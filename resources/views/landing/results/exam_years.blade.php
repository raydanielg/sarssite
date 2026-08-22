@extends('landing.layouts.results_layout')

@section('title', $examName . ' - Chagua Mwaka')

@section('content')
<div class="breadcrumb-bar fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2">
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('results.index') }}" class="results-link inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-[#1e293b] text-xs sm:text-sm font-bold rounded-lg transition-all group">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Rudi Mitihani
        </a>
        <div class="flex items-center gap-1 text-[10px] sm:text-xs font-bold text-gray-500 px-3 py-1.5">
            <span class="text-[#1f7a35]">{{ $examName }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-gray-400">Chagua Mwaka</span>
        </div>
    </div>
</div>

<section class="pt-24 pb-12 sm:pt-32 min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <h2 class="text-xl sm:text-2xl font-black text-[#1e293b]">{{ $examName }}</h2>
            @if($level)
                <p class="text-sm text-gray-500 mt-1">{{ $level->name }}</p>
            @endif
            <p class="text-xs text-gray-400 mt-2 uppercase tracking-widest font-bold">Chagua Mwaka</p>
        </div>

        <div class="results-card max-w-4xl mx-auto p-6 sm:p-8 animate__animated animate__fadeInUp">
            @if($years->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-5">
                    @foreach($years as $index => $year)
                        <a href="{{ route('results.exam_regions', [$examSlug, $year->year]) }}"
                           class="group relative bg-gray-50 p-5 sm:p-7 rounded-xl border border-gray-100 hover:border-[#1f7a35] hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInUp"
                           style="animation-delay: {{ $index * 0.08 }}s">
                            <div class="relative z-10 flex flex-col items-center text-center">
                                <h3 class="text-2xl sm:text-3xl font-black text-[#1e293b] group-hover:text-[#1f7a35] transition-colors tracking-tight">
                                    {{ $year->year }}
                                </h3>
                                <div class="mt-2 text-[10px] sm:text-xs font-bold text-[#1f7a35] uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Chagua <i class="ri-arrow-right-line"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 animate__animated animate__fadeIn">
                    <i class="ri-calendar-line text-5xl text-gray-300 mb-3"></i>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Hakuna mwaka uliopatikana kwa mtihani huu.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
