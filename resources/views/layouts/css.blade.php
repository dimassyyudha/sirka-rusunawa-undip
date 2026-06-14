<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Inventaris Desa')</title>

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets-admin/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('assets-admin/vendors/iconly/bold.css') }}">
<link rel="stylesheet" href="{{ asset('assets-admin/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('assets-admin/vendors/bootstrap-icons/bootstrap-icons.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="{{ asset('assets-admin/css/app.css') }}">
{{-- Favicon Admin --}}
<link rel="icon" type="image/png" sizes="32x32"
    href="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}?v=3">
<link rel="icon" type="image/png" sizes="16x16"
    href="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}?v=3">
<link rel="shortcut icon" type="image/png" href="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}?v=3">


@stack('css')
