<!-- Quote Modal (Báo giá nhanh B2B / Dự án) -->
<div class="modal-overlay" id="quoteModal">
  <div class="modal-box wide">
    <button class="modal-close" onclick="closeModal()">✕</button>
    <h3 id="modalProductTitle">Yêu cầu báo giá sản phẩm</h3>
    <p class="sub">Chọn đúng nhu cầu để nhân viên Winline báo giá chiết khấu tốt nhất.</p>

    <div class="seg-pick" id="segPick">
      <button type="button" class="active" onclick="pickSeg('congtrinh',this)">🏗️ Công trình</button>
      <button type="button" onclick="pickSeg('khoxuong',this)">🏭 Kho-xưởng</button>
      <button type="button" onclick="pickSeg('donvi',this)">🏢 Đơn vị sử dụng</button>
      <button type="button" onclick="pickSeg('thuongmai',this)">🤝 Thương mại</button>
    </div>

    <form id="quoteModalForm" onsubmit="handleQuoteSubmit(event)">
      @csrf
      <input type="hidden" name="subject" id="quoteSubject" value="Báo giá quạt công nghiệp">

      <div class="seg-fields active" id="fields-congtrinh">
        <div class="form-field"><label>Số lượng dự kiến</label><input type="number" name="quantity" placeholder="Ví dụ: 20"></div>
        <div class="form-field"><label>Địa điểm giao hàng</label><input type="text" name="location" placeholder="Công trình / quận, tỉnh"></div>
        <div class="form-field"><label>Số điện thoại / Zalo (*)</label><input type="tel" name="phone" required placeholder="09xx xxx xxx"></div>
      </div>

      <div class="seg-fields" id="fields-khoxuong">
        <div class="form-field"><label>Số lượng</label><input type="number" name="quantity_kx" placeholder="Ví dụ: 15"></div>
        <div class="form-field"><label>Tên xưởng / KCN</label><input type="text" name="factory" placeholder="Tên xưởng / KCN"></div>
        <div class="form-field"><label>Số điện thoại / Zalo (*)</label><input type="tel" name="phone_kx" placeholder="09xx xxx xxx"></div>
      </div>

      <div class="seg-fields" id="fields-donvi">
        <div class="form-field"><label>Số lượng</label><input type="number" name="quantity_dv" placeholder="Ví dụ: 10"></div>
        <div class="form-field"><label>Nơi sử dụng</label><input type="text" name="workplace" placeholder="Văn phòng / nhà hàng / trường học..."></div>
        <div class="form-field"><label>Số điện thoại / Zalo (*)</label><input type="tel" name="phone_dv" placeholder="09xx xxx xxx"></div>
      </div>

      <div class="seg-fields" id="fields-thuongmai">
        <div class="form-field"><label>Số lượng</label><input type="number" name="quantity_tm" placeholder="Ví dụ: 30"></div>
        <div class="form-field"><label>Kho / Cửa hàng</label><input type="text" name="store" placeholder="Kho / cửa hàng"></div>
        <div class="form-field"><label>Số điện thoại / Zalo (*)</label><input type="tel" name="phone_tm" placeholder="09xx xxx xxx"></div>
      </div>

      <button type="submit" class="modal-submit" style="width:100%; margin-top:14px; background:var(--brand-blue); color:#fff; padding:12px; border:none; border-radius:6px; font-weight:700; cursor:pointer;">Gửi yêu cầu báo giá</button>
    </form>
    
    <p class="modal-escape" style="margin-top:12px; font-size:12px; text-align:center;">
      hoặc <a href="https://zalo.me/0949761893" target="_blank" style="color:var(--brand-blue); font-weight:700;">Chat Zalo ngay</a> / <a href="tel:0949761893" style="color:var(--orange); font-weight:700;">0949.761.893</a> — không cần điền form
    </p>
  </div>
</div>

<script>
function pickSeg(name, btn) {
  document.querySelectorAll('#segPick button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.seg-fields').forEach(f => f.classList.remove('active'));
  const target = document.getElementById('fields-' + name);
  if (target) target.classList.add('active');
}

function openModal(title) {
  if (title) {
    const el = document.getElementById('modalProductTitle');
    if (el) el.textContent = 'Báo giá: ' + title;
    const subj = document.getElementById('quoteSubject');
    if (subj) subj.value = 'Báo giá: ' + title;
  }
  const modal = document.getElementById('quoteModal');
  if (modal) modal.classList.add('open');
}

function closeModal() {
  const modal = document.getElementById('quoteModal');
  if (modal) modal.classList.remove('open');
}

function handleQuoteSubmit(e) {
  e.preventDefault();
  const form = e.target;
  const activeField = form.querySelector('.seg-fields.active');
  let phone = '';
  if (activeField) {
    const phoneInput = activeField.querySelector('input[type="tel"]');
    if (phoneInput) phone = phoneInput.value;
  }
  if (!phone) {
    alert('Vui lòng nhập số điện thoại hoặc Zalo để Winline báo giá!');
    return;
  }

  fetch('{{ route("client.contact.submit") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      name: 'Khách hàng báo giá nhanh',
      phone: phone,
      subject: document.getElementById('quoteSubject').value,
      message: 'Yêu cầu báo giá nhanh qua modal website'
    })
  })
  .then(res => res.json())
  .then(data => {
    alert('Cảm ơn bạn! Winline sẽ gửi bảng giá chiết khấu qua Zalo/SĐT ' + phone + ' trong 15 phút.');
    closeModal();
    form.reset();
  })
  .catch(err => {
    alert('Cảm ơn bạn! Winline đã ghi nhận thông tin và sẽ gọi lại ngay.');
    closeModal();
  });
}
</script>
