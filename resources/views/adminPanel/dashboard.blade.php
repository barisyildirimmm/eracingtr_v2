@extends('adminPanel.layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 4px solid;
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        .stat-card.blue { border-left-color: #3b82f6; }
        .stat-card.green { border-left-color: #10b981; }
        .stat-card.orange { border-left-color: #f59e0b; }
        .stat-card.red { border-left-color: #ef4444; }
        .stat-card.purple { border-left-color: #8b5cf6; }
        .stat-card.cyan { border-left-color: #06b6d4; }
        .stat-card.pink { border-left-color: #ec4899; }
        .stat-card.indigo { border-left-color: #6366f1; }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .stat-icon.blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }
        .stat-icon.green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
        .stat-icon.orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }
        .stat-icon.red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; }
        .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; }
        .stat-icon.cyan { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; }
        .stat-icon.pink { background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; }
        .stat-icon.indigo { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .info-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            height: 100%;
        }
        .info-card-header {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-item-name {
            color: #374151;
            font-weight: 500;
        }
        .info-item-value {
            color: #6b7280;
            font-size: 0.875rem;
        }
        .badge-sprint {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #000;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
<div class="dashboard-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-tachometer-alt me-2"></i>{{ __('common.admin_dashboard') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.view_all_statistics') }}
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card blue">
                    <div class="stat-icon blue">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-value">{{ $totalLeagues }}</div>
                    <div class="stat-label">{{ __('common.total_leagues') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card green">
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $activeLeagues }}</div>
                    <div class="stat-label">{{ __('common.active_league') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card orange">
                    <div class="stat-icon orange">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value">{{ $totalDrivers }}</div>
                    <div class="stat-label">{{ __('common.total_drivers') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card purple">
                    <div class="stat-icon purple">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="stat-value">{{ $totalTeams }}</div>
                    <div class="stat-label">{{ __('common.total_teams') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card cyan">
                    <div class="stat-icon cyan">
                        <i class="fas fa-road"></i>
                    </div>
                    <div class="stat-value">{{ $totalTracks }}</div>
                    <div class="stat-label">{{ __('common.total_tracks') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card indigo">
                    <div class="stat-icon indigo">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <div class="stat-value">{{ $totalRaceTracks }}</div>
                    <div class="stat-label">{{ __('common.total_races') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card pink">
                    <div class="stat-icon pink">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-value">{{ number_format($totalPointsDistributed) }}</div>
                    <div class="stat-label">{{ __('common.distributed_points') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card red">
                    <div class="stat-icon red">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <div class="stat-value">{{ $totalComplaints + $totalDefenses + $totalAppeals }}</div>
                    <div class="stat-label">{{ __('common.total_referee_operations') }}</div>
                </div>
            </div>
        </div>

        <!-- Hakem Kararları İstatistikleri -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card red">
                    <div class="stat-icon red">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-value">{{ $totalComplaints }}</div>
                    <div class="stat-label">{{ __('common.total_complaint') }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card blue">
                    <div class="stat-icon blue">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="stat-value">{{ $totalDefenses }}</div>
                    <div class="stat-label">{{ __('common.total_defense') }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card orange">
                    <div class="stat-icon orange">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <div class="stat-value">{{ $totalAppeals }}</div>
                    <div class="stat-label">{{ __('common.total_appeal') }}</div>
                </div>
            </div>
        </div>

        <!-- Information Cards -->
        <div class="row g-4">
            <!-- Son Yarışlar -->
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-flag-checkered"></i>
                        {{ __('common.last_5_races') }}
                    </div>
                    @if($recentRaces->count() > 0)
                        @foreach($recentRaces as $race)
                            <div class="info-item">
                                <div>
                                    <div class="info-item-name">
                                        <i class="fas fa-trophy me-1"></i>{{ $race->league_name }}
                                    </div>
                                    <div class="info-item-value">
                                        <i class="fas fa-road me-1"></i>{{ $race->track_name }}
                                        @if($race->sprint_status)
                                            <span class="badge-sprint ms-2">{{ __('common.sprint') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-muted small">
                                    {{ date('d.m.Y', strtotime($race->race_date)) }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-flag-checkered fa-2x mb-2 opacity-50"></i>
                            <p>{{ __('common.no_race_yet_dashboard') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- En Çok Şikayet Alan Yarışlar -->
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ __('common.most_complained_races') }}
                    </div>
                    @if($topComplaintTracks->count() > 0)
                        @foreach($topComplaintTracks as $track)
                            <div class="info-item">
                                <div>
                                    <div class="info-item-name">
                                        <i class="fas fa-trophy me-1"></i>{{ $track->league_name }}
                                    </div>
                                    <div class="info-item-value">
                                        <i class="fas fa-road me-1"></i>{{ $track->track_name }}
                                    </div>
                                </div>
                                <div>
                                    <span class="badge bg-danger">{{ $track->complaint_count }} {{ __('common.complaint_count_badge') }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2 opacity-50"></i>
                            <p>{{ __('common.no_complaint_yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Aktif Ligler -->
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-trophy"></i>
                        {{ __('common.active_leagues') }}
                    </div>
                    @if($activeLeaguesList->count() > 0)
                        @foreach($activeLeaguesList as $league)
                            <div class="info-item">
                                <div class="info-item-name">
                                    <i class="fas fa-trophy me-1"></i>{{ $league->name }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.leagues.list') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-trophy fa-2x mb-2 opacity-50"></i>
                            <p>{{ __('common.no_active_league_yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Son Eklenen Pilotlar -->
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-user-plus"></i>
                        {{ __('common.recently_added_drivers') }}
                    </div>
                    @if($recentDrivers->count() > 0)
                        @foreach($recentDrivers as $driver)
                            <div class="info-item">
                                <div class="info-item-name">
                                    <i class="fas fa-user me-1"></i>{{ $driver->name }} {{ $driver->surname }}
                                </div>
                                <div class="text-muted small">
                                    {{ date('d.m.Y', strtotime($driver->registration_date)) }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-user fa-2x mb-2 opacity-50"></i>
                            <p>{{ __('common.no_driver_yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection

