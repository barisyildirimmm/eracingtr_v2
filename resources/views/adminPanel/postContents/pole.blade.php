@extends('adminPanel.layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap');
        
        .pole-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .page-header-card {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
            color: white;
        }
        
        .controls-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .preview-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        #canvasArea{
            position:relative;
            width:1000px;
            height:1250px;
            max-width: 100%;
            background:url('{{ asset("assets/img/postContentTemplates/pole.jpg?v=3") }}') center/cover no-repeat;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        #canvasArea:hover {
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
            transform: translateY(-5px);
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
            filter: drop-shadow(0 20px 45px rgba(0,0,0,.6))
                    drop-shadow(0 0 6px rgba(255,255,255,.65))
                    drop-shadow(0 0 12px rgba(255,255,255,.35))
                    drop-shadow(0 0 20px rgba(255,255,255,.15));
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 95%, rgba(0,0,0,0) 100%);
        }

        .team-driver-block{
            position:absolute;
            left:30px;
            top:400px;
            display:flex;
            flex-direction:column;
            align-items:flex-start;
            justify-content:flex-start;
            gap:10px;
            text-align:left;
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
            display:block;
            text-align:left;
        }

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
        
        /* Select2 Custom Styles */
        .select2-container--default .select2-selection--single {
            height: 45px;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 43px;
            padding-left: 0.75rem;
            font-weight: 500;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
            right: 10px;
        }
        
        .select2-dropdown {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }
        
        /* Buttons */
        .btn-modern {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        .btn-preview {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }
        
        .btn-preview:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
            color: white;
        }
        
        .btn-download {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }
        
        .btn-download:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .controls-row {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        
        .control-group {
            flex: 1;
            min-width: 200px;
        }
        
        .background-select-group {
            flex: 1;
            min-width: 200px;
        }
        
        @media (max-width: 1200px) {
            #canvasArea {
                width: 100%;
                height: auto;
                aspect-ratio: 1000 / 1250;
            }
            
            .pole-text {
                font-size: 30vw;
            }
        }
    </style>

@endsection

