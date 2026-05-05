@extends('admin.layouts.admin')

@section('title', 'Bulk Upload Results')
@section('page_title', 'Bulk PDF Upload')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('warning_list'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Baadhi ya faili hayajapakiwa:</h5>
                <ul class="mb-0">
                    @foreach(session('warning_list') as $warning)
                        <li>{{ $warning }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i> Maelekezo</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-file-pdf"></i> Format ya Jina la Faili:</h5>
                    <p>Majina ya faili lazima yawe katika mfumo ufuatao:</p>
                    <code>CODE-SCHOOL NAME.pdf</code>
                    <hr>
                    <p class="mb-0"><b>Mfano:</b> S0104-BWIRU BOYS SECONDARY.pdf</p>
                </div>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Automatic School Creation</b> <span class="float-right text-success"><i class="fas fa-check"></i></span>
                        <p class="small text-muted mb-0">Ikiwa shule haipo, mfumo utaisajili yenyewe kwa kutumia Code na Name kutoka kwenye jina la faili.</p>
                    </li>
                    <li class="list-group-item">
                        <b>Multi-file Support</b> <span class="float-right text-success"><i class="fas fa-check"></i></span>
                        <p class="small text-muted mb-0">Unaweza kuchagua PDF nyingi na kuzipakia kwa mkupuo mmoja.</p>
                    </li>
                </ul>
                <a href="{{ route('admin.results.index') }}" class="btn btn-default btn-block"><b>Rudi kwenye Orodha</b></a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-upload mr-2"></i> Pakia Mafaili</h3>
            </div>
            <form action="{{ route('admin.results.bulk-upload') }}" method="POST" enctype="multipart/form-data" id="bulkUploadForm">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="result_title_id">Chagua Jamii ya Matokeo (Result Title) <span class="text-danger">*</span></label>
                        <select name="result_title_id" id="result_title_id" class="form-control select2" style="width: 100%;" required>
                            <option value="">-- Chagua Jamii --</option>
                            @foreach($resultTitles as $title)
                                <option value="{{ $title->id }}">
                                    {{ $title->name }} ({{ $title->year->year }} - {{ $title->level->name }} - {{ $title->region->name }})
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Hapa ndipo mafaili yote utakayochagua yatawekwa.</small>
                    </div>

                    <div class="form-group mt-4">
                        <label for="files">Chagua Mafaili ya PDF (Multiple) <span class="text-danger">*</span></label>
                        <div class="upload-zone p-5 text-center border rounded bg-light" id="drop-zone" style="border: 2px dashed #ccc !important; cursor: pointer;">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <h5>Bonyeza hapa au buruta mafaili (Drag & Drop)</h5>
                            <p class="text-muted">Unaweza kuchagua mafaili mengi ya PDF kwa wakati mmoja</p>
                            <input type="file" name="files[]" id="files" multiple accept=".pdf" class="d-none" required>
                            <div id="file-list-preview" class="mt-3 text-left row" style="max-height: 200px; overflow-y: auto;"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-lg float-right" id="upload-btn" disabled>
                        <i class="fas fa-upload mr-2"></i> Anza Kupakia Sasa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        const dropZone = $('#drop-zone');
        const fileInput = $('#files');
        const fileListPreview = $('#file-list-preview');
        const uploadBtn = $('#upload-btn');

        dropZone.on('click', function() {
            fileInput.click();
        });

        fileInput.on('change', function() {
            handleFiles(this.files);
        });

        dropZone.on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('bg-white');
        });

        dropZone.on('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('bg-white');
        });

        dropZone.on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('bg-white');
            const files = e.originalEvent.dataTransfer.files;
            fileInput[0].files = files;
            handleFiles(files);
        });

        function handleFiles(files) {
            fileListPreview.empty();
            if (files.length > 0) {
                uploadBtn.prop('disabled', false);
                Array.from(files).forEach(file => {
                    const icon = file.name.toLowerCase().endsWith('.pdf') ? 'fa-file-pdf text-danger' : 'fa-file';
                    fileListPreview.append(`
                        <div class="col-md-6 mb-2">
                            <div class="p-2 border rounded bg-white">
                                <i class="fas ${icon} mr-2"></i>
                                <span class="small">${file.name}</span>
                            </div>
                        </div>
                    `);
                });
                $('#drop-zone h5').text(files.length + ' mafaili yamechaguliwa');
            } else {
                uploadBtn.prop('disabled', true);
                $('#drop-zone h5').text('Bonyeza hapa au buruta mafaili (Drag & Drop)');
            }
        }

        $('#bulkUploadForm').on('submit', function() {
            uploadBtn.prop('disabled', true);
            uploadBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Inapakia... Tafadhali subiri');
            dropZone.css('pointer-events', 'none').css('opacity', '0.6');
        });
    });
</script>
@endpush
