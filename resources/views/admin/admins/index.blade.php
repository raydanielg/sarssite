@extends('admin.layouts.admin')

@section('title', 'Admin Management')
@section('page_title', 'System Administrators')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Admins</h3>
        <div class="card-tools">
            <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-user-plus"></i> Add New Admin
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }} @if(auth()->id() == $admin->id) <span class="badge badge-primary">You</span> @endif</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at->format('M d, Y') }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(auth()->id() != $admin->id)
                            <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete Admin?" data-confirm-text="Are you sure you want to remove this admin?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted p-4">No admin users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($admins->hasPages())
        <div class="card-footer clearfix">
            {{ $admins->links() }}
        </div>
    @endif
</div>
@endsection
