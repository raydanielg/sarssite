@extends('landing.layouts.results_layout')

@section('title', $examName . ' ' . $yearData->year . ' ' . $region->name . ' - Chagua Wilaya')

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
    </div>
</section>
@endsection
