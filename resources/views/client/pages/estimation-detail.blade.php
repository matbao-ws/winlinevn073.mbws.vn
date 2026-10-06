@extends('client.layouts.app')

@section('title', 'Bản dự tính quạt #' . $calculation->public_id . ' | Winline.vn')

@push('styles')
<style>
  .est-hero {
    background: linear-gradient(135deg, #004e7d 0%, #004e7d 100%);
    color: #ffffff;
    padding: 36px 0;
    margin-bottom: 28px;
  }
  .est-hero .badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
    letter-spacing: 0.5px;
  }
  .est-hero h1 {
    font-size: 26px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 8px;
  }
  .est-hero p {
    color: #cbd5e1;
    font-size: 14px;
    margin: 0;
  }

  .est-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
  }

  .btn-est {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    border-radius: 6px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 0.2s;
  }
  .btn-est-primary {
    background: var(--primary);
    color: #ffffff;
    border-color: var(--primary);
  }
  .btn-est-primary:hover {
    background: #002233;
  }
  .btn-est-white {
    background: #ffffff;
    color: #004e7d;
  }
  .btn-est-white:hover {
    background: #f8fafc;
  }
  .btn-est-zalo {
    background: #0068ff;
    color: #ffffff;
  }
  .btn-est-zalo:hover {
    background: #0056d6;
  }
  .btn-est-outline {
    background: transparent;
    color: #ffffff;
    border-color: rgba(255,255,255,0.4);
  }
  .btn-est-outline:hover {
    background: rgba(255,255,255,0.1);
  }

  .est-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px 48px;
  }

  .grid-cards {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 28px;
  }
  @media (max-width: 768px) {
    .grid-cards {
      grid-template-columns: 1fr;
    }
  }

  .box-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px 24px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
  }
  .box-title {
    font-size: 14px;
    font-weight: 700;
    color: #004e7d;
    text-transform: uppercase;
    padding-bottom: 10px;
    margin-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .param-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 13.5px;
    border-bottom: 1px dashed #f1f5f9;
  }
  .param-row:last-child {
    border-bottom: none;
  }
  .param-label {
    color: #64748b;
  }
  .param-val {
    font-weight: 600;
    color: #0f172a;
    text-align: right;
  }

  .table-responsive {
    overflow-x: auto;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-bottom: 24px;
  }
  .est-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }
  .est-table th {
    background: #f8fafc;
    color: #334155;
    font-weight: 700;
    padding: 12px 14px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
  }
  .est-table td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
  }
  .est-table tr:hover {
    background-color: #f8fafc;
  }

  .sku-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: monospace;
    font-weight: 700;
    color: #004e7d;
    background: #e0f2fe;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 12px;
  }
  .copy-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #64748b;
    padding: 2px;
    display: inline-flex;
    align-items: center;
  }
  .copy-btn:hover {
    color: #004e7d;
  }

  .tolerance-banner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    border-radius: 8px;
    margin-bottom: 24px;
    font-size: 13.5px;
  }
  .tolerance-banner.success {
    background: #dcfce7;
    border: 1px solid #86efac;
    color: #14532d;
  }
  .tolerance-banner.warning {
    background: #fef9c3;
    border: 1px solid #fde047;
    color: #713f12;
  }

  .summary-panel {
    background: #f8fafc;
    border: 2px solid #004e7d;
    border-radius: 8px;
    padding: 20px 24px;
    margin-bottom: 28px;
  }
  .sum-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 14px;
  }
  .sum-row.grand {
    border-top: 1px dashed #cbd5e1;
    margin-top: 10px;
    padding-top: 12px;
    font-size: 18px;
    font-weight: 800;
    color: #d41e3d;
  }

  .policy-note {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #004e7d;
    padding: 16px 20px;
    border-radius: 6px;
    font-size: 12.5px;
    color: #475569;
    line-height: 1.6;
    margin-bottom: 32px;
  }

  /* Modal */
  .modal-backdrop {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.55);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  .modal-backdrop.active {
    display: flex;
  }
  .modal-box {
    background: #ffffff;
    width: 100%;
    max-width: 520px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    overflow: hidden;
  }
  .modal-header {
    background: #004e7d;
    color: #ffffff;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .modal-header h3 {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
  }
  .modal-close {
    background: none;
    border: none;
    color: #ffffff;
    font-size: 20px;
    cursor: pointer;
  }
  .modal-body {
    padding: 20px;
  }
  .form-group {
    margin-bottom: 14px;
  }
  .form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 5px;
  }
  .form-control {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 13.5px;
    box-sizing: border-box;
  }
  .form-control:focus {
    border-color: #004e7d;
    outline: none;
  }
