@extends('admin.layouts.admin')

@section('title', 'Edit Result Summary')
@section('page_title', 'Edit Result Summary Details')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-edit mr-2 text-primary"></i> Edit Summary
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.result-summaries.index') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
            <form action="{{ route('admin.result-summaries.update', $resultSummary) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="result_title_id">Examination Category</label>
                        <select name="result_title_id" id="result_title_id" class="form-control select2 @error('result_title_id') is-invalid @enderror" required>
                            @foreach($resultTitles as $title)
                                <option value="{{ $title->id }}" {{ old('result_title_id', $resultSummary->result_title_id) == $title->id ? 'selected' : '' }}>{{ $title->year->year }} - {{ $title->level->name }} - {{ $title->name }}</option>
                            @endforeach
                        </select>
                        @error('result_title_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Summary Display Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $resultSummary->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control shadow-sm">
                            <option value="Published" {{ $resultSummary->status == 'Published' ? 'selected' : '' }}>Published</option>
                            <option value="Draft" {{ $resultSummary->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="file">Replace PDF (Optional - Max 20MB)</label>
                        <div class="custom-file">
                            <input type="file" name="file" id="file" class="custom-file-input @error('file') is-invalid @enderror" accept=".pdf">
                            <label class="custom-file-label" for="file">Choose new PDF...</label>
                        </div>
                        <small class="text-muted d-block mt-2">Current file: <a href="{{ asset('storage/' . $resultSummary->file_path) }}" target="_blank" class="text-primary font-weight-bold">View PDF</a></small>
                        @error('file')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer bg-white text-right">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">
                        <i class="fas fa-save mr-1"></i> Update Summary
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>
@endpush
@endsection
