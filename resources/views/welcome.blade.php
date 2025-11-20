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

                    <!-- Tryouts Section -->
                    @if (count($tryoutsData) > 0)
                        @foreach ($tryoutsData as $tryoutItem)
                            <div class="card mb-4" style="border-radius: 0.75rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); overflow: hidden; border: none;">
                                <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: white; border: none; border-bottom: 3px solid #dc3545;">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h4 class="mb-1" style="color: white; font-weight: 700; font-size: 1.25rem;">
                                                <i class="fas fa-clipboard-check mr-2" style="color: #dc3545;"></i>{{ $tryoutItem['league']->name }} - {{ __('common.tryout_results') }}
                                            </h4>
                                            @if($tryoutItem['track_name'])
                                                <div class="d-flex align-items-center mt-2" style="color: #ccc; font-size: 0.9rem;">
                                                    @php
                                                        $flagPath = asset('assets/img/flags/' . $tryoutItem['track_id'] . '_b.jpg');
                                                        $flagExists = file_exists(public_path('assets/img/flags/' . $tryoutItem['track_id'] . '_b.jpg'));
                                                    @endphp
                                                    @if($flagExists)
                                                        <img src="{{ $flagPath }}" alt="{{ $tryoutItem['track_name'] }}" style="width: 24px; height: 18px; margin-right: 0.5rem; border-radius: 3px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.2); flex-shrink: 0;">
                                                    @else
                                                        <i class="fas fa-flag-checkered me-2" style="color: #dc3545;"></i>
                                                    @endif
                                                    <span>{{ $tryoutItem['track_name'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="padding: 1.5rem;">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" style="font-size: 0.875rem; background: #2d2d2d; border-radius: 0.5rem; overflow: hidden; border: 1px solid #444;">
                                            <thead style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white;">
                                                <tr>
                                                    <th style="padding: 1rem; font-weight: 600; border: none; color: white; border-bottom: 2px solid rgba(255,255,255,0.2); width: 50px; text-align: center;">#</th>
                                                    <th style="padding: 1rem; font-weight: 600; border: none; color: white; border-bottom: 2px solid rgba(255,255,255,0.2);">Pilot</th>
                                                    @if(isset($tryoutItem['activeDays']['first_day_result']))
                                                        <th style="padding: 1rem; text-align: center; font-weight: 600; border: none; color: white; border-bottom: 2px solid rgba(255,255,255,0.2);">{{ $tryoutItem['activeDays']['first_day_result'] }}</th>
                                                    @endif
                                                    @if(isset($tryoutItem['activeDays']['second_day_result']))
                                                        <th style="padding: 1rem; text-align: center; font-weight: 600; border: none; color: white; border-bottom: 2px solid rgba(255,255,255,0.2);">{{ $tryoutItem['activeDays']['second_day_result'] }}</th>
                                                    @endif
                                                    @if(isset($tryoutItem['activeDays']['third_day_result']))
                                                        <th style="padding: 1rem; text-align: center; font-weight: 600; border: none; color: white; border-bottom: 2px solid rgba(255,255,255,0.2);">{{ $tryoutItem['activeDays']['third_day_result'] }}</th>
                                                    @endif
                                                    @if(isset($tryoutItem['activeDays']['fourth_day_result']))
                                                        <th style="padding: 1rem; text-align: center; font-weight: 600; border: none; color: white; border-bottom: 2px solid rgba(255,255,255,0.2);">{{ $tryoutItem['activeDays']['fourth_day_result'] }}</th>
                                                    @endif
                                                    @if(isset($tryoutItem['activeDays']['fifth_day_result']))
                                                        <th style="padding: 1rem; text-align: center; font-weight: 600; border: none; color: white; border-bottom: 2px solid rgba(255,255,255,0.2);">{{ $tryoutItem['activeDays']['fifth_day_result'] }}</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tryoutItem['tryouts']->take(15) as $index => $tryout)
                                                    <tr style="border-bottom: 1px solid #444; background: {{ $index % 2 == 0 ? '#2d2d2d' : '#333333' }}; transition: all 0.3s ease;" 
                                                        onmouseover="this.style.background='#3a3a3a'; this.style.transform='scale(1.01)';" 
                                                        onmouseout="this.style.background='{{ $index % 2 == 0 ? '#2d2d2d' : '#333333' }}'; this.style.transform='scale(1)';">
                                                        <td style="padding: 1rem; text-align: center; vertical-align: middle; border-right: 1px solid #444; font-weight: 700; font-size: 1.1rem; color: {{ $index < 3 ? '#dc3545' : '#fff' }};">
                                                            {{ $index + 1 }}
                                                        </td>
                                                        <td style="padding: 1rem; vertical-align: middle; border-right: 1px solid #444;">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('assets/img/drivers/' . $tryout->driver_id . '.png') }}" 
                                                                     alt="{{ $tryout->name }} {{ $tryout->surname }}"
                                                                     style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; margin-right: 0.75rem; border: 2px solid #dc3545; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4);"
                                                                     onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                                                                <div>
                                                                    <strong style="font-size: 0.9rem; color: #fff; font-weight: 600;">
                                                                        <a href="{{ route('driver.show', driverSlug($tryout->name, $tryout->surname, $tryout->driver_id)) }}" 
                                                                           style="color: inherit; text-decoration: none; transition: color 0.3s ease;"
                                                                           onmouseover="this.style.color='#24d9b0';"
                                                                           onmouseout="this.style.color='inherit';">
                                                                            {{ $tryout->name }} {{ $tryout->surname }}
                                                                        </a>
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @php
                                                            $activeDaysKeys = array_keys($tryoutItem['activeDays']);
                                                            $lastDayKey = end($activeDaysKeys);
                                                        @endphp
                                                        @if(isset($tryoutItem['activeDays']['first_day_result']))
                                                            <td style="padding: 1rem; text-align: center; vertical-align: middle; {{ 'first_day_result' != $lastDayKey ? 'border-right: 1px solid #444;' : '' }}">
                                                                @if($tryout->first_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'first_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 700; border: 1.5px solid #667eea; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star" style="font-size: 0.6rem; margin-right: 0.2rem;"></i><span>{{ $tryout->first_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; border: none; box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);">
                                                                            {{ $tryout->first_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-muted" style="font-size: 0.875rem; font-weight: 500; color: #888;">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if(isset($tryoutItem['activeDays']['second_day_result']))
                                                            <td style="padding: 1rem; text-align: center; vertical-align: middle; {{ 'second_day_result' != $lastDayKey ? 'border-right: 1px solid #444;' : '' }}">
                                                                @if($tryout->second_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'second_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 700; border: 1.5px solid #667eea; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star" style="font-size: 0.6rem; margin-right: 0.2rem;"></i><span>{{ $tryout->second_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; border: none; box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);">
                                                                            {{ $tryout->second_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-muted" style="font-size: 0.875rem; font-weight: 500; color: #888;">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if(isset($tryoutItem['activeDays']['third_day_result']))
                                                            <td style="padding: 1rem; text-align: center; vertical-align: middle; {{ 'third_day_result' != $lastDayKey ? 'border-right: 1px solid #444;' : '' }}">
                                                                @if($tryout->third_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'third_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 700; border: 1.5px solid #667eea; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star" style="font-size: 0.6rem; margin-right: 0.2rem;"></i><span>{{ $tryout->third_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; border: none; box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);">
                                                                            {{ $tryout->third_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-muted" style="font-size: 0.875rem; font-weight: 500; color: #888;">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if(isset($tryoutItem['activeDays']['fourth_day_result']))
                                                            <td style="padding: 1rem; text-align: center; vertical-align: middle; {{ 'fourth_day_result' != $lastDayKey ? 'border-right: 1px solid #444;' : '' }}">
                                                                @if($tryout->fourth_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'fourth_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 700; border: 1.5px solid #667eea; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star" style="font-size: 0.6rem; margin-right: 0.2rem;"></i><span>{{ $tryout->fourth_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; border: none; box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);">
                                                                            {{ $tryout->fourth_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-muted" style="font-size: 0.875rem; font-weight: 500; color: #888;">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if(isset($tryoutItem['activeDays']['fifth_day_result']))
                                                            <td style="padding: 1rem; text-align: center; vertical-align: middle;">
                                                                @if($tryout->fifth_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'fifth_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 700; border: 1.5px solid #667eea; box-shadow: 0 2px 8px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star" style="font-size: 0.6rem; margin-right: 0.2rem;"></i><span>{{ $tryout->fifth_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.35rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; border: none; box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);">
                                                                            {{ $tryout->fifth_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-muted" style="font-size: 0.875rem; font-weight: 500; color: #888;">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($tryoutItem['tryouts']->count() > 15)
                                            <div class="text-center mt-3">
                                                <small class="text-muted" style="font-size: 0.85rem;">
                                                    <i class="fas fa-info-circle me-1" style="color: #dc3545;"></i>
                                                    +{{ $tryoutItem['tryouts']->count() - 15 }} {{ __('common.more_drivers_shown') }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <!-- Tryouts Section / End -->

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
                                <h4>{{ __('common.profile_operations') }}</h4>
                            </div>
                            <div class="widget__content card__content">
                                <!-- Match Preview -->
                                <div class="match-preview">
                                    <section class="match-preview__body">
                                        <header class="match-preview__header">
                                            <a href="#"
                                                class="btn btn-inverse btn-xl btn-outline btn-icon-right btn-condensed hero-unit__btn"
                                                data-toggle="modal" data-target="#modal-login-register">
                                                {{ __('common.login_register') }}
                                                <i class="fas fa-arrow-right-to-bracket fa-xl"></i>
                                            </a>
                                        </header>
                                    </section>
                                </div>
                                <!-- Match Preview / End -->
                            </div>
                        @else
                            <div class="widget__title card__header">
                                <h4>{{ __('common.profile_operations') }}</h4>
                            </div>
                            <div class="widget__content card__content">
                                <!-- Match Preview -->
                                <div class="match-preview">
                                    <section class="match-preview__body">
                                        <header class="match-preview__header">
                                            <a href="{{ route('Dhome') }}"
                                                class="btn btn-inverse btn-xl btn-outline btn-icon-right btn-condensed hero-unit__btn mb-2">
                                                {{ __('common.go_to_driver_panel') }}
                                                <i class="fas fa-id-card fa-xl"></i>
                                            </a>
                                            <a href="{{ route('Dlogout') }}"
                                                class="btn btn-inverse btn-xl btn-outline btn-icon-right btn-condensed hero-unit__btn">
                                                {{ __('common.logout') }}
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
                                <h4>{{ __('common.next_race') }}</h4>
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
                                        <h4 class="countdown__title">{{ __('common.time_until_race') }}</h4>
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
                        <style>
                            .widget-standings-home {
                                background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
                                border-radius: 16px;
                                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
                                overflow: hidden;
                                border: 1px solid rgba(255, 255, 255, 0.1);
                            }

                            .widget-standings-home .widget__title {
                                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                                padding: 0.875rem 1rem;
                                border-bottom: 3px solid rgba(255, 255, 255, 0.1);
                            }

                            .widget-standings-home .widget__title h4 {
                                color: #fff;
                                font-weight: 700;
                                font-size: 1rem;
                                margin: 0;
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                            }

                            .widget-standings-home .table-standings {
                                margin: 0;
                                background: transparent;
                            }

                            .widget-standings-home .table-standings thead {
                                background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                            }

                            .widget-standings-home .table-standings thead th {
                                color: #fff;
                                font-weight: 700;
                                font-size: 0.75rem;
                                padding: 0.625rem 0.5rem;
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                                border: none;
                            }

                            .widget-standings-home .table-standings tbody tr {
                                transition: all 0.3s ease;
                                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                            }

                            .widget-standings-home .table-standings tbody tr:hover {
                                background: rgba(255, 255, 255, 0.05);
                            }

                            .widget-standings-home .table-standings tbody td {
                                padding: 0.625rem 0.5rem;
                                color: #e0e0e0;
                                vertical-align: middle;
                                border: none;
                            }

                            .widget-standings-home .podium-row-home {
                                position: relative;
                            }

                            .widget-standings-home .podium-row-home.podium-gold-home {
                                background: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF8C00 100%) !important;
                                box-shadow: 0 4px 20px rgba(255, 215, 0, 0.4);
                            }

                            .widget-standings-home .podium-row-home.podium-silver-home {
                                background: linear-gradient(135deg, #C0C0C0 0%, #A8A8A8 50%, #808080 100%) !important;
                                box-shadow: 0 4px 20px rgba(192, 192, 192, 0.4);
                            }

                            .widget-standings-home .podium-row-home.podium-bronze-home {
                                background: linear-gradient(135deg, #CD7F32 0%, #B87333 50%, #A0522D 100%) !important;
                                box-shadow: 0 4px 20px rgba(205, 127, 50, 0.4);
                            }

                            .widget-standings-home .podium-row-home td {
                                color: #fff !important;
                                font-weight: 700 !important;
                                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                            }

                            .widget-standings-home .rank-badge-home {
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                width: 1.5rem;
                                height: 1.5rem;
                                border-radius: 50%;
                                font-weight: 800;
                                font-size: 0.75rem;
                                background: rgba(255, 255, 255, 0.1);
                                border: 2px solid rgba(255, 255, 255, 0.2);
                                color: #fff;
                                margin-right: 0.25rem;
                            }

                            .widget-standings-home .podium-row-home .rank-badge-home {
                                background: rgba(0, 0, 0, 0.3);
                                border-color: rgba(255, 255, 255, 0.4);
                            }

                            .widget-standings-home .points-display-home {
                                font-size: 0.95rem;
                                font-weight: 800;
                                color: #24d9b0;
                                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                            }

                            .widget-standings-home .podium-row-home .points-display-home {
                                color: #fff !important;
                                font-size: 1rem;
                            }

                            .widget-standings-home .team-meta {
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                            }

                            .widget-standings-home .team-meta i {
                                font-size: 0.85rem;
                                opacity: 0.8;
                            }

                            .widget-standings-home .driver-photo-home {
                                width: 32px;
                                height: 32px;
                                border-radius: 50%;
                                object-fit: cover;
                                border: 2px solid rgba(255, 255, 255, 0.2);
                                flex-shrink: 0;
                            }

                            .widget-standings-home .podium-row-home .driver-photo-home {
                                border-color: rgba(255, 255, 255, 0.4);
                            }

                            .widget-standings-home .team-meta__name {
                                color: #fff;
                                font-weight: 600;
                                font-size: 0.85rem;
                                margin: 0;
                            }

                            .widget-standings-home .team-meta__place {
                                color: rgba(255, 255, 255, 0.6);
                                font-size: 0.7rem;
                            }
                        </style>
                        <aside class="widget card widget--sidebar widget-standings widget-standings-home">
                            <div class="widget__title card__header card__header--has-btn">
                                <h4>
                                    <i class="fas fa-trophy"></i>
                                    {{ $activeLeague->name }}
                                </h4>
                                <a href="{{ route('statistics') }}"
                                    class="btn btn-default btn-outline btn-xs card-header__button"
                                    style="
                                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                                        color: white !important;
                                        border: none;
                                        padding: 0.5rem 1rem;
                                        border-radius: 0.5rem;
                                        font-weight: 600;
                                        font-size: 0.75rem;
                                        text-decoration: none;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 0.5rem;
                                        transition: all 0.3s ease;
                                        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
                                    "
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(16, 185, 129, 0.5)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(16, 185, 129, 0.4)';">
                                    <i class="fas fa-chart-line"></i>
                                    {{ __('common.view_all_statistics') }}
                                </a>
                            </div>
                            <div class="widget__content card__content" style="padding: 0; background: #1a1a1a;">
                                <div class="table-responsive">
                                    <table class="table table-hover table-standings">
                                        <thead>
                                            <tr>
                                                <th style="width: 35px; padding-right: 0.25rem !important;">#</th>
                                                <th>{{ __('common.pilot') }}</th>
                                                <th style="text-align: center;">{{ __('common.points') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($driverStandings as $index => $driverData)
                                                @php
                                                    $isPodium = $index < 3;
                                                    $podiumClass = '';
                                                    $podiumIcon = '';
                                                    
                                                    if ($index == 0) {
                                                        $podiumClass = 'podium-gold-home';
                                                        $podiumIcon = '🥇';
                                                    } elseif ($index == 1) {
                                                        $podiumClass = 'podium-silver-home';
                                                        $podiumIcon = '🥈';
                                                    } elseif ($index == 2) {
                                                        $podiumClass = 'podium-bronze-home';
                                                        $podiumIcon = '🥉';
                                                    }
                                                @endphp
                                                <tr class="{{ $isPodium ? 'podium-row-home ' . $podiumClass : '' }}">
                                                    <td style="text-align: center; padding-right: 0.25rem !important;">
                                                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.15rem;">
                                                            @if($isPodium)
                                                                <span style="font-size: 0.85rem;">{{ $podiumIcon }}</span>
                                                            @endif
                                                            <span class="rank-badge-home">{{ $index + 1 }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="team-meta">
                                                            <img src="{{ asset('assets/img/drivers/' . $driverData->id . '.png') }}" 
                                                                 alt="{{ $driverData->name }} {{ $driverData->surname }}"
                                                                 class="driver-photo-home"
                                                                 onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                                                            <div class="team-meta__info">
                                                                <h6 class="team-meta__name">
                                                                    <a href="{{ route('driver.show', driverSlug($driverData->name, $driverData->surname, $driverData->id)) }}" 
                                                                       style="color: inherit; text-decoration: none; transition: color 0.3s ease;"
                                                                       onmouseover="this.style.color='#24d9b0';"
                                                                       onmouseout="this.style.color='inherit';">
                                                                        {{ $driverData->name . " " . $driverData->surname }}
                                                                    </a>
                                                                </h6>
                                                                <span class="team-meta__place">{{ $driverData->team_name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <span class="points-display-home">{{ $driverData->total_points }}</span>
                                                    </td>
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
                            <h6 class="btn-social-counter__title">{{ __('common.follow_facebook') }}</h6>
                            <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Likes</span>
                            <span class="btn-social-counter__add-icon"></span>
                        </a> --}}
                        <a href="https://www.youtube.com/eracingtr" class="btn-social-counter btn-social-counter--youtube"
                            target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-youtube"></i>
                            </div>
                            <h6 class="btn-social-counter__title">{{ __('common.follow_youtube') }}</h6>
                            {{-- <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Likes</span> --}}
                            <span class="btn-social-counter__add-icon"></span>
                        </a>
                        <a href="https://www.twitch.tv/eracingtr" class="btn-social-counter btn-social-counter--twitch"
                            target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-twitch"></i>
                            </div>
                            <h6 class="btn-social-counter__title">{{ __('common.follow_twitch') }}</h6>
                            {{-- <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Likes</span> --}}
                            <span class="btn-social-counter__add-icon"></span>
                        </a>
                        <a href="https://x.com/eracingtr" class="btn-social-counter btn-social-counter--x" target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-x"></i>
                            </div>
                            <h6 class="btn-social-counter__title">{{ __('common.follow_x') }}</h6>
                            {{-- <span class="btn-social-counter__count"><span class="btn-social-counter__count-num"></span>
                                Followers</span> --}}
                            <span class="btn-social-counter__add-icon"></span>
                        </a>
                        <a href="https://www.instagram.com/eracingtr"
                            class="btn-social-counter btn-social-counter--instagram" target="_blank">
                            <div class="btn-social-counter__icon">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <h6 class="btn-social-counter__title">{{ __('common.follow_instagram') }}</h6>
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
                                <h4>{{ __('common.latest_uploaded_videos') }}</h4>
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
