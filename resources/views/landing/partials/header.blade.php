<!-- Top Glass Bar -->
<div class="hidden lg:block bg-[#1b5e20] text-white/90 py-1.5 border-b border-white/10">
    <div class="container mx-auto px-4 flex justify-between items-center text-[11px] font-medium tracking-wide">
        <div class="flex gap-6 items-center">
            <a href="#" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="far fa-chart-bar opacity-70"></i> MATOKEO YA SOMO MOJA</a>
            <a href="#" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="far fa-building opacity-70"></i> MATOKEO YA SHULE</a>
            <a href="#" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="far fa-comment-dots opacity-70"></i> FEEDBACK</a>
            <a href="#" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="far fa-envelope opacity-70"></i> E-MREJESHO</a>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative group">
                <input type="text" placeholder="Search..." class="bg-white/10 border border-white/20 rounded-full px-4 py-1 w-48 text-[11px] focus:outline-none focus:bg-white/20 focus:border-white/40 transition-all placeholder:text-white/40">
                <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-white/40 group-focus-within:text-white/70"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="bg-white sticky top-0 z-[100] shadow-sm">
    <!-- Middle Branding Bar -->
    <div class="container mx-auto px-4 py-2 lg:py-3">
        <div class="flex items-center justify-between gap-2">
            <!-- Left: EMaS Logo -->
            <div class="flex items-center">
                <img src="{{ asset('emblem.png') }}" alt="EMaS Logo" class="h-10 lg:h-16 w-auto drop-shadow-sm">
            </div>

            <!-- Middle: Gov Info (Hidden or smaller on mobile) -->
            <div class="text-center flex-1 lg:flex-initial px-2">
                <div class="text-[9px] lg:text-[11px] font-bold text-gray-800 uppercase leading-none mb-1">Jamhuri ya Muungano wa Tanzania</div>
                <div class="text-[8px] lg:text-[10px] text-red-700 font-bold uppercase leading-none max-w-[300px] lg:max-w-[400px] mx-auto">Ofisi ya Rais, Menejimenti ya Utumishi wa Umma na Utawala Bora</div>
            </div>

            <!-- Right: Coat of Arms -->
            <div class="flex items-center">
                 <img src="{{ asset('emblem.png') }}" alt="Coat of Arms" class="h-10 lg:h-16 w-auto object-contain">
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-[#2e7d32] border-t border-white/10">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <!-- Mobile Menu Button -->
                <button class="lg:hidden text-white py-4" id="mobileMenuBtn">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Desktop Menu -->
                <ul class="hidden lg:flex items-center">
                    <li><a href="{{ route('landing') }}" class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all flex items-center gap-2 border-r border-white/10 tracking-tight uppercase"><i class="fas fa-home opacity-80 text-[11px]"></i> NYUMBANI</a></li>
                    
                    <li class="relative group">
                        <button class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all flex items-center gap-2 border-r border-white/10 tracking-tight uppercase">
                            ABOUT <i class="fas fa-chevron-down text-[9px] opacity-60"></i>
                        </button>
                        <ul class="absolute top-full left-0 w-48 bg-white shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 py-2 rounded-b-xl border-t-4 border-[#1b5e20] z-50">
                            <li><a href="#" class="block px-5 py-2.5 text-xs text-gray-700 hover:bg-green-50 hover:text-[#2e7d32] font-bold transition-colors">OUR MISSION</a></li>
                            <li><a href="#" class="block px-5 py-2.5 text-xs text-gray-700 hover:bg-green-50 hover:text-[#2e7d32] font-bold transition-colors">MANAGEMENT</a></li>
                            <li><a href="#" class="block px-5 py-2.5 text-xs text-gray-700 hover:bg-green-50 hover:text-[#2e7d32] font-bold transition-colors">SERVICES</a></li>
                        </ul>
                    </li>

                    <li><a href="#" class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all border-r border-white/10 tracking-tight uppercase">CONTACT</a></li>
                    
                    <li>
                        <a href="#" class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all flex items-center gap-1.5 border-r border-white/10 tracking-tight uppercase">
                            GUIDE <span class="bg-red-500 text-[9px] px-2 py-0.5 rounded-full font-black animate-pulse">NEW</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all flex items-center gap-1.5 border-r border-white/10 tracking-tight uppercase">
                            MATERIALS <span class="bg-yellow-400 text-black text-[9px] px-2 py-0.5 rounded-full font-black">HOT</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all flex items-center gap-1.5 border-r border-white/10 tracking-tight uppercase">
                            EXAMS <span class="bg-blue-400 text-white text-[9px] px-2 py-0.5 rounded-full font-black">SOON</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all flex items-center gap-1.5 border-r border-white/10 tracking-tight uppercase">
                            RESULTS <span class="bg-red-500 text-[9px] px-2 py-0.5 rounded-full font-black">NEW</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all flex items-center gap-1.5 border-r border-white/10 tracking-tight uppercase">
                            BEHAVIOR <span class="bg-purple-500 text-white text-[9px] px-2 py-0.5 rounded-full font-black animate-pulse">STANDALONE</span>
                        </a>
                    </li>

                    <li>
                        <a href="/login" class="px-4 py-3 text-white text-[12px] font-extrabold hover:bg-white/10 transition-all flex items-center gap-1.5 border-r border-white/10 tracking-tight uppercase">
                            STAFF <span class="bg-white/30 text-[9px] px-2 py-0.5 rounded-full font-black">LOGIN</span>
                        </a>
                    </li>
                </ul>

                <!-- Auth Actions -->
                <div class="flex items-center gap-1.5 lg:gap-3 py-2 lg:py-0">
                    <a href="{{ route('register') }}" class="bg-white/10 hover:bg-white/20 text-white text-[11px] lg:text-[12px] font-bold px-3 lg:px-5 py-2 lg:py-2.5 rounded-lg border border-white/20 transition-all flex items-center gap-2">
                        <i class="fas fa-user-plus text-[10px]"></i>
                        <span>JISAJILI</span>
                    </a>
                    <a href="{{ route('login') }}" class="bg-[#f59e0b] hover:bg-[#d97706] text-[#1e293b] text-[11px] lg:text-[12px] font-bold px-3 lg:px-5 py-2 lg:py-2.5 rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                        <i class="fas fa-sign-in-alt text-[10px]"></i>
                        <span>LOGIN</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Mobile Menu (Drawer) -->
<div class="fixed inset-0 bg-black/40 z-[200] hidden backdrop-blur-sm transition-opacity duration-300" id="mobileMenuOverlay"></div>
<div class="fixed inset-y-0 left-0 w-[280px] bg-white z-[201] transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden" id="mobileMenuDrawer">
    <div class="flex flex-col h-full shadow-2xl">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <img src="{{ asset('emblem.png') }}" alt="Logo" class="h-8">
            <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors" id="closeMobileMenu">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Menu Links -->
        <div class="flex-1 overflow-y-auto py-4 px-3">
            <nav class="space-y-1">
                <a href="{{ route('landing') }}" class="flex items-center gap-4 px-4 py-3 text-green-700 bg-green-50 font-bold rounded-xl transition-colors">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span class="text-sm">NYUMBANI</span>
                </a>
                
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold rounded-xl transition-all">
                    <i class="fas fa-info-circle w-5 text-center opacity-70"></i>
                    <span class="text-sm uppercase">ABOUT US</span>
                </a>

                <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold rounded-xl transition-all group">
                    <span class="flex items-center gap-4">
                        <i class="fas fa-book w-5 text-center opacity-70"></i>
                        <span class="text-sm">MATERIALS</span>
                    </span>
                    <span class="px-2 py-0.5 bg-yellow-400 text-[9px] font-black rounded-full text-black">HOT</span>
                </a>

                <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold rounded-xl transition-all">
                    <span class="flex items-center gap-4">
                        <i class="fas fa-file-alt w-5 text-center opacity-70"></i>
                        <span class="text-sm">EXAMINATIONS</span>
                    </span>
                    <span class="px-2 py-0.5 bg-blue-400 text-[9px] font-black rounded-full text-white">SOON</span>
                </a>

                <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold rounded-xl transition-all">
                    <span class="flex items-center gap-4">
                        <i class="fas fa-poll w-5 text-center opacity-70"></i>
                        <span class="text-sm uppercase">RESULTS</span>
                    </span>
                    <span class="px-2 py-0.5 bg-red-500 text-[9px] font-black rounded-full text-white animate-pulse">NEW</span>
                </a>

                <div class="my-4 border-t border-gray-100"></div>

                <a href="#" class="flex items-center justify-between px-4 py-3 text-purple-700 hover:bg-purple-50 font-bold rounded-xl transition-all">
                    <span class="flex items-center gap-4">
                        <i class="fas fa-user-shield w-5 text-center"></i>
                        <span class="text-sm uppercase">BEHAVIOR</span>
                    </span>
                    <i class="fas fa-external-link-alt text-[10px] opacity-50"></i>
                </a>

                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 font-semibold rounded-xl transition-all">
                    <i class="fas fa-envelope w-5 text-center opacity-70"></i>
                    <span class="text-sm uppercase">CONTACT</span>
                </a>
            </nav>
        </div>

        <!-- Auth Footer -->
        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
            <div class="flex items-center gap-2">
                <a href="{{ route('register') }}" class="flex-1 flex items-center justify-center gap-2 py-3 bg-white border border-gray-200 text-gray-800 font-bold rounded-xl text-xs uppercase shadow-sm">
                    <i class="fas fa-user-plus text-[10px]"></i>
                    JISAJILI
                </a>
                <a href="{{ route('login') }}" class="flex-1 flex items-center justify-center gap-2 py-3 bg-[#f59e0b] text-white font-bold rounded-xl text-xs uppercase shadow-md">
                    <i class="fas fa-sign-in-alt text-[10px]"></i>
                    LOGIN
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobileMenuBtn');
        const overlay = document.getElementById('mobileMenuOverlay');
        const drawer = document.getElementById('mobileMenuDrawer');
        const close = document.getElementById('closeMobileMenu');

        function openMenu() {
            drawer.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            drawer.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        btn?.addEventListener('click', function(e) {
            e.preventDefault();
            openMenu();
        });

        close?.addEventListener('click', closeMenu);
        overlay?.addEventListener('click', closeMenu);
    });
</script>
