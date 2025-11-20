@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .post-contents-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header-card {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
            color: white;
        }
        .post-contents-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            padding: 1.5rem;
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
        .btn-go {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-go:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4);
            color: white;
        }
        .content-type-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #374151;
        }
        .content-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            color: white;
        }
        .icon-pole {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        .icon-winner {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .icon-podium {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        .icon-standings {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }
    </style>
@endsection
@section('content')
<div class="post-contents-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-photo-video me-2"></i>{{ __('common.ready_posts') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.ready_posts_desc') }}
            </p>
        </div>

        <!-- Post Contents Table -->
        <div class="post-contents-table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2"></i>{{ __('common.post_templates') }}
                </h5>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table id="basic-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>ID</th>
                            <th><i class="fas fa-tag me-1"></i>{{ __('common.template_name') }}</th>
                            <th><i class="fas fa-cog me-1"></i>{{ __('common.template_action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="content-type-badge">
                                    <div class="content-icon icon-pole">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                    <span>Pole</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.postContents.pole') }}" class="btn-go">
                                    <i class="fas fa-arrow-right"></i>{{ __('common.go') }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <div class="content-type-badge">
                                    <div class="content-icon icon-winner">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <span>{{ __('common.winner') }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.postContents.pole') }}" class="btn-go">
                                    <i class="fas fa-arrow-right"></i>{{ __('common.go') }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <div class="content-type-badge">
                                    <div class="content-icon icon-podium">
                                        <i class="fas fa-medal"></i>
                                    </div>
                                    <span>Podyum</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.postContents.podium') }}" class="btn-go">
                                    <i class="fas fa-arrow-right"></i>{{ __('common.go') }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>
                                <div class="content-type-badge">
                                    <div class="content-icon icon-standings">
                                        <i class="fas fa-table"></i>
                                    </div>
                                    <span>{{ __('common.point_table_short') }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.postContents.podium') }}" class="btn-go">
                                    <i class="fas fa-arrow-right"></i>{{ __('common.go') }}
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#basic-table').DataTable({
                paging: false,
                searching: false,
                ordering: true,
                lengthChange: false,
                info: false,
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
    </script>
@endsection
