@extends('adminPanel.layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap');
        #canvasArea{
            position:relative;width:1000px;height:1250px;
            background:url('{{ asset("assets/img/postContentTemplates/pole.jpg?v=3") }}') center/cover no-repeat;
            overflow: hidden;
            /*border-radius: 16px;*/
        }

        .pole-text {
            position: absolute;
            top: 500px;
            left: 50%;
            transform: translateX(-50%) rotate(-20deg);
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            font-size: 380px;
            color: rgba(255, 255, 255, 0.04);
            -webkit-text-stroke: 6px rgba(255, 255, 255, .9);
            z-index: 3;
        }

        .driver-photo {
            position:absolute;
            bottom:150px;
            left:50%;
            transform:translateX(-50%);
            height:900px;
            display:none;
            z-index:2;

            /* mevcut drop shadow kalsın */
            filter: drop-shadow(0 20px 45px rgba(0,0,0,.6));

            /* ALT FADING */
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 95%, rgba(0,0,0,0) 100%);

            /* YENİ EKLEME — beyaz glow çevresi */
            filter:
                    drop-shadow(0 0 6px rgba(255,255,255,.65))
                    drop-shadow(0 0 12px rgba(255,255,255,.35))
                    drop-shadow(0 0 20px rgba(255,255,255,.15));
        }

        .driver-photo::after {
            display: none;
        }

        /* FADE ONLY BOTTOM PART OF PHOTO */
        /*#driverFadeMask {*/
        /*    pointer-events: none;*/
        /*    position: absolute;*/
        /*    left: 0;*/
        /*    right: 0;*/
        /*    bottom: 220px;*/
        /*    height: 820px;*/
        /*    z-index: 3;*/
        /*    display: none;*/
        /*    background: linear-gradient(0deg, rgba(99, 55, 55, 0.55) 0%, rgba(200, 0, 0, 0) 15%, transparent 100%);*/
        /*}*/

        /* LEFT BLOCK — (Name small & clean, then logo) */
        .team-driver-block{
            position:absolute;
            left:30px;
            top:400px;
            display:flex;
            flex-direction:column;
            align-items:flex-start; /* ← BU SOLA ZORLAR */
            justify-content:flex-start;
            gap:10px;
            text-align:left;         /* ← YAZIYI DA SOLA ZORLAR */
            z-index:4;
        }

        .driver-name-left{
            font-family:'Oswald',sans-serif;
            font-weight:500;
            font-size:40px;
            letter-spacing:0.5px;
            line-height:1;
            color:#bcbcbc;
            text-shadow:0 2px 6px rgba(0,0,0,.45);
            white-space:nowrap;
        }

        .team-logo {
            width: 200px;
            height: 200px;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, .45));
            display:block;         /* ← img varsayılan inline-block’tur, ortalamaya sebep olabilir */
            text-align:left;       /* ← garanti */
        }

        /* Track bottom band */
        .track-bar {
            position: absolute;
            bottom: 78px;
            left: 50%;
            transform: translateX(-50%);
            width: 86%;
            display: flex;
            align-items: center;
            gap: 14px;
            justify-content: center;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 28px;
        }

        .track-flag {
            width: 44px;
            height: 28px;
            object-fit: cover;
            border-radius: 3px;
        }

        .track-hr {
            position: absolute;
            left: 7%;
            right: 7%;
            bottom: 58px;
            height: 2px;
            background: #fff;
        }
    </style>

@endsection

