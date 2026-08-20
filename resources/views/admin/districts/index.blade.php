@extends('admin.layouts.admin')

@section('title', 'Manage Districts (Wilaya)')
@section('page_title', 'Districts Management')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm rounded overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="row align-items-center">
            <div class="col-md-4 col-12 mb-2 mb-md-0">
                <h3 class="card-title font-weight-bold text-dark mb-0">
                    All Districts
                </h3>
            </div>
            <div class="col-md-8 col-12 text-center text-md-right">
                <div class="d-flex flex-column flex-sm-row justify-content-md-end align-items-center gap-2">
                    <form method="GET" action="{{ route('admin.districts.index') }}" class="d-flex align-items-center gap-2 mb-2 mb-sm-0">
                        <select name="region_id" class="form-control form-control-sm shadow-sm" onchange="this.form.submit()">
                            <option value="">All Regions</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm shadow-sm" placeholder="Search..." style="max-width:150px;">
                        <button type="submit" class="btn btn-sm btn-primary shadow-sm">Filter</button>
                    </form>

                    <a href="{{ route('admin.districts.bulk-create-form') }}" class="btn btn-warning btn-sm px-4 shadow-sm mb-2 mb-sm-0 mr-sm-2">
                        Bulk Add Districts
                    </a>
                    <a href="{{ route('admin.districts.create') }}" class="btn btn-success btn-sm px-4 shadow-sm">
                        Add Single District
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
                        <th class="px-4 py-3 border-0" style="width:40px;">
                            <input type="checkbox" id="checkAll">
                        </th>
                        <th class="py-3 border-0">District Name</th>
                        <th class="py-3 border-0">Region</th>
                        <th class="py-3 border-0">Slug</th>
                        <th class="py-3 border-0 text-right px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($districts as $district)
                        <tr>
                            <td class="px-4 py-3">
                                <input type="checkbox" class="item-checkbox" value="{{ $district->id }}">
                            </td>
                            <td class="py-3 font-weight-bold text-dark">{{ $district->name }}</td>
                            <td class="py-3">{{ $district->region->name }}</td>
                            <td class="py-3"><code class="small bg-light px-1 rounded">{{ $district->slug }}</code></td>
                            <td class="text-right px-4 py-3">
                                <div class="btn-group shadow-sm border rounded overflow-hidden">
                                    <a href="{{ route('admin.districts.edit', $district) }}" class="btn btn-white btn-sm" title="Edit">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.districts.destroy', $district) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm border-left" title="Delete">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No districts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <button id="bulkDeleteBtn" class="btn btn-danger btn-sm shadow-sm" style="display:none;">
                Delete Selected (<span id="selectedCount">0</span>)
            </button>
            {{ $districts->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    $('#checkAll').on('change', function() {
        $('.item-checkbox').prop('checked', $(this).is(':checked'));
        updateBulkUI();
    });

    $(document).on('change', '.item-checkbox', function() {
        const all = $('.item-checkbox').length === $('.item-checkbox:checked').length;
        $('#checkAll').prop('checked', all);
        updateBulkUI();
    });

    function updateBulkUI() {
        const count = $('.item-checkbox:checked').length;
        if (count > 0) {
            $('#bulkDeleteBtn').fadeIn();
            $('#selectedCount').text(count);
        } else {
            $('#bulkDeleteBtn').fadeOut();
        }
    }

    $('#bulkDeleteBtn').on('click', function() {
        const ids = $('.item-checkbox:checked').map(function() { return $(this).val(); }).get();
        if (ids.length === 0) return;

        Swal.fire({
            title: 'Una uhakika?',
            text: `Unataka kufuta wilaya ${ids.length} zilizochaguliwa?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ndio, futa',
            cancelButtonText: 'Hapana'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.districts.bulk-delete') }}",
                    method: "POST",
                    data: { _token: "{{ csrf_token() }}", ids: ids },
                    success: function(response) {
                        Swal.fire('Imefutwa!', response.message, 'success').then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'Hitilafu imetokea.', 'error');
                    }
                });
            }
        });
    });

    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Una uhakika?',
            text: "Huwezi kurudisha kitendo hiki!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ndio, futa',
            cancelButtonText: 'Hapana'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
@endsection
