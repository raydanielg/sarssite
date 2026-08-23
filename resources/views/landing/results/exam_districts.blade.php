@extends('landing.layouts.results_layout')

@section('title', $examName . ' ' . $yearData->year . ' ' . $region->name . ' - Chagua Wilaya')

@push('css')
<style>
    .tab-btn {
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
    }
    .tab-btn.active {
        background: #1f7a35;
        color: #fff;
        border-bottom-color: #145524;
    }
    .summary-card {
        transition: all 0.3s;
    }
    .summary-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="breadcrumb-bar fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2">
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('results.exam_regions', [$examSlug, $yearData->year]) }}" class="results-link inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-[#1e293b] text-xs sm:text-sm font-bold rounded-lg transition-all group">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Rudi Mikoa
        </a>
        <div class="flex items-center gap-1 text-[10px] sm:text-xs font-bold text-gray-500 px-3 py-1.5">
            <span class="text-[#1f7a35]">{{ $examName }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span>{{ $yearData->year }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-blue-700">{{ $region->name }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-gray-400">Chagua Wilaya</span>
        </div>
    </div>
</div>

<section class="pt-24 pb-12 sm:pt-32 min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <h2 class="text-xl sm:text-2xl font-black text-[#1e293b]">{{ $region->name }} - Wilaya</h2>
            <p class="text-xs text-gray-400 mt-2 uppercase tracking-widest font-bold">{{ $examName }} {{ $yearData->year }}</p>
        </div>

        <div class="results-card max-w-5xl mx-auto p-6 sm:p-8 animate__animated animate__fadeInUp">

            <!-- Tabs -->
            <div class="text-center mb-8">
                <div class="flex justify-center gap-2 mb-6">
                    <button onclick="switchTab('districts')" id="districts-tab-btn" class="tab-btn active px-6 py-2 bg-white border border-gray-300 font-black text-[13px] uppercase shadow-sm">
                        <i class="ri-map-pin-line mr-1"></i> Wilaya
                    </button>
                    @if($regionSummaries->isNotEmpty())
                    <button onclick="switchTab('summaries')" id="summaries-tab-btn" class="tab-btn px-6 py-2 bg-white border border-gray-300 font-black text-[13px] uppercase shadow-sm">
                        <i class="ri-file-list-3-line mr-1"></i> Summary za Mkoa
                    </button>
                    @endif
                </div>
            </div>

            <!-- Districts Tab -->
            <div id="districts-content">
                @if($districts->isNotEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-4">
                        @foreach($districts as $index => $district)
                            <a href="{{ route('results.exam_final', [$examSlug, $yearData->year, $region->slug, $district->slug]) }}"
                               class="group bg-gray-50 p-4 sm:p-5 rounded-xl border border-gray-100 hover:border-[#1f7a35] hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInUp text-center"
                               style="animation-delay: {{ $index * 0.05 }}s">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-600 transition-colors mb-2">
                                        <i class="ri-map-pin-2-line text-xl text-green-600 group-hover:text-white transition-colors"></i>
                                    </div>
                                    <h3 class="text-sm font-black text-[#1e293b] group-hover:text-[#1f7a35] transition-colors">
                                        {{ $district->name }}
                                    </h3>
                                    <div class="mt-1 text-[10px] font-bold text-[#1f7a35] uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">
                                        Ona Matokeo <i class="ri-arrow-right-line"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 animate__animated animate__fadeIn">
                        <i class="ri-map-2-line text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Hakuna wilaya iliyopatikana.</p>
                    </div>
                @endif
            </div>

            <!-- Summaries Tab -->
            @if($regionSummaries->isNotEmpty())
            <div id="summaries-content" class="hidden">
                <div class="text-center mb-6">
                    <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Summary za Mkoa wa {{ $region->name }} - {{ $examName }} {{ $yearData->year }}</p>
                </div>
                <div class="max-w-3xl mx-auto space-y-3">
                    @foreach($regionSummaries as $summary)
                        <div class="summary-card bg-white border border-gray-200 rounded-xl overflow-hidden animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.05 }}s">
                            <div class="flex items-center justify-between p-4 sm:p-5">
                                <div class="flex items-center gap-3 min-w-0 flex-1">
                                    <div class="w-11 h-11 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                                        <i class="ri-file-pdf-fill text-2xl text-red-600"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-sm sm:text-base font-black text-[#1e293b] truncate">{{ strtoupper($summary->name) }}</h3>
                                        <span class="text-[10px] font-bold text-[#1f7a35] uppercase tracking-tighter">Summary ya Mkoa</span>
                                    </div>
                                </div>
                                <a href="{{ route('results.view_pdf', ['file' => $summary->file_path, 'name' => $summary->name]) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-all duration-300 shadow-sm hover:shadow-md flex-shrink-0 ml-3">
                                    <i class="ri-eye-line"></i> View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</section>

<script>
    function switchTab(tab) {
        const districtsBtn = document.getElementById('districts-tab-btn');
        const summariesBtn = document.getElementById('summaries-tab-btn');
        const districtsContent = document.getElementById('districts-content');
        const summariesContent = document.getElementById('summaries-content');

        if (tab === 'districts') {
            districtsBtn.classList.add('active');
            if (summariesBtn) summariesBtn.classList.remove('active');
            districtsContent.classList.remove('hidden');
            if (summariesContent) summariesContent.classList.add('hidden');
        } else {
            if (summariesBtn) summariesBtn.classList.add('active');
            districtsBtn.classList.remove('active');
            districtsContent.classList.add('hidden');
            if (summariesContent) summariesContent.classList.remove('hidden');
        }
    }
</script>
@endsection
