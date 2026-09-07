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

                    <!-- Exam Selection Card -->
                    <div class="exam-selector-card rounded-lg border shadow-sm mb-4 overflow-hidden">
                        <div class="exam-selector-header px-4 py-3 text-white d-flex align-items-center" style="background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);">
                            <i class="fas fa-clipboard-list fa-lg mr-3"></i>
                            <div>
                                <h5 class="font-weight-bold mb-0">Chagua Mtihani</h5>
                                <small class="text-white-50">Chagua category ya mtihani ambapo summary itapakiwa</small>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <div class="form-group mb-0">
                                <label for="result_title_id" class="font-weight-bold text-muted small text-uppercase mb-2">
                                    <i class="fas fa-tag mr-1 text-primary"></i> Examination Category (Mkoa) <span class="text-danger">*</span>
                                </label>
                                <select name="result_title_id" id="result_title_id" class="form-control form-control-lg select2 shadow-sm @error('result_title_id') is-invalid @enderror" required>
                                    <option value="">-- Chagua Mtihani (Mkoa) --</option>
                                    @foreach($resultTitles as $title)
                                        <option value="{{ $title->id }}" data-year="{{ $title->year->year ?? '' }}" data-level="{{ $title->level->name ?? '' }}" data-region="{{ $title->region->name ?? '' }}" {{ old('result_title_id') == $title->id ? 'selected' : '' }}>
                                            {{ $title->name }}
                                        </option>
                                    @endforeach
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
                                @if($resultTitles->isEmpty())
                                    <div class="alert alert-danger border-0 rounded-lg mt-3 mb-0 d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle fa-lg mr-3"></i>
                                        <div>Hakuna examination category ya Mkoa iliyowekwa. Tafadhali ongeza Result Title na district iwe empty.</div>
                                    </div>
                                @endif
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
