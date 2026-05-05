@extends('admin.layouts.admin')

@section('title', 'Schools')
@section('page_title', 'Schools')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header border-0">
        <h3 class="card-title">All Schools</h3>
        <div class="card-tools flex items-center gap-2">
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
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
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
                
                // Update pagination if needed (this depends on how the controller returns data)
                // For simplicity, we are just updating the table body via partial.
                // To update pagination too, we'd need to return both in a JSON or full partial.
            }
        });
    }
});
</script>
@endpush

@endsection
