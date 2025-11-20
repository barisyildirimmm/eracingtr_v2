@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .league-drivers-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            color: white;
        }
        .drivers-container-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }
        .drivers-column {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
        }
        .column-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .league-column-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        .btn-select-all {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-right: 0.5rem;
        }
        .btn-select-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            color: white;
        }
        .btn-deselect {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-deselect:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4);
            color: white;
        }
        .drivers-list {
            max-height: 500px;
            overflow-y: auto;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            background: white;
        }
        .driver-item {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            background: white;
        }
        .driver-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }
        .league-driver-item {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
        }
        .league-driver-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }
        .driver-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .league-driver-avatar {
            width: 60px;
            height: 60px;
            border: 3px solid #10b981;
        }
        .team-logo-img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            margin-left: 0.5rem;
        }
        .btn-action {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            font-size: 1.25rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-add {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .btn-add:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            color: white;
        }
        .btn-remove {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .btn-remove:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            color: white;
        }
        .team-link {
            color: #3b82f6;
            cursor: pointer;
            text-decoration: underline;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .team-link:hover {
            color: #2563eb;
        }
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        .modal-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 1rem 1rem 0 0;
            border: none;
            padding: 1.5rem;
        }
        .modal-title {
            font-weight: 600;
        }
        .btn-close {
            filter: brightness(0) invert(1);
        }
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        .form-select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }
    </style>
