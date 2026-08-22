@extends('landing.layouts.results_layout')

@section('title', 'SARS - Matokeo ya Mtihani')

@section('content')
<!-- Top Bar -->
<div class="breadcrumb-bar fixed top-0 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4 py-2.5 flex items-center justify-between">
        <h1 class="text-sm sm:text-lg font-black text-[#1e293b] tracking-tight">Matokeo ya Mtihani</h1>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('sitemap') }}" class="results-link hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold transition-colors">
                <i class="ri-sitemap-line text-base"></i> Nyumbani
            </a>
            <a href="/login" class="results-btn inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 text-white text-xs sm:text-sm rounded-lg transition-all">
                <i class="ri-login-circle-line text-base"></i> <span class="hidden sm:inline">Staff Login</span><span class="sm:hidden">Login</span>
            </a>
        </div>
    </div>
</div>

<!-- Exam Selection -->
<section class="min-h-screen flex items-center justify-center overflow-hidden pt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <h2 class="text-2xl sm:text-3xl font-black text-[#1e293b] mb-2">Chagua Mtihani</h2>
            <p class="text-sm text-gray-500">Bofya mtihani kisha chagua Mwaka → Mkoa → Wilaya</p>
        </div>

        <div class="results-card max-w-5xl mx-auto p-6 sm:p-10 animate__animated animate__fadeInUp">
            @if($exams->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                    @foreach($exams as $index => $exam)
                        <a href="{{ route('results.exam_years', $exam->slug) }}"
                           class="group relative bg-gray-50 p-5 sm:p-6 rounded-xl border border-gray-100 hover:border-[#1f7a35] hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInUp"
                           style="animation-delay: {{ $index * 0.05 }}s">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center group-hover:bg-green-600 transition-colors duration-300">
                                    <i class="ri-file-list-3-line text-2xl text-green-600 group-hover:text-white transition-colors"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-black text-[#1e293b] group-hover:text-[#1f7a35] transition-colors leading-tight">
                                        {{ $exam->name }}
                                    </h3>
                                    <div class="flex items-center gap-2 mt-2 flex-wrap">
                                        @if($exam->level)
                                            <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded uppercase tracking-tighter">
                                                {{ $exam->level->name }}
                                            </span>
                                        @endif
                                        @if($exam->result_type)
                                            <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded uppercase tracking-tighter">
                                                {{ $exam->result_type->name }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 mt-3 text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                        <span><i class="ri-calendar-line"></i> {{ $exam->years_count }} Mwaka</span>
                                        <span><i class="ri-school-line"></i> {{ $exam->results_count }} Shule</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 self-center text-gray-300 group-hover:text-[#1f7a35] transition-colors">
                                    <i class="ri-arrow-right-s-line text-2xl"></i>
                                </div>
                            </div>
                            @if($index === 0)
                                <span class="absolute top-3 right-3 text-[9px] font-black text-white bg-green-600 px-2 py-0.5 rounded-full uppercase tracking-wider">NEW</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 animate__animated animate__fadeIn">
                    <i class="ri-inbox-line text-5xl text-gray-300 mb-3"></i>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Hakuna mtihani uliowekwa kwa sasa.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
