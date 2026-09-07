@extends('admin.layouts.admin')

@section('title', 'Upload PC Result')
@section('page_title', 'Upload Private Candidate Result')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-outline card-warning shadow border-0 rounded-lg overflow-hidden">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);">
                <h3 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-user-graduate mr-2"></i> Upload Matokeo ya Private Candidate (PC)
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.results.index') }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
            <form action="{{ route('admin.results.pc-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="alert alert-warning border-0 rounded-lg d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-lg mr-3 text-warning"></i>
                        <div>
                            Hii sehemu ni kwa ajili ya <strong>Private Candidates (PC)</strong> tu. Watahiniwa wa PC hawana mgawanyiko wa Wilaya — wanatumia category ya Mkoa tu.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="result_title_id"><i class="fas fa-clipboard-list text-muted mr-1"></i> Examination Category (Mkoa) <span class="text-danger">*</span></label>
                                <select name="result_title_id" id="result_title_id" class="form-control select2 shadow-sm @error('result_title_id') is-invalid @enderror" required>
                                    <option value="">-- Chagua Mtihani (Mkoa) --</option>
                                    @foreach($resultTitles as $rt)
                                        <option value="{{ $rt->id }}" {{ old('result_title_id') == $rt->id ? 'selected' : '' }}>
                                            {{ $rt->name }} ({{ $rt->year->year ?? '' }} - {{ $rt->level->name ?? '' }} - {{ $rt->region->name ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Watahiniwa wa PC wanatumia category ya Mkoa tu (bila Wilaya).</small>
                                @error('result_title_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                @if($resultTitles->isEmpty())
                                    <small class="text-danger d-block mt-2">
                                        <i class="fas fa-exclamation-triangle"></i> Hakuna examination category ya Mkoa iliyowekwa. Tafadhali ongeza Result Title na district iwe empty.
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_id"><i class="fas fa-school text-muted mr-1"></i> Chagua Private Candidate <span class="text-danger">*</span></label>
                                <select name="school_id" id="school_id" class="form-control select2 shadow-sm @error('school_id') is-invalid @enderror" required>
                                    <option value="">-- Chagua PC --</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                            {{ $school->name }} ({{ $school->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('school_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                @if($schools->isEmpty())
                                    <small class="text-danger d-block mt-2">
                                        <i class="fas fa-exclamation-triangle"></i> Hakuna Private Candidate aliyesajiliwa. Tafadhali ongeza shule na kuweka <strong>Is PC?</strong> kwenye settings.
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file"><i class="fas fa-file-pdf text-muted mr-1"></i> PDF File (Max 20MB) <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="file" id="file" class="custom-file-input shadow-sm @error('file') is-invalid @enderror" accept=".pdf" required>
                                    <label class="custom-file-label" for="file">Choose PDF...</label>
                                </div>
                                @error('file')
                                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status"><i class="fas fa-flag text-muted mr-1"></i> Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control shadow-sm" required>
                                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft (Private)</option>
                                    <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published (Public)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description"><i class="fas fa-align-left text-muted mr-1"></i> Extra Description (Optional)</label>
                        <textarea name="description" id="description" rows="2" class="form-control shadow-sm" placeholder="Maelezo ya ziada kuhusu matokeo ya mtahiniwa huyo...">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="card-footer bg-light text-right py-3 border-top">
                    <a href="{{ route('admin.results.index') }}" class="btn btn-default rounded-pill px-4 mr-2">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-warning px-5 rounded-pill shadow-sm">
                        <i class="fas fa-cloud-upload-alt mr-1"></i> Upload PC Result
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function () {
    $('.select2').select2({ theme: 'bootstrap4' });
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>
@endpush
@endsection
