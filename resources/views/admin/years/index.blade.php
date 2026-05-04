@extends('admin.layouts.admin')

@section('title', 'Years')
@section('page_title', 'Years')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Years</h3>

        <div class="card-tools">
            <a href="{{ route('admin.years.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add Year
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th style="width: 80px">#</th>
                    <th>Year</th>
                    <th style="width: 180px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($years as $year)
                    <tr>
                        <td>{{ $year->id }}</td>
                        <td>{{ $year->year }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.years.edit', $year) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.years.destroy', $year) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete Year?" data-confirm-text="This will permanently delete the year." data-confirm-button="Yes, delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted p-4">No years found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($years->hasPages())
        <div class="card-footer clearfix">
            {{ $years->links() }}
        </div>
    @endif
</div>
@endsection
