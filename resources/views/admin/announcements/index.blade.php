@extends('admin.layouts.admin')

@section('title', 'Announcements')
@section('page_title', 'Announcements')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Announcements</h3>
        <div class="card-tools">
            <a href="{{ route('admin.announcements.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add Announcement
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="width: 180px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td><span class="badge badge-{{ $announcement->type }}">{{ ucfirst($announcement->type) }}</span></td>
                        <td>
                            @if($announcement->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $announcement->created_at->format('M d, Y') }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete Announcement?" data-confirm-text="Unataka kufuta tangazo hili?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">No announcements found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($announcements->hasPages())
        <div class="card-footer clearfix">
            {{ $announcements->links() }}
        </div>
    @endif
</div>
@endsection
