@extends('admin.layouts.admin')

@section('title', 'Edit Announcement')
@section('page_title', 'Edit Announcement Details')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Form</h3>
        <div class="card-tools">
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Important Notice" required autofocus>
            </div>

            <div class="form-group">
                <label for="type">Type (Color Style)</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="info" {{ $announcement->type == 'info' ? 'selected' : '' }}>Info (Blue)</option>
                    <option value="success" {{ $announcement->type == 'success' ? 'selected' : '' }}>Success (Green)</option>
                    <option value="warning" {{ $announcement->type == 'warning' ? 'selected' : '' }}>Warning (Yellow)</option>
                    <option value="danger" {{ $announcement->type == 'danger' ? 'selected' : '' }}>Danger (Red)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror" placeholder="Write your announcement here..." required>{{ old('content', $announcement->content) }}</textarea>
            </div>

            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="is_active" id="is_active" {{ $announcement->is_active ? 'checked' : '' }}>
                <label for="is_active" class="custom-control-label">Mark as Active</label>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Announcement
            </button>
        </div>
    </form>
</div>
@endsection
