@extends('landing.layouts.app')

@section('title', 'SARS - Regional Examination System')

@section('content')

<!-- Announcement Banner -->
@if($announcements->count() > 0)
    @php
        $latest = $announcements->first();
        $typeColors = [
            'New' => 'bg-green-600',
            'Update' => 'bg-blue-600',
            'Alert' => 'bg-red-600',
            'Info' => 'bg-primary-600'
        ];
        $bgColor = $typeColors[$latest->type] ?? 'bg-primary-600';
    @endphp
    <div class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 py-2">
            <button onclick="showAnnouncement('{{ addslashes($latest->title) }}', '{{ addslashes($latest->content) }}', '{{ $latest->type }}')" class="w-full flex justify-between items-center text-sm text-gray-700 hover:text-primary-600 transition-colors">
                <span class="flex items-center gap-2">
                    <span class="text-[10px] font-bold uppercase {{ $bgColor }} rounded-full text-white px-3 py-1 tracking-wider">{{ $latest->type }}</span>
                    <span class="font-medium tracking-tight truncate max-w-[200px] sm:max-w-md">{{ $latest->title }}</span>
                </span>
                <i class="ri-arrow-right-s-line text-lg opacity-50"></i>
            </button>
        </div>
    </div>
@endif

<!-- Hero Section -->
<section class="bg-gradient-to-br from-gray-50 via-white to-primary-50/30 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 py-12 sm:py-20 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-50 border border-primary-100 rounded-full mb-6 animate__animated animate__fadeInDown">
            <span class="w-2 h-2 bg-primary-600 rounded-full animate-pulse"></span>
            <span class="text-[10px] sm:text-xs font-bold text-primary-700 uppercase tracking-widest">Matokeo Yanapatikana Sasa</span>
        </div>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-gray-900 leading-tight animate__animated animate__fadeInUp">
            Karibu kwenye<span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-green-500"> Mfumo wa Matokeo</span>
        </h1>
        <p class="mt-4 text-sm sm:text-lg text-gray-500 font-medium max-w-2xl mx-auto animate__animated animate__fadeInUp animate__delay-1s">
            Pata matokeo ya mitihani kwa kuchagua mwaka, mkoa, wilaya, na shule yako. Chagua link hapa chini.
        </p>

        <div class="mt-8 flex flex-row items-center justify-center space-x-2 sm:space-x-4 animate__animated animate__zoomIn animate__delay-2s">
            <a href="{{ route('results.index') }}" class="inline-flex justify-center items-center py-3 px-6 sm:px-8 text-xs sm:text-base font-black text-center text-white rounded-xl bg-primary-600 hover:bg-primary-700 hover:shadow-xl hover:shadow-primary-200 transition-all uppercase tracking-wider group relative overflow-hidden whitespace-nowrap">
                <span class="relative z-10 flex items-center">
                    Check Results
                    <i class="ri-arrow-right-line ml-2 text-lg sm:text-xl group-hover:translate-x-1 transition-transform"></i>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </a>
            <a href="{{ route('results.tour') }}" class="inline-flex justify-center items-center py-3 px-6 sm:px-8 text-xs sm:text-base font-bold text-center text-gray-900 rounded-xl border-2 border-gray-200 hover:border-primary-600 hover:text-primary-600 hover:bg-primary-50 transition-all uppercase tracking-wider group whitespace-nowrap">
                <i class="ri-play-circle-fill mr-2 text-xl sm:text-2xl group-hover:scale-110 transition-transform"></i>
                Tour
            </a>
        </div>
    </div>
</section>

