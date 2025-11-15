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
                        <li class=""><a href="#" class="text-white">LİGLER</a>
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
                                                                    <span>Puan Tablosu</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a href="{{ route('f1Leagues.results', $leagueD->link) }}" class="text-white">
                                                                    <i class="fas fa-flag-checkered mr-2"></i>
                                                                    <span>Yarış Sonuçları</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a onclick="yapimAsamasinda()" class="nav-sub-btn text-white">
                                                                    <i class="fas fa-balance-scale mr-2"></i>
                                                                    <span>Hakem Kararları</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a onclick="yapimAsamasinda()" class="nav-sub-btn text-white">
                                                                    <i class="fas fa-video mr-2"></i>
                                                                    <span>Canlı Yayınlar</span>
                                                                </a>
                                                            </li>
                                                            <li class="d-flex align-items-center mb-2">
                                                                <a onclick="yapimAsamasinda()" class="nav-sub-btn text-white">
                                                                    <i class="fas fa-calendar-alt mr-2"></i>
                                                                    <span>Fikstür</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endforeach

                                                @if (!count($f1Leagues))
                                                    <span class="text-white">Aktif Lig Bulunmamaktadır..</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><a class="nav-btn text-white" onclick="yapimAsamasinda()">İSTATİSTİKLER</a></li>
                        <li><a class="nav-btn text-white" href="{{ route('roolBook') }}">KURAL KİTAPÇIĞI</a></li>
                        <li><a class="nav-btn text-white" onclick="yapimAsamasinda()">TAKVİM</a></li>
                        @if (!session('driverInfo'))
                            <li><a class="nav-btn text-danger" data-toggle="modal" data-target="#modal-login-register">BAŞVURU</a></li>
                        @endif
                    </ul>

                    <!-- Social Links -->
                    <ul class="social-links social-links--inline social-links--main-nav">
                        <li class="social-links__item">
                            <a href="https://www.twitch.tv/eracingtr" target="_blank" class="social-links__link text-white">
                                <i class="fab fa-twitch"></i>
                            </a>
                        </li>
                        <li class="social-links__item">
                            <a href="https://www.youtube.com/eracingtr" target="_blank" class="social-links__link text-white">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                        <li class="social-links__item">
                            <a href="https://x.com/eracingtr" target="_blank" class="social-links__link text-white">
                                <i class="fab fa-x"></i>
                            </a>
                        </li>
                        <li class="social-links__item">
                            <a href="https://www.instagram.com/eracingtr" target="_blank" class="social-links__link text-white">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- Social Links / End -->
                </nav>
                <!-- Main Navigation / End -->
            </div>
        </div>
    </div>
    <!-- Header Primary / End -->

</header>
<!-- Header / End -->
