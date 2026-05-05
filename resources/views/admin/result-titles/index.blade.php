@extends('admin.layouts.admin')

@section('title', 'Result Categories')
@section('page_title', 'Result Categories (Titles)')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Result Categories</h3>
        <div class="card-tools">
            <a href="{{ route('admin.result-titles.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Title Name</th>
                    <th>Year</th>
                    <th>Level</th>
                    <th>Region</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultTitles as $title)
                    <tr>
                        <td>{{ $title->name }}</td>
                        <td>{{ $title->year->year }}</td>
                        <td><span class="badge badge-info">{{ $title->level->name }}</span></td>
                        <td>{{ $title->region->name }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.result-titles.edit', $title) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.result-titles.destroy', $title) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete Category?" data-confirm-text="Deleting this category will also delete ALL results uploaded under it!">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">No result categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($resultTitles->hasPages())
        <div class="card-footer clearfix">
            {{ $resultTitles->links() }}
        </div>
    @endif
</div>
@endsection
