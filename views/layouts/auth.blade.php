<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="/css/admin.css" rel="stylesheet">
    @yield('head')
</head>

<body dir="rtl" class="d-flex flex-column">
    <section class="page-container">
        <main class="container py-4 d-flex flex-column h-100 justify-content-center">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h3 class="text-center fw-200">{{ appName() }}</h3>
                    @yield('content')
                </div>
            </div>
        </main>
    </section>
    <script src="/js/admin.js"></script>
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
    <script src="https://www.google.com/recaptcha/api.js?hl=ar"></script>
    @yield('scripts')
</body>

</html>
