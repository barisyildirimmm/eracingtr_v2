@extends('layouts.layout')

@section('content')

    <!-- Page Heading -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">{{ __('common.past_seasons_title') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="site-content py-4">
        <div class="container">
            @if($pastLeagues->count() > 0)
                <div class="row">
                    @foreach($pastLeagues as $league)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card card--has-table" style="height: 100%; transition: all 0.3s ease;">
                                <div class="card__header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <h4 style="color: white; margin: 0;">
                                        <i class="fas fa-trophy me-2"></i>{{ $league->name }}
                                    </h4>
                                </div>
                                <div class="card__content" style="padding: 1.5rem;">
                                    <div class="league-actions">
                                        <a href="{{ route('f1Leagues.pointTable', $league->link) }}" 
                                           class="btn btn-primary btn-block mb-2" 
                                           style="width: 100%; padding: 0.75rem; font-weight: 600; border-radius: 0.5rem;">
                                            <i class="fas fa-chart-bar me-2"></i>{{ __('common.point_table') }}
                                        </a>
                                        <a href="{{ route('f1Leagues.results', $league->link) }}" 
                                           class="btn btn-success btn-block" 
                                           style="width: 100%; padding: 0.75rem; font-weight: 600; border-radius: 0.5rem;">
                                            <i class="fas fa-flag-checkered me-2"></i>{{ __('common.race_results') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card card--has-table">
                    <div class="card__content text-center py-5">
                        <i class="fas fa-trophy fa-3x mb-3 text-muted"></i>
                        <h4 class="text-muted">{{ __('common.no_past_season_yet') }}</h4>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .card.card--has-table:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #653a91 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #0d7a73 0%, #2dd169 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
        }
    </style>

@endsection

@section('js')
    <!-- Font Awesome (CDN) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

