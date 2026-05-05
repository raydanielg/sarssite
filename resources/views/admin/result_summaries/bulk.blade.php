@extends('admin.layouts.admin')

@section('title', 'Bulk Upload Summaries')
@section('page_title', 'Bulk Upload Result Summaries')

@section('content')
<div class="card card-outline card-primary shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h3 class="card-title font-weight-bold">
            <i class="fas fa-layer-group mr-2 text-primary"></i> Bulk Upload PDFs
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.result-summaries.index') }}" class="btn btn-default btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <form id="bulkUploadForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="result_title_id">Target Examination Category</label>
                        <select name="result_title_id" id="result_title_id" class="form-control select2 shadow-sm" required>
                            <option value="">-- Select Examination --</option>
                            @foreach($resultTitles as $title)
                                <option value="{{ $title->id }}">{{ $title->year->year }} - {{ $title->level->name }} - {{ $title->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">All uploaded files will be linked to this exam category.</small>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div id="dropzone" class="dropzone-area border-dashed rounded-lg p-5 text-center bg-light">
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <h5>Drag and drop PDF files here</h5>
                    <p class="text-muted small text-uppercase font-weight-bold">OR</p>
                    <input type="file" id="fileInput" name="files[]" multiple accept=".pdf" class="d-none">
                    <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm" onclick="document.getElementById('fileInput').click()">
                        Select PDF Files
                    </button>
                    <div class="mt-3 text-muted small">Max file size: 50MB per PDF</div>
                </div>
            </div>

            <div id="filePreviewContainer" class="mt-4 d-none">
                <h6 class="font-weight-bold mb-3">Selected Files (<span id="fileCount">0</span>)</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover border">
                        <thead class="bg-light small font-weight-bold text-muted">
                            <tr>
                                <th>File Name (System will use this as Summary Name)</th>
                                <th style="width: 100px">Size</th>
                                <th style="width: 80px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="filePreviewBody"></tbody>
                    </table>
                </div>
                
                <div class="text-right mt-4">
                    <button type="button" id="clearBtn" class="btn btn-default mr-2">Clear All</button>
                    <button type="submit" id="uploadBtn" class="btn btn-success px-5 shadow-sm">
                        <i class="fas fa-upload mr-1"></i> Start Bulk Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .dropzone-area { border: 2px dashed #cbd5e0; transition: all 0.3s; cursor: pointer; }
    .dropzone-area:hover, .dropzone-area.dragover { border-color: #3182ce; background-color: #ebf8ff; }
</style>

@push('js')
<script>
$(document).ready(function() {
    let selectedFiles = [];
    const fileInput = $('#fileInput');
    const previewContainer = $('#filePreviewContainer');
    const previewBody = $('#filePreviewBody');
    const dropzone = $('#dropzone');

    fileInput.on('change', function() {
        handleFiles(this.files);
    });

    dropzone.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    }).on('dragleave', function() {
        $(this).removeClass('dragover');
    }).on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        handleFiles(e.originalEvent.dataTransfer.files);
    });

    function handleFiles(files) {
        Array.from(files).forEach(file => {
            if (file.type === 'application/pdf') {
                selectedFiles.push(file);
            }
        });
        updatePreview();
    }

    function updatePreview() {
        if (selectedFiles.length > 0) {
            previewContainer.removeClass('d-none');
            $('#fileCount').text(selectedFiles.length);
            previewBody.empty();
            selectedFiles.forEach((file, index) => {
                previewBody.append(`
                    <tr>
                        <td><input type="text" class="form-control form-control-sm border-0 bg-transparent" value="${file.name.replace('.pdf', '')}" readonly></td>
                        <td>${(file.size / 1024 / 1024).toFixed(2)} MB</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link text-danger p-0" onclick="removeFile(${index})">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        } else {
            previewContainer.addClass('d-none');
        }
    }

    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updatePreview();
    };

    $('#clearBtn').on('click', function() {
        selectedFiles = [];
        updatePreview();
    });

    $('#bulkUploadForm').on('submit', function(e) {
        e.preventDefault();
        
        if (selectedFiles.length === 0) {
            Swal.fire('Error', 'Please select files to upload', 'error');
            return;
        }

        const formData = new FormData(this);
        formData.delete('files[]');
        selectedFiles.forEach(file => formData.append('files[]', file));

        const uploadBtn = $('#uploadBtn');
        uploadBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Uploading...');

        $.ajax({
            url: "{{ route('admin.result-summaries.bulk-upload') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success'
                }).then(() => {
                    window.location.href = "{{ route('admin.result-summaries.index') }}";
                });
            },
            error: function(xhr) {
                uploadBtn.prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Start Bulk Upload');
                const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error uploading files';
                Swal.fire('Failed', msg, 'error');
            }
        });
    });
});
</script>
@endpush
@endsection
