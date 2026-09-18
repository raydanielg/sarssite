@extends('admin.layouts.admin')

@section('title', 'Bulk Upload Summaries za Mikoa')
@section('page_title', 'Bulk Upload Summaries za Mikoa')

@section('content')
<div class="card card-outline card-success shadow border-0 rounded-lg overflow-hidden">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-layer-group mr-2"></i> Bulk Upload Summaries za Mikoa
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.result-summaries.index', ['type' => 'region']) }}" class="btn btn-light btn-sm rounded-pill shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="alert alert-info border-0 rounded-lg d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg mr-3 text-info"></i>
            <div>
                Hii sehemu ni kwa ajili ya <strong>Summary za Mikoa</strong> tu. Kwa summary za Wilaya tumia <a href="{{ route('admin.district-summaries.bulk-form') }}" class="alert-link font-weight-bold">page ya Wilaya</a>.
            </div>
        </div>

        <form id="bulkUploadForm">
            @csrf
            <!-- Step 1: Region Selection Card -->
            <div class="exam-selector-card rounded-lg border shadow-sm mb-4 overflow-hidden">
                <div class="exam-selector-header px-4 py-3 text-white d-flex align-items-center" style="background: linear-gradient(135deg, #6c5ce7 0%, #4834d4 100%);">
                    <div class="step-number mr-3 d-flex align-items-center justify-content-center rounded-circle bg-white text-dark font-weight-bold" style="width: 32px; height: 32px; font-size: 1rem;">1</div>
                    <div>
                        <h5 class="font-weight-bold mb-0">Chagua Mkoa</h5>
                        <small class="text-white-50">Chagua mkoa ambapo summaries zitapakiwa</small>
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
                        <small class="text-white-50">Chagua category ya mtihani ambapo summaries zitapakiwa</small>
                    </div>
                </div>
                <div class="p-4 bg-white">
                    <div class="form-group mb-0">
                        <label for="result_title_id" class="font-weight-bold text-muted small text-uppercase mb-2">
                            <i class="fas fa-tag mr-1 text-primary"></i> Examination Category <span class="text-danger">*</span>
                        </label>
                        <select name="result_title_id" id="result_title_id" class="form-control form-control-lg select2 shadow-sm" required disabled>
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
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div id="dropzone" class="dropzone-area border-dashed rounded-lg p-5 text-center bg-light">
                    <i class="fas fa-cloud-upload-alt fa-4x text-success mb-3"></i>
                    <h5 class="font-weight-bold">Drag and drop PDF files here</h5>
                    <p class="text-muted small text-uppercase font-weight-bold">OR</p>
                    <input type="file" id="fileInput" name="files[]" multiple accept=".pdf" class="d-none">
                    <button type="button" class="btn btn-success px-5 rounded-pill shadow-sm" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-folder-open mr-1"></i> Select PDF Files
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
    .dropzone-area:hover, .dropzone-area.dragover { border-color: #38a169; background-color: #f0fff4; transform: scale(1.01); }
    .dropzone-area i { transition: transform 0.3s; }
    .dropzone-area:hover i { transform: translateY(-4px); }

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
    let selectedFiles = [];
    const fileInput = $('#fileInput');
    const previewContainer = $('#filePreviewContainer');
    const previewBody = $('#filePreviewBody');
    const dropzone = $('#dropzone');
    const bulkUploadForm = $('#bulkUploadForm');

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
            url: "{{ route('admin.region-summaries.titles-by-region', ':id') }}".replace(':id', regionId),
            type: 'GET',
            success: function(data) {
                titleSelect.empty();
                if (data.length > 0) {
                    titleSelect.append('<option value="">-- Chagua Mtihani --</option>');
                    data.forEach(function(item) {
                        titleSelect.append('<option value="' + item.id + '" data-year="' + item.year + '" data-level="' + item.level + '" data-region="' + item.region + '" data-region-id="' + regionId + '">' + item.name + '</option>');
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
                    url: "{{ route('admin.region-summaries.districts-by-region', ':id') }}".replace(':id', regionId),
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
                url: "{{ route('admin.region-summaries.bulk-upload') }}",
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
            text: `${doneCount} region summaries uploaded successfully.`,
            icon: 'success'
        }).then(() => {
            window.location.href = "{{ route('admin.result-summaries.index', ['type' => 'region']) }}";
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
