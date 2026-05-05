@extends('landing.layouts.results_layout')

@section('title', 'Choose Year')

@section('content')
<div class="fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2">
    <div>
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-white/90 backdrop-blur text-[#1e293b] text-xs sm:text-sm font-bold rounded-xl shadow-sm hover:shadow-md hover:text-blue-600 transition-all group border border-white/20">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Back to Home
        </a>
    </div>
    <div class="animate__animated animate__fadeInDown">
        <h1 class="text-xl sm:text-4xl font-bold text-[#1e293b] tracking-tight bg-white/50 backdrop-blur inline-block px-3 py-1 rounded-lg">Academic Years</h1>
    </div>
</div>

<section class="pt-32 pb-12 sm:py-24 bg-[#e9ecef] min-h-screen flex items-center justify-center overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:flex md:flex-wrap justify-center gap-3 sm:gap-6 max-w-7xl mx-auto">
            @forelse($years as $index => $year)
                <div class="bg-white/70 backdrop-blur p-4 sm:p-8 rounded-xl shadow-sm hover:shadow-xl transition-all duration-500 animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 sm:w-16 sm:h-16 mb-2 sm:mb-4 relative flex items-center justify-center">
                            <div class="absolute inset-0 bg-gray-200/50 rounded-full scale-110"></div>
                            <i class="ri-file-copy-2-line text-blue-500 text-xl sm:text-3xl z-10"></i>
                        </div>
                        <h3 class="text-base sm:text-xl font-bold text-[#1e293b] mb-2 sm:mb-4">{{ $year->year }}</h3>
                        <div class="w-full text-center sm:text-left">
                            <a href="{{ route('results.year', $year->year) }}" class="inline-flex items-center gap-1 text-green-600 hover:text-green-700 text-[10px] sm:text-[13px] font-medium transition-colors">
                                <i class="ri-link text-blue-400"></i> <span class="hidden sm:inline">Results link 1</span><span class="sm:hidden">Results</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full text-center py-12 animate__animated animate__fadeIn">
                    <p class="text-[#64748b] font-bold uppercase tracking-widest italic">Hakuna miaka iliyopatikana.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
