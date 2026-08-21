<!-- Main Header -->
<header class="bg-[#1b5e20] shadow-md sticky top-0 z-[100]">
    <!-- Branding Bar -->
    <div class="container mx-auto px-4 py-3 lg:py-5">
        <div class="flex items-center justify-between relative">
            <!-- Left: Coat of Arms -->
            <div class="flex items-center">
                <img src="{{ asset('emblem.png') }}" alt="Coat of Arms" class="h-14 lg:h-20 w-auto object-contain">
            </div>

            <!-- Middle: System Title -->
            <div class="text-center flex-1 px-4">
                <h1 class="text-yellow-400 text-base lg:text-2xl font-bold uppercase tracking-tight leading-tight animate__animated animate__fadeInDown">
                    THE REGIONAL EXAMINATION SYSTEM
                </h1>
                <p class="text-white/70 text-[10px] lg:text-xs font-medium mt-0.5 tracking-wide">Student Academic Results System (SARS)</p>
            </div>

            <!-- Right: Logo -->
            <div class="flex items-center">
                 <img src="{{ asset('emblem.png') }}" alt="Logo" class="h-14 lg:h-20 w-auto object-contain brightness-110">
            </div>
        </div>
    </div>

    <!-- Navigation Menu Bar -->
    <nav class="bg-[#0d3c14] border-t border-white/10">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <!-- Desktop Menu -->
                <ul class="hidden md:flex items-center space-x-1">
                    <li>
                        <a href="{{ route('landing') }}" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300 {{ request()->routeIs('landing') ? 'bg-white/10 border-b-2 border-yellow-400' : '' }}">
                            <i class="ri-home-4-line"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('results.index') }}" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300 {{ request()->routeIs('results.*') ? 'bg-white/10 border-b-2 border-yellow-400' : '' }}">
                            <i class="ri-file-list-3-line"></i> Exam Types
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('results.index') }}" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300 {{ request()->routeIs('results.*') ? 'bg-white/10 border-b-2 border-yellow-400' : '' }}">
                            <i class="ri-bar-chart-box-line"></i> Results
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('landing') }}#contacts" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300">
                            <i class="ri-contacts-book-line"></i> Contacts
                        </a>
                    </li>
                </ul>

                <!-- Right side: Login + Mobile toggle -->
                <div class="hidden md:flex items-center space-x-3 py-2">
                    <a href="/login" class="flex items-center gap-1.5 px-4 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-[#0d3c14] text-xs font-black rounded-lg transition-all duration-300 hover:shadow-lg">
                        <i class="ri-login-circle-line"></i> Staff Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-white p-3 text-xl" onclick="toggleMobileMenu()">
                    <i class="ri-menu-line"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Drawer -->
    <div id="mobileMenu" class="md:hidden hidden bg-[#0d3c14] border-t border-white/10">
        <ul class="flex flex-col py-2">
            <li>
                <a href="{{ route('landing') }}" class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <i class="ri-home-4-line"></i> Home
                </a>
            </li>
            <li>
                <a href="{{ route('results.index') }}" class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <i class="ri-file-list-3-line"></i> Exam Types
                </a>
            </li>
            <li>
                <a href="{{ route('results.index') }}" class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <i class="ri-bar-chart-box-line"></i> Results
                </a>
            </li>
            <li>
                <a href="{{ route('landing') }}#contacts" class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <i class="ri-contacts-book-line"></i> Contacts
                </a>
            </li>
            <li class="border-t border-white/10 mt-1 pt-2">
                <a href="/login" class="flex items-center gap-2 px-6 py-3 text-yellow-400 text-sm font-black hover:bg-white/10 transition-all">
                    <i class="ri-login-circle-line"></i> Staff Login
                </a>
            </li>
        </ul>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}
</script>
