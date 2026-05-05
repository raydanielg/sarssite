@extends('landing.layouts.app')

@section('title', 'Karibu')

@section('content')
<!-- Hero Section -->
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
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
            <button onclick="showAnnouncement('{{ addslashes($latest->title) }}', '{{ addslashes($latest->content) }}', '{{ $latest->type }}')" class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-300 transform hover:scale-105" role="alert">
                <span class="text-[10px] font-bold uppercase {{ $bgColor }} rounded-full text-white px-3 py-1 mr-3 tracking-wider">{{ $latest->type }}</span> 
                <span class="text-sm font-medium tracking-tight truncate max-w-[200px] sm:max-w-md">{{ $latest->title }}</span> 
                <i class="ri-arrow-right-s-line ml-2 text-lg opacity-50"></i>
            </button>
        @else
            <a href="#" class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700" role="alert">
                <span class="text-xs bg-primary-600 rounded-full text-white px-4 py-1.5 mr-3 tracking-tight">New</span> 
                <span class="text-sm font-medium tracking-tight">SARS v1.0 is now live! Explore the features</span> 
                <i class="ri-arrow-right-s-line ml-2 text-lg"></i>
            </a>
        @endif
        <h1 class="mb-4 text-4xl font-black tracking-tight leading-none text-gray-900 md:text-5xl lg:text-7xl dark:text-white animate__animated animate__fadeInDown">
            Your Academic <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-green-500">Success</span> Starts Here
        </h1>
        <p class="mb-8 text-lg font-medium text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400 animate__animated animate__fadeInUp animate__delay-1s">
            Access your results quickly, securely, and easily. THE REGIONAL EXAMINATION SYSTEM brings transparency and efficiency to school performance management.
        </p>
        <div class="flex flex-row items-center justify-center mb-8 lg:mb-16 space-x-2 sm:space-x-4 animate__animated animate__zoomIn animate__delay-2s px-2">
            <a href="{{ route('results.index') }}" class="flex-1 sm:flex-none inline-flex justify-center items-center py-3 px-4 sm:px-8 text-xs sm:text-base font-black text-center text-white rounded-xl bg-primary-600 hover:bg-primary-700 hover:shadow-xl hover:shadow-primary-200 focus:ring-4 focus:ring-primary-300 transition-all uppercase tracking-wider group relative overflow-hidden whitespace-nowrap">
                <span class="relative z-10 flex items-center">
                    Check Results
                    <i class="ri-arrow-right-line ml-1 sm:ml-2 text-lg sm:text-xl group-hover:translate-x-1 transition-transform"></i>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </a>
            <a href="{{ route('results.tour') }}" class="flex-1 sm:flex-none inline-flex justify-center items-center py-3 px-4 sm:px-8 text-xs sm:text-base font-bold text-center text-gray-900 rounded-xl border-2 border-gray-200 hover:border-primary-600 hover:text-primary-600 hover:bg-primary-50 focus:ring-4 focus:ring-gray-100 transition-all uppercase tracking-wider group whitespace-nowrap">
                <i class="ri-play-circle-fill mr-1 sm:mr-2 text-xl sm:text-2xl group-hover:scale-110 transition-transform"></i>
                Tour
            </a>  
        </div>
        <div class="px-4 mx-auto text-center md:max-w-screen-md lg:max-w-screen-lg lg:px-36">
            <span class="font-bold text-gray-400 uppercase tracking-widest text-xs">OFFICIALLY RECOGNIZED BY</span>
            <div class="flex flex-wrap justify-center items-center mt-8 text-gray-400 sm:justify-between gap-8 opacity-60">
                <div class="flex items-center gap-2 hover:text-primary-600 transition-colors cursor-default">
                    <i class="fas fa-university text-2xl"></i>
                    <span class="font-black text-sm uppercase">TAMISEMI</span>
                </div>
                <div class="flex items-center gap-2 hover:text-primary-600 transition-colors cursor-default">
                    <i class="fas fa-landmark text-2xl"></i>
                    <span class="font-black text-sm uppercase">NECTA</span>
                </div>
                <div class="flex items-center gap-2 hover:text-primary-600 transition-colors cursor-default">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                    <span class="font-black text-sm uppercase">MOEST</span>
                </div>
            </div>
        </div> 
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mb-4 tracking-tight">Vipengele vya Mfumo</h2>
            <div class="h-1.5 w-20 bg-primary-600 mx-auto rounded-full"></div>
            <p class="mt-4 text-gray-600 font-medium max-w-2xl mx-auto italic">Mfumo umejengwa kwa ajili ya kurahisisha usimamizi na utoaji wa matokeo ya kitaaluma kwa ufanisi zaidi.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
            <!-- Feature 1: Joint Exams -->
            <div class="group p-4 sm:p-8 bg-gray-50 rounded-2xl sm:rounded-3xl border border-gray-100 hover:bg-white hover:border-primary-100 hover:shadow-2xl hover:shadow-primary-100/50 transition-all duration-500 transform hover:-translate-y-2 text-center">
                <div class="w-12 h-12 sm:w-20 sm:h-20 mx-auto mb-4 sm:mb-6 relative">
                    <div class="absolute inset-0 bg-primary-100 rounded-xl sm:rounded-2xl rotate-6 group-hover:rotate-12 transition-transform duration-500"></div>
                    <div class="absolute inset-0 bg-white rounded-xl sm:rounded-2xl shadow-sm flex items-center justify-center p-2 sm:p-4 z-10">
                        <img src="https://cdn-icons-png.flaticon.com/512/3589/3589030.png" alt="Joint Exams" class="w-full h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-300 transform group-hover:scale-110">
                    </div>
                </div>
                <h3 class="text-sm sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-primary-600 transition-colors">Joint Exams</h3>
                <p class="text-[10px] sm:text-sm text-gray-600 leading-tight sm:leading-relaxed">Usimamizi wa mitihani ya pamoja.</p>
            </div>

            <!-- Feature 2: Marking System -->
            <div class="group p-4 sm:p-8 bg-gray-50 rounded-2xl sm:rounded-3xl border border-gray-100 hover:bg-white hover:border-primary-100 hover:shadow-2xl hover:shadow-primary-100/50 transition-all duration-500 transform hover:-translate-y-2 text-center">
                <div class="w-12 h-12 sm:w-20 sm:h-20 mx-auto mb-4 sm:mb-6 relative">
                    <div class="absolute inset-0 bg-primary-100 rounded-xl sm:rounded-2xl rotate-6 group-hover:rotate-12 transition-transform duration-500"></div>
                    <div class="absolute inset-0 bg-white rounded-xl sm:rounded-2xl shadow-sm flex items-center justify-center p-2 sm:p-4 z-10">
                        <img src="https://cdn-icons-png.flaticon.com/512/1048/1048953.png" alt="Marking" class="w-full h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-300 transform group-hover:scale-110">
                    </div>
                </div>
                <h3 class="text-sm sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-primary-600 transition-colors">E-Marking</h3>
                <p class="text-[10px] sm:text-sm text-gray-600 leading-tight sm:leading-relaxed">Usahihishaji wa kielektroniki.</p>
            </div>

            <!-- Feature 3: Statistics -->
            <div class="group p-4 sm:p-8 bg-gray-50 rounded-2xl sm:rounded-3xl border border-gray-100 hover:bg-white hover:border-primary-100 hover:shadow-2xl hover:shadow-primary-100/50 transition-all duration-500 transform hover:-translate-y-2 text-center">
                <div class="w-12 h-12 sm:w-20 sm:h-20 mx-auto mb-4 sm:mb-6 relative">
                    <div class="absolute inset-0 bg-primary-100 rounded-xl sm:rounded-2xl rotate-6 group-hover:rotate-12 transition-transform duration-500"></div>
                    <div class="absolute inset-0 bg-white rounded-xl sm:rounded-2xl shadow-sm flex items-center justify-center p-2 sm:p-4 z-10">
                        <img src="https://cdn-icons-png.flaticon.com/512/2103/2103633.png" alt="Statistics" class="w-full h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-300 transform group-hover:scale-110">
                    </div>
                </div>
                <h3 class="text-sm sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-primary-600 transition-colors">Takwimu</h3>
                <p class="text-[10px] sm:text-sm text-gray-600 leading-tight sm:leading-relaxed">Uchambuzi wa kina wa matokeo.</p>
            </div>

            <!-- Feature 4: E-Mrejesho -->
            <div class="group p-4 sm:p-8 bg-gray-50 rounded-2xl sm:rounded-3xl border border-gray-100 hover:bg-white hover:border-primary-100 hover:shadow-2xl hover:shadow-primary-100/50 transition-all duration-500 transform hover:-translate-y-2 text-center">
                <div class="w-12 h-12 sm:w-20 sm:h-20 mx-auto mb-4 sm:mb-6 relative">
                    <div class="absolute inset-0 bg-primary-100 rounded-xl sm:rounded-2xl rotate-6 group-hover:rotate-12 transition-transform duration-500"></div>
                    <div class="absolute inset-0 bg-white rounded-xl sm:rounded-2xl shadow-sm flex items-center justify-center p-2 sm:p-4 z-10">
                        <img src="https://cdn-icons-png.flaticon.com/512/2190/2190552.png" alt="Feedback" class="w-full h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-300 transform group-hover:scale-110">
                    </div>
                </div>
                <h3 class="text-sm sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3 group-hover:text-primary-600 transition-colors">E-Mrejesho</h3>
                <p class="text-[10px] sm:text-sm text-gray-600 leading-tight sm:leading-relaxed">Mrejesho wa papo hapo.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function () {
  $('.select2').select2({
      theme: 'bootstrap4'
  });
});

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
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    });
}
</script>
@endpush
