    <!-- Team Pages Filter -->
    <nav class="content-filter">
        <div class="container">
            <a href="#" class="content-filter__toggle"></a>
            <ul class="content-filter__list">
                <li class="content-filter__item @if (request()->route()->getName() == 'f1Leagues.pointTable') content-filter__item--active @endif">
                    <a href="{{ route('f1Leagues.pointTable', $link) }}" class="content-filter__link">
                        PUAN TABLOSU
                    </a>
                </li>
                <li class="content-filter__item @if (request()->route()->getName() == 'f1Leagues.results') content-filter__item--active @endif">
                     <a href="{{ route('f1Leagues.results', $link) }}" class="content-filter__link">
{{--                    <a class="content-filter__link" onclick="yapimAsamasinda()">--}}
                        YARIŞ SONUÇLARI
                    </a>
                </li>
                <li class="content-filter__item @if (request()->route()->getName() == 'f1Leagues.refDecisions') content-filter__item--active @endif">
                    {{-- <a href="{{ route('f1Leagues.refDecisions', $link) }}" class="content-filter__link"> --}}
                    <a class="content-filter__link" onclick="yapimAsamasinda()">
                        HAKEM KARARLARI
                    </a>
                </li>
                <li class="content-filter__item @if (request()->route()->getName() == 'f1Leagues.liveBroadcasts') content-filter__item--active @endif">
                    {{-- <a href="{{ route('f1Leagues.liveBroadcasts', $link) }}" class="content-filter__link"> --}}
                    <a class="content-filter__link" onclick="yapimAsamasinda()">
                        CANLI YAYINLAR
                    </a>
                </li>
                <li class="content-filter__item @if (request()->route()->getName() == 'f1Leagues.schedule') content-filter__item--active @endif">
                    {{-- <a href="{{ route('f1Leagues.schedule', $link) }}" class="content-filter__link"> --}}
                    <a class="content-filter__link" onclick="yapimAsamasinda()">
                        FİKSTÜR
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Team Pages Filter / End -->
