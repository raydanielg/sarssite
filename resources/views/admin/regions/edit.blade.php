@extends('admin.layouts.admin')

@section('title', 'Edit Region')
@section('page_title', 'Edit Region')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Region</h3>
        <div class="card-tools">
            <a href="{{ route('admin.regions.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.regions.update', $region) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Region Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $region->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Arusha, Dar es Salaam" required autofocus>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Region
            </button>
        </div>
    </form>
</div>
@endsection
