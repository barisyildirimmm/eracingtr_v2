<header class="app-header">
    <nav class="main-header !h-[3.75rem]" aria-label="Global">
        <div class="main-header-container ps-[0.725rem] pe-[1rem] ">

            <div class="header-content-left">
                <!-- Start::header-element -->
                <div class="header-element">
                    <div class="horizontal-logo">
                        <a href="{{ route('Dhome') }}" class="header-logo">
                            <img src="{{ asset('assets/img/logo/logo_yuvarlak.png') }}" alt="logo" class="toggle-dark.png">
{{--                            <img src="{{ asset('assets/panel/images/brand-logos/desktop-logo.png') }}" alt="logo"--}}
{{--                                class="desktop-logo">--}}
{{--                            <img src="{{ asset('assets/panel/images/brand-logos/toggle-logo.png') }}" alt="logo"--}}
{{--                                class="toggle-logo">--}}
{{--                            <img src="{{ asset('assets/panel/images/brand-logos/desktop-dark.png') }}" alt="logo"--}}
{{--                                class="desktop-dark">--}}
{{--                            <img src="{{ asset('assets/panel/images/brand-logos/toggle-dark.png') }}" alt="logo"--}}
{{--                                class="toggle-dark">--}}
{{--                            <img src="{{ asset('assets/panel/images/brand-logos/desktop-white.png') }}" alt="logo"--}}
{{--                                class="desktop-white">--}}
{{--                            <img src="{{ asset('assets/panel/images/brand-logos/toggle-white.png') }}" alt="logo"--}}
{{--                                class="toggle-white">--}}
                        </a>
                    </div>
                </div>
                <!-- End::header-element -->
                <!-- Start::header-element -->
                <div class="header-element md:px-[0.325rem] !items-center">
                    <!-- Start::header-link -->
                    <a aria-label="Hide Sidebar"
                        class="sidemenu-toggle animated-arrow  hor-toggle horizontal-navtoggle inline-flex items-center"
                        href="javascript:void(0);"><span></span></a>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->
            </div>



            <div class="header-content-right">
                <!-- light and dark theme -->
                <div
                    class="header-element header-theme-mode hidden !items-center sm:block !py-[1rem] md:!px-[0.65rem] px-2">
                    <a aria-label="anchor"
                        class="hs-dark-mode-active:hidden flex hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium transition-all text-xs dark:bg-bgdark dark:hover:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                        href="javascript:void(0);" data-hs-theme-click-value="dark">
                        <i class="bx bx-moon header-link-icon"></i>
                    </a>
                    <a aria-label="anchor"
                        class="hs-dark-mode-active:flex hidden hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium text-defaulttextcolor  transition-all text-xs dark:bg-bodybg dark:bg-bgdark dark:hover:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                        href="javascript:void(0);" data-hs-theme-click-value="light">
                        <i class="bx bx-sun header-link-icon"></i>
                    </a>
                </div>
                <!-- End light and dark theme -->

                <!-- Header Profile -->
                <div
                    class="header-element md:!px-[0.65rem] px-2 hs-dropdown !items-center ti-dropdown [--placement:bottom-left]">

                    <button id="dropdown-profile" type="button"
                        class="hs-dropdown-toggle ti-dropdown-toggle !gap-2 !p-0 flex-shrink-0 sm:me-2 me-0 !rounded-full !shadow-none text-xs align-middle !border-0 !shadow-transparent ">
                        <img class="inline-block rounded-full" style="border: 1px solid #CCC" src="{{ asset('assets/img/drivers/'.session('driverInfo')->id.'.png') }}"
                            width="50" height="50" alt="Image Description">
                    </button>
                    <div class="md:block hidden dropdown-profile">
                        <p class="font-semibold mb-0 leading-none text-[#536485] text-[0.813rem] ">
                            {{ session('driverInfo')->name . ' ' . session('driverInfo')->surname }}
                        </p>
                    </div>
                    <div class="hs-dropdown-menu ti-dropdown-menu !-mt-3 border-0 w-[11rem] !p-0 border-defaultborder hidden main-header-dropdown  pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                        aria-labelledby="dropdown-profile">

                        <ul class="text-defaulttextcolor font-medium dark:text-[#8c9097] dark:text-white/50">
{{--                            <li>--}}
{{--                                <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0  !p-[0.65rem] !inline-flex"--}}
{{--                                    href="profile.html">--}}
{{--                                    <i class="ti ti-user-circle text-[1.125rem] me-2 opacity-[0.7]"></i>Profile--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0  !p-[0.65rem] !inline-flex"--}}
{{--                                    href="mail.html"><i class="ti ti-inbox text-[1.125rem] me-2 opacity-[0.7]"></i>Inbox--}}
{{--                                    <span--}}
{{--                                        class="!py-1 !px-[0.45rem] !font-semibold !rounded-sm text-success text-[0.75em] bg-success/10 ms-auto">25</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0 !p-[0.65rem] !inline-flex"--}}
{{--                                    href="todo.html"><i--}}
{{--                                        class="ti ti-clipboard-check text-[1.125rem] me-2 opacity-[0.7]"></i>Task--}}
{{--                                    Manager</a></li>--}}
{{--                            <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0 !p-[0.65rem] !inline-flex"--}}
{{--                                    href="mail-settings.html"><i--}}
{{--                                        class="ti ti-adjustments-horizontal text-[1.125rem] me-2 opacity-[0.7]"></i>Settings</a>--}}
{{--                            </li>--}}
{{--                            <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0 !p-[0.65rem] !inline-flex "--}}
{{--                                    href="javascript:void(0);"><i--}}
{{--                                        class="ti ti-wallet text-[1.125rem] me-2 opacity-[0.7]"></i>Bal:--}}
{{--                                    $7,12,950</a></li>--}}
{{--                            <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex"--}}
{{--                                    href="chat.html"><i--}}
{{--                                        class="ti ti-headset text-[1.125rem] me-2 opacity-[0.7]"></i>Support</a>--}}
{{--                            </li>--}}
                            <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex"
                                    href="{{ route('Dlogout') }}"><i
                                        class="ti ti-logout text-[1.125rem] me-2 opacity-[0.7]"></i>Çıkış Yap</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End Header Profile -->

                {{-- <!-- Switcher Icon -->
                <div class="header-element md:px-[0.48rem]">
                    <button aria-label="button" type="button"
                        class="hs-dropdown-toggle switcher-icon inline-flex flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium  align-middle transition-all text-xs dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                        data-hs-overlay="#hs-overlay-switcher">
                        <i class="bx bx-cog header-link-icon animate-spin-slow"></i>
                    </button>
                </div>
                <!-- Switcher Icon --> --}}

                <!-- End::header-element -->
            </div>
        </div>
    </nav>
</header>
