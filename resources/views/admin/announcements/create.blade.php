@extends('admin.layouts.admin')

@section('title', 'Add Announcement')
@section('page_title', 'Create New Announcement')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">Announcement Form</h3>
        <div class="card-tools">
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.announcements.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Important Notice for 2026 Results" required autofocus>
            </div>

            <div class="form-group">
                <label for="type">Type (Color Style)</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="info">Info (Blue)</option>
                    <option value="success">Success (Green)</option>
                    <option value="warning">Warning (Yellow)</option>
                    <option value="danger">Danger (Red)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="link">Action Link (Hiari - Mfano: https://google.com)</label>
                <input type="url" id="link" name="link" value="{{ old('link') }}" class="form-control @error('link') is-invalid @enderror" placeholder="Ingiza link kama ipo...">
                <small class="text-muted">Mtu akibofya tangazo, atapelekwa kwenye link hii.</small>
                @error('link')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror" placeholder="Write your announcement here..." required>{{ old('content') }}</textarea>
            </div>

            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="is_active" id="is_active" checked>
                <label for="is_active" class="custom-control-label">Mark as Active</label>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save Announcement
            </button>
        </div>
    </form>
</div>
@endsection