</style>
@endpush

@section('content')
<section class="est-hero">
  <div class="container">
    <div class="badge-pill">
      <span>MÃ BẢN DỰ TÍNH: {{ $calculation->public_id }}</span>
      <span>•</span>
      <span>{{ $calculation->created_at->format('d/m/Y H:i') }}</span>
      @if($calculation->status === 'submitted')
        <span>•</span>
        <span style="color: #86efac;">✓ Đã gửi yêu cầu tới Winline</span>
      @endif
    </div>
    <h1>BẢN DỰ TÍNH THIẾT BỊ THÔNG GIÓ &amp; LÀM MÁT</h1>
    <p>
      @if($calculation->tab === 'cooling-pad')
        Phương án hệ thống làm mát áp suất âm quạt hút kết hợp Cooling Pad
      @elseif($calculation->tab === 'thong-gio-phong')
        Phương án thông gió văn phòng, phòng bếp, phòng ngủ &amp; WC (Theo chuẩn thông gió TCVN)
      @else
        Phương án thông gió tổng thể &amp; hút khí công nghiệp
      @endif
    </p>

    <div class="est-actions">
      <a href="{{ route('client.calculator.pdf', ['locale' => app()->getLocale(), 'publicId' => $calculation->public_id]) }}" target="_blank" class="btn-est btn-est-white">
        <i class="fas fa-file-pdf text-danger"></i> Tải / In bản PDF (A4)
      </a>

      <button onclick="openRfqModal()" class="btn-est btn-est-zalo">
        <i class="fas fa-paper-plane"></i> Gửi Winline qua Zalo / Nhận báo giá
      </button>

      <button onclick="copyShareUrl()" class="btn-est btn-est-outline" id="copyShareBtn">
        <i class="fas fa-link"></i> Sao chép liên kết
      </button>

      @php
        $inputs = $calculation->inputs ?? [];
        $editParams = http_build_query([
          'tab' => $calculation->tab,
          'area' => $inputs['area'] ?? 0,
          'height' => $inputs['height'] ?? 0,
          'boiso' => $inputs['boiso'] ?? 0,
          'voltage' => $inputs['voltage'] ?? 'all',
        ]);
      @endphp
      <a href="{{ route('client.calculator', ['locale' => app()->getLocale()]) }}?{{ $editParams }}" class="btn-est btn-est-outline">
        <i class="fas fa-sliders-h"></i> Điều chỉnh trong công cụ
      </a>
    </div>
  </div>
</section>

