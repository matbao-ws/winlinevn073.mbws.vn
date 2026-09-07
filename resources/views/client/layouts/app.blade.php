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

    @include('client.partials.admin-bar')

    <script src="{{ asset('client-assets/js/products-data.js') }}"></script>
    <script src="{{ asset('client-assets/js/app.js') }}"></script>
    @stack('scripts')

    @include('client.partials.mobile-bottom-bar')
</body>
</html>
