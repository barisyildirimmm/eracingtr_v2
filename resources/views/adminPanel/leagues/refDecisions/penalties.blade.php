@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .penalties-page {
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
        .penalties-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 1.5rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-add {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }
        .table thead th {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: #fff;
            text-align: center;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 0.5rem;
            border: none;
        }
        .table tbody td {
            vertical-align: middle;
            text-align: center;
            font-size: 0.875rem;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: all 0.2s ease;
        }
        .action-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            margin: 0 0.25rem;
        }
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
            color: white;
        }
        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            color: white;
        }
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        .modal-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
        }
        .badge-point {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
        }
    </style>
@endsection
@section('content')
<div class="penalties-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-gavel me-2"></i>{{ __('common.penalty_management') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.penalty_management_desc') }}
            </p>
        </div>

        <!-- Penalties Table -->
        <div class="penalties-table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2"></i>{{ __('common.penalties_list') }}
                </h5>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createPenaltyModal">
                    <i class="fas fa-plus me-2"></i>{{ __('common.add_new_penalty') }}
                </button>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>ID</th>
                            <th><i class="fas fa-tag me-1"></i>{{ __('common.penalty_name') }}</th>
                            <th><i class="fas fa-star me-1"></i>{{ __('common.penalty_point') }}</th>
                            <th><i class="fas fa-list-alt me-1"></i>{{ __('common.penalty_type') }}</th>
                            <th><i class="fas fa-clock me-1"></i>{{ __('common.penalty_time') }}</th>
                            <th><i class="fas fa-cog me-1"></i>{{ __('common.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($penalties as $penalty)
                            <tr>
                                <td>{{ $penalty->id }}</td>
                                <td><strong>{{ $penalty->name }}</strong></td>
                                <td>
                                    @if($penalty->penalty_point)
                                        <span class="badge-point">{{ $penalty->penalty_point }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $penalty->type }}</td>
                                <td>{{ $penalty->time }}</td>
                                <td>
                                    <button class="btn btn-edit action-btn" data-bs-toggle="modal" data-bs-target="#editPenaltyModal" 
                                            onclick="editPenalty({{ $penalty->id }}, '{{ addslashes($penalty->name) }}', {{ $penalty->penalty_point ?? 'null' }}, {{ $penalty->type }}, '{{ $penalty->time }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-delete action-btn" onclick="deletePenalty({{ $penalty->id }}, '{{ addslashes($penalty->name) }}')">
                                        <i class="fas fa-trash"></i>
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
</div>

<!-- Create Modal -->
<div class="modal fade" id="createPenaltyModal" tabindex="-1" aria-labelledby="createPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPenaltyModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>{{ __('common.add_new_penalty') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="createPenaltyForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('common.penalty_name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="{{ __('common.penalty_name_placeholder') }}">
                    </div>
                    <div class="mb-3">
                        <label for="penalty_point" class="form-label">{{ __('common.penalty_point') }}</label>
                        <input type="number" class="form-control" id="penalty_point" name="penalty_point" placeholder="{{ __('common.penalty_point_placeholder') }}">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">{{ __('common.penalty_type') }}</label>
                        <input type="number" class="form-control" id="type" name="type" required placeholder="{{ __('common.penalty_type_placeholder') }}">
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">{{ __('common.penalty_time') }}</label>
                        <input type="text" class="form-control" id="time" name="time" required value="0" placeholder="{{ __('common.penalty_time_placeholder') }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                <button type="button" class="btn btn-primary" onclick="createPenalty()">
                    <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editPenaltyModal" tabindex="-1" aria-labelledby="editPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPenaltyModalLabel">
                    <i class="fas fa-edit me-2"></i>{{ __('common.edit_penalty') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editPenaltyForm">
                    <input type="hidden" id="edit_penalty_id" name="id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">{{ __('common.penalty_name') }}</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required placeholder="{{ __('common.penalty_name_placeholder') }}">
                    </div>
                    <div class="mb-3">
                        <label for="edit_penalty_point" class="form-label">{{ __('common.penalty_point') }}</label>
                        <input type="number" class="form-control" id="edit_penalty_point" name="penalty_point" placeholder="{{ __('common.penalty_point_placeholder') }}">
                    </div>
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">{{ __('common.penalty_type') }}</label>
                        <input type="number" class="form-control" id="edit_type" name="type" required placeholder="{{ __('common.penalty_type_placeholder') }}">
                    </div>
                    <div class="mb-3">
                        <label for="edit_time" class="form-label">{{ __('common.penalty_time') }}</label>
                        <input type="text" class="form-control" id="edit_time" name="time" required placeholder="{{ __('common.penalty_time_placeholder') }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                <button type="button" class="btn btn-primary" onclick="updatePenalty()">
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
        function createPenalty() {
            $.ajax({
                url: '{{ route('admin.penalties.create') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#name').val(),
                    penalty_point: $('#penalty_point').val() || null,
                    type: $('#type').val(),
                    time: $('#time').val()
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

        function editPenalty(id, name, penaltyPoint, type, time) {
            $('#edit_penalty_id').val(id);
            $('#edit_name').val(name);
            $('#edit_penalty_point').val(penaltyPoint && penaltyPoint !== 'null' ? penaltyPoint : '');
            $('#edit_type').val(type);
            $('#edit_time').val(time);
        }

        function updatePenalty() {
            const id = $('#edit_penalty_id').val();
            $.ajax({
                url: '{{ route('admin.penalties.update', '') }}/' + id,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#edit_name').val(),
                    penalty_point: $('#edit_penalty_point').val() || null,
                    type: $('#edit_type').val(),
                    time: $('#edit_time').val()
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

        function deletePenalty(id, name) {
            Swal.fire({
                title: '{{ __('common.are_you_sure') }}',
                text: name + ' {{ __('common.delete_penalty_confirm') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('common.yes_delete') }}',
                cancelButtonText: '{{ __('common.cancel') }}',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.penalties.delete', '') }}/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
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
    </script>
@endsection
