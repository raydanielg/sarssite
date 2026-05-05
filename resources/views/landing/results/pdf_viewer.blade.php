@extends('landing.layouts.results_layout')

@section('title', 'View Results')

@push('css')
<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        background: #525659;
        overflow: hidden;
    }
    .pdf-viewer-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }
    .pdf-toolbar {
        background: #1e293b;
        color: white;
        padding: 8px 15px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        z-index: 1000;
    }
    .pdf-content {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        background: #525659;
        -webkit-overflow-scrolling: touch;
    }
    .pdf-page-canvas {
        box-shadow: 0 0 15px rgba(0,0,0,0.5);
        max-width: 100%;
        background: white;
    }
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #334155;
        color: white;
        padding: 6px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        transition: all 0.2s;
    }
    .back-btn:hover {
        background: #475569;
    }
    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(30, 41, 59, 0.9);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        color: white;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div id="loading-screen">
    <div class="spinner"></div>
    <p class="text-sm font-bold uppercase tracking-widest">Loading Results...</p>
</div>

<div class="pdf-viewer-container">
    <div class="pdf-toolbar">
        <a href="javascript:history.back()" class="back-btn">
            <i class="ri-arrow-left-line"></i> <span>Back</span>
        </a>
    </div>
    
    <div id="pdf-render-container" class="pdf-content">
        <!-- The PDF.js renderer will append canvases here -->
    </div>
</div>

<script>
    const url = '{{ asset("storage/" . $filePath) }}';
    const container = document.getElementById('pdf-render-container');
    const loadingScreen = document.getElementById('loading-screen');

    pdfjsLib.getDocument(url).promise.then(pdfDoc => {
        const renderAllPages = async () => {
            // Determine scale based on screen width for better initial fit
            const initialScale = window.innerWidth < 768 ? 1.0 : 1.5;

            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                const page = await pdfDoc.getPage(pageNum);
                const viewport = page.getViewport({ scale: initialScale });
                
                const canvas = document.createElement('canvas');
                canvas.className = 'pdf-page-canvas animate__animated animate__fadeIn mb-4';
                const ctx = canvas.getContext('2d');
                
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                
                const renderCtx = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                
                await page.render(renderCtx).promise;
                container.appendChild(canvas);
                
                if (pageNum === 1) {
                    loadingScreen.style.opacity = '0';
                    setTimeout(() => loadingScreen.style.display = 'none', 500);
                }
            }
        };

        renderAllPages().catch(err => {
            console.error('Render Error:', err);
            loadingScreen.innerHTML = '<p class="text-red-400">Error rendering pages.</p>';
        });

    }).catch(err => {
        console.error('PDF.js Error:', err);
        loadingScreen.innerHTML = '<p class="text-red-400 font-bold uppercase tracking-widest text-xs px-10 text-center">Failed to load PDF. The file might be missing or inaccessible.</p>';
    });
</script>
@endsection
