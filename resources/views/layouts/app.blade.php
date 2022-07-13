<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OPMS</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/images/fav_g.png">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/template_css_js/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template_css_js/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/template_css_js/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/template_css_js/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/template_css_js/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/template_css_js/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/template_css_js/vendor/simple-datatables/style.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="/template_css_js/css/style.css" rel="stylesheet">


    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased">



    @livewire('navigation-menu')

    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">


        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    <script src="/template_css_js/js/javas.js" defer></script>


    <!--Vendor JS Files-->
    <script src="/template_css_js/vendor/apexcharts/apexcharts.min.js" defer></script>
    <script src="/template_css_js/vendor/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <script src="/template_css_js/vendor/chart.js/chart.min.js" defer></script>
    <script src="/template_css_js/vendor/echarts/echarts.min.js"></script>
    <script src="/template_css_js/vendor/quill/quill.min.js"></script>
    <script src="/template_css_js/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/'template_css_js/vendor/tinymce/tinymce.min.js"></script>
    <script src="/template_css_js/vendor/php-email-form/validate.js"></script>

    <!--Template Main JS File-->
    <script src="/template_css_js/js/main.js" defer></script>
</body>

</html>