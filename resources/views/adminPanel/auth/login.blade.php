<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" class="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eRacing Türkiye - Türkiye'nin Yarış Platformu</title>
    <meta name="description" content="Türkiye'nin Yarış Platformu">

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
                        <p class="h5 font-semibold mb-2 text-center">Giriş Yap</p>
                        <form id="loginForm">
                            @csrf
                            <div class="grid grid-cols-12">
                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="signin-username" class="form-label text-default">Kullanıcı Adı</label>
                                    <input type="text" name="username" class="form-control form-control-lg w-full !rounded-md" id="signin-username" placeholder="">
                                </div>
                                <div class="xl:col-span-12 col-span-12 mb-3">
                                    <label for="signin-password" class="form-label text-default block">Şifre</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control !border-s border-defaultborder dark:border-defaultborder/10 form-control-lg !rounded-s-md" id="signin-password" placeholder="">
                                        <button aria-label="button" class="ti-btn ti-btn-light !rounded-s-none !mb-0" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    </div>
                                </div>
                                <div class="xl:col-span-12 col-span-12 grid mt-2">
                                    <a onclick="login()" class="ti-btn ti-btn-primary !bg-danger !text-white !font-medium">Giriş Yap</a>
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
                        title: 'Hata',
                        text: response.aciklama,
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                } else {
                    Swal.fire({
                        title: 'Başarılı',
                        text: 'Giriş başarılı! Yönlendiriliyorsunuz...',
                        icon: 'success',
                        confirmButtonText: 'Tamam'
                    }).then(() => {
                        window.location.href = '{{ route('Ahome') }}';
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Hata',
                    text: 'Beklenmedik bir hata oluştu.',
                    icon: 'error',
                    confirmButtonText: 'Tamam'
                });
            }
        });
    }
</script>
</body>

</html>