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
                    <!-- Bulk Delete Button -->
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm px-4 shadow-sm mb-2 mb-sm-0 mr-sm-2" style="display:none;">
                        <i class="fas fa-trash-alt mr-1"></i> Delete Selected (<span id="selectedCount">0</span>)
                    </button>

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
                    <a href="{{ route('admin.results.create') }}" class="btn btn-success btn-sm px-4 shadow-sm">
                        <i class="fas fa-plus-circle mr-1 small"></i> Upload Single
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
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

    // Bulk Delete Logic
    const bulkDeleteBtn = $('#bulkDeleteBtn');
    const selectedCountSpan = $('#selectedCount');
    const checkAll = $('#checkAll');

    function updateBulkDeleteUI() {
        const checkedCount = $('.item-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkDeleteBtn.fadeIn();
            selectedCountSpan.text(checkedCount);
        } else {
            bulkDeleteBtn.fadeOut();
        }
    }

    $(document).on('change', '#checkAll', function() {
        $('.item-checkbox').prop('checked', $(this).is(':checked'));
        updateBulkDeleteUI();
    });

    $(document).on('change', '.item-checkbox', function() {
        const allChecked = $('.item-checkbox').length === $('.item-checkbox:checked').length;
        $('#checkAll').prop('checked', allChecked);
        updateBulkDeleteUI();
    });

    bulkDeleteBtn.on('click', function() {
        const ids = $('.item-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

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
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Imefutwa!', response.message, 'success').then(() => {
                                fetchResults(1);
                                $('#checkAll').prop('checked', false);
                                bulkDeleteBtn.fadeOut();
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


