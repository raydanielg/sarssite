@extends('admin.layouts.admin')

@section('title', 'Schools')
@section('page_title', 'Schools')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Schools</h3>
        <div class="card-tools">
            <a href="{{ route('admin.schools.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add School
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th style="width: 80px">Code</th>
                    <th>Name</th>
                    <th>Region</th>
                    <th>Levels</th>
                    <th style="width: 180px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schools as $school)
                    <tr>
                        <td><code>{{ $school->code }}</code></td>
                        <td>{{ $school->name }}</td>
                        <td>{{ $school->region->name }}</td>
                        <td>
                            @foreach($school->levels as $level)
                                <span class="badge badge-info">{{ $level->name }}</span>
                            @endforeach
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.schools.destroy', $school) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete School?" data-confirm-text="Unataka kufuta shule ya '{{ $school->name }}'?" data-confirm-button="Yes, Delete it!">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">No schools found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($schools->hasPages())
        <div class="card-footer clearfix">
            {{ $schools->links() }}
        </div>
    @endif
</div>
@endsection
