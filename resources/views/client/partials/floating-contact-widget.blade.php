@php
    $rawWidgetSetting = \App\Models\ProjectSetting::query()->where('setting_key', 'floating_contact_widget')->first()?->setting_value;
    $defaults = \App\Http\Controllers\Admin\ContactWidgetController::getDefaultSettings();
    $widget = is_array($rawWidgetSetting) ? array_merge($defaults, $rawWidgetSetting) : $defaults;
    if (!empty($rawWidgetSetting['consultants']) && is_array($rawWidgetSetting['consultants'])) {
        $widget['consultants'] = $rawWidgetSetting['consultants'];
    }
    $isEnabled = (bool)($widget['enabled'] ?? true);
    $position = ($widget['position'] ?? 'bottom_right') === 'bottom_left' ? 'pos-left' : 'pos-right';
    $consultants = collect($widget['consultants'] ?? [])->filter(fn($c) => !isset($c['is_active']) || $c['is_active']);
@endphp

@if($isEnabled)
<div id="floatingContactWidget" class="floating-contact-widget {{ $position }}">
    {{-- Backdrop for mobile --}}
    <div class="fcw-backdrop" id="fcwBackdrop" onclick="toggleContactWidget(false)"></div>

    {{-- Bảng nhỏ mở rộng khi click nút liên hệ --}}
    <div class="fcw-card" id="fcwCard" role="dialog" aria-modal="true" aria-label="Bảng liên hệ tư vấn Winline">
        {{-- Header: Logo + WINLINE VIỆT NAM + Close Button --}}
        <div class="fcw-card-header">
            <div class="fcw-header-brand">
                <img src="{{ asset('client-assets/images/logo.png') }}" alt="Winline" class="fcw-header-logo" onerror="this.style.display='none'">
                <div class="fcw-header-text">
                    <div class="fcw-brand-title">{{ $widget['brand_name'] ?? 'WINLINE VIỆT NAM' }}</div>
                    <div class="fcw-brand-sub">{{ $widget['subtitle'] ?? 'Đội ngũ chuyên viên tư vấn' }}</div>
                </div>
            </div>
            <button type="button" class="fcw-btn-close" onclick="toggleContactWidget(false)" aria-label="Đóng bảng liên hệ">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Body: Danh sách chuyên viên tư vấn --}}
        <div class="fcw-card-body">
            @forelse($consultants as $consultant)
                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $consultant['phone'] ?? '');
                    $cleanZalo = preg_replace('/[^0-9]/', '', $consultant['zalo'] ?? $cleanPhone);
                    $avatar = !empty($consultant['avatar']) ? $consultant['avatar'] : '/client-assets/images/avatars/default_consultant.png';
                @endphp
                <div class="fcw-consultant-item">
                    <div class="fcw-avatar-wrap">
                        <img src="{{ asset($avatar) }}" alt="{{ $consultant['name'] ?? 'Chuyên viên tư vấn' }}" class="fcw-avatar" loading="lazy">
                        <span class="fcw-online-dot" title="Đang trực tuyến"></span>
                    </div>
                    <div class="fcw-info">
                        <div class="fcw-name">{{ $consultant['name'] ?? 'Chuyên viên tư vấn' }}</div>
                        <div class="fcw-role">{{ $consultant['role'] ?? 'Bán hàng Winline' }}</div>
                        @if(!empty($consultant['phone']))
                        <div class="fcw-phone"><i class="fas fa-phone-alt"></i> {{ $consultant['phone'] }}</div>
                        @endif
                    </div>
                    <div class="fcw-actions">
                        @if($cleanZalo)
                        <a href="https://zalo.me/{{ $cleanZalo }}" target="_blank" rel="noopener noreferrer" class="fcw-action-icon fcw-action-zalo" title="Chat Zalo với {{ $consultant['name'] }}" aria-label="Chat Zalo">
                            <i class="fas fa-comment-dots"></i>
                        </a>
                        @endif
                        @if($cleanPhone)
                        <a href="tel:{{ $cleanPhone }}" class="fcw-action-icon fcw-action-call" title="Gọi điện cho {{ $consultant['name'] }}" aria-label="Gọi điện">
                            <i class="fas fa-phone-alt"></i>
                        </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="fcw-empty-state">
                    <p>Hiện không có chuyên viên trực tuyến. Quý khách vui lòng gọi Hotline: <a href="tel:0949761893">0949.761.893</a></p>
                </div>
            @endforelse
        </div>

        {{-- Footer: Thông tin giờ làm việc --}}
        <div class="fcw-card-footer">
            <i class="far fa-clock"></i>
            <span>{{ $widget['working_hours'] ?? '8h00 - 17h30 (Thứ 2 đến Thứ 7)' }}</span>
        </div>
    </div>

    {{-- Nút tròn liên hệ nổi góc màn hình (thiết kế tĩnh, thanh lịch, không nhấp nháy) --}}
    <div class="fcw-launcher-wrap">
        <button type="button" class="fcw-launcher-btn" id="fcwLauncherBtn" onclick="toggleContactWidget()" aria-label="Mở bảng hỗ trợ tư vấn">
            <span class="fcw-icon-open">
                <i class="fas fa-comment-dots fcw-launcher-bubble"></i>
                <span class="fcw-launcher-label">{{ !empty($widget['badge_text']) ? $widget['badge_text'] : 'Liên hệ' }}</span>
            </span>
            <span class="fcw-icon-close">
                <i class="fas fa-times"></i>
            </span>
        </button>
    </div>
</div>
@endif
