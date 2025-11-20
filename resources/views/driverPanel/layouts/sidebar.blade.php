<aside class="app-sidebar" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('Dhome') }}" class="header-logo">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" class="toggle-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg></div>
            <ul class="main-menu">

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('Dhome') }}" class="side-menu__item">
                        <i class='bx bx-stats side-menu__icon'></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('driver.profile') }}" class="side-menu__item">
                        <i class='bx bx-user side-menu__icon'></i>
                        <span class="side-menu__label">{{ __('common.profile') }}</span>
                    </a>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class='bx bx-video-recording side-menu__icon'></i>
                        <span class="side-menu__label">{{ __('common.referee_decisions') }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Dashboards</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('referee.decisions.complaints') }}" class="side-menu__item">{{ __('common.my_complaints') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('referee.decisions.defenses') }}" class="side-menu__item">{{ __('common.my_defenses') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('referee.decisions.appeals') }}" class="side-menu__item">{{ __('common.my_appeals') }}</a>
                        </li>
                    </ul>
                </li>
{{--                <li class="slide">--}}
{{--                    <a href="" class="side-menu__item">--}}
{{--                        <i class='bx bx-cog side-menu__icon'></i>--}}
{{--                        <span class="side-menu__label">Ayarlar</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="slide">--}}
{{--                    <a href="{{ route('home') }}" class="side-menu__item">--}}
{{--                        <i class='bx bx-message-rounded side-menu__icon'></i>--}}
{{--                        <span class="side-menu__label">Hakem Bölümü</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="slide">
                    <a href="{{ route('home') }}" class="side-menu__item">
                        <i class='bx bx-undo side-menu__icon'></i>
                        <span class="side-menu__label">{{ __('common.return_to_site') }}</span>
                    </a>
                </li>
                <!-- End::slide -->

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>

    <!-- End::main-sidebar -->

</aside>
