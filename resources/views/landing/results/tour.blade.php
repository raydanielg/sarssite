@extends('landing.layouts.results_layout')

@section('title', 'System Tour - Karibu SARS')

@section('content')
<style>
    .step-content { display: none; }
    .step-content.active { display: block; }
    .progress-bar-container {
        height: 4px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: #16a34a;
        width: 0%;
        transition: width 0.1s linear;
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    .bg-grid-pattern {
        background-image: radial-gradient(circle, #e5e7eb 1px, transparent 1px);
        background-size: 30px 30px;
    }
</style>

<div class="fixed inset-0 bg-white overflow-hidden flex flex-col">
    <!-- Top Header -->
    <div class="p-6 flex justify-between items-center z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center text-white font-bold">S</div>
            <span class="font-black text-gray-900 tracking-tighter">SARS TOUR</span>
        </div>
        <a href="{{ route('results.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
            Skip to Portal
        </a>
    </div>

    <!-- Video Progress Indicators -->
    <div class="px-6 flex gap-2 z-50">
        @for($i = 1; $i <= 6; $i++)
        <div class="flex-1 progress-bar-container">
            <div id="fill-{{ $i }}" class="progress-fill"></div>
        </div>
        @endfor
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 relative flex items-center justify-center p-4">
        <!-- Floating Background Elements -->
        <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
        <div class="absolute top-1/4 left-1/4 w-80 h-80 bg-primary-50 rounded-full mix-blend-multiply filter blur-3xl animate-float opacity-20"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl animate-float opacity-20" style="animation-delay: 2s"></div>

        <div class="max-w-2xl w-full relative z-10 text-center px-4">
            <!-- Step 1: Karibu -->
            <div id="step-1" class="step-content active animate__animated animate__zoomIn">
                <div class="mb-10 flex justify-center">
                    <div class="w-40 h-40 bg-primary-50 rounded-[3rem] flex items-center justify-center text-primary-600 shadow-2xl shadow-primary-100 border-4 border-white">
                        <i class="ri-government-line text-7xl"></i>
                    </div>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">Mifumo ya Kidijitali kwa Elimu Yetu</h2>
                <p class="text-lg sm:text-xl text-gray-500 font-medium leading-relaxed">
                    SARS ni mapinduzi mapya katika kusimamia matokeo ya kitaaluma nchini Tanzania. Tumia teknolojia kurahisisha kazi zako.
                </p>
            </div>

            <!-- Step 2: Instant Results -->
            <div id="step-2" class="step-content animate__animated animate__fadeInUp">
                <div class="mb-10 flex justify-center">
                    <div class="w-40 h-40 bg-blue-50 rounded-[3rem] flex items-center justify-center text-blue-600 shadow-2xl shadow-blue-100 border-4 border-white">
                        <i class="ri-flashlight-line text-7xl"></i>
                    </div>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">Upatikanaji wa Matokeo Haraka</h2>
                <p class="text-lg sm:text-xl text-gray-500 font-medium leading-relaxed">
                    Ondoa usumbufu wa kusubiri. Matokeo yanapakiwa na kupatikana papo hapo kwa kila mwanafunzi na kila shule nchi nzima.
                </p>
            </div>

            <!-- Step 3: PDF Viewer -->
            <div id="step-3" class="step-content animate__animated animate__fadeInRight">
                <div class="mb-10 flex justify-center">
                    <div class="w-40 h-40 bg-green-50 rounded-[3rem] flex items-center justify-center text-green-600 shadow-2xl shadow-green-100 border-4 border-white">
                        <i class="ri-eye-line text-7xl"></i>
                    </div>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">Interactive Results Viewing</h2>
                <p class="text-lg sm:text-xl text-gray-500 font-medium leading-relaxed">
                    Soma matokeo yako moja kwa moja kwenye kivinjari (browser) bila kulazimika kupakua faili. Ni salama na inafanya kazi kwenye simu zote.
                </p>
            </div>

            <!-- Step 4: Search & Filter -->
            <div id="step-4" class="step-content animate__animated animate__bounceIn">
                <div class="mb-10 flex justify-center">
                    <div class="w-40 h-40 bg-orange-50 rounded-[3rem] flex items-center justify-center text-orange-600 shadow-2xl shadow-orange-100 border-4 border-white">
                        <i class="ri-search-eye-line text-7xl"></i>
                    </div>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">Tafuta Shule kwa Urahisi</h2>
                <p class="text-lg sm:text-xl text-gray-500 font-medium leading-relaxed">
                    Tumia mfumo wetu wa kisasa kutafuta shule kwa jina au herufi. Pata unachokitafuta ndani ya sekunde chache tu.
                </p>
            </div>

            <!-- Step 5: Analysis -->
            <div id="step-5" class="step-content animate__animated animate__rotateIn">
                <div class="mb-10 flex justify-center">
                    <div class="w-40 h-40 bg-purple-50 rounded-[3rem] flex items-center justify-center text-purple-600 shadow-2xl shadow-purple-100 border-4 border-white">
                        <i class="ri-pie-chart-2-line text-7xl"></i>
                    </div>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">Uchambuzi wa Takwimu</h2>
                <p class="text-lg sm:text-xl text-gray-500 font-medium leading-relaxed">
                    Pata grafu na takwimu za ufaulu kitalamu zaidi. SARS inakusaidia kufanya maamuzi sahihi ya kitaaluma kwa shule yako.
                </p>
            </div>

            <!-- Step 6: Get Started -->
            <div id="step-6" class="step-content animate__animated animate__pulse animate__infinite">
                <div class="mb-10 flex justify-center">
                    <div class="w-40 h-40 bg-primary-600 rounded-[3rem] flex items-center justify-center text-white shadow-2xl shadow-primary-200 border-4 border-white">
                        <i class="ri-checkbox-circle-line text-7xl"></i>
                    </div>
                </div>
                <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">Uko Tayari Kuanza?</h2>
                <p class="text-lg sm:text-xl text-gray-500 font-medium leading-relaxed mb-10">
                    Safari yako ya kitaaluma inaanza hapa. Karibu kwenye ulimwengu wa matokeo ya kidijitali.
                </p>
                <a href="{{ route('results.index') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-primary-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-primary-700 transition-all transform hover:scale-105">
                    Start Checking Now <i class="ri-arrow-right-line text-2xl"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Text -->
    <div class="p-10 text-center z-50">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.3em]">SARS Digital Ecosystem • 2026</p>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 6;
    const stepDuration = 5000; // 5 seconds per step
    let progress = 0;
    let timer;

    function startTour() {
        updateStep();
        startProgress();
    }

    function updateStep() {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(s => s.classList.remove('active'));
        
        // Show current step
        const activeStep = document.getElementById(`step-${currentStep}`);
        activeStep.classList.add('active');

        // Mark previous bars as full
        for (let i = 1; i < currentStep; i++) {
            document.getElementById(`fill-${i}`).style.width = '100%';
        }
    }

    function startProgress() {
        progress = 0;
        const fill = document.getElementById(`fill-${currentStep}`);
        
        clearInterval(timer);
        timer = setInterval(() => {
            progress += (100 / (stepDuration / 100));
            fill.style.width = `${progress}%`;

            if (progress >= 100) {
                clearInterval(timer);
                nextStep();
            }
        }, 100);
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStep();
            startProgress();
        } else {
            // After last step, wait a bit then redirect if they haven't clicked
            setTimeout(() => {
                // window.location.href = "{{ route('results.index') }}";
            }, 3000);
        }
    }

    // Initialize
    window.onload = startTour;
</script>
@endsection
