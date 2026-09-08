<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bản dự tính lựa chọn quạt #{{ $calculation->public_id }} - Winline Việt Nam</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('client-assets/images/favicon.ico') }}">
  <style>
    :root {
      --primary: #00354f;
      --primary-light: #004e7d;
      --accent: #d41e3d;
      --dark: #1e293b;
      --gray-50: #f8fafc;
      --gray-100: #f1f5f9;
      --gray-200: #e2e8f0;
      --gray-400: #94a3b8;
      --gray-600: #475569;
      --green: #16a34a;
      --green-bg: #dcfce7;
      --yellow: #ca8a04;
      --yellow-bg: #fef9c3;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      font-size: 13px;
      line-height: 1.5;
      color: var(--dark);
      background-color: #f1f5f9;
      padding: 24px 12px;
    }

    .toolbar {
      max-width: 820px;
      margin: 0 auto 20px auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ffffff;
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .toolbar-title {
      font-weight: 600;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      font-size: 13px;
      font-weight: 600;
      border-radius: 6px;
      border: 1px solid transparent;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s;
    }

    .btn-primary {
      background: var(--primary);
      color: #ffffff;
    }
    .btn-primary:hover {
      background: var(--primary-light);
    }

    .btn-outline {
      background: #ffffff;
      border-color: var(--gray-200);
      color: var(--gray-600);
    }
    .btn-outline:hover {
      background: var(--gray-50);
      color: var(--primary);
    }

    .btn-accent {
      background: var(--accent);
      color: #ffffff;
    }

    .document-page {
      max-width: 820px;
      margin: 0 auto;
      background: #ffffff;
      padding: 36px 40px;
      border-radius: 8px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    /* Header */
    .doc-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 2px solid var(--primary);
      padding-bottom: 18px;
      margin-bottom: 20px;
    }

    .company-info h1 {
      font-size: 18px;
      font-weight: 800;
      color: var(--primary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 4px;
    }

    .company-meta {
      font-size: 11.5px;
      color: var(--gray-600);
      line-height: 1.6;
    }

    .doc-badge {
      text-align: right;
    }

    .doc-badge .badge-id {
      display: inline-block;
      background: var(--primary-light);
      color: #ffffff;
      font-weight: 700;
      font-size: 13px;
      padding: 4px 10px;
      border-radius: 4px;
      margin-bottom: 4px;
      letter-spacing: 0.5px;
    }

    .doc-badge .badge-date {
      font-size: 11px;
      color: var(--gray-400);
    }

    /* Title */
    .doc-title-block {
      text-align: center;
      margin-bottom: 24px;
    }

    .doc-title {
      font-size: 19px;
      font-weight: 800;
      color: var(--primary);
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .doc-subtitle {
      font-size: 12.5px;
      color: var(--gray-600);
      font-style: italic;
    }

    /* Section Grid */
    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 20px;
    }

    .card {
      background: var(--gray-50);
      border: 1px solid var(--gray-200);
      border-radius: 6px;
      padding: 14px 16px;
    }

    .card-title {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--primary);
      margin-bottom: 8px;
      padding-bottom: 4px;
      border-bottom: 1px dashed var(--gray-200);
      display: flex;
      justify-content: space-between;
    }

    .info-list {
      list-style: none;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      padding: 3px 0;
    }

    .info-label {
      color: var(--gray-600);
    }

    .info-value {
      font-weight: 600;
      color: var(--dark);
      text-align: right;
    }

    /* Tables */
    .section-title {
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--primary);
      margin: 20px 0 10px 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 16px;
      font-size: 12px;
    }

    .data-table th {
      background: var(--primary);
      color: #ffffff;
      padding: 8px 10px;
      font-weight: 600;
      text-align: left;
      border: 1px solid var(--primary);
    }

    .data-table td {
      padding: 8px 10px;
      border: 1px solid var(--gray-200);
      vertical-align: middle;
    }

    .data-table tbody tr:nth-child(even) {
      background-color: var(--gray-50);
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .font-semibold { font-weight: 600; }

    .sku-badge {
      display: inline-block;
      font-weight: 700;
      color: var(--primary);
      font-family: monospace;
      font-size: 12px;
    }

    .product-thumb {
      width: 36px;
      height: 36px;
      object-fit: cover;
      border-radius: 4px;
      border: 1px solid var(--gray-200);
      vertical-align: middle;
      margin-right: 6px;
    }

    /* Tolerance Callout */
    .tolerance-box {
      padding: 10px 14px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .tolerance-box.success {
      background: var(--green-bg);
      border: 1px solid #86efac;
      color: #14532d;
    }

    .tolerance-box.warning {
      background: var(--yellow-bg);
      border: 1px solid #fde047;
      color: #713f12;
    }

    /* Total Summary Box */
    .total-box {
      background: var(--gray-50);
      border: 2px solid var(--primary);
      border-radius: 8px;
      padding: 16px 20px;
      margin: 20px 0;
    }

    .total-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
      padding: 4px 0;
    }

    .total-row.grand-total {
      border-top: 1px dashed var(--gray-400);
      margin-top: 8px;
      padding-top: 10px;
      font-size: 17px;
      font-weight: 800;
      color: var(--accent);
    }

    /* Disclaimers */
    .disclaimer-box {
      background: var(--gray-50);
      border-left: 3px solid var(--gray-400);
      padding: 10px 14px;
      margin-bottom: 24px;
      font-size: 11px;
      color: var(--gray-600);
      line-height: 1.5;
    }

    .disclaimer-box p {
      margin-bottom: 4px;
    }
    .disclaimer-box p:last-child {
      margin-bottom: 0;
    }

    /* Verification & Signatures */
    .footer-section {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: 24px;
      padding-top: 16px;
      border-top: 1px solid var(--gray-200);
    }

    .qr-block {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .qr-img {
      width: 68px;
      height: 68px;
      border: 1px solid var(--gray-200);
      border-radius: 4px;
      padding: 2px;
      background: #ffffff;
    }

    .qr-info {
      font-size: 11px;
      color: var(--gray-600);
    }
    .qr-info a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      word-break: break-all;
    }

    .signature-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      text-align: center;
      width: 320px;
    }

    .sig-title {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--primary);
    }

    .sig-subtitle {
      font-size: 10.5px;
      color: var(--gray-400);
      margin-top: 2px;
    }

    .sig-space {
      height: 60px;
    }

    /* Print Styles */
    @media print {
      body {
        background: #ffffff;
        padding: 0;
      }
      .no-print {
        display: none !important;
      }
      .document-page {
        box-shadow: none;
        padding: 0;
        max-width: 100%;
        margin: 0;
      }
      @page {
        size: A4 portrait;
        margin: 12mm 15mm;
      }
    }
  </style>
