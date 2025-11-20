<!DOCTYPE html>
<html lang="tr" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" class="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('common.site_title') }}</title>
    <meta name="description" content="{{ __('common.site_description') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/logo_fav.png') }}">

    <!-- Main Theme Js -->
    <script src="{{ asset('assets/panel/js/authentication-main.js') }}"></script>

    <!-- Style Css -->
    <link rel="stylesheet" href="{{ asset('assets/panel/css/style.css') }}">

    <!-- Simplebar Css -->
    <link rel="stylesheet" href="{{ asset('assets/panel/libs/simplebar/simplebar.min.css') }}">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/panel/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ asset('assets/panel/libs/swiper/swiper-bundle.min.css') }}">

    <!-- SweetAlert2 Custom Styles -->
    <style>
        .swal2-popup-custom {
            border-radius: 12px !important;
            padding: 30px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3) !important;
        }
        .swal2-confirm-custom {
            border-radius: 8px !important;
            padding: 12px 30px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            transition: all 0.3s !important;
        }
        .swal2-confirm-custom:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
        }
        .swal2-title {
            padding: 0 !important;
            margin: 0 !important;
        }
        .swal2-html-container {
            margin: 0 !important;
            padding: 0 !important;
        }
        .swal2-footer {
            border-top: 1px solid #e5e7eb !important;
            padding-top: 15px !important;
            margin-top: 15px !important;
        }
    </style>

</head>

<body class="">

<!-- Loader -->
<div id="loader" >
    <img src="{{ asset('assets/panel/images/media/loader.svg') }}" alt="">
</div>
<!-- Loader -->

<div class="container">
    <div class="flex justify-center authentication authentication-basic items-center h-full text-defaultsize text-defaulttextcolor">
        <div class="grid grid-cols-12">
            <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-3 sm:col-span-2"></div>
            <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-6 sm:col-span-8 col-span-12">
                <div class="my-[2.5rem] flex justify-center">
                    <a href="{{route('AloginGet')}}">
                        <img src="{{ asset('assets/img/logo/logo.png?v=2') }}" alt="logo" class="desktop-dark">
                        <img src="{{ asset('assets/img/logo/logo_dark.png?v=2') }}" alt="logo" class="desktop-logo">
                    </a>
                </div>
                <div class="box">
                    <div class="box-body !p-[3rem]">
                        <p class="h5 font-semibold mb-2 text-center">{{ __('common.login') }}</p>
                        <form id="loginForm">
                            @csrf
                            <div class="grid grid-cols-12">
                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="signin-username" class="form-label text-default">{{ __('common.username') }}</label>
                                    <input type="text" name="username" class="form-control form-control-lg w-full !rounded-md" id="signin-username" placeholder="">
                                </div>
                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="signin-password" class="form-label text-default block">{{ __('common.password') }}</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control !border-s border-defaultborder dark:border-defaultborder/10 form-control-lg !rounded-s-md" id="signin-password" placeholder="">
                                        <button aria-label="button" class="ti-btn ti-btn-light !rounded-s-none !mb-0" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    </div>
                                </div>
                                <div class="xl:col-span-12 col-span-12 grid mt-2">
                                    <a onclick="login()" class="ti-btn ti-btn-primary !bg-danger !text-white !font-medium">{{ __('common.login') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-3 sm:col-span-2"></div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Show Password JS -->
<script src="{{ asset('assets/panel/js/show-password.js') }}"></script>

<!-- Auth Custom JS -->
<script src="{{ asset('assets/panel/js/auth-custom.js') }}"></script>
<script>
    function login() {
        $.ajax({
            url: '{{ route('AloginPost') }}',
            type: 'POST',
            data: $('#loginForm').serialize(),
            success: function(response) {
                if (response.hata === 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<div style="font-size: 24px; font-weight: 600; color: #ef4444; margin-bottom: 10px;"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ __('common.error') }}</div>',
                        html: '<p style="font-size: 16px; color: #333; margin: 0;">' + response.aciklama + '</p>',
                        confirmButtonText: '{{ __('common.ok') }}',
                        confirmButtonColor: '#ef4444',
                        buttonsStyling: true,
                        customClass: {
                            popup: 'swal2-popup-custom',
                            confirmButton: 'swal2-confirm-custom'
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: '<div style="font-size: 24px; font-weight: 600; color: #10b981; margin-bottom: 10px;"><i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ __('common.login_success') }}</div>',
                        html: '<p style="font-size: 16px; color: #333; margin: 0;">{{ __('common.login_success_text') }}</p>',
                        confirmButtonText: '{{ __('common.ok') }}',
                        confirmButtonColor: '#10b981',
                        buttonsStyling: true,
                        customClass: {
                            popup: 'swal2-popup-custom',
                            confirmButton: 'swal2-confirm-custom'
                        }
                    }).then(() => {
                        window.location.href = '{{ route('Ahome') }}';
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: '<div style="font-size: 24px; font-weight: 600; color: #ef4444; margin-bottom: 10px;"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ __('common.error') }}</div>',
                    html: '<p style="font-size: 16px; color: #333; margin: 0;">{{ __('common.unexpected_error') }}</p>',
                    confirmButtonText: '{{ __('common.ok') }}',
                    confirmButtonColor: '#ef4444',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'swal2-confirm-custom'
                    }
                });
            }
        });
    }
</script>
</body>

</html>