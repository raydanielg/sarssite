@extends('landing.layouts.results_layout')

@section('title', 'Year ' . $yearData->year)

@section('content')
<div class="fixed top-0 left-0 w-full p-3 sm:p-4 z-50">
    <div class="animate__animated animate__fadeInDown">
        <h1 class="text-xl sm:text-3xl font-black text-[#1e293b] tracking-tight bg-white/80 backdrop-blur inline-block px-4 py-2 rounded-xl shadow-sm">
            {{ $yearData->year }} - Regions
        </h1>
    </div>
</div>

<section class="pt-24 pb-12 sm:pt-28 sm:pb-20 bg-[#e9ecef] min-h-screen overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="space-y-2">
                @forelse($regions as $region)
                    <a href="{{ route('results.districts', [$yearData->year, $region->slug]) }}"
                       class="block px-5 py-4 bg-white rounded-xl border border-gray-200 hover:border-primary-500 hover:bg-primary-50 text-sm sm:text-base font-bold text-gray-700 hover:text-primary-700 transition-all animate__animated animate__fadeInUp"
                       style="animation-delay: {{ $loop->index * 0.03 }}s">
                        {{ $region->name }}
                    </a>
                @empty
                    <p class="text-center text-gray-500 font-medium py-12">Hakuna Mikoa iliyopatikana.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
