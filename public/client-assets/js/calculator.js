/**
 * Winline Vietnam - HVAC Fan & Cooling Pad Sizing Calculator
 * Master specifications according to Winline v05 & Website Maps
 */

(function () {
  'use strict';

  const cfg = window.CALC_CONFIG || {
    locale: 'vi',
    initialTab: 'thong-gio-hut-khi',
    coolingVelocity: 9000,
    urls: { products: '', balance: '', save: '' },
    padCatalog: []
  };

  // Application State
  const state = {
    tab: cfg.initialTab || 'thong-gio-hut-khi',
    area: 3000,
    height: 3.0,
    boiso: 20,
    voltage: '380V',
    spaceType: 'nha_xuong',
    volume: 9000,
    requiredAirflow: 180000,
    nominalPadArea: 0,
    candidateFans: [],
    selectedItems: [], // Up to 3 fan items
    selectedPads: [],  // Selected cooling pads for Tab 2
    deltaPercent: 0,
    isInTolerance: false,
    totalFanFlow: 0,
    fanTotalPrice: 0,
    padTotalPrice: 0,
    grandTotal: 0,
  };

  // Helper: Format Vietnamese Currency
  function formatVnd(val) {
    return new Intl.NumberFormat('vi-VN').format(Math.round(val)) + ' đ';
  }

  // Helper: Format Number
  function formatNum(val, decimals = 0) {
    return new Intl.NumberFormat('vi-VN', {
      minimumFractionDigits: decimals,
      maximumFractionDigits: decimals
    }).format(val);
  }

  // Helper: Copy Text to Clipboard with visual alert
  window.copySku = function (sku, btnElement) {
    if (!sku) return;
    navigator.clipboard.writeText(sku).then(() => {
      if (btnElement) {
        const origHtml = btnElement.innerHTML;
        btnElement.innerHTML = '<i class="fas fa-check" style="color: green;"></i>';
        setTimeout(() => { btnElement.innerHTML = origHtml; }, 2000);
      } else {
        alert('Đã sao chép mã SKU: ' + sku);
      }
    }).catch(() => {
      prompt('Mã SKU:', sku);
    });
  };

  // 1. Initialize Inputs based on Current Tab
  function initInputsForTab() {
    const areaInp = document.getElementById('input_area');
    const heightInp = document.getElementById('input_height');
    const boisoInp = document.getElementById('input_boiso');
    const lblArea = document.getElementById('lbl_area');

    if (state.tab === 'cooling-pad') {
      if (lblArea) lblArea.textContent = 'Diện tích xưởng cần làm mát (m²)';
      state.area = parseFloat(areaInp.value) || 200;
      state.height = parseFloat(heightInp.value) || 6.0;
      state.boiso = parseFloat(boisoInp.value) || 60;
    } else if (state.tab === 'thong-gio-phong') {
      if (lblArea) lblArea.textContent = 'Diện tích phòng / sàn (m²)';
      state.area = parseFloat(areaInp.value) || 50;
      state.height = parseFloat(heightInp.value) || 3.0;
      const spSelect = document.getElementById('select_space_type');
      if (spSelect) {
        const opt = spSelect.options[spSelect.selectedIndex];
        state.boiso = parseFloat(opt.getAttribute('data-ach')) || 6;
      } else {
        state.boiso = 6;
      }
    } else {
      if (lblArea) lblArea.textContent = 'Diện tích không gian (m²)';
      state.area = parseFloat(areaInp.value) || 3000;
      state.height = parseFloat(heightInp.value) || 3.0;
      state.boiso = parseFloat(boisoInp.value) || 20;
    }

    areaInp.value = state.area;
    heightInp.value = state.height;
    boisoInp.value = state.boiso;

    calculateFlow();
  }

  // 2. Calculate Airflow & Volume
  function calculateFlow() {
    const area = Math.max(0, parseFloat(document.getElementById('input_area').value) || 0);
    const height = Math.max(0, parseFloat(document.getElementById('input_height').value) || 0);
    const boiso = Math.max(0, parseFloat(document.getElementById('input_boiso').value) || 0);

    state.area = area;
    state.height = height;
    state.boiso = boiso;

    state.volume = Math.round(area * height);
    state.requiredAirflow = Math.round(state.volume * boiso);

    // Update Metrics
    const volEl = document.getElementById('metric_volume');
    if (volEl) volEl.innerHTML = `${formatNum(state.volume)} <small>m³</small>`;

    const flowEl = document.getElementById('metric_airflow');
    if (flowEl) flowEl.innerHTML = `${formatNum(state.requiredAirflow)} <small>m³/h</small>`;

    // Tab 2 Nominal Pad Area: Q / 9000
    if (state.tab === 'cooling-pad') {
      state.nominalPadArea = state.requiredAirflow > 0 ? (state.requiredAirflow / cfg.coolingVelocity).toFixed(2) : '0.00';
      const padEl = document.getElementById('metric_pad_area');
      if (padEl) padEl.innerHTML = `${formatNum(state.nominalPadArea, 2)} <small>m²</small>`;
    }

    rebalanceSelection();
  }

  window.onInputChange = function () {
    calculateFlow();
    fetchProducts();
  };

  // 3. Preset ACH chips & Voltage
  window.setBoiso = function (val, el) {
    document.getElementById('input_boiso').value = val;
    const parent = el.closest('.preset-chips');
    if (parent) {
      parent.querySelectorAll('.preset-chip').forEach(c => c.classList.remove('active'));
      el.classList.add('active');
    }
    window.onInputChange();
  };

  window.onSpaceTypeChange = function (val) {
    state.spaceType = val;
    const spSelect = document.getElementById('select_space_type');
    const opt = spSelect.options[spSelect.selectedIndex];
    const ach = parseFloat(opt.getAttribute('data-ach')) || 6;
    document.getElementById('input_boiso').value = ach;
    window.onInputChange();
  };

  window.setVoltage = function (v, el) {
    state.voltage = v;
    document.querySelectorAll('.voltage-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    fetchProducts();
  };

  // 4. Tab Switching
  window.switchTab = function (tabKey) {
    if (state.tab === tabKey) return;
    state.tab = tabKey;

    // Update URL query without reload
    const newUrl = window.location.pathname + '?tab=' + tabKey;
    window.history.pushState({ tab: tabKey }, '', newUrl);

    // Tab button classes
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.classList.toggle('active', btn.getAttribute('onclick').includes(tabKey));
    });

    // Show/hide presets
    document.querySelectorAll('.tab-preset-group').forEach(p => p.style.display = 'none');
    if (tabKey === 'thong-gio-hut-khi') {
      const p1 = document.getElementById('presets_tab1');
      if (p1) p1.style.display = 'flex';
      document.getElementById('th_size').textContent = 'Kích thước';
      document.getElementById('lbl_filter_size').textContent = 'Kích thước';
      document.getElementById('cooling_pad_metrics').style.display = 'none';
      document.getElementById('cooling_pad_section').style.display = 'none';
      document.getElementById('input_area').value = 3000;
      document.getElementById('input_height').value = 3.0;
      document.getElementById('input_boiso').value = 20;
    } else if (tabKey === 'cooling-pad') {
      const p2 = document.getElementById('presets_tab2');
      if (p2) p2.style.display = 'flex';
      document.getElementById('th_size').textContent = 'Kích thước';
      document.getElementById('lbl_filter_size').textContent = 'Kích thước';
      document.getElementById('cooling_pad_metrics').style.display = 'block';
      document.getElementById('cooling_pad_section').style.display = 'block';
      document.getElementById('input_area').value = 200;
      document.getElementById('input_height').value = 6.0;
      document.getElementById('input_boiso').value = 60;
    } else if (tabKey === 'thong-gio-phong') {
      const p3 = document.getElementById('presets_tab3');
      if (p3) p3.style.display = 'block';
      document.getElementById('th_size').textContent = 'KT Lỗ chờ';
      document.getElementById('lbl_filter_size').textContent = 'Kích thước lỗ chờ';
      document.getElementById('cooling_pad_metrics').style.display = 'none';
      document.getElementById('cooling_pad_section').style.display = 'none';
      document.getElementById('input_area').value = 50;
      document.getElementById('input_height').value = 3.0;
      document.getElementById('input_boiso').value = 6;
    }

    state.selectedItems = [];
    state.selectedPads = [];
    initInputsForTab();
    fetchProducts();
  };

  // 5. Fetch Candidate Products via API
  window.fetchProducts = function () {
    const brand = document.getElementById('filter_brand')?.value || '';
    const fanType = document.getElementById('filter_fan_type')?.value || '';
    const size = document.getElementById('filter_size')?.value || '';
    const priceRange = document.getElementById('filter_price')?.value || '';

    const params = new URLSearchParams({
      tab: state.tab,
      required_airflow: state.requiredAirflow,
      voltage: state.voltage,
      brand: brand,
      fan_type: fanType,
      size: size,
      price_range: priceRange
    });

    fetch(cfg.urls.products + '?' + params.toString())
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          state.candidateFans = data.products || [];
          renderProductsTable();
          updateFilterDropdowns(data.filter_options);
        }
      })
      .catch(err => console.error('Error fetching fans:', err));
  };

  // Update filter dropdowns if options changed
  function updateFilterDropdowns(options) {
    if (!options) return;
    const brandSel = document.getElementById('filter_brand');
    const typeSel = document.getElementById('filter_fan_type');
    const sizeSel = document.getElementById('filter_size');

    if (brandSel && brandSel.options.length <= 1) {
      options.brands.forEach(b => {
        const opt = new Option(b.name, b.slug);
        brandSel.add(opt);
      });
    }
    if (typeSel && typeSel.options.length <= 1) {
      options.fan_types.forEach(t => {
        const opt = new Option(t, t);
        typeSel.add(opt);
      });
    }
    if (sizeSel && sizeSel.options.length <= 1) {
      options.sizes.forEach(s => {
        const opt = new Option(s, s);
        sizeSel.add(opt);
      });
    }
  }

  // Reset Filters
  window.resetFilters = function () {
    document.getElementById('filter_brand').value = '';
    document.getElementById('filter_fan_type').value = '';
    document.getElementById('filter_size').value = '';
    document.getElementById('filter_price').value = 'all';
    fetchProducts();
  };

  // 6. Render 10-Column Desktop Table / Cards
  function renderProductsTable() {
    const tbody = document.getElementById('fans_tbody');
    if (!tbody) return;

    if (state.candidateFans.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="10" style="text-align: center; padding: 28px; color: #64748b;">
            Không tìm thấy sản phẩm quạt nào phù hợp với bộ lọc và thông số hiện tại.
          </td>
        </tr>
      `;
      return;
    }

    let html = '';
    state.candidateFans.forEach(fan => {
      const isSelected = state.selectedItems.some(i => i.sku === fan.sku);
      const rowClass = isSelected ? 'is-selected' : '';
      const sizeVal = (state.tab === 'thong-gio-phong') ? fan.hole_size : fan.size_display;

      html += `
        <tr class="${rowClass}">
          <!-- 1. Ảnh -->
          <td style="text-align: center;">
            <img src="${fan.image_url}" alt="${fan.name}" class="fan-thumb" onerror="this.src='/client-assets/images/km-vuong-1380.jpg'">
          </td>

          <!-- 2. Tên & SKU -->
          <td>
            <a href="${fan.detail_url}" target="_blank" style="font-weight: 700; color: #004e7d; text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.35;">
              ${fan.name}
            </a>
            <div class="sku-line">
              <span>${fan.sku}</span>
              <button type="button" class="copy-sku-btn" onclick="copySku('${fan.sku}', this)" title="Sao chép SKU">
                <i class="far fa-copy"></i>
              </button>
            </div>
          </td>

          <!-- 3. Thương hiệu -->
          <td><strong>${fan.brand_name}</strong></td>

          <!-- 4. Loại sản phẩm -->
          <td><span style="font-size: 12px; color: #475569;">${fan.fan_type}</span></td>

          <!-- 5. Kích thước / Lỗ chờ -->
          <td><span style="font-size: 12px; font-weight: 600;">${sizeVal}</span></td>

          <!-- 6. Công suất -->
          <td><span style="font-size: 12px;">${fan.power}</span></td>

          <!-- 7. Lưu lượng -->
          <td style="text-align: right; font-weight: 700; color: #004e7d;">
            ${formatNum(fan.airflow)} m³/h
          </td>

          <!-- 8. SL dự tính -->
          <td style="text-align: center; font-weight: 800; font-size: 14px;">
            ${fan.estimated_qty}
          </td>

          <!-- 9. Đơn giá -->
          <td style="text-align: right; font-weight: 600;">
            ${formatVnd(fan.unit_price)}
          </td>

          <!-- 10. Nút Chọn -->
          <td style="text-align: center;">
            <button type="button" class="btn-select-product ${isSelected ? 'selected' : ''}" onclick="toggleSelectFan('${fan.sku}')">
              ${isSelected ? '✓ Đã chọn' : '+ Chọn'}
            </button>
          </td>
        </tr>
      `;
    });

    tbody.innerHTML = html;
  }

  // 7. Toggle Fan Selection (Max 3 items, Primary auto-balances)
  window.toggleSelectFan = function (sku) {
    const existingIndex = state.selectedItems.findIndex(i => i.sku === sku);

    if (existingIndex >= 0) {
      // Remove item
      const removedWasPrimary = state.selectedItems[existingIndex].is_primary;
      state.selectedItems.splice(existingIndex, 1);

      // If removed item was primary, designate first remaining as primary
      if (removedWasPrimary && state.selectedItems.length > 0) {
        state.selectedItems[0].is_primary = true;
      }
    } else {
      // Check max 3 items
      if (state.selectedItems.length >= 3) {
        alert('⚠️ Bạn chỉ được chọn tối đa 3 loại quạt để phối hợp công suất trong một bản dự tính.');
        return;
      }

      const fan = state.candidateFans.find(f => f.sku === sku);
      if (!fan) return;

      const isFirst = state.selectedItems.length === 0;
      state.selectedItems.push({
        id: fan.id,
        sku: fan.sku,
        name: fan.name,
        slug: fan.slug,
        brand_name: fan.brand_name,
        fan_type: fan.fan_type,
        size_display: fan.size_display,
        hole_size: fan.hole_size,
        power: fan.power,
        voltage: fan.voltage,
        airflow: fan.airflow,
        unit_price: fan.unit_price,
        quantity: isFirst ? fan.estimated_qty : 1,
        is_primary: isFirst
      });
    }

    rebalanceSelection();
    renderProductsTable();
  };

  // 8. Auto-balancing Selection Logic
  function rebalanceSelection() {
    const countEl = document.getElementById('selected_count');
    if (countEl) countEl.textContent = state.selectedItems.length;

    if (state.selectedItems.length === 0) {
      renderSelectedItemsList();
      renderCoolingPadTable();
      updateTotalsDisplay(0, 0, 0, false);
      return;
    }

    // Identify primary item
    let primaryIdx = state.selectedItems.findIndex(i => i.is_primary);
    if (primaryIdx < 0) {
      primaryIdx = 0;
      state.selectedItems[0].is_primary = true;
    }

    // Sum airflow of secondary items
    let secondaryFlow = 0;
    state.selectedItems.forEach((item, idx) => {
      if (idx !== primaryIdx) {
        item.is_primary = false;
        item.quantity = Math.max(1, parseInt(item.quantity) || 1);
        secondaryFlow += item.quantity * item.airflow;
      }
    });

    // Primary item balances remainder
    const primaryItem = state.selectedItems[primaryIdx];
    const neededForPrimary = Math.max(0, state.requiredAirflow - secondaryFlow);
    if (primaryItem.airflow > 0 && state.requiredAirflow > 0) {
      const balancedQty = Math.ceil(neededForPrimary / primaryItem.airflow);
      primaryItem.quantity = Math.max(1, balancedQty);
    } else {
      primaryItem.quantity = Math.max(1, parseInt(primaryItem.quantity) || 1);
    }

    // Calculate total fan airflow & total fan price
    let totalFlow = 0;
    let fanPrice = 0;
    state.selectedItems.forEach(item => {
      totalFlow += item.quantity * item.airflow;
      fanPrice += item.quantity * item.unit_price;
    });

    state.totalFanFlow = totalFlow;
    state.fanTotalPrice = fanPrice;

    // Delta %
    const deltaFlow = totalFlow - state.requiredAirflow;
    state.deltaPercent = state.requiredAirflow > 0
      ? ((deltaFlow / state.requiredAirflow) * 100).toFixed(1)
      : 0;
    state.isInTolerance = Math.abs(state.deltaPercent) <= 5.0;

    // Update Tolerance Callout
    const tolBox = document.getElementById('tolerance_box');
    const tolText = document.getElementById('tolerance_text');
    const tolBadge = document.getElementById('tolerance_badge');

    if (tolBox && tolText && tolBadge) {
      tolBox.style.display = 'flex';
      if (state.isInTolerance) {
        tolBox.className = 'tolerance-callout success';
        tolText.innerHTML = `Lưu lượng đã chọn: <strong>${formatNum(totalFlow)} m³/h</strong> / Nhu cầu: <strong>${formatNum(state.requiredAirflow)} m³/h</strong> (Độ lệch: <strong>+${state.deltaPercent}%</strong>).`;
        tolBadge.innerHTML = '✓ Nằm trong khoảng dự tính ±5%';
      } else {
        tolBox.className = 'tolerance-callout warning';
        tolText.innerHTML = `Lưu lượng đã chọn: <strong>${formatNum(totalFlow)} m³/h</strong> / Nhu cầu: <strong>${formatNum(state.requiredAirflow)} m³/h</strong> (Chênh lệch: <strong>${state.deltaPercent > 0 ? '+' : ''}${state.deltaPercent}%</strong>). Bạn có thể chỉnh lại số lượng hoặc tiếp tục lưu bản dự tính.`;
        tolBadge.innerHTML = '⚠ Ngoài ngưỡng ±5%';
      }
    }

    renderSelectedItemsList();
    renderCoolingPadTable();
    updateGrandTotal();
  }

  // Set Item as Primary
  window.setPrimaryItem = function (sku) {
    state.selectedItems.forEach(item => {
      item.is_primary = (item.sku === sku);
    });
    rebalanceSelection();
  };

  // Adjust Quantity
  window.changeItemQty = function (sku, delta) {
    const item = state.selectedItems.find(i => i.sku === sku);
    if (!item) return;

    const newQty = Math.max(1, (parseInt(item.quantity) || 1) + delta);
    item.quantity = newQty;

    // If changing secondary item, primary will auto-balance remainder
    // If changing primary item, we simply recalculate totals
    rebalanceSelection();
  };

  window.setItemQtyDirect = function (sku, val) {
    const item = state.selectedItems.find(i => i.sku === sku);
    if (!item) return;
    item.quantity = Math.max(1, parseInt(val) || 1);
    rebalanceSelection();
  };

  // Render Selected Fans List in Selection Panel
  function renderSelectedItemsList() {
    const container = document.getElementById('selected_items_list');
    if (!container) return;

    if (state.selectedItems.length === 0) {
      container.innerHTML = `
        <div style="text-align: center; padding: 18px; color: #64748b; font-size: 13px;">
          Chưa có sản phẩm nào được chọn. Nhấp "Chọn" tại bảng trên để thêm vào phương án (Tối đa 3 dòng).
        </div>
      `;
      const tolBox = document.getElementById('tolerance_box');
      if (tolBox) tolBox.style.display = 'none';
      return;
    }

    let html = '';
    state.selectedItems.forEach((item, idx) => {
      const subtotal = item.quantity * item.unit_price;
      const totalItemFlow = item.quantity * item.airflow;

      html += `
        <div class="selected-item-row ${item.is_primary ? 'is-primary' : ''}">
          <div style="flex: 1; padding-right: 12px;">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span class="sku-line">${item.sku}</span>
              <strong>${item.name}</strong>
              ${item.is_primary ? '<span style="font-size: 11px; background: #004e7d; color: #fff; padding: 2px 6px; border-radius: 4px; font-weight: 700;">DÒNG CHÍNH</span>' : ''}
            </div>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
              Lưu lượng: <strong>${formatNum(item.airflow)} m³/h/quạt</strong> &times; ${item.quantity} = <strong>${formatNum(totalItemFlow)} m³/h</strong> &middot;
              Đơn giá: ${formatVnd(item.unit_price)}
            </div>
          </div>

          <div style="display: flex; align-items: center; gap: 14px;">
            <!-- Stepper -->
            <div class="qty-stepper">
              <button type="button" class="qty-btn" onclick="changeItemQty('${item.sku}', -1)">-</button>
              <input type="number" class="qty-input" value="${item.quantity}" min="1" onchange="setItemQtyDirect('${item.sku}', this.value)">
              <button type="button" class="qty-btn" onclick="changeItemQty('${item.sku}', 1)">+</button>
            </div>

            <!-- Subtotal -->
            <div style="min-width: 100px; text-align: right; font-weight: 700; color: #004e7d;">
              ${formatVnd(subtotal)}
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 6px;">
              ${!item.is_primary ? `<button type="button" class="btn-select-product" style="padding: 4px 8px; font-size: 11px;" onclick="setPrimaryItem('${item.sku}')">Đặt dòng chính</button>` : ''}
              <button type="button" style="background: none; border: none; color: #ef4444; font-size: 16px; cursor: pointer; padding: 4px;" onclick="toggleSelectFan('${item.sku}')" title="Bỏ chọn">
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </div>
      `;
    });

    container.innerHTML = html;
  }

  // 9. Tab 2: Render Cooling Pad Table
  function renderCoolingPadTable() {
    if (state.tab !== 'cooling-pad') return;

    const tbody = document.getElementById('cooling_pad_tbody');
    const actualAreaEl = document.getElementById('actual_pad_area_needed');
    if (!tbody || !actualAreaEl) return;

    // Derived from SELECTED fans total airflow (or required airflow if none selected yet)
    const baseFlow = (state.totalFanFlow > 0) ? state.totalFanFlow : state.requiredAirflow;
    const padAreaNeeded = (baseFlow > 0) ? (baseFlow / cfg.coolingVelocity) : 0;
    actualAreaEl.textContent = formatNum(padAreaNeeded, 2);

    let html = '';
    (cfg.padCatalog || []).forEach(pad => {
      const areaPerPad = (pad.length * pad.width);
      const recommendedQty = (areaPerPad > 0 && padAreaNeeded > 0)
        ? Math.ceil(padAreaNeeded / areaPerPad)
        : 1;

      const isChosen = state.selectedPads.some(p => p.sku === pad.sku);
      const chosenItem = state.selectedPads.find(p => p.sku === pad.sku);
      const currentQty = isChosen ? chosenItem.quantity : recommendedQty;
      const totalArea = (currentQty * areaPerPad).toFixed(2);
      const subtotal = currentQty * pad.unit_price;

      html += `
        <tr class="${isChosen ? 'is-selected' : ''}">
          <td style="text-align: center;">
            <input type="checkbox" ${isChosen ? 'checked' : ''} onchange="toggleCoolingPad('${pad.sku}', this.checked, ${recommendedQty})">
          </td>
          <td>
            <strong>${pad.name}</strong>
            <div style="font-size: 11px; color: #64748b;">Mã: ${pad.sku} &middot; Dài ${pad.length}m &times; Rộng ${pad.width}m &times; Dày ${pad.thickness}mm</div>
          </td>
          <td style="text-align: center; font-weight: 600;">${areaPerPad.toFixed(2)} m²</td>
          <td style="text-align: center;">
            <div class="qty-stepper" style="display: inline-flex;">
              <button type="button" class="qty-btn" onclick="changePadQty('${pad.sku}', -1)">-</button>
              <input type="number" class="qty-input" value="${currentQty}" min="1" onchange="setPadQtyDirect('${pad.sku}', this.value)">
              <button type="button" class="qty-btn" onclick="changePadQty('${pad.sku}', 1)">+</button>
            </div>
          </td>
          <td style="text-align: right; font-weight: 700;">${totalArea} m²</td>
          <td style="text-align: right;">${formatVnd(pad.unit_price)}</td>
          <td style="text-align: right; font-weight: 700; color: #004e7d;">${formatVnd(subtotal)}</td>
        </tr>
      `;
    });

    tbody.innerHTML = html;
  }

  window.toggleCoolingPad = function (sku, isChecked, defaultQty) {
    const pad = (cfg.padCatalog || []).find(p => p.sku === sku);
    if (!pad) return;

    if (isChecked) {
      if (!state.selectedPads.some(p => p.sku === sku)) {
        state.selectedPads.push({
          sku: pad.sku,
          name: pad.name,
          length: pad.length,
          width: pad.width,
          thickness: pad.thickness,
          area_per_unit: (pad.length * pad.width),
          unit_price: pad.unit_price,
          quantity: defaultQty || 1,
          dimensions: `${pad.length * 1000}x${pad.width * 1000}x${pad.thickness}mm`
        });
      }
    } else {
      state.selectedPads = state.selectedPads.filter(p => p.sku !== sku);
    }

    renderCoolingPadTable();
    updateGrandTotal();
  };

  window.changePadQty = function (sku, delta) {
    const item = state.selectedPads.find(p => p.sku === sku);
    if (item) {
      item.quantity = Math.max(1, item.quantity + delta);
      renderCoolingPadTable();
      updateGrandTotal();
    } else {
      // If not yet checked, auto select with adjusted qty
      window.toggleCoolingPad(sku, true, Math.max(1, delta > 0 ? 2 : 1));
    }
  };

  window.setPadQtyDirect = function (sku, val) {
    const qty = Math.max(1, parseInt(val) || 1);
    const item = state.selectedPads.find(p => p.sku === sku);
    if (item) {
      item.quantity = qty;
      renderCoolingPadTable();
      updateGrandTotal();
    } else {
      window.toggleCoolingPad(sku, true, qty);
    }
  };

  // 10. Update Grand Total
  function updateGrandTotal() {
    let padPrice = 0;
    if (state.tab === 'cooling-pad') {
      state.selectedPads.forEach(p => {
        padPrice += p.quantity * p.unit_price;
      });
    }
    state.padTotalPrice = padPrice;
    state.grandTotal = state.fanTotalPrice + state.padTotalPrice;

    const totalEl = document.getElementById('grand_total_price');
    if (totalEl) totalEl.textContent = formatVnd(state.grandTotal);
  }

  function updateTotalsDisplay(flow, fanPrice, padPrice, inTol) {
    state.totalFanFlow = flow;
    state.fanTotalPrice = fanPrice;
    state.padTotalPrice = padPrice;
    state.grandTotal = fanPrice + padPrice;
    const totalEl = document.getElementById('grand_total_price');
    if (totalEl) totalEl.textContent = formatVnd(state.grandTotal);
  }

  // 11. Save Calculation Session to Backend
  window.saveEstimation = function (andOpenPdf = false, customerData = null, callback = null) {
    if (state.selectedItems.length === 0) {
      if (!confirm('Bạn chưa chọn model quạt nào vào phương án. Bạn có muốn lưu bản dự tính với thông số đầu vào này không?')) {
        return;
      }
    }

    const payload = {
      tab: state.tab,
      inputs: {
        area: state.area,
        height: state.height,
        boiso: state.boiso,
        voltage: state.voltage,
        space_type: state.spaceType,
        volume: state.volume
      },
      results: {
        required_airflow: state.requiredAirflow,
        total_actual_airflow: state.totalFanFlow,
        delta_percent: state.deltaPercent,
        is_in_tolerance: state.isInTolerance,
        total_price: state.fanTotalPrice,
        total_pad_price: state.padTotalPrice,
        grand_total: state.grandTotal,
        nominal_pad_area: state.nominalPadArea
      },
      selected_items: {
        fans: state.selectedItems,
        cooling_pads: state.selectedPads
      },
      customer: customerData || {}
    };

    fetch(cfg.urls.save, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify(payload)
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          if (callback) {
            callback(data);
            return;
          }

          if (andOpenPdf) {
            window.open(data.pdf_url + '?print=1', '_blank');
          } else {
            // Open Share Modal
            document.getElementById('saved_public_id').textContent = data.public_id;
            document.getElementById('saved_share_url').value = data.url;
            document.getElementById('view_saved_btn').href = data.url;
            document.getElementById('pdf_saved_btn').href = data.pdf_url + '?print=1';
            document.getElementById('shareModal').classList.add('active');
          }
        } else {
          alert('Không thể lưu bản dự tính: ' + JSON.stringify(data.errors || data.message));
        }
      })
      .catch(err => {
        console.error('Save error:', err);
        alert('Lỗi kết nối khi lưu bản dự tính.');
      });
  };

  // Close Modals
  window.closeShareModal = function () {
    document.getElementById('shareModal').classList.remove('active');
  };
  window.copySavedUrl = function () {
    const inp = document.getElementById('saved_share_url');
    navigator.clipboard.writeText(inp.value).then(() => {
      alert('Đã sao chép liên kết bản dự tính vào clipboard!');
    }).catch(() => {
      prompt('Liên kết bản dự tính:', inp.value);
    });
  };

  // 12. Zalo Modal & Submission
  window.openZaloModal = function () {
    document.getElementById('zaloModal').classList.add('active');
  };
  window.closeZaloModal = function () {
    document.getElementById('zaloModal').classList.remove('active');
  };

  window.submitZaloRfq = function () {
    const name = document.getElementById('modal_cust_name')?.value?.trim();
    const phone = document.getElementById('modal_cust_phone')?.value?.trim();
    const email = document.getElementById('modal_cust_email')?.value?.trim();
    const company = document.getElementById('modal_cust_company')?.value?.trim();
    const tax = document.getElementById('modal_cust_tax')?.value?.trim();

    if (!name || !phone) {
      alert('Vui lòng nhập Họ tên và Số điện thoại liên hệ để gửi Winline.');
      return;
    }

    const btn = document.getElementById('modalSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang chuẩn bị Zalo...';

    const custInfo = {
      name: name,
      phone: phone,
      email: email,
      company: company,
      tax_code: tax
    };

    // Save calculation with customer info first
    saveEstimation(false, custInfo, function (saveRes) {
      const publicId = saveRes.public_id;
      const detailUrl = saveRes.url;
      const totalStr = formatVnd(state.grandTotal);

      // Submit RFQ officially to Winline
      const submitUrl = `/vi/du-tinh/${publicId}/submit`;
      fetch(submitUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({
          customer_name: name,
          customer_phone: phone,
          customer_email: email,
          company_name: company,
          tax_code: tax,
          customer_note: 'Yêu cầu từ công cụ tính quạt'
        })
      })
      .then(res => res.json())
      .then(subData => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Xác nhận & Mở Zalo Winline (0949.761.888)';
        closeZaloModal();

        const zaloUrl = subData.zalo_url || `https://zalo.me/0949761888`;
        alert(`Bản dự tính #${publicId} đã được lưu thành công! Hệ thống sẽ mở Zalo để kết nối với bộ phận kỹ thuật Winline Việt Nam.`);
        window.open(zaloUrl, '_blank');
      })
      .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Xác nhận & Mở Zalo Winline (0949.761.888)';
        console.error(err);
        closeZaloModal();
        window.open(`https://zalo.me/0949761888`, '_blank');
      });
    });
  };

  // Run on DOM Load
  document.addEventListener('DOMContentLoaded', () => {
    initInputsForTab();
    fetchProducts();
  });

})();
