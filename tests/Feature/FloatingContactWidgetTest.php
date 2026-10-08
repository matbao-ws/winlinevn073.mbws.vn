<?php

namespace Tests\Feature;

use App\Models\ProjectSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FloatingContactWidgetTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $guestUser;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::query()->create([
            'name' => 'Admin',
            'permissions' => ['settings.view', 'settings.update'],
        ]);

        $guestRole = Role::query()->create([
            'name' => 'Guest',
            'permissions' => [],
        ]);

        $this->adminUser = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $this->guestUser = User::factory()->create([
            'role_id' => $guestRole->id,
        ]);
    }

    public function test_guests_cannot_access_contact_widget_settings(): void
    {
        $response = $this->get(route('admin.contact-widget.index', ['locale' => 'vi']));
        $response->assertRedirect();
    }

    public function test_unauthorized_users_cannot_access_contact_widget_settings(): void
    {
        $response = $this->actingAs($this->guestUser)->get(route('admin.contact-widget.index', ['locale' => 'vi']));
        $response->assertStatus(403);
    }

    public function test_admin_can_view_contact_widget_settings_page(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.contact-widget.index', ['locale' => 'vi']));
        $response->assertOk();
        $response->assertSee('Cấu hình Nút liên hệ tư vấn');
        $response->assertSee('WINLINE VIỆT NAM');
        $response->assertSee('Kim Huệ');
        $response->assertSee('Phương Thảo');
        $response->assertSee('Ngọc Yến');
    }

    public function test_admin_can_update_contact_widget_settings(): void
    {
        $payload = [
            'enabled' => '1',
            'brand_name' => 'WINLINE TEST BRAND',
            'subtitle' => 'Chuyên viên kỹ thuật',
            'working_hours' => '7h30 - 18h00 (T2 - T7)',
            'position' => 'bottom_left',
            'badge_text' => 'Gọi ngay',
            'consultants' => [
                [
                    'name' => 'Lê Quyết Thắng',
                    'role' => 'Trưởng phòng kinh doanh',
                    'phone' => '0988.123.456',
                    'zalo' => '0988123456',
                    'is_active' => '1',
                ],
                [
                    'name' => 'Kim Huệ',
                    'role' => 'Bán hàng Winline',
                    'phone' => '0949761893',
                    'zalo' => '0949761893',
                    'is_active' => '1',
                ],
            ],
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.contact-widget.update', ['locale' => 'vi']), $payload);

        $response->assertRedirect(route('admin.contact-widget.index', ['locale' => 'vi']));
        $response->assertSessionHas('success');

        $setting = ProjectSetting::query()->where('setting_key', 'floating_contact_widget')->first();
        $this->assertNotNull($setting);
        $val = $setting->setting_value;

        $this->assertTrue($val['enabled']);
        $this->assertSame('WINLINE TEST BRAND', $val['brand_name']);
        $this->assertSame('Chuyên viên kỹ thuật', $val['subtitle']);
        $this->assertSame('7h30 - 18h00 (T2 - T7)', $val['working_hours']);
        $this->assertSame('bottom_left', $val['position']);
        $this->assertSame('Gọi ngay', $val['badge_text']);
        $this->assertCount(2, $val['consultants']);
        $this->assertSame('Lê Quyết Thắng', $val['consultants'][0]['name']);
        $this->assertSame('Trưởng phòng kinh doanh', $val['consultants'][0]['role']);
    }

    public function test_storefront_renders_contact_widget_when_enabled(): void
    {
        ProjectSetting::updateOrCreate(
            ['setting_key' => 'floating_contact_widget'],
            [
                'setting_value' => [
                    'enabled' => true,
                    'brand_name' => 'WINLINE VIỆT NAM',
                    'subtitle' => 'Đội ngũ chuyên viên tư vấn',
                    'working_hours' => '8h00 - 17h30 (Thứ 2 đến Thứ 7)',
                    'position' => 'bottom_right',
                    'badge_text' => 'Liên hệ',
                    'consultants' => [
                        [
                            'name' => 'Kim Huệ',
                            'role' => 'Bán hàng Winline',
                            'phone' => '0949.761.893',
                            'zalo' => '0949761893',
                            'avatar' => '/client-assets/images/avatars/kim_hue.png',
                            'is_active' => true,
                        ],
                        [
                            'name' => 'Phương Thảo',
                            'role' => 'Bán hàng doanh nghiệp',
                            'phone' => '0963.230.665',
                            'zalo' => '0963230665',
                            'avatar' => '/client-assets/images/avatars/phuong_thao.png',
                            'is_active' => true,
                        ],
                    ],
                ],
                'updated_at' => now(),
            ]
        );

        $response = $this->get('/vi');
        $response->assertOk();
        $response->assertSee('floatingContactWidget');
        $response->assertSee('Liên hệ');
        $response->assertSee('WINLINE VIỆT NAM');
        $response->assertSee('Kim Huệ');
        $response->assertSee('Bán hàng Winline');
        $response->assertSee('Phương Thảo');
        $response->assertSee('Bán hàng doanh nghiệp');
        $response->assertSee('zalo.me/0949761893');
        $response->assertSee('tel:0949761893');
    }

    public function test_storefront_does_not_render_widget_when_disabled(): void
    {
        ProjectSetting::updateOrCreate(
            ['setting_key' => 'floating_contact_widget'],
            [
                'setting_value' => [
                    'enabled' => false,
                    'brand_name' => 'WINLINE VIỆT NAM',
                ],
                'updated_at' => now(),
            ]
        );

        $response = $this->get('/vi');
        $response->assertOk();
        $response->assertDontSee('id="floatingContactWidget"', false);
    }
}
