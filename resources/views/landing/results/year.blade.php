@extends('landing.layouts.results_layout')

@section('title', 'Year ' . $yearData->year)

@section('content')
<div class="breadcrumb-bar fixed top-0 left-0 w-full p-3 sm:p-4 z-50">
    <div class="animate__animated animate__fadeInDown">
        <h1 class="text-xl sm:text-3xl font-black text-[#1e293b] tracking-tight inline-block">
            {{ $yearData->year }} - Regions
        </h1>
    </div>
</div>

<section class="pt-24 pb-12 sm:pt-28 sm:pb-20 min-h-screen overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="results-card max-w-4xl mx-auto p-6 sm:p-8 animate__animated animate__fadeInUp">
            <div class="space-y-2">
                @forelse($regions as $region)
                    <a href="{{ route('results.districts', [$yearData->year, $region->slug]) }}"
                       class="block px-5 py-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-[#1f7a35] hover:bg-green-50 text-sm sm:text-base font-bold text-gray-700 hover:text-[#1f7a35] transition-all animate__animated animate__fadeInUp"
                       style="animation-delay: {{ $loop->index * 0.03 }}s">
                        {{ $region->name }}
                    </a>
                @empty
                    <p class="text-center text-gray-400 font-medium py-12">Hakuna Mikoa iliyopatikana.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
