@extends('landing.layouts.results_layout')

@section('title', 'Examinations - ' . $yearData->year . ' - ' . $district->name)

@section('content')
<div class="fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2 no-print">
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('results.districts', [$yearData->year, $region->slug]) }}" class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-white/90 backdrop-blur text-[#1e293b] text-xs sm:text-sm font-bold rounded-xl shadow-sm hover:shadow-md hover:text-blue-600 transition-all group border border-white/20">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Back to Wilaya
        </a>
        <div class="flex items-center gap-1 text-[10px] sm:text-xs font-bold text-gray-500 bg-white/70 backdrop-blur px-3 py-1.5 rounded-xl">
            <span>{{ $yearData->year }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-green-700">{{ $region->name }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-blue-700">{{ $district->name }}</span>
        </div>
    </div>
    <div class="animate__animated animate__fadeInDown">
        <h1 class="text-xl sm:text-3xl font-bold text-[#1e293b] tracking-tight bg-white/50 backdrop-blur inline-block px-3 py-1 rounded-lg leading-tight">
            {{ $district->name }} - Mitihani
        </h1>
    </div>
</div>

<section class="pt-32 pb-12 sm:py-24 bg-[#e9ecef] min-h-screen flex items-center justify-center overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Select an examination to view results</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 max-w-6xl mx-auto">
            @forelse($resultTitles as $index => $title)
                <a href="{{ route('results.final', [$yearData->year, $region->slug, $district->slug, $title->slug]) }}" 
                   class="group bg-white/80 backdrop-blur p-5 sm:p-6 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 border border-white/40 transition-all duration-300 animate__animated animate__fadeInUp"
                   style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-inner">
                            <i class="ri-file-list-3-line text-2xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-[#1e293b] truncate group-hover:text-blue-700 transition-colors">
                                {{ $title->name }}
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] font-bold text-green-600 uppercase tracking-tighter flex items-center gap-1">
                                    <i class="ri-checkbox-circle-fill"></i> Published
                                </span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                    • {{ $title->results_count }} Centres
                                </span>
                            </div>
                        </div>
                        <div class="text-gray-300 group-hover:text-blue-500 transition-colors">
                            <i class="ri-arrow-right-s-line text-2xl"></i>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 animate__animated animate__fadeIn">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-folder-open-line text-3xl text-gray-300"></i>
                    </div>
                    <p class="text-[#64748b] font-bold uppercase tracking-widest italic text-xs">Hakuna Mitihani iliyopatikana kwa sasa.</p>
                </div>
            @endforelse
        </div>

        @if($districtSummaries->isNotEmpty())
        <div class="border-t border-gray-300 pt-8 mt-10 animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm sm:text-lg font-black text-[#1e293b] uppercase tracking-wider flex items-center gap-2">
                    <i class="ri-file-chart-line text-blue-600 text-xl"></i>
                    Summary za Wilaya - {{ $district->name }}
                </h2>
                <span class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase">Muhtasari wa Matokeo ya Wilaya</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @foreach($districtSummaries as $summary)
                    <a href="{{ route('results.view_pdf', ['file' => $summary->file_path, 'name' => $summary->name]) }}"
                       class="group flex items-center gap-3 bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md hover:border-blue-400 transition-all duration-300">
                        <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                            <i class="ri-file-pdf-fill text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xs sm:text-sm font-bold text-[#1e293b] group-hover:text-blue-700 transition-colors truncate">
                                {{ strtoupper($summary->name) }}
                            </h3>
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-tighter">View PDF</span>
                        </div>
                        <i class="ri-arrow-right-s-line text-gray-300 group-hover:text-blue-500 text-xl"></i>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
