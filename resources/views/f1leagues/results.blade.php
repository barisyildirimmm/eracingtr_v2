@extends('layouts.layout')

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">YARIŞ <span class="highlight">SONUÇLARI</span></h1>
                </div>
            </div>
        </div>
    </div>

    @include('f1leagues.components.nav')

    <div class="site-content">
        <div class="container">

            <!-- Pist Seçim Kartları -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @foreach($tracks as $track)
                            <a href="{{ route('f1Leagues.results', ['leagueLink' => $link, 'trackId' => $track->f1_league_track_id]) }}"
                               class="btn track-tab px-4 py-2 fw-bold shadow-sm rounded-pill m-1
                                {{ isset($trackID) && $trackID == $track->f1_league_track_id ? 'btn-danger text-white' : 'btn-outline-secondary' }}">
                                <i class="fas fa-flag-checkered"></i> {{ $track->name }}
                                @if($track->sprint_status)
                                    <span class="badge bg-warning text-dark ml-1">Sprint</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Yarış Sonuçları Tablosu -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-trophy mr-1"></i>
                        {{ $raceResults->isEmpty() ? 'Sonuç Bulunamadı' : $raceResults->first()->track_name }}
                        @if(!$raceResults->isEmpty() && $raceResults->first()->sprint_status)
                            <span class="badge bg-warning text-dark ml-1">Sprint</span>
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle text-center">
                            <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Pilot</th>
                                <th class="text-center">Sıralama Süresi</th>
                                <th class="text-center">EN Hızlı Tur (Yarış)</th>
                                <th class="text-center">Toplam Süre</th>
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
                                        {{ $result->driver_name }} {{ $result->driver_surname }}
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
                                    <td colspan="6" class="text-center text-muted">Bu pist için sonuç bulunamadı.</td>
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
