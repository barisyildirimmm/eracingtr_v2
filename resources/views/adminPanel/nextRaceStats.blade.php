@extends('adminPanel.layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .next-race-stats-page {
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
        .race-info-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .race-info-header {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .race-info-details {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            color: #6b7280;
        }
        .race-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .badge-sprint {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #000;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .driver-milestone-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        .driver-milestone-card:hover {
            transform: translateX(5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }
        .driver-milestone-card.blue { border-left-color: #3b82f6; }
        .driver-milestone-card.orange { border-left-color: #f59e0b; }
        .driver-milestone-card.gold { border-left-color: #fbbf24; }
        .driver-milestone-card.purple { border-left-color: #8b5cf6; }
        .driver-milestone-card.red { border-left-color: #ef4444; }
        .driver-milestone-card.green { border-left-color: #10b981; }
        
        .driver-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }
        .driver-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }
        .driver-team {
            color: #6b7280;
            font-size: 0.875rem;
        }
        .driver-stats {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }
        .stat-value {
            font-weight: 600;
            color: #1f2937;
        }
        .milestones-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .milestone-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }
        .milestone-item:hover {
            border-color: #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }
        .milestone-icon {
            width: 50px;
            height: 50px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }
        .milestone-icon.blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .milestone-icon.orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .milestone-icon.gold { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); }
        .milestone-icon.purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        .milestone-icon.red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .milestone-icon.green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .milestone-text {
            flex: 1;
            font-weight: 600;
            color: #1f2937;
            font-size: 1rem;
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
    </style>
@endsection

@section('content')
<div class="next-race-stats-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-chart-line me-2"></i>{{ __('common.next_race_statistics') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.view_milestones_next_race') }}
            </p>
        </div>

        @if($nextRace)
            <!-- Race Info Card -->
            <div class="race-info-card">
                <div class="race-info-header">
                    <i class="fas fa-flag-checkered"></i>
                    {{ $nextRace->league_name }} - {{ $nextRace->track_name }}
                </div>
                <div class="race-info-details">
                    <div class="race-info-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ date('d.m.Y H:i', strtotime($nextRace->race_date)) }}</span>
                    </div>
                    @if($nextRace->sprint_status)
                        <div class="race-info-item">
                            <span class="badge-sprint">{{ __('common.sprint') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Driver Milestones -->
            @if($driverMilestones->count() > 0)
                @foreach($driverMilestones as $driverData)
                    <div class="driver-milestone-card {{ $driverData['milestones'][0]['color'] ?? 'blue' }}">
                        <div class="driver-header">
                            <div>
                                <div class="driver-name">
                                    {{ $driverData['driver']->name }} {{ $driverData['driver']->surname }}
                                </div>
                                @if($driverData['driver']->team_name)
                                    <div class="driver-team">
                                        <i class="fas fa-users me-1"></i>{{ $driverData['driver']->team_name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="driver-stats">
                            <div class="stat-item">
                                <i class="fas fa-flag-checkered"></i>
                                <span>{{ __('common.race') }}: <span class="stat-value">{{ $driverData['stats']['total_races'] }}</span></span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-flag"></i>
                                <span>{{ __('common.pole') }}: <span class="stat-value">{{ $driverData['stats']['poles'] }}</span></span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-trophy"></i>
                                <span>{{ __('common.wins') }}: <span class="stat-value">{{ $driverData['stats']['wins'] }}</span></span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-medal"></i>
                                <span>{{ __('common.podiums') }}: <span class="stat-value">{{ $driverData['stats']['podiums'] }}</span></span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>{{ __('common.fastest_lap') }}: <span class="stat-value">{{ $driverData['stats']['fastest_laps'] }}</span></span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-chart-line"></i>
                                <span>{{ __('common.points_label') }}: <span class="stat-value">{{ number_format($driverData['stats']['total_points']) }}</span></span>
                            </div>
                        </div>

                        <div class="milestones-list">
                            @foreach($driverData['milestones'] as $milestone)
                                <div class="milestone-item">
                                    <div class="milestone-icon {{ $milestone['color'] }}">
                                        <i class="fas {{ $milestone['icon'] }}"></i>
                                    </div>
                                    <div class="milestone-text">
                                        {{ $milestone['text'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="race-info-card">
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <h5>{{ __('common.no_milestone_for_race') }}</h5>
                        <p class="text-muted">{{ __('common.no_milestone_desc') }}</p>
                    </div>
                </div>
            @endif
        @else
            <div class="race-info-card">
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h5>{{ __('common.no_upcoming_race') }}</h5>
                    <p class="text-muted">{{ __('common.no_upcoming_race_desc') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('js')
@endsection

