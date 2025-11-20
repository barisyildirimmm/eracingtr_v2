@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .teams-page {
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
        .teams-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
    </style>
@endsection
@section('content')
<div class="teams-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-users me-2"></i>{{ __('common.team_list') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.team_list_desc') }}
            </p>
        </div>

        <!-- Teams Table -->
        <div class="teams-table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2"></i>{{ __('common.teams_list') }}
                </h5>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createTeamModal">
                    <i class="fas fa-plus me-2"></i>{{ __('common.add_new') }}
                </button>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table id="teamsTable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>ID</th>
                            <th><i class="fas fa-tag me-1"></i>{{ __('common.name') }}</th>
                            <th><i class="fas fa-cog me-1"></i>{{ __('common.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($teams as $team)
                            <tr>
                                <td>{{ $team->id }}</td>
                                <td><strong>{{ $team->name }}</strong></td>
                                <td>
                                    <button class="btn btn-edit action-btn" data-bs-toggle="modal" data-bs-target="#editTeamModal" onclick="editTeam({{ $team->id }}, '{{ $team->name }}')">
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
</div>

<!-- Create Modal -->
<div class="modal fade" id="createTeamModal" tabindex="-1" aria-labelledby="createTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTeamModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>{{ __('common.add_new_team_modal') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="createTeamForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('common.team_name_label') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="{{ __('common.team_name_placeholder') }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="createTeam()">
                    <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editTeamModal" tabindex="-1" aria-labelledby="editTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTeamModalLabel">
                    <i class="fas fa-edit me-2"></i>{{ __('common.edit_team') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editTeamForm">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">{{ __('common.team_name_label') }}</label>
                        <input type="text" class="form-control" id="editName" name="name" required placeholder="{{ __('common.team_name_placeholder') }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="updateTeam()">
                    <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#teamsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                language: {
                    search: "{{ __('common.datatable_search') }}",
                    lengthMenu: "{{ __('common.datatable_length_menu') }}",
                    info: "{{ __('common.datatable_info') }}",
                    paginate: {
                        next: "{{ __('common.datatable_next') }}",
                        previous: "{{ __('common.datatable_previous') }}"
                    }
                }
            });
        });

        function editTeam(id, name) {
            $('#editId').val(id);
            $('#editName').val(name);
        }

        function createTeam() {
            $.ajax({
                url: '{{ route('admin.teams.create') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#name').val()
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
                error: function() {
                    Swal.fire({
                        title: '{{ __('common.error') }}',
                        text: '{{ __('common.error_occurred') }}',
                        icon: 'error'
                    });
                }
            });
        }

        function updateTeam() {
            const id = $('#editId').val();
            $.ajax({
                url: '{{ route('admin.teams.edit', '') }}/' + id,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#editName').val()
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
                error: function() {
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
