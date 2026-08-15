<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom/admin.css') }}" />

    @stack('styles')
</head>

<body>
    @include('admin.layouts.sidebar')

    @include('admin.layouts.header')

    <main class="nxl-container">
        @yield('main-content')

        @include('admin.layouts.footer')
    </main>

    {{-- Kept outside .nxl-container: the theme blurs .nxl-container while a
         modal is open (body.modal-open .nxl-container { filter: blur(3px) }),
         so modals must live here to stay sharp themselves. --}}
    @stack('modals')

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080">
        <div id="app-toast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body" id="app-toast-body">&nbsp;</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
