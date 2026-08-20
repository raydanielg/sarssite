@extends('admin.layouts.admin')

@section('title', 'Add District')
@section('page_title', 'Add District')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">District Details</h3>
        <div class="card-tools">
            <a href="{{ route('admin.districts.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.districts.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">District Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Ilala" required autofocus>
            </div>
            <div class="form-group">
                <label for="region_id">Region</label>
                <select name="region_id" id="region_id" class="form-control" required>
                    <option value="">-- Select Region --</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save District
            </button>
        </div>
    </form>
</div>
@endsection
