@extends('admin.layouts.admin')

@section('title', 'Upload Summary ya Wilaya')
@section('page_title', 'Upload Summary ya Wilaya')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-primary shadow border-0 rounded-lg overflow-hidden">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                <h3 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-map-pin mr-2"></i> Upload Summary ya Wilaya
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.result-summaries.index', ['type' => 'district']) }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
            <form action="{{ route('admin.district-summaries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 rounded-lg d-flex align-items-center">
                        <i class="fas fa-info-circle fa-lg mr-3 text-info"></i>
                        <div>
                            Hii sehemu ni kwa ajili ya <strong>Summary za Wilaya</strong> tu. Kwa summary za Mkoa tumia <a href="{{ route('admin.region-summaries.create') }}" class="alert-link font-weight-bold">page ya Mkoa</a>.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="district_id">Chagua Wilaya <span class="text-danger">*</span></label>
                        <select name="district_id" id="district_id" class="form-control select2" required>
                            <option value="">-- Chagua Wilaya --</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }} ({{ $district->region->name }})</option>
                            @endforeach
                        </select>
                        @if($districts->isEmpty())
                            <small class="text-danger d-block mt-2">
                                <i class="fas fa-exclamation-triangle"></i> Hakuna wilaya iliowekwa kwenye examination categories. Tafadhali ongeza Result Title na district ilichaguliwa.
                            </small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="result_title_id">Examination Category <span class="text-danger">*</span></label>
                        <select name="result_title_id" id="result_title_id" class="form-control select2 @error('result_title_id') is-invalid @enderror" required disabled>
                            <option value="">-- Chagua Wilaya kwanza --</option>
                        </select>
                        @error('result_title_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Summary Display Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Matokeo ya Wilaya - Mock 2026" required>
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
                <div class="card-footer bg-light text-right py-3 border-top">
                    <a href="{{ route('admin.result-summaries.index', ['type' => 'district']) }}" class="btn btn-default rounded-pill px-4 mr-2">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                        <i class="fas fa-save mr-1"></i> Save Summary ya Wilaya
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

    $('#district_id').on('change', function() {
        const districtId = $(this).val();
        const titleSelect = $('#result_title_id');

        if (!districtId) {
            titleSelect.empty().append('<option value="">-- Chagua Wilaya kwanza --</option>').prop('disabled', true);
            return;
        }

        titleSelect.prop('disabled', true).empty().append('<option value="">Inatafuta...</option>');

        $.ajax({
            url: '{{ route("admin.district-summaries.titles-by-district", ":id") }}'.replace(':id', districtId),
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
                    titleSelect.append('<option value="">Hakuna mtihani wa wilaya hii</option>').prop('disabled', true);
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