<div class="est-container">
  <!-- 2 Info Cards -->
  <div class="grid-cards">
    <!-- Card 1: Customer Contact -->
    <div class="box-card">
      <div class="box-title">
        <span>Thông tin khách hàng / Người lập</span>
        <button onclick="openRfqModal()" class="btn-est btn-est-primary" style="padding: 4px 10px; font-size: 11.5px;">
          Cập nhật thông tin
        </button>
      </div>
      <div class="param-row">
        <span class="param-label">Họ và tên:</span>
        <span class="param-val">{{ $calculation->customer_name ?: 'Khách hàng tham khảo trực tuyến' }}</span>
      </div>
      <div class="param-row">
        <span class="param-label">Số điện thoại:</span>
        <span class="param-val">{{ $calculation->customer_phone ?: 'Chưa cập nhật' }}</span>
      </div>
      <div class="param-row">
        <span class="param-label">Email:</span>
        <span class="param-val">{{ $calculation->customer_email ?: 'Chưa cập nhật' }}</span>
      </div>
      <div class="param-row">
        <span class="param-label">Đơn vị / Công ty:</span>
        <span class="param-val">{{ $calculation->company_name ?: 'Khách hàng cá nhân' }}</span>
      </div>
      @if($calculation->tax_code)
      <div class="param-row">
        <span class="param-label">Mã số thuế:</span>
        <span class="param-val">{{ $calculation->tax_code }}</span>
      </div>
      @endif
    </div>

    <!-- Card 2: Space Requirements -->
    @php
      $results = $calculation->results ?? [];
    @endphp
    <div class="box-card">
      <div class="box-title">
        <span>Thông số công trình &amp; Nhu cầu</span>
      </div>
      <div class="param-row">
        <span class="param-label">Diện tích không gian:</span>
        <span class="param-val">{{ number_format($inputs['area'] ?? 0, 0, ',', '.') }} m²</span>
      </div>
      <div class="param-row">
        <span class="param-label">Chiều cao trung bình:</span>
        <span class="param-val">{{ number_format($inputs['height'] ?? 0, 1, ',', '.') }} m</span>
      </div>
      <div class="param-row">
        <span class="param-label">Thể tích không gian:</span>
        <span class="param-val">{{ number_format($inputs['volume'] ?? (($inputs['area'] ?? 0) * ($inputs['height'] ?? 0)), 0, ',', '.') }} m³</span>
      </div>
      <div class="param-row">
        <span class="param-label">Bội số trao đổi khí (ACH):</span>
        <span class="param-val">{{ $inputs['boiso'] ?? '—' }} lần/h</span>
      </div>
      <div class="param-row">
        <span class="param-label">Lưu lượng gió cần thiết:</span>
        <span class="param-val" style="color: #004e7d; font-size: 15px;">
          <strong>{{ number_format($results['required_airflow'] ?? 0, 0, ',', '.') }} m³/h</strong>
        </span>
      </div>
      <div class="param-row">
        <span class="param-label">Nguồn điện sử dụng:</span>
        <span class="param-val">{{ $inputs['voltage'] ?? 'Tất cả' }}</span>
      </div>
    </div>
  </div>

  <!-- Tolerance Status Callout -->
  @php
    $deltaPercent = (float) ($results['delta_percent'] ?? 0);
    $isInTol = abs($deltaPercent) <= 5.0;
    $totalFanFlow = (float) ($results['total_actual_airflow'] ?? 0);
    $neededFlow = (float) ($results['required_airflow'] ?? 0);
  @endphp
  <div class="tolerance-banner {{ $isInTol ? 'success' : 'warning' }}">
    <div>
      <strong>Đối soát kỹ thuật lưu lượng:</strong>
      Lưu lượng quạt thực chọn đạt <strong>{{ number_format($totalFanFlow, 0, ',', '.') }} m³/h</strong>
      so với nhu cầu <strong>{{ number_format($neededFlow, 0, ',', '.') }} m³/h</strong>
      (Độ lệch: <strong>{{ ($deltaPercent >= 0 ? '+' : '') . number_format($deltaPercent, 1, ',', '.') }}%</strong>).
    </div>
    <div>
      @if($isInTol)
        <span style="font-weight: 700;">✓ Nằm trong khoảng dự tính ±5%</span>
      @else
        <span style="font-weight: 700;">⚠ Cần lưu ý điều chỉnh số lượng</span>
      @endif
    </div>
  </div>

  <!-- Selected Fans Table -->
  @php
    $items = $calculation->selected_items['items'] ?? ($calculation->selected_items['fans'] ?? []);
    if (empty($items) && is_array($calculation->selected_items) && isset($calculation->selected_items[0])) {
        $items = $calculation->selected_items;
    }
  @endphp
  <h3 style="font-size: 16px; font-weight: 800; color: #004e7d; margin-bottom: 12px; text-transform: uppercase;">
    1. Danh mục thiết bị quạt đã chọn
  </h3>
  <div class="table-responsive">
    <table class="est-table">
      <thead>
        <tr>
          <th style="width: 40px; text-align: center;">STT</th>
          <th style="width: 130px;">Mã SKU</th>
          <th>Tên sản phẩm &amp; Quy cách</th>
          <th style="width: 100px;">Thương hiệu</th>
          <th style="width: 110px; text-align: right;">Lưu lượng</th>
          <th style="width: 70px; text-align: center;">Số lượng</th>
          <th style="width: 120px; text-align: right;">Đơn giá tham khảo</th>
          <th style="width: 130px; text-align: right;">Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $idx => $item)
          @php
            $qty = (int) ($item['quantity'] ?? 1);
            $price = (float) ($item['unit_price'] ?? 0);
            $subtotal = $qty * $price;
            $flow = (float) ($item['airflow'] ?? 0);
          @endphp
          <tr>
            <td style="text-align: center; font-weight: 600;">{{ $idx + 1 }}</td>
            <td>
              <span class="sku-badge">
                {{ $item['sku'] ?? '—' }}
                <button type="button" class="copy-btn" onclick="copySku('{{ $item['sku'] }}')" title="Sao chép SKU">
                  <i class="far fa-copy"></i>
                </button>
              </span>
              @if(!empty($item['is_primary']))
                <div style="font-size: 10px; color: #004e7d; font-weight: 700; margin-top: 2px;">DÒNG CHÍNH</div>
              @endif
            </td>
            <td>
              @if(!empty($item['slug']))
                <a href="{{ route('client.products.detail', ['locale' => app()->getLocale(), 'slug' => $item['slug']]) }}" target="_blank" style="color: #004e7d; font-weight: 700; text-decoration: none;">
                  {{ $item['name'] ?? $item['sku'] }}
                </a>
              @else
                <strong style="color: #004e7d;">{{ $item['name'] ?? $item['sku'] }}</strong>
              @endif
              <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                {{ $item['fan_type'] ?? '' }}
                @if(!empty($item['size_display'])) · KT: {{ $item['size_display'] }} @endif
                @if(!empty($item['power'])) · CS: {{ $item['power'] }} @endif
                @if(!empty($item['voltage'])) · Nguồn: {{ $item['voltage'] }} @endif
              </div>
            </td>
            <td><strong>{{ $item['brand_name'] ?? ($item['brand'] ?? 'Winline') }}</strong></td>
            <td style="text-align: right; font-weight: 700;">{{ number_format($flow, 0, ',', '.') }} m³/h</td>
            <td style="text-align: center; font-weight: 800; font-size: 14px;">{{ $qty }}</td>
            <td style="text-align: right;">{{ number_format($price, 0, ',', '.') }} đ</td>
            <td style="text-align: right; font-weight: 700; color: #004e7d;">{{ number_format($subtotal, 0, ',', '.') }} đ</td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="text-align: center; padding: 20px; color: #64748b;">
              Chưa có thiết bị quạt nào được lưu trong bản dự tính này.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Cooling Pad Table (If Tab 2) -->
  @if($calculation->tab === 'cooling-pad')
    @php
      $coolingPads = $calculation->selected_items['cooling_pads'] ?? [];
      $padData = $calculation->results['cooling_pads'] ?? [];
      $nominalArea = $results['nominal_pad_area'] ?? ($padData['required_pad_area'] ?? 0);
    @endphp
    <h3 style="font-size: 16px; font-weight: 800; color: #004e7d; margin: 28px 0 12px; text-transform: uppercase;">
      2. Tấm làm mát Cooling Pad (Năng suất cơ sở: 9.000 m³/h/m²)
    </h3>
    <div class="table-responsive">
      <table class="est-table">
        <thead>
          <tr>
            <th style="width: 40px; text-align: center;">STT</th>
            <th style="width: 140px;">Mã quy cách</th>
            <th>Quy cách tấm Cooling Pad</th>
            <th style="width: 120px; text-align: center;">Diện tích 1 tấm</th>
            <th style="width: 70px; text-align: center;">Số lượng</th>
            <th style="width: 110px; text-align: right;">Tổng diện tích</th>
            <th style="width: 120px; text-align: right;">Đơn giá</th>
            <th style="width: 130px; text-align: right;">Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          @forelse($coolingPads as $pIdx => $pad)
            @php
              $pQty = (int) ($pad['quantity'] ?? 1);
              $pPrice = (float) ($pad['unit_price'] ?? 0);
              $pSubtotal = $pQty * $pPrice;
              $pAreaUnit = (float) ($pad['area_per_unit'] ?? 0);
              $pTotalArea = round($pQty * $pAreaUnit, 2);
            @endphp
            <tr>
              <td style="text-align: center; font-weight: 600;">{{ $pIdx + 1 }}</td>
              <td><span class="sku-badge">{{ $pad['sku'] ?? 'COOLING-PAD' }}</span></td>
              <td>
                <strong style="color: #004e7d;">{{ $pad['name'] ?? 'Tấm làm mát Cooling Pad' }}</strong>
                <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                  Kích thước: {{ $pad['dimensions'] ?? '1800x600x150mm' }} (Độ dày 150mm tiêu chuẩn, khung mua riêng)
                </div>
              </td>
              <td style="text-align: center;">{{ number_format($pAreaUnit, 2, ',', '.') }} m²</td>
              <td style="text-align: center; font-weight: 800; font-size: 14px;">{{ $pQty }}</td>
              <td style="text-align: right; font-weight: 700;">{{ number_format($pTotalArea, 2, ',', '.') }} m²</td>
              <td style="text-align: right;">{{ number_format($pPrice, 0, ',', '.') }} đ</td>
              <td style="text-align: right; font-weight: 700; color: #004e7d;">{{ number_format($pSubtotal, 0, ',', '.') }} đ</td>
            </tr>
          @empty
            <tr>
              <td colspan="8" style="text-align: center; padding: 16px; color: #64748b;">
                Diện tích cooling pad tính toán theo tổng lưu lượng quạt: <strong>{{ number_format($nominalArea, 2, ',', '.') }} m²</strong> (chưa lưu quy cách tấm chi tiết).
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  @endif

  <!-- Overall Total Summary Panel -->
  @php
    $grandTotal = (float) ($results['grand_total'] ?? ($results['total_price'] ?? 0));
    $fanTotal = (float) ($results['total_price'] ?? 0);
    $padTotal = (float) ($results['total_pad_price'] ?? ($grandTotal - $fanTotal));
  @endphp
  <div class="summary-panel">
    <div class="sum-row">
      <span style="color: #475569;">Tổng chi phí thiết bị quạt thông gió:</span>
      <span style="font-weight: 700;">{{ number_format($fanTotal, 0, ',', '.') }} đ</span>
    </div>
    @if($calculation->tab === 'cooling-pad' && $padTotal > 0)
    <div class="sum-row">
      <span style="color: #475569;">Tổng chi phí tấm làm mát Cooling Pad:</span>
      <span style="font-weight: 700;">{{ number_format($padTotal, 0, ',', '.') }} đ</span>
    </div>
    @endif
    <div class="sum-row grand">
      <span>TỔNG KINH PHÍ DỰ TÍNH (THAM KHẢO):</span>
      <span>{{ number_format($grandTotal, 0, ',', '.') }} VNĐ</span>
    </div>
  </div>

  <!-- Disclaimer policy note -->
  <div class="policy-note">
    <p style="margin-bottom: 6px;">
      <strong>Lưu ý về chính sách giá &amp; kỹ thuật:</strong> Đơn giá và tổng tiền nêu trên là giá tham khảo tại thời điểm tạo bản dự tính; có thể thay đổi theo số lượng đơn hàng, điều kiện vận chuyển, thuế VAT và chính sách chiết khấu của Winline Việt Nam.
    </p>
    <p style="margin: 0;">
      Kết quả tính toán là bản dự tính sơ bộ dựa trên thể tích không gian và bội số trao đổi khí tiêu chuẩn. Để đảm bảo hệ thống vận hành đạt hiệu quả cao nhất và tối ưu chi phí đầu tư, quý khách vui lòng liên hệ hotline kỹ thuật <strong>0949.761.888 / 0963.230.665</strong> để được khảo sát và tư vấn chi tiết.
    </p>
  </div>
