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

                    <!-- Step 1: Region Selection Card -->
                    <div class="exam-selector-card rounded-lg border shadow-sm mb-4 overflow-hidden">
                        <div class="exam-selector-header px-4 py-3 text-white d-flex align-items-center" style="background: linear-gradient(135deg, #6c5ce7 0%, #4834d4 100%);">
                            <div class="step-number mr-3 d-flex align-items-center justify-content-center rounded-circle bg-white text-dark font-weight-bold" style="width: 32px; height: 32px; font-size: 1rem;">1</div>
                            <div>
                                <h5 class="font-weight-bold mb-0">Chagua Mkoa</h5>
                                <small class="text-white-50">Chagua mkoa ambao mtahiniwa wa PC anahusiana</small>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <div class="form-group mb-0">
                                <label for="region_id" class="font-weight-bold text-muted small text-uppercase mb-2">
                                    <i class="fas fa-globe-africa mr-1 text-primary"></i> Mkoa <span class="text-danger">*</span>
                                </label>
                                <select name="region_id" id="region_id" class="form-control form-control-lg select2 shadow-sm" required>
                                    <option value="">-- Chagua Mkoa --</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                                @if($regions->isEmpty())
                                    <div class="alert alert-danger border-0 rounded-lg mt-3 mb-0 d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle fa-lg mr-3"></i>
                                        <div>Hakuna mkoa uliowekwa. Tafadhali ongeza mikoa kwanza.</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Exam Selection Card -->
                    <div class="exam-selector-card rounded-lg border shadow-sm mb-4 overflow-hidden" id="examSelectionCard" style="opacity: 0.5; pointer-events: none;">
                        <div class="exam-selector-header px-4 py-3 text-white d-flex align-items-center" style="background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);">
                            <div class="step-number mr-3 d-flex align-items-center justify-content-center rounded-circle bg-white text-dark font-weight-bold" style="width: 32px; height: 32px; font-size: 1rem;">2</div>
                            <div>
                                <h5 class="font-weight-bold mb-0">Chagua Mtihani</h5>
                                <small class="text-white-50">Chagua category ya mtihani ya Mkoa (bila Wilaya)</small>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <div class="form-group mb-0">
                                <label for="result_title_id" class="font-weight-bold text-muted small text-uppercase mb-2">
                                    <i class="fas fa-tag mr-1 text-primary"></i> Examination Category <span class="text-danger">*</span>
                                </label>
                                <select name="result_title_id" id="result_title_id" class="form-control form-control-lg select2 shadow-sm @error('result_title_id') is-invalid @enderror" required disabled>
                                    <option value="">-- Chagua Mkoa kwanza --</option>
                                </select>
                                <div id="examInfoBox" class="mt-3 d-none">
                                    <div class="d-flex flex-wrap gap-3">
                                        <span class="badge badge-info badge-pill px-3 py-2"><i class="fas fa-calendar mr-1"></i> <span id="examInfoYear"></span></span>
                                        <span class="badge badge-success badge-pill px-3 py-2"><i class="fas fa-graduation-cap mr-1"></i> <span id="examInfoLevel"></span></span>
                                        <span class="badge badge-primary badge-pill px-3 py-2"><i class="fas fa-map-marked-alt mr-1"></i> <span id="examInfoRegion"></span></span>
                                    </div>
                                </div>
                                @error('result_title_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: PC Selection -->
                    <div class="form-group">
                        <label for="school_id" class="font-weight-bold"><i class="fas fa-user-graduate text-muted mr-1"></i> Chagua Private Candidate <span class="text-danger">*</span></label>
                        <select name="school_id" id="school_id" class="form-control form-control-lg select2 shadow-sm @error('school_id') is-invalid @enderror" required>
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
                            <div class="alert alert-danger border-0 rounded-lg mt-3 mb-0 d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-lg mr-3"></i>
                                <div>Hakuna Private Candidate aliyesajiliwa. Tafadhali ongeza shule na kuweka <strong>Is PC?</strong> kwenye settings.</div>
                            </div>
                        @endif
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
                                <select name="status" id="status" class="form-control form-control-lg shadow-sm" required>
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

    $('#region_id').on('change', function() {
        const regionId = $(this).val();
        const titleSelect = $('#result_title_id');
        const examCard = $('#examSelectionCard');

        if (!regionId) {
            titleSelect.empty().append('<option value="">-- Chagua Mkoa kwanza --</option>').prop('disabled', true);
            examCard.css({ opacity: 0.5, pointerEvents: 'none' });
            $('#examInfoBox').fadeOut(200).addClass('d-none');
            return;
        }

        titleSelect.prop('disabled', true).empty().append('<option value="">Inatafuta...</option>');
        examCard.css({ opacity: 0.5, pointerEvents: 'none' });

        $.ajax({
            url: '{{ route("admin.region-summaries.titles-by-region", ":id") }}'.replace(':id', regionId),
            type: 'GET',
            success: function(data) {
                titleSelect.empty();
                if (data.length > 0) {
                    titleSelect.append('<option value="">-- Chagua Mtihani --</option>');
                    data.forEach(function(item) {
                        titleSelect.append('<option value="' + item.id + '" data-year="' + item.year + '" data-level="' + item.level + '" data-region="' + item.region + '">' + item.name + '</option>');
                    });
                    titleSelect.prop('disabled', false);
                    examCard.css({ opacity: 1, pointerEvents: 'auto' });
                } else {
                    titleSelect.append('<option value="">Hakuna mtihani wa mkoa huu</option>').prop('disabled', true);
                }
            },
            error: function() {
                titleSelect.empty().append('<option value="">Hitilafu imetokea. Jaribu tena.</option>').prop('disabled', true);
            }
        });
    });

    $('#result_title_id').on('change', function() {
        const $opt = $(this).find('option:selected');
        if ($opt.val()) {
            $('#examInfoYear').text($opt.data('year') || '-');
            $('#examInfoLevel').text($opt.data('level') || '-');
            $('#examInfoRegion').text($opt.data('region') || '-');
            $('#examInfoBox').removeClass('d-none').hide().fadeIn(300);
        } else {
            $('#examInfoBox').fadeOut(200).addClass('d-none');
        }
    });
});
</script>
@endpush
@endsection
