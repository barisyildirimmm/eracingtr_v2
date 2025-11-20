<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('common.admin_panel_title') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/logo_fav.png') }}">

    <!-- Main JS -->
    <script src="{{ asset('assets/panel/js/main.js') }}"></script>

    <!-- Style Css -->
    <link rel="stylesheet" href="{{ asset('assets/panel/css/style.css') }}">

    <!-- Simplebar Css -->
    <link rel="stylesheet" href="{{ asset('assets/panel/libs/simplebar/simplebar.min.css') }}">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/panel/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('css')
</head>

<body>

    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('assets/panel/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">

        <!-- Start::Header -->
        @include('adminPanel.layouts.header')
        <!-- End::Header -->
        <!-- Start::app-sidebar -->
        @include('adminPanel.layouts.sidebar')
        <!-- End::app-sidebar -->


        <div class="content main-index">

            <!-- Start::main-content -->
            <div class="main-content">
                @yield('content')
            </div>
            <!-- end::main-content -->

        </div>

        <!-- Footer Start -->
        @include('adminPanel.layouts.footer')
        <!-- Footer End -->

    </div>

    <!-- Back To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill text-xl"></i></span>
    </div>

    <div id="responsive-overlay"></div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- Switch JS -->
    <script src="{{ asset('assets/panel/js/switch.js') }}"></script>

    <!-- Preline JS -->
    <script src="{{ asset('assets/panel/libs/preline/preline.js') }}"></script>

    <!-- popperjs -->
    <script src="{{ asset('assets/panel/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('assets/panel/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- sidebar JS -->
    <script src="{{ asset('assets/panel/js/defaultmenu.js') }}"></script>

    <!-- sticky JS -->
    <script src="{{ asset('assets/panel/js/sticky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('assets/panel/libs/simplebar/simplebar.min.js') }}"></script>



    <!-- JSVector Maps JS -->
    <script src="{{ asset('assets/panel/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>

    <!-- JSVector Maps MapsJS -->
    <script src="{{ asset('assets/panel/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!-- Apex Charts JS -->
    <script src="{{ asset('assets/panel/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Chartjs Chart JS -->
    <script src="{{ asset('assets/panel/libs/chart.js/chart.min.js') }}"></script>

    <!-- CRM-Dashboard -->
    <script src="{{ asset('assets/panel/js/crm-dashboard.js') }}"></script>


    <!-- Custom-Switcher JS -->
    <script src="{{ asset('assets/panel/js/custom-switcher.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/panel/js/custom.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Language Switcher Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const languageSelect = document.getElementById('language-select-admin');
            if (languageSelect) {
                languageSelect.addEventListener('change', function() {
                    const locale = this.value;
                    
                    fetch('{{ route("change.locale") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ locale: locale })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('{{ __('common.language_change_failed') }}');
                            languageSelect.value = '{{ app()->getLocale() }}';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('{{ __('common.language_change_error') }}');
                        languageSelect.value = '{{ app()->getLocale() }}';
                    });
                });
            }
        });
    </script>
    <!-- Language Switcher Script / End -->
    
    @yield('js')

</body>

</html>
