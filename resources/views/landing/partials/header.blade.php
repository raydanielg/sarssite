<!-- Main Header -->
<header class="bg-[#1b5e20] shadow-md sticky top-0 z-[100]">
    <!-- Branding Bar -->
    <div class="container mx-auto px-4 py-3 lg:py-4">
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
                <p class="text-white/70 text-sm lg:text-base font-semibold mt-1 tracking-wide">Student Academic Results System (SARS)</p>
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

                    <!-- About Dropdown -->
                    <li class="nav-dropdown">
                        <a href="#" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300">
                            <i class="ri-information-line"></i> About <i class="bi bi-chevron-down text-xs ml-0.5"></i>
                        </a>
                        <ul class="nav-dropdown-menu">
                            <li><a href="{{ route('landing') }}#about">About Us</a></li>
                            <li><a href="{{ route('landing') }}#mission">Mission and Vision</a></li>
                            <li><a href="{{ route('landing') }}#core-values">Core Values</a></li>
                            <li><a href="{{ route('landing') }}#roles">Roles</a></li>
                        </ul>
                    </li>

                    <!-- Exam Types Dropdown -->
                    <li class="nav-dropdown">
                        <a href="#" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300">
                            <i class="ri-file-list-3-line"></i> Exam Types <i class="bi bi-chevron-down text-xs ml-0.5"></i>
                        </a>
                        <ul class="nav-dropdown-menu">
                            @foreach($resultTypes ?? [] as $type)
                                <li><a href="{{ route('results.index') }}">{{ $type->name }}</a></li>
                            @endforeach
                            @if(empty($resultTypes) || count($resultTypes) === 0)
                                <li><a href="{{ route('results.index') }}">All Exam Types</a></li>
                            @endif
                        </ul>
                    </li>

                    <!-- Results Dropdown -->
                    <li class="nav-dropdown">
                        <a href="{{ route('results.index') }}" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300 {{ request()->routeIs('results.*') ? 'bg-white/10 border-b-2 border-yellow-400' : '' }}">
                            <i class="ri-bar-chart-box-line"></i> Results <i class="bi bi-chevron-down text-xs ml-0.5"></i>
                        </a>
                        <ul class="nav-dropdown-menu">
                            @foreach($resultTitles ?? [] as $title)
                                <li><a href="{{ route('results.exam_years', \Illuminate\Support\Str::slug($title->name)) }}">{{ $title->name }}</a></li>
                            @endforeach
                            @if(empty($resultTitles) || count($resultTitles) === 0)
                                <li><a href="{{ route('results.index') }}">All Results</a></li>
                            @endif
                        </ul>
                    </li>

                    <!-- Services -->
                    <li>
                        <a href="{{ route('landing') }}#services" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300">
                            <i class="ri-customer-service-2-line"></i> Services
                        </a>
                    </li>

                    <!-- FAQ -->
                    <li>
                        <a href="{{ route('landing') }}#faq" class="nav-link flex items-center gap-1.5 px-4 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300">
                            <i class="ri-question-line"></i> FAQ
                        </a>
                    </li>

                    <!-- Contacts -->
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
            <!-- About Dropdown (Mobile) -->
            <li>
                <a href="javascript:void(0)" onclick="toggleMobileDropdown('aboutDropdown')" class="flex items-center justify-between gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <span class="flex items-center gap-2"><i class="ri-information-line"></i> About</span>
                    <i class="bi bi-chevron-down text-xs"></i>
                </a>
                <div id="aboutDropdown" class="mobile-dropdown-content">
                    <a href="{{ route('landing') }}#about" class="block px-10 py-2 text-white/80 text-sm hover:text-yellow-400 transition-all">About Us</a>
                    <a href="{{ route('landing') }}#mission" class="block px-10 py-2 text-white/80 text-sm hover:text-yellow-400 transition-all">Mission and Vision</a>
                    <a href="{{ route('landing') }}#core-values" class="block px-10 py-2 text-white/80 text-sm hover:text-yellow-400 transition-all">Core Values</a>
                    <a href="{{ route('landing') }}#roles" class="block px-10 py-2 text-white/80 text-sm hover:text-yellow-400 transition-all">Roles</a>
                </div>
            </li>
            <!-- Exam Types Dropdown (Mobile) -->
            <li>
                <a href="javascript:void(0)" onclick="toggleMobileDropdown('examTypesDropdown')" class="flex items-center justify-between gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <span class="flex items-center gap-2"><i class="ri-file-list-3-line"></i> Exam Types</span>
                    <i class="bi bi-chevron-down text-xs"></i>
                </a>
                <div id="examTypesDropdown" class="mobile-dropdown-content">
                    @foreach($resultTypes ?? [] as $type)
                        <a href="{{ route('results.index') }}" class="block px-10 py-2 text-white/80 text-sm hover:text-yellow-400 transition-all">{{ $type->name }}</a>
                    @endforeach
                    @if(empty($resultTypes) || count($resultTypes) === 0)
                        <a href="{{ route('results.index') }}" class="block px-10 py-2 text-white/80 text-sm hover:text-yellow-400 transition-all">All Exam Types</a>
                    @endif
                </div>
            </li>
            <!-- Results Dropdown (Mobile) -->
            <li>
                <a href="javascript:void(0)" onclick="toggleMobileDropdown('resultsDropdown')" class="flex items-center justify-between gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <span class="flex items-center gap-2"><i class="ri-bar-chart-box-line"></i> Results</span>
                    <i class="bi bi-chevron-down text-xs"></i>
                </a>
                <div id="resultsDropdown" class="mobile-dropdown-content">
                    @foreach($resultTitles ?? [] as $title)
                        <a href="{{ route('results.exam_years', \Illuminate\Support\Str::slug($title->name)) }}" class="block px-10 py-2 text-white/80 text-sm hover:text-yellow-400 transition-all">{{ $title->name }}</a>
                    @endforeach
                    @if(empty($resultTitles) || count($resultTitles) === 0)
                        <a href="{{ route('results.index') }}" class="block px-10 py-2 text-white/80 text-sm hover:text-yellow-400 transition-all">All Results</a>
                    @endif
                </div>
            </li>
            <li>
                <a href="{{ route('landing') }}#services" class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <i class="ri-customer-service-2-line"></i> Services
                </a>
            </li>
            <li>
                <a href="{{ route('landing') }}#faq" class="flex items-center gap-2 px-6 py-3 text-white text-sm font-bold hover:bg-white/10 transition-all">
                    <i class="ri-question-line"></i> FAQ
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

function toggleMobileDropdown(id) {
    const el = document.getElementById(id);
    el.classList.toggle('open');
}
</script>
