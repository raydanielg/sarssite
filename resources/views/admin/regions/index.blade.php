@extends('admin.layouts.admin')

@section('title', 'Regions')
@section('page_title', 'Regions')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">All Regions</h3>
        <div class="card-tools">
            <a href="{{ route('admin.regions.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add Region
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
                @forelse($regions as $region)
                    <tr>
                        <td>{{ $loop->iteration + ($regions->currentPage() - 1) * $regions->perPage() }}</td>
                        <td>{{ $region->name }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.regions.edit', $region) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.regions.destroy', $region) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" data-confirm-delete data-confirm-title="Delete Region?" data-confirm-text="Unataka kufuta mkoa wa '{{ $region->name }}'?" data-confirm-button="Yes, Delete it!">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted p-4">No regions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($regions->hasPages())
        <div class="card-footer clearfix">
            {{ $regions->links() }}
        </div>
    @endif
</div>
@endsection
