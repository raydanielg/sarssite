@extends('admin.layouts.admin')

@section('title', 'Add School')
@section('page_title', 'Add School')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">Create School</h3>
        <div class="card-tools">
            <a href="{{ route('admin.schools.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.schools.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="code">School Code</label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" placeholder="e.g. S0101" required autofocus>
                        @error('code')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">School Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. AZANIA SECONDARY SCHOOL" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="region_id">Region</label>
                        <select name="region_id" id="region_id" class="form-control @error('region_id') is-invalid @enderror" required>
                            <option value="">-- Select Region --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                        @error('region_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Levels</label>
                        <div class="mt-2">
                            @foreach($levels as $level)
                                <div class="custom-control custom-checkbox d-inline mr-3">
                                    <input class="custom-control-input" type="checkbox" name="levels[]" id="level_{{ $level->id }}" value="{{ $level->id }}" {{ is_array(old('levels')) && in_array($level->id, old('levels')) ? 'checked' : '' }}>
                                    <label for="level_{{ $level->id }}" class="custom-control-label font-weight-normal">{{ $level->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('levels')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save School
            </button>
        </div>
    </form>
</div>
@endsection
