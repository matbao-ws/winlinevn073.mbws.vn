@extends('client.layouts.app')

@section('title', 'Công cụ tính chọn quạt thông gió & làm mát | Winline.vn')

@push('styles')
<style>
  :root {
    --primary: #00354f;
    --primary-light: #004e7d;
    --accent: #d41e3d;
    --navy-950: #002233;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-500: #64748b;
    --gray-700: #334155;
    --green: #16a34a;
    --green-bg: #dcfce7;
    --yellow: #ca8a04;
    --yellow-bg: #fef9c3;
  }

  /* Hero Section */
  .calc-hero {
    background: linear-gradient(135deg, #00354f 0%, #004e7d 100%);
    color: #ffffff;
    padding: 36px 0 28px;
    margin-bottom: 24px;
  }
  .calc-hero .badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11.5px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #fbd38d;
    font-weight: 700;
    margin-bottom: 10px;
    background: rgba(255,255,255,0.1);
    padding: 4px 12px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.15);
  }
  .calc-hero h1 {
    font-size: 26px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 8px;
  }
  .calc-hero p {
    color: #cbd5e1;
    font-size: 14px;
    max-width: 780px;
    margin: 0;
    line-height: 1.5;
  }

  .calc-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 16px 60px;
  }

  /* Tabs */
  .calc-tabs {
    display: flex;
    gap: 6px;
    margin-bottom: 24px;
    border-bottom: 2px solid #e2e8f0;
    overflow-x: auto;
  }
  .tab-btn {
    font-weight: 700;
    font-size: 13.5px;
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    border: 1px solid #e2e8f0;
    border-bottom: none;
    background: #f1f5f9;
    color: #64748b;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: all 0.2s;
  }
  .tab-btn.active {
    background: #ffffff;
    color: #00354f;
    border-color: #00354f;
    border-top: 3px solid #00354f;
  }
  .tab-btn:hover:not(.active) {
    background: #e2e8f0;
    color: #00354f;
  }

  /* Main Grid */
  .calc-grid {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 24px;
    align-items: start;
    margin-bottom: 28px;
  }
  @media (max-width: 960px) {
    .calc-grid {
      grid-template-columns: 1fr;
    }
  }

  .calc-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 22px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
  }
  .calc-card-title {
    font-size: 15px;
    font-weight: 800;
    color: #00354f;
    text-transform: uppercase;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .calc-card-title .step-n {
    width: 24px;
    height: 24px;
    background: #00354f;
    color: #ffffff;
    font-size: 12px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  /* Inputs */
  .form-group {
    margin-bottom: 14px;
  }
  .form-label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 5px;
  }
  .form-input {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid #cbd5e1;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    background: #f8fafc;
    box-sizing: border-box;
    transition: all 0.15s;
  }
  .form-input:focus {
    outline: none;
    border-color: #00354f;
    background: #ffffff;
  }

  /* Preset chips */
  .preset-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 6px;
    margin-bottom: 10px;
  }
  .preset-chip {
    font-size: 11.5px;
    padding: 5px 10px;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    color: #475569;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.15s;
  }
  .preset-chip:hover {
    background: #e2e8f0;
    color: #00354f;
  }
  .preset-chip.active {
    background: #00354f;
    color: #ffffff;
    border-color: #00354f;
  }

  /* Voltage Radios */
  .voltage-group {
    display: flex;
    gap: 8px;
    margin-top: 4px;
  }
  .voltage-btn {
    flex: 1;
    text-align: center;
    padding: 8px 6px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    background: #f8fafc;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s;
  }
  .voltage-btn.active {
    background: #00354f;
    color: #ffffff;
    border-color: #00354f;
  }

  /* Results Dashboard Metrics */
  .metric-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 20px;
  }
  .metric-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px;
  }
  .metric-box.highlight {
    background: #eff6ff;
    border-color: #bfdbfe;
  }
  .metric-box.cooling {
    background: #ecfdf5;
    border-color: #a7f3d0;
  }
  .metric-lbl {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 4px;
  }
  .metric-val {
    font-size: 20px;
    font-weight: 800;
    color: #00354f;
    line-height: 1.2;
  }
  .metric-val small {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
  }

  /* Horizontal Filter Bar: Exactly 4 criteria */
  .filter-bar {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 18px;
    margin-bottom: 18px;
    display: grid;
    grid-template-columns: repeat(4, 1fr) auto;
    gap: 12px;
    align-items: flex-end;
  }
  @media (max-width: 900px) {
    .filter-bar {
      grid-template-columns: 1fr 1fr;
    }
  }
  @media (max-width: 600px) {
    .filter-bar {
      grid-template-columns: 1fr;
    }
  }
  .filter-col label {
    display: block;
    font-size: 11.5px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 4px;
    text-transform: uppercase;
  }
  .filter-select {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 13px;
    background: #ffffff;
    color: #334155;
    outline: none;
  }
  .filter-reset-btn {
    padding: 8px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    background: #ffffff;
    color: #64748b;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    height: 36px;
  }
  .filter-reset-btn:hover {
    background: #f1f5f9;
    color: #00354f;
  }

  /* Table: 10 columns */
  .table-responsive {
    overflow-x: auto;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: #ffffff;
    margin-bottom: 20px;
  }
  .calc-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }
  .calc-table th {
    background: #f1f5f9;
    color: #334155;
    font-weight: 700;
    padding: 10px 12px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
    font-size: 12px;
  }
  .calc-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
  }
  .calc-table tbody tr {
    transition: background 0.15s;
  }
  .calc-table tbody tr:hover {
    background-color: #f8fafc;
  }
  .calc-table tbody tr.is-selected {
    background-color: #f0fdf4;
  }

  .fan-thumb {
    width: 44px;
    height: 44px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #e2e8f0;
  }

  .sku-line {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: monospace;
    font-weight: 700;
    color: #00354f;
    background: #e0f2fe;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 11.5px;
    margin-top: 2px;
  }
  .copy-sku-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #64748b;
    padding: 1px 3px;
    display: inline-flex;
    align-items: center;
  }
  .copy-sku-btn:hover {
    color: #00354f;
  }

  .btn-select-product {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    border: 1px solid #00354f;
    background: #ffffff;
    color: #00354f;
    transition: all 0.15s;
    white-space: nowrap;
  }
  .btn-select-product:hover {
    background: #00354f;
    color: #ffffff;
  }
  .btn-select-product.selected {
    background: #16a34a;
    border-color: #16a34a;
    color: #ffffff;
  }

  /* Selection Summary Sticky Panel */
  .selection-panel {
    background: #ffffff;
    border: 2px solid #00354f;
    border-radius: 10px;
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  }
  .selection-panel-title {
    font-size: 15px;
    font-weight: 800;
    color: #00354f;
    text-transform: uppercase;
    margin-bottom: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .selected-item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 14px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    margin-bottom: 8px;
    font-size: 13px;
  }
  .selected-item-row.is-primary {
    border-left: 4px solid #00354f;
    background: #f0f9ff;
  }
  .qty-stepper {
    display: inline-flex;
    align-items: center;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    overflow: hidden;
    background: #ffffff;
  }
  .qty-btn {
    width: 28px;
    height: 28px;
    background: #f1f5f9;
    border: none;
    cursor: pointer;
    font-weight: 800;
    color: #334155;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .qty-btn:hover {
    background: #e2e8f0;
  }
  .qty-input {
    width: 44px;
    height: 28px;
    border: none;
    text-align: center;
    font-weight: 700;
    font-size: 13px;
  }

  /* Tolerance Indicator Callout */
  .tolerance-callout {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 18px;
    border-radius: 6px;
    margin: 14px 0;
    font-size: 13px;
  }
  .tolerance-callout.success {
    background: #dcfce7;
    border: 1px solid #86efac;
    color: #14532d;
  }
  .tolerance-callout.warning {
    background: #fef9c3;
    border: 1px solid #fde047;
    color: #713f12;
  }

  /* Cooling Pad Table inside Tab 2 */
  .cooling-pad-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 22px;
    margin-bottom: 24px;
  }
  .pad-table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    margin-top: 12px;
    font-size: 13px;
  }
  .pad-table th {
    background: #f1f5f9;
    padding: 10px 12px;
    font-weight: 700;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
  }
  .pad-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
  }

  /* Major CTA Action Buttons */
  .cta-buttons-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #e2e8f0;
  }
  .cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 22px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    border: 1px solid transparent;
    transition: all 0.2s;
  }
  .cta-btn-primary {
    background: #00354f;
    color: #ffffff;
  }
  .cta-btn-primary:hover {
    background: #002233;
  }
  .cta-btn-pdf {
    background: #d41e3d;
    color: #ffffff;
  }
  .cta-btn-pdf:hover {
    background: #b91530;
  }
  .cta-btn-zalo {
    background: #0068ff;
    color: #ffffff;
  }
  .cta-btn-zalo:hover {
    background: #0056d6;
  }

  /* Disclaimer Box */
  .disclaimer-card {
    background: #f8fafc;
    border-left: 4px solid #00354f;
    padding: 16px 20px;
    border-radius: 6px;
    font-size: 12.5px;
    color: #475569;
    line-height: 1.6;
    margin-top: 28px;
  }

  /* Modal */
  .calc-modal-backdrop {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.55);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  .calc-modal-backdrop.active {
    display: flex;
  }
  .calc-modal-box {
    background: #ffffff;
    width: 100%;
    max-width: 520px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    overflow: hidden;
  }
  .calc-modal-header {
    background: #00354f;
    color: #ffffff;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .calc-modal-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
  }
  .calc-modal-close {
    background: none;
    border: none;
    color: #ffffff;
    font-size: 22px;
    cursor: pointer;
  }
  .calc-modal-body {
    padding: 20px;
  }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="calc-hero">
  <div class="calc-container">
    <div class="badge-tag">
      <i class="fas fa-calculator"></i> CÔNG CỤ TÍNH KỸ THUẬT HVAC &middot; WINLINE VIỆT NAM
    </div>
    <h1>CÔNG CỤ TÍNH CHỌN QUẠT THÔNG GIÓ &amp; LÀM MÁT</h1>
    <p>
      Gợi ý model quạt và diện tích tấm làm mát Cooling Pad theo lưu lượng gió tính toán.
      Kết quả dự tính theo dữ liệu người dùng nhập, hỗ trợ xuất bản vẽ/file PDF và gửi báo giá nhanh qua Zalo.
    </p>
  </div>
