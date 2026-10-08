<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectSetting;
use App\Services\ActivityLogger;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactWidgetController extends Controller
{
    public function __construct(
        protected CloudinaryService $cloudinaryService
    ) {}

    /**
     * Default settings for Floating Contact Widget
     */
    public static function getDefaultSettings(): array
    {
        return [
            'enabled' => true,
            'brand_name' => 'WINLINE VIỆT NAM',
            'subtitle' => 'Đội ngũ chuyên viên tư vấn',
            'working_hours' => '8h00 - 17h30 (Thứ 2 đến Thứ 7)',
            'position' => 'bottom_right',
            'badge_text' => 'Liên hệ',
            'consultants' => [
                [
                    'id' => 'consultant_1',
                    'name' => 'Kim Huệ',
                    'role' => 'Bán hàng Winline',
                    'phone' => '0949.761.893',
                    'zalo' => '0949761893',
                    'avatar' => '/client-assets/images/avatars/kim_hue.png',
                    'is_active' => true,
                ],
                [
                    'id' => 'consultant_2',
                    'name' => 'Phương Thảo',
                    'role' => 'Bán hàng doanh nghiệp',
                    'phone' => '0963.230.665',
                    'zalo' => '0963230665',
                    'avatar' => '/client-assets/images/avatars/phuong_thao.png',
                    'is_active' => true,
                ],
                [
                    'id' => 'consultant_3',
                    'name' => 'Ngọc Yến',
                    'role' => 'Bán hàng Winline',
                    'phone' => '0981.805.488',
                    'zalo' => '0981805488',
                    'avatar' => '/client-assets/images/avatars/ngoc_yen.png',
                    'is_active' => true,
                ],
            ],
        ];
    }

    /**
     * Display contact widget settings page
     */
    public function index(): View
    {
        $settingRecord = ProjectSetting::query()->where('setting_key', 'floating_contact_widget')->first();
        $storedSettings = $settingRecord?->setting_value;

        $defaults = self::getDefaultSettings();

        if (is_array($storedSettings)) {
            $widgetSettings = array_merge($defaults, $storedSettings);
            // If consultants exist, ensure array structure is maintained
            if (!empty($storedSettings['consultants']) && is_array($storedSettings['consultants'])) {
                $widgetSettings['consultants'] = $storedSettings['consultants'];
            }
        } else {
            $widgetSettings = $defaults;
        }

        return view('admin.contact_widget.index', compact('widgetSettings'));
    }

    /**
     * Update contact widget settings
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'working_hours' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'in:bottom_right,bottom_left'],
            'badge_text' => ['nullable', 'string', 'max:100'],
            'consultants' => ['nullable', 'array'],
            'consultants.*.name' => ['required_with:consultants', 'string', 'max:255'],
            'consultants.*.role' => ['nullable', 'string', 'max:255'],
            'consultants.*.phone' => ['nullable', 'string', 'max:50'],
            'consultants.*.zalo' => ['nullable', 'string', 'max:50'],
            'consultants.*.avatar' => ['nullable', 'string', 'max:500'],
            'consultants.*.is_active' => ['nullable'],
        ]);

        $rawConsultants = $request->input('consultants', []);
        $processedConsultants = [];

        if (is_array($rawConsultants)) {
            foreach ($rawConsultants as $index => $item) {
                if (empty($item['name']) && empty($item['phone'])) {
                    continue;
                }

                $avatarUrl = $item['avatar'] ?? '/client-assets/images/avatars/default_consultant.png';

                // Check if a new avatar file was uploaded for this consultant
                if ($request->hasFile("consultants.{$index}.avatar_file")) {
                    $file = $request->file("consultants.{$index}.avatar_file");
                    $uploadedUrl = $this->cloudinaryService->uploadFile($file, 'avatars');
                    if ($uploadedUrl) {
                        $avatarUrl = $uploadedUrl;
                    }
                }

                $isActive = isset($item['is_active']) && ($item['is_active'] == '1' || $item['is_active'] === true);

                $processedConsultants[] = [
                    'id' => $item['id'] ?? 'consultant_' . ($index + 1) . '_' . time(),
                    'name' => trim($item['name'] ?? ''),
                    'role' => trim($item['role'] ?? 'Tư vấn bán hàng'),
                    'phone' => trim($item['phone'] ?? ''),
                    'zalo' => trim($item['zalo'] ?? ''),
                    'avatar' => $avatarUrl,
                    'is_active' => $isActive,
                ];
            }
        }

        $payload = [
            'enabled' => $request->boolean('enabled'),
            'brand_name' => $validated['brand_name'] ?? 'WINLINE VIỆT NAM',
            'subtitle' => $validated['subtitle'] ?? 'Đội ngũ chuyên viên tư vấn',
            'working_hours' => $validated['working_hours'] ?? '8h00 - 17h30 (Thứ 2 đến Thứ 7)',
            'position' => $validated['position'] ?? 'bottom_right',
            'badge_text' => $validated['badge_text'] ?? 'Liên hệ',
            'consultants' => $processedConsultants,
        ];

        ProjectSetting::updateOrCreate(
            ['setting_key' => 'floating_contact_widget'],
            [
                'setting_value' => $payload,
                'updated_at' => now(),
            ]
        );

        ActivityLogger::log('updated', null, 'Cập nhật cấu hình nút liên hệ tư vấn', [
            'new' => [
                'enabled' => $payload['enabled'],
                'consultants_count' => count($processedConsultants),
            ],
        ]);

        return redirect()
            ->route('admin.contact-widget.index')
            ->with('success', 'Đã lưu cấu hình nút liên hệ tư vấn thành công!');
    }
}
