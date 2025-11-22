<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" id="html-root">

<head>

    <!-- Basic Page Needs
 ================================================== -->
    <title>{{ __('common.site_title_full') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ __('common.site_description_full') }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/css/intlTelInput.css" />

    <!-- Template CSS-->
    <link href="{{ asset('assets/css/style-basketball-dark.css') }}?v=3" rel="stylesheet">
    
    <!-- Light Theme CSS-->
    <link href="{{ asset('assets/css/style-basketball-light.css') }}?v=1" rel="stylesheet">

    <!-- Custom CSS-->
    <link href="{{ asset('assets/css/custom.css?v=4') }}" rel="stylesheet">

    <!-- Theme CSS Variables -->
    <style>
        :root {
            /* Dark Theme (Default) */
            --bg-primary: #1a1a1a;
            --bg-secondary: #2d2d2d;
            --bg-tertiary: #0a0a0a;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --border-color: rgba(255, 255, 255, 0.1);
            --card-bg: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            --header-bg: #1a1a1a;
            --header-top-bg: #1a1a1a;
            --hero-bg: linear-gradient(135deg, #0d1117 0%, #161b22 30%, #1c2128 60%, #0d1117 100%);
        }
        
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
    
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
        
        .swal2-toast-custom {
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
            border: 1px solid #e5e7eb !important;
            padding: 16px 20px !important;
            min-width: 350px !important;
        }
        
        .swal2-toast-custom .swal2-title {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body data-template="template-basketball">

    {{-- GLOBAL FLASH MESSAGES --}}
    {{-- FLASH MESSAGES --}}
    @if (session('success'))
        <div style="
        margin: 15px auto;
        max-width: 1200px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        animation: slideDown 0.3s ease-out;">
            <i class="fas fa-check-circle" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div style="
        margin: 15px auto;
        max-width: 1200px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        animation: slideDown 0.3s ease-out;">
            <i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>
            <span>{{ session('error') }}</span>
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
        <div class="modal fade" id="modal-login-register" tabindex="-1" role="dialog" aria-labelledby="modal-login-register-label">
            <div class="modal-dialog modal-lg modal--login" role="document">
                <div class="modal-content" style="border-radius: 8px; border: none; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 20px 30px; border-bottom: 2px solid #dc3545; position: relative; display: flex; align-items: center; justify-content: space-between;">
                        <h4 class="modal-title text-white" id="modal-login-register-label" style="margin: 0; font-weight: 600; font-size: 20px; line-height: 1.2;">
                            <i class="fas fa-user-circle mr-2" style="color: #dc3545;"></i>{{ __('common.login_register') }}
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" 
                                style="opacity: 1; font-size: 24px; font-weight: 300; padding: 0; line-height: 1; background: rgba(0,0,0,0.3); border-radius: 4px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; transition: background 0.3s; margin: 0; border: none; position: relative; flex-shrink: 0;"
                                onmouseover="this.style.background='rgba(220, 53, 69, 0.5)'"
                                onmouseout="this.style.background='rgba(0,0,0,0.3)'">
                            <span aria-hidden="true" style="line-height: 1; display: block;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 30px; background: #222;">

                        <!-- Tab Navigation -->
                        <div class="d-flex mb-4" style="gap: 10px; border-bottom: 2px solid #333; padding-bottom: 0;">
                            <button type="button" class="btn-tab-auth active" id="login-tab-btn" onclick="switchAuthTab('login')" 
                                    style="flex: 1; background: #dc3545; color: white; border: none; border-radius: 6px 6px 0 0; padding: 12px 20px; font-weight: 600; transition: all 0.3s; cursor: pointer; position: relative; bottom: -2px;">
                                <i class="fas fa-sign-in-alt mr-2"></i>{{ __('common.login_title') }}
                            </button>
                            <button type="button" class="btn-tab-auth" id="register-tab-btn" onclick="switchAuthTab('register')" 
                                    style="flex: 1; background: #444; color: #999; border: none; border-radius: 6px 6px 0 0; padding: 12px 20px; font-weight: 600; transition: all 0.3s; cursor: pointer; position: relative; bottom: -2px;">
                                <i class="fas fa-user-plus mr-2"></i>{{ __('common.register_title') }}
                            </button>
                        </div>
                        <style>
                            .btn-tab-auth:hover {
                                background: #555 !important;
                                color: #fff !important;
                            }
                            .btn-tab-auth.active {
                                background: #dc3545 !important;
                                color: white !important;
                            }
                        </style>
                        <script>
                            function switchAuthTab(tab) {
                                // Tüm tab butonlarını deaktif yap
                                document.querySelectorAll('.btn-tab-auth').forEach(btn => {
                                    btn.classList.remove('active');
                                    btn.style.background = '#444';
                                    btn.style.color = '#999';
                                });
                                
                                // Tüm tab panellerini gizle
                                document.querySelectorAll('.tab-pane').forEach(pane => {
                                    pane.classList.remove('show', 'active');
                                });
                                
                                // Seçilen tab'ı aktif yap
                                if(tab === 'login') {
                                    document.getElementById('login-tab-btn').classList.add('active');
                                    document.getElementById('login-tab-btn').style.background = '#dc3545';
                                    document.getElementById('login-tab-btn').style.color = 'white';
                                    document.getElementById('login').classList.add('show', 'active');
                                } else {
                                    document.getElementById('register-tab-btn').classList.add('active');
                                    document.getElementById('register-tab-btn').style.background = '#dc3545';
                                    document.getElementById('register-tab-btn').style.color = 'white';
                                    document.getElementById('register').classList.add('show', 'active');
                                }
                            }
                        </script>

                        <!-- Tab Content -->
                        <div class="tab-content" id="authTabsContent">
                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                <form id="loginForm" class="modal-form">
                                    @csrf
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                            <i class="fas fa-envelope mr-2" style="color: #dc3545;"></i>{{ __('common.email_placeholder') }}
                                        </label>
                                        <input type="email" class="form-control" name="email" 
                                            placeholder="{{ __('common.email_placeholder') }}" required
                                            style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                            onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                            onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                    </div>
                                    <div class="form-group" style="margin-bottom: 25px;">
                                        <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                            <i class="fas fa-lock mr-2" style="color: #dc3545;"></i>{{ __('common.password_placeholder') }}
                                        </label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="{{ __('common.password_placeholder') }}" required
                                            style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                            onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                            onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                    </div>
                                    <div class="form-group form-group--submit" style="margin-bottom: 10px;">
                                        <button type="button" onclick="loginUser()"
                                            class="btn btn-block" 
                                            style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 14px; font-weight: 600; font-size: 16px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.6)'; this.style.background='linear-gradient(135deg, #c82333 0%, #bd2130 100%)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 53, 69, 0.4)'; this.style.background='linear-gradient(135deg, #dc3545 0%, #c82333 100%)'">
                                            <i class="fas fa-sign-in-alt mr-2"></i>{{ __('common.login_title') }}
                                        </button>
                                    </div>
                                    <div style="text-align: center; margin-top: 15px;">
                                        <a href="#" onclick="event.preventDefault(); $('#modal-login-register').modal('hide'); $('#modal-forgot-password').modal('show');" 
                                           style="color: #dc3545; text-decoration: none; font-size: 14px; transition: color 0.3s;"
                                           onmouseover="this.style.color='#c82333'; this.style.textDecoration='underline';"
                                           onmouseout="this.style.color='#dc3545'; this.style.textDecoration='none';">
                                            <i class="fas fa-key mr-2"></i>{{ __('common.forgot_password') }}
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <!-- Login Form / End -->

                            <!-- Register Form -->
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form id="registerForm" class="modal-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 20px;">
                                                <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                                    <i class="fas fa-user mr-2" style="color: #dc3545;"></i>{{ __('common.name_placeholder') }}
                                                </label>
                                                <input type="text" class="form-control" name="name" placeholder="{{ __('common.name_placeholder') }}" required
                                                    style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                                    onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                                    onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 20px;">
                                                <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                                    <i class="fas fa-user mr-2" style="color: #dc3545;"></i>{{ __('common.surname_placeholder') }}
                                                </label>
                                                <input type="text" class="form-control" name="surname" placeholder="{{ __('common.surname_placeholder') }}" required
                                                    style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                                    onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                                    onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                            <i class="fas fa-phone mr-2" style="color: #dc3545;"></i>{{ __('common.phone_placeholder_form') }}
                                        </label>
                                        <input type="tel" class="form-control" id="gsm" name="gsm" placeholder="{{ __('common.phone_placeholder_form') }}" required
                                            style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s; width: 100%;"
                                            onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                            onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                    </div>
                                    <input type="hidden" id="gsm_country_code" name="country_code" value="">
                                    <div class="form-group" style="margin-bottom: 20px;">
                                        <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                            <i class="fas fa-envelope mr-2" style="color: #dc3545;"></i>{{ __('common.email_placeholder') }}
                                        </label>
                                        <input type="email" class="form-control" name="email" placeholder="{{ __('common.email_placeholder') }}" required
                                            style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                            onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                            onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 20px;">
                                                <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                                    <i class="fas fa-lock mr-2" style="color: #dc3545;"></i>{{ __('common.password_placeholder') }}
                                                </label>
                                                <input type="password" class="form-control" name="password" placeholder="{{ __('common.password_placeholder') }}" required
                                                    style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                                    onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                                    onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-bottom: 25px;">
                                                <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                                    <i class="fas fa-lock mr-2" style="color: #dc3545;"></i>{{ __('common.password_confirmation_placeholder') }}
                                                </label>
                                                <input type="password" class="form-control" name="password_confirmation"
                                                    placeholder="{{ __('common.password_confirmation_placeholder') }}" required
                                                    style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                                    onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                                    onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group--submit" style="margin-bottom: 15px;">
                                        <button type="button" onclick="registerUser()"
                                            class="btn btn-block"
                                            style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 14px; font-weight: 600; font-size: 16px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.6)'; this.style.background='linear-gradient(135deg, #c82333 0%, #bd2130 100%)'"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 53, 69, 0.4)'; this.style.background='linear-gradient(135deg, #dc3545 0%, #c82333 100%)'">
                                            <i class="fas fa-user-plus mr-2"></i>{{ __('common.create_account') }}
                                        </button>
                                    </div>
                                    <div class="modal-form--note" style="text-align: center; color: #999; font-size: 13px; margin-top: 15px;">
                                        @if(session('driverInfo') && session('driverInfo')->email_verified_at)
                                            <i class="fas fa-check-circle mr-2" style="color: #10b981;"></i>{{ __('common.email_verified') }}
                                        @else
                                            <i class="fas fa-info-circle mr-2" style="color: #dc3545;"></i>{{ __('common.register_note') }}
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <!-- Register Form / End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login/Register Modal / End -->

        <!-- Forgot Password Modal -->
        <div class="modal fade" id="modal-forgot-password" tabindex="-1" role="dialog" aria-labelledby="modal-forgot-password-label">
            <div class="modal-dialog modal-lg modal--login" role="document">
                <div class="modal-content" style="border-radius: 8px; border: none; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 20px 30px; border-bottom: 2px solid #dc3545; position: relative; display: flex; align-items: center; justify-content: space-between;">
                        <h4 class="modal-title text-white" id="modal-forgot-password-label" style="margin: 0; font-weight: 600; font-size: 20px; line-height: 1.2;">
                            <i class="fas fa-key mr-2" style="color: #dc3545;"></i><span id="forgot-password-modal-title">{{ __('common.forgot_password_title') }}</span>
                        </h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" 
                                style="opacity: 1; font-size: 24px; font-weight: 300; padding: 0; line-height: 1; background: rgba(0,0,0,0.3); border-radius: 4px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; transition: background 0.3s; margin: 0; border: none; position: relative; flex-shrink: 0;"
                                onmouseover="this.style.background='rgba(220, 53, 69, 0.5)'"
                                onmouseout="this.style.background='rgba(0,0,0,0.3)'">
                            <span aria-hidden="true" style="line-height: 1; display: block;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 30px; background: #222;">
                        <!-- Step 1: Email Input -->
                        <div id="forgot-password-step1">
                            <p style="color: #999; margin-bottom: 25px; font-size: 14px;">
                                {{ __('common.forgot_password_message') }}
                            </p>
                            <form id="forgotPasswordForm" class="modal-form">
                                @csrf
                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                        <i class="fas fa-envelope mr-2" style="color: #dc3545;"></i>{{ __('common.email_placeholder') }}
                                    </label>
                                    <input type="email" class="form-control" name="email" id="forgot-password-email"
                                        placeholder="{{ __('common.email_placeholder') }}" required
                                        style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                        onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                        onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                </div>
                                <div class="form-group form-group--submit" style="margin-bottom: 15px;">
                                    <button type="button" onclick="sendResetCode()"
                                        class="btn btn-block" 
                                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 14px; font-weight: 600; font-size: 16px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.6)'; this.style.background='linear-gradient(135deg, #c82333 0%, #bd2130 100%)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 53, 69, 0.4)'; this.style.background='linear-gradient(135deg, #dc3545 0%, #c82333 100%)'">
                                        <i class="fas fa-paper-plane mr-2"></i>{{ __('common.enter_reset_code') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Step 2: Code and New Password Input -->
                        <div id="forgot-password-step2" style="display: none;">
                            <p style="color: #999; margin-bottom: 25px; font-size: 14px;">
                                {{ __('common.reset_password_message') }}
                            </p>
                            <form id="resetPasswordForm" class="modal-form">
                                @csrf
                                <input type="hidden" name="email" id="reset-password-email">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                        <i class="fas fa-key mr-2" style="color: #dc3545;"></i>{{ __('common.reset_code_placeholder') }}
                                    </label>
                                    <input type="text" class="form-control" name="reset_code" id="reset-code-input"
                                        placeholder="{{ __('common.reset_code_placeholder') }}" required maxlength="4"
                                        style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s; text-align: center; font-size: 24px; letter-spacing: 8px; font-weight: bold; font-family: 'Courier New', monospace;"
                                        onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                        onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                                <div class="form-group" style="margin-bottom: 20px; text-align: center;">
                                    <button type="button" id="resend-code-btn" onclick="resendResetCode()" disabled
                                        style="background: #555; color: #999; border: none; border-radius: 6px; padding: 10px 20px; font-weight: 600; font-size: 14px; cursor: not-allowed; transition: all 0.3s;">
                                        <i class="fas fa-redo mr-2"></i><span id="resend-code-text">{{ __('common.resend_code') }}</span> <span id="resend-countdown"></span>
                                    </button>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                        <i class="fas fa-lock mr-2" style="color: #dc3545;"></i>{{ __('common.password_placeholder') }}
                                    </label>
                                    <input type="password" class="form-control" name="password" id="reset-password-new"
                                        placeholder="{{ __('common.password_placeholder') }}" required
                                        style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                        onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                        onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                </div>
                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label style="color: #fff; font-weight: 500; margin-bottom: 8px; display: block;">
                                        <i class="fas fa-lock mr-2" style="color: #dc3545;"></i>{{ __('common.password_confirmation_placeholder') }}
                                    </label>
                                    <input type="password" class="form-control" name="password_confirmation" id="reset-password-confirm"
                                        placeholder="{{ __('common.password_confirmation_placeholder') }}" required
                                        style="background: #333; border: 2px solid #444; color: #fff; border-radius: 6px; padding: 12px 15px; transition: all 0.3s;"
                                        onfocus="this.style.borderColor='#dc3545'; this.style.boxShadow='0 0 0 3px rgba(220, 53, 69, 0.2)'; this.style.background='#3a3a3a'"
                                        onblur="this.style.borderColor='#444'; this.style.boxShadow='none'; this.style.background='#333'">
                                </div>
                                <div class="form-group form-group--submit" style="margin-bottom: 15px;">
                                    <button type="button" onclick="resetPassword()"
                                        class="btn btn-block" 
                                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 14px; font-weight: 600; font-size: 16px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220, 53, 69, 0.6)'; this.style.background='linear-gradient(135deg, #c82333 0%, #bd2130 100%)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 53, 69, 0.4)'; this.style.background='linear-gradient(135deg, #dc3545 0%, #c82333 100%)'">
                                        <i class="fas fa-check mr-2"></i>{{ __('common.reset_password_title') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Forgot Password Modal / End -->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/js/intlTelInput.min.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <script>

        // Telefon numarası için ülke bazlı mask
        let iti = null;
        let gsmInput = null;
        
        function initPhoneInput() {
            gsmInput = document.querySelector('#gsm');
            if (gsmInput && !iti) {
                iti = window.intlTelInput(gsmInput, {
                    initialCountry: "tr",
                    preferredCountries: ["tr", "us", "gb", "de", "fr", "it", "es", "pt"],
                    separateDialCode: true,
                    nationalMode: false,
                    autoFormat: true,
                    autoPlaceholder: "aggressive",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/js/utils.js"
                });

            // Stil düzenlemeleri
            const itiContainer = gsmInput.closest('.form-group');
            const itiWrapper = gsmInput.parentElement;
            if (itiWrapper) {
                itiWrapper.style.position = 'relative';
                itiWrapper.style.display = 'block';
            }

            // IMask ile telefon numarası formatlama
            let phoneMask = null;
            
            function updatePhoneMask() {
                if (phoneMask) {
                    phoneMask.destroy();
                }
                
                const countryData = iti.getSelectedCountryData();
                const countryCode = countryData.iso2;
                
                // Ülkeye göre maske tanımlamaları (sadece numara kısmı, dial code ayrı gösteriliyor)
                const masks = {
                    'tr': '(000) 000 00 00',
                    'us': '(000) 000-0000',
                    'gb': '0000 000000',
                    'de': '000 00000000',
                    'fr': '0 00 00 00 00',
                    'it': '000 000 0000',
                    'es': '000 000 000',
                    'pt': '000 000 000'
                };
                
                // Varsayılan maske
                let maskPattern = masks[countryCode] || '000000000000';
                
                phoneMask = IMask(gsmInput, {
                    mask: maskPattern,
                    lazy: false
                });
            }

            // Input stillerini güncelle
            gsmInput.addEventListener('focus', function() {
                this.style.borderColor = '#dc3545';
                this.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.2)';
                this.style.background = '#3a3a3a';
            });

            gsmInput.addEventListener('blur', function() {
                this.style.borderColor = '#444';
                this.style.boxShadow = 'none';
                this.style.background = '#333';
            });
            
            // İlk maske oluşturma
            updatePhoneMask();

            // Ülke seçici stillerini düzenle
            gsmInput.addEventListener('countrychange', function() {
                const countryData = iti.getSelectedCountryData();
                document.getElementById('gsm_country_code').value = '+' + countryData.dialCode;
                
                // Maske'yi güncelle
                updatePhoneMask();
                
                // Input'u temizle
                gsmInput.value = '';
                
                // Ülke seçici dropdown stillerini güncelle
                const countryList = document.querySelector('.iti__country-list');
                if (countryList) {
                    countryList.style.background = '#333';
                    countryList.style.border = '2px solid #444';
                    countryList.style.color = '#fff';
                }
            });

            // İlk yüklemede ülke kodunu ayarla
            const initialCountryData = iti.getSelectedCountryData();
            document.getElementById('gsm_country_code').value = '+' + initialCountryData.dialCode;

            // Telefon numarası doğrulama fonksiyonu
            window.validatePhoneNumber = function() {
                if (!iti || !gsmInput || !iti.isValidNumber()) {
                    Swal.fire({
                        icon: 'error',
                        title: '<div style="font-size: 24px; font-weight: 600; color: #ef4444; margin-bottom: 10px;"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ __('common.error') }}</div>',
                        html: '<p style="font-size: 16px; color: #333; margin: 0;">Lütfen geçerli bir telefon numarası girin.</p>',
                        confirmButtonText: '{{ __('common.ok') }}',
                        confirmButtonColor: '#ef4444',
                        buttonsStyling: true,
                        customClass: {
                            popup: 'swal2-popup-custom',
                            confirmButton: 'swal2-confirm-custom'
                        }
                    });
                    return false;
                }
                const fullNumber = iti.getNumber();
                gsmInput.value = fullNumber;
                return true;
            };

            // CSS stilleri için ek düzenlemeler
            const style = document.createElement('style');
            style.textContent = `
                .iti {
                    width: 100%;
                }
                .iti__flag-container {
                    background: #333;
                    border-right: 2px solid #444;
                }
                .iti__selected-flag {
                    background: #333;
                    border-radius: 6px 0 0 6px;
                    padding: 12px 10px;
                }
                .iti__selected-flag:hover {
                    background: #3a3a3a;
                }
                .iti__arrow {
                    border-top-color: #fff;
                }
                .iti__country-list {
                    background: #333 !important;
                    border: 2px solid #444 !important;
                    color: #fff !important;
                }
                .iti__country {
                    color: #fff !important;
                }
                .iti__country:hover,
                .iti__country.iti__highlight {
                    background: #dc3545 !important;
                }
                .iti__dial-code {
                    color: #999;
                }
                #gsm {
                    padding-left: 80px !important;
                }
            `;
            document.head.appendChild(style);
            }
        }

        // Modal açıldığında telefon input'unu initialize et
        $('#modal-login-register').on('shown.bs.modal', function() {
            setTimeout(function() {
                if (!iti) {
                    initPhoneInput();
                }
            }, 100);
        });

        // Sayfa yüklendiğinde de initialize et
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPhoneInput);
        } else {
            initPhoneInput();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function yapimAsamasinda() {
            Swal.fire({
                title: '{{ __('common.under_construction') }}',
                text: '{{ __('common.under_construction_text') }}',
                icon: 'warning',
                confirmButtonText: '{{ __('common.ok') }}'
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
                    });;
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
                            window.location.href = '{{ route('home') }}';
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

        function registerUser() {
            // Telefon numarası doğrulaması
            if (typeof window.validatePhoneNumber === 'function' && !window.validatePhoneNumber()) {
                return;
            }

            $.ajax({
                url: '{{ route('DregisterPost') }}',
                type: 'POST',
                data: $('#registerForm').serialize(),
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
                            title: '<div style="font-size: 24px; font-weight: 600; color: #10b981; margin-bottom: 10px;"><i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ __('common.register_success') }}</div>',
                            html: '<p style="font-size: 16px; color: #333; margin: 0 0 15px 0;">{{ __('common.register_success_text') }}</p>',
                            confirmButtonText: '{{ __('common.ok') }}',
                            confirmButtonColor: '#10b981',
                            buttonsStyling: true,
                            footer: '<div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;"><small style="color: #6b7280; font-size: 13px;"><i class="fas fa-info-circle" style="margin-right: 5px; color: #3b82f6;"></i>{{ __('common.mail_delivery_time') }}</small></div>',
                            customClass: {
                                popup: 'swal2-popup-custom',
                                confirmButton: 'swal2-confirm-custom'
                            }
                        }).then(() => {
                            window.location.href = '{{ route('home') }}';
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

        function sendResetCode() {
            const email = $('#forgot-password-email').val();
            if (!email) {
                Swal.fire({
                    icon: 'error',
                    title: '<div style="font-size: 24px; font-weight: 600; color: #ef4444; margin-bottom: 10px;"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ __('common.error') }}</div>',
                    html: '<p style="font-size: 16px; color: #333; margin: 0;">{{ __('common.email_required') }}</p>',
                    confirmButtonText: '{{ __('common.ok') }}',
                    confirmButtonColor: '#ef4444',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'swal2-confirm-custom'
                    }
                });
                return;
            }

            $.ajax({
                url: '{{ route('DforgotPasswordPost') }}',
                type: 'POST',
                data: {
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
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
                            title: '<div style="font-size: 24px; font-weight: 600; color: #10b981; margin-bottom: 10px;"><i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ __('common.success') }}</div>',
                            html: '<p style="font-size: 16px; color: #333; margin: 0 0 15px 0;">' + response.aciklama + '</p>',
                            confirmButtonText: '{{ __('common.ok') }}',
                            confirmButtonColor: '#10b981',
                            buttonsStyling: true,
                            footer: '<div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;"><small style="color: #6b7280; font-size: 13px;"><i class="fas fa-info-circle" style="margin-right: 5px; color: #3b82f6;"></i>{{ __('common.mail_delivery_time') }}</small></div>',
                            customClass: {
                                popup: 'swal2-popup-custom',
                                confirmButton: 'swal2-confirm-custom'
                            }
                        }).then(() => {
                            // Step 2'ye geç
                            $('#forgot-password-step1').hide();
                            $('#forgot-password-step2').show();
                            $('#reset-password-email').val(email);
                            $('#forgot-password-modal-title').text('{{ __('common.reset_password_title') }}');
                            $('#reset-code-input').focus();
                            // 2 dakika geri sayım başlat
                            startResendCountdown();
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

        function resetPassword() {
            const resetCode = $('#reset-code-input').val();
            const password = $('#reset-password-new').val();
            const passwordConfirmation = $('#reset-password-confirm').val();
            const email = $('#reset-password-email').val();

            if (!resetCode || resetCode.length !== 4) {
                Swal.fire({
                    icon: 'error',
                    title: '<div style="font-size: 24px; font-weight: 600; color: #ef4444; margin-bottom: 10px;"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ __('common.error') }}</div>',
                    html: '<p style="font-size: 16px; color: #333; margin: 0;">{{ __('common.reset_code_required') }}</p>',
                    confirmButtonText: '{{ __('common.ok') }}',
                    confirmButtonColor: '#ef4444',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'swal2-confirm-custom'
                    }
                });
                return;
            }

            if (!password || password.length < 6) {
                Swal.fire({
                    icon: 'error',
                    title: '<div style="font-size: 24px; font-weight: 600; color: #ef4444; margin-bottom: 10px;"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ __('common.error') }}</div>',
                    html: '<p style="font-size: 16px; color: #333; margin: 0;">{{ __('common.password_min_length') }}</p>',
                    confirmButtonText: '{{ __('common.ok') }}',
                    confirmButtonColor: '#ef4444',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'swal2-confirm-custom'
                    }
                });
                return;
            }

            if (password !== passwordConfirmation) {
                Swal.fire({
                    icon: 'error',
                    title: '<div style="font-size: 24px; font-weight: 600; color: #ef4444; margin-bottom: 10px;"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ __('common.error') }}</div>',
                    html: '<p style="font-size: 16px; color: #333; margin: 0;">{{ __('common.password_confirmed') }}</p>',
                    confirmButtonText: '{{ __('common.ok') }}',
                    confirmButtonColor: '#ef4444',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'swal2-confirm-custom'
                    }
                });
                return;
            }

            $.ajax({
                url: '{{ route('DresetPasswordPost') }}',
                type: 'POST',
                data: {
                    email: email,
                    reset_code: resetCode,
                    password: password,
                    password_confirmation: passwordConfirmation,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
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
                            title: '<div style="font-size: 24px; font-weight: 600; color: #10b981; margin-bottom: 10px;"><i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ __('common.success') }}</div>',
                            html: '<p style="font-size: 16px; color: #333; margin: 0;">' + response.aciklama + '</p>',
                            confirmButtonText: '{{ __('common.ok') }}',
                            confirmButtonColor: '#10b981',
                            buttonsStyling: true,
                            customClass: {
                                popup: 'swal2-popup-custom',
                                confirmButton: 'swal2-confirm-custom'
                            }
                        }).then(() => {
                            $('#modal-forgot-password').modal('hide');
                            $('#modal-login-register').modal('show');
                            // Formları temizle
                            $('#forgotPasswordForm')[0].reset();
                            $('#resetPasswordForm')[0].reset();
                            $('#forgot-password-step1').show();
                            $('#forgot-password-step2').hide();
                            $('#forgot-password-modal-title').text('{{ __('common.forgot_password_title') }}');
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

        // Geri sayım değişkeni
        let resendCountdownInterval = null;
        let resendCountdownSeconds = 120; // 2 dakika = 120 saniye

        function startResendCountdown() {
            // Önceki interval'i temizle
            if (resendCountdownInterval) {
                clearInterval(resendCountdownInterval);
            }
            
            resendCountdownSeconds = 120; // 2 dakika
            const resendBtn = $('#resend-code-btn');
            const resendText = $('#resend-code-text');
            const countdownSpan = $('#resend-countdown');
            
            // Butonu devre dışı bırak
            resendBtn.prop('disabled', true);
            resendBtn.css({
                'background': '#555',
                'color': '#999',
                'cursor': 'not-allowed'
            });
            
            resendCountdownInterval = setInterval(function() {
                const minutes = Math.floor(resendCountdownSeconds / 60);
                const seconds = resendCountdownSeconds % 60;
                const timeString = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                
                countdownSpan.text('(' + timeString + ')');
                
                resendCountdownSeconds--;
                
                if (resendCountdownSeconds < 0) {
                    clearInterval(resendCountdownInterval);
                    resendBtn.prop('disabled', false);
                    resendBtn.css({
                        'background': 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)',
                        'color': 'white',
                        'cursor': 'pointer'
                    });
                    countdownSpan.text('');
                }
            }, 1000);
        }

        function resendResetCode() {
            const email = $('#reset-password-email').val();
            if (!email) {
                Swal.fire({
                    icon: 'error',
                    title: '<div style="font-size: 24px; font-weight: 600; color: #ef4444; margin-bottom: 10px;"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ __('common.error') }}</div>',
                    html: '<p style="font-size: 16px; color: #333; margin: 0;">{{ __('common.email_required') }}</p>',
                    confirmButtonText: '{{ __('common.ok') }}',
                    confirmButtonColor: '#ef4444',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'swal2-popup-custom',
                        confirmButton: 'swal2-confirm-custom'
                    }
                });
                return;
            }

            $.ajax({
                url: '{{ route('DforgotPasswordPost') }}',
                type: 'POST',
                data: {
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
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
                            title: '<div style="font-size: 24px; font-weight: 600; color: #10b981; margin-bottom: 10px;"><i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ __('common.success') }}</div>',
                            html: '<p style="font-size: 16px; color: #333; margin: 0 0 15px 0;">' + response.aciklama + '</p>',
                            confirmButtonText: '{{ __('common.ok') }}',
                            confirmButtonColor: '#10b981',
                            buttonsStyling: true,
                            footer: '<div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;"><small style="color: #6b7280; font-size: 13px;"><i class="fas fa-info-circle" style="margin-right: 5px; color: #3b82f6;"></i>{{ __('common.mail_delivery_time') }}</small></div>',
                            customClass: {
                                popup: 'swal2-popup-custom',
                                confirmButton: 'swal2-confirm-custom'
                            }
                        });
                        // Geri sayımı yeniden başlat
                        startResendCountdown();
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

        // Modal kapandığında formları sıfırla
        $('#modal-forgot-password').on('hidden.bs.modal', function() {
            $('#forgotPasswordForm')[0].reset();
            $('#resetPasswordForm')[0].reset();
            $('#forgot-password-step1').show();
            $('#forgot-password-step2').hide();
            $('#forgot-password-modal-title').text('{{ __('common.forgot_password_title') }}');
            // Geri sayımı durdur
            if (resendCountdownInterval) {
                clearInterval(resendCountdownInterval);
                resendCountdownInterval = null;
            }
            $('#resend-countdown').text('');
            $('#resend-code-btn').prop('disabled', false);
            $('#resend-code-btn').css({
                'background': 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)',
                'color': 'white',
                'cursor': 'pointer'
            });
        });

        // Logout linklerini form submit'e çevir
        $(document).on('click', 'a[href="{{ route('Dlogout') }}"]', function(e) {
            e.preventDefault();
            // Form oluştur ve submit et
            var form = $('<form>', {
                'method': 'POST',
                'action': '{{ route('Dlogout') }}'
            });
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '{{ csrf_token() }}'
            }));
            $('body').append(form);
            form.submit();
        });

        // Dil değiştirme
        document.addEventListener('DOMContentLoaded', function() {
            const languageSelect = document.getElementById('language-select');
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
                            // Sayfayı yenile
                            window.location.reload();
                        } else {
                            alert('{{ __('common.language_change_failed') }}');
                            // Select'i eski değere geri al
                            languageSelect.value = '{{ app()->getLocale() }}';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('{{ __('common.language_change_error') }}');
                        // Select'i eski değere geri al
                        languageSelect.value = '{{ app()->getLocale() }}';
                    });
                });
            }
        });
    </script>
    
    <!-- Logout Success Toast -->
    @if(session('logout_success'))
    <script>
        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            
            Toast.fire({
                icon: 'success',
                title: '<div style="display: flex; align-items: center; gap: 12px;"><i class="fas fa-sign-out-alt" style="font-size: 22px; color: #10b981;"></i><div><div style="font-weight: 600; font-size: 16px; color: #1f2937; margin-bottom: 4px;">{{ __('common.logout_success') }}</div><div style="font-size: 14px; color: #6b7280;">{{ __('common.logout_success_text') }}</div></div></div>',
                background: '#ffffff',
                customClass: {
                    popup: 'swal2-toast-custom'
                }
            });
        });
    </script>
    @endif
    <!-- Logout Success Toast / End -->
    
    <!-- Theme Toggle Script -->
    <script>
        // Tema yükleme
        function loadTheme() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            const htmlRoot = document.getElementById('html-root');
            const themeIcon = document.getElementById('theme-icon');
            const themeBetaText = document.getElementById('theme-beta-text');
            
            if (savedTheme === 'light') {
                htmlRoot.setAttribute('data-theme', 'light');
                if (themeIcon) {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                }
                if (themeBetaText) {
                    themeBetaText.style.display = 'inline';
                }
            } else {
                htmlRoot.setAttribute('data-theme', 'dark');
                if (themeIcon) {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
                if (themeBetaText) {
                    themeBetaText.style.display = 'none';
                }
            }
        }
        
        // Tema değiştirme
        function toggleTheme() {
            const htmlRoot = document.getElementById('html-root');
            const themeIcon = document.getElementById('theme-icon');
            const themeBetaText = document.getElementById('theme-beta-text');
            const currentTheme = htmlRoot.getAttribute('data-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            htmlRoot.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            if (themeIcon) {
                if (newTheme === 'light') {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            }
            
            if (themeBetaText) {
                if (newTheme === 'light') {
                    themeBetaText.style.display = 'inline';
                } else {
                    themeBetaText.style.display = 'none';
                }
            }
        }
        
        // Sayfa yüklendiğinde temayı yükle
        document.addEventListener('DOMContentLoaded', function() {
            loadTheme();
        });
    </script>
    <!-- Theme Toggle Script / End -->
</body>

</html>
