<!-- Header Mobile -->
<div class="header-mobile clearfix" id="header-mobile" style="background: #222;">
    <div class="header-mobile__logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo/logo.png?v=2') }}" alt="eRacingTR" class="header-mobile__logo-img">
        </a>
    </div>
    <div class="header-mobile__inner">
        <a id="header-mobile__toggle" class="burger-menu-icon"><span class="burger-menu-icon__line"></span></a>
    </div>
</div>

<!-- Header Desktop -->
<header class="header header--layout-1">

    <!-- Header Top Bar -->
    <div class="header__top-bar" style="background: #1a1a1a; padding: 8px 0; border-bottom: 1px solid #333;">
        <div class="container">
            <div class="header__top-bar-inner" style="display: flex; justify-content: flex-end; align-items: center; gap: 20px;">
                <!-- Language Switcher -->
                <div class="language-switcher" style="display: inline-flex; align-items: center;">
                    <select id="language-select" 
                            style="background: #333; color: white; border: 1px solid #555; padding: 5px 10px; border-radius: 4px; cursor: pointer; outline: none; font-size: 13px;">
                        <option value="tr" {{ app()->getLocale() == 'tr' ? 'selected' : '' }}>🇹🇷 TR</option>
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧 EN</option>
                        <option value="de" {{ app()->getLocale() == 'de' ? 'selected' : '' }}>🇩🇪 DE</option>
                        <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>🇫🇷 FR</option>
                        <option value="it" {{ app()->getLocale() == 'it' ? 'selected' : '' }}>🇮🇹 IT</option>
                        <option value="pt" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>🇵🇹 PT</option>
                        <option value="es" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>🇪🇸 ES</option>
                        <option value="az" {{ app()->getLocale() == 'az' ? 'selected' : '' }}>🇦🇿 AZ</option>
                    </select>
                </div>
                <!-- Language Switcher / End -->

                <!-- Social Links -->
                <ul class="social-links social-links--inline" style="display: flex; list-style: none; margin: 0; padding: 0; gap: 10px;">
                    <li class="social-links__item">
                        <a href="https://www.twitch.tv/eracingtr" target="_blank" class="social-links__link text-white" style="font-size: 16px; transition: color 0.3s;">
                            <i class="fab fa-twitch"></i>
                        </a>
                    </li>
                    <li class="social-links__item">
                        <a href="https://www.youtube.com/eracingtr" target="_blank" class="social-links__link text-white" style="font-size: 16px; transition: color 0.3s;">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                    <li class="social-links__item">
                        <a href="https://x.com/eracingtr" target="_blank" class="social-links__link text-white" style="font-size: 16px; transition: color 0.3s;">
                            <i class="fab fa-x"></i>
                        </a>
                    </li>
                    <li class="social-links__item">
                        <a href="https://www.instagram.com/eracingtr" target="_blank" class="social-links__link text-white" style="font-size: 16px; transition: color 0.3s;">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                </ul>
                <!-- Social Links / End -->
            </div>
        </div>
    </div>
    <!-- Header Top Bar / End -->

    <!-- Header Primary -->
    <div class="header__primary">
        <div class="container">
            <div class="header__primary-inner">
                <!-- Header Logo -->
                <div class="header-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/logo/logo.png?v=2') }}" alt="eRacingTR" class="header-logo__img">
                    </a>
                </div>

                <!-- Main Navigation -->
                <nav class="main-nav clearfix">
                    <ul class="main-nav__list">
                        <li class=""><a href="#" class="text-white">{{ __('common.leagues') }}</a>
                            <div class="main-nav__megamenu clearfix" style="background: #333;">
                                <div class="col-lg-4 col-md-3 col-12">
                                    <div class="posts posts--simple-list posts--simple-list--lg">
                                        <div class="posts__item posts__item--category-1">
                                            <div class="posts__inner">
                                                @foreach ($f1Leagues as $leagueD)
                                                    <div class="posts__cat">
                                                        <span class="label posts__cat-label text-white"
                                                              style="font-size:12px; background: #555;">{{ $leagueD->name }}</span>
                                                    </div>
                                                    <div class="posts__excerpt">
                                                        <ul class="list-unstyled pl-0">
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a href="{{ route('f1Leagues.pointTable', $leagueD->link) }}" class="text-white">
                                                                    <i class="fas fa-chart-bar mr-2"></i>
                                                                    <span>{{ __('common.point_table') }}</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a href="{{ route('f1Leagues.results', $leagueD->link) }}" class="text-white">
                                                                    <i class="fas fa-flag-checkered mr-2"></i>
                                                                    <span>{{ __('common.race_results') }}</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a href="{{ route('f1Leagues.refDecisions', $leagueD->link) }}" class="nav-sub-btn text-white">
                                                                    <i class="fas fa-balance-scale mr-2"></i>
                                                                    <span>{{ __('common.referee_decisions') }}</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a href="{{ route('f1Leagues.liveBroadcasts', $leagueD->link) }}" class="nav-sub-btn text-white">
                                                                    <i class="fas fa-video mr-2"></i>
                                                                    <span>{{ __('common.live_broadcasts') }}</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a href="{{ route('f1Leagues.schedule', $leagueD->link) }}" class="nav-sub-btn text-white">
                                                                    <i class="fas fa-calendar-alt mr-2"></i>
                                                                    <span>{{ __('common.schedule') }}</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endforeach

                                                @if (!count($f1Leagues))
                                                    <span class="text-white">{{ __('common.no_active_league') }}</span>
                                                @endif
                                                
                                                <div class="posts__cat mt-3">
                                                    <span class="label posts__cat-label text-white"
                                                          style="font-size:12px; background: #555;">{{ __('common.past_seasons') }}</span>
                                                </div>
                                                <div class="posts__excerpt">
                                                    <ul class="list-unstyled pl-0">
                                                        <li class="d-flex align-items-center mb-2">
                                                            <a href="{{ route('f1Leagues.pastSeasons') }}" class="text-white">
                                                                <i class="fas fa-history mr-2"></i>
                                                                <span>{{ __('common.all_past_seasons') }}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><a class="nav-btn text-white" href="{{ route('statistics') }}">{{ __('common.statistics') }}</a></li>
                        <li><a class="nav-btn text-white" href="{{ route('roolBook') }}">{{ __('common.rule_book') }}</a></li>
                        <li><a class="nav-btn text-white" href="{{ route('calendar') }}">{{ __('common.calendar') }}</a></li>
                        @if (!session('driverInfo'))
                            <li><a class="nav-btn text-danger" data-toggle="modal" data-target="#modal-login-register">{{ __('common.application') }}</a></li>
                        @endif
                    </ul>
                </nav>
                <!-- Main Navigation / End -->
            </div>
        </div>
    </div>
    <!-- Header Primary / End -->

</header>
<!-- Header / End -->
