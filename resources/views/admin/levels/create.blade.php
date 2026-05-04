@extends('admin.layouts.admin')

@section('title', 'Add Level')
@section('page_title', 'Add Level')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">Create Level</h3>
        <div class="card-tools">
            <a href="{{ route('admin.levels.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.levels.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Level Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. O-Level, A-Level" required autofocus>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save Level
            </button>
        </div>
    </form>
</div>
@endsection