</div>

<!-- Modal RFQ / Send to Winline -->
<div class="modal-backdrop" id="rfqModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3>GỬI BẢN DỰ TÍNH TỚI WINLINE QUA ZALO</h3>
      <button class="modal-close" onclick="closeRfqModal()">&times;</button>
    </div>
    <form id="rfqForm" onsubmit="handleRfqSubmit(event)">
      <div class="modal-body">
        <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
          Winline Việt Nam sẽ tiếp nhận bản dự tính <strong>#{{ $calculation->public_id }}</strong> để hỗ trợ kiểm tra kỹ thuật, khả năng cung ứng và gửi báo giá cạnh tranh nhất.
        </p>

        <div class="form-group">
          <label>Họ và tên của bạn <span style="color: red;">*</span></label>
          <input type="text" id="rfq_name" class="form-control" required value="{{ $calculation->customer_name }}" placeholder="Ví dụ: Nguyễn Văn A">
        </div>

        <div class="form-group">
          <label>Số điện thoại liên hệ (Zalo) <span style="color: red;">*</span></label>
          <input type="tel" id="rfq_phone" class="form-control" required value="{{ $calculation->customer_phone }}" placeholder="Ví dụ: 0912345678">
        </div>

        <div class="form-group">
          <label>Địa chỉ Email</label>
          <input type="email" id="rfq_email" class="form-control" value="{{ $calculation->customer_email }}" placeholder="Ví dụ: contact@company.com">
        </div>

        <div class="form-group">
          <label>Tên đơn vị / Doanh nghiệp</label>
          <input type="text" id="rfq_company" class="form-control" value="{{ $calculation->company_name }}" placeholder="Ví dụ: Công ty TNHH Cơ điện ABC">
        </div>

        <div class="form-group">
          <label>Mã số thuế (nếu cần xuất hóa đơn VAT)</label>
          <input type="text" id="rfq_tax" class="form-control" value="{{ $calculation->tax_code }}" placeholder="Mã số thuế doanh nghiệp">
        </div>

        <div class="form-group">
          <label>Ghi chú thêm về công trình</label>
          <textarea id="rfq_note" class="form-control" rows="2" placeholder="Ví dụ: Cần khảo sát tại KCN Quang Minh, Hà Nội...">{{ $calculation->customer_note }}</textarea>
        </div>

        <button type="submit" id="rfqSubmitBtn" class="btn-est btn-est-zalo" style="width: 100%; justify-content: center; padding: 12px; font-size: 15px;">
          <i class="fas fa-paper-plane"></i> Gửi dự tính &amp; Mở Zalo Winline
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function openRfqModal() {
    document.getElementById('rfqModal').classList.add('active');
  }

  function closeRfqModal() {
    document.getElementById('rfqModal').classList.remove('active');
  }

  function copySku(sku) {
    navigator.clipboard.writeText(sku).then(() => {
      alert('Đã sao chép mã SKU: ' + sku);
    }).catch(() => {
      prompt('Mã SKU:', sku);
    });
  }

  function copyShareUrl() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
      const btn = document.getElementById('copyShareBtn');
      const origText = btn.innerHTML;
      btn.innerHTML = '<i class="fas fa-check"></i> Đã sao chép liên kết!';
      setTimeout(() => { btn.innerHTML = origText; }, 2500);
    }).catch(() => {
      prompt('Đường dẫn bản dự tính:', url);
    });
  }

  function handleRfqSubmit(e) {
    e.preventDefault();
    const btn = document.getElementById('rfqSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';

    const payload = {
      customer_name: document.getElementById('rfq_name').value,
      customer_phone: document.getElementById('rfq_phone').value,
      customer_email: document.getElementById('rfq_email').value,
      company_name: document.getElementById('rfq_company').value,
      tax_code: document.getElementById('rfq_tax').value,
      customer_note: document.getElementById('rfq_note').value,
    };

    fetch('{{ route("client.calculator.submit", ["locale" => app()->getLocale(), "publicId" => $calculation->public_id]) }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-paper-plane"></i> Gửi dự tính & Mở Zalo Winline';
      if (data.success) {
        closeRfqModal();
        alert('Cảm ơn bạn! Thông tin bản dự tính đã được chuyển tới bộ phận kỹ thuật Winline Việt Nam.');
        if (data.zalo_url) {
          window.open(data.zalo_url, '_blank');
        }
        window.location.reload();
      } else {
        alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
      }
    })
    .catch(err => {
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-paper-plane"></i> Gửi dự tính & Mở Zalo Winline';
      console.error(err);
      alert('Không thể kết nối máy chủ, vui lòng thử lại.');
    });
  }
</script>
@endpush