</head>
<body>

  <!-- Toolbar (hidden when printing) -->
  <div class="toolbar no-print">
    <div class="toolbar-title">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
      <span>Bản dự tính #{{ $calculation->public_id }}</span>
    </div>
    <div style="display: flex; gap: 8px;">
      <a href="{{ route('client.calculator.estimation', ['locale' => app()->getLocale(), 'publicId' => $calculation->public_id]) }}" class="btn btn-outline">
        ← Xem trực tuyến
      </a>
      <button onclick="window.print()" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        In / Lưu PDF (A4)
      </button>
    </div>
  </div>

  <div class="document-page">
    <!-- Header -->
    <div class="doc-header">
      <div class="company-info">
        <h1>CÔNG TY TNHH WINLINE VIỆT NAM</h1>
        <div class="company-meta">
          <div>Trụ sở: Số 17, ngõ 46, phố Quan Nhân, P. Trung Hòa, Q. Cầu Giấy, TP. Hà Nội</div>
          <div>Mã số thuế: <strong>0106085370</strong> &nbsp;|&nbsp; Hotline: <strong>0949.761.888 / 0963.230.665</strong></div>
          <div>Website: <strong>https://winline.vn</strong> &nbsp;|&nbsp; Email: <strong>kd@winline.vn</strong></div>
        </div>
      </div>
      <div class="doc-badge">
        <div class="badge-id">{{ $calculation->public_id }}</div>
        <div class="badge-date">{{ $calculation->created_at->format('d/m/Y H:i') }}</div>
      </div>
    </div>

    <!-- Title -->
    <div class="doc-title-block">
      <div class="doc-title">BẢN DỰ TÍNH LỰA CHỌN THIẾT BỊ THÔNG GIÓ</div>
      <div class="doc-subtitle">
        @if($calculation->tab === 'cooling-pad')
          Hệ thống làm mát áp suất âm quạt hút kết hợp Cooling Pad
        @elseif($calculation->tab === 'thong-gio-phong')
          Hệ thống thông gió văn phòng, phòng ngủ, bếp & phòng vệ sinh (WC)
        @else
          Hệ thống thông gió tổng thể & hút khí công nghiệp
        @endif
      </div>
    </div>

    <!-- 2 Column Info Grid: Customer & Technical Inputs -->
    <div class="grid-2">
      <!-- Customer Information -->
      <div class="card">
        <div class="card-title">
          <span>Thông tin người lập / Khách hàng</span>
        </div>
        <ul class="info-list">
          <li class="info-item">
            <span class="info-label">Người liên hệ:</span>
            <span class="info-value">{{ $calculation->customer_name ?: 'Khách hàng tham khảo trực tuyến' }}</span>
          </li>
          <li class="info-item">
            <span class="info-label">Số điện thoại:</span>
            <span class="info-value">{{ $calculation->customer_phone ?: '—' }}</span>
          </li>
          <li class="info-item">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $calculation->customer_email ?: '—' }}</span>
          </li>
          <li class="info-item">
            <span class="info-label">Đơn vị / Công ty:</span>
            <span class="info-value">{{ $calculation->company_name ?: '—' }}</span>
          </li>
          @if($calculation->tax_code)
          <li class="info-item">
            <span class="info-label">Mã số thuế:</span>
            <span class="info-value">{{ $calculation->tax_code }}</span>
          </li>
          @endif
        </ul>
      </div>

      <!-- Technical Inputs & Flow Requirements -->
      @php
        $inputs = $calculation->inputs ?? [];
        $results = $calculation->results ?? [];
      @endphp
      <div class="card">
        <div class="card-title">
          <span>Thông số không gian & Nhu cầu</span>
        </div>
        <ul class="info-list">
          <li class="info-item">
            <span class="info-label">Diện tích không gian:</span>
            <span class="info-value">{{ number_format($inputs['area'] ?? 0, 0, ',', '.') }} m²</span>
          </li>
          <li class="info-item">
            <span class="info-label">Chiều cao trung bình:</span>
            <span class="info-value">{{ number_format($inputs['height'] ?? 0, 1, ',', '.') }} m</span>
          </li>
          <li class="info-item">
            <span class="info-label">Thể tích không gian:</span>
            <span class="info-value">{{ number_format($inputs['volume'] ?? (($inputs['area'] ?? 0) * ($inputs['height'] ?? 0)), 0, ',', '.') }} m³</span>
          </li>
          <li class="info-item">
            <span class="info-label">Bội số trao đổi khí:</span>
            <span class="info-value">{{ $inputs['boiso'] ?? '—' }} lần/h</span>
          </li>
          <li class="info-item">
            <span class="info-label">Lưu lượng gió cần:</span>
            <span class="info-value" style="color: var(--primary); font-size: 13px;">
              <strong>{{ number_format($results['required_airflow'] ?? 0, 0, ',', '.') }} m³/h</strong>
            </span>
          </li>
          <li class="info-item">
            <span class="info-label">Nguồn điện sử dụng:</span>
            <span class="info-value">{{ $inputs['voltage'] ?? 'Tất cả' }}</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Table 1: Selected Fans -->
    @php
      $items = $calculation->selected_items['items'] ?? ($calculation->selected_items['fans'] ?? []);
      if (empty($items) && is_array($calculation->selected_items) && isset($calculation->selected_items[0])) {
          $items = $calculation->selected_items;
      }
      $hasFans = !empty($items);
    @endphp

    <div class="section-title">
      <span>1. Thiết bị quạt đã chọn</span>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 36px;" class="text-center">STT</th>
          <th style="width: 110px;">Mã SKU</th>
          <th>Tên sản phẩm & Thông số</th>
          <th style="width: 85px;">Hãng</th>
          <th style="width: 90px;" class="text-right">Lưu lượng</th>
          <th style="width: 50px;" class="text-center">SL</th>
          <th style="width: 95px;" class="text-right">Đơn giá</th>
          <th style="width: 105px;" class="text-right">Thành tiền</th>
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
            <td class="text-center">{{ $idx + 1 }}</td>
            <td>
              <span class="sku-badge">{{ $item['sku'] ?? '—' }}</span>
              @if(!empty($item['is_primary']))
                <div style="font-size: 9.5px; color: var(--primary-light); font-weight: 600;">(Dòng chính)</div>
              @endif
            </td>
            <td>
              <div class="font-semibold">{{ $item['name'] ?? $item['sku'] }}</div>
              <div style="font-size: 11px; color: var(--gray-600);">
                {{ $item['fan_type'] ?? '' }}
                @if(!empty($item['size_display'])) · KT: {{ $item['size_display'] }} @endif
                @if(!empty($item['power'])) · CS: {{ $item['power'] }} @endif
                @if(!empty($item['voltage'])) · Điện: {{ $item['voltage'] }} @endif
              </div>
            </td>
            <td>{{ $item['brand_name'] ?? ($item['brand'] ?? 'Winline') }}</td>
            <td class="text-right font-semibold">{{ number_format($flow, 0, ',', '.') }} m³/h</td>
            <td class="text-center font-semibold" style="font-size: 13px;">{{ $qty }}</td>
            <td class="text-right">{{ number_format($price, 0, ',', '.') }} đ</td>
            <td class="text-right font-semibold" style="color: var(--primary);">{{ number_format($subtotal, 0, ',', '.') }} đ</td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center" style="padding: 16px; color: var(--gray-600);">
              Chưa chọn thiết bị quạt cụ thể.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <!-- Table 2: Cooling Pads (if Tab 2) -->
    @if($calculation->tab === 'cooling-pad')
      @php
        $coolingPads = $calculation->selected_items['cooling_pads'] ?? [];
        $padData = $calculation->results['cooling_pads'] ?? [];
        $nominalArea = $results['nominal_pad_area'] ?? ($padData['required_pad_area'] ?? 0);
      @endphp
      <div class="section-title">
        <span>2. Tấm làm mát Cooling Pad (Năng suất cơ sở: 9.000 m³/h/m²)</span>
      </div>

      <table class="data-table">
        <thead>
          <tr>
            <th style="width: 36px;" class="text-center">STT</th>
            <th style="width: 140px;">Mã / Quy cách</th>
            <th>Tên sản phẩm & Kích thước</th>
            <th style="width: 100px;" class="text-center">DT 1 tấm</th>
            <th style="width: 50px;" class="text-center">SL</th>
            <th style="width: 90px;" class="text-right">Tổng DT</th>
            <th style="width: 95px;" class="text-right">Đơn giá</th>
            <th style="width: 105px;" class="text-right">Thành tiền</th>
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
              <td class="text-center">{{ $pIdx + 1 }}</td>
              <td><span class="sku-badge">{{ $pad['sku'] ?? 'COOLING-PAD' }}</span></td>
              <td>
                <div class="font-semibold">{{ $pad['name'] ?? 'Tấm làm mát Cooling Pad' }}</div>
                <div style="font-size: 11px; color: var(--gray-600);">
                  Kích thước: {{ $pad['dimensions'] ?? '1800x600x150mm' }} (Độ dày 150mm tiêu chuẩn, khung mua riêng)
                </div>
              </td>
              <td class="text-center">{{ number_format($pAreaUnit, 2, ',', '.') }} m²</td>
              <td class="text-center font-semibold" style="font-size: 13px;">{{ $pQty }}</td>
              <td class="text-right font-semibold">{{ number_format($pTotalArea, 2, ',', '.') }} m²</td>
              <td class="text-right">{{ number_format($pPrice, 0, ',', '.') }} đ</td>
              <td class="text-right font-semibold" style="color: var(--primary);">{{ number_format($pSubtotal, 0, ',', '.') }} đ</td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center" style="padding: 12px; color: var(--gray-600);">
                Diện tích cooling pad tính toán theo lưu lượng quạt thực chọn: <strong>{{ number_format($nominalArea, 2, ',', '.') }} m²</strong> (chưa chọn quy cách tấm cụ thể).
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    @endif

    <!-- Tolerance & Selection Status Indicator -->
    @php
      $deltaPercent = (float) ($results['delta_percent'] ?? 0);
      $isInTol = abs($deltaPercent) <= 5.0;
      $totalFanFlow = (float) ($results['total_actual_airflow'] ?? 0);
      $neededFlow = (float) ($results['required_airflow'] ?? 0);
    @endphp
    <div class="tolerance-box {{ $isInTol ? 'success' : 'warning' }}">
      <div>
        <strong>Đối soát kỹ thuật lưu lượng:</strong>
        Lưu lượng quạt thực chọn: <strong>{{ number_format($totalFanFlow, 0, ',', '.') }} m³/h</strong>
        / Nhu cầu: <strong>{{ number_format($neededFlow, 0, ',', '.') }} m³/h</strong>
        (Độ lệch: <strong>{{ ($deltaPercent >= 0 ? '+' : '') . number_format($deltaPercent, 1, ',', '.') }}%</strong>).
      </div>
      <div>
        @if($isInTol)
          <span style="font-weight: 700;">✓ Trong khoảng dự tính ±5%</span>
        @else
          <span style="font-weight: 700;">⚠ Cần lưu ý điều chỉnh số lượng</span>
        @endif
      </div>
    </div>

    <!-- Total Cost Summary -->
    @php
      $grandTotal = (float) ($results['grand_total'] ?? ($results['total_price'] ?? 0));
      $fanTotal = (float) ($results['total_price'] ?? 0);
      $padTotal = (float) ($results['total_pad_price'] ?? ($grandTotal - $fanTotal));
    @endphp
    <div class="total-box">
      <div class="total-row">
        <span>Tổng chi phí quạt thông gió:</span>
        <span class="font-semibold">{{ number_format($fanTotal, 0, ',', '.') }} đ</span>
      </div>
      @if($calculation->tab === 'cooling-pad' && $padTotal > 0)
      <div class="total-row">
        <span>Tổng chi phí tấm làm mát Cooling Pad:</span>
        <span class="font-semibold">{{ number_format($padTotal, 0, ',', '.') }} đ</span>
      </div>
      @endif
      <div class="total-row grand-total">
        <span>TỔNG KINH PHÍ DỰ TÍNH (THAM KHẢO):</span>
        <span>{{ number_format($grandTotal, 0, ',', '.') }} VNĐ</span>
      </div>
    </div>

    <!-- Disclaimers and Pricing Policies -->
    <div class="disclaimer-box">
      <p><strong>Ghi chú đơn giá:</strong> Đơn giá và tổng tiền là giá tham khảo tại thời điểm lập bản dự tính; có thể thay đổi theo số lượng đặt hàng, điều kiện giao hàng, chính sách ưu đãi của hãng và chưa bao gồm thuế GTGT (VAT) cũng như chi phí thi công lắp đặt hoàn thiện.</p>
      <p><strong>Khuyến cáo kỹ thuật:</strong> Kết quả trên là bản dự tính ban đầu dựa trên dữ liệu người dùng cung cấp và thông số chuẩn của thiết bị. Tổn thất áp suất đường ống dẫn khí, vị trí cấp/thoát gió, nguồn nhiệt phát sinh tại chỗ và điều kiện thực tế công trình có thể ảnh hưởng đến hiệu suất thông gió. Đối với các công trình quy mô lớn hoặc yêu cầu đặc thù, kính mời quý khách liên hệ trực tiếp đội ngũ kỹ thuật Winline Việt Nam để khảo sát mặt bằng và tư vấn phương án tối ưu nhất.</p>
    </div>

    <!-- Signatures & Verification -->
    <div class="footer-section">
      <div class="qr-block">
        <img class="qr-img" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('client.calculator.estimation', ['locale' => app()->getLocale(), 'publicId' => $calculation->public_id])) }}" alt="QR Code">
        <div class="qr-info">
          <div>Quét mã QR hoặc truy cập đường dẫn:</div>
          <div><a href="{{ route('client.calculator.estimation', ['locale' => app()->getLocale(), 'publicId' => $calculation->public_id]) }}" target="_blank">{{ route('client.calculator.estimation', ['locale' => app()->getLocale(), 'publicId' => $calculation->public_id]) }}</a></div>
          <div style="color: var(--gray-400); margin-top: 2px;">Để đối soát và cập nhật bản dự tính theo dữ liệu mới nhất.</div>
        </div>
      </div>

      <div class="signature-grid">
        <div>
          <div class="sig-title">ĐẠI DIỆN KHÁCH HÀNG</div>
          <div class="sig-subtitle">(Ký, ghi rõ họ tên)</div>
          <div class="sig-space"></div>
        </div>
        <div>
          <div class="sig-title">WINLINE VIỆT NAM</div>
          <div class="sig-subtitle">(Phòng dự án & Bán hàng)</div>
          <div class="sig-space"></div>
        </div>
      </div>
    </div>
  </div>

  @if(request()->query('print') == '1')
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => { window.print(); }, 500);
    });
  </script>
  @endif

</body>
</html>