@section('content')
    <div class="grid grid-cols-12 mt-6">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header"><h5 class="box-title">Hazır Paylaşımlar — POLE</h5></div>
                <div class="box-body">

                    <div class="mb-4" style="display:flex;gap:12px;flex-wrap:wrap;">
                        <select id="driverSelect" class="select2 form-control" style="width:260px">
                            <option value="">Pilot...</option>
                            @foreach($drivers as $d)
                                <option value="{{ $d->id }}" data-name="{{ $d->name }}" data-surname="{{ $d->surname }}">
                                    {{ $d->name }} {{ $d->surname }}
                                </option>
                            @endforeach
                        </select>

                        <select id="teamSelect" class="select2 form-control" style="width:260px">
                            <option value="">Takım...</option>
                            @foreach($teams as $tm)
                                <option value="{{ $tm->id }}"
                                        data-name="{{ $tm->name }}"
                                        data-color="{{ $tm->color ?? '#FFF' }}">
                                    {{ $tm->name }}
                                </option>
                            @endforeach
                        </select>

                        <select id="trackSelect" class="select2 form-control" style="width:260px">
                            <option value="">Pist...</option>
                            @foreach($tracks as $t)
                                <option value="{{ $t->id }}" data-name="{{ $t->name }}">{{ $t->name }}</option>
                            @endforeach
                        </select>

                        <button id="btnPreview" class="btn btn-primary">Önizle</button>
                        <button id="btnDownload" class="btn btn-success">PNG İndir</button>
                    </div>

                    <div id="canvasArea">
                        <div class="pole-text">POLE</div>

                        <img id="driverImg" class="driver-photo" src="" crossorigin="anonymous">
                        <div id="driverFadeMask"></div>

                        <div id="teamDriverBlock" class="team-driver-block" style="display:none;">
                            <div id="driverNameLeft" class="driver-name-left"></div>
                            <img id="teamLogo" class="team-logo" src="" onerror="this.style.display='none'">
                        </div>

                        <div class="track-bar">
                            <img id="trackFlag" class="track-flag" src="" onerror="this.style.display='none'">
                            <span id="trackLabel"></span>
                        </div>
                        <div class="track-hr"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        $(function(){
            $('#driverSelect,#trackSelect,#teamSelect').select2({ width:'260px' });

            const $driverImg  = $('#driverImg');
            const $fadeMask   = $('#driverFadeMask');
            const $teamBlock  = $('#teamDriverBlock');
            const $teamLogo   = $('#teamLogo');
            const $driverName = $('#driverNameLeft');
            const $trackFlag  = $('#trackFlag');
            const $trackLabel = $('#trackLabel');

            function driverImgUrl(id){
                return `https://eracingtr.com/assets/img/drivers/${id}.png`;
            }
            function teamLogoUrl(id){
                return `{{ asset('assets/img/team_logo') }}2/${id}.png`;
            }
            function flagUrl(id){
                return `{{ asset('assets/img/flags') }}/${id}_b.jpg`;
            }

            function positionLeftBlock(){
                const canvas = document.querySelector('#canvasArea');
                const img    = document.querySelector('#driverImg');
                const block  = document.querySelector('#teamDriverBlock');
                if(!img || img.style.display=='none') return;
                const cRect = canvas.getBoundingClientRect();
                const iRect = img.getBoundingClientRect();
                const midY  = (iRect.top - cRect.top) + iRect.height*0.45;
                block.style.top = (midY - block.offsetHeight*0.5) + 'px';
                block.style.display = 'flex';
            }

            function updatePreview(){
                const dSel = $('#driverSelect').find(':selected');
                const did  = dSel.val();
                $driverName.text(`${dSel.data('name')||''} ${dSel.data('surname')||''}`.trim());

                const tSel = $('#teamSelect').find(':selected');
                const teamId = tSel.val();
                if(teamId){ $teamLogo.attr('src',teamLogoUrl(teamId)).show(); } else $teamLogo.hide();

                if(did){
                    $driverImg.hide().attr('src',driverImgUrl(did)).on('load',()=>{
                        $driverImg.show();$fadeMask.show();
                        if(teamId) setTimeout(positionLeftBlock,80);
                    });
                }else{ $driverImg.hide();$fadeMask.hide();$teamBlock.hide(); }

                const trSel = $('#trackSelect').find(':selected');
                const trId  = trSel.val();
                $trackLabel.text(trSel.data('name') ? trSel.data('name')+' GP' : '');
                if(trId){ $trackFlag.attr('src',flagUrl(trId)).show(); } else $trackFlag.hide();

                if(teamId) $teamBlock.show(); else $teamBlock.hide();
            }

            $('#btnPreview').on('click',updatePreview);

            $('#btnDownload').on('click',async()=>{
                updatePreview();await new Promise(r=>setTimeout(r,300));
                html2canvas(document.querySelector('#canvasArea'),{scale:2,useCORS:true})
                    .then(cv=>{const a=document.createElement('a');a.download='pole.png';a.href=cv.toDataURL();a.click();});
            });

            updatePreview();
        });
    </script>
@endsection
