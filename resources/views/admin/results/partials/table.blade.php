@forelse($results as $result)
    @php
        $isNew = $result->created_at && $result->created_at->diffInMinutes(now()) <= 5;
    @endphp
    <tr>
        <td class="px-4 py-3">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input item-checkbox" type="checkbox" id="check-{{ $result->id }}" value="{{ $result->id }}">
                <label for="check-{{ $result->id }}" class="custom-control-label"></label>
            </div>
        </td>
        <td class="py-3">
            <div class="d-flex align-items-center">
                <div class="mr-3 bg-light rounded p-2 text-success">
                    <i class="fas fa-file-pdf fa-lg"></i>
                </div>
                <div>
                    <div class="font-weight-bold text-dark">{{ $result->resultTitle->name }}</div>
                    <small class="text-muted">{{ $result->resultTitle->region->name }}</small>
                    @if($isNew)
                        <span class="ml-2 badge badge-danger blink-new py-1 px-2 rounded-sm font-weight-black" style="font-size: 9px; vertical-align: middle;">NEW</span>
                    @endif
                </div>
            </div>
        </td>
        <td class="text-center py-3">
            <span class="badge badge-info shadow-none px-2 py-1 rounded-sm d-block mb-1">{{ $result->resultTitle->level->name }}</span>
            <span class="font-weight-bold text-muted small">Year: {{ $result->resultTitle->year->year }}</span>
        </td>
        <td class="py-3 px-4">
            <div class="font-weight-bold">{{ $result->school->name }}</div>
            <code class="small bg-light px-1 rounded text-primary font-weight-bold">{{ $result->school->code }}</code>
        </td>
        <td class="py-3">
            @if($result->status == 'Published')
                <span class="text-success small font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Published</span>
            @else
                <span class="text-warning small font-weight-bold"><i class="fas fa-clock mr-1"></i> Draft</span>
            @endif
        </td>
        <td class="text-right px-4 py-3">
            <div class="btn-group shadow-sm border rounded overflow-hidden">
                <a href="{{ route('results.serve_pdf', ['file' => $result->file_path]) }}" target="_blank" class="btn btn-white btn-sm" title="View"><i class="fas fa-eye text-info"></i></a>
                <a href="{{ route('admin.results.edit', $result) }}" class="btn btn-white btn-sm border-left" title="Edit"><i class="fas fa-edit text-primary"></i></a>
                <form action="{{ route('admin.results.destroy', $result) }}" method="POST" class="d-inline delete-result-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-white btn-sm border-left" title="Delete"><i class="fas fa-trash text-danger"></i></button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-5 text-muted">No results found.</td>
    </tr>
@endforelse

@if(isset($results) && method_exists($results, 'links') && $results->hasPages())
    <tr class="pagination-row">
        <td colspan="6" class="px-4 py-3 bg-light">
            <div class="d-flex justify-content-center">
                {{ $results->appends(request()->except('page'))->links() }}
            </div>
        </td>
    </tr>
@endif
