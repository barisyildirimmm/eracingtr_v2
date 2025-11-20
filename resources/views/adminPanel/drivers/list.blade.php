@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .drivers-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .drivers-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            color: white;
        }
        .whatsapp-btn {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            text-decoration: none;
        }
        .whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            color: white;
        }
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
        }
        .status-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .status-inactive {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .action-btn {
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            font-size: 0.75rem;
            transition: all 0.3s ease;
            border: none;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            color: white;
        }
        #basic-table_wrapper {
            padding: 1rem;
        }
        #basic-table tbody tr {
            height: auto;
        }
        #basic-table tbody td i {
            font-size: 0.875rem;
        }
        #basic-table {
            border-collapse: separate;
            border-spacing: 0;
        }
        #basic-table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #495057;
            font-weight: 600;
            padding: 0.75rem 0.5rem;
            border-bottom: 2px solid #dee2e6;
            font-size: 0.875rem;
        }
        #basic-table tbody td {
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.875rem;
            vertical-align: middle;
        }
        #basic-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        .phone-cell {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        /* intl-tel-input stilleri */
        .iti {
            width: 100%;
        }
        .iti__flag-container {
            background: white;
            border-right: 2px solid #e5e7eb;
        }
        .iti__selected-flag {
            background: white;
            border-radius: 0.5rem 0 0 0.5rem;
            padding: 0.75rem 10px;
        }
        .iti__selected-flag:hover {
            background: #f9fafb;
        }
        .iti__arrow {
            border-top-color: #6b7280;
        }
        .iti__country-list {
            background: white !important;
            border: 2px solid #e5e7eb !important;
            color: #374151 !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
        }
        .iti__country {
            color: #374151 !important;
        }
        .iti__country:hover,
        .iti__country.iti__highlight {
            background: #f3f4f6 !important;
        }
        .iti__dial-code {
            color: #6b7280;
        }
        #editPhone {
            padding-left: 80px !important;
        }
    </style>
