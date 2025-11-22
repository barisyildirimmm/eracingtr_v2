@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .statistics-page {
        padding: 2rem 0;
    }
    .track-selector {
        margin-bottom: 2rem;
        text-align: center;
    }
    .track-btn {
        padding: 0.75rem 1.5rem;
        margin: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .track-btn i {
        margin-right: 0.5rem;
    }
    .track-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .track-btn:not(.active) {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    .track-btn:not(.active):hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: #1a1a1a;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .stat-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }
    .stat-card-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 1rem;
        color: white;
        text-align: center;
    }
    .stat-card-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .stat-card-body {
        padding: 1rem;
    }
    .stat-card-footer {
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-top: 1px solid #e0e0e0;
        font-size: 0.75rem;
        color: #6c757d;
        line-height: 1.4;
    }
    .stat-item {
        display: flex;
        flex-direction: column;
        padding: 0.5rem 0;
        font-size: 0.85rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .stat-item:last-child {
        border-bottom: none;
    }
    .stat-item-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }
    .stat-item-name {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
        color: #333;
    }
    
    .stat-item-name a {
        color: #333 !important;
    }
    
    .stat-item-name a:hover {
        color: #24d9b0 !important;
    }
    .stat-item-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 0.25rem;
        font-size: 0.75rem;
        color: #6c757d;
    }
    .stat-league {
        font-weight: 500;
        color: #495057;
    }
    .stat-track {
        color: #6c757d;
        margin-left: 0.5rem;
    }
    .stat-link {
        color: #007bff;
        text-decoration: none;
        margin-left: 0.5rem;
        transition: color 0.2s;
    }
    .stat-link:hover {
        color: #0056b3;
        text-decoration: none;
    }
    .champions-section {
        margin: 2rem 0;
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
    }
    .champions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    .champion-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .champion-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }
    .champion-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffd700 0%, #ffed4e 100%);
    }
    .champion-rank {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        color: #333;
        box-shadow: 0 2px 10px rgba(255, 215, 0, 0.4);
    }
    .champion-photo {
        width: 150px;
        height: 150px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #ffd700;
        box-shadow: 0 4px 20px rgba(255, 215, 0, 0.3);
        background: white;
    }
    .champion-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .champion-info {
        margin-top: 1rem;
    }
    .champion-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.75rem;
    }
    
    .champion-name a {
        color: #333 !important;
    }
    
    .champion-name a:hover {
        color: #24d9b0 !important;
    }
    .champion-trophy {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: #ffd700;
        font-weight: 600;
        font-size: 1rem;
    }
    .champion-trophy i {
        font-size: 1.5rem;
    }
    .champion-count {
        color: #333;
    }
    .champion-seasons-count {
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #6c757d;
    }
    .champion-seasons-count i {
        color: #28a745;
        font-size: 0.9rem;
    }
    .champion-seasons {
        margin-top: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #6c757d;
    }
    .champion-seasons i {
        color: #667eea;
    }
    .seasons-text {
        font-weight: 500;
        color: #495057;
    }
    .other-champions-section {
        margin: 2rem 0;
        padding: 1.5rem;
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .other-champions-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .other-champions-title i {
        color: #ffd700;
    }
    .other-champions-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .other-champion-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    .other-champion-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .other-champion-rank {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        color: white;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    .other-champion-photo {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #dee2e6;
        margin-right: 1rem;
        flex-shrink: 0;
        background: white;
    }
    .other-champion-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .other-champion-info {
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 0.5rem;
    }
    .other-champion-main {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .other-champion-name {
        font-weight: 600;
        font-size: 1rem;
        color: #333;
    }
    
    .other-champion-name a {
        color: #333 !important;
    }
    
    .other-champion-name a:hover {
        color: #24d9b0 !important;
    }
    .other-champion-trophy {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #ffd700;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .other-champion-trophy i {
        font-size: 1.1rem;
    }
    .other-champion-seasons-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
    .other-champion-seasons-count i {
        color: #28a745;
        font-size: 0.85rem;
    }
    .other-champion-seasons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
    .other-champion-seasons i {
        color: #667eea;
        font-size: 0.9rem;
    }
    .stat-item-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 600;
        font-size: 0.7rem;
        min-width: 25px;
        text-align: center;
        color: white !important;
    }
    .stat-item-value {
        font-weight: 700;
        font-size: 0.9rem;
    }
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    .badge.bg-info {
        background-color: #17a2b8 !important;
    }
    .badge.bg-danger {
        background-color: #dc3545 !important;
    }
    .badge.bg-primary {
        background-color: #007bff !important;
    }
    .badge.bg-secondary {
        background-color: #6c757d !important;
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    .track-title {
        text-align: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .track-title h3 {
        margin: 0;
        font-weight: 700;
    }
</style>

<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h1 class="page-heading__title">{{ __('common.track_statistics') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="site-content">
    <div class="container">
        <!-- {{ __('common.track_selection') }} -->
        <div class="track-selector">
            <a href="{{ route('statistics') }}" 
               class="track-btn {{ !$trackId ? 'active' : '' }}">
                <i class="fas fa-globe me-1"></i>{{ __('common.all') }}
            </a>
            @foreach($allTracks as $track)
                <a href="{{ route('statistics.track', $track->id) }}" 
                   class="track-btn {{ $trackId == $track->id ? 'active' : '' }}">
                    @php
                        $flagPath = asset('assets/img/flags/' . $track->id . '_b.jpg');
                        $flagExists = file_exists(public_path('assets/img/flags/' . $track->id . '_b.jpg'));
                    @endphp
                    @if($flagExists)
                        <img src="{{ $flagPath }}" alt="{{ $track->name }}" style="width: 20px; height: 15px; margin-right: 0.5rem; border-radius: 2px; object-fit: cover;">
                    @else
                        <i class="fas fa-flag-checkered me-1"></i>
                    @endif
                    {{ $track->name }}
                </a>
            @endforeach
        </div>

        <!-- Track Title (if specific track selected) -->
        @if($trackId && $trackStatistics)
        <div class="track-title">
            <h3>
                @php
                    $trackFlagPath = asset('assets/img/flags/' . $trackStatistics['track_id'] . '_b.jpg');
                    $trackFlagExists = file_exists(public_path('assets/img/flags/' . $trackStatistics['track_id'] . '_b.jpg'));
                @endphp
                @if($trackFlagExists)
                    <img src="{{ $trackFlagPath }}" alt="{{ $trackStatistics['track_name'] }}" style="width: 24px; height: 18px; margin-right: 0.75rem; border-radius: 2px; object-fit: cover; vertical-align: middle;">
                @else
                    <i class="fas fa-flag-checkered" style="margin-right: 0.75rem;"></i>
                @endif
                {{ $trackStatistics['track_name'] }} {{ __('common.track_statistics') }}
            </h3>
        </div>
        @endif

        <!-- Statistics Grid -->
        @if($trackId && $trackStatistics)
            <!-- Single Track Statistics (Horizontal Layout) -->
            <div class="stat-grid">
                @if(count($trackStatistics['most_wins']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-trophy"></i>{{ __('common.most_wins_title') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_wins'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-success stat-item-badge">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-success">{{ $driver['count'] }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_wins_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_podiums']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-medal"></i>{{ __('common.most_podiums') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_podiums'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-warning stat-item-badge text-dark">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-warning">{{ $driver['count'] }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_podiums_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_poles']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-flag"></i>{{ __('common.most_poles') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_poles'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-info stat-item-badge">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-info">{{ $driver['count'] }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_poles_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_fastest_laps']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-tachometer-alt"></i>{{ __('common.most_fastest_laps') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_fastest_laps'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-danger stat-item-badge">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-danger">{{ $driver['count'] }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_fastest_laps_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_points']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-star"></i>{{ __('common.most_points') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_points'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-primary stat-item-badge">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-primary">{{ number_format($driver['total'], 0) }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['track_name']) && $driver['track_name'])
                                <span class="stat-track">• {{ $driver['track_name'] }}</span>
                                @endif
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_points_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_races']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-flag-checkered"></i>{{ __('common.most_races') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_races'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-secondary stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="color: inherit; text-decoration: none; transition: color 0.3s ease;"
                                       onmouseover="this.style.color='#24d9b0';"
                                       onmouseout="this.style.color='inherit';">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-secondary">{{ $driver['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_races_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['best_avg_position']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-chart-line"></i>{{ __('common.best_avg_position') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['best_avg_position'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-success stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-success">{{ number_format($driver['avg'], 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.best_avg_position_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_top5']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-trophy"></i>{{ __('common.most_top5') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_top5'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-warning stat-item-badge text-dark">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-warning">{{ $driver['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_top5_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_top10']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-award"></i>{{ __('common.most_top10') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_top10'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-info stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-info">{{ $driver['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_top10_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_positions_gained']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-arrow-up"></i>{{ __('common.most_positions_gained') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_positions_gained'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-success stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-success">+{{ $driver['total_gained'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_positions_gained_desc') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['fastest_qualifying_laps']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-stopwatch"></i>{{ __('common.fastest_qualifying_lap') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['fastest_qualifying_laps'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-primary stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-primary">{{ $driver['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.fastest_qualifying_lap_desc') }}
                        {{ __('common.sorted_fastest_to_slowest') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['fastest_race_laps']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-stopwatch-20"></i>{{ __('common.fastest_race_lap') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['fastest_race_laps'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-danger stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-danger">{{ $driver['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.fastest_race_lap_desc') }}
                        {{ __('common.sorted_fastest_to_slowest') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_positions_lost']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-arrow-down"></i>{{ __('common.most_positions_lost') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_positions_lost'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-danger stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-danger">-{{ $driver['total_lost'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_positions_lost_desc') }}
                        {{ __('common.sorted_by_total_lost') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_consistent']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-chart-line"></i>{{ __('common.most_consistent_driver') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_consistent'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-success stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-success">σ: {{ $driver['std_dev'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_consistent_desc') }}
                        {{ __('common.sorted_by_std_dev') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['most_dnf']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-times-circle"></i>{{ __('common.most_dnf') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['most_dnf'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-danger stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-danger">{{ $driver['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_dnf_desc') }}
                        {{ __('common.sorted_by_dnf_count') }}
                    </div>
                </div>
                @endif

                @if(count($trackStatistics['highest_avg_points']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-star"></i>{{ __('common.highest_avg_points') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($trackStatistics['highest_avg_points'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-primary stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-primary">{{ number_format($driver['avg_points'], 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.highest_avg_points_desc') }}
                        {{ __('common.at_least_5_races_evaluated') }}
                    </div>
                </div>
                @endif
            </div>

        @elseif(!$trackId && $generalStatistics)
            <!-- General Statistics (All Tracks Combined) -->
            <div class="track-title">
                <h3>
                    <i class="fas fa-globe" style="margin-right: 0.75rem;"></i>{{ __('common.general_statistics_all_tracks') }}
                </h3>
            </div>
            
            @if(isset($topChampions) && $topChampions->count() > 0)
            <div class="champions-section">
                <div class="champions-grid">
                    @foreach($topChampions as $index => $champion)
                    <div class="champion-card">
                        <div class="champion-rank">{{ $index + 1 }}</div>
                        <div class="champion-photo">
                            <img src="{{ asset('assets/img/drivers/' . $champion['id'] . '.png') }}" 
                                 alt="{{ $champion['name'] }} {{ $champion['surname'] }}"
                                 onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                        </div>
                        <div class="champion-info">
                            <h4 class="champion-name">
                                <a href="{{ route('driver.show', driverSlug($champion['name'], $champion['surname'], $champion['id'])) }}" 
                                   style="text-decoration: none; transition: color 0.3s ease;">
                                    {{ $champion['name'] }} {{ $champion['surname'] }}
                                </a>
                            </h4>
                            <div class="champion-trophy">
                                <i class="fas fa-trophy"></i>
                                <span class="champion-count">{{ $champion['championships'] }} {{ __('common.championships_count') }}</span>
                            </div>
                            @if(isset($champion['seasons_participated']))
                            <div class="champion-seasons-count">
                                <i class="fas fa-calendar-check"></i>
                                <span>{{ $champion['seasons_participated'] }} {{ __('common.seasons_participated') }}</span>
                            </div>
                            @endif
                            @if(isset($champion['seasons']) && count($champion['seasons']) > 0)
                            <div class="champion-seasons">
                                <span class="seasons-text">
                                    @foreach($champion['seasons'] as $seasonIndex => $season)
                                    <i class="fas fa-calendar-alt"></i>
                                        {{ $season }}<br>
                                    @endforeach
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(isset($otherChampions) && $otherChampions->count() > 0)
            <div class="other-champions-section">
                <h4 class="other-champions-title">
                    <i class="fas fa-medal"></i> {{ __('common.other_champions') }}
                </h4>
                <div class="other-champions-list">
                    @foreach($otherChampions as $index => $champion)
                    <div class="other-champion-item">
                        <div class="other-champion-rank">{{ $index + 1 }}</div>
                        <div class="other-champion-photo">
                            <img src="{{ asset('assets/img/drivers/' . $champion['id'] . '.png') }}" 
                                 alt="{{ $champion['name'] }} {{ $champion['surname'] }}"
                                 onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                        </div>
                        <div class="other-champion-info">
                            <div class="other-champion-main">
                                <span class="other-champion-name">
                                    <a href="{{ route('driver.show', driverSlug($champion['name'], $champion['surname'], $champion['id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $champion['name'] }} {{ $champion['surname'] }}
                                    </a>
                                </span>
                                <span class="other-champion-trophy">
                                    <i class="fas fa-trophy"></i>
                                    {{ $champion['championships'] }} {{ __('common.championships_count') }}
                                </span>
                            </div>
                            @if(isset($champion['seasons_participated']))
                            <div class="other-champion-seasons-count">
                                <i class="fas fa-calendar-check"></i>
                                <span>{{ $champion['seasons_participated'] }} {{ __('common.seasons_participated') }}</span>
                            </div>
                            @endif
                            @if(isset($champion['seasons']) && count($champion['seasons']) > 0)
                            <div class="other-champion-seasons">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="seasons-text">
                                    @foreach($champion['seasons'] as $seasonIndex => $season)
                                        {{ $season }}@if($seasonIndex < count($champion['seasons']) - 1), @endif
                                    @endforeach
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <div class="stat-grid">
                @if(count($generalStatistics['most_wins']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-trophy"></i>{{ __('common.most_wins_title') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_wins'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-success stat-item-badge">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-success">{{ $driver['count'] }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['track_name']) && $driver['track_name'])
                                <span class="stat-track">• {{ $driver['track_name'] }}</span>
                                @endif
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_wins_desc') }}
                        {{ __('common.most_wins_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_podiums']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-medal"></i>{{ __('common.most_podiums') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_podiums'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-warning stat-item-badge text-dark">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-warning">{{ $driver['count'] }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['track_name']) && $driver['track_name'])
                                <span class="stat-track">• {{ $driver['track_name'] }}</span>
                                @endif
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_podiums_desc') }}
                        {{ __('common.most_podiums_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_poles']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-flag"></i>{{ __('common.most_poles') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_poles'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-info stat-item-badge">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-info">{{ $driver['count'] }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['track_name']) && $driver['track_name'])
                                <span class="stat-track">• {{ $driver['track_name'] }}</span>
                                @endif
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_poles_desc') }}
                        {{ __('common.most_poles_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_fastest_laps']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-tachometer-alt"></i>{{ __('common.most_fastest_laps') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_fastest_laps'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-danger stat-item-badge">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-danger">{{ $driver['count'] }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['track_name']) && $driver['track_name'])
                                <span class="stat-track">• {{ $driver['track_name'] }}</span>
                                @endif
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_fastest_laps_desc') }}
                        {{ __('common.most_fastest_laps_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_points']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-star"></i>{{ __('common.most_points') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_points'] as $index => $driver)
                        <div class="stat-item">
                            <div class="stat-item-content">
                                <span class="stat-item-name">
                                    <span class="badge bg-primary stat-item-badge">{{ $index + 1 }}</span>
                                    @if(isset($driver['driver_id']))
                                        <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                           style="text-decoration: none; transition: color 0.3s ease;">
                                            {{ $driver['name'] }} {{ $driver['surname'] }}
                                        </a>
                                    @else
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    @endif
                                </span>
                                <span class="stat-item-value text-primary">{{ number_format($driver['total'], 0) }}</span>
                            </div>
                            @if(isset($driver['league_name']) && $driver['league_name'])
                            <div class="stat-item-meta">
                                <span class="stat-league">{{ $driver['league_name'] }}</span>
                                @if(isset($driver['track_name']) && $driver['track_name'])
                                <span class="stat-track">• {{ $driver['track_name'] }}</span>
                                @endif
                                @if(isset($driver['league_link']) && isset($driver['f1_league_track_id']) && $driver['league_link'] && $driver['f1_league_track_id'])
                                <a href="{{ route('f1Leagues.results', ['leagueLink' => $driver['league_link'], 'trackId' => $driver['f1_league_track_id']]) }}" class="stat-link" target="_blank" title="{{ __('common.race_results') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_points_desc') }}
                        {{ __('common.most_points_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_races']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-flag-checkered"></i>{{ __('common.most_races') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_races'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-secondary stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="color: inherit; text-decoration: none; transition: color 0.3s ease;"
                                       onmouseover="this.style.color='#24d9b0';"
                                       onmouseout="this.style.color='inherit';">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-secondary">{{ $driver['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_races_desc') }}
                        {{ __('common.most_races_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['best_avg_position']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-chart-line"></i>{{ __('common.best_avg_position') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['best_avg_position'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-success stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-success">{{ number_format($driver['avg'], 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_best_avg_position_desc') }}
                        {{ __('common.at_least_3_races_evaluated') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_top5']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-trophy"></i>{{ __('common.most_top5') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_top5'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-warning stat-item-badge text-dark">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-warning">{{ $driver['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_top5_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_top10']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-award"></i>{{ __('common.most_top10') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_top10'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-info stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-info">{{ $driver['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_top10_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_positions_gained']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-arrow-up"></i>{{ __('common.most_positions_gained') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_positions_gained'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-success stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-success">+{{ $driver['total_gained'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.most_positions_gained_desc') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['fastest_qualifying_laps']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-stopwatch"></i>{{ __('common.fastest_qualifying_lap') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['fastest_qualifying_laps'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-primary stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-primary">{{ $driver['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_fastest_qualifying_lap_desc') }}
                        {{ __('common.sorted_fastest_to_slowest') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['fastest_race_laps']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-stopwatch-20"></i>{{ __('common.fastest_race_lap') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['fastest_race_laps'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-danger stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-danger">{{ $driver['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_fastest_race_lap_desc') }}
                        {{ __('common.sorted_fastest_to_slowest') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_positions_lost']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-arrow-down"></i>{{ __('common.most_positions_lost') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_positions_lost'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-danger stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-danger">-{{ $driver['total_lost'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_positions_lost_desc') }}
                        {{ __('common.sorted_by_total_lost') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_consistent']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-chart-line"></i>{{ __('common.most_consistent_driver') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_consistent'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-success stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-success">σ: {{ $driver['std_dev'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_consistent_desc') }}
                        {{ __('common.sorted_by_std_dev') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['most_dnf']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-times-circle"></i>{{ __('common.most_dnf') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['most_dnf'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-danger stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-danger">{{ $driver['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_most_dnf_desc') }}
                        {{ __('common.sorted_by_dnf_count') }}
                    </div>
                </div>
                @endif

                @if(count($generalStatistics['highest_avg_points']) > 0)
                <div class="stat-card">
                    <div class="stat-card-header">
                        <h6><i class="fas fa-star"></i>{{ __('common.highest_avg_points') }}</h6>
                    </div>
                    <div class="stat-card-body">
                        @foreach($generalStatistics['highest_avg_points'] as $index => $driver)
                        <div class="stat-item">
                            <span class="stat-item-name">
                                <span class="badge bg-primary stat-item-badge">{{ $index + 1 }}</span>
                                @if(isset($driver['driver_id']))
                                    <a href="{{ route('driver.show', driverSlug($driver['name'], $driver['surname'], $driver['driver_id'])) }}" 
                                       style="text-decoration: none; transition: color 0.3s ease;">
                                        {{ $driver['name'] }} {{ $driver['surname'] }}
                                    </a>
                                @else
                                    {{ $driver['name'] }} {{ $driver['surname'] }}
                                @endif
                            </span>
                            <span class="stat-item-value text-primary">{{ number_format($driver['avg_points'], 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="stat-card-footer">
                        {{ __('common.all_tracks_highest_avg_points_desc') }}
                        {{ __('common.at_least_5_races_evaluated') }}
                    </div>
                </div>
                @endif
            </div>

        @else
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <div class="empty-state">
                    <i class="fas fa-chart-bar"></i>
                    <h5>{{ __('common.no_statistics_yet') }}</h5>
                    <p class="text-muted">{{ __('common.race_results_will_appear') }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
