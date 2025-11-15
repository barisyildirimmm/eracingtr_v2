@extends('layouts.layout')

@section('content')
    @include('layouts.upSlider')
    {{-- @include('layouts.slider') --}}
    <!-- Content
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ================================================== -->
    <div class="site-content">
        <div class="container">
            <div class="row">
                <!-- Content -->
                <div class="content col-lg-8">

                    <!-- Post Area 1 -->
                    <div class="posts posts--cards post-grid row">

                        @foreach ($instagramPosts as $post)
                            <div class="post-grid__item col-sm-6">
                                <div class="posts__item posts__item--card posts__item--category-1 card">
                                    <figure class="posts__thumb">
                                        {{-- <div class="posts__cat">
                                            <span class="label posts__cat-label">The Team</span>
                                        </div> --}}
                                        @if ($post->media_type == 'IMAGE' || $post->media_type == 'CAROUSEL_ALBUM')
                                            {{-- Eğer media_type IMAGE ise resim göster --}}
{{--                                            @if($post->timestamp > '2025-01-01 00:00:00')--}}
                                                <a href="{{ $post->permalink }}" target="_blank">
                                                    <img src="{{ asset('assets/img/instagram/' . $post->instagram_id . '.jpg') }}" alt="">
                                                </a>
{{--                                            @else--}}
{{--                                                <a href="{{ $post->permalink }}" target="_blank">--}}
{{--                                                    <img src="{{ $post->permalink }}media/?size=l" alt="">--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
                                        @elseif($post->media_type == 'VIDEO')
                                            <!-- Eğer media_type VIDEO ise video göster -->
                                            <a href="{{ $post->permalink }}" target="_blank">
                                                <video controls style="max-width: 100%; height: auto;">
                                                    <source src="{{ $post->media_url }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video></a>
                                        @endif
                                    </figure>
                                    <div class="posts__inner card__content">
                                        <a href="{{ $post->permalink }}" target="_blank" class="posts__cta"></a>
                                        <time datetime="2016-08-23" class="posts__date">
                                            {{ tarihBicimi($post->timestamp) }}</time>
                                        {{-- <h6 class="posts__title"><a href="#">{{ $post->caption }}</a></h6> --}}
                                        <div class="posts__excerpt">
                                            {{ $post->caption }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Post Area 1 / End -->
                </div>
                <!-- Content / End -->

                <!-- Sidebar -->
                <div id="sidebar" class="sidebar col-lg-4">

                    <aside class="widget widget--sidebar card widget-preview">
                        @if (!session('driverInfo'))
                            <div class="widget__title card__header">
                                <h4>PROFİL İŞLEMLERİ</h4>
                            </div>
                            <div class="widget__content card__content">
                                <!-- Match Preview -->
                                <div class="match-preview">
                                    <section class="match-preview__body">
                                        <header class="match-preview__header">
                                            <a href="#"
                                                class="btn btn-inverse btn-xl btn-outline btn-icon-right btn-condensed hero-unit__btn"
                                                data-toggle="modal" data-target="#modal-login-register">
                                                GİRİŞ YAP / KAYIT OL
                                                <i class="fas fa-arrow-right-to-bracket fa-xl"></i>
                                            </a>
                                        </header>
                                    </section>
                                </div>
                                <!-- Match Preview / End -->
                            </div>
                        @else
                            <div class="widget__title card__header">
                                <h4>PROFİL İŞLEMLERİ</h4>
                            </div>
                            <div class="widget__content card__content">
                                <!-- Match Preview -->
                                <div class="match-preview">
                                    <section class="match-preview__body">
                                        <header class="match-preview__header">
                                            @if (session('driverInfo') && in_array(session('driverInfo')->id, [1004]))
                                                <a href="{{ route('Dhome') }}"
                                                    class="btn btn-inverse btn-xl btn-outline btn-icon-right btn-condensed hero-unit__btn mb-2">
                                                    PİLOT PANELİNE GİT
                                                    <i class="fas fa-id-card fa-xl"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('Dlogout') }}"
                                                class="btn btn-inverse btn-xl btn-outline btn-icon-right btn-condensed hero-unit__btn">
                                                ÇIKIŞ YAP
                                                <i class="fas fa-arrow-right-from-bracket fa-xl"></i>
                                            </a>
                                        </header>
                                    </section>
                                </div>
                                <!-- Match Preview / End -->
                            </div>
                        @endif
                    </aside>

                    <!-- Widget: Match Announcement -->
                    @if (count($nextRace))
                        <aside class="widget widget--sidebar card widget-preview">
                            <div class="widget__title card__header">
                                <h4>SIRADAKİ YARIŞ</h4>
                            </div>
                            <div class="widget__content card__content">

                                <!-- Match Preview -->
                                <div class="match-preview">
                                    <section class="match-preview__body">
                                        <header class="match-preview__header">
                                            <h3 class="match-preview__title">{{ $nextRace[0]->name }}</h3>
                                            <time class="match-preview__date"
                                                datetime="{{ $nextRace[0]->race_date }}">{{ $nextRace[0]->race_date }}</time>
                                        </header>
{{--                                         <div class="match-preview__content">--}}

{{--                                            <!-- 1st Team -->--}}
{{--                                            <div class="match-preview__team match-preview__team--first">--}}
{{--                                                <figure class="match-preview__team-logo">--}}
{{--                                                    <img src="assets/images/samples/logo-alchemists--sm.png" alt="">--}}
{{--                                                </figure>--}}
{{--                                                <h5 class="match-preview__team-name">Alchemists</h5>--}}
{{--                                                <div class="match-preview__team-info">Elric Bros School</div>--}}
{{--                                            </div>--}}
{{--                                            <!-- 1st Team / End -->--}}

{{--                                            <div class="match-preview__vs">--}}
{{--                                                <div class="match-preview__conj">VS</div>--}}
{{--                                                <div class="match-preview__match-info">--}}
{{--                                                    <time class="match-preview__match-time" datetime="2018-08-07 08:00">8:00--}}
{{--                                                        PM</time>--}}
{{--                                                    <div class="match-preview__match-place">Madison Cube Stadium</div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <!-- 2nd Team -->--}}
{{--                                            <div class="match-preview__team match-preview__team--second">--}}
{{--                                                <figure class="match-preview__team-logo">--}}
{{--                                                    <img src="assets/images/samples/logo-l-clovers--sm.png" alt="">--}}
{{--                                                </figure>--}}
{{--                                                <h5 class="match-preview__team-name">Clovers</h5>--}}
{{--                                                <div class="match-preview__team-info">ST Paddy's Institute</div>--}}
{{--                                            </div>--}}
{{--                                            <!-- 2nd Team / End -->--}}

{{--                                        </div>--}}
{{--                                        <div class="match-preview__action">--}}
{{--                                            <a href="#" class="btn btn-default btn-block">Buy Tickets Now</a>--}}
{{--                                        </div> --}}
                                    </section>
                                    <section class="match-preview__countdown countdown">
                                        <h4 class="countdown__title">YARIŞA KALAN</h4>
                                        <div class="countdown__content">
                                            {{-- <div class="countdown-counter" data-date="June 18, 2025 21:00:00"></div> --}}
                                            <div class="countdown-counter" data-date="{{ $nextRace[0]->race_date }}">
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <!-- Match Preview / End -->

                            </div>
                        </aside>
                    @endif
                    <!-- Widget: Match Announcement / End -->

                    <!-- Widget: Standings -->
                    @if (isset($activeLeague))
                        <aside class="widget card widget--sidebar widget-standings">
                            <div class="widget__title card__header card__header--has-btn">
                                <h4>{{ $activeLeague->name }}</h4>
                                <a href="puan-tablosu-{{ $activeLeague->link }}"
                                    class="btn btn-default btn-outline btn-xs card-header__button">TÜM
                                    İSTATİSTİKLERİ GÖR</a>
                            </div>
                            <div class="widget__content card__content">
                                <div class="table-responsive">
                                    <table class="table table-hover table-standings">
                                        <thead>
                                            <tr>
                                                <th>PİLOT</th>
                                                <th>PUAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($driverStandings as $index => $driverData)
                                                <tr>
                                                    <td>
                                                        <div class="team-meta">
{{--                                                            <figure class="team-meta__logo">--}}
{{--                                                                --}}{{-- <img src="{{ $driverData['team_logo'] }}"--}}
{{--                                                                    alt="{{ $driverData['team_name'] }}"> --}}
{{--                                                                <img src="" alt="{{ $driverData->team_name }}">--}}
{{--                                                            </figure>--}}
                                                            <i class="fas fa-user mr-1"></i>
                                                            <div class="team-meta__info">
                                                                <h6 class="team-meta__name">
                                                                    {{ $driverData->name . " " . $driverData->surname }}</h6>
                                                                <span
                                                                    class="team-meta__place">{{ $driverData->team_name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $driverData->total_points }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </aside>
                    @endif
                    <!-- Widget: Standings / End -->


                    <!-- Widget: Social Buttons -->
                    <aside class="widget widget--sidebar widget-social">
                        {{-- <a href="#" class="btn-social-counter btn-social-counter--facebook" target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-facebook"></i>
                            </div>
                            <h6 class="btn-social-counter__title">FACEBOOK SAYFAMIZI TAKİP ET</h6>
                            <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Likes</span>
                            <span class="btn-social-counter__add-icon"></span>
                        </a> --}}
                        <a href="https://www.youtube.com/eracingtr" class="btn-social-counter btn-social-counter--youtube"
                            target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-youtube"></i>
                            </div>
                            <h6 class="btn-social-counter__title">YOUTUBE SAYFAMIZI TAKİP ET</h6>
                            {{-- <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Likes</span> --}}
                            <span class="btn-social-counter__add-icon"></span>
                        </a>
                        <a href="https://www.twitch.tv/eracingtr" class="btn-social-counter btn-social-counter--twitch"
                            target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-twitch"></i>
                            </div>
                            <h6 class="btn-social-counter__title">TWITCH SAYFAMIZI TAKİP ET</h6>
                            {{-- <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Likes</span> --}}
                            <span class="btn-social-counter__add-icon"></span>
                        </a>
                        <a href="https://x.com/eracingtr" class="btn-social-counter btn-social-counter--x" target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-x"></i>
                            </div>
                            <h6 class="btn-social-counter__title">X SAYFAMIZI TAKİP ET</h6>
                            {{-- <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Followers</span> --}}
                            <span class="btn-social-counter__add-icon"></span>
                        </a>
                        <a href="https://www.instagram.com/eracingtr"
                            class="btn-social-counter btn-social-counter--instagram" target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <h6 class="btn-social-counter__title">INSTAGRAM SAYFAMIZI TAKİP ET</h6>
                            {{-- <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Followers</span> --}}
                            <span class="btn-social-counter__add-icon"></span>
                        </a>
                    </aside>
                    <!-- Widget: Social Buttons / End -->

                    @if (count($youtubePosts))
                        <!-- Widget: Latest YouTube Videos -->
                        <aside class="widget widget--sidebar card widget-tabbed">
                            <div class="widget__title card__header">
                                <h4>SON YÜKLENEN VİDEOLAR</h4>
                            </div>
                            <div class="widget__content card__content">
                                <div class="widget-tabbed__tabs">
                                    <div class="tab-content widget-tabbed__tab-content">
                                        <div role="tabpanel" class="tab-pane fade show active" id="widget-tabbed-newest">
                                            <ul class="posts posts--simple-list">
                                                @foreach ($youtubePosts as $post)
                                                    <li class="posts__item posts__item--category-1">
                                                        <div class="posts__inner">

                                                            <iframe width="100%" height="200"
                                                                src="https://www.youtube.com/embed/{{ $post->video_id }}"
                                                                title="{{ $post->title }}" frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen>
                                                            </iframe>

                                                            <h6 class="posts__title">
                                                                <a href="https://www.youtube.com/watch?v={{ $post->video_id }}"
                                                                    target="_blank">
                                                                    {{ $post->title }}
                                                                </a>
                                                            </h6>

                                                            <time datetime="{{ $post->publish_time }}"
                                                                class="posts__date">
                                                                {{ tarihBicimi($post->publish_time) }}
                                                            </time>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <!-- Widget: Latest YouTube Videos / End -->
                    @endif
                </div>
                <!-- Sidebar / End -->
            </div>

        </div>
    </div>

    <!-- Content / End -->
@endsection
