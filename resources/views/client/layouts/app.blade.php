<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('client.partials.head')
    @stack('styles')
</head>
<body>
    @include('client.partials.top-bar')

    {{-- Server-rendered navigation bar marked uneditable for CMS inline editor --}}
    <div contenteditable="false">
        @include('client.partials.header')
    </div>

    <main>
        @yield('content')
    </main>

    @include('client.partials.footer')
    @include('client.partials.modals')
    @include('client.partials.smart-search-modal')
    @include('client.partials.mobile-category-sheet')
    @include('client.partials.mobile-nav-drawer')

    {{-- Nút Lên TOP nổi bên phải (hiển thị khi cuộn xuống 2/3 màn hình) --}}
    <button type="button" id="backToTopBtn" class="floating-back-to-top" onclick="scrollToTop()" aria-label="Lên đầu trang">
        <i class="fas fa-chevron-up"></i>
    </button>

    @include('client.partials.admin-bar')

    <script src="{{ asset('client-assets/js/products-data.js') }}"></script>
    <script src="{{ asset('client-assets/js/app.js') }}"></script>
    @stack('scripts')

    @include('client.partials.mobile-bottom-bar')
</body>
</html>
