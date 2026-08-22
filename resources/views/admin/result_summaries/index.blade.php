@extends('admin.layouts.admin')

@section('title', 'Manage Result Summaries')
@section('page_title', 'Result Summaries')

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
    </div>
</div>

<div class="card border-0 shadow-sm rounded overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="row align-items-center">
            <div class="col-md-4 col-12 mb-2 mb-md-0">
                <h3 class="card-title font-weight-bold text-dark mb-0 d-inline-block float-none">
                    <i class="fas fa-file-alt mr-2 text-primary"></i> Result Summaries
                </h3>
            </div>
            <div class="col-md-8 col-12 text-center text-md-right">
                <div class="d-flex flex-column flex-sm-row justify-content-md-end align-items-center gap-2">
                    <!-- Bulk Delete Button -->
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm px-4 shadow-sm mb-2 mb-sm-0 mr-sm-2" style="display:none;">
                        <i class="fas fa-trash-alt mr-1"></i> Delete Selected (<span id="selectedCount">0</span>)
                    </button>

                    <div class="input-group input-group-sm mr-sm-3 mb-2 mb-sm-0" style="max-width: 250px;">
                        <input type="text" id="summarySearch" class="form-control" placeholder="Search summaries...">
                        <div class="input-group-append">
                            <span class="input-group-text bg-light border-left-0"><i class="fas fa-search text-muted"></i></span>
                        </div>
                    </div>
                    
                    <select id="summaryLimit" class="form-control form-control-sm mr-sm-3 mb-2 mb-sm-0 shadow-sm" style="width: auto;">
                        <option value="10" {{ $limit == 10 ? 'selected' : '' }}>Show 10</option>
                        <option value="50" {{ $limit == 50 ? 'selected' : '' }}>Show 50</option>
                        <option value="all" {{ $limit == 'all' ? 'selected' : '' }}>Show All</option>
                    </select>

                    <a href="{{ route('admin.result-summaries.bulk-upload-form') }}" class="btn btn-primary btn-sm px-4 shadow-sm mb-2 mb-sm-0 mr-sm-2">
                        <i class="fas fa-layer-group mr-1 small"></i> Bulk Upload
                    </a>
                    <a href="{{ route('admin.result-summaries.create') }}" class="btn btn-success btn-sm px-4 shadow-sm">
                        <i class="fas fa-upload mr-1 small"></i> Upload Single
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light text-muted small text-uppercase font-weight-bold">
                    <tr>
                        <th class="px-4 py-3 border-0" style="width: 40px;">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="checkAll">
                                <label for="checkAll" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="px-4 py-3 border-0">Summary Name</th>
                        <th class="py-3 border-0 px-4">Examination</th>
                        <th class="py-3 border-0">Level</th>
                        <th class="py-3 border-0">Status</th>
                        <th class="py-3 border-0 text-right px-4">Action</th>
                    </tr>
                </thead>
                <tbody id="summariesTableBody">
                    @include('admin.result_summaries.partials.table')
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-white { background: #fff; color: #444; border: 1px solid #dee2e6; }
    .btn-white:hover { background: #f8f9fa; border-color: #c1c9d0; }
    
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
    
    @media (max-width: 767.98px) {
        .card-header .btn, .card-header select { width: 100%; }
        .input-group { width: 100% !important; max-width: none !important; }
    }
</style>

@push('js')
<script>
$(document).ready(function() {
    let searchTimer;
    const searchInput = $('#summarySearch');
    const limitSelect = $('#summaryLimit');
    const tableBody = $('#summariesTableBody');

    function fetchSummaries(page = 1) {
        const query = searchInput.val();
        const limit = limitSelect.val();
        const url = "{{ route('admin.result-summaries.index') }}";
        const params = new URLSearchParams();
        params.set('search', query);
        params.set('limit', limit);
        params.set('page', page);
        const typeParam = new URLSearchParams(window.location.search).get('type');
        if (typeParam) params.set('type', typeParam);

        tableBody.css('opacity', '0.5');

        $.ajax({
            url: url,
            data: params.toString(),
            success: function(html) {
                tableBody.html(html);
                tableBody.css('opacity', '1');
            }
        });
    }

    searchInput.on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => fetchSummaries(1), 500);
    });

    limitSelect.on('change', function() {
        fetchSummaries(1);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const page = new URL(url).searchParams.get('page');
        fetchSummaries(page);
    });

    $(document).on('submit', '.delete-summary-form', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete this result summary?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });

    // Bulk Delete Logic
    const bulkDeleteBtn = $('#bulkDeleteBtn');
    const selectedCountSpan = $('#selectedCount');

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
            text: `Unataka kufuta summaries ${ids.length} zilizochaguliwa? Kitendo hiki hakiwezi kurudishwa!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ndio, futa zote',
            cancelButtonText: 'Hapana',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.result-summaries.bulk-delete') }}",
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
                                fetchSummaries(1);
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