@endsection
@section('content')
<div class="drivers-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-users me-2"></i>{{ __('common.driver_list') }}
                    </h2>
                    <p class="mb-0 opacity-90">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('common.view_and_manage_all_drivers') }}
                    </p>
                </div>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createDriverModal">
                    <i class="fas fa-plus me-2"></i>{{ __('common.add_new_driver') }}
                </button>
            </div>
        </div>

        <!-- Drivers Table Card -->
        <div class="drivers-table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-table me-2"></i>{{ __('common.drivers') }}
                </h5>
            </div>
            <div class="overflow-auto">
                <table id="basic-table" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('common.name') }}</th>
                            <th>{{ __('common.email') }}</th>
                            <th>{{ __('common.steam_id') }}</th>
                            <th>{{ __('common.country') }}</th>
                            <th>{{ __('common.phone') }}</th>
                            <th>{{ __('common.birth_date') }}</th>
                            <th>{{ __('common.email_verification') }}</th>
                            <th>{{ __('common.phone_verification') }}</th>
                            <th>{{ __('common.status') }}</th>
                            <th>{{ __('common.creation_date') }}</th>
                            <th>{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($drivers as $driver)
                            <tr>
                                <td><strong>#{{ $driver->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2" style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.75rem;">
                                            @php
                                                $firstChar = mb_substr($driver->name, 0, 1, 'UTF-8');
                                                $secondChar = mb_substr($driver->surname, 0, 1, 'UTF-8');
                                                $initials = mb_strtoupper($firstChar . $secondChar, 'UTF-8');
                                            @endphp
                                            {{ $initials }}
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <strong>{{ $driver->name . " " . $driver->surname }}</strong>
                                            @if($driver->phone)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $driver->phone) }}" target="_blank" class="whatsapp-btn" title="{{ __('common.whatsapp_send_message') }}">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-envelope me-2 text-muted"></i>{{ $driver->email }}
                                </td>
                                <td>
                                    <i class="fab fa-steam me-2 text-muted"></i>{{ $driver->steam_id ?? '-' }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ getCountryNameFromCode($driver->country ?? '') }}
                                </td>
                                <td>
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    <span>{{ $driver->phone }}</span>
                                </td>
                                <td data-order="{{ $driver->birth_date ? strtotime($driver->birth_date) : 0 }}">
                                    <i class="fas fa-calendar me-2 text-muted"></i>
                                    {{ $driver->birth_date != '' ? tarihBicimi($driver->birth_date, 1) : __('common.not_specified') }}
                                </td>
                                <td>
                                    @if($driver->is_email_verified && $driver->email_verified_at)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle me-1"></i>{{ __('common.verified') }}
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($driver->email_verified_at)->format('d.m.Y H:i') }}</small>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle me-1"></i>{{ __('common.not_verified') }}
                                        </span>
                                        <br>
                                        <button class="btn btn-sm btn-success mt-1" onclick="verifyEmail({{ $driver->id }})" style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">
                                            <i class="fas fa-check me-1"></i>{{ __('common.verify') }}
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    @if($driver->is_phone_verified && $driver->phone_verified_at)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle me-1"></i>{{ __('common.verified') }}
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($driver->phone_verified_at)->format('d.m.Y H:i') }}</small>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle me-1"></i>{{ __('common.not_verified') }}
                                        </span>
                                        <br>
                                        <button class="btn btn-sm btn-success mt-1" onclick="verifyPhone({{ $driver->id }})" style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">
                                            <i class="fas fa-check me-1"></i>{{ __('common.verify') }}
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    @if($driver->status)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle me-1"></i>{{ __('common.active') }}
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle me-1"></i>{{ __('common.inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td data-order="{{ $driver->registration_date ? strtotime($driver->registration_date) : 0 }}">
                                    <i class="fas fa-clock me-2 text-muted"></i>
                                    {{ tarihBicimi($driver->registration_date, 1) }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning action-btn" data-bs-toggle="modal" data-bs-target="#editDriverModal" onclick="editDriver({{ $driver->id }}, '{{ addslashes($driver->name) }}', '{{ addslashes($driver->surname) }}', '{{ $driver->email }}', '{{ $driver->steam_id ?? '' }}', '{{ $driver->psn_id ?? '' }}', '{{ $driver->country_display ?? getCountryNameFromCode($driver->country ?? '') }}', '{{ $driver->phone ?? '' }}', '{{ $driver->birth_date ?? '' }}', '{{ $driver->status }}', {{ $driver->is_email_verified ? 1 : 0 }}, {{ $driver->is_phone_verified ? 1 : 0 }}, '{{ $driver->email_verified_at ?? '' }}', '{{ $driver->phone_verified_at ?? '' }}')">
                                        <i class="fas fa-edit me-1"></i>{{ __('common.edit') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createDriverModal" tabindex="-1" aria-labelledby="createDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 1rem; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 1rem 1rem 0 0;">
                <h5 class="modal-title fw-bold" id="createDriverModalLabel">
                    <i class="fas fa-user-plus me-2"></i>{{ __('common.add_new_driver') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="createDriverForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">{{ __('common.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="{{ __('common.driver_name_placeholder') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="surname" class="form-label fw-semibold">{{ __('common.surname') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="surname" name="surname" required placeholder="{{ __('common.driver_surname_placeholder') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">{{ __('common.email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="{{ __('common.email_placeholder') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">{{ __('common.password') }} <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="{{ __('common.password_placeholder') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="steam_id" class="form-label fw-semibold">{{ __('common.steam_id') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="steam_id" name="steam_id" required placeholder="{{ __('common.steam_id') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="country" class="form-label fw-semibold">{{ __('common.country') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="country" name="country" required placeholder="{{ __('common.country_placeholder') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">{{ __('common.phone') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" required placeholder="{{ __('common.phone_placeholder') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label fw-semibold">{{ __('common.birth_date') }} <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">{{ __('common.status') }} <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">{{ __('common.select_status') }}</option>
                            <option value="1">{{ __('common.active') }}</option>
                            <option value="0">{{ __('common.inactive') }}</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="editDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 1rem; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 1rem 1rem 0 0;">
                <h5 class="modal-title fw-bold" id="editDriverModalLabel">
                    <i class="fas fa-user-edit me-2"></i>{{ __('common.edit_driver') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editDriverForm">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="editDriverId" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editName" class="form-label fw-semibold">{{ __('common.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editSurname" class="form-label fw-semibold">{{ __('common.surname') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editSurname" name="surname" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editEmail" class="form-label fw-semibold">
                                {{ __('common.email') }} <span class="text-danger">*</span>
                                <span id="editEmailVerifiedBadge" class="ms-2"></span>
                            </label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                                <button type="button" class="btn btn-success" id="editVerifyEmailBtn" onclick="verifyEmailFromModal()" style="display: none;">
                                    <i class="fas fa-check me-1"></i>{{ __('common.verify') }}
                                </button>
                            </div>
                            <small id="editEmailVerifiedDate" class="text-muted"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editPassword" class="form-label fw-semibold">{{ __('common.password') }} ({{ __('common.fill_to_change') }})</label>
                            <input type="password" class="form-control" id="editPassword" name="password" placeholder="{{ __('common.leave_empty_to_keep') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editSteamId" class="form-label fw-semibold">{{ __('common.steam_id') }}</label>
                            <input type="text" class="form-control" id="editSteamId" name="steam_id">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editPsnId" class="form-label fw-semibold">{{ __('common.psn_id') }}</label>
                            <input type="text" class="form-control" id="editPsnId" name="psn_id" maxlength="50">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editPhone" class="form-label fw-semibold">
                                {{ __('common.phone') }} <span class="text-danger">*</span>
                                <span id="editPhoneVerifiedBadge" class="ms-2"></span>
                            </label>
                            <div class="input-group">
                                <input type="tel" class="form-control" id="editPhone" name="phone" required style="padding-left: 80px !important;">
                                <button type="button" class="btn btn-success" id="editVerifyPhoneBtn" onclick="verifyPhoneFromModal()" style="display: none;">
                                    <i class="fas fa-check me-1"></i>{{ __('common.verify') }}
                                </button>
                            </div>
                            <small id="editPhoneVerifiedDate" class="text-muted"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editCountry" class="form-label fw-semibold">{{ __('common.country') }}</label>
                            <input type="text" class="form-control" id="editCountry" name="country" disabled>
                            <small class="text-muted">{{ __('common.country_auto_detected_from_phone') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editBirthDate" class="form-label fw-semibold">{{ __('common.birth_date') }}</label>
                            <input type="date" class="form-control" id="editBirthDate" name="birth_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editStatus" class="form-label fw-semibold">{{ __('common.status') }} <span class="text-danger">*</span></label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="0">{{ __('common.inactive') }}</option>
                                <option value="1">{{ __('common.active') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                        <button type="submit" class="btn btn-warning" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none; color: white;">
                            <i class="fas fa-save me-2"></i>{{ __('common.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/js/intlTelInput.min.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.fn.dataTable.ext.type.order['date-custom-pre'] = function (date) {
            var parsedDate = date.split('.').reverse().join('-');
            return new Date(parsedDate).getTime() || 0;
        };

        // Tarih sıralama için özel tip
        $.fn.dataTable.ext.type.order['date-turkish-pre'] = function(data) {
            if (!data || data === 'Belirtilmedi') {
                return 0;
            }
            // Türkçe tarih formatını parse et (dd.mm.yyyy)
            var parts = data.match(/(\d{1,2})\.(\d{1,2})\.(\d{4})/);
            if (parts) {
                var day = parseInt(parts[1], 10);
                var month = parseInt(parts[2], 10);
                var year = parseInt(parts[3], 10);
                return new Date(year, month - 1, day).getTime();
            }
            return 0;
        };

        $(document).ready(function () {
            var table = $('#basic-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                pageLength: 25,
                columnDefs: [
                    {
                        targets: [6, 8],
                        type: 'date-turkish',
                        orderDataType: 'date-turkish'
                    }
                ],
                language: {
                    search: "{{ __('common.datatable_search') }}",
                    lengthMenu: "{{ __('common.datatable_length_menu') }}",
                    info: "{{ __('common.datatable_info') }}",
                    infoEmpty: "{{ __('common.datatable_info_empty') }}",
                    infoFiltered: "{{ __('common.datatable_info_filtered') }}",
                    paginate: {
                        next: "{{ __('common.datatable_next') }}",
                        previous: "{{ __('common.datatable_previous') }}"
                    },
                    zeroRecords: "{{ __('common.datatable_zero_records') }}"
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                responsive: true
            });

            // Tarih filtreleme için özel arama
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    if (settings.nTable.id !== 'basic-table') {
                        return true;
                    }
                    
                    var searchValue = table.search().toLowerCase();
                    if (!searchValue) return true;
                    
                    // Tarih formatlarını kontrol et (dd.mm.yyyy veya dd/mm/yyyy)
                    var datePatterns = [
                        /(\d{1,2})[.\/](\d{1,2})[.\/](\d{4})/,
                        /(\d{4})[.\/-](\d{1,2})[.\/-](\d{1,2})/
                    ];
                    
                    for (var i = 0; i < datePatterns.length; i++) {
                        var match = searchValue.match(datePatterns[i]);
                        if (match) {
                            var day, month, year;
                            if (i === 0) {
                                day = match[1];
                                month = match[2];
                                year = match[3];
                            } else {
                                year = match[1];
                                month = match[2];
                                day = match[3];
                            }
                            
                            var searchDate = year + '-' + month.padStart(2, '0') + '-' + day.padStart(2, '0');
                            
                            // Tarih sütunlarını kontrol et
                            var row = table.row(dataIndex).node();
                            var birthDateCell = $(row).find('td:eq(6)');
                            var regDateCell = $(row).find('td:eq(8)');
                            
                            var birthDateOrder = birthDateCell.data('order');
                            var regDateOrder = regDateCell.data('order');
                            
                            if (birthDateOrder || regDateOrder) {
                                var birthDateStr = birthDateOrder ? new Date(birthDateOrder * 1000).toISOString().split('T')[0] : '';
                                var regDateStr = regDateOrder ? new Date(regDateOrder * 1000).toISOString().split('T')[0] : '';
                                
                                return birthDateStr.includes(searchDate) || regDateStr.includes(searchDate);
                            }
                        }
                    }
                    
                    return true;
                }
            );
        });

        // Create Driver Form
        $('#createDriverForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.drivers.create") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.hata == 0) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('common.success') }}',
                            text: response.aciklama,
                            confirmButtonColor: '#667eea',
                            confirmButtonText: '{{ __('common.ok') }}'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('common.error') }}',
                            text: response.aciklama,
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: '{{ __('common.ok') }}'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('common.error') }}',
                        text: '{{ __('common.error_occurred') }}',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: '{{ __('common.ok') }}'
                    });
                }
            });
        });

        // Edit Driver Form
        $('#editDriverForm').on('submit', function(e) {
            e.preventDefault();
            
            // Telefon numarasını formatlanmış şekilde al
            if (editPhoneIti && editPhoneIti.isValidNumber()) {
                const countryData = editPhoneIti.getSelectedCountryData();
                const dialCode = countryData.dialCode;
                const fullNumber = editPhoneIti.getNumber(); // +905432591260 formatında
                
                // Sadece rakamları al
                const digitsOnly = fullNumber.replace(/\D/g, '');
                
                let formattedNumber = '';
                
                if (dialCode === '90') {
                    // Türkiye formatı: +90 (543) 259 12 60
                    const turkishNumber = digitsOnly.substring(2); // 5432591260 (90'yı çıkar)
                    if (turkishNumber.length === 10) {
                        formattedNumber = '+' + dialCode + ' (' + turkishNumber.substring(0, 3) + ') ' + 
                                         turkishNumber.substring(3, 6) + ' ' + 
                                         turkishNumber.substring(6, 8) + ' ' + 
                                         turkishNumber.substring(8, 10);
                    } else {
                        formattedNumber = '+' + dialCode + ' ' + turkishNumber;
                    }
                } else {
                    // Diğer ülkeler için: +49 123 4567890 formatı
                    const nationalNumber = digitsOnly.substring(dialCode.length);
                    formattedNumber = '+' + dialCode + ' ' + nationalNumber;
                }
                
                $('#editPhone').val(formattedNumber);
            }
            
            var driverId = $('#editDriverId').val();
            var formData = $(this).serialize();
            $.ajax({
                url: '/admin/pilot-duzenle/' + driverId,
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.hata == 0) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('common.success') }}',
                            text: response.aciklama,
                            confirmButtonColor: '#667eea',
                            confirmButtonText: '{{ __('common.ok') }}'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('common.error') }}',
                            text: response.aciklama,
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: '{{ __('common.ok') }}'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('common.error') }}',
                        text: '{{ __('common.error_occurred') }}',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: '{{ __('common.ok') }}'
                    });
                }
            });
        });

        let editPhoneIti = null;
        let editPhoneMask = null;

        function editDriver(id, name, surname, email, steam_id, psn_id, country, phone, birth_date, status, is_email_verified, is_phone_verified, email_verified_at, phone_verified_at) {
            $('#editDriverId').val(id);
            $('#editName').val(name);
            $('#editSurname').val(surname);
            $('#editEmail').val(email);
            $('#editSteamId').val(steam_id || '');
            $('#editPsnId').val(psn_id || '');
            $('#editBirthDate').val(birth_date || '');
            $('#editStatus').val(status);
            
            // Ülke adını göster (backend'den zaten ülke adı geliyor)
            $('#editCountry').val(country || '');
            
            // Telefon input'unu başlat
            const editPhoneInput = document.getElementById('editPhone');
            if (editPhoneInput) {
                // Önceki instance'ı temizle
                if (editPhoneIti) {
                    editPhoneIti.destroy();
                    editPhoneIti = null;
                }
                if (editPhoneMask) {
                    editPhoneMask.destroy();
                    editPhoneMask = null;
                }

                // Mevcut telefon numarasından ülke kodunu belirle
                let initialCountry = 'tr';
                if (phone) {
                    if (phone.startsWith('+90')) {
                        initialCountry = 'tr';
                    } else if (phone.startsWith('+49')) {
                        initialCountry = 'de';
                    } else if (phone.startsWith('+44')) {
                        initialCountry = 'gb';
                    } else if (phone.startsWith('+1')) {
                        initialCountry = 'us';
                    } else if (phone.startsWith('+33')) {
                        initialCountry = 'fr';
                    } else if (phone.startsWith('+39')) {
                        initialCountry = 'it';
                    } else if (phone.startsWith('+34')) {
                        initialCountry = 'es';
                    } else if (phone.startsWith('+351')) {
                        initialCountry = 'pt';
                    }
                }

                // intl-tel-input başlat
                editPhoneIti = window.intlTelInput(editPhoneInput, {
                    initialCountry: initialCountry,
                    preferredCountries: ["tr", "us", "gb", "de", "fr", "it", "es", "pt"],
                    separateDialCode: true,
                    nationalMode: false,
                    autoFormat: true,
                    autoPlaceholder: "aggressive",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/js/utils.js"
                });

                // Mevcut telefon numarasını set et
                if (phone) {
                    // Formatlanmış telefon numarasını temizle (+90 (543) 259 12 60 -> +905432591260)
                    let cleanPhone = phone.replace(/\s+/g, '').replace(/[()]/g, '');
                    
                    // Eğer + ile başlamıyorsa ekle
                    if (!cleanPhone.startsWith('+')) {
                        // Eğer 0 ile başlıyorsa (0905...), 0'ı kaldır ve +90 ekle
                        if (cleanPhone.startsWith('0')) {
                            cleanPhone = '+90' + cleanPhone.substring(1);
                        } else {
                            cleanPhone = '+' + cleanPhone;
                        }
                    }
                    
                    // intl-tel-input'a set et (E164 formatında)
                    editPhoneIti.setNumber(cleanPhone);
                    
                    // intl-tel-input'un formatını kontrol et ve düzelt
                    setTimeout(() => {
                        const countryData = editPhoneIti.getSelectedCountryData();
                        const dialCode = countryData.dialCode;
                        const fullNumber = editPhoneIti.getNumber(); // E164 formatında (+905432591260)
                        
                        // Eğer Türkiye numarasıysa, formatı düzelt
                        if (dialCode === '90' && fullNumber) {
                            const digitsOnly = fullNumber.replace(/\D/g, '');
                            const turkishNumber = digitsOnly.substring(2); // 90'yı çıkar (5432591260)
                            
                            if (turkishNumber.length === 10) {
                                // Türkiye formatı: +90 (543) 259 12 60
                                const formatted = '+' + dialCode + ' (' + turkishNumber.substring(0, 3) + ') ' + 
                                                 turkishNumber.substring(3, 6) + ' ' + 
                                                 turkishNumber.substring(6, 8) + ' ' + 
                                                 turkishNumber.substring(8, 10);
                                
                                // Input'un görünen değerini güncelle
                                // intl-tel-input'un iç değerini korumak için, sadece görünen değeri değiştir
                                const currentValue = editPhoneInput.value;
                                
                                // Eğer yanlış format görünüyorsa (0905 gibi veya parantez yoksa) düzelt
                                if (currentValue && (currentValue.startsWith('0') || !currentValue.includes('('))) {
                                    // Input'un value'sunu manuel olarak formatla
                                    // intl-tel-input'un iç değerini korumak için, setNumber'ı tekrar çağırmadan
                                    // sadece görünen değeri değiştir
                                    editPhoneInput.value = formatted;
                                }
                                
                                // Input event'inde formatı koru
                                const countryDialCode = dialCode; // Closure için
                                const formatPhoneInput = function() {
                                    const currentNum = editPhoneIti.getNumber();
                                    if (currentNum && currentNum.startsWith('+90')) {
                                        const digits = currentNum.replace(/\D/g, '');
                                        const turkNum = digits.substring(2);
                                        if (turkNum.length === 10) {
                                            const fmt = '+' + countryDialCode + ' (' + turkNum.substring(0, 3) + ') ' + 
                                                       turkNum.substring(3, 6) + ' ' + 
                                                       turkNum.substring(6, 8) + ' ' + 
                                                       turkNum.substring(8, 10);
                                            // Sadece formatlanmamışsa güncelle
                                            if (editPhoneInput.value && !editPhoneInput.value.includes('(')) {
                                                editPhoneInput.value = fmt;
                                            }
                                        }
                                    }
                                };
                                
                                // Input ve blur event'lerinde formatı koru
                                editPhoneInput.addEventListener('input', formatPhoneInput);
                                editPhoneInput.addEventListener('blur', formatPhoneInput);
                            }
                        }
                    }, 500);
                }

                // IMask ile telefon numarası formatlama
                function updateEditPhoneMask() {
                    if (editPhoneMask) {
                        editPhoneMask.destroy();
                        editPhoneMask = null;
                    }

                    const countryData = editPhoneIti.getSelectedCountryData();
                    const countryCode = countryData.iso2;

                    const masks = {
                        'tr': '(000) 000 00 00',
                        'us': '(000) 000-0000',
                        'gb': '0000 000000',
                        'de': '000 00000000',
                        'fr': '0 00 00 00 00',
                        'it': '000 000 0000',
                        'es': '000 000 000',
                        'pt': '000 000 000'
                    };

                    let maskPattern = masks[countryCode] || '000000000000';

                    // IMask'ı aktif et - intl-tel-input'un autoFormat özelliği ile birlikte çalışacak
                    // intl-tel-input'un separateDialCode özelliği true olduğu için,
                    // dial code ayrı gösteriliyor, IMask sadece national number kısmını formatlayacak
                    editPhoneMask = IMask(editPhoneInput, {
                        mask: maskPattern,
                        lazy: false,
                        // intl-tel-input ile uyumlu çalışması için
                        overwrite: true,
                        autofix: true
                    });
                }

                // İlk maske oluşturma
                updateEditPhoneMask();

                // Ülke değiştiğinde maske'yi güncelle
                editPhoneInput.addEventListener('countrychange', function() {
                    updateEditPhoneMask();
                });
            }
            
            // E-posta doğrulama durumu
            if (is_email_verified && email_verified_at) {
                $('#editEmailVerifiedBadge').html('<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>{{ __('common.verified') }}</span>');
                $('#editVerifyEmailBtn').hide();
                if (email_verified_at) {
                    const date = new Date(email_verified_at);
                    const formattedDate = date.toLocaleDateString('tr-TR') + ' ' + date.toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                    $('#editEmailVerifiedDate').text('{{ __('common.verified_at') }}: ' + formattedDate);
                }
            } else {
                $('#editEmailVerifiedBadge').html('<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>{{ __('common.not_verified') }}</span>');
                $('#editVerifyEmailBtn').show();
                $('#editEmailVerifiedDate').text('');
            }
            
            // Telefon doğrulama durumu
            if (is_phone_verified && phone_verified_at) {
                $('#editPhoneVerifiedBadge').html('<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>{{ __('common.verified') }}</span>');
                $('#editVerifyPhoneBtn').hide();
                if (phone_verified_at) {
                    const date = new Date(phone_verified_at);
                    const formattedDate = date.toLocaleDateString('tr-TR') + ' ' + date.toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
                    $('#editPhoneVerifiedDate').text('{{ __('common.verified_at') }}: ' + formattedDate);
                }
            } else {
                $('#editPhoneVerifiedBadge').html('<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>{{ __('common.not_verified') }}</span>');
                $('#editVerifyPhoneBtn').show();
                $('#editPhoneVerifiedDate').text('');
            }
        }

        function verifyEmailFromModal() {
            const driverId = $('#editDriverId').val();
            if (!driverId) {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('common.error') }}',
                    text: '{{ __('common.error_occurred') }}',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: '{{ __('common.ok') }}'
                });
                return;
            }
            verifyEmail(driverId);
        }

        function verifyPhoneFromModal() {
            const driverId = $('#editDriverId').val();
            if (!driverId) {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('common.error') }}',
                    text: '{{ __('common.error_occurred') }}',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: '{{ __('common.ok') }}'
                });
                return;
            }
            verifyPhone(driverId);
        }

        function verifyEmail(driverId) {
            Swal.fire({
                title: '{{ __('common.confirm_email_verification') }}',
                text: '{{ __('common.are_you_sure') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: '{{ __('common.yes') }}',
                cancelButtonText: '{{ __('common.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/pilot-email-onayla/' + driverId,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.hata == 0) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('common.success') }}',
                                    text: response.aciklama,
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: '{{ __('common.ok') }}'
                                }).then(() => {
                                    $('#editDriverModal').modal('hide');
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __('common.error') }}',
                                    text: response.aciklama,
                                    confirmButtonColor: '#dc3545',
                                    confirmButtonText: '{{ __('common.ok') }}'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('common.error') }}',
                                text: '{{ __('common.error_occurred') }}',
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: '{{ __('common.ok') }}'
                            });
                        }
                    });
                }
            });
        }

        function verifyPhone(driverId) {
            Swal.fire({
                title: '{{ __('common.confirm_phone_verification') }}',
                text: '{{ __('common.are_you_sure') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: '{{ __('common.yes') }}',
                cancelButtonText: '{{ __('common.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/pilot-telefon-onayla/' + driverId,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.hata == 0) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('common.success') }}',
                                    text: response.aciklama,
                                    confirmButtonColor: '#28a745',
                                    confirmButtonText: '{{ __('common.ok') }}'
                                }).then(() => {
                                    $('#editDriverModal').modal('hide');
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __('common.error') }}',
                                    text: response.aciklama,
                                    confirmButtonColor: '#dc3545',
                                    confirmButtonText: '{{ __('common.ok') }}'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('common.error') }}',
                                text: '{{ __('common.error_occurred') }}',
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: '{{ __('common.ok') }}'
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
