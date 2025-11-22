@extends('layouts.layout')

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">{{ __('common.race_results_title') }}</h1>
                </div>
            </div>
        </div>
    </div>

    @include('f1leagues.components.nav')

    <div class="site-content">
        <div class="container">

            <!-- {{ __('common.track_selection_cards') }} -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @foreach($tracks as $track)
                            <a href="{{ route('f1Leagues.results', ['leagueLink' => $link, 'trackId' => $track->f1_league_track_id]) }}"
                               class="btn track-tab px-4 py-2 fw-bold shadow-sm rounded-pill m-1
                                {{ isset($trackID) && $trackID == $track->f1_league_track_id ? 'btn-danger text-white' : 'btn-outline-secondary' }}">
                                <i class="fas fa-flag-checkered"></i> {{ $track->name }}
                                @if($track->sprint_status)
                                    <span class="badge bg-warning text-dark ml-1">{{ __('common.sprint') }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- {{ __('common.race_results_table') }} -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;">
                    <h4 class="mb-0">
                        <i class="fas fa-trophy mr-1"></i>
                        {{ $raceResults->isEmpty() ? __('common.no_result_found') : $raceResults->first()->track_name }}
                        @if(!$raceResults->isEmpty() && $raceResults->first()->sprint_status)
                            <span class="badge bg-warning text-dark ml-1">{{ __('common.sprint') }}</span>
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle text-center">
                            <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>{{ __('common.pilot') }}</th>
                                <th class="text-center">{{ __('common.qualifying_time') }}</th>
                                <th class="text-center">{{ __('common.fastest_lap_race') }}</th>
                                <th class="text-center">{{ __('common.total_time') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($raceResults as $index => $result)
                                <tr class="fw-semibold text-white">
                                    <td>
                                        @if($result->r_ranking == 0)
                                            <span class="text-muted">-</span>
                                        @else
                                            <span class="badge badge-danger p-1" style="font-size: 12px">{{ $result->r_ranking }}</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-start">
{{--                                        <i class="fas fa-user-circle mr-1"></i>--}}
                                        <a href="{{ route('driver.show', driverSlug($result->driver_name, $result->driver_surname, $result->driver_id)) }}" 
                                           style="color: inherit; text-decoration: none; transition: color 0.3s ease;"
                                           onmouseover="this.style.color='#24d9b0';"
                                           onmouseout="this.style.color='inherit';">
                                            {{ $result->driver_name }} {{ $result->driver_surname }}
                                        </a>
                                    </td>
                                    <td>{{ $result->fast_q ?? '-' }}</td>
                                    <td>
                                        @if($result->fastest_lap)
                                            <span class="text-danger" style="font-weight: 900">{{ $result->fast_r ?? '-' }}</span>
                                        @else
                                            {{ $result->fast_r ?? '-' }}
                                        @endif
                                    </td>
                                    <td>{{ $result->total_time ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">{{ __('common.no_result_for_track') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
