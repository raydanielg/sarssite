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

<div class="modal fade" id="summaryUploadProgressModal" tabindex="-1" role="dialog" aria-labelledby="summaryUploadProgressModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summaryUploadProgressModalLabel"><i class="fas fa-cloud-upload-alt mr-2"></i> Upload Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeSummaryProgressModalBtn" style="display:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-muted small" id="summaryUploadProgressSummary">Preparing uploads...</div>
                    <div class="text-muted small"><span id="summaryUploadDoneCount">0</span>/<span id="summaryUploadTotalCount">0</span></div>
                </div>
                <div class="progress mb-3" style="height: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="summaryOverallProgressBar" role="progressbar" style="width: 0%"></div>
                </div>

                <div class="table-responsive" style="max-height: 360px; overflow-y: auto;">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>File</th>
                                <th style="width: 140px;">Status</th>
                                <th style="width: 220px;">Progress</th>
                            </tr>
                        </thead>
                        <tbody id="summaryUploadQueueTableBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cancelSummaryUploadsBtn" disabled>Cancel</button>
                <button type="button" class="btn btn-success" id="doneSummaryUploadsBtn" style="display:none;">Done</button>
            </div>
        </div>
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
    const bulkUploadForm = $('#bulkUploadForm');

    const progressModal = $('#summaryUploadProgressModal');
    const queueBody = $('#summaryUploadQueueTableBody');
    const overallProgressBar = $('#summaryOverallProgressBar');
    const uploadProgressSummary = $('#summaryUploadProgressSummary');
    const uploadDoneCount = $('#summaryUploadDoneCount');
    const uploadTotalCount = $('#summaryUploadTotalCount');
    const cancelUploadsBtn = $('#cancelSummaryUploadsBtn');
    const doneUploadsBtn = $('#doneSummaryUploadsBtn');
    const closeProgressModalBtn = $('#closeSummaryProgressModalBtn');

    const maxConcurrentUploads = 3;

    let uploadQueue = [];
    let doneCount = 0;
    let failedCount = 0;
    let cancelRequested = false;
    let isUploading = false;

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

    function resetUploadState() {
        uploadQueue = [];
        doneCount = 0;
        failedCount = 0;
        cancelRequested = false;
        isUploading = false;
        queueBody.empty();
        overallProgressBar.css('width', '0%');
        uploadDoneCount.text('0');
        uploadTotalCount.text('0');
        uploadProgressSummary.text('Preparing uploads...');
        doneUploadsBtn.hide();
        closeProgressModalBtn.hide();
        cancelUploadsBtn.prop('disabled', true);
    }

    function bytesToMB(bytes) {
        return (bytes / 1024 / 1024).toFixed(2);
    }

    function addToQueue(files) {
        uploadQueue = Array.from(files).map((file, idx) => ({
            id: idx,
            file,
        }));

        uploadTotalCount.text(uploadQueue.length);
        uploadDoneCount.text('0');
        queueBody.empty();

        uploadQueue.forEach(item => {
            queueBody.append(`
                <tr id="summary-upload-row-${item.id}">
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf text-danger mr-2"></i>
                            <div>
                                <div class="font-weight-bold" style="font-size: 12px;">${item.file.name}</div>
                                <div class="text-muted" style="font-size: 11px;">${bytesToMB(item.file.size)} MB</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-secondary" id="summary-upload-status-${item.id}">Pending</span>
                    </td>
                    <td>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" id="summary-upload-bar-${item.id}" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="text-muted" style="font-size: 11px;" id="summary-upload-percent-${item.id}">0%</div>
                    </td>
                </tr>
            `);
        });
    }

    function setRowStatus(id, label, badgeClass) {
        $(`#summary-upload-status-${id}`).removeClass('badge-secondary badge-info badge-success badge-danger badge-warning').addClass(badgeClass).text(label);
    }

    function setRowProgress(id, percent) {
        const p = Math.max(0, Math.min(100, percent));
        $(`#summary-upload-bar-${id}`).css('width', `${p}%`);
        $(`#summary-upload-percent-${id}`).text(`${p}%`);
    }

    function updateOverallProgress() {
        const total = uploadQueue.length || 1;
        const overall = Math.round((doneCount / total) * 100);
        overallProgressBar.css('width', `${overall}%`);
        uploadDoneCount.text(doneCount);
    }

    function uploadSingleFile(queueItem) {
        return new Promise((resolve, reject) => {
            const resultTitleId = $('#result_title_id').val();
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('result_title_id', resultTitleId);
            formData.append('files[]', queueItem.file);

            $.ajax({
                url: "{{ route('admin.result-summaries.bulk-upload') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            const percent = Math.round((e.loaded / e.total) * 100);
                            setRowProgress(queueItem.id, percent);
                        }
                    });
                    return xhr;
                },
                success: function(resp) {
                    resolve(resp);
                },
                error: function(xhr) {
                    reject(xhr);
                }
            });
        });
    }

    async function startUploadsFast() {
        const resultTitleId = $('#result_title_id').val();
        if (!resultTitleId) {
            Swal.fire('Error', 'Please select Examination Category first.', 'error');
            return;
        }
        if (selectedFiles.length === 0) {
            Swal.fire('Error', 'Please select files to upload', 'error');
            return;
        }

        resetUploadState();
        addToQueue(selectedFiles);

        cancelUploadsBtn.prop('disabled', false);
        uploadProgressSummary.text(`Uploading (fast mode: ${maxConcurrentUploads} at a time)...`);
        progressModal.modal('show');

        const uploadBtn = $('#uploadBtn');
        uploadBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Uploading...');
        isUploading = true;

        let nextIndex = 0;
        const total = uploadQueue.length;

        const worker = async () => {
            while (nextIndex < total && !cancelRequested) {
                const current = uploadQueue[nextIndex++];
                setRowStatus(current.id, 'Uploading', 'badge-info');
                setRowProgress(current.id, 0);

                try {
                    await uploadSingleFile(current);
                    setRowStatus(current.id, 'Done', 'badge-success');
                    setRowProgress(current.id, 100);
                    doneCount++;
                    updateOverallProgress();
                    setTimeout(() => {
                        $(`#summary-upload-row-${current.id}`).fadeOut(250, function() { $(this).remove(); });
                    }, 350);
                } catch (xhr) {
                    failedCount++;
                    setRowStatus(current.id, 'Failed', 'badge-danger');
                    if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                        console.error(xhr.responseJSON.message);
                    }
                }
            }
        };

        const workers = [];
        for (let i = 0; i < maxConcurrentUploads; i++) {
            workers.push(worker());
        }
        await Promise.all(workers);

        isUploading = false;
        cancelUploadsBtn.prop('disabled', true);
        doneUploadsBtn.show();
        closeProgressModalBtn.show();
        uploadProgressSummary.text('Upload finished.');

        uploadBtn.prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Start Bulk Upload');

        if (failedCount > 0) {
            Swal.fire('Completed with errors', `${doneCount} uploaded, ${failedCount} failed.`, 'warning');
            return;
        }

        Swal.fire({
            title: 'Success!',
            text: `${doneCount} summaries uploaded successfully.`,
            icon: 'success'
        }).then(() => {
            window.location.href = "{{ route('admin.result-summaries.index') }}";
        });
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
        startUploadsFast();
    });

    cancelUploadsBtn.on('click', function() {
        if (!isUploading) return;
        cancelRequested = true;
        uploadProgressSummary.text('Cancel requested. Finishing current uploads...');
    });

    doneUploadsBtn.on('click', function() {
        progressModal.modal('hide');
    });
});
</script>
@endpush
@endsection
