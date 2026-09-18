@extends('admin.layouts.admin')

@section('title', 'Aina za Mitihani')
@section('page_title', 'Aina za Mitihani')

@section('content')
<div class="card card-outline card-success shadow border-0 rounded-lg overflow-hidden">
    <div class="card-header bg-gradient-success text-white py-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-layer-group mr-2"></i> Aina Zote za Mitihani
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.result-types.create') }}" class="btn btn-sm btn-light text-success font-weight-bold rounded-pill px-3">
                <i class="fas fa-plus-circle"></i> Ongeza Aina
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="font-weight-bold" style="width: 60px">#</th>
                    <th class="font-weight-bold">Jina la Aina</th>
                    <th class="font-weight-bold" style="width: 180px">Level</th>
                    <th class="font-weight-bold" style="width: 120px">Hali (Status)</th>
                    <th class="font-weight-bold text-right" style="width: 140px">Vitendo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultTypes as $type)
                    <tr>
                        <td class="font-weight-bold text-muted">{{ $type->id }}</td>
                        <td>
                            <div class="font-weight-bold text-dark">{{ $type->name }}</div>
                            @if($type->description)
                                <small class="text-muted">{{ $type->description }}</small>
                            @endif
                        </td>
                        <td>
                            @forelse($type->levels as $level)
                                <span class="badge badge-success badge-pill px-2 py-1 mr-1"><i class="fas fa-graduation-cap mr-1"></i>{{ $level->name }}</span>
                            @empty
                                <span class="badge badge-secondary badge-pill px-2 py-1"><i class="fas fa-layer-group mr-1"></i>All Levels</span>
                            @endforelse
                        </td>
                        <td>
                            @if($type->is_active)
                                <span class="badge badge-success badge-pill px-3 py-1"><i class="fas fa-check-circle mr-1"></i>Active</span>
                            @else
                                <span class="badge badge-danger badge-pill px-3 py-1"><i class="fas fa-times-circle mr-1"></i>Inactive</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.result-types.edit', $type) }}" class="btn btn-xs btn-outline-primary rounded-pill">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.result-types.destroy', $type) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-outline-danger rounded-pill" data-confirm-delete data-confirm-title="Futa Aina?" data-confirm-text="Una uhakika unataka kufuta aina hii ya mtihani?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
                            <p class="font-weight-bold">Hakuna aina za mitihani zilizowekwa.</p>
                            <a href="{{ route('admin.result-types.create') }}" class="btn btn-success btn-sm rounded-pill px-4">
                                <i class="fas fa-plus-circle mr-1"></i> Ongeza Aina
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($resultTypes->hasPages())
        <div class="card-footer clearfix">
            {{ $resultTypes->links() }}
        </div>
    @endif
</div>
@endsection
