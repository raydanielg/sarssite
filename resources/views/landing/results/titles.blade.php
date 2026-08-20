@extends('landing.layouts.results_layout')

@section('title', 'Examinations - ' . $yearData->year . ' - ' . $district->name)

@section('content')
<div class="breadcrumb-bar fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2 no-print">
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('results.districts', [$yearData->year, $region->slug]) }}" class="results-link inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-[#1e293b] text-xs sm:text-sm font-bold rounded-lg transition-all group">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Back to Wilaya
        </a>
        <div class="flex items-center gap-1 text-[10px] sm:text-xs font-bold text-gray-500 px-3 py-1.5">
            <span>{{ $yearData->year }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-[#1f7a35]">{{ $region->name }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-blue-700">{{ $district->name }}</span>
        </div>
    </div>
    <div class="animate__animated animate__fadeInDown">
        <h1 class="text-xl sm:text-3xl font-bold text-[#1e293b] tracking-tight inline-block leading-tight">
            {{ $district->name }} - Mitihani
        </h1>
    </div>
</div>

<section class="pt-32 pb-12 sm:py-24 min-h-screen flex items-center justify-center overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="results-card p-6 sm:p-8 animate__animated animate__fadeInUp">
            <div class="text-center mb-8">
                <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Select an examination to view results</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 max-w-6xl mx-auto">
                @forelse($resultTitles as $index => $title)
                    <a href="{{ route('results.final', [$yearData->year, $region->slug, $district->slug, $title->slug]) }}" 
                       class="group bg-gray-50 p-5 sm:p-6 rounded-xl border border-gray-100 hover:border-[#1f7a35] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate__animated animate__fadeInUp"
                       style="animation-delay: {{ $index * 0.05 }}s">
                        <div class="flex items-center gap-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm sm:text-base font-bold text-[#1e293b] truncate group-hover:text-[#1f7a35] transition-colors">
                                    {{ $title->name }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-bold text-[#1f7a35] uppercase tracking-tighter">
                                        Published
                                    </span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                        • {{ $title->results_count }} Centres
                                    </span>
                                </div>
                            </div>
                            <div class="text-gray-300 group-hover:text-[#1f7a35] transition-colors">
                                <i class="ri-arrow-right-s-line text-2xl"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12 animate__animated animate__fadeIn">
                        <p class="text-gray-400 font-bold uppercase tracking-widest italic text-xs">Hakuna Mitihani iliyopatikana kwa sasa.</p>
                    </div>
                @endforelse
            </div>

            @if($districtSummaries->isNotEmpty())
            <div class="border-t border-gray-200 pt-8 mt-10 animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm sm:text-lg font-black text-[#1e293b] uppercase tracking-wider">
                        Summary za Wilaya - {{ $district->name }}
                    </h2>
                    <span class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase">Muhtasari wa Matokeo ya Wilaya</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    @foreach($districtSummaries as $summary)
                        <a href="{{ route('results.view_pdf', ['file' => $summary->file_path, 'name' => $summary->name]) }}"
                           class="group flex items-center gap-3 bg-gray-50 border border-gray-100 rounded-xl p-4 hover:border-[#1f7a35] hover:shadow-md transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                                <i class="ri-file-pdf-fill text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-bold text-[#1e293b] group-hover:text-[#1f7a35] transition-colors truncate">
                                    {{ strtoupper($summary->name) }}
                                </h3>
                                <span class="text-[10px] font-bold text-[#1f7a35] uppercase tracking-tighter">View PDF</span>
                            </div>
                            <i class="ri-arrow-right-s-line text-gray-300 group-hover:text-[#1f7a35] text-xl"></i>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
