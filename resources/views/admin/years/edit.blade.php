@extends('admin.layouts.admin')

@section('title', 'Edit Year')
@section('page_title', 'Edit Year')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Year</h3>
        <div class="card-tools">
            <a href="{{ route('admin.years.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.years.update', $year) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" min="1900" max="2100" id="year" name="year" value="{{ old('year', $year->year) }}" class="form-control @error('year') is-invalid @enderror" placeholder="e.g. 2026" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection
