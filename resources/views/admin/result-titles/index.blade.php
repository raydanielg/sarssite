@extends('admin.layouts.admin')

@section('title', 'Result Categories')
@section('page_title', 'Examination Categories')

@section('content')
<div class="card card-outline card-success shadow border-0 rounded-lg overflow-hidden">
    <div class="card-header bg-gradient-success text-white py-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-clipboard-list mr-2"></i> Examination Categories
        </h3>
        <div class="card-tools">
            <button id="bulk-delete-btn" class="btn btn-sm btn-light text-danger font-weight-bold mr-2" style="display:none;">
                <i class="fas fa-trash"></i> Delete (<span id="selected-count">0</span>)
            </button>
            <a href="{{ route('admin.result-titles.create') }}" class="btn btn-sm btn-light text-success font-weight-bold">
                <i class="fas fa-plus-circle"></i> Add Category
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 40px">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="check-all">
                            <label for="check-all" class="custom-control-label"></label>
                        </div>
                    </th>
                    <th class="font-weight-bold">Exam Name</th>
                    <th class="font-weight-bold" style="width: 80px">Year</th>
                    <th class="font-weight-bold" style="width: 120px">Level</th>
                    <th class="font-weight-bold" style="width: 120px">Mkoa</th>
                    <th class="font-weight-bold" style="width: 120px">Wilaya</th>
                    <th class="font-weight-bold text-center" style="width: 80px">Results</th>
                    <th class="font-weight-bold" style="width: 120px">Actions</th>
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
                        <td>
                            <div class="font-weight-bold text-dark">{{ $title->name }}</div>
                            @if($title->resultType)
                                <span class="badge badge-secondary badge-pill mt-1"><i class="fas fa-tag mr-1"></i>{{ $title->resultType->name }}</span>
                            @endif
                        </td>
                        <td><span class="badge badge-info badge-pill px-2 py-1"><i class="fas fa-calendar mr-1"></i>{{ $title->year->year }}</span></td>
                        <td><span class="badge badge-success badge-pill px-2 py-1"><i class="fas fa-graduation-cap mr-1"></i>{{ $title->level->name }}</span></td>
                        <td>
                            @if($title->region)
                                <span class="badge badge-primary badge-pill px-2 py-1"><i class="fas fa-globe-africa mr-1"></i>{{ $title->region->name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($title->district)
                                <span class="badge badge-warning badge-pill px-2 py-1"><i class="fas fa-map-pin mr-1"></i>{{ $title->district->name }}</span>
                            @else
                                <span class="text-muted small font-italic">Mkoa mzima</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-light border px-2 py-1 font-weight-bold {{ $title->results_count > 0 ? 'text-primary' : 'text-muted' }}">{{ $title->results_count }}</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.result-titles.edit', $title) }}" class="btn btn-xs btn-outline-primary rounded-pill">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.result-titles.destroy', $title) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-outline-danger rounded-pill" data-confirm-delete data-confirm-title="Delete Category?" data-confirm-text="Deleting this category will also delete ALL results uploaded under it!">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
                            <p class="font-weight-bold">Hakuna examination categories zilizowekwa.</p>
                            <a href="{{ route('admin.result-titles.create') }}" class="btn btn-success btn-sm rounded-pill px-4">
                                <i class="fas fa-plus-circle mr-1"></i> Ongeza Category
                            </a>
                        </td>
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
