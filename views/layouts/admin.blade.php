<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="/vendor/cms/css/admin.css" rel="stylesheet">
    @yield('head')
</head>

<body dir="rtl" class="d-flex flex-column">
    <section class="page-container">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    {{ appName() }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbarContent"
                    aria-controls="mainNavbarContent" aria-expanded="false" aria-label="پیمایش">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbarContent">
                {!! renderMenu('admin_navigation', 'navbar-nav mr-auto') !!}
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">مشاهده سایت</a>
                        </li>
                        @if(currentUser())
                        <li class="nav-item dropdown">
                            <a id="navbarProfileDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ currentUser()->name }}
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarProfileDropdown">
                                <a class="dropdown-item" href="{{ route('auth.logout') }}">خروج</a>
                            </div>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login') }}">ورود</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container mb-3">@yield('content')</div>
        </main>
    </section>
    <footer>
        <div class="container py-3 border-top">
            <div class="text-center">طراحی و پیاده‌سازی توسط <a target="_blank" rel="nofollow" href="https://codictive.net">Codictive</a></div>
        </div>
    </footer>
    <script src="/vendor/cms/js/admin.js"></script>
    <script>
    var alertMessage = '';
    var alertLevel = 'success';

    @if (session('success'))
    alertMessage = '{{ session('success') }}';
    alertLevel = 'success';
    @endif

    @if (session('info'))
    alertMessage = '{{ session('info') }}';
    alertLevel = 'info';
    @endif

    @if (session('warning'))
    alertMessage = '{{ session('warning') }}';
    alertLevel = 'warning';
    @endif
    @if ($errors->any())
    alertMessage = '{!! implode("<br>", $errors->all()) !!}';
    alertLevel = 'error';
    @endif

    if (alertMessage) {
        swAlert(alertLevel, alertMessage);
    }
    </script>
    @yield('scripts')
</body>

</html>
