@extends('admin.layouts.admin')

@section('title', 'Edit Result Category')
@section('page_title', 'Edit Category Details')

@section('content')
<div class="card card-outline card-primary shadow border-0 rounded-lg overflow-hidden">
    <div class="card-header bg-gradient-primary text-white py-3" style="background: linear-gradient(135deg, #6c5ce7 0%, #4834d4 100%);">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-edit mr-2"></i> Edit Category Details
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.result-titles.index') }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.result-titles.update', $resultTitle) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="form-group">
                <label for="name" class="font-weight-bold"><i class="fas fa-tag text-muted mr-1"></i> Category Title Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $resultTitle->name) }}" class="form-control form-control-lg shadow-sm @error('name') is-invalid @enderror" placeholder="e.g. Form Four Results 2026 - Arusha" required autofocus>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="year_id" class="font-weight-bold"><i class="fas fa-calendar text-muted mr-1"></i> Year <span class="text-danger">*</span></label>
                        <select name="year_id" id="year_id" class="form-control form-control-lg shadow-sm" required>
                            <option value="">-- Select --</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}" {{ old('year_id', $resultTitle->year_id) == $year->id ? 'selected' : '' }}>{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="level_id" class="font-weight-bold"><i class="fas fa-graduation-cap text-muted mr-1"></i> Level <span class="text-danger">*</span></label>
                        <select name="level_id" id="level_id" class="form-control form-control-lg shadow-sm" required>
                            <option value="">-- Select --</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id', $resultTitle->level_id) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="result_type_id" class="font-weight-bold"><i class="fas fa-layer-group text-muted mr-1"></i> Result Type</label>
                        <select name="result_type_id" id="result_type_id" class="form-control form-control-lg shadow-sm">
                            <option value="">-- None --</option>
                            @foreach($resultTypes as $type)
                                <option value="{{ $type->id }}" {{ old('result_type_id', $resultTitle->result_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr class="my-3">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="region_id" class="font-weight-bold"><i class="fas fa-globe-africa text-muted mr-1"></i> Mkoa (Region) <span class="text-danger">*</span></label>
                        <select name="region_id" id="region_id" class="form-control form-control-lg shadow-sm" required>
                            <option value="">-- Select Region --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id', $resultTitle->region_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Badilisha mkoa kama unahitaji.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="district_id" class="font-weight-bold"><i class="fas fa-map-pin text-muted mr-1"></i> Wilaya (District)</label>
                        <select name="district_id" id="district_id" class="form-control form-control-lg shadow-sm">
                            <option value="">-- Mkoa mzima (No District) --</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id', $resultTitle->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Acha bila kuchagua kwa mkoa mzima.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light text-right py-3 border-top">
            <a href="{{ route('admin.result-titles.index') }}" class="btn btn-default rounded-pill px-4 mr-2">
                <i class="fas fa-times mr-1"></i> Ghairi
            </a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                <i class="fas fa-save mr-1"></i> Update Category
            </button>
        </div>
    </form>
</div>

@push('js')
<script>
$(document).ready(function() {
    $('#region_id').on('change', function() {
        const regionId = $(this).val();
        const districtSelect = $('#district_id');
        if (!regionId) {
            districtSelect.empty().append('<option value="">-- Mkoa mzima (No District) --</option>');
            return;
        }
        districtSelect.prop('disabled', true).empty().append('<option value="">Inatafuta...</option>');
        $.getJSON('{{ url("admin/districts-by-region") }}/' + regionId, function(data) {
            districtSelect.empty().append('<option value="">-- Mkoa mzima (No District) --</option>');
            data.forEach(function(d) {
                districtSelect.append('<option value="' + d.id + '">' + d.name + '</option>');
            });
            districtSelect.prop('disabled', false);
        }).fail(function() {
            districtSelect.empty().append('<option value="">Hitilafu imetokea</option>').prop('disabled', false);
        });
    });
});
</script>
@endpush
@endsection
