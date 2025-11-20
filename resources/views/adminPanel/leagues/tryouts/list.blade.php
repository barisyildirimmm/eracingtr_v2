@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .tryouts-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header-card {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
            color: white;
        }
        .tryouts-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 1.5rem;
            color: white;
        }
        .btn-add-tryout {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }
        .btn-add-tryout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.5);
            color: white;
        }
        .tryout-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .tryout-table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #495057;
            font-weight: 600;
            padding: 1rem;
            border-bottom: 2px solid #dee2e6;
            text-align: center;
            font-size: 0.875rem;
        }
        .tryout-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            text-align: center;
            vertical-align: middle;
        }
        .tryout-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .driver-name-cell {
            text-align: left !important;
            font-weight: 600;
            color: #333;
        }
        .result-input {
            width: 100%;
            max-width: 120px;
            padding: 0.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.375rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        .result-input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            outline: none;
        }
        .btn-save {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
            color: white;
        }
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
            color: white;
        }
        .driver-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 0.75rem;
            border: 2px solid #e5e7eb;
        }
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            padding-left: 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #dc3545;
        }
        .select2-dropdown {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
        }
    </style>
@endsection
@section('content')
<div class="tryouts-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-clipboard-check me-2"></i>{{ __('common.tryout_results') }} - {{ $league->name }}
                    </h2>
                    <p class="mb-0 opacity-90">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('common.tryout_results_for_league') }}
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.leagues.list') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('common.back') }}
                    </a>
                    <button class="btn-add-tryout" data-bs-toggle="modal" data-bs-target="#addTryoutModal">
                        <i class="fas fa-plus me-2"></i>{{ __('common.add_new_tryout_result') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Tryouts Table Card -->
        <div class="tryouts-table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-table me-2"></i>Seçme Sonuçları Listesi
                </h5>
            </div>
            <div class="overflow-auto p-3">
                @if($tryouts->count() > 0)
                <table class="tryout-table">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Pilot</th>
                            <th>1. Gün</th>
                            <th>2. Gün</th>
                            <th>3. Gün</th>
                            <th>4. Gün</th>
                            <th>5. Gün</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tryouts as $tryout)
                        <tr>
                            <td class="driver-name-cell">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/img/drivers/' . $tryout->driver_id . '.png') }}" 
                                         alt="{{ $tryout->name }} {{ $tryout->surname }}"
                                         class="driver-avatar"
                                         onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                                    <div>
                                        <strong>{{ $tryout->name }} {{ $tryout->surname }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text" 
                                       class="result-input" 
                                       value="{{ $tryout->first_day_result ?? '' }}" 
                                       data-tryout-id="{{ $tryout->id }}"
                                       data-field="first_day_result"
                                       placeholder="-">
                            </td>
                            <td>
                                <input type="text" 
                                       class="result-input" 
                                       value="{{ $tryout->second_day_result ?? '' }}" 
                                       data-tryout-id="{{ $tryout->id }}"
                                       data-field="second_day_result"
                                       placeholder="-">
                            </td>
                            <td>
                                <input type="text" 
                                       class="result-input" 
                                       value="{{ $tryout->third_day_result ?? '' }}" 
                                       data-tryout-id="{{ $tryout->id }}"
                                       data-field="third_day_result"
                                       placeholder="-">
                            </td>
                            <td>
                                <input type="text" 
                                       class="result-input" 
                                       value="{{ $tryout->fourth_day_result ?? '' }}" 
                                       data-tryout-id="{{ $tryout->id }}"
                                       data-field="fourth_day_result"
                                       placeholder="-">
                            </td>
                            <td>
                                <input type="text" 
                                       class="result-input" 
                                       value="{{ $tryout->fifth_day_result ?? '' }}" 
                                       data-tryout-id="{{ $tryout->id }}"
                                       data-field="fifth_day_result"
                                       placeholder="-">
                            </td>
                            <td>
                                <button class="btn-save btn-sm" onclick="saveTryoutResult({{ $tryout->id }})">
                                    <i class="fas fa-save me-1"></i>Kaydet
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Henüz seçme sonucu kaydedilmemiş.</p>
                    <button class="btn-add-tryout" data-bs-toggle="modal" data-bs-target="#addTryoutModal">
                        <i class="fas fa-plus me-2"></i>İlk Seçme Sonucunu Ekle
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Tryout Modal -->
<div class="modal fade" id="addTryoutModal" tabindex="-1" aria-labelledby="addTryoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 1rem; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-radius: 1rem 1rem 0 0;">
                <h5 class="modal-title fw-bold" id="addTryoutModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Yeni Seçme Sonucu Ekle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addTryoutForm">
                    @csrf
                    <input type="hidden" name="league_id" value="{{ $league_id }}">
                    <div class="mb-3">
                        <label for="driver_id" class="form-label fw-semibold">Pilot Seçin <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="driver_id" name="driver_id" required style="width: 100%;">
                            <option value="">Pilot Seçin...</option>
                            @foreach($allDrivers as $driver)
                                <option value="{{ $driver->id }}" data-name="{{ $driver->name }}" data-surname="{{ $driver->surname }}">
                                    {{ $driver->name }} {{ $driver->surname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_day_result" class="form-label fw-semibold">1. Gün Sonucu</label>
                            <input type="text" class="form-control" id="first_day_result" name="first_day_result" placeholder="Örn: 1:23.456">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="second_day_result" class="form-label fw-semibold">2. Gün Sonucu</label>
                            <input type="text" class="form-control" id="second_day_result" name="second_day_result" placeholder="Örn: 1:23.456">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="third_day_result" class="form-label fw-semibold">3. Gün Sonucu</label>
                            <input type="text" class="form-control" id="third_day_result" name="third_day_result" placeholder="Örn: 1:23.456">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fourth_day_result" class="form-label fw-semibold">4. Gün Sonucu</label>
                            <input type="text" class="form-control" id="fourth_day_result" name="fourth_day_result" placeholder="Örn: 1:23.456">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="fifth_day_result" class="form-label fw-semibold">5. Gün Sonucu</label>
                        <input type="text" class="form-control" id="fifth_day_result" name="fifth_day_result" placeholder="Örn: 1:23.456">
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn-add-tryout">
                            <i class="fas fa-save me-2"></i>Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Select2 initialization
        $(document).ready(function() {
            $('#driver_id').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilot Seçin...',
                allowClear: true,
                dropdownParent: $('#addTryoutModal'),
                language: {
                    noResults: function() {
                        return "Sonuç bulunamadı";
                    },
                    searching: function() {
                        return "Aranıyor...";
                    }
                }
            });

            // Modal açıldığında Select2'yi yeniden initialize et
            $('#addTryoutModal').on('shown.bs.modal', function () {
                // Eğer Select2 zaten initialize edilmişse destroy et
                if ($('#driver_id').hasClass('select2-hidden-accessible')) {
                    $('#driver_id').select2('destroy');
                }
                // Yeniden initialize et
                $('#driver_id').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: 'Pilot Seçin...',
                    allowClear: true,
                    dropdownParent: $('#addTryoutModal'),
                    language: {
                        noResults: function() {
                            return "Sonuç bulunamadı";
                        },
                        searching: function() {
                            return "Aranıyor...";
                        }
                    }
                });
            });

            // Modal kapandığında Select2'yi temizle
            $('#addTryoutModal').on('hidden.bs.modal', function () {
                $('#driver_id').val(null).trigger('change');
            });
        });
        // Yeni seçme sonucu ekleme
        $('#addTryoutForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Kaydediliyor...',
                text: 'Lütfen bekleyin',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route('admin.leagues.saveTryoutResult') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.hata == 0) {
                        $('#addTryoutForm')[0].reset();
                        $('#addTryoutModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı',
                            text: response.aciklama,
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: response.aciklama,
                            confirmButtonText: 'Tamam'
                        });
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Bir hata oluştu';
                    if (xhr.responseJSON && xhr.responseJSON.aciklama) {
                        errorMsg = xhr.responseJSON.aciklama;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: errorMsg,
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        });

        // Seçme sonucu güncelleme
        function saveTryoutResult(tryoutId) {
            const row = event.target.closest('tr');
            const inputs = row.querySelectorAll('.result-input');
            
            const data = {
                tryout_id: tryoutId,
                first_day_result: inputs[0].value || null,
                second_day_result: inputs[1].value || null,
                third_day_result: inputs[2].value || null,
                fourth_day_result: inputs[3].value || null,
                fifth_day_result: inputs[4].value || null,
                _token: '{{ csrf_token() }}'
            };

            Swal.fire({
                title: 'Güncelleniyor...',
                text: 'Lütfen bekleyin',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route('admin.leagues.updateTryoutResult') }}',
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.hata == 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı',
                            text: response.aciklama,
                            confirmButtonText: 'Tamam'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: response.aciklama,
                            confirmButtonText: 'Tamam'
                        });
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Bir hata oluştu';
                    if (xhr.responseJSON && xhr.responseJSON.aciklama) {
                        errorMsg = xhr.responseJSON.aciklama;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: errorMsg,
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        }
    </script>
@endsection

