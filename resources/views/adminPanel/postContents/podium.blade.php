@extends('adminPanel.layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ========== CANVAS (1000 x 1250) ========== */
        #canvasArea{
            position:relative;
            width:1000px;height:1250px;
            background:url('{{ asset("assets/img/postContentTemplates/podium.jpg") }}') center/cover no-repeat;
            overflow:hidden;border-radius:16px;
            box-shadow:0 10px 30px rgba(0,0,0,.18);
        }

        /* ======= P1/P2/P3 SLOTS ======= */
        .podium-slot{
            position:absolute;
            width:auto;pointer-events:none; /* sadece önizleme */
            text-align:center;
        }

        /* Labels: “1st Max Verstappen” tek satır */
        .podium-label{
            font-family:'Oswald',sans-serif;
            font-weight:500;
            font-size:30px;
            letter-spacing:.3px;
            line-height:1;
            color:#ffffff;
            text-shadow:0 2px 6px rgba(0,0,0,.45);
            white-space:nowrap;
            margin-bottom:8px;
        }

        /* Foto efektleri (üçü için de aynı) */
        .podium-photo{
            display:none;
            filter:
                    brightness(1.12)
                    contrast(1.08)
                    saturate(1.10)
                    drop-shadow(0 22px 48px rgba(0,0,0,.6))
                    drop-shadow(0 0 6px rgba(255,255,255,.55))
                    drop-shadow(0 0 14px rgba(255,255,255,.25))
                    drop-shadow(0 0 20px rgba(255,255,255,.12));
            /* Alt fade – sadece son %10-12’lik kısım */
            -webkit-mask-image:linear-gradient(to bottom, rgba(0,0,0,1) 88%, rgba(0,0,0,0) 100%);
            mask-image:linear-gradient(to bottom, rgba(0,0,0,1) 88%, rgba(0,0,0,0) 100%);
        }

        /* — P1: ortada, en yukarı ve en büyük — */
        #slotP1{ left:50%; transform:translateX(-50%); bottom:360px; }
        #slotP1 .podium-photo{ height:780px; }

        /* — P2: solda orta yükseklik — */
        #slotP2{ left:18%; bottom:230px; transform:translateX(-50%); }
        #slotP2 .podium-photo{ height:640px; }

        /* — P3: sağda, P2’den biraz daha aşağı — */
        #slotP3{ left:82%; bottom:210px; transform:translateX(-50%); }
        #slotP3 .podium-photo{ height:620px; }

        /* Büyük “PODIUM” yazısı (isteğe bağlı) – hafif doku için */
        .podium-text{
            position:absolute;top:520px;left:50%;
            transform:translateX(-50%) rotate(-10deg);
            font-family:'Poppins',sans-serif;font-weight:900;
            font-size:220px;color:rgba(255,255,255,0.04);
            -webkit-text-stroke:4px rgba(255,255,255,.55);
            z-index:1;user-select:none;white-space:nowrap;
        }

        /* Alt bar: sadece bayrak + pist adı */
        .track-bar{
            position:absolute;left:50%;transform:translateX(-50%);
            bottom:78px;width:86%;
            display:flex;align-items:center;justify-content:center;gap:14px;
            color:#fff;font-family:'Oswald',sans-serif;font-weight:600;font-size:28px;
            text-shadow:0 2px 8px rgba(0,0,0,.45);z-index:4;
        }
        .track-flag{ width:44px;height:28px;object-fit:cover;border-radius:3px;box-shadow:0 2px 6px rgba(0,0,0,.35); }
        .track-hr{ position:absolute;left:7%;right:7%;bottom:58px;height:2px;background:rgba(255,255,255,.75);box-shadow:0 1px 6px rgba(0,0,0,.3);z-index:4; }

        /* Select2 tidy */
        .select2-container .select2-selection--single{height:40px!important;display:flex;align-items:center;border-radius:8px}
        .select2-selection__arrow{height:38px!important}
        .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:38px;padding-left:10px}
    </style>
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header"><h5 class="box-title">{{ __('common.ready_posts_podium') }}</h5></div>
                <div class="box-body">

                    <!-- Controls -->
                    <div class="mb-4" style="display:flex;gap:12px;flex-wrap:wrap;align-items:end">
                        <div>
                            <label class="form-label">{{ __('common.p1_driver') }}</label>
                            <select id="p1Select" class="select2 form-control" style="width:260px">
                                <option value="">{{ __('common.select_status') }}</option>
                                @foreach($drivers as $d)
                                    <option value="{{ $d->id }}" data-name="{{ $d->name }}" data-surname="{{ $d->surname }}">
                                        {{ $d->name }} {{ $d->surname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">{{ __('common.p2_driver') }}</label>
                            <select id="p2Select" class="select2 form-control" style="width:260px">
                                <option value="">{{ __('common.select_status') }}</option>
                                @foreach($drivers as $d)
                                    <option value="{{ $d->id }}" data-name="{{ $d->name }}" data-surname="{{ $d->surname }}">
                                        {{ $d->name }} {{ $d->surname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">{{ __('common.p3_driver') }}</label>
                            <select id="p3Select" class="select2 form-control" style="width:260px">
                                <option value="">{{ __('common.select_status') }}</option>
                                @foreach($drivers as $d)
                                    <option value="{{ $d->id }}" data-name="{{ $d->name }}" data-surname="{{ $d->surname }}">
                                        {{ $d->name }} {{ $d->surname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">{{ __('common.track') }}</label>
                            <select id="trackSelect" class="select2 form-control" style="width:260px">
                                <option value="">{{ __('common.select_status') }}</option>
                                @foreach($tracks as $t)
                                    <option value="{{ $t->id }}" data-name="{{ $t->name }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">&nbsp;</label><br>
                            <button id="btnPreview" class="btn btn-primary">{{ __('common.preview') }}</button>
                            <button id="btnDownload" class="btn btn-success">{{ __('common.download_png') }}</button>
                        </div>
                    </div>

                    <!-- Canvas -->
                    <div id="canvasArea">
                        <div class="podium-text">PODIUM</div>

                        <!-- P1 -->
                        <div id="slotP1" class="podium-slot">
                            <div id="labelP1" class="podium-label">1st —</div>
                            <img id="imgP1" class="podium-photo" src="" alt="" crossorigin="anonymous">
                        </div>

                        <!-- P2 -->
                        <div id="slotP2" class="podium-slot">
                            <div id="labelP2" class="podium-label">2nd —</div>
                            <img id="imgP2" class="podium-photo" src="" alt="" crossorigin="anonymous">
                        </div>

                        <!-- P3 -->
                        <div id="slotP3" class="podium-slot">
                            <div id="labelP3" class="podium-label">3rd —</div>
                            <img id="imgP3" class="podium-photo" src="" alt="" crossorigin="anonymous">
                        </div>

                        <!-- Alt Pist Bar -->
                        <div class="track-bar">
                            <img id="trackFlag" class="track-flag" src="" alt="" onerror="this.style.display='none'">
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
            $('#p1Select,#p2Select,#p3Select,#trackSelect').select2({ width:'260px', placeholder:'{{ __('common.select_status') }}' });

            const $imgP1 = $('#imgP1'), $imgP2 = $('#imgP2'), $imgP3 = $('#imgP3');
            const $labelP1 = $('#labelP1'), $labelP2 = $('#labelP2'), $labelP3 = $('#labelP3');
            const $trackFlag = $('#trackFlag'), $trackLabel = $('#trackLabel');

            function driverImgUrl(id){
                return `https://eracingtr.com/assets/img/drivers/${id}.png`;
            }
            function flagUrl(trackId){
                // Daha önce kullandığımız varyantla tutarlı kalalım:
                return `{{ asset('assets/img/flags') }}/${trackId}_b.jpg`;
            }
            function fullName($sel){
                const n = $sel.data('name') || ''; const s = $sel.data('surname') || '';
                return (n + ' ' + s).trim();
            }

            function setImg($img, url){
                $img.hide().attr('src', url).off('load error').on('load', ()=> $img.show());
            }

            function updatePreview(){
                // P1
                const p1sel = $('#p1Select').find(':selected');
                const p1id  = p1sel.val();
                const p1name= fullName(p1sel);
                $labelP1.text(p1name ? `1st ${p1name}` : '1st —');
                if(p1id){ setImg($imgP1, driverImgUrl(p1id)); } else { $imgP1.hide(); }

                // P2
                const p2sel = $('#p2Select').find(':selected');
                const p2id  = p2sel.val();
                const p2name= fullName(p2sel);
                $labelP2.text(p2name ? `2nd ${p2name}` : '2nd —');
                if(p2id){ setImg($imgP2, driverImgUrl(p2id)); } else { $imgP2.hide(); }

                // P3
                const p3sel = $('#p3Select').find(':selected');
                const p3id  = p3sel.val();
                const p3name= fullName(p3sel);
                $labelP3.text(p3name ? `3rd ${p3name}` : '3rd —');
                if(p3id){ setImg($imgP3, driverImgUrl(p3id)); } else { $imgP3.hide(); }

                // Track
                const trSel = $('#trackSelect').find(':selected');
                const trId  = trSel.val();
                const trName= trSel.data('name') || '';
                $trackLabel.text(trName);
                if(trId){ $trackFlag.attr('src', flagUrl(trId)).show(); } else { $trackFlag.hide(); }
            }

            $('#btnPreview').on('click', updatePreview);

            $('#btnDownload').on('click', async ()=>{
                updatePreview();
                await new Promise(r=>setTimeout(r,300));
                html2canvas(document.querySelector('#canvasArea'),{
                    scale:2,useCORS:true,allowTaint:false,backgroundColor:null,width:1000,height:1250
                }).then(cv=>{
                    const a=document.createElement('a');
                    a.download='podium.png';
                    a.href=cv.toDataURL('image/png');
                    a.click();
                }).catch(e=>{
                    alert('{{ __('common.png_cannot_be_created') }}');
                    console.error(e);
                });
            });

            // İlk render
            updatePreview();
        });
    </script>
@endsection
