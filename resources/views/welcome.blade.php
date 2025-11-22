@extends('layouts.layout')

@section('content')
    <!-- Modern Hero Section -->
    <section class="modern-hero" style="position: relative; overflow: hidden; background: linear-gradient(135deg, #0d1117 0%, #161b22 30%, #1c2128 60%, #0d1117 100%); padding: 50px 0 60px; margin-bottom: 0;">
        <!-- Racing Track Pattern Background -->
        <div class="hero-background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.15; background-image: 
            radial-gradient(circle at 15% 30%, rgba(220, 53, 69, 0.5) 0%, transparent 40%),
            radial-gradient(circle at 85% 70%, rgba(36, 217, 176, 0.4) 0%, transparent 40%),
            radial-gradient(circle at 50% 50%, rgba(255, 193, 7, 0.2) 0%, transparent 50%),
            linear-gradient(45deg, transparent 48%, rgba(220, 53, 69, 0.05) 49%, rgba(220, 53, 69, 0.05) 51%, transparent 52%),
            linear-gradient(-45deg, transparent 48%, rgba(36, 217, 176, 0.05) 49%, rgba(36, 217, 176, 0.05) 51%, transparent 52%);"></div>
        <!-- Animated Grid Overlay -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: 
            linear-gradient(rgba(220, 53, 69, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(220, 53, 69, 0.03) 1px, transparent 1px);
            background-size: 50px 50px; opacity: 0.3; animation: gridMove 20s linear infinite;"></div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" style="animation: fadeInUp 0.8s ease-out;">
                        <div class="hero-badge" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%); border: 1px solid rgba(220, 53, 69, 0.3); padding: 6px 16px; border-radius: 50px; margin-bottom: 12px; backdrop-filter: blur(10px);">
                            <i class="fas fa-star" style="color: #dc3545; font-size: 12px; animation: pulse 2s infinite;"></i>
                            <span style="color: #fff; font-weight: 600; font-size: 12px; letter-spacing: 1px;">{{ __('common.new_season_starting') }}</span>
                        </div>
                        <h1 class="hero-title" style="font-size: 3rem; font-weight: 900; color: #fff; margin-bottom: 12px; line-height: 1.1; text-shadow: 0 4px 20px rgba(0,0,0,0.5); background: linear-gradient(135deg, #fff 0%, #dc3545 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            {{ __('common.eracing_turkey') }}
                        </h1>
                        <p class="hero-description" style="font-size: 1.05rem; color: rgba(255,255,255,0.8); margin-bottom: 24px; line-height: 1.5;">
                            {{ __('common.application_desc') }}
                        </p>
                        @if (!session('driverInfo'))
                            <a href="#" class="hero-cta-btn" data-toggle="modal" data-target="#modal-login-register" style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: #fff; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; box-shadow: 0 8px 30px rgba(220, 53, 69, 0.4); transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <span style="position: relative; z-index: 2;">{{ __('common.join') }}</span>
                                <i class="fas fa-arrow-right" style="position: relative; z-index: 2; transition: transform 0.3s;"></i>
                                <span class="btn-shine" style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transition: left 0.5s;"></span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-visual" style="position: relative; animation: fadeInRight 0.8s ease-out;">
                        <div class="floating-elements" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0;">
                            <div class="floating-circle" style="position: absolute; width: 180px; height: 180px; background: radial-gradient(circle, rgba(220, 53, 69, 0.4) 0%, rgba(220, 53, 69, 0.1) 50%, transparent 70%); border-radius: 50%; top: 15%; right: 5%; animation: float 6s ease-in-out infinite; box-shadow: 0 0 60px rgba(220, 53, 69, 0.4);"></div>
                            <div class="floating-circle" style="position: absolute; width: 150px; height: 150px; background: radial-gradient(circle, rgba(36, 217, 176, 0.35) 0%, rgba(36, 217, 176, 0.1) 50%, transparent 70%); border-radius: 50%; bottom: 15%; left: 5%; animation: float 8s ease-in-out infinite reverse; box-shadow: 0 0 50px rgba(36, 217, 176, 0.3);"></div>
                            <div class="floating-circle" style="position: absolute; width: 100px; height: 100px; background: radial-gradient(circle, rgba(255, 193, 7, 0.3) 0%, transparent 70%); border-radius: 50%; top: 50%; right: 20%; animation: float 10s ease-in-out infinite; box-shadow: 0 0 40px rgba(255, 193, 7, 0.25);"></div>
                        </div>
                        <div style="text-align: center; padding: 20px; position: relative;">
                            @if(count($heroSliders) > 0)
                                <div id="heroSlider" class="carousel slide" data-ride="carousel" data-interval="4000" style="border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
                                    <div class="carousel-inner">
                                        @foreach($heroSliders as $index => $slider)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('assets/img/hero_slider/' . $slider->image) }}" alt="Hero Slider {{ $index + 1 }}" style="width: 100%; max-width: 600px; max-height: 250px; height: auto; object-fit: cover; display: block; margin: 0 auto;">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($heroSliders) > 1)
                                        <a class="carousel-control-prev" href="#heroSlider" role="button" data-slide="prev" style="width: 5%;">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#heroSlider" role="button" data-slide="next" style="width: 5%;">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                        <ol class="carousel-indicators" style="bottom: 10px;">
                                            @foreach($heroSliders as $index => $slider)
                                                <li data-target="#heroSlider" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-30px) translateX(20px); }
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes gridMove {
            0% { background-position: 0 0; }
            100% { background-position: 50px 50px; }
        }
        .hero-cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(220, 53, 69, 0.6) !important;
        }
        .hero-cta-btn:hover .btn-shine {
            left: 100%;
        }
        .hero-cta-btn:hover i {
            transform: translateX(5px);
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            /* Hero Section Mobile */
            .modern-hero {
                padding: 30px 0 40px !important;
            }
            .hero-badge {
                padding: 5px 12px !important;
                margin-bottom: 10px !important;
                font-size: 11px !important;
            }
            .hero-badge i {
                font-size: 10px !important;
            }
            .hero-title {
                font-size: 2rem !important;
                margin-bottom: 10px !important;
            }
            .hero-description {
                font-size: 0.95rem !important;
                margin-bottom: 20px !important;
                line-height: 1.4 !important;
            }
            .hero-cta-btn {
                padding: 12px 24px !important;
                font-size: 0.9rem !important;
                width: 100%;
                justify-content: center;
            }
            .hero-visual {
                display: none !important;
            }
            .floating-circle {
                display: none !important;
            }
            
            /* Next Race Card Mobile */
            .next-race-card {
                padding: 20px !important;
                margin-bottom: 25px !important;
                border-radius: 15px !important;
            }
            
            /* Tryouts Cards Mobile */
            .modern-card {
                margin-bottom: 25px !important;
                border-radius: 15px !important;
            }
            .card-header-modern {
                padding: 16px 18px !important;
            }
            .card-header-modern h4 {
                font-size: 1.2rem !important;
            }
            .card-header-modern h4 span:first-child {
                width: 36px !important;
                height: 36px !important;
            }
            .card-header-modern h4 span:first-child i {
                font-size: 0.95rem !important;
            }
            .widget-modern > div:first-child h4 span:first-child {
                width: 34px !important;
                height: 34px !important;
            }
            .widget-modern > div:first-child h4 span:first-child i {
                font-size: 0.9rem !important;
            }
            .card-body-modern {
                padding: 20px !important;
            }
            /* Tryouts Table - Mobile Responsive */
            .card-body-modern .table-responsive {
                overflow-x: hidden !important;
                overflow-y: visible !important;
                width: 100%;
                display: block;
            }
            .card-body-modern .table {
                min-width: 100% !important;
                width: 100% !important;
                display: table;
                table-layout: fixed;
            }
            .card-body-modern .table thead th {
                font-size: 0.65rem !important;
                padding: 0.5rem 0.25rem !important;
                white-space: nowrap;
            }
            .card-body-modern .table tbody td {
                font-size: 0.75rem !important;
                padding: 0.5rem 0.25rem !important;
                white-space: nowrap;
            }
            /* # kolonu - Sol */
            .card-body-modern .table thead th:first-child {
                position: sticky;
                left: 0;
                background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%) !important;
                z-index: 10;
                width: 35px !important;
                padding: 0.5rem 0.2rem !important;
            }
            .card-body-modern .table tbody td:first-child {
                position: sticky;
                left: 0;
                background: #1a1a1a !important;
                z-index: 10;
                width: 35px !important;
                padding: 0.5rem 0.2rem !important;
                font-size: 0.9rem !important;
            }
            .card-body-modern .table tbody tr:nth-child(even) td:first-child {
                background: rgba(255,255,255,0.02) !important;
            }
            .card-body-modern .table tbody tr:hover td:first-child {
                background: rgba(220, 53, 69, 0.1) !important;
            }
            /* PİLOT kolonu - Orta */
            .card-body-modern .table thead th:nth-child(2) {
                background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%) !important;
                padding: 0.5rem 0.3rem !important;
                text-align: left !important;
            }
            .card-body-modern .table tbody td:nth-child(2) {
                background: #1a1a1a !important;
                padding: 0.5rem 0.3rem !important;
                text-align: left !important;
            }
            .card-body-modern .table tbody td:nth-child(2) strong {
                font-size: 0.75rem !important;
                font-weight: 600 !important;
            }
            .card-body-modern .table tbody tr:nth-child(even) td:nth-child(2) {
                background: rgba(255,255,255,0.02) !important;
            }
            .card-body-modern .table tbody tr:hover td:nth-child(2) {
                background: rgba(220, 53, 69, 0.1) !important;
            }
            /* En Hızlı Tur kolonu - Sağ (Sticky) */
            .card-body-modern .table thead th.fastest-lap-col {
                position: sticky;
                right: 0;
                background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%) !important;
                z-index: 10;
                width: 120px !important;
                padding: 0.5rem 0.3rem !important;
            }
            .card-body-modern .table tbody td.fastest-lap-col {
                position: sticky;
                right: 0;
                background: #1a1a1a !important;
                z-index: 10;
                width: 120px !important;
                padding: 0.5rem 0.3rem !important;
            }
            .card-body-modern .table tbody tr:nth-child(even) td.fastest-lap-col {
                background: rgba(255,255,255,0.02) !important;
            }
            .card-body-modern .table tbody tr:hover td.fastest-lap-col {
                background: rgba(220, 53, 69, 0.1) !important;
            }
            .card-body-modern .table tbody td.fastest-lap-col .badge {
                padding: 0.3rem 0.5rem !important;
                font-size: 0.7rem !important;
            }
            .card-body-modern .table tbody td.fastest-lap-col .badge i {
                font-size: 0.65rem !important;
                margin-right: 0.3rem !important;
            }
            /* Mobilde sadece #, PİLOT ve En Hızlı Tur sütunlarını göster */
            .card-body-modern .table thead th:nth-child(n+4),
            .card-body-modern .table tbody td:nth-child(n+4) {
                display: none !important;
            }
            .card-body-modern .table thead th.fastest-lap-col,
            .card-body-modern .table tbody td.fastest-lap-col {
                display: table-cell !important;
            }
            
            /* Instagram Posts Grid Mobile */
            .posts-grid-modern {
                grid-template-columns: 1fr !important;
                gap: 15px !important;
                margin-top: 25px !important;
            }
            .post-card-modern {
                border-radius: 15px !important;
            }
            
            /* Sidebar Widgets Mobile */
            .widget-modern {
                margin-bottom: 20px !important;
                border-radius: 15px !important;
            }
            .widget-modern > div:first-child {
                padding: 15px 18px !important;
            }
            .widget-modern > div:first-child h4 {
                font-size: 1.1rem !important;
            }
            .widget-modern > div:last-child {
                padding: 18px !important;
            }
            .btn-modern-primary,
            .btn-modern-secondary {
                padding: 14px 20px !important;
                font-size: 0.9rem !important;
            }
            .social-btn-modern {
                padding: 14px 18px !important;
                font-size: 0.9rem !important;
            }
            
            /* Standings Table Mobile */
            .widget-standings-modern .widget__title {
                padding: 15px 18px !important;
            }
            .widget-standings-modern .widget__title h4 {
                font-size: 1.1rem !important;
            }
            .widget-standings-modern .table-standings thead th {
                font-size: 0.7rem !important;
                padding: 0.35rem 0.15rem !important;
            }
            .widget-standings-modern .table-standings tbody td {
                padding: 0.4rem 0.15rem !important;
                font-size: 0.8rem !important;
            }
            .widget-standings-modern .driver-photo-modern {
                width: 28px !important;
                height: 28px !important;
            }
            .widget-standings-modern .team-meta__name-modern {
                font-size: 0.8rem !important;
            }
            .widget-standings-modern .team-meta__place-modern {
                font-size: 0.7rem !important;
            }
            .widget-standings-modern .rank-badge-modern {
                width: 1.3rem !important;
                height: 1.3rem !important;
                font-size: 0.7rem !important;
            }
            .widget-standings-modern .points-display-modern {
                font-size: 0.85rem !important;
            }
            .widget-standings-modern .podium-row-modern .points-display-modern {
                font-size: 0.9rem !important;
            }
            
            /* Container Padding Mobile */
            .container {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
            
            /* Content Spacing Mobile */
            .site-content {
                padding-top: 20px !important;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.75rem !important;
            }
            .hero-description {
                font-size: 0.9rem !important;
            }
            .card-header-modern h4 {
                font-size: 1.1rem !important;
            }
            .modern-card {
                border-radius: 12px !important;
            }
            .widget-modern {
                border-radius: 12px !important;
            }
        }
    </style>

    <div class="site-content">
        <div class="container">
            <div class="row">
                <!-- Content -->
                <div class="content col-lg-8">
                    <!-- Next Race Highlight Card -->
                    @if (count($nextRace))
                        <div class="next-race-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; padding: 30px; margin-bottom: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); border: 1px solid rgba(220, 53, 69, 0.2); position: relative; overflow: hidden;">
                            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(220, 53, 69, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                            <div style="position: relative; z-index: 2;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                                            <i class="fas fa-calendar-alt" style="color: #dc3545; font-size: 1.5rem;"></i>
                                            <h3 style="color: #fff; font-weight: 700; font-size: 1.75rem; margin: 0;">{{ __('common.next_race') }}</h3>
                                        </div>
                                        <h4 style="color: rgba(255,255,255,0.9); font-weight: 600; font-size: 1.25rem; margin: 0;">{{ $nextRace[0]->name }}</h4>
                                        <p style="color: rgba(255,255,255,0.6); margin: 8px 0 0 0; font-size: 1rem;">{{ $nextRace[0]->race_date }}</p>
                                    </div>
                                </div>
                                <div class="countdown-modern" style="background: rgba(0,0,0,0.3); border-radius: 15px; padding: 25px; backdrop-filter: blur(10px);">
                                    <h5 style="color: #fff; font-weight: 600; margin-bottom: 20px; text-align: center; font-size: 1.1rem;">
                                        <i class="fas fa-clock mr-2" style="color: #dc3545;"></i>{{ __('common.time_until_race') }}
                                    </h5>
                                    <div class="countdown-counter" data-date="{{ $nextRace[0]->race_date }}"></div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tryouts Section -->
                    @if (count($tryoutsData) > 0)
                        @foreach ($tryoutsData as $tryoutItem)
                            <div class="modern-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; overflow: hidden; margin-bottom: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 50px rgba(0,0,0,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.3)';">
                                <div class="card-header-modern" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08) 0%, rgba(220, 53, 69, 0.03) 100%); padding: 22px 28px; border: none; border-left: 4px solid #dc3545; position: relative; border-radius: 20px 20px 0 0;">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h4 style="color: #fff; font-weight: 700; font-size: 1.5rem; margin: 0 0 10px 0; display: flex; align-items: center; gap: 14px;">
                                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 42px; height: 42px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 10px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                                    <i class="fas fa-clipboard-check" style="color: #fff; font-size: 1.1rem;"></i>
                                                </span>
                                                <span>{{ $tryoutItem['league']->name }} - {{ __('common.tryout_results') }}</span>
                                            </h4>
                                            @if($tryoutItem['track_name'])
                                                <div class="d-flex align-items-center" style="color: rgba(255,255,255,0.9); font-size: 1rem;">
                                                    @php
                                                        $flagPath = asset('assets/img/flags/' . $tryoutItem['track_id'] . '_b.jpg');
                                                        $flagExists = file_exists(public_path('assets/img/flags/' . $tryoutItem['track_id'] . '_b.jpg'));
                                                    @endphp
                                                    @if($flagExists)
                                                        <img src="{{ $flagPath }}" alt="{{ $tryoutItem['track_name'] }}" style="width: 28px; height: 20px; margin-right: 10px; border-radius: 4px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                                                    @else
                                                        <i class="fas fa-flag-checkered mr-2" style="color: rgba(255,255,255,0.9);"></i>
                                                    @endif
                                                    <span>{{ $tryoutItem['track_name'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body-modern" style="padding: 30px;">
                                    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
                                        <table class="table table-hover mb-0" style="font-size: 0.95rem; background: transparent; border-radius: 12px; overflow: hidden; width: 100%;">
                                            <thead style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%); border: none;">
                                                <tr>
                                                    <th style="padding: 1.25rem 0.5rem 1.25rem 0.75rem; font-weight: 700; border: none; color: #fff; text-align: center; width: 50px;">#</th>
                                                    <th style="padding: 1.25rem 1.25rem 1.25rem 0.5rem; font-weight: 700; border: none; color: #fff;">Pilot</th>
                                                    <th class="fastest-lap-col" style="padding: 1.25rem 0.75rem; text-align: center; font-weight: 700; border: none; color: #fff;">
                                                        <i class="fas fa-tachometer-alt mr-1"></i>En Hızlı Tur
                                                    </th>
                                                    @if(isset($tryoutItem['activeDays']['first_day_result']))
                                                        <th style="padding: 1.25rem 0.75rem; text-align: center; font-weight: 700; border: none; color: #fff;">{{ $tryoutItem['activeDays']['first_day_result'] }}</th>
                                                    @endif
                                                    @if(isset($tryoutItem['activeDays']['second_day_result']))
                                                        <th style="padding: 1.25rem 0.75rem; text-align: center; font-weight: 700; border: none; color: #fff;">{{ $tryoutItem['activeDays']['second_day_result'] }}</th>
                                                    @endif
                                                    @if(isset($tryoutItem['activeDays']['third_day_result']))
                                                        <th style="padding: 1.25rem 0.75rem; text-align: center; font-weight: 700; border: none; color: #fff;">{{ $tryoutItem['activeDays']['third_day_result'] }}</th>
                                                    @endif
                                                    @if(isset($tryoutItem['activeDays']['fourth_day_result']))
                                                        <th style="padding: 1.25rem 0.75rem; text-align: center; font-weight: 700; border: none; color: #fff;">{{ $tryoutItem['activeDays']['fourth_day_result'] }}</th>
                                                    @endif
                                                    @if(isset($tryoutItem['activeDays']['fifth_day_result']))
                                                        <th style="padding: 1.25rem 0.75rem; text-align: center; font-weight: 700; border: none; color: #fff;">{{ $tryoutItem['activeDays']['fifth_day_result'] }}</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tryoutItem['tryouts']->take(15) as $index => $tryout)
                                                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); background: {{ $index % 2 == 0 ? 'transparent' : 'rgba(255,255,255,0.02)' }}; transition: all 0.3s ease;" 
                                                        onmouseover="this.style.background='rgba(220, 53, 69, 0.1)'; this.style.transform='scale(1.01)';" 
                                                        onmouseout="this.style.background='{{ $index % 2 == 0 ? 'transparent' : 'rgba(255,255,255,0.02)' }}'; this.style.transform='scale(1)';">
                                                        <td style="padding: 1.25rem 0.5rem 1.25rem 0.75rem; text-align: center; vertical-align: middle; font-weight: 700; font-size: 1.2rem; color: {{ $index < 3 ? '#dc3545' : 'rgba(255,255,255,0.8)' }};">
                                                            {{ $index + 1 }}
                                                        </td>
                                                        <td style="padding: 1.25rem 1.25rem 1.25rem 0.5rem; vertical-align: middle;">
                                                            <strong style="font-size: 1rem; color: #fff; font-weight: 600; display: block;">
                                                                        <a href="{{ route('driver.show', driverSlug($tryout->name, $tryout->surname, $tryout->driver_id)) }}" 
                                                                           style="color: inherit; text-decoration: none; transition: color 0.3s ease;"
                                                                           onmouseover="this.style.color='#24d9b0';"
                                                                           onmouseout="this.style.color='inherit';">
                                                                            {{ $tryout->name }} {{ $tryout->surname }}
                                                                        </a>
                                                                    </strong>
                                                        </td>
                                                        <td class="fastest-lap-col" style="padding: 1.25rem 0.75rem; text-align: center; vertical-align: middle;">
                                                            @if(isset($tryout->best_time_formatted) && $tryout->best_time_formatted)
                                                                <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 2px solid #9b59b6; box-shadow: 0 4px 12px rgba(155, 89, 182, 0.5); white-space: nowrap;">
                                                                    <i class="fas fa-tachometer-alt mr-2"></i><span>{{ $tryout->best_time_formatted }}</span>
                                                                </span>
                                                            @else
                                                                <span style="font-size: 0.95rem; font-weight: 500; color: rgba(255,255,255,0.4);">-</span>
                                                            @endif
                                                        </td>
                                                        @php
                                                            $activeDaysKeys = array_keys($tryoutItem['activeDays']);
                                                            $lastDayKey = end($activeDaysKeys);
                                                        @endphp
                                                        @if(isset($tryoutItem['activeDays']['first_day_result']))
                                                            <td style="padding: 1.25rem 0.75rem; text-align: center; vertical-align: middle;">
                                                                @if($tryout->first_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'first_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 2px solid #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star mr-2"></i><span>{{ $tryout->first_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: none; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                                                            {{ $tryout->first_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span style="font-size: 0.95rem; font-weight: 500; color: rgba(255,255,255,0.4);">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if(isset($tryoutItem['activeDays']['second_day_result']))
                                                            <td style="padding: 1.25rem 0.75rem; text-align: center; vertical-align: middle;">
                                                                @if($tryout->second_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'second_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 2px solid #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star mr-2"></i><span>{{ $tryout->second_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: none; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                                                            {{ $tryout->second_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span style="font-size: 0.95rem; font-weight: 500; color: rgba(255,255,255,0.4);">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if(isset($tryoutItem['activeDays']['third_day_result']))
                                                            <td style="padding: 1.25rem 0.75rem; text-align: center; vertical-align: middle;">
                                                                @if($tryout->third_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'third_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 2px solid #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star mr-2"></i><span>{{ $tryout->third_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: none; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                                                            {{ $tryout->third_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span style="font-size: 0.95rem; font-weight: 500; color: rgba(255,255,255,0.4);">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if(isset($tryoutItem['activeDays']['fourth_day_result']))
                                                            <td style="padding: 1.25rem 0.75rem; text-align: center; vertical-align: middle;">
                                                                @if($tryout->fourth_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'fourth_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 2px solid #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star mr-2"></i><span>{{ $tryout->fourth_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: none; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                                                            {{ $tryout->fourth_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span style="font-size: 0.95rem; font-weight: 500; color: rgba(255,255,255,0.4);">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if(isset($tryoutItem['activeDays']['fifth_day_result']))
                                                            <td style="padding: 1.25rem 0.75rem; text-align: center; vertical-align: middle;">
                                                                @if($tryout->fifth_day_result)
                                                                    @if(isset($tryout->best_time_field) && $tryout->best_time_field == 'fifth_day_result')
                                                                        <span class="badge d-inline-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 2px solid #667eea; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);">
                                                                            <i class="fas fa-star mr-2"></i><span>{{ $tryout->fifth_day_result }}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.5rem 0.75rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; border: none; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                                                            {{ $tryout->fifth_day_result }}
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span style="font-size: 0.95rem; font-weight: 500; color: rgba(255,255,255,0.4);">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($tryoutItem['tryouts']->count() > 15)
                                            <div class="text-center mt-4">
                                                <span style="color: rgba(255,255,255,0.6); font-size: 0.95rem;">
                                                    <i class="fas fa-info-circle mr-2" style="color: #dc3545;"></i>
                                                    +{{ $tryoutItem['tryouts']->count() - 15 }} {{ __('common.more_drivers_shown') }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <!-- Tryouts Section / End -->

                    <!-- Instagram Posts Grid -->
                    <div class="posts-grid-modern" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; margin-top: 40px; margin-bottom: 40px;">
                        @foreach ($instagramPosts as $post)
                            <div class="post-card-modern" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease; position: relative;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 50px rgba(0,0,0,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.3)';">
                                <figure style="margin: 0; position: relative; overflow: hidden; padding-top: 100%; background: #0a0a0a;">
                                        @if ($post->media_type == 'IMAGE' || $post->media_type == 'CAROUSEL_ALBUM')
                                        <a href="{{ $post->permalink }}" target="_blank" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: block;">
                                            <img src="{{ asset('assets/img/instagram/' . $post->instagram_id . '.jpg') }}" alt="" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.1)';" onmouseout="this.style.transform='scale(1)';">
                                        </a>
                                        @elseif($post->media_type == 'VIDEO')
                                        <a href="{{ $post->permalink }}" target="_blank" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: block;">
                                            <video controls style="width: 100%; height: 100%; object-fit: cover;">
                                                    <source src="{{ $post->media_url }}" type="video/mp4">
                                            </video>
                                        </a>
                                        @endif
                                    <div style="position: absolute; top: 15px; right: 15px; background: rgba(0,0,0,0.7); padding: 8px 12px; border-radius: 20px; backdrop-filter: blur(10px);">
                                        <time style="color: #fff; font-size: 0.85rem; font-weight: 600;">{{ tarihBicimi($post->timestamp) }}</time>
                                    </div>
                                    </figure>
                                <div style="padding: 20px;">
                                    <div style="color: rgba(255,255,255,0.8); font-size: 0.9rem; line-height: 1.6; max-height: 80px; overflow: hidden; text-overflow: ellipsis;">
                                        {{ Str::limit($post->caption, 120) }}
                                        </div>
                                    <a href="{{ $post->permalink }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; color: #dc3545; text-decoration: none; font-weight: 600; font-size: 0.9rem; margin-top: 15px; transition: color 0.3s;" onmouseover="this.style.color='#c82333';" onmouseout="this.style.color='#dc3545';">
                                        <span>Devamını Gör</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Instagram Posts Grid / End -->
                </div>
                <!-- Content / End -->

                <!-- Sidebar -->
                <div id="sidebar" class="sidebar col-lg-4">
                    <!-- Profile Operations Card -->
                    <aside class="widget-modern" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 8px 30px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05);">
                        <div style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08) 0%, rgba(220, 53, 69, 0.03) 100%); padding: 18px 22px; border: none; border-left: 4px solid #dc3545; position: relative; border-radius: 20px 20px 0 0;">
                            <h4 style="color: #fff; font-weight: 700; font-size: 1.25rem; margin: 0; display: flex; align-items: center; gap: 12px;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 10px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                    <i class="fas fa-user-circle" style="color: #fff; font-size: 1rem;"></i>
                                </span>
                                <span>{{ __('common.profile_operations') }}</span>
                            </h4>
                            </div>
                        <div style="padding: 25px;">
                            @if (!session('driverInfo'))
                                <a href="#" class="btn-modern-primary" data-toggle="modal" data-target="#modal-login-register" style="display: flex; align-items: center; justify-content: center; gap: 12px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 16px 24px; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; box-shadow: 0 6px 25px rgba(220, 53, 69, 0.4); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 35px rgba(220, 53, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 25px rgba(220, 53, 69, 0.4)';">
                                    <i class="fas fa-arrow-right-to-bracket"></i>
                                    <span>{{ __('common.login_register') }}</span>
                                </a>
                        @else
                                <a href="{{ route('Dhome') }}" class="btn-modern-primary" style="display: flex; align-items: center; justify-content: center; gap: 12px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 16px 24px; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; box-shadow: 0 6px 25px rgba(220, 53, 69, 0.4); transition: all 0.3s ease; margin-bottom: 15px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 35px rgba(220, 53, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 25px rgba(220, 53, 69, 0.4)';">
                                    <i class="fas fa-id-card"></i>
                                    <span>{{ __('common.go_to_driver_panel') }}</span>
                                            </a>
                                <a href="{{ route('Dlogout') }}" class="btn-modern-secondary" style="display: flex; align-items: center; justify-content: center; gap: 12px; background: rgba(255,255,255,0.1); color: white; padding: 16px 24px; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)';">
                                    <i class="fas fa-arrow-right-from-bracket"></i>
                                    <span>{{ __('common.logout') }}</span>
                                </a>
                        @endif
                            </div>
                        </aside>

                    <!-- Standings Widget -->
                    @if (isset($activeLeague))
                        <style>
                            .widget-standings-modern {
                                background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
                                border-radius: 20px;
                                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
                                overflow: hidden;
                                border: 1px solid rgba(255, 255, 255, 0.05);
                                margin-bottom: 30px;
                            }
                            .widget-standings-modern .widget__title {
                                background: linear-gradient(135deg, rgba(220, 53, 69, 0.08) 0%, rgba(220, 53, 69, 0.03) 100%) !important;
                                padding: 18px 22px !important;
                                border: none !important;
                                border-left: 4px solid #dc3545 !important;
                                border-bottom: none !important;
                                position: relative;
                                border-radius: 20px 20px 0 0;
                            }
                            .widget-standings-modern .widget__title::before {
                                display: none !important;
                                content: none !important;
                            }
                            .widget-standings-modern .widget__title h4 {
                                color: #fff !important;
                                font-weight: 700 !important;
                                font-size: 1.25rem !important;
                                margin: 0 !important;
                                display: flex !important;
                                align-items: center !important;
                                gap: 12px !important;
                            }
                            .widget-standings-modern .widget__title h4 span.icon-box {
                                display: inline-flex !important;
                                align-items: center !important;
                                justify-content: center !important;
                                width: 38px !important;
                                height: 38px !important;
                                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
                                border-radius: 10px !important;
                                box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4) !important;
                                color: #fff !important;
                                font-size: 1rem !important;
                            }
                            .widget-standings-modern .widget__title h4 span.icon-box i {
                                color: #fff !important;
                            }
                            .widget-standings-modern .table-standings {
                                margin: 0;
                                background: transparent;
                            }
                            .widget-standings-modern .table-standings thead {
                                background: rgba(220, 53, 69, 0.1);
                            }
                            .widget-standings-modern .table-standings thead th {
                                color: #fff;
                                font-weight: 700;
                                font-size: 0.75rem;
                                padding: 0.4rem 0.1rem;
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                                border: none;
                            }
                            .widget-standings-modern .table-standings tbody tr {
                                transition: all 0.3s ease;
                                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                            }
                            .widget-standings-modern .table-standings tbody tr:hover {
                                background: rgba(220, 53, 69, 0.1);
                            }
                            .widget-standings-modern .table-standings tbody td {
                                padding: 0.5rem 0.1rem;
                                color: rgba(255,255,255,0.9);
                                vertical-align: middle;
                                border: none;
                                line-height: 1.4;
                            }
                            .widget-standings-modern .podium-row-modern {
                                position: relative;
                            }
                            .widget-standings-modern .podium-row-modern td {
                                padding: 0.5rem 0.1rem !important;
                                line-height: 1.4;
                            }
                            .widget-standings-modern .podium-row-modern .team-meta__name-modern {
                                font-size: 0.9rem !important;
                            }
                            .widget-standings-modern .podium-row-modern .points-display-modern {
                                font-size: 1.05rem !important;
                            }
                            .widget-standings-modern .podium-row-modern.podium-gold-modern {
                                background: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF8C00 100%) !important;
                                box-shadow: 0 4px 20px rgba(255, 215, 0, 0.4);
                            }
                            .widget-standings-modern .podium-row-modern.podium-silver-modern {
                                background: linear-gradient(135deg, #C0C0C0 0%, #A8A8A8 50%, #808080 100%) !important;
                                box-shadow: 0 4px 20px rgba(192, 192, 192, 0.4);
                            }
                            .widget-standings-modern .podium-row-modern.podium-bronze-modern {
                                background: linear-gradient(135deg, #CD7F32 0%, #B87333 50%, #A0522D 100%) !important;
                                box-shadow: 0 4px 20px rgba(205, 127, 50, 0.4);
                            }
                            .widget-standings-modern .podium-row-modern td {
                                color: #fff !important;
                                font-weight: 700 !important;
                                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                            }
                            .widget-standings-modern .rank-badge-modern {
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
                            .widget-standings-modern .podium-row-modern .rank-badge-modern {
                                background: rgba(0, 0, 0, 0.3);
                                border-color: rgba(255, 255, 255, 0.4);
                            }
                            .widget-standings-modern .points-display-modern {
                                font-size: 0.95rem;
                                font-weight: 800;
                                color: #24d9b0;
                                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                            }
                            .widget-standings-modern .podium-row-modern .points-display-modern {
                                color: #fff !important;
                                font-size: 1rem;
                            }
                            .widget-standings-modern .team-meta-modern {
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                                text-align: left;
                            }
                            .widget-standings-modern .driver-photo-modern {
                                width: 32px;
                                height: 32px;
                                border-radius: 50%;
                                object-fit: cover;
                                border: 2px solid rgba(255, 255, 255, 0.2);
                                flex-shrink: 0;
                            }
                            .widget-standings-modern .podium-row-modern .driver-photo-modern {
                                border-color: rgba(255, 255, 255, 0.4);
                            }
                            .widget-standings-modern .team-meta__name-modern {
                                color: #fff;
                                font-weight: 600;
                                font-size: 0.85rem;
                                margin: 0;
                                line-height: 1.2;
                            }
                            .widget-standings-modern .team-meta__place-modern {
                                color: rgba(255, 255, 255, 0.6);
                                font-size: 0.75rem;
                                line-height: 1.2;
                            }
                        </style>
                        <aside class="widget card widget--sidebar widget-standings widget-standings-modern">
                            <div class="widget__title card__header card__header--has-btn" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08) 0%, rgba(220, 53, 69, 0.03) 100%) !important; padding: 18px 22px !important; border: none !important; border-left: 4px solid #dc3545 !important; border-bottom: none !important; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; border-radius: 20px 20px 0 0;">
                                <h4 style="color: #fff !important; font-weight: 700 !important; font-size: 1.25rem !important; margin: 0 !important; display: flex !important; align-items: center !important; gap: 12px !important;">
                                    <span style="display: inline-flex !important; align-items: center !important; justify-content: center !important; width: 38px !important; height: 38px !important; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important; border-radius: 10px !important; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4) !important;">
                                        <i class="fas fa-trophy" style="color: #fff !important; font-size: 1rem !important;"></i>
                                    </span>
                                    <span>{{ $activeLeague->name }}</span>
                                </h4>
                                <a href="{{ route('statistics') }}" class="btn-modern-link" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white !important; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(16, 185, 129, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(16, 185, 129, 0.4)';">
                                    <i class="fas fa-chart-line"></i>
                                    <span>{{ __('common.view_all_statistics') }}</span>
                                </a>
                            </div>
                            <div class="widget__content card__content" style="padding: 0; background: transparent; overflow: hidden;">
                                <div class="table-responsive" style="overflow-x: hidden; overflow-y: hidden;">
                                    <table class="table table-hover table-standings" style="margin: 0;">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px; text-align: center;">#</th>
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
                                                        $podiumClass = 'podium-gold-modern';
                                                        $podiumIcon = '🥇';
                                                    } elseif ($index == 1) {
                                                        $podiumClass = 'podium-silver-modern';
                                                        $podiumIcon = '🥈';
                                                    } elseif ($index == 2) {
                                                        $podiumClass = 'podium-bronze-modern';
                                                        $podiumIcon = '🥉';
                                                    }
                                                @endphp
                                                <tr class="{{ $isPodium ? 'podium-row-modern ' . $podiumClass : '' }}">
                                                    <td style="text-align: center;">
                                                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.15rem;">
                                                            @if($isPodium)
                                                                <span style="font-size: 0.85rem;">{{ $podiumIcon }}</span>
                                                            @endif
                                                            <span class="rank-badge-modern">{{ $index + 1 }}</span>
                                                        </div>
                                                    </td>
                                                    <td style="text-align: left;">
                                                        <div class="team-meta-modern">
                                                            <img src="{{ asset('assets/img/drivers/' . $driverData->id . '.png') }}" 
                                                                 alt="{{ $driverData->name }} {{ $driverData->surname }}"
                                                                 class="driver-photo-modern"
                                                                 onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                                                            <div class="team-meta__info">
                                                                <h6 class="team-meta__name-modern">
                                                                    <a href="{{ route('driver.show', driverSlug($driverData->name, $driverData->surname, $driverData->id)) }}" 
                                                                       style="color: inherit; text-decoration: none; transition: color 0.3s ease;"
                                                                       onmouseover="this.style.color='#24d9b0';"
                                                                       onmouseout="this.style.color='inherit';">
                                                                        {{ $driverData->name . " " . $driverData->surname }}
                                                                    </a>
                                                                </h6>
                                                                <span class="team-meta__place-modern">{{ $driverData->team_name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="text-align: right; padding-right: 0.5rem !important;">
                                                        <span class="points-display-modern">{{ $driverData->total_points }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </aside>
                    @endif
                    <!-- Standings Widget / End -->

                    <!-- Social Media Widget -->
                    <aside class="widget-modern" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 8px 30px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05);">
                        <div style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08) 0%, rgba(220, 53, 69, 0.03) 100%); padding: 18px 22px; border: none; border-left: 4px solid #dc3545; position: relative; border-radius: 20px 20px 0 0;">
                            <h4 style="color: #fff; font-weight: 700; font-size: 1.25rem; margin: 0; display: flex; align-items: center; gap: 12px;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 10px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                    <i class="fas fa-share-alt" style="color: #fff; font-size: 1rem;"></i>
                                </span>
                                <span>Sosyal Medya</span>
                            </h4>
                            </div>
                        <div style="padding: 20px;">
                            <a href="https://www.youtube.com/eracingtr" class="social-btn-modern" target="_blank" style="display: flex; align-items: center; gap: 15px; background: linear-gradient(135deg, #FF0000 0%, #CC0000 100%); color: white; padding: 16px 20px; border-radius: 12px; text-decoration: none; margin-bottom: 12px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(255, 0, 0, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(255, 0, 0, 0.3)';">
                                <i class="fab fa-youtube" style="font-size: 1.5rem;"></i>
                                <span style="font-weight: 600;">{{ __('common.follow_youtube') }}</span>
                        </a>
                            <a href="https://www.twitch.tv/eracingtr" class="social-btn-modern" target="_blank" style="display: flex; align-items: center; gap: 15px; background: linear-gradient(135deg, #9146FF 0%, #772CE8 100%); color: white; padding: 16px 20px; border-radius: 12px; text-decoration: none; margin-bottom: 12px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(145, 70, 255, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(145, 70, 255, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(145, 70, 255, 0.3)';">
                                <i class="fab fa-twitch" style="font-size: 1.5rem;"></i>
                                <span style="font-weight: 600;">{{ __('common.follow_twitch') }}</span>
                        </a>
                            <a href="https://x.com/eracingtr" class="social-btn-modern" target="_blank" style="display: flex; align-items: center; gap: 15px; background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%); color: white; padding: 16px 20px; border-radius: 12px; text-decoration: none; margin-bottom: 12px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.3)';">
                                <i class="fab fa-x" style="font-size: 1.5rem;"></i>
                                <span style="font-weight: 600;">{{ __('common.follow_x') }}</span>
                        </a>
                            <a href="https://www.instagram.com/eracingtr" class="social-btn-modern" target="_blank" style="display: flex; align-items: center; gap: 15px; background: linear-gradient(135deg, #E4405F 0%, #C13584 50%, #833AB4 100%); color: white; padding: 16px 20px; border-radius: 12px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(228, 64, 95, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(228, 64, 95, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(228, 64, 95, 0.3)';">
                                <i class="fab fa-instagram" style="font-size: 1.5rem;"></i>
                                <span style="font-weight: 600;">{{ __('common.follow_instagram') }}</span>
                        </a>
                        </div>
                    </aside>
                    <!-- Social Media Widget / End -->

                    <!-- YouTube Videos Widget -->
                    @if (count($youtubePosts))
                        <aside class="widget-modern" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 20px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 8px 30px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05);">
                            <div style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.08) 0%, rgba(220, 53, 69, 0.03) 100%); padding: 18px 22px; border: none; border-left: 4px solid #dc3545; position: relative; border-radius: 20px 20px 0 0;">
                                <h4 style="color: #fff; font-weight: 700; font-size: 1.25rem; margin: 0; display: flex; align-items: center; gap: 12px;">
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 10px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);">
                                        <i class="fab fa-youtube" style="color: #fff; font-size: 1rem;"></i>
                                    </span>
                                    <span>{{ __('common.latest_uploaded_videos') }}</span>
                                </h4>
                            </div>
                            <div style="padding: 20px;">
                                                @foreach ($youtubePosts as $post)
                                    <div style="margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                        @if(!$loop->last)
                                        @endif
                                        <iframe width="100%" height="200" src="https://www.youtube.com/embed/{{ $post->video_id }}" title="{{ $post->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border-radius: 12px; margin-bottom: 15px;"></iframe>
                                        <h6 style="margin: 0 0 10px 0;">
                                            <a href="https://www.youtube.com/watch?v={{ $post->video_id }}" target="_blank" style="color: #fff; text-decoration: none; font-weight: 600; font-size: 0.95rem; line-height: 1.4; transition: color 0.3s;" onmouseover="this.style.color='#dc3545';" onmouseout="this.style.color='#fff';">
                                                                    {{ $post->title }}
                                                                </a>
                                                            </h6>
                                        <time style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">
                                            <i class="fas fa-calendar-alt mr-2"></i>{{ tarihBicimi($post->publish_time) }}
                                                            </time>
                                                        </div>
                                                @endforeach
                            </div>
                        </aside>
                    @endif
                    <!-- YouTube Videos Widget / End -->
                </div>
                <!-- Sidebar / End -->
            </div>
        </div>
    </div>
@endsection
