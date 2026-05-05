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

<div class="modal fade" id="uploadProgressModal" tabindex="-1" role="dialog" aria-labelledby="uploadProgressModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadProgressModalLabel"><i class="fas fa-cloud-upload-alt mr-2"></i> Upload Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeProgressModalBtn" style="display:none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-muted small" id="uploadProgressSummary">Preparing uploads...</div>
                    <div class="text-muted small"><span id="uploadDoneCount">0</span>/<span id="uploadTotalCount">0</span></div>
                </div>
                <div class="progress mb-3" style="height: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="overallProgressBar" role="progressbar" style="width: 0%"></div>
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
                        <tbody id="uploadQueueTableBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cancelUploadsBtn" disabled>Cancel</button>
                <button type="button" class="btn btn-success" id="doneUploadsBtn" style="display:none;">Done</button>
            </div>
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
        const form = $('#bulkUploadForm');

        const progressModal = $('#uploadProgressModal');
        const queueBody = $('#uploadQueueTableBody');
        const overallProgressBar = $('#overallProgressBar');
        const uploadProgressSummary = $('#uploadProgressSummary');
        const uploadDoneCount = $('#uploadDoneCount');
        const uploadTotalCount = $('#uploadTotalCount');
        const cancelUploadsBtn = $('#cancelUploadsBtn');
        const doneUploadsBtn = $('#doneUploadsBtn');
        const closeProgressModalBtn = $('#closeProgressModalBtn');

        const maxConcurrentUploads = 3;

        let uploadQueue = [];
        let doneCount = 0;
        let failedCount = 0;
        let warningList = [];
        let cancelRequested = false;
        let isUploading = false;

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

        function resetUploadState() {
            uploadQueue = [];
            doneCount = 0;
            failedCount = 0;
            warningList = [];
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
                status: 'pending',
                progress: 0,
            }));

            uploadTotalCount.text(uploadQueue.length);
            uploadDoneCount.text('0');
            queueBody.empty();
            uploadQueue.forEach(item => {
                queueBody.append(`
                    <tr id="upload-row-${item.id}">
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
                            <span class="badge badge-secondary" id="upload-status-${item.id}">Pending</span>
                        </td>
                        <td>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" id="upload-bar-${item.id}" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div class="text-muted" style="font-size: 11px;" id="upload-percent-${item.id}">0%</div>
                        </td>
                    </tr>
                `);
            });
        }

        function setRowStatus(id, status, label, badgeClass) {
            $(`#upload-status-${id}`).removeClass('badge-secondary badge-info badge-success badge-danger badge-warning').addClass(badgeClass).text(label);
        }

        function setRowProgress(id, percent) {
            const p = Math.max(0, Math.min(100, percent));
            $(`#upload-bar-${id}`).css('width', `${p}%`);
            $(`#upload-percent-${id}`).text(`${p}%`);
        }

        function updateOverallProgress() {
            const total = uploadQueue.length || 1;
            const overall = Math.round((doneCount / total) * 100);
            overallProgressBar.css('width', `${overall}%`);
            uploadDoneCount.text(doneCount);
        }

        async function uploadSingleFile(queueItem) {
            return new Promise((resolve, reject) => {
                const resultTitleId = $('#result_title_id').val();
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('result_title_id', resultTitleId);
                formData.append('files[]', queueItem.file);

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
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

        async function startUploads() {
            const resultTitleId = $('#result_title_id').val();
            if (!resultTitleId) {
                Swal.fire('Error', 'Please select Result Title first.', 'error');
                return;
            }
            if (!fileInput[0].files || fileInput[0].files.length === 0) {
                Swal.fire('Error', 'Please select PDF files to upload.', 'error');
                return;
            }

            resetUploadState();
            addToQueue(fileInput[0].files);

            cancelUploadsBtn.prop('disabled', false);
            uploadProgressSummary.text(`Uploading (fast mode: ${maxConcurrentUploads} at a time)...`);
            progressModal.modal('show');

            uploadBtn.prop('disabled', true);
            uploadBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...');
            dropZone.css('pointer-events', 'none').css('opacity', '0.6');

            isUploading = true;

            let nextIndex = 0;
            const total = uploadQueue.length;

            const worker = async () => {
                while (nextIndex < total && !cancelRequested) {
                    const item = uploadQueue[nextIndex++];

                    setRowStatus(item.id, 'uploading', 'Uploading', 'badge-info');
                    setRowProgress(item.id, 0);

                    try {
                        const resp = await uploadSingleFile(item);

                        if (resp && resp.errors && resp.errors.length > 0) {
                            warningList = warningList.concat(resp.errors);
                        }

                        setRowStatus(item.id, 'done', 'Done', 'badge-success');
                        setRowProgress(item.id, 100);
                        doneCount++;
                        updateOverallProgress();

                        setTimeout(() => {
                            $(`#upload-row-${item.id}`).fadeOut(250, function() { $(this).remove(); });
                        }, 400);
                    } catch (xhr) {
                        failedCount++;
                        setRowStatus(item.id, 'failed', 'Failed', 'badge-danger');
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                            warningList.push(`${item.file.name}: ${xhr.responseJSON.message}`);
                        } else {
                            warningList.push(`${item.file.name}: Upload failed`);
                        }
                    }
                }
            };

            const workers = [];
            for (let i = 0; i < maxConcurrentUploads; i++) {
                workers.push(worker());
            }
            await Promise.all(workers);

            if (cancelRequested) {
                for (let i = nextIndex; i < uploadQueue.length; i++) {
                    setRowStatus(uploadQueue[i].id, 'canceled', 'Canceled', 'badge-warning');
                }
            }

            isUploading = false;
            cancelUploadsBtn.prop('disabled', true);
            doneUploadsBtn.show();
            closeProgressModalBtn.show();
            uploadProgressSummary.text('Upload finished.');

            dropZone.css('pointer-events', 'auto').css('opacity', '1');
            uploadBtn.prop('disabled', false);
            uploadBtn.html('<i class="fas fa-upload mr-2"></i> Anza Kupakia Sasa');

            if (failedCount > 0) {
                let errorListHtml = '<ul class="text-left small mt-3" style="max-height: 200px; overflow-y: auto;">';
                warningList.slice(0, 10).forEach(err => {
                    errorListHtml += `<li>${err}</li>`;
                });
                if (warningList.length > 10) errorListHtml += `<li>...na mengine ${warningList.length - 10}</li>`;
                errorListHtml += '</ul>';

                Swal.fire({
                    title: 'Upload Imekamilika na Hitilafu',
                    html: `Mafaili <b>${doneCount}</b> yamepakiwa, <b>${failedCount}</b> yamefeli.<br>${errorListHtml}`,
                    icon: 'warning',
                    confirmButtonText: 'Sawa'
                }).then(() => {
                    window.location.href = "{{ route('admin.results.index') }}";
                });
                return;
            }

            if (warningList.length > 0) {
                let warningListHtml = '<ul class="text-left small mt-3" style="max-height: 200px; overflow-y: auto;">';
                warningList.slice(0, 10).forEach(warn => {
                    warningListHtml += `<li>${warn}</li>`;
                });
                if (warningList.length > 10) warningListHtml += `<li>...na mengine ${warningList.length - 10}</li>`;
                warningListHtml += '</ul>';

                Swal.fire({
                    title: 'Yamepakiwa na Onyo',
                    html: `Mafaili <b>${doneCount}</b> yamepakiwa. Baadhi ya mafaili yalikuwa na majina yasiyo sahihi:<br>${warningListHtml}`,
                    icon: 'warning',
                    confirmButtonText: 'Sawa'
                }).then(() => {
                    window.location.href = "{{ route('admin.results.index') }}";
                });
                return;
            }

            Swal.fire({
                title: 'Hongera!',
                text: `Mafaili yote ${doneCount} yamepakiwa kikamilifu.`,
                icon: 'success',
                confirmButtonText: 'Sawa'
            }).then(() => {
                window.location.href = "{{ route('admin.results.index') }}";
            });
        }

        cancelUploadsBtn.on('click', function() {
            if (!isUploading) return;
            cancelRequested = true;
            uploadProgressSummary.text('Cancel requested. Finishing current upload...');
        });

        doneUploadsBtn.on('click', function() {
            progressModal.modal('hide');
        });

        form.on('submit', function(e) {
            e.preventDefault();
            startUploads();
        });
    });
</script>
@endpush
