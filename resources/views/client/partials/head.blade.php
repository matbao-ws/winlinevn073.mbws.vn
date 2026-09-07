<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Winline.vn — Quạt điện, quạt công nghiệp chính hãng')</title>
<meta name="description" content="@yield('meta_description', 'Winline.vn - Tổng kho phân phối quạt điện dân dụng, quạt công nghiệp, quạt ly tâm, quạt thông gió nhà xưởng chính hãng Komasu, Vinawind, Deton, Dasin, Hatari, Panasonic. Cam kết CO/CQ, bảo hành 12-24 tháng.')">
<link rel="icon" href="{{ asset('client-assets/images/favicon.png') }}" type="image/png">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&family=IBM+Plex+Mono:wght@500;600;700&family=Inter:wght@400;500;600;700;800&display=swap&subset=vietnamese" rel="stylesheet">

<!-- FontAwesome Pro 6 CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Master Design System Stylesheet -->
<link rel="stylesheet" href="{{ asset('client-assets/css/style.css') }}">
