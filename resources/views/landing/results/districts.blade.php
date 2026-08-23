@extends('landing.layouts.results_layout')

@section('title', $region->name . ' - Wilaya')

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
        <a href="{{ route('results.year', $yearData->year) }}" class="results-link inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-[#1e293b] text-xs sm:text-sm font-bold rounded-lg transition-all group">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Back to Regions
        </a>
        <div class="flex items-center gap-1 text-[10px] sm:text-xs font-bold text-gray-500 px-3 py-1.5">
            <span>{{ $yearData->year }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-[#1f7a35]">{{ $region->name }}</span>
        </div>
    </div>
    <div class="animate__animated animate__fadeInDown">
        <h1 class="text-xl sm:text-3xl font-bold text-[#1e293b] tracking-tight inline-block">
            {{ $region->name }} - Chagua Wilaya
        </h1>
    </div>
</div>

<section class="pt-32 pb-12 sm:py-24 min-h-screen overflow-hidden">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="results-card p-6 sm:p-8 animate__animated animate__fadeInUp">

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
                <div class="text-center mb-6">
                    <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Chagua Wilaya (District) ili kuona matokeo</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
                    @forelse($districts as $index => $district)
                        <a href="{{ route('results.titles', [$yearData->year, $region->slug, $district->slug]) }}"
                           class="group bg-gray-50 p-4 sm:p-5 rounded-xl border border-gray-100 hover:bg-green-600 hover:border-green-600 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate__animated animate__fadeInUp"
                           style="animation-delay: {{ $index * 0.03 }}s">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-white/20 transition-colors mb-2">
                                    <i class="ri-map-pin-2-line text-xl text-green-600 group-hover:text-white transition-colors"></i>
                                </div>
                                <h3 class="text-xs sm:text-sm font-bold text-[#1e293b] group-hover:text-white transition-colors leading-tight">
                                    {{ $district->name }}
                                </h3>
                                <div class="mt-2 text-[10px] font-bold text-[#1f7a35] group-hover:text-white/80 uppercase tracking-tighter transition-colors">
                                    Mitihani
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12 animate__animated animate__fadeIn">
                            <i class="ri-map-2-line text-5xl text-gray-300 mb-3"></i>
                            <p class="text-gray-400 font-bold uppercase tracking-widest italic text-xs">Hakuna Wilaya zilizopatikana.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Summaries Tab -->
            @if($regionSummaries->isNotEmpty())
            <div id="summaries-content" class="hidden">
                <div class="text-center mb-6">
                    <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Summary za Mkoa wa {{ $region->name }} - {{ $yearData->year }}</p>
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
