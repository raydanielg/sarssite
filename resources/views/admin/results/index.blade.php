@extends('admin.layouts.admin')

@section('title', 'Results')
@section('page_title', 'Result Files (PDFs)')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Uploaded Results</h3>
        <div class="card-tools">
            <a href="{{ route('admin.results.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-upload"></i> Upload New Result
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Category (Title)</th>
                    <th>Year</th>
                    <th>Level</th>
                    <th>Region</th>
                    <th>School</th>
                    <th>Status</th>
                    <th style="width: 180px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                    <tr>
                        <td>{{ $result->resultTitle->name }}</td>
                        <td>{{ $result->resultTitle->year->year }}</td>
                        <td><span class="badge badge-info">{{ $result->resultTitle->level->name }}</span></td>
                        <td>{{ $result->resultTitle->region->name }}</td>
                        <td>{{ $result->school->name }} ({{ $result->school->code }})</td>
                        <td>
                            @if($result->status == 'Published')
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ asset('storage/' . $result->file_path) }}" target="_blank" class="btn btn-xs btn-info" title="View PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('admin.results.edit', $result) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.results.destroy', $result) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete Result?" data-confirm-text="Unataka kufuta faili la matokeo hili?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted p-4">No results uploaded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($results->hasPages())
        <div class="card-footer clearfix">
            {{ $results->links() }}
        </div>
    @endif
</div>
@endsection
