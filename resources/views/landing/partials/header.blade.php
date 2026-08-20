<!-- Main Header -->
<header class="bg-[#1b5e20] shadow-md sticky top-0 z-[100]">
    <!-- Branding Bar -->
    <div class="container mx-auto px-4 py-4 lg:py-6">
        <div class="flex items-center justify-between relative">
            <!-- Left: Coat of Arms -->
            <div class="flex items-center">
                <img src="{{ asset('emblem.png') }}" alt="Coat of Arms" class="h-16 lg:h-24 w-auto object-contain">
            </div>

            <!-- Middle: NECTA Title -->
            <div class="text-center flex-1 px-4">
                <h1 class="text-yellow-400 text-lg lg:text-3xl font-bold uppercase tracking-tight leading-tight">
                    THE REGIONAL EXAMINATION SYSTEM
                </h1>
            </div>

            <!-- Right: Logo -->
            <div class="flex items-center">
                 <img src="{{ asset('emblem.png') }}" alt="Logo" class="h-16 lg:h-24 w-auto object-contain brightness-110">
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <div class="bg-[#1b5e20] border-t border-white/10">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-center">
                <!-- Mobile Menu Toggler -->
                <div class="lg:hidden py-3 w-full flex justify-between items-center">
                    <span class="text-white font-bold text-sm tracking-widest uppercase">Navigation</span>
                    <button class="text-white focus:outline-none p-2 hover:bg-white/10 rounded-lg transition-colors" id="mobileMenuBtn">
                        <i class="ri-menu-3-line text-2xl"></i>
                    </button>
                </div>

                <!-- Desktop Menu -->
                <ul class="hidden lg:flex items-center gap-2 mx-auto list-none mb-0 p-0 py-2">
                    <li class="relative group">
                        <a href="{{ route('results.index') }}" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all flex items-center gap-1 uppercase tracking-wide">
                            RESULTS <i class="ri-arrow-down-s-line opacity-60"></i>
                        </a>
                        <!-- New Mega Menu UI -->
                        <div class="absolute top-full left-1/2 -translate-x-1/2 w-[900px] bg-white shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border-b-4 border-yellow-400 z-[101] rounded-b-2xl overflow-hidden">
                            <div class="flex">
                                <!-- Left Sidebar: Years -->
                                <div class="w-1/4 bg-gray-50 border-r border-gray-100 p-4 max-h-[500px] overflow-y-auto custom-scrollbar">
                                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 px-2">Academic Years</h3>
                                    <div class="space-y-1">
                                        @foreach($years->sortByDesc('year')->take(12) as $year)
                                            <button class="w-full text-left px-4 py-3 rounded-xl transition-all hover:bg-white hover:shadow-sm group/year {{ $loop->first ? 'bg-white shadow-sm ring-1 ring-black/5' : '' }}" onclick="switchYear('{{ $year->year }}')">
                                                <span class="block text-sm font-bold text-gray-700 group-hover/year:text-[#1b5e20]">{{ $year->year }}</span>
                                                <span class="block text-[9px] text-gray-400 uppercase tracking-tighter">View Examinations</span>
                                            </button>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('results.index') }}" class="mt-4 block text-center py-2 text-[9px] font-black text-[#1b5e20] uppercase hover:underline">View All Years</a>
                                </div>

                                <!-- Right Content: Exam Cards -->
                                <div class="flex-1 p-8 bg-white">
                                    <div id="examContainer" class="grid grid-cols-2 gap-6">
                                        <!-- This will be dynamically populated or show initial items -->
                                        <div class="col-span-2 text-center py-12">
                                            <div class="mb-4">
                                                <i class="ri-search-eye-line text-4xl text-gray-200"></i>
                                            </div>
                                            <h4 class="text-gray-400 font-medium italic text-sm">Select a year to view examinations</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- New Mega Menu JavaScript -->
<script>
    function switchYear(year) {
        // Update active button state
        const buttons = document.querySelectorAll('.group/year');
        buttons.forEach(btn => {
            if (btn.innerText.includes(year)) {
                btn.classList.add('bg-white', 'shadow-sm', 'ring-1', 'ring-black/5');
            } else {
                btn.classList.remove('bg-white', 'shadow-sm', 'ring-1', 'ring-black/5');
            }
        });

        // Show loading state
        const container = document.getElementById('examContainer');
        container.innerHTML = `
            <div class="col-span-2 text-center py-12">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#1b5e20]"></div>
                <p class="mt-4 text-gray-500 font-medium italic text-sm">Loading examinations for ${year}...</p>
            </div>
        `;

        // Fetch data
        fetch(`{{ route('api.exams-by-year') }}?year=${year}`)
            .then(response => response.json())
            .then(data => {
                if (data.exams && data.exams.length > 0) {
                    container.innerHTML = data.exams.map(exam => `
                        <a href="${exam.url}" class="group/card relative p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl hover:border-[#1b5e20]/20 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shadow-inner ${exam.color} border">
                                    <i class="${exam.icon}"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full ${exam.color} opacity-80">${exam.level}</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-800 line-clamp-2 leading-tight">${exam.name}</h4>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-[#1b5e20] uppercase tracking-tighter group-hover/card:translate-x-1 transition-transform inline-flex items-center gap-1">
                                            View Results <i class="ri-arrow-right-line"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = `
                        <div class="col-span-2 text-center py-12">
                            <div class="mb-4">
                                <i class="ri-error-warning-line text-4xl text-gray-200"></i>
                            </div>
                            <h4 class="text-gray-400 font-medium italic text-sm">No examinations found for year ${year}</h4>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = `
                    <div class="col-span-2 text-center py-12">
                        <div class="mb-4">
                            <i class="ri-wifi-off-line text-4xl text-red-100 text-red-400"></i>
                        </div>
                        <h4 class="text-gray-400 font-medium italic text-sm">Failed to load examinations. Please try again.</h4>
                    </div>
                `;
            });
    }

    // Load initial year results on hover or page load if needed
    document.addEventListener('DOMContentLoaded', function() {
        const firstYearBtn = document.querySelector('.group/year');
        if (firstYearBtn) {
            const year = firstYearBtn.querySelector('span').innerText;
            switchYear(year);
        }
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }
</style>

<!-- Mobile Sidebar Modal Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[110] hidden opacity-0 transition-opacity duration-300"></div>

<!-- Mobile Sidebar Content -->
<div id="mobileSidebar" class="fixed top-0 right-0 h-full w-[300px] bg-white z-[120] translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
    <!-- Sidebar Header -->
    <div class="bg-[#1b5e20] p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('emblem.png') }}" alt="Logo" class="h-10 w-auto">
            <span class="text-white font-bold text-lg tracking-tight">NECTA</span>
        </div>
        <button id="closeSidebar" class="text-white/80 hover:text-white transition-colors">
            <i class="ri-close-line text-2xl"></i>
        </button>
    </div>

    <!-- Sidebar Links -->
    <div class="flex-1 overflow-y-auto py-6">
        <nav class="px-4 space-y-2">
            <!-- Results Dropdown for Mobile -->
            <div class="space-y-1">
                <button id="mobileResultsToggle" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 font-bold uppercase text-xs hover:bg-gray-100 hover:text-[#1b5e20] rounded-xl transition-all">
                    <span class="flex items-center gap-3">
                        <i class="ri-file-list-3-line text-lg opacity-60"></i> RESULTS
                    </span>
                    <i class="ri-arrow-down-s-line transition-transform duration-300" id="resultsArrow"></i>
                </button>
                <div id="mobileResultsMenu" class="hidden overflow-hidden bg-gray-50 rounded-xl mx-2 border border-gray-100">
                    <div class="p-3 grid grid-cols-2 gap-2">
                        @foreach($years->sortByDesc('year')->take(10) as $year)
                        <a href="{{ route('results.year', $year->year) }}" class="flex flex-col p-2 bg-white rounded-lg border border-gray-200 hover:border-[#1b5e20] hover:bg-green-50 transition-all text-center">
                            <span class="text-sm font-bold text-gray-800">{{ $year->year }}</span>
                            <span class="text-[9px] text-gray-500 uppercase">View</span>
                        </a>
                        @endforeach
                        <a href="{{ route('results.index') }}" class="col-span-2 text-center py-2 text-[10px] font-black text-[#1b5e20] uppercase tracking-widest bg-yellow-400 rounded-lg mt-1">
                            VIEW ALL YEARS
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="p-6 border-t border-gray-100 bg-gray-50">
        <p class="text-[10px] text-gray-400 text-center uppercase font-bold tracking-tighter">
            &copy; {{ date('Y') }} NECTA. ALL RIGHTS RESERVED.
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const mobileResultsToggle = document.getElementById('mobileResultsToggle');
        const mobileResultsMenu = document.getElementById('mobileResultsMenu');
        const resultsArrow = document.getElementById('resultsArrow');

        function openMenu() {
            sidebarOverlay.classList.remove('hidden');
            setTimeout(() => {
                sidebarOverlay.classList.add('opacity-100');
                mobileSidebar.classList.remove('translate-x-full');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            sidebarOverlay.classList.remove('opacity-100');
            mobileSidebar.classList.add('translate-x-full');
            setTimeout(() => {
                sidebarOverlay.classList.add('hidden');
            }, 300);
            document.body.style.overflow = '';
        }

        mobileMenuBtn.addEventListener('click', openMenu);
        closeSidebar.addEventListener('click', closeMenu);
        sidebarOverlay.addEventListener('click', closeMenu);

        // Results Dropdown Toggle
        mobileResultsToggle.addEventListener('click', () => {
            const isHidden = mobileResultsMenu.classList.contains('hidden');
            if (isHidden) {
                mobileResultsMenu.classList.remove('hidden');
                resultsArrow.classList.add('rotate-180');
            } else {
                mobileResultsMenu.classList.add('hidden');
                resultsArrow.classList.remove('rotate-180');
            }
        });
    });
</script>
