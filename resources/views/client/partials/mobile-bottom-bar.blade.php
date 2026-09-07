<div class="mobile-bottom-bar" style="position:fixed; bottom:0; left:0; right:0; background:#ffffff; border-top:1px solid #e2e8f0; display:flex; justify-content:space-around; align-items:center; padding:8px 0; z-index:999; box-shadow:0 -2px 10px rgba(0,0,0,0.06);">
    <a href="tel:0949761893" style="display:flex; flex-direction:column; align-items:center; color:#00354f; font-size:11px; font-weight:600; text-decoration:none;">
        <i class="fas fa-phone-alt" style="font-size:18px; color:#d41e3d; margin-bottom:2px;"></i>
        <span>Gọi điện</span>
    </a>
    <a href="https://zalo.me/0949761893" target="_blank" style="display:flex; flex-direction:column; align-items:center; color:#00354f; font-size:11px; font-weight:600; text-decoration:none;">
        <i class="fas fa-comment-dots" style="font-size:18px; color:#0068ff; margin-bottom:2px;"></i>
        <span>Zalo</span>
    </a>
    <a href="{{ route('client.calculator') }}" style="display:flex; flex-direction:column; align-items:center; color:#00354f; font-size:11px; font-weight:600; text-decoration:none;">
        <i class="fas fa-calculator" style="font-size:18px; color:#f59e0b; margin-bottom:2px;"></i>
        <span>Tính quạt</span>
    </a>
    <a href="javascript:void(0)" onclick="openCartDrawer()" style="display:flex; flex-direction:column; align-items:center; color:#00354f; font-size:11px; font-weight:600; text-decoration:none; position:relative;">
        <i class="fas fa-shopping-cart" style="font-size:18px; color:#004e7d; margin-bottom:2px;"></i>
        <span class="cart-badge-count" style="position:absolute; top:-4px; right:6px; background:#d41e3d; color:#fff; font-size:9px; font-weight:700; width:15px; height:15px; border-radius:50%; display:none; align-items:center; justify-content:center;">0</span>
        <span>Giỏ hàng</span>
    </a>
</div>
