@extends('admin.layouts.admin')

@section('title', 'Aina za Mitihani')
@section('page_title', 'Aina za Mitihani')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">Aina Zote</h3>
        <div class="card-tools">
            <a href="{{ route('admin.result-types.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Ongeza Aina
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th style="width: 80px">#</th>
                    <th>Jina la Aina</th>
                    <th>Level</th>
                    <th>Slug</th>
                    <th>Hali (Status)</th>
                    <th style="width: 180px">Vitendo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultTypes as $type)
                    <tr>
                        <td>{{ $type->id }}</td>
                        <td>{{ $type->name }}</td>
                        <td>
                            @forelse($type->levels as $level)
                                <span class="badge badge-info">{{ $level->name }}</span>
                            @empty
                                <span class="badge badge-secondary">All Levels</span>
                            @endforelse
                        </td>
                        <td><code>{{ $type->slug }}</code></td>
                        <td>
                            @if($type->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.result-types.edit', $type) }}" class="btn btn-xs btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.result-types.destroy', $type) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Una uhakika unataka kufuta aina hii?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">Hakuna aina za mitihani zilizopatikana.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