</section>

<div class="calc-container">
  <!-- 3 Standard Navigation Tabs -->
  <div class="calc-tabs">
    <button class="tab-btn {{ $activeTab === 'thong-gio-hut-khi' ? 'active' : '' }}" onclick="switchTab('thong-gio-hut-khi')">
      <i class="fas fa-wind"></i> 1. Thông gió &ndash; hút khí
    </button>
    <button class="tab-btn {{ $activeTab === 'cooling-pad' ? 'active' : '' }}" onclick="switchTab('cooling-pad')">
      <i class="fas fa-snowflake"></i> 2. Làm mát bằng Cooling Pad
    </button>
    <button class="tab-btn {{ $activeTab === 'thong-gio-phong' ? 'active' : '' }}" onclick="switchTab('thong-gio-phong')">
      <i class="fas fa-door-open"></i> 3. Thông gió văn phòng, phòng bếp &amp; WC
    </button>
  </div>

  <!-- Main Inputs & Dashboard Grid -->
  <div class="calc-grid">
    <!-- Left: Inputs Card -->
    <div class="calc-card">
      <div class="calc-card-title">
        <span class="step-n">1</span>
        <span>Thông số không gian &amp; Nhu cầu</span>
      </div>

      <!-- Area -->
      <div class="form-group">
        <label class="form-label" id="lbl_area">Diện tích không gian (m²)</label>
        <input type="number" class="form-input" id="input_area" value="{{ $initialCalc['area'] ?? 3000 }}" min="1" step="10" oninput="onInputChange()">
      </div>

      <!-- Height: Exactly "chiều cao trung bình" -->
      <div class="form-group">
        <label class="form-label">Chiều cao trung bình (m)</label>
        <input type="number" class="form-input" id="input_height" value="{{ $initialCalc['height'] ?? 3.0 }}" min="1" step="0.5" oninput="onInputChange()">
      </div>

      <!-- Presets by Tab -->
      <div class="form-group">
        <label class="form-label">Loại không gian / Nhu cầu sử dụng</label>
        
        <!-- Tab 1 Presets -->
        <div class="preset-chips tab-preset-group" id="presets_tab1" style="{{ $activeTab === 'thong-gio-hut-khi' ? '' : 'display:none;' }}">
          <span class="preset-chip {{ ($initialCalc['boiso'] ?? 20) == 20 ? 'active' : '' }}" onclick="setBoiso(20, this)">Bếp / Kho ít người (20 lần/h)</span>
          <span class="preset-chip {{ ($initialCalc['boiso'] ?? 20) == 25 ? 'active' : '' }}" onclick="setBoiso(25, this)">Thông gió xưởng (25 lần/h)</span>
          <span class="preset-chip {{ ($initialCalc['boiso'] ?? 20) == 40 ? 'active' : '' }}" onclick="setBoiso(40, this)">Nhiệt cao, đông người (40 lần/h)</span>
          <span class="preset-chip {{ ($initialCalc['boiso'] ?? 20) == 60 ? 'active' : '' }}" onclick="setBoiso(60, this)">Hút nhiệt nóng mạnh (60 lần/h)</span>
          <span class="preset-chip" onclick="setBoiso(10, this)">Nhà màng nông nghiệp (10 lần/h)</span>
        </div>

        <!-- Tab 2 Presets -->
        <div class="preset-chips tab-preset-group" id="presets_tab2" style="{{ $activeTab === 'cooling-pad' ? '' : 'display:none;' }}">
          <span class="preset-chip {{ ($initialCalc['boiso'] ?? 60) == 50 ? 'active' : '' }}" onclick="setBoiso(50, this)">Xưởng thông thoáng (50 lần/h)</span>
          <span class="preset-chip {{ ($initialCalc['boiso'] ?? 60) == 60 ? 'active' : '' }}" onclick="setBoiso(60, this)">Xưởng may, cơ khí (60 lần/h)</span>
          <span class="preset-chip {{ ($initialCalc['boiso'] ?? 60) == 70 ? 'active' : '' }}" onclick="setBoiso(70, this)">Xưởng ép nhựa / nóng gắt (70 lần/h)</span>
          <span class="preset-chip" onclick="setBoiso(40, this)">Trang trại chăn nuôi kín (40 lần/h)</span>
        </div>

        <!-- Tab 3 Presets (Phụ lục G) -->
        <div class="tab-preset-group" id="presets_tab3" style="{{ $activeTab === 'thong-gio-phong' ? '' : 'display:none;' }}">
          <select class="form-input" id="select_space_type" onchange="onSpaceTypeChange(this.value)">
            @foreach($spaceTypesPhuLucG as $key => $info)
              <option value="{{ $key }}" data-ach="{{ $info['ach'] }}" {{ ($initialCalc['space_type'] ?? 'cong_so') === $key ? 'selected' : '' }}>
                {{ $info['name'] }} (Bội số: {{ $info['ach'] }} lần/h)
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- ACH Bội số trao đổi khí -->
      <div class="form-group">
        <label class="form-label">Bội số trao đổi khí (lần/h)</label>
        <input type="number" class="form-input" id="input_boiso" value="{{ $initialCalc['boiso'] ?? 20 }}" min="1" max="150" step="1" oninput="onInputChange()">
      </div>

      <!-- Voltage selector (placed in inputs area per spec) -->
      <div class="form-group">
        <label class="form-label">Điện áp sử dụng</label>
        <div class="voltage-group">
          <div class="voltage-btn {{ ($initialCalc['voltage'] ?? '380V') === '380V' ? 'active' : '' }}" onclick="setVoltage('380V', this)">
            380V (3 pha)
          </div>
          <div class="voltage-btn {{ ($initialCalc['voltage'] ?? '') === '220V' ? 'active' : '' }}" onclick="setVoltage('220V', this)">
            220V (1 pha)
          </div>
          <div class="voltage-btn {{ ($initialCalc['voltage'] ?? '') === 'all' ? 'active' : '' }}" onclick="setVoltage('all', this)">
            Tất cả
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Calculation Results Dashboard -->
    <div class="calc-card">
      <div class="calc-card-title">
        <span class="step-n">2</span>
        <span>Kết quả dự tính lưu lượng</span>
      </div>

      <div class="metric-grid">
        <div class="metric-box">
          <div class="metric-lbl">Thể tích không gian</div>
          <div class="metric-val" id="metric_volume">
            {{ number_format($initialCalc['volume'] ?? 9000, 0, ',', '.') }} <small>m³</small>
          </div>
        </div>

        <div class="metric-box highlight">
          <div class="metric-lbl" style="color: #00354f;">Lưu lượng gió cần thiết</div>
          <div class="metric-val" id="metric_airflow" style="color: #00354f;">
            {{ number_format($initialCalc['required_airflow'] ?? 180000, 0, ',', '.') }} <small>m³/h</small>
          </div>
        </div>
      </div>

      <!-- If Tab 2 Cooling Pad: Show Required Pad Area Metric -->
      <div id="cooling_pad_metrics" style="{{ $activeTab === 'cooling-pad' ? '' : 'display:none;' }}">
        <div class="metric-box cooling" style="margin-bottom: 16px;">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
              <div class="metric-lbl" style="color: #065f46;">Diện tích tấm Cooling Pad cần sơ bộ</div>
              <div class="metric-val" id="metric_pad_area" style="color: #065f46;">
                {{ number_format($initialCalc['nominal_pad_area'] ?? 8.0, 2, ',', '.') }} <small>m²</small>
              </div>
            </div>
            <div style="text-align: right; font-size: 11.5px; color: #065f46;">
              Năng suất cơ sở: <strong>{{ number_format($coolingPadVelocity, 0, ',', '.') }} m³/h/m²</strong><br>
              <span style="font-size: 10.5px; color: #64748b;">(Sẽ tính chuẩn lại theo tổng lưu lượng quạt thực chọn)</span>
            </div>
          </div>
        </div>
      </div>

      <div style="font-size: 12.5px; color: #64748b; line-height: 1.5; padding: 10px 14px; background: #f8fafc; border-radius: 6px;">
        <i class="fas fa-info-circle text-primary"></i>
        Công thức: <strong>Thể tích V = Diện tích × Chiều cao trung bình</strong> &middot;
        <strong>Lưu lượng gió Q = Thể tích V × Bội số trao đổi khí ACH</strong>.
      </div>
    </div>
  </div>

  <!-- Horizontal Filter Bar: Exactly 4 criteria -->
  <div class="filter-bar">
    <div class="filter-col">
      <label>Thương hiệu</label>
      <select class="filter-select" id="filter_brand" onchange="fetchProducts()">
        <option value="">Tất cả thương hiệu</option>
        @foreach($filterOptions['brands'] as $b)
          <option value="{{ $b['slug'] }}">{{ $b['name'] }}</option>
        @endforeach
      </select>
    </div>

    <div class="filter-col">
      <label>Loại quạt / sản phẩm</label>
      <select class="filter-select" id="filter_fan_type" onchange="fetchProducts()">
        <option value="">Tất cả loại quạt</option>
        @foreach($filterOptions['fan_types'] as $type)
          <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
      </select>
    </div>

    <div class="filter-col">
      <label id="lbl_filter_size">{{ $activeTab === 'thong-gio-phong' ? 'Kích thước lỗ chờ' : 'Kích thước' }}</label>
      <select class="filter-select" id="filter_size" onchange="fetchProducts()">
        <option value="">Tất cả kích thước</option>
        @foreach($filterOptions['sizes'] as $sz)
          <option value="{{ $sz }}">{{ $sz }}</option>
        @endforeach
      </select>
    </div>

    <div class="filter-col">
      <label>Khoảng giá</label>
      <select class="filter-select" id="filter_price" onchange="fetchProducts()">
        @foreach($filterOptions['price_ranges'] as $pr)
          <option value="{{ $pr['value'] }}">{{ $pr['label'] }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <button type="button" class="filter-reset-btn" onclick="resetFilters()">
        <i class="fas fa-redo-alt"></i> Xóa lọc
      </button>
    </div>
  </div>

  <!-- Table 1: Candidate Products (Max 6 results) -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
    <h3 style="font-size: 15px; font-weight: 800; color: #00354f; text-transform: uppercase; margin: 0;">
      GỢI Ý SẢN PHẨM THEO LƯU LƯỢNG TÍNH TOÁN (TỐI ĐA 6 SẢN PHẨM)
    </h3>
    <span style="font-size: 12.5px; color: #64748b;">
      Hiển thị tối đa 6 model phù hợp nhất &middot; Chọn tối đa 3 dòng
    </span>
  </div>

  <div class="table-responsive">
    <table class="calc-table" id="fans_table">
      <thead>
        <tr>
          <th style="width: 50px; text-align: center;">Ảnh</th>
          <th style="min-width: 220px;">Tên sản phẩm / SKU</th>
          <th style="width: 90px;">Thương hiệu</th>
          <th style="width: 130px;">Loại sản phẩm</th>
          <th style="width: 110px;" id="th_size">{{ $activeTab === 'thong-gio-phong' ? 'KT Lỗ chờ' : 'Kích thước' }}</th>
          <th style="width: 80px;">Công suất</th>
          <th style="width: 95px; text-align: right;">Lưu lượng</th>
          <th style="width: 75px; text-align: center;">SL dự tính</th>
          <th style="width: 105px; text-align: right;">Đơn giá</th>
          <th style="width: 90px; text-align: center;">Chọn</th>
        </tr>
      </thead>
      <tbody id="fans_tbody">
        <!-- Injected via JavaScript -->
      </tbody>
    </table>
  </div>

  <!-- Selection & Auto-balancing Panel (Max 3 items, Primary balances remainder) -->
  <div class="selection-panel" id="selection_panel">
    <div class="selection-panel-title">
      <span>
        <i class="fas fa-check-circle text-primary"></i>
        PHƯƠNG ÁN ĐÃ CHỌN (<span id="selected_count">0</span>/3 SẢN PHẨM)
      </span>
      <span style="font-size: 12px; font-weight: 600; color: #64748b;">
        Dòng chính tự động bù số lượng cho phần lưu lượng còn lại
      </span>
    </div>

    <!-- Selected items list -->
    <div id="selected_items_list">
      <div style="text-align: center; padding: 18px; color: #64748b; font-size: 13px;">
        Chưa có sản phẩm nào được chọn. Nhấp "Chọn" tại bảng trên để thêm vào phương án (Tối đa 3 dòng).
      </div>
    </div>

    <!-- Tolerance & Flow Callout -->
    <div id="tolerance_box" class="tolerance-callout warning" style="display: none;">
      <div id="tolerance_text">
        Lưu lượng quạt thực tế đang chênh lệch so với nhu cầu.
      </div>
      <div id="tolerance_badge" style="font-weight: 700;">
        Đang đối soát
      </div>
    </div>

    <!-- Tab 2: Cooling Pad Selection Block (Integrated into same estimation) -->
    <div class="cooling-pad-section" id="cooling_pad_section" style="{{ $activeTab === 'cooling-pad' ? '' : 'display:none;' }}">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h4 style="margin: 0; font-size: 14px; font-weight: 800; color: #00354f; text-transform: uppercase;">
          BẢNG CHỌN TẤM LÀM MÁT COOLING PAD (THEO LƯU LƯỢNG QUẠT ĐÃ CHỌN)
        </h4>
        <span style="font-size: 12.5px; color: #065f46; font-weight: 700;">
          Diện tích tấm cần: <span id="actual_pad_area_needed">0.00</span> m²
        </span>
      </div>
      <p style="font-size: 12px; color: #64748b; margin: 0 0 10px 0;">
        Diện tích tấm = Chiều dài &times; Chiều rộng (Độ dày 150mm tiêu chuẩn không tham gia tính diện tích; Khung mua riêng). Số lượng làm tròn lên (ROUNDUP).
      </p>

      <table class="pad-table">
        <thead>
          <tr>
            <th style="width: 40px; text-align: center;">Chọn</th>
            <th>Kích thước tấm (Dài &times; Rộng &times; Dày)</th>
            <th style="width: 100px; text-align: center;">DT 1 tấm</th>
            <th style="width: 110px; text-align: center;">SL đề xuất</th>
            <th style="width: 110px; text-align: right;">Tổng DT</th>
            <th style="width: 110px; text-align: right;">Đơn giá</th>
            <th style="width: 120px; text-align: right;">Thành tiền</th>
          </tr>
        </thead>
        <tbody id="cooling_pad_tbody">
          <!-- Injected via JavaScript -->
        </tbody>
      </table>
    </div>

    <!-- Grand Total & Pricing -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 14px; border-top: 1px dashed #cbd5e1;">
      <div>
        <div style="font-size: 12.5px; color: #64748b;">
          Đơn giá tham khảo tại thời điểm hiện tại &middot; Chưa gồm VAT &amp; vận chuyển
        </div>
      </div>
      <div style="text-align: right;">
        <div style="font-size: 12.5px; color: #475569; text-transform: uppercase; font-weight: 700;">TỔNG KINH PHÍ DỰ TÍNH:</div>
        <div style="font-size: 22px; font-weight: 800; color: #d41e3d;" id="grand_total_price">0 đ</div>
      </div>
    </div>

    <!-- 3 Action Buttons -->
    <div class="cta-buttons-bar">
      <button type="button" class="cta-btn cta-btn-primary" onclick="saveEstimation(false)">
        <i class="fas fa-save"></i> Lưu bản dự tính &amp; Lấy liên kết
      </button>

      <button type="button" class="cta-btn cta-btn-pdf" onclick="saveEstimation(true)">
        <i class="fas fa-file-pdf"></i> Tải bản dự tính PDF (A4)
      </button>

      <button type="button" class="cta-btn cta-btn-zalo" onclick="openZaloModal()">
        <i class="fas fa-paper-plane"></i> Gửi bản dự tính cho Winline qua Zalo
      </button>
    </div>
  </div>

  <!-- Disclaimer policy note -->
  <div class="disclaimer-card">
    <p style="margin-bottom: 6px;">
      <strong>Khuyến cáo kỹ thuật Winline:</strong> Kết quả là bản dự tính ban đầu dựa trên dữ liệu khách nhập và thông số sản phẩm tiêu chuẩn. Tổn thất áp đường ống, nguồn nhiệt thực tế, vị trí cấp/hút gió và điều kiện lắp đặt thực tế có thể làm thay đổi lựa chọn. Công trình phức tạp hoặc dự án công nghiệp quy mô lớn vui lòng liên hệ hotline <strong>0949.761.888 / 0963.230.665</strong> để được kỹ sư Winline khảo sát và lập bản vẽ chi tiết.
    </p>
    <p style="margin: 0;">
      <strong>Chính sách đơn giá:</strong> Đơn giá và tổng tiền là giá tham khảo tại thời điểm tạo bản dự tính; có thể thay đổi theo số lượng, giao hàng, thuế GTGT (VAT) và chính sách ưu đãi của hãng.
    </p>
  </div>
</div>

<!-- Modal RFQ / Send to Winline -->
<div class="calc-modal-backdrop" id="zaloModal">
  <div class="calc-modal-box">
    <div class="calc-modal-header">
      <h3>GỬI BẢN DỰ TÍNH TỚI WINLINE QUA ZALO</h3>
      <button type="button" class="calc-modal-close" onclick="closeZaloModal()">&times;</button>
    </div>
    <div class="calc-modal-body">
      <p style="font-size: 13px; color: #64748b; margin-bottom: 14px;">
        Vui lòng nhập thông tin để chuyên viên kỹ thuật Winline kiểm tra tính khả thi, chuẩn bị hồ sơ báo giá tốt nhất và mở Zalo hỗ trợ bạn ngay lập tức:
      </p>

      <div class="form-group">
        <label class="form-label">Họ và tên của bạn <span style="color: red;">*</span></label>
        <input type="text" id="modal_cust_name" class="form-input" required placeholder="Ví dụ: Nguyễn Văn A">
      </div>

      <div class="form-group">
        <label class="form-label">Số điện thoại liên hệ (Zalo) <span style="color: red;">*</span></label>
        <input type="tel" id="modal_cust_phone" class="form-input" required placeholder="Ví dụ: 0912345678">
      </div>

      <div class="form-group">
        <label class="form-label">Địa chỉ Email</label>
        <input type="email" id="modal_cust_email" class="form-input" placeholder="Ví dụ: contact@company.com">
      </div>

      <div class="form-group">
        <label class="form-label">Tên đơn vị / Doanh nghiệp</label>
        <input type="text" id="modal_cust_company" class="form-input" placeholder="Ví dụ: Công ty Cơ điện ABC">
      </div>

      <div class="form-group">
        <label class="form-label">Mã số thuế (tùy chọn)</label>
        <input type="text" id="modal_cust_tax" class="form-input" placeholder="Mã số thuế nếu cần xuất hóa đơn VAT">
      </div>

      <button type="button" class="cta-btn cta-btn-zalo" id="modalSubmitBtn" style="width: 100%; justify-content: center; margin-top: 10px;" onclick="submitZaloRfq()">
        <i class="fas fa-paper-plane"></i> Xác nhận &amp; Mở Zalo Winline (0949.761.888)
      </button>
    </div>
  </div>
</div>

<!-- Modal Share Link After Save -->
<div class="calc-modal-backdrop" id="shareModal">
  <div class="calc-modal-box">
    <div class="calc-modal-header">
      <h3>BẢN DỰ TÍNH ĐÃ ĐƯỢC LƯU THÀNH CÔNG!</h3>
      <button type="button" class="calc-modal-close" onclick="closeShareModal()">&times;</button>
    </div>
    <div class="calc-modal-body">
      <p style="font-size: 13.5px; color: #334155; margin-bottom: 12px;">
        Mã bản dự tính của bạn: <strong id="saved_public_id" style="color: #00354f; font-size: 16px;">—</strong>
      </p>
      <div class="form-group">
        <label class="form-label">Đường dẫn chia sẻ trực tuyến:</label>
        <div style="display: flex; gap: 8px;">
          <input type="text" id="saved_share_url" class="form-input" readonly>
          <button type="button" class="cta-btn cta-btn-primary" style="padding: 8px 14px;" onclick="copySavedUrl()">
            Sao chép
          </button>
        </div>
      </div>
      <div style="display: flex; gap: 10px; margin-top: 18px;">
        <a href="#" id="view_saved_btn" class="cta-btn cta-btn-primary" style="flex: 1; justify-content: center;">
          Xem trực tuyến
        </a>
        <a href="#" id="pdf_saved_btn" target="_blank" class="cta-btn cta-btn-pdf" style="flex: 1; justify-content: center;">
          In / Tải PDF
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  window.CALC_CONFIG = {
    locale: '{{ app()->getLocale() }}',
    initialTab: '{{ $activeTab }}',
    coolingVelocity: {{ $coolingPadVelocity }},
    urls: {
      products: '{{ route("client.calculator.products", ["locale" => app()->getLocale()]) }}',
      balance: '{{ route("client.calculator.balance", ["locale" => app()->getLocale()]) }}',
      save: '{{ route("client.calculator.save", ["locale" => app()->getLocale()]) }}',
    },
    padCatalog: @json($coolingPadCatalog),
  };
</script>
<script src="{{ asset('client-assets/js/calculator.js') }}?v={{ time() }}"></script>
@endpush
