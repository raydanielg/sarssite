@extends('landing.layouts.results_layout')

@section('title', $region->name . ' - Wilaya')

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
            <div class="text-center mb-8">
                <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Chagua Wilaya (District) ili kuona matokeo</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4 mb-10">
                @forelse($districts as $index => $district)
                    <a href="{{ route('results.titles', [$yearData->year, $region->slug, $district->slug]) }}"
                       class="group bg-gray-50 p-4 sm:p-5 rounded-xl border border-gray-100 hover:bg-green-600 hover:border-green-600 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate__animated animate__fadeInUp"
                       style="animation-delay: {{ $index * 0.03 }}s">
                        <div class="flex flex-col items-center text-center">
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
                        <p class="text-gray-400 font-bold uppercase tracking-widest italic text-xs">Hakuna Wilaya zilizopatikana.</p>
                    </div>
                @endforelse
            </div>

            </div>
        </div>
    </div>
</section>
@endsection
