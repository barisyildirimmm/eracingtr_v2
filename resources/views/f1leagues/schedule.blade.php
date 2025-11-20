@extends('layouts.layout')

@section('content')
<style>
    .schedule-card {
        background: linear-gradient(135deg, rgba(30, 30, 30, 0.95) 0%, rgba(20, 20, 20, 0.95) 100%);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .schedule-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(255, 255, 255, 0.2);
    }
    .schedule-card.past {
        opacity: 0.6;
    }
    .schedule-card.past:hover {
        opacity: 0.8;
    }
    .track-flag {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        font-weight: bold;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
    }
    .track-flag img {
        width: 40px;
        height: 30px;
        border-radius: 4px;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
    }
    .track-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .track-details {
        flex: 1;
    }
    .track-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 5px;
    }
    .race-date-time {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }
    .date-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .time-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .race-type-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .race-type-badge.sprint {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        color: #856404;
    }
    .race-type-badge.race {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    .qualifying-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .qualifying-badge.yes {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
        color: #155724;
    }
    .qualifying-badge.no {
        background: linear-gradient(135deg, #a8caba 0%, #5d4e75 100%);
        color: white;
    }
    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    @media (max-width: 768px) {
        .schedule-grid {
            grid-template-columns: 1fr;
        }
    }
    .card-header-custom {
        background: linear-gradient(135deg, rgba(40, 40, 40, 0.95) 0%, rgba(30, 30, 30, 0.95) 100%);
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
    }
    .card-title-custom {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>
    <!-- Page Heading
                  ================================================== -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">{{ __('common.schedule_title') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Heading / End -->

    @include('f1leagues.components.nav')

    <!-- Content
                  ================================================== -->
    <div class="site-content">
        <div class="container">
            @if(isset($schedule) && $schedule->count() > 0)
            <div class="card schedule-card">
                <div class="card-header-custom">
                    <h4 class="card-title-custom">
                        <i class="fas fa-calendar-alt"></i>
                        {{ __('common.schedule') }}
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="schedule-grid">
                        @foreach($schedule as $race)
                        <div class="schedule-card {{ $race->is_past ? 'past' : '' }}" style="padding: 20px;">
                            <div class="track-info">
                                @php
                                    $flagPath = asset('assets/img/flags/' . $race->track_id . '_b.jpg');
                                    $flagExists = file_exists(public_path('assets/img/flags/' . $race->track_id . '_b.jpg'));
                                @endphp
                                @if($flagExists)
                                    <img src="{{ $flagPath }}" alt="{{ $race->track_name }}" class="track-flag">
                                @else
                                    <div class="track-flag">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                @endif
                                <div class="track-details">
                                    <div class="track-name">{{ $race->track_name }}</div>
                                    <div class="race-date-time">
                                        <span class="date-badge">
                                            <i class="fas fa-calendar"></i>
                                            {{ $race->race_date_formatted }}
                                        </span>
                                        <span class="time-badge">
                                            <i class="fas fa-clock"></i>
                                            {{ $race->race_time_formatted }}
                                        </span>
                                    </div>
                                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                                        @if($race->sprint_status)
                                        <span class="race-type-badge sprint">
                                            <i class="fas fa-bolt"></i> {{ __('common.sprint') }}
                                        </span>
                                        @else
                                        <span class="race-type-badge race">
                                            <i class="fas fa-flag-checkered"></i> {{ __('common.race') }}
                                        </span>
                                        @endif
                                        @if($race->qualifying_type == 1)
                                        <span class="qualifying-badge yes">
                                            <i class="fas fa-check-circle"></i> {{ __('common.qualifying') }}
                                        </span>
                                        @else
                                        <span class="qualifying-badge no">
                                            <i class="fas fa-times-circle"></i> {{ __('common.no_qualifying') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info">
                <p>{{ __('common.no_schedule') }}</p>
            </div>
            @endif
        </div>
    </div>
    <!-- Content / End -->
@endsection
