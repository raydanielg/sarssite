@extends('admin.layouts.admin')

@section('title', 'Upload Summary ya Mkoa')
@section('page_title', 'Upload Summary ya Mkoa')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-success shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-map-marked-alt mr-2 text-success"></i> Upload Summary ya Mkoa
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.result-summaries.index', ['type' => 'region']) }}" class="btn btn-default btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
            <form action="{{ route('admin.region-summaries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i> Chagua mtihani wowote - mfumo utatengeneza <strong>category ya Mkoa</strong> otomatiki kama haipo. Kwa summary za Wilaya tumia <a href="{{ route('admin.district-summaries.create') }}" class="alert-link">page ya Wilaya</a>.
                    </div>

                    <div class="form-group">
                        <label for="result_title_id">Chagua Mtihani</label>
                        <select name="result_title_id" id="result_title_id" class="form-control select2 @error('result_title_id') is-invalid @enderror" required>
                            <option value="">-- Chagua Mtihani --</option>
                            @foreach($resultTitles as $title)
                                <option value="{{ $title->id }}" {{ old('result_title_id') == $title->id ? 'selected' : '' }}>
                                    {{ $title->year->year }} - {{ $title->level->name }} - [Mkoa: {{ $title->region->name }}] - {{ $title->name }}{{ $title->district ? ' [Wilaya: ' . $title->district->name . ']' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('result_title_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted d-block mt-2">Unaweza kuchagua mtihani wa mkoa au wilaya - summary itaunganishwa otomatiki kwenye category ya Mkoa.</small>
                    </div>

                    <div class="form-group">
                        <label for="name">Summary Display Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Matokeo ya Mkoa - Mock 2026" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="file">PDF File (Max 20MB)</label>
                        <div class="custom-file">
                            <input type="file" name="file" id="file" class="custom-file-input @error('file') is-invalid @enderror" accept=".pdf" required>
                            <label class="custom-file-label" for="file">Choose PDF...</label>
                        </div>
                        @error('file')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer bg-white text-right">
                    <button type="submit" class="btn btn-success px-4 rounded-pill">
                        <i class="fas fa-save mr-1"></i> Save Summary ya Mkoa
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
