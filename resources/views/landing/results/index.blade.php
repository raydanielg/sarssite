@extends('landing.layouts.results_layout')

@section('title', 'SARS - Regional Examination System')

@section('content')
<!-- Top Bar -->
<div class="breadcrumb-bar fixed top-0 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4 py-2.5 flex items-center justify-between">
        <h1 class="text-sm sm:text-lg font-black text-[#1e293b] tracking-tight">Regional Examination System</h1>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('results.tour') }}" class="results-link hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold transition-colors">
                <i class="ri-play-circle-line text-base"></i> Tour
            </a>
            <a href="{{ route('sitemap') }}" class="results-link hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold transition-colors">
                <i class="ri-sitemap-line text-base"></i> Sitemap
            </a>
            <a href="/login" class="results-btn inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 text-white text-xs sm:text-sm rounded-lg transition-all">
                <i class="ri-login-circle-line text-base"></i> <span class="hidden sm:inline">Staff Login</span><span class="sm:hidden">Login</span>
            </a>
        </div>
    </div>
</div>

<!-- Year Selection -->
<section class="min-h-screen flex items-center justify-center overflow-hidden pt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="results-card max-w-5xl mx-auto p-6 sm:p-10 animate__animated animate__fadeInUp">
            <!-- Year Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 sm:gap-5">
                @forelse($years as $index => $year)
                    <a href="{{ route('results.year', $year->year) }}"
                       class="group relative bg-gray-50 p-5 sm:p-7 rounded-xl border border-gray-100 hover:border-[#1f7a35] hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInUp"
                       style="animation-delay: {{ $index * 0.08 }}s">
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <h3 class="text-2xl sm:text-3xl font-black text-[#1e293b] group-hover:text-[#1f7a35] transition-colors tracking-tight">
                                {{ $year->year }}
                            </h3>
                            <div class="mt-2 text-[10px] sm:text-xs font-bold text-[#1f7a35] uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Chagua
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 animate__animated animate__fadeIn">
                        <p class="text-gray-400 font-bold uppercase tracking-widest italic text-sm">Hakuna miaka iliyopatikana kwa sasa.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