@endsection
@section('content')
<div class="league-drivers-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-users me-2"></i>{{ __('common.league_drivers') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.league_drivers_desc') }}
            </p>
        </div>

        <!-- Drivers Container -->
        <div class="drivers-container-card">
            <div class="row g-4">
                <!-- Sol Taraf: Tüm Pilotlar -->
                <div class="col-md-5">
                    <div class="drivers-column">
                        <div class="column-header">
                            <i class="fas fa-user-friends me-2"></i>{{ __('common.all_drivers') }}
                        </div>
                        <div class="mb-3">
                            <input type="text" id="searchAllDrivers" class="form-control" placeholder="{{ __('common.search_driver_placeholder') }}">
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn-select-all" onclick="selectAllAvailable()">
                                <i class="fas fa-check-double me-1"></i>{{ __('common.select_all') }}
                            </button>
                            <button type="button" class="btn-deselect" onclick="deselectAllAvailable()">
                                <i class="fas fa-times me-1"></i>{{ __('common.deselect_all') }}
                            </button>
                        </div>
                        <div class="drivers-list">
                            <div id="allDriversList">
                                @foreach ($allDrivers as $driver)
                                    <div class="driver-item" data-driver-id="{{ $driver->id }}" data-driver-name="{{ strtolower($driver->name . ' ' . $driver->surname) }}">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input driver-checkbox me-3" type="checkbox" value="{{ $driver->id }}" id="driver_{{ $driver->id }}">
                                            <img src="{{ asset('assets/img/drivers/' . $driver->id . '.png') }}" 
                                                 alt="{{ $driver->name }} {{ $driver->surname }}"
                                                 class="driver-avatar me-3"
                                                 onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                                            <div class="flex-grow-1">
                                                <label class="form-check-label mb-0 fw-semibold" for="driver_{{ $driver->id }}" style="cursor: pointer;">
                                                    {{ $driver->name }} {{ $driver->surname }}
                                                </label>
                                                @if($driver->phone)
                                                    <div class="text-muted small mt-1">
                                                        <i class="fas fa-phone me-1"></i>{{ $driver->phone }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orta: Butonlar -->
                <div class="col-md-2 d-flex flex-column justify-content-center align-items-center gap-3">
                    <button type="button" class="btn-action btn-add" id="addDriversBtn" onclick="addDriversToLeague()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button type="button" class="btn-action btn-remove" id="removeDriversBtn" onclick="removeDriversFromLeague()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>

                <!-- Sağ Taraf: Lige Dahil Olan Pilotlar -->
                <div class="col-md-5">
                    <div class="drivers-column">
                        <div class="column-header league-column-header">
                            <i class="fas fa-users-cog me-2"></i>{{ __('common.league_drivers_included') }}
                        </div>
                        <div class="mb-3">
                            <input type="text" id="searchLeagueDrivers" class="form-control" placeholder="{{ __('common.search_driver_placeholder') }}">
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn-select-all" onclick="selectAllLeague()">
                                <i class="fas fa-check-double me-1"></i>{{ __('common.select_all') }}
                            </button>
                            <button type="button" class="btn-deselect" onclick="deselectAllLeague()">
                                <i class="fas fa-times me-1"></i>{{ __('common.deselect_all') }}
                            </button>
                        </div>
                        <div class="drivers-list">
                            <div id="leagueDriversList">
                                @foreach ($drivers as $driver)
                                    <div class="league-driver-item" data-driver-id="{{ $driver->driver_id }}" data-driver-name="{{ strtolower($driver->name . ' ' . $driver->surname) }}">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input league-driver-checkbox me-3" type="checkbox" value="{{ $driver->driver_id }}" id="league_driver_{{ $driver->driver_id }}">
                                            <img src="{{ asset('assets/img/drivers/' . $driver->driver_id . '.png') }}" 
                                                 alt="{{ $driver->name }} {{ $driver->surname }}"
                                                 class="driver-avatar league-driver-avatar me-3"
                                                 onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-1">
                                                    <label class="form-check-label mb-0 fw-semibold me-2" for="league_driver_{{ $driver->driver_id }}" style="cursor: pointer;">
                                                        {{ $driver->name }} {{ $driver->surname }}
                                                    </label>
                                                    @if($driver->team_id)
                                                        <img src="{{ asset('assets/img/team_logo2/' . $driver->team_id . '.png') }}" 
                                                             alt="{{ $driver->team_name }}"
                                                             class="team-logo-img"
                                                             onerror="this.style.display='none'"
                                                             id="team_logo_{{ $driver->driver_id }}">
                                                    @endif
                                                </div>
                                                @if($driver->phone)
                                                    <div class="text-muted small mb-2">
                                                        <i class="fas fa-phone me-1"></i>{{ $driver->phone }}
                                                    </div>
                                                @endif
                                                <span class="team-link" id="team_btn_{{ $driver->driver_id }}" onclick="openTeamModal({{ $driver->driver_id }}, {{ $driver->team_id ?? 'null' }}, '{{ $driver->team_name ?? '' }}')">
                                                    <i class="fas fa-users me-1"></i>{{ $driver->team_name ? __('common.change_team') : __('common.select_team') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Takım Seç Modal -->
<div class="modal fade" id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teamModalLabel">
                    <i class="fas fa-users me-2"></i>{{ __('common.select_team_modal') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="teamForm">
                    <input type="hidden" id="modal_driver_id" name="driver_id">
                    <input type="hidden" id="modal_league_id" name="league_id" value="{{ $leagueId }}">
                    <div class="mb-3">
                        <label for="team_select" class="form-label">{{ __('common.team_label') }}</label>
                        <select class="form-select" id="team_select" name="team_id">
                            <option value="">{{ __('common.no_team') }}</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="saveTeam()">
                    <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const leagueId = {{ $leagueId }};

        // Sayfa yüklendiğinde tüm checkbox'ları temizle
        $(document).ready(function() {
            $('.driver-checkbox').prop('checked', false);
            $('.league-driver-checkbox').prop('checked', false);
        });

        // Arama fonksiyonları
        $('#searchAllDrivers').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.driver-item').each(function() {
                const driverName = $(this).data('driver-name');
                if (driverName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $('#searchLeagueDrivers').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.league-driver-item').each(function() {
                const driverName = $(this).data('driver-name');
                if (driverName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Tümünü seç / Seçimi kaldır fonksiyonları
        function selectAllAvailable() {
            $('.driver-item:visible .driver-checkbox').prop('checked', true);
        }

        function deselectAllAvailable() {
            $('.driver-item:visible .driver-checkbox').prop('checked', false);
        }

        function selectAllLeague() {
            $('.league-driver-item:visible .league-driver-checkbox').prop('checked', true);
        }

        function deselectAllLeague() {
            $('.league-driver-item:visible .league-driver-checkbox').prop('checked', false);
        }

        // Pilotları lige ekle
        function addDriversToLeague() {
            const selectedDrivers = [];
            $('.driver-checkbox:checked').each(function() {
                selectedDrivers.push($(this).val());
            });

            if (selectedDrivers.length === 0) {
                Swal.fire({
                    title: '{{ __('common.warning') }}',
                    text: '{{ __('common.please_select_at_least_one_driver') }}',
                    icon: 'warning'
                });
                return;
            }

            $.ajax({
                url: '{{ route('admin.leagues.addDriversToLeague') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    league_id: leagueId,
                    driver_ids: selectedDrivers
                },
                success: function(response) {
                    if (response.hata == 0) {
                        Swal.fire({
                            title: '{{ __('common.success') }}',
                            text: response.aciklama,
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: '{{ __('common.error') }}',
                            text: response.aciklama,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: '{{ __('common.error') }}',
                        text: '{{ __('common.error_occurred') }}',
                        icon: 'error'
                    });
                }
            });
        }

        // Pilotları ligden çıkar
        function removeDriversFromLeague() {
            const selectedDrivers = [];
            $('.league-driver-checkbox:checked').each(function() {
                selectedDrivers.push($(this).val());
            });

            if (selectedDrivers.length === 0) {
                Swal.fire({
                    title: '{{ __('common.warning') }}',
                    text: '{{ __('common.please_select_at_least_one_driver') }}',
                    icon: 'warning'
                });
                return;
            }

            Swal.fire({
                title: '{{ __('common.are_you_sure') }}',
                text: '{{ __('common.selected_drivers_will_be_removed') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('common.yes_remove') }}',
                cancelButtonText: '{{ __('common.cancel') }}',
                confirmButtonColor: '#ef4444'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.leagues.removeDriversFromLeague') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            league_id: leagueId,
                            driver_ids: selectedDrivers
                        },
                        success: function(response) {
                            if (response.hata == 0) {
                                Swal.fire({
                                    title: '{{ __('common.success') }}',
                                    text: response.aciklama,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: '{{ __('common.error') }}',
                                    text: response.aciklama,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: '{{ __('common.error') }}',
                                text: '{{ __('common.error_occurred') }}',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        // Takım modalını aç
        function openTeamModal(driverId, teamId, teamName) {
            $('#modal_driver_id').val(driverId);
            if (teamId && teamId !== 'null') {
                $('#team_select').val(teamId);
            } else {
                $('#team_select').val('');
            }
            $('#teamModal').modal('show');
        }

        // Takım kaydet
        function saveTeam() {
            const driverId = $('#modal_driver_id').val();
            const leagueId = $('#modal_league_id').val();
            const teamId = $('#team_select').val() || null;

            $.ajax({
                url: '{{ route('admin.leagues.updateDriverTeam') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    league_id: leagueId,
                    driver_id: driverId,
                    team_id: teamId
                },
                success: function(response) {
                    if (response.hata == 0) {
                        const teamName = response.team_name || '{{ __('common.no_team') }}';
                        const teamId = response.team_id;
                        const noTeamText = '{{ __('common.no_team') }}';
                        const selectTeamText = '{{ __('common.select_team') }}';
                        const changeTeamText = '{{ __('common.change_team') }}';
                        
                        // Takım logosunu güncelle
                        const teamLogoImg = $('#team_logo_' + driverId);
                        if (teamId) {
                            if (teamLogoImg.length === 0) {
                                const logoHtml = '<img src="{{ asset("assets/img/team_logo2") }}/' + teamId + '.png" alt="' + teamName + '" class="team-logo-img" onerror="this.style.display=\'none\'" id="team_logo_' + driverId + '">';
                                $('#team_btn_' + driverId).before(logoHtml);
                            } else {
                                teamLogoImg.attr('src', '{{ asset("assets/img/team_logo2") }}/' + teamId + '.png').show();
                            }
                        } else {
                            teamLogoImg.remove();
                        }
                        
                        // Link metnini güncelle
                        $('#team_btn_' + driverId).html('<i class="fas fa-users me-1"></i>' + (teamName === noTeamText ? selectTeamText : changeTeamText));
                        
                        $('#teamModal').modal('hide');
                        
                        Swal.fire({
                            title: '{{ __('common.success') }}',
                            text: response.aciklama,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: '{{ __('common.error') }}',
                            text: response.aciklama,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: '{{ __('common.error') }}',
                        text: '{{ __('common.error_occurred') }}',
                        icon: 'error'
                    });
                }
            });
        }
    </script>
@endsection
