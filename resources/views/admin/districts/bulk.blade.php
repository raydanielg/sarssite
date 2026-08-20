@extends('admin.layouts.admin')

@section('title', 'Bulk Add Districts')
@section('page_title', 'Bulk Add Districts (Wilaya)')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header bg-white">
        <h3 class="card-title font-weight-bold">Bulk Add Districts by Region</h3>
        <div class="card-tools">
            <a href="{{ route('admin.districts.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.districts.bulk-store') }}" method="POST" id="bulkForm">
        @csrf
        <div class="card-body">
            <div class="row">
                <!-- Left: Region Selection + JSON Import -->
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="region_id">Select Region</label>
                        <select name="region_id" id="region_id" class="form-control" required>
                            <option value="">-- Select Region --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Chagua mkoa unataka kuongeza wilaya zake.</small>
                    </div>

                    @if(!empty($tanzaniaData) && isset($tanzaniaData['regions']))
                        <div class="form-group">
                            <label>Import from Tanzania Data (JSON)</label>
                            <div class="border rounded p-3 bg-light" style="max-height:400px;overflow-y:auto;">
                                @foreach($tanzaniaData['regions'] as $data)
                                    @php
                                        $matchedRegion = null;
                                        foreach($regions as $r) {
                                            if (stripos($r->name, $data['name']) !== false || stripos($data['name'], $r->name) !== false) {
                                                $matchedRegion = $r;
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if($matchedRegion)
                                        <button type="button" class="btn btn-sm btn-outline-success w-100 mb-2 text-left json-import-btn"
                                                data-region-id="{{ $matchedRegion->id }}"
                                                data-districts='{{ json_encode($data["districts"]) }}'>
                                            <i class="fas fa-download mr-1"></i> {{ $data['name'] }}
                                            <span class="badge badge-light ml-2">{{ count($data['districts']) }} wilaya</span>
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                            <small class="text-muted">Bonyeza mkoa kujaza wilaya zake moja kwa moja.</small>
                        </div>
                    @endif
                </div>

                <!-- Right: District Input -->
                <div class="col-md-7">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="mb-0">Districts to Add</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" id="addRowBtn">
                                <i class="fas fa-plus"></i> Add Row
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" id="clearRowsBtn">
                                <i class="fas fa-eraser"></i> Clear All
                            </button>
                        </div>
                    </div>

                    <div id="districtRows" class="border rounded p-3 bg-white" style="min-height:300px;max-height:500px;overflow-y:auto;">
                        <div class="district-row d-flex align-items-center mb-2">
                            <input type="text" name="districts[]" class="form-control form-control-sm district-input" placeholder="Wilaya name...">
                            <button type="button" class="btn btn-sm btn-outline-danger ml-2 remove-row-btn" style="min-width:38px;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Total: <strong id="rowCount">1</strong> wilaya</span>
                        <button type="submit" class="btn btn-success px-5 shadow-sm">
                            <i class="fas fa-save"></i> Save All Districts
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('js')
<script>
$(document).ready(function() {
    const rowsContainer = $('#districtRows');
    const rowCountSpan = $('#rowCount');

    function updateRowCount() {
        rowCountSpan.text($('.district-row').length);
    }

    function addRow(value) {
        const row = $(`
            <div class="district-row d-flex align-items-center mb-2">
                <input type="text" name="districts[]" class="form-control form-control-sm district-input" placeholder="Wilaya name..." value="${value || ''}">
                <button type="button" class="btn btn-sm btn-outline-danger ml-2 remove-row-btn" style="min-width:38px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `);
        rowsContainer.append(row);
        updateRowCount();
    }

    $('#addRowBtn').on('click', function() {
        addRow();
    });

    $(document).on('click', '.remove-row-btn', function() {
        if ($('.district-row').length > 1) {
            $(this).closest('.district-row').remove();
            updateRowCount();
        }
    });

    $('#clearRowsBtn').on('click', function() {
        rowsContainer.empty();
        addRow();
        updateRowCount();
    });

    // JSON Import
    $('.json-import-btn').on('click', function() {
        const regionId = $(this).data('region-id');
        const districts = $(this).data('districts');

        $('#region_id').val(regionId);
        rowsContainer.empty();

        districts.forEach(function(name) {
            addRow(name);
        });

        if ($('.district-row').length === 0) {
            addRow();
        }
        updateRowCount();

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: `${districts.length} wilaya zimejazwa`,
            showConfirmButton: false,
            timer: 2000
        });
    });

    // Form submit
    $('#bulkForm').on('submit', function(e) {
        const filled = $('.district-input').filter(function() { return $(this).val().trim() !== ''; }).length;
        if (filled === 0) {
            e.preventDefault();
            Swal.fire('Error', 'Tafadhali jaza angalau wilaya moja.', 'error');
            return;
        }
        // Remove empty rows
        $('.district-input').each(function() {
            if ($(this).val().trim() === '') {
                $(this).closest('.district-row').remove();
            }
        });
    });
});
</script>
@endpush
@endsection
