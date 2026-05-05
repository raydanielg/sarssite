@extends('admin.layouts.admin')

@section('title', 'Manage Results')
@section('page_title', 'Results Management')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle mr-3 fa-lg"></i>
                    <div>
                        <strong>Hongera!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('warning_list'))
            <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" role="alert">
                <h5><i class="icon fas fa-exclamation-triangle mr-2"></i> Baadhi ya faili hayajapakiwa:</h5>
                <ul class="mb-0 mt-2 pl-4">
                    @foreach(session('warning_list') as $warning)
                        <li>{{ $warning }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>

<div class="card card-outline card-success shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-list-alt mr-2 text-success"></i> Orodha ya Matokeo yote
                </h3>
            </div>
            <div class="card-tools d-flex gap-2">
                <a href="{{ route('admin.results.bulk-upload-form') }}" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill mr-2">
                    <i class="fas fa-copy mr-1"></i> Bulk Upload
                </a>
                <a href="{{ route('admin.results.create') }}" class="btn btn-success btn-sm px-3 shadow-sm rounded-pill">
                    <i class="fas fa-upload mr-1"></i> Upload Single
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted text-uppercase small font-weight-bold">
                    <tr>
                        <th class="border-0 px-4 py-3">Maelezo (Category)</th>
                        <th class="border-0 py-3">Level & Year</th>
                        <th class="border-0 py-3">Kanda/Mkoa</th>
                        <th class="border-0 py-3">Shule</th>
                        <th class="border-0 py-3">Hali (Status)</th>
                        <th class="border-0 py-3 text-right px-4">Vitendo</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    @forelse($results as $result)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-weight-bold">{{ $result->resultTitle->name }}</div>
                                <small class="text-muted text-uppercase tracking-wider font-weight-bold" style="font-size: 10px;">{{ $result->resultTitle->slug }}</small>
                            </td>
                            <td>
                                <div class="badge badge-info shadow-none px-2 py-1 rounded-sm mb-1">{{ $result->resultTitle->level->name }}</div>
                                <div class="text-dark font-weight-bold" style="font-size: 14px;">Mwaka: {{ $result->resultTitle->year->year }}</div>
                            </td>
                            <td>
                                <div class="text-dark">{{ $result->resultTitle->region->name }}</div>
                                <small class="text-muted text-uppercase">Tanzania</small>
                            </td>
                            <td>
                                <div class="font-weight-bold text-primary">{{ $result->school->name }}</div>
                                <code class="text-muted font-weight-bold" style="font-size: 12px;">{{ $result->school->code }}</code>
                            </td>
                            <td>
                                @if($result->status == 'Published')
                                    <span class="badge badge-success-soft text-success px-3 py-1 rounded-pill border border-success" style="background-color: #e8f5e9;">
                                        <i class="fas fa-check-circle mr-1 small"></i> Published
                                    </span>
                                @else
                                    <span class="badge badge-warning-soft text-warning px-3 py-1 rounded-pill border border-warning" style="background-color: #fff8e1;">
                                        <i class="fas fa-clock mr-1 small"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td class="text-right px-4">
                                <div class="btn-group shadow-sm border rounded">
                                    <a href="{{ asset('storage/' . $result->file_path) }}" target="_blank" class="btn btn-white btn-sm" title="View PDF">
                                        <i class="fas fa-file-pdf text-danger"></i>
                                    </a>
                                    <a href="{{ route('admin.results.edit', $result) }}" class="btn btn-white btn-sm" title="Edit">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.results.destroy', $result) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm border-left" 
                                                onclick="return confirm('Una uhakika unataka kufuta matokeo haya?')"
                                                title="Delete">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted mb-3">
                                    <i class="fas fa-folder-open fa-3x opacity-20"></i>
                                </div>
                                <h5 class="text-muted">Hakuna matokeo yoyote yaliyopatikana.</h5>
                                <p class="text-muted small">Anza kwa kupakia (upload) faili za matokeo.</p>
                                <a href="{{ route('admin.results.bulk-upload-form') }}" class="btn btn-success btn-sm mt-2 rounded-pill px-4 shadow-sm">
                                    <i class="fas fa-upload mr-1"></i> Pakia Matokeo Sasa
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($results->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $results->links() }}
            </div>
        </div>
    @endif
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }
    .btn-white {
        background-color: #fff;
        border: none;
    }
    .btn-white:hover {
        background-color: #f1f1f1;
    }
    .badge-success-soft { font-size: 11px; letter-spacing: 0.5px; }
    .badge-warning-soft { font-size: 11px; letter-spacing: 0.5px; }
</style>
@endsection