<!-- Main Content: Sitemap-style Navigation -->
<section class="bg-white py-12 sm:py-16">
    <div class="max-w-6xl mx-auto px-4">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Quick Pages Card -->
            <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow duration-300 animate__animated animate__fadeInUp">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                        <i class="ri-links-line text-primary-600 text-xl"></i>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-widest text-gray-900">Quick Pages</h3>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('results.index') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-bold text-sm transition-all group">
                        <i class="ri-file-list-3-line text-gray-400 group-hover:text-primary-600"></i> Results Portal
                        <i class="ri-arrow-right-s-line ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </a>
                    <a href="{{ route('results.tour') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-bold text-sm transition-all group">
                        <i class="ri-play-circle-line text-gray-400 group-hover:text-primary-600"></i> System Tour
                        <i class="ri-arrow-right-s-line ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </a>
                    <a href="/login" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-bold text-sm transition-all group">
                        <i class="ri-login-circle-line text-gray-400 group-hover:text-primary-600"></i> Staff Login
                        <i class="ri-arrow-right-s-line ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </a>
                    <a href="{{ route('sitemap.xml') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-bold text-sm transition-all group">
                        <i class="ri-code-line text-gray-400 group-hover:text-primary-600"></i> Sitemap XML
                        <i class="ri-arrow-right-s-line ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </a>
                </div>
            </div>

            <!-- Years + Exams Card -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 lg:col-span-2 hover:shadow-lg transition-shadow duration-300 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="flex items-center justify-between gap-4 flex-wrap mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                            <i class="ri-file-list-3-line text-primary-600 text-xl"></i>
                        </div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-gray-900">Results Navigation</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Years -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 flex items-center gap-2 mb-3">
                            <i class="ri-calendar-line text-primary-600"></i> Years
                        </h4>
                        <div class="grid grid-cols-2 gap-2">
                            @forelse($years as $y)
                                <a href="{{ route('results.year', $y->year) }}" class="flex items-center justify-between px-3 py-2 bg-white rounded-lg border border-gray-200 hover:border-primary-400 hover:bg-primary-50 text-sm font-bold text-gray-700 hover:text-primary-700 transition-all group">
                                    {{ $y->year }}
                                    <i class="ri-arrow-right-s-line text-gray-300 group-hover:text-primary-600 transition-colors"></i>
                                </a>
                            @empty
                                <div class="col-span-2 text-sm text-gray-500 text-center py-4">Hakuna years zilizowekwa.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Exams -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 flex items-center gap-2 mb-3">
                            <i class="ri-graduation-cap-line text-primary-600"></i> Recent Exams
                        </h4>
                        <div class="space-y-2">
                            @forelse($resultTitles->take(8) as $t)
                                @if($t->year && $t->region)
                                    @php
                                        $params = [$t->year->year, $t->region->slug];
                                        if ($t->district) {
                                            $params[] = $t->district->slug;
                                            $params[] = $t->slug;
                                        }
                                    @endphp
                                    <a href="{{ $t->district ? route('results.final', $params) : route('results.districts', $params) }}" class="block text-sm font-bold text-gray-700 hover:text-primary-600 truncate transition-colors">
                                        <i class="ri-file-line text-gray-400 mr-1"></i> {{ $t->name }}
                                    </a>
                                @endif
                            @empty
                                <div class="text-sm text-gray-500">Hakuna examinations zilizowekwa.</div>
                            @endforelse
                        </div>
                        <a href="{{ route('results.index') }}" class="mt-3 inline-flex items-center gap-1 text-[11px] font-black text-primary-600 uppercase hover:underline">
                            View All <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                </div>

                <!-- Tip Box -->
                <div class="mt-5 bg-primary-50 border border-primary-100 rounded-xl p-4 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-primary-600 text-white flex items-center justify-center flex-shrink-0">
                        <i class="ri-information-line text-lg"></i>
                    </div>
                    <div>
                        <div class="text-sm font-black text-gray-900">Tip</div>
                        <div class="text-xs sm:text-sm text-gray-600 font-medium">
                            Ukishafika kwenye "School List" au "Result Summary", bonyeza item yoyote kufungua PDF viewer.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showAnnouncement(title, content, type) {
    let icon = 'info';
    let confirmBtnClass = 'bg-primary-600';

    if (type === 'Alert') {
        icon = 'error';
        confirmBtnClass = 'bg-red-600';
    } else if (type === 'New') {
        icon = 'success';
        confirmBtnClass = 'bg-green-600';
    } else if (type === 'Update') {
        icon = 'info';
        confirmBtnClass = 'bg-blue-600';
    }

    Swal.fire({
        title: `<h3 class="text-xl font-bold text-gray-900">${title}</h3>`,
        html: `<div class="text-left text-gray-600 leading-relaxed">${content}</div>`,
        icon: icon,
        confirmButtonText: 'Sawa, nimeelewa',
        customClass: {
            confirmButton: `px-6 py-2.5 rounded-lg text-white font-bold transition-all ${confirmBtnClass}`,
            popup: 'rounded-2xl shadow-2xl border-0'
        },
        buttonsStyling: false,
        showCloseButton: true,
        showClass: { popup: 'animate__animated animate__fadeInDown' },
        hideClass: { popup: 'animate__animated animate__fadeOutUp' }
    });
}
</script>
@endpush
