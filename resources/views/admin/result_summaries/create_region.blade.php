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
                        <i class="fas fa-info-circle mr-1"></i> Hii sehemu ni kwa ajili ya <strong>Summary za Mkoa</strong> tu. Kwa summary za Wilaya tumia <a href="{{ route('admin.district-summaries.create') }}" class="alert-link">page ya Wilaya</a>.
                    </div>

                    <div class="form-group">
                        <label for="region_id">Chagua Mkoa <span class="text-danger">*</span></label>
                        <select name="region_id" id="region_id" class="form-control select2" required>
                            <option value="">-- Chagua Mkoa --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                        @if($regions->isEmpty())
                            <small class="text-danger d-block mt-2">
                                <i class="fas fa-exclamation-triangle"></i> Hakuna mkoa uliowekwa kwenye examination categories. Tafadhali ongeza Result Title na district iwe empty.
                            </small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="result_title_id">Examination Category <span class="text-danger">*</span></label>
                        <select name="result_title_id" id="result_title_id" class="form-control select2 @error('result_title_id') is-invalid @enderror" required disabled>
                            <option value="">-- Chagua Mkoa kwanza --</option>
                        </select>
                        @error('result_title_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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

    $('#region_id').on('change', function() {
        const regionId = $(this).val();
        const titleSelect = $('#result_title_id');

        if (!regionId) {
            titleSelect.empty().append('<option value="">-- Chagua Mkoa kwanza --</option>').prop('disabled', true);
            return;
        }

        titleSelect.prop('disabled', true).empty().append('<option value="">Inatafuta...</option>');

        $.ajax({
            url: '{{ route("admin.region-summaries.titles-by-region", ":id") }}'.replace(':id', regionId),
            type: 'GET',
            success: function(data) {
                titleSelect.empty();
                if (data.length > 0) {
                    titleSelect.append('<option value="">-- Chagua Mtihani --</option>');
                    data.forEach(function(item) {
                        titleSelect.append('<option value="' + item.id + '">' + item.text + '</option>');
                    });
                    titleSelect.prop('disabled', false);
                } else {
                    titleSelect.append('<option value="">Hakuna mtihani wa mkoa huu</option>').prop('disabled', true);
                }
            },
            error: function() {
                titleSelect.empty().append('<option value="">Hitilafu imetokea. Jaribu tena.</option>').prop('disabled', true);
            }
        });
    });
});
</script>
@endpush
@endsection
