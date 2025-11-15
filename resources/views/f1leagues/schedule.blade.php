@extends('layouts.layout')

@section('content')
    <!-- Page Heading
                  ================================================== -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">FİKSTÜR</span></h1>
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

            <!-- Schedule & Tickets -->
            <div class="card card--has-table">
                <div class="card__header">
                    <h4>Schedule and Tickets</h4>
                </div>
                <div class="card__content">
                    <div class="table-responsive">
                        <table class="table table-hover team-schedule team-schedule--full">
                            <thead>
                                <tr>
                                    <th class="team-schedule__date">Date</th>
                                    <th class="team-schedule__versus">Versus</th>
                                    <th class="team-schedule__status">Status</th>
                                    <th class="team-schedule__time">Time</th>
                                    <th class="team-schedule__compet">Competition</th>
                                    <th class="team-schedule__venue">Venue</th>
                                    <th class="team-schedule__tickets">Tickets</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="team-schedule__date">Saturday, Mar 24</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/lucky_clovers_shield.png"
                                                    alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">Lucky Clovers</h6>
                                                <span class="team-meta__place">St. Patrick’s Institute</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Away</td>
                                    <td class="team-schedule__time">9:00PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">Madison Cube Stadium</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block ">
                                            Buy Game Tickets
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="team-schedule__date">Friday, May 31</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/red_wings_shield.png" alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">Red Wings</h6>
                                                <span class="team-meta__place">Icarus College</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Home</td>
                                    <td class="team-schedule__time">9:30PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">Alchemists Stadium</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block disabled">
                                            Sold Out
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="team-schedule__date">Saturday, May 8</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/draconians_shield.png" alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">Draconians</h6>
                                                <span class="team-meta__place">Wyvern College</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Away</td>
                                    <td class="team-schedule__time">10:00PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">Scalding Rock Stadium</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block ">
                                            Buy Game Tickets
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="team-schedule__date">Friday, May 14</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/aqua_keyes_shield.png" alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">Aqua Keyes</h6>
                                                <span class="team-meta__place">Pacific Institute</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Home</td>
                                    <td class="team-schedule__time">10:00PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">Alchemists Stadium</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block ">
                                            Buy Game Tickets
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="team-schedule__date">Saturday, May 22</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/icarus_wings_shield.png"
                                                    alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">Icarus Wings</h6>
                                                <span class="team-meta__place">Waxer College</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Away</td>
                                    <td class="team-schedule__time">10:30PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">The FireStar Arena</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block disabled">
                                            Sold Out
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="team-schedule__date">Saturday, May 29</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/bloody_wave_shield.png"
                                                    alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">Bloody Wave</h6>
                                                <span class="team-meta__place">Atlantic School</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Home</td>
                                    <td class="team-schedule__time">9:00PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">Alchemists Stadium</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block ">
                                            Buy Game Tickets
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="team-schedule__date">Friday, Jun 5</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/sharks_shield.png" alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">Sharks</h6>
                                                <span class="team-meta__place">Marine College</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Away</td>
                                    <td class="team-schedule__time">9:30PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">Great Hammerhead Arena</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block disabled">
                                            Sold Out
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="team-schedule__date">Saturday, Jun 13</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/pirates_shield.png" alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">L.A. Pirates</h6>
                                                <span class="team-meta__place">Bebop Institute</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Home</td>
                                    <td class="team-schedule__time">10:00PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">Alchemists Stadium</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block ">
                                            Buy Game Tickets
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="team-schedule__date">Thursday, Jun 8</td>
                                    <td class="team-schedule__versus">
                                        <div class="team-meta">
                                            <figure class="team-meta__logo">
                                                <img src="assets/images/samples/logos/ocean_kings_shield.png"
                                                    alt="">
                                            </figure>
                                            <div class="team-meta__info">
                                                <h6 class="team-meta__name">Ocean Kings</h6>
                                                <span class="team-meta__place">Bay College</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="team-schedule__status">Away</td>
                                    <td class="team-schedule__time">10:00PM EST</td>
                                    <td class="team-schedule__compet">West Bay Playoffs 2018</td>
                                    <td class="team-schedule__venue">Coral Reef LA Institute</td>
                                    <td class="team-schedule__tickets">
                                        <a href="#" class="btn btn-xs btn-default btn-outline btn-block ">
                                            Buy Game Tickets
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Schedule & Tickets / End -->

            <!-- Team Pagination -->
            <nav class="team-pagination" aria-label="Team navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><span class="page-link">...</span></li>
                    <li class="page-item"><a class="page-link" href="#">16</a></li>
                </ul>
            </nav>
            <!-- Team Pagination / End -->
        </div>
    </div>

    <!-- Content / End -->
@endsection
