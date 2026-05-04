@extends('admin.layouts.admin')

@section('title', 'Levels')
@section('page_title', 'Levels')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Levels</h3>
        <div class="card-tools">
            <a href="{{ route('admin.levels.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add Level
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th style="width: 80px">#</th>
                    <th>Name</th>
                    <th style="width: 180px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($levels as $level)
                    <tr>
                        <td>{{ $level->id }}</td>
                        <td>{{ $level->name }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.levels.edit', $level) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.levels.destroy', $level) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete Level?" data-confirm-text="Unataka kufuta level ya '{{ $level->name }}'?" data-confirm-button="Yes, Delete it!">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted p-4">No levels found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($levels->hasPages())
        <div class="card-footer clearfix">
            {{ $levels->links() }}
        </div>
    @endif
</div>
@endsection
