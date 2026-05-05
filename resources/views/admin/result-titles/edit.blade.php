@extends('admin.layouts.admin')

@section('title', 'Edit Result Category')
@section('page_title', 'Edit Category Details')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Category Details</h3>
        <div class="card-tools">
            <a href="{{ route('admin.result-titles.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.result-titles.update', $resultTitle) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Category Title Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $resultTitle->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Form Four Results 2026 - Arusha" required autofocus>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="year_id">Year</label>
                        <select name="year_id" id="year_id" class="form-control" required>
                            <option value="">-- Select Year --</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}" {{ old('year_id', $resultTitle->year_id) == $year->id ? 'selected' : '' }}>{{ $year->year }}</option>
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
                                <option value="{{ $level->id }}" {{ old('level_id', $resultTitle->level_id) == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="region_id">Region</label>
                        <select name="region_id" id="region_id" class="form-control" required>
                            <option value="">-- Select Region --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id', $resultTitle->region_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Category
            </button>
        </div>
    </form>
</div>
@endsection
