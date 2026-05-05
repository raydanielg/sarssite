@extends('landing.layouts.results_layout')

@section('title', 'View Results')

@push('css')
<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        background: #334155;
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
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        z-index: 1000;
    }
    .pdf-content {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 25px;
        background: #334155;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
    .pdf-page-wrapper {
        position: relative;
        background: white;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        margin-bottom: 10px;
        max-width: 100%;
    }
    .pdf-page-canvas {
        display: block;
        max-width: 100%;
        height: auto !important;
    }
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0f172a;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
        border: 1px solid #334155;
    }
    .back-btn:hover {
        background: #1e293b;
        border-color: #475569;
        transform: translateX(-2px);
    }
    .page-indicator {
        background: rgba(0, 0, 0, 0.4);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        backdrop-filter: blur(4px);
    }
    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #1e293b;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        color: white;
        transition: opacity 0.5s ease-out;
    }
    .loader-pulse {
        width: 60px;
        height: 60px;
        background-color: #3b82f6;
        border-radius: 100%;
        animation: pulse 1.2s infinite ease-in-out;
        margin-bottom: 20px;
    }
    @keyframes pulse {
        0% { transform: scale(0); opacity: 0.8; }
        100% { transform: scale(1); opacity: 0; }
    }
    .loading-text {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 12px;
    }
</style>
@endpush

@section('content')
<div id="loading-screen">
    <div class="loader-pulse"></div>
    <p class="loading-text">Rendering High Quality PDF...</p>
</div>

<div class="pdf-viewer-container">
    <div class="pdf-toolbar">
        <a href="javascript:history.back()" class="back-btn">
            <i class="ri-arrow-left-line"></i> <span>RUDI NYUMA</span>
        </a>
        <div id="page-count" class="page-indicator">Loading...</div>
        <div class="hidden md:block">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">NECTA RESULTS VIEWER</span>
        </div>
    </div>
    
    <div id="pdf-render-container" class="pdf-content">
        <!-- High quality pages will be rendered here -->
    </div>
</div>

<script>
    const url = '{{ asset("storage/" . $filePath) }}';
    const container = document.getElementById('pdf-render-container');
    const loadingScreen = document.getElementById('loading-screen');
    const pageCountDisplay = document.getElementById('page-count');

    // High quality rendering configuration
    const scale = window.devicePixelRatio || 2; // Use high resolution scale for crisp text
    const displayScale = 1.5; // Base scale for CSS display

    pdfjsLib.getDocument(url).promise.then(async pdfDoc => {
        const numPages = pdfDoc.numPages;
        pageCountDisplay.textContent = `PAGES: 1 / ${numPages}`;

        const renderPage = async (pageNum) => {
            const page = await pdfDoc.getPage(pageNum);
            const viewport = page.getViewport({ scale: displayScale });
            
            const wrapper = document.createElement('div');
            wrapper.className = 'pdf-page-wrapper animate__animated animate__fadeIn';
            wrapper.id = `page-${pageNum}`;
            
            const canvas = document.createElement('canvas');
            canvas.className = 'pdf-page-canvas';
            const ctx = canvas.getContext('2d', { alpha: false });
            
            // Set high resolution for the canvas
            canvas.width = viewport.width * scale;
            canvas.height = viewport.height * scale;
            
            // Scale the context to draw in high resolution
            ctx.scale(scale, scale);
            
            const renderCtx = {
                canvasContext: ctx,
                viewport: viewport,
                enableWebGL: true,
                intent: 'print' // Using print intent often yields higher quality text
            };
            
            await page.render(renderCtx).promise;
            wrapper.appendChild(canvas);
            container.appendChild(wrapper);
            
            if (pageNum === 1) {
                loadingScreen.style.opacity = '0';
                setTimeout(() => loadingScreen.style.display = 'none', 500);
            }
        };

        // Render first page immediately for perceived speed
        await renderPage(1);

        // Sequentially render the rest of the pages to avoid browser hanging
        for (let i = 2; i <= numPages; i++) {
            await renderPage(i);
            pageCountDisplay.textContent = `PAGES: ${i} / ${numPages}`;
        }

    }).catch(err => {
        console.error('PDF Load Error:', err);
        loadingScreen.innerHTML = `
            <i class="ri-error-warning-line text-4xl text-red-500 mb-4"></i>
            <p class="text-red-400 font-bold px-10 text-center">FILE HALIPATIKANI AU LINA SHIDA.</p>
            <a href="javascript:history.back()" class="mt-4 back-btn">RUDI NYUMA</a>
        `;
    });

    // Simple scroll tracker for page numbers
    container.addEventListener('scroll', () => {
        const wrappers = document.querySelectorAll('.pdf-page-wrapper');
        let currentPage = 1;
        
        wrappers.forEach((wrapper, index) => {
            const rect = wrapper.getBoundingClientRect();
            if (rect.top <= window.innerHeight / 2) {
                currentPage = index + 1;
            }
        });
        
        const total = wrappers.length;
        if (total > 0) {
            pageCountDisplay.textContent = `PAGES: ${currentPage} / ${total}`;
        }
    });
</script>
@endsection

