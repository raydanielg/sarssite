@extends('admin.layouts.admin')

@section('title', 'Schools')
@section('page_title', 'Schools')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header border-0">
        <h3 class="card-title">All Schools</h3>
        <div class="card-tools flex items-center gap-2">
            <button type="button" class="btn btn-sm btn-secondary" id="resetAllPcBtn" title="Weka shule zote kuwa Normal (zisizo PC)">
                <i class="fas fa-check-double"></i> Set ALL to Normal
            </button>
            <button type="button" class="btn btn-sm btn-info" id="markNormalBtn">
                <i class="fas fa-user-check"></i> Mark Selected as Normal
            </button>
            <button type="button" class="btn btn-sm btn-warning" id="markPcBtn">
                <i class="fas fa-user-secret"></i> Mark Selected as PC
            </button>
            <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <div class="input-group input-group-sm" style="width: 250px;">
                <input type="text" id="schoolSearch" class="form-control" placeholder="Search school name or code...">
                <div class="input-group-append">
                    <button class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('admin.schools.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add School
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div id="schoolsTableContainer">
            <table class="table table-striped mb-0" id="schoolsTable">
                <thead>
                    <tr>
                        <th style="width: 40px"><input type="checkbox" id="selectAllSchools" title="Chagua zote"></th>
                        <th style="width: 80px">Code</th>
                        <th>Name</th>
                        <th>Region</th>
                        <th>Levels</th>
                        <th style="width: 180px">Actions</th>
                    </tr>
                </thead>
                <tbody id="schoolsTableBody">
                    @include('admin.schools.partials.table')
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix" id="paginationContainer">
        {{ $schools->links() }}
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    let searchTimer;
    const searchInput = $('#schoolSearch');
    const tableBody = $('#schoolsTableBody');
    const paginationContainer = $('#paginationContainer');

    searchInput.on('keyup', function() {
        clearTimeout(searchTimer);
        const query = $(this).val();
        
        searchTimer = setTimeout(function() {
            fetchSchools(query);
        }, 500);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const query = searchInput.val();
        fetchSchools(query, url);
    });

    function fetchSchools(query, url = null) {
        const fetchUrl = url || "{{ route('admin.schools.index') }}";
        const data = url ? {} : { search: query };

        tableBody.css('opacity', '0.5');

        $.ajax({
            url: fetchUrl,
            data: data,
            success: function(html) {
                tableBody.html(html);
                tableBody.css('opacity', '1');
                $('#selectAllSchools').prop('checked', false);
            }
        });
    }

    $(document).on('change', '#selectAllSchools', function() {
        $('.school-checkbox').prop('checked', this.checked);
    });

    function getSelectedSchoolIds() {
        return $('.school-checkbox:checked').map(function() { return $(this).val(); }).get();
    }

    function sendBulkAction(actionType, data) {
        const ids = getSelectedSchoolIds();
        if (ids.length === 0) {
            alert('Tafadhali chagua angalau shule moja.');
            return;
        }

        if (actionType === 'delete' && !confirm('Una uhakika unataka kufuta shule zilizochaguliwa?')) {
            return;
        }

        const postData = Object.assign({ ids: ids }, data);
        const url = actionType === 'delete' ? "{{ route('admin.schools.bulk-delete') }}" : "{{ route('admin.schools.bulk-pc') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                fetchSchools(searchInput.val());
            },
            error: function(xhr) {
                const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Hitilafu imetokea.';
                alert(msg);
            }
        });
    }

    $('#markNormalBtn').on('click', function() {
        sendBulkAction('pc', { is_pc: 0 });
    });

    $('#markPcBtn').on('click', function() {
        sendBulkAction('pc', { is_pc: 1 });
    });

    $('#bulkDeleteBtn').on('click', function() {
        sendBulkAction('delete', {});
    });

    $('#resetAllPcBtn').on('click', function() {
        if (!confirm('Una uhakika? Hii itaweka shule ZOTE kuwa Normal, hata zile zilizo halali kuwa PC.')) {
            return;
        }

        $.ajax({
            url: "{{ route('admin.schools.reset-all-pc') }}",
            type: 'POST',
            data: JSON.stringify({}),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                fetchSchools(searchInput.val());
            },
            error: function(xhr) {
                const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Hitilafu imetokea.';
                alert(msg);
            }
        });
    });
});
</script>
@endpush

@endsection
