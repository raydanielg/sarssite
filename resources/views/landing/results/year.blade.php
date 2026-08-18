@extends('landing.layouts.results_layout')

@section('title', 'Year ' . $yearData->year)

@section('content')
<div class="fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2">
    <div>
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-white/90 backdrop-blur text-[#1e293b] text-xs sm:text-sm font-bold rounded-xl shadow-sm hover:shadow-md hover:text-blue-600 transition-all group border border-white/20">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Back to Years
        </a>
    </div>
    <div class="animate__animated animate__fadeInDown">
        <h1 class="text-xl sm:text-4xl font-bold text-[#1e293b] tracking-tight bg-white/50 backdrop-blur inline-block px-3 py-1 rounded-lg">Year {{ $yearData->year }} - Select Region</h1>
    </div>
</div>

<section class="pt-32 pb-12 sm:py-24 bg-[#e9ecef] min-h-screen overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Chagua Mkoa (Region) ili kuendelea</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4 max-w-7xl mx-auto">
            @forelse($regions as $index => $region)
                <a href="{{ route('results.districts', [$yearData->year, $region->slug]) }}"
                   class="group bg-white/80 backdrop-blur p-4 sm:p-5 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 border border-white/40 transition-all duration-300 animate__animated animate__fadeInUp"
                   style="animation-delay: {{ $index * 0.03 }}s">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mb-2 sm:mb-3 rounded-xl bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                            <i class="ri-map-pin-line text-lg sm:text-xl"></i>
                        </div>
                        <h3 class="text-xs sm:text-sm font-bold text-[#1e293b] group-hover:text-green-700 transition-colors leading-tight">
                            {{ $region->name }}
                        </h3>
                        <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-green-600 uppercase tracking-tighter">
                            <i class="ri-arrow-right-s-line"></i> Wilaya
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 animate__animated animate__fadeIn">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-map-pin-line text-3xl text-gray-300"></i>
                    </div>
                    <p class="text-[#64748b] font-bold uppercase tracking-widest italic text-xs">Hakuna Mikoa iliyopatikana.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
