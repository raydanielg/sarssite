@extends('landing.layouts.results_layout')

@section('title', 'SARS - Regional Examination System')

@section('content')
<!-- Top Bar -->
<div class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200/50">
    <div class="max-w-7xl mx-auto px-4 py-2.5 flex items-center justify-between">
        <div class="flex items-center gap-2 sm:gap-3 ml-auto">
            <a href="{{ route('results.tour') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-gray-600 hover:text-primary-600 transition-colors">
                <i class="ri-play-circle-line text-base"></i> Tour
            </a>
            <a href="{{ route('sitemap') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-gray-600 hover:text-primary-600 transition-colors">
                <i class="ri-sitemap-line text-base"></i> Sitemap
            </a>
            <a href="/login" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-primary-600 hover:bg-primary-700 text-white text-xs sm:text-sm font-bold rounded-lg shadow-sm hover:shadow-md transition-all">
                <i class="ri-login-circle-line text-base"></i> <span class="hidden sm:inline">Staff Login</span><span class="sm:hidden">Login</span>
            </a>
        </div>
    </div>
</div>

<!-- Hero + Year Selection -->
<section class="min-h-screen bg-gradient-to-br from-[#e9ecef] via-[#f0f4f8] to-[#e9ecef] flex items-center justify-center overflow-hidden pt-16">
    <div class="container mx-auto px-4 py-12">

        <!-- Year Cards -->
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-5">
                @forelse($years as $index => $year)
                    <a href="{{ route('results.year', $year->year) }}"
                       class="group relative bg-white/80 backdrop-blur p-5 sm:p-7 rounded-2xl shadow-sm hover:shadow-2xl border border-white/60 transition-all duration-500 hover:-translate-y-2 animate__animated animate__fadeInUp overflow-hidden"
                       style="animation-delay: {{ $index * 0.08 }}s">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-50/0 to-primary-100/0 group-hover:from-primary-50/50 group-hover:to-primary-100/30 transition-all duration-500"></div>
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 mb-3 sm:mb-4 rounded-2xl bg-primary-50 group-hover:bg-primary-600 flex items-center justify-center transition-all duration-500 shadow-inner">
                                <i class="ri-calendar-line text-primary-600 group-hover:text-white text-xl sm:text-3xl transition-colors duration-500"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-black text-[#1e293b] group-hover:text-primary-700 transition-colors tracking-tight">
                                {{ $year->year }}
                            </h3>
                            <div class="mt-2 sm:mt-3 flex items-center gap-1 text-[10px] sm:text-xs font-bold text-primary-600 uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span>Chagua</span>
                                <i class="ri-arrow-right-s-line text-sm"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 animate__animated animate__fadeIn">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="ri-calendar-off-line text-4xl text-gray-300"></i>
                        </div>
                        <p class="text-[#64748b] font-bold uppercase tracking-widest italic text-sm">Hakuna miaka iliyopatikana kwa sasa.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Bottom Info Bar -->
        <div class="mt-12 sm:mt-16 max-w-3xl mx-auto animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
            <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-8 text-center">
                <div class="flex items-center gap-2 text-gray-500">
                    <i class="ri-shield-check-line text-primary-600 text-lg"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">Official Results</span>
                </div>
                <div class="hidden sm:block w-px h-4 bg-gray-300"></div>
                <div class="flex items-center gap-2 text-gray-500">
                    <i class="ri-map-pin-line text-primary-600 text-lg"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">All Regions</span>
                </div>
                <div class="hidden sm:block w-px h-4 bg-gray-300"></div>
                <div class="flex items-center gap-2 text-gray-500">
                    <i class="ri-building-line text-primary-600 text-lg"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">All Schools</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
