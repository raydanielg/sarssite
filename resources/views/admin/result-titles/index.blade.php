@extends('admin.layouts.admin')

@section('title', 'Result Categories')
@section('page_title', 'Result Categories (Titles)')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Result Categories</h3>
        <div class="card-tools">
            <button id="bulk-delete-btn" class="btn btn-sm btn-danger mr-2" style="display:none;">
                <i class="fas fa-trash"></i> Delete Selected (<span id="selected-count">0</span>)
            </button>
            <a href="{{ route('admin.result-titles.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th style="width: 40px">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="check-all">
                            <label for="check-all" class="custom-control-label"></label>
                        </div>
                    </th>
                    <th>Title Name</th>
                    <th>Year</th>
                    <th>Level</th>
                    <th>Region</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultTitles as $title)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input item-checkbox" type="checkbox" id="check-{{ $title->id }}" value="{{ $title->id }}">
                                <label for="check-{{ $title->id }}" class="custom-control-label"></label>
                            </div>
                        </td>
                        <td>{{ $title->name }}</td>
                        <td>{{ $title->year->year }}</td>
                        <td><span class="badge badge-info">{{ $title->level->name }}</span></td>
                        <td>{{ $title->region->name }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.result-titles.edit', $title) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.result-titles.destroy', $title) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete Category?" data-confirm-text="Deleting this category will also delete ALL results uploaded under it!">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted p-4">No result categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($resultTitles->hasPages())
        <div class="card-footer clearfix">
            {{ $resultTitles->links() }}
        </div>
    @endif
</div>
@endsection

@push('js')
<script>
    $(function() {
        const checkAll = $('#check-all');
        const itemCheckboxes = $('.item-checkbox');
        const bulkDeleteBtn = $('#bulk-delete-btn');
        const selectedCountSpan = $('#selected-count');

        function updateBulkDeleteButton() {
            const checkedCount = $('.item-checkbox:checked').length;
            if (checkedCount > 0) {
                bulkDeleteBtn.fadeIn();
                selectedCountSpan.text(checkedCount);
            } else {
                bulkDeleteBtn.fadeOut();
            }
        }

        checkAll.on('change', function() {
            itemCheckboxes.prop('checked', $(this).is(':checked'));
            updateBulkDeleteButton();
        });

        itemCheckboxes.on('change', function() {
            const allChecked = itemCheckboxes.length === $('.item-checkbox:checked').length;
            checkAll.prop('checked', allChecked);
            updateBulkDeleteButton();
        });

        bulkDeleteBtn.on('click', function() {
            const ids = $('.item-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) return;

            Swal.fire({
                title: 'Una uhakika?',
                text: `Unataka kufuta item ${ids.length} zilizochaguliwa? Kitendo hiki hakiwezi kurudishwa!`,
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
                        url: "{{ route('admin.result-titles.bulk-delete') }}",
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
                                    location.reload();
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
