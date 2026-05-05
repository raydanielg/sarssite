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
                    THE NATIONAL EXAMINATIONS COUNCIL OF TANZANIA
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
                    <li>
                        <a href="{{ route('landing') }}" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all uppercase tracking-wide">
                            HOME
                        </a>
                    </li>
                    <li class="relative group">
                        <button class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all flex items-center gap-1 uppercase tracking-wide opacity-50 cursor-not-allowed">
                            ABOUT <span class="text-[9px] bg-yellow-400 text-[#1b5e20] px-1 rounded ml-1">SOON</span>
                        </button>
                    </li>
                    <li class="relative group">
                        <button class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all flex items-center gap-1 uppercase tracking-wide opacity-50 cursor-not-allowed">
                            EXAM TYPES <span class="text-[9px] bg-yellow-400 text-[#1b5e20] px-1 rounded ml-1">SOON</span>
                        </button>
                    </li>
                    <li>
                        <a href="#" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all uppercase tracking-wide opacity-50 cursor-not-allowed">
                            REGISTRATION <span class="text-[9px] bg-yellow-400 text-[#1b5e20] px-1 rounded ml-1">SOON</span>
                        </a>
                    </li>
                    <li class="relative group">
                        <a href="{{ route('results.index') }}" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all flex items-center gap-1 uppercase tracking-wide">
                            RESULTS <i class="ri-arrow-down-s-line opacity-60"></i>
                        </a>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 w-[800px] bg-gray-50 shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 p-8 border-b-4 border-yellow-400 z-[101] rounded-b-2xl">
                            <div class="text-center mb-8">
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black rounded-full uppercase tracking-widest mb-3">
                                    <i class="ri-calendar-event-line"></i> Year
                                </span>
                                <h2 class="text-2xl font-bold text-gray-800">Choose an academic year</h2>
                                <p class="text-xs text-gray-500 mt-1 uppercase tracking-tighter">NECTA-style navigation: Year → Exam → School → Results</p>
                            </div>
                            
                            <div class="grid grid-cols-5 gap-4">
                                @forelse($years->sortByDesc('year')->take(10) as $year)
                                <a href="{{ route('results.year', $year->year) }}" class="group/card bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all flex items-center justify-between">
                                    <div>
                                        <p class="text-lg font-bold text-gray-800">{{ $year->year }}</p>
                                        <p class="text-[10px] text-gray-500 uppercase font-medium">View exams</p>
                                    </div>
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 font-bold group-hover/card:bg-blue-600 group-hover/card:text-white transition-colors">
                                        {{ substr($year->year, -2) }}
                                    </div>
                                </a>
                                @empty
                                <div class="col-span-5 text-center py-4">
                                    <p class="text-sm text-gray-500 uppercase font-bold tracking-widest">No years found</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all uppercase tracking-wide opacity-50 cursor-not-allowed">
                            SERVICES <span class="text-[9px] bg-yellow-400 text-[#1b5e20] px-1 rounded ml-1">SOON</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all uppercase tracking-wide opacity-50 cursor-not-allowed">
                            PUBLICATIONS <span class="text-[9px] bg-yellow-400 text-[#1b5e20] px-1 rounded ml-1">SOON</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all uppercase tracking-wide opacity-50 cursor-not-allowed">
                            FAQ <span class="text-[9px] bg-yellow-400 text-[#1b5e20] px-1 rounded ml-1">SOON</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all uppercase tracking-wide opacity-50 cursor-not-allowed">
                            E-MREJESHO <span class="text-[9px] bg-yellow-400 text-[#1b5e20] px-1 rounded ml-1">SOON</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="px-3 py-2 text-white text-[12px] font-bold hover:text-yellow-400 transition-all uppercase tracking-wide opacity-50 cursor-not-allowed">
                            CONTACTS <span class="text-[9px] bg-yellow-400 text-[#1b5e20] px-1 rounded ml-1">SOON</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

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
            <a href="{{ route('landing') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 font-bold uppercase text-xs hover:bg-gray-100 hover:text-[#1b5e20] rounded-xl transition-all">
                <i class="ri-home-4-line text-lg opacity-60"></i> HOME
            </a>

            <div class="border-t border-gray-100 my-2"></div>

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

            <div class="border-t border-gray-100 my-2"></div>

            <button class="w-full flex items-center justify-between px-4 py-3 text-gray-400 font-bold uppercase text-xs cursor-not-allowed">
                <span class="flex items-center gap-3">
                    <i class="ri-information-line text-lg opacity-40"></i> ABOUT
                </span>
                <span class="text-[8px] bg-gray-200 text-gray-500 px-1 rounded">SOON</span>
            </button>

            <button class="w-full flex items-center justify-between px-4 py-3 text-gray-400 font-bold uppercase text-xs cursor-not-allowed">
                <span class="flex items-center gap-3">
                    <i class="ri-book-open-line text-lg opacity-40"></i> EXAM TYPES
                </span>
                <span class="text-[8px] bg-gray-200 text-gray-500 px-1 rounded">SOON</span>
            </button>

            <button class="w-full flex items-center justify-between px-4 py-3 text-gray-400 font-bold uppercase text-xs cursor-not-allowed">
                <span class="flex items-center gap-3">
                    <i class="ri-user-add-line text-lg opacity-40"></i> REGISTRATION
                </span>
                <span class="text-[8px] bg-gray-200 text-gray-500 px-1 rounded">SOON</span>
            </button>

            <button class="w-full flex items-center justify-between px-4 py-3 text-gray-400 font-bold uppercase text-xs cursor-not-allowed">
                <span class="flex items-center gap-3">
                    <i class="ri-customer-service-2-line text-lg opacity-40"></i> SERVICES
                </span>
                <span class="text-[8px] bg-gray-200 text-gray-500 px-1 rounded">SOON</span>
            </button>

            <button class="w-full flex items-center justify-between px-4 py-3 text-gray-400 font-bold uppercase text-xs cursor-not-allowed">
                <span class="flex items-center gap-3">
                    <i class="ri-contacts-line text-lg opacity-40"></i> CONTACTS
                </span>
                <span class="text-[8px] bg-gray-200 text-gray-500 px-1 rounded">SOON</span>
            </button>
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
