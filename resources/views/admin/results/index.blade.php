@extends('admin.layouts.admin')

@section('title', 'Manage Results')
@section('page_title', 'Results Management')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle mr-3 fa-lg"></i>
                    <div>
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('warning_list'))
            <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" role="alert">
                <h5><i class="icon fas fa-exclamation-triangle mr-2"></i> Some files were not uploaded:</h5>
                <ul class="mb-0 mt-2 pl-4">
                    @foreach(session('warning_list') as $warning)
                        <li>{{ $warning }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm rounded overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="row align-items-center">
            <div class="col-md-4 col-12 mb-2 mb-md-0">
                <h3 class="card-title font-weight-bold text-dark mb-0 d-inline-block float-none">
                    <i class="fas fa-file-invoice mr-2 text-success"></i> All Results
                </h3>
            </div>
            <div class="col-md-8 col-12 text-center text-md-right">
                <div class="d-flex flex-column flex-sm-row justify-content-md-end align-items-center gap-2">
                    <!-- Bulk Actions Dropdown -->
                    <div class="btn-group shadow-sm mb-2 mb-sm-0 mr-sm-2" id="bulkActionsGroup" style="display:none;">
                        <button type="button" class="btn btn-warning btn-sm px-3 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-tasks mr-1"></i> Bulk Actions (<span id="selectedCount">0</span>)
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                            <button class="dropdown-item text-success font-weight-bold" id="bulkPublishBtn">
                                <i class="fas fa-globe mr-2"></i> Publish Selected
                            </button>
                            <button class="dropdown-item text-warning font-weight-bold" id="bulkDraftBtn">
                                <i class="fas fa-lock mr-2"></i> Make Draft (Private)
                            </button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item text-danger font-weight-bold" id="bulkDeleteBtn">
                                <i class="fas fa-trash-alt mr-2"></i> Delete Selected
                            </button>
                        </div>
                    </div>

                    <!-- Search Input -->
                    <div class="input-group input-group-sm mr-sm-3 mb-2 mb-sm-0" style="max-width: 250px;">
                        <input type="text" id="resultSearch" class="form-control" placeholder="Search school name/code...">
                        <div class="input-group-append">
                            <span class="input-group-text bg-light border-left-0"><i class="fas fa-search text-muted"></i></span>
                        </div>
                    </div>
                    
                    <!-- Limit Selector -->
                    <select id="resultLimit" class="form-control form-control-sm mr-sm-3 mb-2 mb-sm-0 shadow-sm" style="width: auto;">
                        <option value="10" {{ $limit == 10 ? 'selected' : '' }}>Show 10</option>
                        <option value="50" {{ $limit == 50 ? 'selected' : '' }}>Show 50</option>
                        <option value="all" {{ $limit == 'all' ? 'selected' : '' }}>Show All</option>
                    </select>

                    <a href="{{ route('admin.results.bulk-upload-form') }}" class="btn btn-primary btn-sm px-4 shadow-sm mb-2 mb-sm-0 mr-sm-2">
                        <i class="fas fa-layer-group mr-1 small"></i> Bulk Upload
                    </a>
                    <!-- Upload Single Dropdown -->
                    <div class="dropdown mb-2 mb-sm-0">
                        <button class="btn btn-success btn-sm px-4 shadow-sm dropdown-toggle" type="button" id="singleUploadDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-plus-circle mr-1 small"></i> Upload Single
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 rounded-lg" aria-labelledby="singleUploadDropdown">
                            <a class="dropdown-item py-2" href="{{ route('admin.results.create') }}">
                                <i class="fas fa-school text-success mr-2"></i> Shule ya Kawaida
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2" href="{{ route('admin.results.pc-create') }}">
                                <i class="fas fa-user-graduate text-warning mr-2"></i> Private Candidate (PC)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="px-4 pt-3 pb-2 border-bottom bg-light">
            <ul class="nav nav-pills nav-sm" id="resultTypeTabs">
                <li class="nav-item">
                    <a class="nav-link py-1 px-3 {{ !request()->has('type') ? 'active' : '' }}" href="{{ route('admin.results.index') }}">
                        <i class="fas fa-th-list mr-1"></i> Zote
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-1 px-3 {{ request('type') === 'school' ? 'active' : '' }}" href="{{ route('admin.results.index', ['type' => 'school']) }}">
                        <i class="fas fa-school mr-1"></i> Shule
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-1 px-3 {{ request('type') === 'pc' ? 'active' : '' }}" href="{{ route('admin.results.index', ['type' => 'pc']) }}">
                        <i class="fas fa-user-graduate mr-1"></i> Private Candidates
                    </a>
                </li>
            </ul>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="resultsTable">
                <thead class="bg-light text-muted small text-uppercase font-weight-bold">
                    <tr>
                        <th class="px-4 py-3 border-0" style="width: 40px;">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="checkAll">
                                <label for="checkAll" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="py-3 border-0">Result Details</th>
                        <th class="py-3 border-0 text-center">Year & Level</th>
                        <th class="py-3 border-0 px-4">School</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="py-3 border-0 text-right px-4">Action</th>
                    </tr>
                </thead>
                <tbody id="resultsTableBody">
                    @include('admin.results.partials.table')
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-white { background: #fff; color: #444; border: 1px solid #dee2e6; }
    .btn-white:hover { background: #f8f9fa; border-color: #c1c9d0; }
    .badge-info-soft { background-color: #e3f2fd; color: #0277bd; font-size: 10px; font-weight: bold; }
    
    @keyframes blink {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
    
    .blink-new {
        animation: blink 1s infinite;
        box-shadow: 0 0 8px rgba(220, 53, 69, 0.4);
    }
    
    .gap-2 { gap: 0.5rem; }
    .font-weight-black { font-weight: 900 !important; }
    
    .dropdown-item {
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.15s;
    }
    .dropdown-item:hover {
        background: #f0f4ff;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .card-header .btn, .card-header select { width: 100%; }
        .input-group { width: 100% !important; max-width: none !important; }
    }
</style>

@push('js')
<script>
$(document).ready(function() {
    let searchTimer;
    const searchInput = $('#resultSearch');
    const limitSelect = $('#resultLimit');
    const tableBody = $('#resultsTableBody');

    function fetchResults(page = 1) {
        const query = searchInput.val();
        const limit = limitSelect.val();
        const url = "{{ route('admin.results.index') }}";

        tableBody.css('opacity', '0.5');

        $.ajax({
            url: url,
            data: {
                search: query,
                limit: limit,
                page: page
            },
            success: function(html) {
                tableBody.html(html);
                tableBody.css('opacity', '1');
            },
            error: function() {
                tableBody.css('opacity', '1');
                alert('Error fetching results. Please try again.');
            }
        });
    }

    // Search event
    searchInput.on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            fetchResults(1);
        }, 500);
    });

    // Limit change event
    limitSelect.on('change', function() {
        fetchResults(1);
    });

    // Pagination click event
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const page = new URL(url).searchParams.get('page');
        fetchResults(page);
    });

    // SweetAlert for Delete
    $(document).on('submit', '.delete-result-form', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Bulk Actions Logic
    const bulkActionsGroup = $('#bulkActionsGroup');
    const selectedCountSpan = $('#selectedCount');
    const checkAll = $('#checkAll');

    function updateBulkUI() {
        const checkedCount = $('.item-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkActionsGroup.fadeIn();
            selectedCountSpan.text(checkedCount);
        } else {
            bulkActionsGroup.fadeOut();
        }
    }

    function getSelectedIds() {
        return $('.item-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
    }

    $(document).on('change', '#checkAll', function() {
        $('.item-checkbox').prop('checked', $(this).is(':checked'));
        updateBulkUI();
    });

    $(document).on('change', '.item-checkbox', function() {
        const allChecked = $('.item-checkbox').length === $('.item-checkbox:checked').length;
        $('#checkAll').prop('checked', allChecked);
        updateBulkUI();
    });

    // Bulk Status Change
    function bulkStatusChange(status) {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        const label = status === 'Published' ? 'kupublish' : 'kufanya Draft';

        Swal.fire({
            title: 'Una uhakika?',
            text: `Unataka ${label} matokeo ${ids.length} yaliyochaguliwa?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ndio, endelea',
            cancelButtonText: 'Hapana',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.results.bulk-status') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids,
                        status: status
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Inabadilisha status...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Imefanyika!', response.message, 'success').then(() => {
                                fetchResults(1);
                                $('#checkAll').prop('checked', false);
                                bulkActionsGroup.fadeOut();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Hitilafu imetokea.', 'error');
                    }
                });
            }
        });
    }

    $('#bulkPublishBtn').on('click', function() { bulkStatusChange('Published'); });
    $('#bulkDraftBtn').on('click', function() { bulkStatusChange('Draft'); });

    // Bulk Delete
    $('#bulkDeleteBtn').on('click', function() {
        const ids = getSelectedIds();

        if (ids.length === 0) return;

        Swal.fire({
            title: 'Una uhakika?',
            text: `Unataka kufuta matokeo ${ids.length} yaliyochaguliwa? Kitendo hiki hakiwezi kurudishwa!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ndio, futa yote',
            cancelButtonText: 'Hapana',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.results.bulk-delete') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Inafuta...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Imefutwa!', response.message, 'success').then(() => {
                                fetchResults(1);
                                $('#checkAll').prop('checked', false);
                                bulkActionsGroup.fadeOut();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Hitilafu imetokea wakati wa kufuta.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
@endsection


