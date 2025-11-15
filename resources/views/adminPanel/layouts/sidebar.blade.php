<aside class="app-sidebar" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('Ahome') }}" class="header-logo">
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
                    <a href="{{ route('admin.leagues.list') }}" class="side-menu__item">
                        <i class='bx bxs-flag-checkered side-menu__icon'></i>
                        <span class="side-menu__label">Ligler</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.drivers.list') }}" class="side-menu__item">
                        <i class='bx bx-user side-menu__icon'></i>
                        <span class="side-menu__label">Pilotlar</span>
                    </a>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class='bx bxs-bolt side-menu__icon'></i>
                        <span class="side-menu__label">Hakem Kurulu</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="{{ route('admin.leagues.list') }}" class="side-menu__item">Cezalar</a>
                        </li>
                        <li class="slide">
                            <a href="" class="side-menu__item">Ceza Tanımları</a>
                        </li>
                        <li class="slide">
                            <a href="" class="side-menu__item">Kural Kitapçığı</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.teams.list') }}" class="side-menu__item">
                        <i class='bx bx-car side-menu__icon'></i>
                        <span class="side-menu__label">Takımlar</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.tracks.list') }}" class="side-menu__item">
                        <i class="las la-road side-menu__icon"></i>
                        <span class="side-menu__label">Pistler</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.postContents.list') }}" class="side-menu__item">
                        <i class='bx bx-photo-album side-menu__icon' ></i>
                        <span class="side-menu__label">Hazır Paylaşımlar</span>
                    </a>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class='bx bx-cog side-menu__icon' ></i>
                        <span class="side-menu__label">Ayarlar</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="{{ route('admin.admins.list') }}" class="side-menu__item">Kullanıcılar</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.config.socialMediaPostUpdate') }}" class="side-menu__item">Sosyal Medya Güncelleme</a>
                        </li>
                        <li class="slide">
                            <a href="" class="side-menu__item">Site Ayarları</a>
                        </li>
                    </ul>
                </li>
{{--                <li class="slide">--}}
{{--                    <a href="widgets.html" class="side-menu__item">--}}
{{--                        <i class="bx bx-gift side-menu__icon"></i>--}}
{{--                        <span class="side-menu__label">Widgets <span--}}
{{--                                    class="text-danger text-[0.75em] rounded-sm badge !py-[0.25rem] !px-[0.45rem] !bg-danger/10 ms-2">Hot</span></span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="slide has-sub">--}}
{{--                    <a href="javascript:void(0);" class="side-menu__item">--}}
{{--                        <i class="bx bx-layer side-menu__icon"></i>--}}
{{--                        <span class="side-menu__label">Nested Menu</span>--}}
{{--                        <i class="fe fe-chevron-right side-menu__angle"></i>--}}
{{--                    </a>--}}
{{--                    <ul class="slide-menu child1">--}}
{{--                        <li class="slide side-menu__label1">--}}
{{--                            <a href="javascript:void(0)">Nested Menu</a>--}}
{{--                        </li>--}}
{{--                        <li class="slide">--}}
{{--                            <a href="javascript:void(0);" class="side-menu__item">Nested-1</a>--}}
{{--                        </li>--}}
{{--                        <li class="slide has-sub">--}}
{{--                            <a href="javascript:void(0);" class="side-menu__item">Nested-2--}}
{{--                                <i class="fe fe-chevron-right side-menu__angle"></i></a>--}}
{{--                            <ul class="slide-menu child2">--}}
{{--                                <li class="slide">--}}
{{--                                    <a href="javascript:void(0);" class="side-menu__item">Nested-2-1</a>--}}
{{--                                </li>--}}
{{--                                <li class="slide has-sub">--}}
{{--                                    <a href="javascript:void(0);" class="side-menu__item">Nested-2-2--}}
{{--                                        <i class="fe fe-chevron-right side-menu__angle"></i></a>--}}
{{--                                    <ul class="slide-menu child3">--}}
{{--                                        <li class="slide">--}}
{{--                                            <a href="javascript:void(0);" class="side-menu__item">Nested-2-2-1</a>--}}
{{--                                        </li>--}}
{{--                                        <li class="slide">--}}
{{--                                            <a href="javascript:void(0);" class="side-menu__item">Nested-2-2-2</a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
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
