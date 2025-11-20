@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .calendar-page {
        padding: 2rem 0;
    }
    .calendar-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .calendar-header h1 {
        margin: 0;
        font-weight: 700;
        font-size: 2.5rem;
    }
    .calendar-events {
        max-width: 900px;
        margin: 0 auto;
    }
    .calendar-day {
        margin-bottom: 2rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }
    .calendar-day-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 1rem 1.5rem;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .calendar-day-date {
        font-size: 1.25rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .calendar-day-date i {
        font-size: 1.5rem;
    }
    .calendar-day-content {
        padding: 1.5rem;
    }
    .calendar-race-item {
        padding: 1rem;
        margin-bottom: 1rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    .calendar-race-item:last-child {
        margin-bottom: 0;
    }
    .calendar-race-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .race-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }
    .race-title {
        flex: 1;
    }
    .race-title h4 {
        margin: 0 0 0.25rem 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
    }
    .race-league {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    .race-time {
        font-size: 0.85rem;
        color: #667eea;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }
    .race-badges {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
        flex-wrap: wrap;
    }
    .badge-sprint {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .badge-race {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .badge-combined {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
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
    .race-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        transition: all 0.3s ease;
    }
    .race-link:hover {
        color: #764ba2;
        transform: translateX(3px);
    }
</style>

<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h1 class="page-heading__title">{{ __('common.race_calendar') }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="site-content">
    <div class="container">
        <div class="calendar-page">
            @if(count($calendarEvents) > 0)
                <div class="calendar-events">
                    @foreach($calendarEvents as $dateKey => $day)
                        <div class="calendar-day">
                            <div class="calendar-day-header">
                                <div class="calendar-day-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ $day['date_formatted'] }}</span>
                                </div>
                            </div>
                            <div class="calendar-day-content">
                                @foreach($day['races'] as $race)
                                    <div class="calendar-race-item">
                                        <div class="race-header">
                                            <div class="race-title">
                                                <h4>
                                                    <i class="fas fa-flag-checkered" style="margin-right: 0.75rem;"></i>{{ $race['track_name'] }}
                                                </h4>
                                                <div class="race-league">
                                                    <i class="fas fa-trophy me-1"></i>{{ $race['league_name'] }}
                                                </div>
                                            </div>
                                            <div class="race-time">
                                                <i class="fas fa-clock"></i>
                                                {{ $race['race_time'] }}
                                            </div>
                                        </div>
                                        <div class="race-badges">
                                            @if($race['has_sprint'] && $race['has_race'])
                                                <span class="badge-combined">
                                                    <i class="fas fa-bolt"></i>{{ __('common.sprint_plus_race') }}
                                                </span>
                                            @elseif($race['has_sprint'])
                                                <span class="badge-sprint">
                                                    <i class="fas fa-bolt"></i>Sprint
                                                </span>
                                            @elseif($race['has_race'])
                                                <span class="badge-race">
                                                    <i class="fas fa-flag-checkered"></i>{{ __('common.race') }}
                                                </span>
                                            @endif
                                        </div>
                                        <a href="{{ route('f1Leagues.results', $race['league_link']) }}" class="race-link">
                                            <i class="fas fa-external-link-alt"></i>
                                            {{ __('common.race_results') }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h5>{{ __('common.no_upcoming_race_calendar') }}</h5>
                            <p class="text-muted">{{ __('common.will_appear_soon') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

