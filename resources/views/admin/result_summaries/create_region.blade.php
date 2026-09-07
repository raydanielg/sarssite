@extends('admin.layouts.admin')

@section('title', 'Upload Summary ya Mkoa')
@section('page_title', 'Upload Summary ya Mkoa')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-success shadow border-0 rounded-lg overflow-hidden">
            <div class="card-header bg-gradient-success text-white py-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <h3 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-map-marked-alt mr-2"></i> Upload Summary ya Mkoa
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.result-summaries.index', ['type' => 'region']) }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
            <form action="{{ route('admin.region-summaries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 rounded-lg d-flex align-items-center">
                        <i class="fas fa-info-circle fa-lg mr-3 text-info"></i>
                        <div>
                            Hii sehemu ni kwa ajili ya <strong>Summary za Mkoa</strong> tu. Kwa summary za Wilaya tumia <a href="{{ route('admin.district-summaries.create') }}" class="alert-link font-weight-bold">page ya Wilaya</a>.
                        </div>
                    </div>

                    <!-- Step 1: Region Selection Card -->
                    <div class="exam-selector-card rounded-lg border shadow-sm mb-4 overflow-hidden">
                        <div class="exam-selector-header px-4 py-3 text-white d-flex align-items-center" style="background: linear-gradient(135deg, #6c5ce7 0%, #4834d4 100%);">
                            <div class="step-number mr-3 d-flex align-items-center justify-content-center rounded-circle bg-white text-dark font-weight-bold" style="width: 32px; height: 32px; font-size: 1rem;">1</div>
                            <div>
                                <h5 class="font-weight-bold mb-0">Chagua Mkoa</h5>
                                <small class="text-white-50">Chagua mkoa ambao summary itapakiwa</small>
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
                        <div class="exam-selector-header px-4 py-3 text-white d-flex align-items-center" style="background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);">
                            <div class="step-number mr-3 d-flex align-items-center justify-content-center rounded-circle bg-white text-dark font-weight-bold" style="width: 32px; height: 32px; font-size: 1rem;">2</div>
                            <div>
                                <h5 class="font-weight-bold mb-0">Chagua Mtihani</h5>
                                <small class="text-white-50">Chagua category ya mtihani ambapo summary itapakiwa</small>
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
                                    <div class="d-flex flex-wrap gap-3 mb-3">
                                        <span class="badge badge-info badge-pill px-3 py-2"><i class="fas fa-calendar mr-1"></i> <span id="examInfoYear"></span></span>
                                        <span class="badge badge-success badge-pill px-3 py-2"><i class="fas fa-graduation-cap mr-1"></i> <span id="examInfoLevel"></span></span>
                                        <span class="badge badge-primary badge-pill px-3 py-2"><i class="fas fa-map-marked-alt mr-1"></i> <span id="examInfoRegion"></span></span>
                                    </div>
                                    <div id="districtsCoverageBox" class="d-none">
                                        <div class="alert alert-light border rounded-lg p-3 mb-0">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-info-circle text-primary mr-2"></i>
                                                <span class="font-weight-bold small text-muted text-uppercase">Wilaya zote zitakazopata summary hii:</span>
                                            </div>
                                            <div id="districtsList" class="d-flex flex-wrap gap-2"></div>
                                        </div>
                                    </div>
                                </div>
                                @error('result_title_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name"><i class="fas fa-tag text-muted mr-1"></i> Summary Display Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control shadow-sm @error('name') is-invalid @enderror" placeholder="e.g. Matokeo ya Mkoa - Mock 2026" required>
                        @error('name')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

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
                <div class="card-footer bg-light text-right py-3 border-top">
                    <a href="{{ route('admin.result-summaries.index', ['type' => 'region']) }}" class="btn btn-default rounded-pill px-4 mr-2">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                        <i class="fas fa-save mr-1"></i> Save Summary ya Mkoa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .exam-selector-card { transition: box-shadow 0.3s; }
    .exam-selector-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important; }
    .exam-selector-header { transition: filter 0.3s; }
    .exam-selector-card:hover .exam-selector-header { filter: brightness(1.05); }
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.5em + 1rem + 2px) !important;
        padding: 0.5rem 0.75rem !important;
        font-size: 1.05rem !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
    }
</style>

@push('js')
<script>
$(document).ready(function() {
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Step 1: Region selection -> load exam titles
    $('#region_id').on('change', function() {
        const regionId = $(this).val();
        const titleSelect = $('#result_title_id');
        const examCard = $('#examSelectionCard');

        if (!regionId) {
            titleSelect.empty().append('<option value="">-- Chagua Mkoa kwanza --</option>').prop('disabled', true);
            examCard.css({ opacity: 0.5, pointerEvents: 'none' });
            $('#examInfoBox').fadeOut(200).addClass('d-none');
            $('#districtsCoverageBox').addClass('d-none');
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
                        var parts = item.text.split(' - ');
                        var name = parts[0] || item.text;
                        var year = parts[1] || '';
                        var level = parts[2] || '';
                        var region = (parts[3] || '').replace('\\[Mkoa: ', '').replace('\\]', '');
                        titleSelect.append('<option value="' + item.id + '" data-year="' + year + '" data-level="' + level + '" data-region="' + region + '" data-region-id="' + regionId + '">' + name + '</option>');
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

    // Step 2: Exam selection -> show info badges + districts
    $('#result_title_id').on('change', function() {
        const $opt = $(this).find('option:selected');
        const districtsCoverageBox = $('#districtsCoverageBox');
        const districtsList = $('#districtsList');

        if ($opt.val()) {
            $('#examInfoYear').text($opt.data('year') || '-');
            $('#examInfoLevel').text($opt.data('level') || '-');
            $('#examInfoRegion').text($opt.data('region') || '-');
            $('#examInfoBox').removeClass('d-none').hide().fadeIn(300);

            const regionId = $opt.data('region-id');
            if (regionId) {
                districtsList.html('<span class="text-muted small"><i class="fas fa-spinner fa-spin mr-1"></i> Inatafuta wilaya...</span>');
                districtsCoverageBox.removeClass('d-none').hide().fadeIn(300);
                $.ajax({
                    url: '{{ route("admin.region-summaries.districts-by-region", ":id") }}'.replace(':id', regionId),
                    type: 'GET',
                    success: function(data) {
                        districtsList.empty();
                        if (data.length > 0) {
                            data.forEach(function(d) {
                                districtsList.append('<span class="badge badge-light badge-pill px-3 py-2 border"><i class="fas fa-map-pin text-primary mr-1"></i> ' + d.name + '</span>');
                            });
                        } else {
                            districtsList.html('<span class="text-muted small">Hakuna wilaya chini ya mkoa huu.</span>');
                        }
                    },
                    error: function() {
                        districtsList.html('<span class="text-danger small"><i class="fas fa-exclamation-circle mr-1"></i> Hitilafu imetokea. Jaribu tena.</span>');
                    }
                });
            }
        } else {
            $('#examInfoBox').fadeOut(200).addClass('d-none');
            districtsCoverageBox.addClass('d-none');
        }
    });
});
</script>
@endpush
@endsection
