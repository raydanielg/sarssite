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

<!-- Main Content -->
<section class="bg-white py-12 sm:py-16">
    <div class="max-w-6xl mx-auto px-4">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Quick Pages Card -->
            <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow duration-300 animate__animated animate__fadeInUp">
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 mb-5">Quick Pages</h3>
                <div class="space-y-2">
                    <a href="{{ route('results.index') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-bold text-sm transition-all">
                        Results Portal
                    </a>
                    <a href="{{ route('results.tour') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-bold text-sm transition-all">
                        System Tour
                    </a>
                    <a href="/login" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-bold text-sm transition-all">
                        Staff Login
                    </a>
                    <a href="{{ route('sitemap.xml') }}" class="block px-4 py-3 rounded-xl text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-bold text-sm transition-all">
                        Sitemap XML
                    </a>
                </div>
            </div>

            <!-- Years + Recent Exams -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 lg:col-span-2 hover:shadow-lg transition-shadow duration-300 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Years as Buttons -->
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 mb-4">Years</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($years as $y)
                                <a href="{{ route('results.year', $y->year) }}" class="px-5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-black text-gray-700 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-all">
                                    {{ $y->year }}
                                </a>
                            @empty
                                <p class="text-sm text-gray-500">Hakuna years zilizowekwa.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Exam Titles -->
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 mb-4">Recent Exams</h3>
                        <div class="space-y-2.5">
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
                                        {{ $t->name }}
                                    </a>
                                @endif
                            @empty
                                <p class="text-sm text-gray-500">Hakuna examinations zilizowekwa.</p>
                            @endforelse
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
