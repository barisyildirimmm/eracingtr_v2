<!DOCTYPE html>
<html lang="zxx">

<head>

    <!-- Basic Page Needs
 ================================================== -->
    <title>eRacing Türkiye - Türkiye'nin Yarış Platformu</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Türkiye'nin Yarış Platformu">
    <meta name="author" content="eRacingTR">
    <meta name="keywords" content="yaris, race, f1, formula, multiplayer, turnuva, lig">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons
 ================================================== -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/logo_fav.png?v=2') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/logo/logo_fav.png?v=2') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/img/logo/logo_fav.png?v=2') }}">

    <!-- Mobile Specific Metas
 ================================================== -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">

    <!-- Google Web Fonts
 ================================================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&amp;family&#x3D;Source+Sans+Pro:wght@400;700&amp;display&#x3D;swap"
        rel="stylesheet">

    <!-- CSS
 ================================================== -->
    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/slick/slick.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- Template CSS-->
    <link href="{{ asset('assets/css/style-basketball-dark.css') }}?v=3" rel="stylesheet">

    <!-- Custom CSS-->
    <link href="{{ asset('assets/css/custom.css?v=4') }}" rel="stylesheet">

</head>

<body data-template="template-basketball">

    {{-- GLOBAL FLASH MESSAGES --}}
    {{-- FLASH MESSAGES --}}
    @if (session('success'))
        <div style="
        margin:12px 0;
        padding:14px 18px;
        background:#e8f7ee;
        border:1px solid #b8e2c3;
        border-left:5px solid #38b000;
        border-radius:6px;
        color:#215732;
        font-size:14px;
        display:flex;
        align-items:center;
        gap:8px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="
        margin:12px 0;
        padding:14px 18px;
        background:#fdeaea;
        border:1px solid #f5c2c2;
        border-left:5px solid #d90429;
        border-radius:6px;
        color:#7c1a1a;
        font-size:14px;
        display:flex;
        align-items:center;
        gap:8px;">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="
        margin:12px 0;
        padding:14px 18px;
        background:#fff3cd;
        border:1px solid #ffeeba;
        border-left:5px solid #e0a800;
        border-radius:6px;
        color:#856404;
        font-size:14px;">
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="site-wrapper clearfix">
        <div class="site-overlay"></div>

        @include('layouts.header')
        <!-- Pushy Panel -->
        <aside class="pushy-panel ">
            <div class="pushy-panel__inner">
                <header class="pushy-panel__header">
                    <div class="pushy-panel__logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo/logo.png?v=2') }}"
                                srcset="{{ asset('assets/img/logo/logo.png?v=2') }}" alt="eRacingTR"></a>
                    </div>
                </header>
                <div class="pushy-panel__content">

                    <!-- Widget: Posts -->
                    {{-- <aside class="widget widget--side-panel">
                        <div class="widget__content">
                            <ul class="posts posts--simple-list posts--simple-list--lg">
                                <li class="posts__item posts__item--category-1">
                                    <div class="posts__inner">
                                        <div class="posts__cat">
                                            <span class="label posts__cat-label">The Team</span>
                                        </div>
                                        <h6 class="posts__title"><a href="#">The new eco friendly stadium won a
                                                Leafy Award in 2016</a></h6>
                                        <time datetime="2017-08-23" class="posts__date">August 23rd, 2018</time>
                                        <div class="posts__excerpt">
                                            Lorem ipsum dolor sit amet, consectetur adipisi nel elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad mini veniam,
                                            quis nostrud en derum sum laborem.
                                        </div>
                                    </div>
                                    <footer class="posts__footer card__footer">
                                        <div class="post-author">
                                            <figure class="post-author__avatar">
                                                <img src="assets/images/samples/avatar-1.jpg" alt="Post Author Avatar">
                                            </figure>
                                            <div class="post-author__info">
                                                <h4 class="post-author__name">James Spiegel</h4>
                                            </div>
                                        </div>
                                        <ul class="post__meta meta">
                                            <li class="meta__item meta__item--likes"><a href="#"><i
                                                        class="meta-like meta-like--active icon-heart"></i> 530</a></li>
                                            <li class="meta__item meta__item--comments"><a href="#">18</a></li>
                                        </ul>
                                    </footer>
                                </li>
                                <li class="posts__item posts__item--category-2">
                                    <div class="posts__inner">
                                        <div class="posts__cat">
                                            <span class="label posts__cat-label">Injuries</span>
                                        </div>
                                        <h6 class="posts__title"><a href="#">Mark Johnson has a Tibia Fracture and
                                                is gonna be out</a></h6>
                                        <time datetime="2017-08-23" class="posts__date">August 23rd, 2018</time>
                                        <div class="posts__excerpt">
                                            Lorem ipsum dolor sit amet, consectetur adipisi nel elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad mini veniam,
                                            quis nostrud en derum sum laborem.
                                        </div>
                                    </div>
                                    <footer class="posts__footer card__footer">
                                        <div class="post-author">
                                            <figure class="post-author__avatar">
                                                <img src="assets/images/samples/avatar-2.jpg" alt="Post Author Avatar">
                                            </figure>
                                            <div class="post-author__info">
                                                <h4 class="post-author__name">Jessica Hoops</h4>
                                            </div>
                                        </div>
                                        <ul class="post__meta meta">
                                            <li class="meta__item meta__item--likes"><a href="#"><i
                                                        class="meta-like meta-like--active icon-heart"></i> 530</a></li>
                                            <li class="meta__item meta__item--comments"><a href="#">18</a></li>
                                        </ul>
                                    </footer>
                                </li>
                            </ul>
                        </div>
                    </aside> --}}
                    <!-- Widget: Posts / End -->

                    <!-- Widget: Tag Cloud -->
                    {{-- <aside class="widget widget--side-panel widget-tagcloud">
                        <div class="widget__title">
                            <h4>Tag Cloud</h4>
                        </div>
                        <div class="widget__content">
                            <div class="tagcloud">
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">PLAYOFFS</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">ALCHEMISTS</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">INJURIES</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">TEAM</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">INCORPORATIONS</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">UNIFORMS</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">CHAMPIONS</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">PROFESSIONAL</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">COACH</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">STADIUM</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">NEWS</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">PLAYERS</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">WOMEN DIVISION</a>
                                <a href="#" class="btn btn-primary btn-xs btn-outline btn-sm">AWARDS</a>
                            </div>
                        </div>
                    </aside> --}}
                    <!-- Widget: Tag Cloud / End -->

                    <!-- Widget: Banner -->
                    {{-- <aside class="widget widget--side-panel widget-banner">
                        <div class="widget__content">
                            <figure class="widget-banner__img">
                                <a href="#"><img src="assets/images/samples/banner.jpg" alt="Banner"></a>
                            </figure>
                        </div>
                    </aside> --}}
                    <!-- Widget: Banner / End -->

                </div>
                <a href="#" class="pushy-panel__back-btn"></a>
            </div>
        </aside>
        <!-- Pushy Panel / End -->

        @yield('content')

        @include('layouts.footer')

        <!-- Login/Register Modal -->
        <div class="modal fade" id="modal-login-register" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal--login" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="modal-account-holder">
                            <div class="modal-account__item">

                                <!-- Register Form -->
                                <form id="registerForm" class="modal-form">
                                    @csrf
                                    <h5>KAYIT OL !</h5>
                                    <div class="form-group">
                                        <input type="name" class="form-control" name="name" placeholder="İsim" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="name" class="form-control" name="surname" placeholder="Soyisim" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="name" class="form-control" id="gsm" name="gsm" placeholder="Telefon Numarası" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="E-posta" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Şifre" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            placeholder="Şifreyi Tekrar Girin" required>
                                    </div>
                                    <div class="form-group form-group--submit">
                                        <button type="button" onclick="registerUser()"
                                            class="btn btn-primary-inverse btn-block">HESAP OLUŞTUR</button>
                                    </div>
                                    <div class="modal-form--note">Kayıt işlemi tamamlandığında, mail adresini onaylamak için bir mail gönderilecek. </div>
                                </form>
                                <!-- Register Form / End -->

                            </div>
                            <div class="modal-account__item">
                                <!-- Login Form -->
                                <form id="loginForm" class="modal-form">
                                    @csrf
                                    <h5>GİRİŞ YAP</h5>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email"
                                            placeholder="E-posta" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Şifre" required>
                                    </div>
                                    {{-- <div class="form-group form-group--pass-reminder">
                                        <label class="checkbox checkbox-inline">
                                            <input type="checkbox" id="inlineCheckbox1" name="remember"
                                                value="1">
                                            Remember Me
                                            <span class="checkbox-indicator"></span>
                                        </label>
                                        <a href="#">Forgot your password?</a>
                                    </div> --}}
                                    <div class="form-group form-group--submit">
                                        <button type="button" onclick="loginUser()"
                                            class="btn btn-primary-inverse btn-block">GİRİŞ YAP</button>
                                    </div>
                                </form>
                                <!-- Login Form / End -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login/Register Modal / End -->

    </div>

    <!-- Javascript Files
 ================================================== -->
    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/core.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vendor JS -->
    <script src="{{ asset('assets/vendor/twitter/jquery.twitter.js') }}"></script>

    <!-- Template JS -->
    <script src="{{ asset('assets/js/init.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="https://unpkg.com/imask"></script>
    <script>

        const gsmInput = $('#gsm');
        IMask(gsmInput[0], {
            mask: '+{90} (000) 000 00 00',
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function yapimAsamasinda() {
            Swal.fire({
                title: 'Yapım Aşamasında',
                text: 'Çok yakında bu bölüm aktif olacak.',
                icon: 'warning',
                confirmButtonText: 'Tamam'
            });
        }

        function loginUser() {
            $.ajax({
                url: '{{ route('DloginPost') }}',
                type: 'POST',
                data: $('#loginForm').serialize(),
                success: function(response) {
                    if (response.hata === 1) {
                        Swal.fire({
                            title: 'Hata',
                            text: response.aciklama,
                            icon: 'error',
                            confirmButtonText: 'Tamam'
                        });;
                    } else {
                        Swal.fire({
                            title: 'Başarılı',
                            text: 'Giriş başarılı! Yönlendiriliyorsunuz...',
                            icon: 'success',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            window.location.href = '{{ route('home') }}';
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

        function registerUser() {
            $.ajax({
                url: '{{ route('DregisterPost') }}',
                type: 'POST',
                data: $('#registerForm').serialize(),
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
                            text: 'Hesabınız başarıyla oluşturuldu! Yönlendiriliyorsunuz...',
                            icon: 'success',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            window.location.href = '{{ route('home') }}';
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

        function logout() {
            $.ajax({
                url: '{{ route('Dlogout') }}',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Çıkış işlemi başarılı olduysa
                    if (response.hata == 0) {
                        Swal.fire({
                            title: 'Başarılı',
                            text: 'Başarıyla Çıkış Yapıldı!',
                            icon: 'success',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            window.location.href = '{{ route('home') }}';
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Eğer hata oluşursa
                    Swal.fire({
                        title: 'Hata',
                        text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        }
    </script>
</body>

</html>
