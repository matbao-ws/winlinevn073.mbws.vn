@extends('admin.layouts.app')

@section('title', 'Cấu hình Nút liên hệ tư vấn')

@push('styles')
<style>
    .consultant-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 16px;
        transition: all 0.2s ease;
        position: relative;
    }
    .consultant-card:hover {
        border-color: #004e7d;
        box-shadow: 0 4px 16px rgba(0, 78, 125, 0.08);
    }
    .consultant-avatar-preview {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #004e7d;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .preview-box-container {
        position: sticky;
        top: 90px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }
    /* Simulated Mobile/PC Widget Popup in Admin */
    .sim-popup {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 40, 80, 0.12);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-top: 14px;
    }
    .sim-header {
        background: #ffffff;
        color: #0f172a;
        padding: 13px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #edf2f7;
    }
    .sim-header .sim-brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .sim-header img.sim-logo {
        height: 26px;
        object-fit: contain;
    }
    .sim-header .sim-brand-title {
        font-size: 13.5px;
        font-weight: 700;
        letter-spacing: 0.3px;
        color: #005b8e;
        line-height: 1.2;
    }
    .sim-header .sim-brand-sub {
        font-size: 11px;
        color: #64748b;
    }
    .sim-body {
        padding: 6px 12px;
        max-height: 380px;
        overflow-y: auto;
    }
    .sim-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 6px;
        border-bottom: 1px solid #f1f5f9;
        gap: 10px;
    }
    .sim-item:last-child {
        border-bottom: none;
    }
    .sim-item-info {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 0;
    }
    .sim-item-avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }
    .sim-item-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 1.5px solid #e2e8f0;
    }
    .sim-online-dot {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 9px;
        height: 9px;
        background: #10b981;
        border-radius: 50%;
        border: 1.5px solid #ffffff;
    }
    .sim-item-meta {
        overflow: hidden;
    }
    .sim-item-name {
        font-size: 13.5px;
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sim-item-role {
        font-size: 11.5px;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sim-item-phone {
        font-size: 11px;
        color: #0284c7;
        font-weight: 500;
        margin-top: 1px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .sim-item-actions {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
    }
    .sim-icon-box {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .sim-box-zalo {
        background: #f0f7ff;
        color: #0068ff;
        border: 1px solid #dbeafe;
    }
    .sim-box-call {
        background: #fff7ed;
        color: #ea580c;
        border: 1px solid #fed7aa;
    }
    .sim-footer {
        background: #f8fafc;
        border-top: 1px solid #edf2f7;
        padding: 8px 14px;
        font-size: 11.5px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    /* Floating launcher simulation */
    .sim-launcher {
        display: flex;
        align-items: center;
        margin-top: 16px;
        justify-content: flex-end;
    }
    .sim-launcher-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0284c7 0%, #005b8e 100%);
        color: #ffffff;
        border: 2px solid #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        position: relative;
    }
    .sim-launcher-btn .sim-launcher-bubble {
        font-size: 18px;
        line-height: 1;
        margin-bottom: 2px;
    }
    .sim-launcher-btn .sim-launcher-label {
        font-size: 9px;
        font-weight: 700;
        line-height: 1;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }
</style>
@endpush

@section('content')
<!-- Header Card -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-none position-relative overflow-hidden mb-4" style="background: linear-gradient(90deg, #10203C 0%, #004e7d 100%) !important;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4 class="fw-semibold mb-1 text-white">Cấu hình Nút liên hệ tư vấn</h4>
                        <nav class="py-0" style="--bs-breadcrumb-divider: '>'; --bs-breadcrumb-divider-color: rgba(255, 255, 255, 0.6);" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('admin.dashboard') }}">{{ __('admin.home') }}</a></li>
                                <li class="breadcrumb-item"><a class="text-white-50 text-decoration-none" href="{{ route('admin.settings.index') }}">{{ __('admin.sidebar.settings') }}</a></li>
                                <li class="breadcrumb-item active" style="color: rgba(255, 255, 255, 0.9) !important;" aria-current="page">Nút liên hệ tư vấn</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="ti ti-check fs-5 me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="ti ti-alert-circle me-1"></i> Có lỗi xảy ra:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Contact Widget Configuration Form -->
<form action="{{ route('admin.contact-widget.update', ['locale' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data" id="contactWidgetForm">
    @csrf

    <div class="row">
        <!-- Left: Form inputs -->
        <div class="col-lg-7">
            <!-- Card 1: General Settings -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary-subtle p-2 rounded text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <iconify-icon icon="solar:widget-2-line-duotone" class="fs-5"></iconify-icon>
                        </div>
                        <h5 class="fw-semibold text-dark mb-0">Cài đặt chung Nút liên hệ</h5>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="enabled" value="1" id="widget_enabled" 
                            @checked(old('enabled', data_get($widgetSettings, 'enabled', true)))>
                        <label class="form-check-label fw-bold text-primary" for="widget_enabled">Bật widget</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold text-dark" for="brand_name">Tên thương hiệu Header</label>
                            <input type="text" class="form-control text-dark live-sync" id="brand_name" name="brand_name" 
                                value="{{ old('brand_name', data_get($widgetSettings, 'brand_name', 'WINLINE VIỆT NAM')) }}" 
                                placeholder="WINLINE VIỆT NAM" required>
                            <small class="text-muted">Hiển thị ở dòng đầu của bảng liên hệ</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark" for="position">Vị trí hiển thị</label>
                            <select class="form-select text-dark live-sync" id="position" name="position">
                                <option value="bottom_right" @selected(old('position', data_get($widgetSettings, 'position')) === 'bottom_right')>Góc dưới bên phải</option>
                                <option value="bottom_left" @selected(old('position', data_get($widgetSettings, 'position')) === 'bottom_left')>Góc dưới bên trái</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark" for="subtitle">Phụ đề / Tiêu đề phụ</label>
                            <input type="text" class="form-control text-dark live-sync" id="subtitle" name="subtitle" 
                                value="{{ old('subtitle', data_get($widgetSettings, 'subtitle', 'Đội ngũ chuyên viên tư vấn')) }}" 
                                placeholder="Đội ngũ chuyên viên tư vấn">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark" for="badge_text">Nhãn nút nổi</label>
                            <input type="text" class="form-control text-dark live-sync" id="badge_text" name="badge_text" 
                                value="{{ old('badge_text', data_get($widgetSettings, 'badge_text', 'Tư vấn ngay')) }}" 
                                placeholder="Tư vấn ngay">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark" for="working_hours">Thông tin giờ làm việc (Footer)</label>
                            <input type="text" class="form-control text-dark live-sync" id="working_hours" name="working_hours" 
                                value="{{ old('working_hours', data_get($widgetSettings, 'working_hours', '8h00 - 17h30 (Thứ 2 đến Thứ 7)')) }}" 
                                placeholder="8h00 - 17h30 (Thứ 2 đến Thứ 7)" required>
                            <small class="text-muted">Thông báo giờ làm việc ở chân bảng popup</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Consultants List -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary-subtle p-2 rounded text-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <iconify-icon icon="solar:users-group-two-rounded-line-duotone" class="fs-5"></iconify-icon>
                        </div>
                        <h5 class="fw-semibold text-dark mb-0">Danh sách Chuyên viên tư vấn</h5>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1" id="btnAddConsultant">
                        <iconify-icon icon="solar:user-plus-rounded-bold" class="fs-5"></iconify-icon> Thêm chuyên viên
                    </button>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Thêm hoặc tùy biến danh sách nhân viên trực tuyến hiển thị khi khách hàng click nút liên hệ. Mỗi nhân viên có ảnh đại diện, số Zalo và số điện thoại gọi trực tiếp.
                    </p>

                    <div id="consultantsContainer">
                        @php
                            $consultants = old('consultants', data_get($widgetSettings, 'consultants', []));
                        @endphp

                        @foreach($consultants as $idx => $consultant)
                        <div class="consultant-card" data-index="{{ $idx }}">
                            <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary-subtle text-primary fw-bold consultant-index-badge">#{{ $loop->iteration }}</span>
                                    <span class="fw-bold text-dark consultant-name-heading">{{ $consultant['name'] ?? 'Chuyên viên mới' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input live-sync" type="checkbox" 
                                            name="consultants[{{ $idx }}][is_active]" value="1" 
                                            id="consultant_active_{{ $idx }}" 
                                            @checked(isset($consultant['is_active']) ? (bool)$consultant['is_active'] : true)>
                                        <label class="form-check-label small" for="consultant_active_{{ $idx }}">Hiển thị</label>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm p-1 px-2 btn-remove-consultant" title="Xóa chuyên viên này">
                                        <iconify-icon icon="solar:trash-bin-trash-line-duotone" class="fs-5"></iconify-icon>
                                    </button>
                                </div>
                            </div>

                            <input type="hidden" name="consultants[{{ $idx }}][id]" value="{{ $consultant['id'] ?? 'c_' . $idx }}">
                            <input type="hidden" name="consultants[{{ $idx }}][avatar]" class="consultant-avatar-hidden" value="{{ $consultant['avatar'] ?? '/client-assets/images/avatars/default_consultant.png' }}">

                            <div class="row g-3">
                                <!-- Avatar preview & upload -->
                                <div class="col-md-3 text-center d-flex flex-column align-items-center justify-content-center">
                                    <img src="{{ asset($consultant['avatar'] ?? '/client-assets/images/avatars/default_consultant.png') }}" 
                                         alt="Avatar" class="consultant-avatar-preview mb-2 preview-img">
                                    <label class="btn btn-outline-secondary btn-sm w-100" style="font-size: 11px;">
                                        Đổi ảnh
                                        <input type="file" name="consultants[{{ $idx }}][avatar_file]" class="d-none consultant-file-input" accept="image/*">
                                    </label>
                                </div>

                                <!-- Info fields -->
                                <div class="col-md-9">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-dark mb-1">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm text-dark input-consultant-name live-sync" 
                                                name="consultants[{{ $idx }}][name]" 
                                                value="{{ $consultant['name'] ?? '' }}" placeholder="VD: Kim Huệ" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-dark mb-1">Chức danh / Vai trò</label>
                                            <input type="text" class="form-control form-control-sm text-dark input-consultant-role live-sync" 
                                                name="consultants[{{ $idx }}][role]" 
                                                value="{{ $consultant['role'] ?? '' }}" placeholder="VD: Bán hàng Winline">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-dark mb-1">Số điện thoại gọi</label>
                                            <input type="text" class="form-control form-control-sm text-dark input-consultant-phone live-sync" 
                                                name="consultants[{{ $idx }}][phone]" 
                                                value="{{ $consultant['phone'] ?? '' }}" placeholder="VD: 0949761893">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold text-dark mb-1">Số Zalo</label>
                                            <input type="text" class="form-control form-control-sm text-dark input-consultant-zalo live-sync" 
                                                name="consultants[{{ $idx }}][zalo]" 
                                                value="{{ $consultant['zalo'] ?? '' }}" placeholder="VD: 0949761893">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submit button container -->
            <div class="d-flex align-items-center justify-content-end gap-2 mb-5">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold d-flex align-items-center gap-2">
                    <iconify-icon icon="solar:diskette-bold" class="fs-5"></iconify-icon> Lưu cấu hình
                </button>
            </div>
        </div>

        <!-- Right: Live Preview -->
        <div class="col-lg-5">
            <div class="preview-box-container">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <iconify-icon icon="solar:eye-line-duotone" class="text-primary fs-5"></iconify-icon>
                        Xem trước trực tiếp (Live Preview)
                    </h5>
                    <span class="badge bg-success-subtle text-success fw-semibold">Thời gian thực</span>
                </div>
                <p class="text-muted small mb-3">Mô phỏng hiển thị trên website khi người dùng nhấp vào nút liên hệ.</p>

                <!-- Popup simulation -->
                <div class="sim-popup" id="simPopup">
                    <div class="sim-header">
                        <div class="sim-brand">
                            <img src="{{ asset('client-assets/images/logo.png') }}" alt="Logo" class="sim-logo" onerror="this.style.display='none'">
                            <div>
                                <div class="sim-brand-title" id="simBrandTitle">{{ data_get($widgetSettings, 'brand_name', 'WINLINE VIỆT NAM') }}</div>
                                <div class="sim-brand-sub" id="simSubtitle">{{ data_get($widgetSettings, 'subtitle', 'Đội ngũ chuyên viên tư vấn') }}</div>
                            </div>
                        </div>
                        <span class="text-secondary fs-5" style="cursor: pointer;">&times;</span>
                    </div>

                    <div class="sim-body" id="simConsultantsList">
                        <!-- Rendered dynamically by JavaScript -->
                    </div>

                    <div class="sim-footer">
                        <iconify-icon icon="solar:clock-circle-line-duotone" class="text-primary fs-5"></iconify-icon>
                        <span id="simWorkingHours">{{ data_get($widgetSettings, 'working_hours', '8h00 - 17h30 (Thứ 2 đến Thứ 7)') }}</span>
                    </div>
                </div>

                <!-- Floating button launcher simulation -->
                <div class="sim-launcher" id="simLauncher">
                    <div class="sim-launcher-btn">
                        <iconify-icon icon="solar:chat-round-dots-bold" class="sim-launcher-bubble"></iconify-icon>
                        <span class="sim-launcher-label" id="simBadgeText">{{ data_get($widgetSettings, 'badge_text', 'Liên hệ') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Template for new consultant item (hidden) -->
<template id="consultantTemplate">
    <div class="consultant-card" data-index="__INDEX__">
        <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary-subtle text-primary fw-bold consultant-index-badge">#__NUM__</span>
                <span class="fw-bold text-dark consultant-name-heading">Chuyên viên mới</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input live-sync" type="checkbox" 
                        name="consultants[__INDEX__][is_active]" value="1" 
                        id="consultant_active___INDEX__" checked>
                    <label class="form-check-label small" for="consultant_active___INDEX__">Hiển thị</label>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm p-1 px-2 btn-remove-consultant" title="Xóa chuyên viên này">
                    <iconify-icon icon="solar:trash-bin-trash-line-duotone" class="fs-5"></iconify-icon>
                </button>
            </div>
        </div>

        <input type="hidden" name="consultants[__INDEX__][id]" value="consultant___INDEX___new">
        <input type="hidden" name="consultants[__INDEX__][avatar]" class="consultant-avatar-hidden" value="/client-assets/images/avatars/default_consultant.png">

        <div class="row g-3">
            <div class="col-md-3 text-center d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('client-assets/images/avatars/default_consultant.png') }}" 
                     alt="Avatar" class="consultant-avatar-preview mb-2 preview-img">
                <label class="btn btn-outline-secondary btn-sm w-100" style="font-size: 11px;">
                    Đổi ảnh
                    <input type="file" name="consultants[__INDEX__][avatar_file]" class="d-none consultant-file-input" accept="image/*">
                </label>
            </div>

            <div class="col-md-9">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-dark mb-1">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm text-dark input-consultant-name live-sync" 
                            name="consultants[__INDEX__][name]" 
                            value="" placeholder="VD: Kim Huệ" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-dark mb-1">Chức danh / Vai trò</label>
                        <input type="text" class="form-control form-control-sm text-dark input-consultant-role live-sync" 
                            name="consultants[__INDEX__][role]" 
                            value="Bán hàng Winline" placeholder="VD: Bán hàng Winline">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-dark mb-1">Số điện thoại gọi</label>
                        <input type="text" class="form-control form-control-sm text-dark input-consultant-phone live-sync" 
                            name="consultants[__INDEX__][phone]" 
                            value="" placeholder="VD: 0949761893">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-dark mb-1">Số Zalo</label>
                        <input type="text" class="form-control form-control-sm text-dark input-consultant-zalo live-sync" 
                            name="consultants[__INDEX__][zalo]" 
                            value="" placeholder="VD: 0949761893">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('consultantsContainer');
    const btnAdd = document.getElementById('btnAddConsultant');
    const template = document.getElementById('consultantTemplate').innerHTML;

    // Real-time elements
    const simBrandTitle = document.getElementById('simBrandTitle');
    const simSubtitle = document.getElementById('simSubtitle');
    const simWorkingHours = document.getElementById('simWorkingHours');
    const simBadgeText = document.getElementById('simBadgeText');
    const simConsultantsList = document.getElementById('simConsultantsList');

    function updateLivePreview() {
        const brandInput = document.getElementById('brand_name');
        const subInput = document.getElementById('subtitle');
        const hoursInput = document.getElementById('working_hours');
        const badgeInput = document.getElementById('badge_text');

        if (simBrandTitle && brandInput) simBrandTitle.textContent = brandInput.value || 'WINLINE VIỆT NAM';
        if (simSubtitle && subInput) simSubtitle.textContent = subInput.value || 'Đội ngũ chuyên viên tư vấn';
        if (simWorkingHours && hoursInput) simWorkingHours.textContent = hoursInput.value || '8h00 - 17h30 (Thứ 2 đến Thứ 7)';
        if (simBadgeText && badgeInput) simBadgeText.textContent = badgeInput.value || 'Tư vấn ngay';

        // Re-render consultants
        const cards = container.querySelectorAll('.consultant-card');
        simConsultantsList.innerHTML = '';

        cards.forEach((card, i) => {
            const nameInput = card.querySelector('.input-consultant-name');
            const roleInput = card.querySelector('.input-consultant-role');
            const phoneInput = card.querySelector('.input-consultant-phone');
            const zaloInput = card.querySelector('.input-consultant-zalo');
            const previewImg = card.querySelector('.preview-img');
            const activeCheckbox = card.querySelector('.form-check-input');
            const nameHeading = card.querySelector('.consultant-name-heading');

            const name = nameInput ? nameInput.value.trim() : '';
            const role = roleInput ? roleInput.value.trim() : '';
            const phone = phoneInput ? phoneInput.value.trim() : '';
            const zalo = zaloInput ? zaloInput.value.trim() : '';
            const imgSrc = previewImg ? previewImg.src : '/client-assets/images/avatars/default_consultant.png';
            const isActive = activeCheckbox ? activeCheckbox.checked : true;

            if (nameHeading) {
                nameHeading.textContent = name || 'Chuyên viên #' + (i + 1);
            }

            if (!isActive) return; // Do not show inactive consultants in preview

            const itemEl = document.createElement('div');
            itemEl.className = 'sim-item';
            itemEl.innerHTML = `
                <div class="sim-item-info">
                    <div class="sim-item-avatar-wrap">
                        <img src="${imgSrc}" class="sim-item-avatar" alt="${name}">
                        <span class="sim-online-dot"></span>
                    </div>
                    <div class="sim-item-meta">
                        <div class="sim-item-name">${name || 'Chuyên viên ' + (i+1)}</div>
                        <div class="sim-item-role">${role || 'Bán hàng Winline'}</div>
                        ${phone ? `<div class="sim-item-phone"><iconify-icon icon="solar:phone-bold" style="font-size:10px;"></iconify-icon> ${phone}</div>` : ''}
                    </div>
                </div>
                <div class="sim-item-actions">
                    <span class="sim-icon-box sim-box-zalo" title="Chat Zalo"><iconify-icon icon="solar:chat-round-dots-bold"></iconify-icon></span>
                    <span class="sim-icon-box sim-box-call" title="Gọi điện"><iconify-icon icon="solar:phone-calling-bold"></iconify-icon></span>
                </div>
            `;
            simConsultantsList.appendChild(itemEl);
        });

        if (simConsultantsList.children.length === 0) {
            simConsultantsList.innerHTML = '<div class="text-center text-muted py-4 small">Chưa có chuyên viên nào được kích hoạt hiển thị.</div>';
        }
    }

    // Attach listeners to live-sync
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('live-sync') || e.target.classList.contains('form-control')) {
            updateLivePreview();
        }
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('live-sync') || e.target.classList.contains('form-check-input')) {
            updateLivePreview();
        }
    });

    // File input handler for image preview
    container.addEventListener('change', function (e) {
        if (e.target.classList.contains('consultant-file-input')) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                const card = e.target.closest('.consultant-card');
                const img = card.querySelector('.preview-img');
                reader.onload = function(evt) {
                    if (img) img.src = evt.target.result;
                    updateLivePreview();
                };
                reader.readAsDataURL(file);
            }
        }
    });

    // Remove consultant
    container.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-remove-consultant');
        if (btn) {
            const card = btn.closest('.consultant-card');
            if (container.querySelectorAll('.consultant-card').length <= 1) {
                alert('Phải giữ lại ít nhất 1 chuyên viên tư vấn.');
                return;
            }
            if (confirm('Bạn có chắc chắn muốn xóa chuyên viên này?')) {
                card.remove();
                reindexCards();
                updateLivePreview();
            }
        }
    });

    // Add new consultant
    btnAdd.addEventListener('click', function () {
        const index = new Date().getTime();
        const num = container.querySelectorAll('.consultant-card').length + 1;
        const html = template.replace(/__INDEX__/g, index).replace(/__NUM__/g, num);
        const div = document.createElement('div');
        div.innerHTML = html;
        container.appendChild(div.firstElementChild);
        reindexCards();
        updateLivePreview();
    });

    function reindexCards() {
        const cards = container.querySelectorAll('.consultant-card');
        cards.forEach((card, idx) => {
            const badge = card.querySelector('.consultant-index-badge');
            if (badge) badge.textContent = '#' + (idx + 1);
        });
    }

    // Initial render
    updateLivePreview();
});
</script>
@endpush
