@extends('admin.layouts.admin')

@section('title', 'Add Result Category')
@section('page_title', 'Create Result Category')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">Category Details</h3>
        <div class="card-tools">
            <a href="{{ route('admin.result-titles.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.result-titles.store') }}" method="POST" id="titleForm">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Category Title Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Form Four Results 2026" required autofocus>
                <small class="text-muted">This name will appear in the public results list. It will be created for each selected region/district.</small>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="year_id">Year</label>
                        <select name="year_id" id="year_id" class="form-control" required>
                            <option value="">-- Select Year --</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}" {{ old('year_id') == $year->id ? 'selected' : '' }}>{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="level_id">Level</label>
                        <select name="level_id" id="level_id" class="form-control" required>
                            <option value="">-- Select Level --</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="result_type_id">Result Type (Optional)</label>
                        <select name="result_type_id" id="result_type_id" class="form-control">
                            <option value="">-- None --</option>
                            @if(isset($resultTypes))
                                @foreach($resultTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('result_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            <h5 class="font-weight-bold mb-3">Select Regions & Districts</h5>
            <small class="text-muted d-block mb-3">Chagua mkoa/mikoa. Kwa kila mkoa, unaweza kuchagua wilaya zake au uache bila wilaya (itaumbwa kwa mkoa mzima).</small>

            <div class="row">
                @foreach($regions as $region)
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="border rounded p-3 region-card">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input region-checkbox" name="region_ids[]" value="{{ $region->id }}" id="region-{{ $region->id }}">
                                <label class="custom-control-label font-weight-bold" for="region-{{ $region->id }}">{{ $region->name }}</label>
                            </div>
                            <div class="district-list mt-2 pl-4" id="districts-{{ $region->id }}" style="display:none;max-height:200px;overflow-y:auto;">
                                <small class="text-muted d-block mb-1">Wilaya (leave unchecked for entire region):</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save Category
            </button>
        </div>
    </form>
</div>

@push('js')
<script>
$(document).ready(function() {
    $('.region-checkbox').on('change', function() {
        const regionId = $(this).val();
        const districtBox = $('#districts-' + regionId);

        if ($(this).is(':checked')) {
            districtBox.show();
            if (districtBox.find('.district-checkbox').length === 0) {
                districtBox.append('<small class="text-muted loading-msg">Loading...</small>');
                $.getJSON('{{ route("admin.districts.by-region", ":id") }}'.replace(':id', regionId), function(data) {
                    districtBox.find('.loading-msg').remove();
                    if (data.length === 0) {
                        districtBox.append('<small class="text-muted">No districts found for this region.</small>');
                    } else {
                        data.forEach(function(d) {
                            districtBox.append(`
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input district-checkbox" name="district_ids_${regionId}[]" value="${d.id}" id="dist-${d.id}">
                                    <label class="custom-control-label" for="dist-${d.id}">${d.name}</label>
                                </div>
                            `);
                        });
                    }
                }).fail(function() {
                    districtBox.find('.loading-msg').remove();
                    districtBox.append('<small class="text-danger">Failed to load districts.</small>');
                });
            }
        } else {
            districtBox.hide();
        }
    });

    $('#titleForm').on('submit', function(e) {
        const checkedRegions = $('.region-checkbox:checked').length;
        if (checkedRegions === 0) {
            e.preventDefault();
            Swal.fire('Error', 'Tafadhali chagua angalau mkoa mmoja.', 'error');
        }
    });
});
</script>
@endpush
@endsection
