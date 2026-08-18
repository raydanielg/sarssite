@extends('landing.layouts.results_layout')

@section('title', $region->name . ' - Wilaya')

@section('content')
<div class="fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2">
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('results.year', $yearData->year) }}" class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-white/90 backdrop-blur text-[#1e293b] text-xs sm:text-sm font-bold rounded-xl shadow-sm hover:shadow-md hover:text-blue-600 transition-all group border border-white/20">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Back to Regions
        </a>
        <div class="flex items-center gap-1 text-[10px] sm:text-xs font-bold text-gray-500 bg-white/70 backdrop-blur px-3 py-1.5 rounded-xl">
            <span>{{ $yearData->year }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-green-700">{{ $region->name }}</span>
        </div>
    </div>
    <div class="animate__animated animate__fadeInDown">
        <h1 class="text-xl sm:text-3xl font-bold text-[#1e293b] tracking-tight bg-white/50 backdrop-blur inline-block px-3 py-1 rounded-lg">
            {{ $region->name }} - Chagua Wilaya
        </h1>
    </div>
</div>

<section class="pt-32 pb-12 sm:py-24 bg-[#e9ecef] min-h-screen overflow-hidden">
    <div class="container mx-auto px-4 max-w-7xl">

        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Chagua Wilaya (District) ili kuona matokeo</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4 mb-10">
            @forelse($districts as $index => $district)
                <a href="{{ route('results.titles', [$yearData->year, $region->slug, $district->slug]) }}"
                   class="group bg-white/80 backdrop-blur p-4 sm:p-5 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 border border-white/40 transition-all duration-300 animate__animated animate__fadeInUp"
                   style="animation-delay: {{ $index * 0.03 }}s">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="ri-community-line text-lg sm:text-xl"></i>
                        </div>
                        <h3 class="text-xs sm:text-sm font-bold text-[#1e293b] group-hover:text-blue-700 transition-colors leading-tight">
                            {{ $district->name }}
                        </h3>
                        <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-blue-600 uppercase tracking-tighter">
                            <i class="ri-arrow-right-s-line"></i> Mitihani
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 animate__animated animate__fadeIn">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-community-line text-3xl text-gray-300"></i>
                    </div>
                    <p class="text-[#64748b] font-bold uppercase tracking-widest italic text-xs">Hakuna Wilaya zilizopatikana.</p>
                </div>
            @endforelse
        </div>

        <div class="border-t border-gray-300 pt-8 animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm sm:text-lg font-black text-[#1e293b] uppercase tracking-wider flex items-center gap-2">
                    <i class="ri-file-chart-line text-green-600 text-xl"></i>
                    Summary ya Mkoa - {{ $region->name }}
                </h2>
                <span class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase">Muhtasari wa Matokeo ya Mkoa</span>
            </div>

            @if($regionSummaries->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    @foreach($regionSummaries as $summary)
                        <a href="{{ route('results.view_pdf', ['file' => $summary->file_path, 'name' => $summary->name]) }}"
                           class="group flex items-center gap-3 bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md hover:border-green-400 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                                <i class="ri-file-pdf-fill text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-bold text-[#1e293b] group-hover:text-green-700 transition-colors truncate">
                                    {{ strtoupper($summary->name) }}
                                </h3>
                                <span class="text-[10px] font-bold text-green-600 uppercase tracking-tighter">View PDF</span>
                            </div>
                            <i class="ri-arrow-right-s-line text-gray-300 group-hover:text-green-500 text-xl"></i>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white/60 border border-dashed border-gray-300 rounded-xl p-8 text-center">
                    <i class="ri-file-list-off-line text-3xl text-gray-300 mb-2"></i>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Hakuna muhtasari wa mkoa uliowekwa kwa sasa.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
