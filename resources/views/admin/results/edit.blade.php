@extends('admin.layouts.admin')

@section('title', 'Edit Result')
@section('page_title', 'Edit Result Details')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Form</h3>
        <div class="card-tools">
            <a href="{{ route('admin.results.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <form action="{{ route('admin.results.update', $result) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="result_title_id">Select Result Category (Title)</label>
                        <select name="result_title_id" id="result_title_id" class="form-control select2" required>
                            <option value="">-- Select Category --</option>
                            @foreach($resultTitles as $rt)
                                <option value="{{ $rt->id }}" {{ old('result_title_id', $result->result_title_id) == $rt->id ? 'selected' : '' }}>
                                    {{ $rt->name }} ({{ $rt->year->year }} - {{ $rt->level->name }} - {{ $rt->region->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="school_id">Select School</label>
                        <select name="school_id" id="school_id" class="form-control select2" required>
                            <option value="">-- Select School --</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id', $result->school_id) == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ $school->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="file">Update PDF File (Leave blank to keep current)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" accept="application/pdf">
                                <label class="custom-file-label" for="file">Choose new PDF file</label>
                            </div>
                        </div>
                        <p class="text-muted text-sm mt-1">Current file: <a href="{{ asset('storage/' . $result->file_path) }}" target="_blank">View Current PDF</a></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Draft" {{ old('status', $result->status) == 'Draft' ? 'selected' : '' }}>Draft (Private)</option>
                            <option value="Published" {{ old('status', $result->status) == 'Published' ? 'selected' : '' }}>Published (Public)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Extra Description (Optional)</label>
                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Any extra information about this school's result...">{{ old('description', $result->description) }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Result Details
            </button>
        </div>
    </form>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
$(function () {
  bsCustomFileInput.init();
  $('.select2').select2({
      theme: 'bootstrap4'
  });
});
</script>
@endpush
