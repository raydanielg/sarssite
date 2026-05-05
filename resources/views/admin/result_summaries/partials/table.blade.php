@forelse($summaries as $summary)
    @php
        $isNew = $summary->created_at && $summary->created_at->diffInMinutes(now()) <= 5;
    @endphp
    <tr>
        <td class="px-4 py-3">
            <div class="d-flex align-items-center">
                <div class="mr-3 bg-light rounded p-2 text-primary">
                    <i class="fas fa-file-pdf fa-lg"></i>
                </div>
                <div>
                    <div class="font-weight-bold text-dark">{{ $summary->name }}</div>
                    @if($isNew)
                        <span class="badge badge-danger blink-new py-1 px-2 rounded-sm font-weight-black" style="font-size: 9px; vertical-align: middle;">NEW</span>
                    @endif
                </div>
            </div>
        </td>
        <td class="py-3 px-4">
            <div class="font-weight-bold text-dark">{{ $summary->resultTitle->name }}</div>
            <div class="small text-muted">
                {{ $summary->resultTitle->year->year }} - {{ $summary->resultTitle->level->name }}
            </div>
        </td>
        <td class="py-3">
            @if($summary->status == 'Published')
                <span class="text-success small font-weight-bold"><i class="fas fa-check-circle mr-1"></i> Published</span>
            @else
                <span class="text-warning small font-weight-bold"><i class="fas fa-clock mr-1"></i> Draft</span>
            @endif
        </td>
        <td class="text-right px-4 py-3">
            <div class="btn-group shadow-sm border rounded overflow-hidden">
                <a href="{{ asset('storage/' . $summary->file_path) }}" target="_blank" class="btn btn-white btn-sm" title="View"><i class="fas fa-eye text-info"></i></a>
                <a href="{{ route('admin.result-summaries.edit', $summary) }}" class="btn btn-white btn-sm border-left" title="Edit"><i class="fas fa-edit text-primary"></i></a>
                <form action="{{ route('admin.result-summaries.destroy', $summary) }}" method="POST" class="d-inline delete-summary-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-white btn-sm border-left" title="Delete"><i class="fas fa-trash text-danger"></i></button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center py-5 text-muted">No summaries found.</td>
    </tr>
@endforelse

@if(isset($summaries) && method_exists($summaries, 'links') && $summaries->hasPages())
    <tr class="pagination-row">
        <td colspan="4" class="px-4 py-3 bg-light">
            <div class="d-flex justify-content-center">
                {{ $summaries->appends(request()->except('page'))->links() }}
            </div>
        </td>
    </tr>
@endif
