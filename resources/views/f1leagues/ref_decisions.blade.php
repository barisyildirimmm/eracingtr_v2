@extends('layouts.layout')

@section('content')
    <!-- Page Heading
                              ================================================== -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">HAKEM <span class="highlight">KARARLARI</span></h1>
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

            <div class="row">
                <div class="col-lg-4">

                    <!-- Widget: Team Info -->
                    <aside class="widget widget--sidebar card card--no-paddings widget-team-info">
                        <div class="widget__title card__header">
                            <h4>Team Information</h4>
                        </div>
                        <div class="widget__content card__content">
                            <ul class="team-info-list list-unstyled">

                                <li class="team-info__item">
                                    <span class="team-info__label">Team Name:</span>
                                    <span class="team-info__value ">Alchemists L.O. Heroes</span>
                                </li>
                                <li class="team-info__item">
                                    <span class="team-info__label">Country of Origin:</span>
                                    <span class="team-info__value ">United States</span>
                                </li>
                                <li class="team-info__item">
                                    <span class="team-info__label">Founded in:</span>
                                    <span class="team-info__value ">December 2014</span>
                                </li>
                                <li class="team-info__item">
                                    <span class="team-info__label">Prize Money Won in 2017:</span>
                                    <span class="team-info__value team-info__value--active">USD 94.000</span>
                                </li>
                                <li class="team-info__item">
                                    <span class="team-info__label">Total Prize Money Won:</span>
                                    <span class="team-info__value ">USD 2.843.050</span>
                                </li>

                                <li class="team-info__item team-info__item--desc">
                                    <span class="team-info__label">Team Bio:</span>
                                    <span class="team-info__desc">Based in California, and founded by Faye Spiegel “The
                                        Game Huntress”, The Alchemists L.O. Heroes ended up being one of the strongests
                                        teams in the world.</span>
                                </li>

                            </ul>
                        </div>
                    </aside>
                    <!-- Widget: Team Info / End -->

                </div>
            </div>

        </div>
    </div>

    <!-- Content / End -->
@endsection
