<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- TITLE -->
    <title>  {{ config('app.name', 'Laravel') }} - @yield('title') </title>

    <!-- FAVICON -->
    <link rel="icon" href="{{asset('build/assets/images/brand/prevat.ico')}}" type="image/x-icon" >
    <link rel="shortcut icon" href="{{asset('build/assets/images/brand/prevat.ico')}}" type="image/x-icon">

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{asset('build/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- APP SCSS -->
    @livewireStyles
    @vite(['resources/sass/app.scss'])


    <!-- ICONS CSS -->
    <link href="{{asset('build/assets/iconfonts/icons.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- ANIMATE CSS -->
{{--    <link href="{{asset('build/assets/iconfonts/animated.css')}}" rel="stylesheet">--}}

    @yield('styles')

</head>

<body class="app sidebar-mini ltr">

<!--- GLOBAL LOADER -->
<div id="global-loader" >
    <img src="{{asset('build/assets/images/svgs/loader.svg')}}" alt="loader">
</div>
<!--- END GLOBAL LOADER -->

<!-- PAGE -->
<div class="page">
    <div class="page-main">

        <!-- MAIN-HEADER -->
        @include('layouts.components.main-header')

        <!-- END MAIN-HEADER -->

        <!-- NEWS-TICKER -->
        @include('layouts.components.news-ticker')

        <!-- END NEWS-TICKER -->

        <!-- MAIN-SIDEBAR -->
        @include('layouts.components.main-sidebar')

        <!-- END MAIN-SIDEBAR -->

        <!-- MAIN-CONTENT -->
        <div class="main-content app-content">
            <div class="side-app">
                <!-- CONTAINER -->
                <div class="main-container container-fluid">
                    @yield('content')
                </div>
            </div>
            @yield('modal-page-content')
        </div>
        <!-- END MAIN-CONTENT -->
    </div>

    @yield('modal-page-content1')

    <!-- RIGHT-SIDEBAR -->
    @include('layouts.components.right-sidebar')

    <!-- END RIGHT-SIDEBAR -->

    <!-- MAIN-FOOTER -->
    @include('layouts.components.main-footer')

    <!-- END MAIN-FOOTER -->

    @livewire('components.toast')
    @livewire('components.notification')
    @livewire('components.slide-right')
    @livewire('components.modal')
    @livewire('components.small-modal')
    @livewire('components.confirm-modal')

    @include('includes.dialog')
{{--    @include('includes.toast')--}}

</div>
<!-- END PAGE-->

<!-- SCRIPTS -->
@livewireScriptConfig
@stack('scripts')
@include('layouts.components.scripts')

<!-- STICKY JS -->
<script src="{{asset('build/assets/sticky.js')}}"></script>

<!-- THEMECOLOR JS -->
@vite('resources/assets/js/themeColors.js')

<!-- APP JS -->
@vite('resources/js/app.js')

<script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>


</body>
</html>
