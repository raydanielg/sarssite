@extends('admin.layouts.admin')

@section('title', 'Edit Level')
@section('page_title', 'Edit Level')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Level</h3>
        <div class="card-tools">
            <a href="{{ route('admin.levels.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.levels.update', $level) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Level Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $level->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. O-Level, A-Level" required autofocus>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Level
            </button>
        </div>
    </form>
</div>
@endsection