@section('content')
<div class="pole-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-flag-checkered me-2"></i>{{ __('common.create_pole_image') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.create_pole_image_desc') }}
            </p>
        </div>

        <!-- Controls Card -->
        <div class="controls-card">
            <div class="controls-row">
                <div class="control-group">
                    <label class="form-label">
                        <i class="fas fa-user me-1"></i>{{ __('common.pilot') }}
                    </label>
                    <select id="driverSelect" class="select2 form-control" style="width:100%">
                        <option value="">{{ __('common.select_driver_placeholder') }}</option>
                        @foreach($drivers as $d)
                            <option value="{{ $d->id }}" data-name="{{ $d->name }}" data-surname="{{ $d->surname }}">
                                {{ $d->name }} {{ $d->surname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="control-group">
                    <label class="form-label">
                        <i class="fas fa-users me-1"></i>{{ __('common.team_label') }}
                    </label>
                    <select id="teamSelect" class="select2 form-control" style="width:100%">
                        <option value="">{{ __('common.select_team_placeholder') }}</option>
                        @foreach($teams as $tm)
                            <option value="{{ $tm->id }}"
                                    data-name="{{ $tm->name }}"
                                    data-color="{{ $tm->color ?? '#FFF' }}">
                                {{ $tm->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="control-group">
                    <label class="form-label">
                        <i class="fas fa-road me-1"></i>{{ __('common.track') }}
                    </label>
                    <select id="trackSelect" class="select2 form-control" style="width:100%">
                        <option value="">{{ __('common.select_track_placeholder') }}</option>
                        @foreach($tracks as $t)
                            <option value="{{ $t->id }}" data-name="{{ $t->name }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="background-select-group">
                    <label class="form-label">
                        <i class="fas fa-image me-1"></i>{{ __('common.background') }}
                    </label>
                    <select id="backgroundSelect" class="select2 form-control" style="width:100%">
                        <option value="pole.jpg">{{ __('common.default_pole') }}</option>
                        <option value="pole.jpg">{{ __('common.pole_template_1') }}</option>
                        <option value="podium.jpg">{{ __('common.podium_template') }}</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4 d-flex gap-3 flex-wrap">
                <button id="btnPreview" class="btn-modern btn-preview">
                    <i class="fas fa-eye"></i>{{ __('common.preview') }}
                </button>
                <button id="btnDownload" class="btn-modern btn-download">
                    <i class="fas fa-download"></i>{{ __('common.download_png') }}
                </button>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="preview-card">
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
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function(){
            // Initialize Select2
            $('#driverSelect,#trackSelect,#teamSelect,#backgroundSelect').select2({ 
                width: '100%',
                theme: 'default'
            });

            const $driverImg  = $('#driverImg');
            const $fadeMask   = $('#driverFadeMask');
            const $teamBlock  = $('#teamDriverBlock');
            const $teamLogo   = $('#teamLogo');
            const $driverName = $('#driverNameLeft');
            const $trackFlag  = $('#trackFlag');
            const $trackLabel = $('#trackLabel');
            const $canvasArea = $('#canvasArea');
            const $btnDownload = $('#btnDownload');

            function driverImgUrl(id){
                return `https://eracingtr.com/assets/img/drivers/${id}.png`;
            }
            function teamLogoUrl(id){
                return `{{ asset('assets/img/team_logo') }}2/${id}.png`;
            }
            function flagUrl(id){
                return `{{ asset('assets/img/flags') }}/${id}_b.jpg`;
            }
            function backgroundUrl(filename){
                return `{{ asset('assets/img/postContentTemplates') }}/${filename}`;
            }

            // Background selection handler
            $('#backgroundSelect').on('change', function(){
                const bgFile = $(this).val();
                $canvasArea.css('background-image', `url('${backgroundUrl(bgFile)}')`);
            });

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
                if(teamId){ 
                    $teamLogo.attr('src',teamLogoUrl(teamId)).show(); 
                } else { 
                    $teamLogo.hide(); 
                }

                if(did){
                    $driverImg.hide().attr('src',driverImgUrl(did)).on('load',()=>{
                        $driverImg.show();
                        $fadeMask.show();
                        if(teamId) setTimeout(positionLeftBlock,80);
                    }).on('error', function(){
                        Swal.fire({
                            icon: 'warning',
                            title: '{{ __('common.image_not_found') }}',
                            text: '{{ __('common.driver_image_not_loaded') }}',
                            timer: 3000
                        });
                    });
                }else{ 
                    $driverImg.hide();
                    $fadeMask.hide();
                    $teamBlock.hide(); 
                }

                const trSel = $('#trackSelect').find(':selected');
                const trId  = trSel.val();
                $trackLabel.text(trSel.data('name') ? trSel.data('name')+' GP' : '');
                if(trId){ 
                    $trackFlag.attr('src',flagUrl(trId)).show(); 
                } else { 
                    $trackFlag.hide(); 
                }

                if(teamId) $teamBlock.show(); else $teamBlock.hide();
            }

            $('#btnPreview').on('click', function(){
                updatePreview();
                Swal.fire({
                    icon: 'success',
                    title: '{{ __('common.preview_updated') }}',
                    timer: 1500,
                    showConfirmButton: false
                });
            });

            $('#btnDownload').on('click', async function(){
                const $btn = $(this);
                const originalHtml = $btn.html();
                
                // Disable button and show loading
                $btn.prop('disabled', true);
                $btn.html('<i class="fas fa-spinner fa-spin"></i> {{ __('common.downloading') }}');
                
                try {
                    updatePreview();
                    await new Promise(r => setTimeout(r, 500));
                    
                    const canvas = await html2canvas(document.querySelector('#canvasArea'), {
                        scale: 2,
                        useCORS: true,
                        logging: false,
                        backgroundColor: null
                    });
                    
                    const dataUrl = canvas.toDataURL('image/png');
                    const a = document.createElement('a');
                    a.download = 'pole-' + Date.now() + '.png';
                    a.href = dataUrl;
                    a.click();
                    
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('common.success') }}!',
                        text: '{{ __('common.image_downloaded') }}',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('common.error') }}',
                        text: '{{ __('common.image_download_failed') }}',
                    });
                } finally {
                    // Re-enable button
                    $btn.prop('disabled', false);
                    $btn.html(originalHtml);
                }
            });

            // Auto preview on selection change
            $('#driverSelect, #teamSelect, #trackSelect').on('change', function(){
                updatePreview();
            });

            // Initial preview
            updatePreview();
        });
    </script>
@endsection
