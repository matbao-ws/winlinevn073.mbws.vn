<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(string $locale): View
    {
        return view('client.pages.contact');
    }

    public function store(Request $request, string $locale): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:2000',
            'subject' => 'nullable|string|max:255',
        ]);

        $submission = ContactSubmission::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'message' => $validated['message'] ?? ($validated['subject'] ?? 'Yêu cầu tư vấn / báo giá từ website'),
            'meta' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'subject' => $validated['subject'] ?? null,
                'url' => $request->headers->get('referer'),
            ],
            'is_read' => false,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn quý khách! Winline sẽ liên hệ lại trong vòng 15 phút.',
                'id' => $submission->id,
            ]);
        }

        return back()->with('success', 'Cảm ơn quý khách! Yêu cầu của bạn đã được gửi thành công. Chuyên viên Winline sẽ liên hệ lại trong ít phút.');
    }
}
