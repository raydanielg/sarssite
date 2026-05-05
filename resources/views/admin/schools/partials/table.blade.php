@forelse($schools as $school)
    <tr>
        <td><code>{{ $school->code }}</code></td>
        <td>
            {{ $school->name }}
            @if($school->is_pc)
                <span class="badge badge-warning ml-1">PC</span>
            @endif
        </td>
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
