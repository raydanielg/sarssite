@extends('landing.layouts.app')

@section('title', 'SARS - Regional Examination System')

@section('content')

<!-- ======= Hero Section ======= -->
<section id="hero" class="relative">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner" role="listbox">

            <!-- Slide 1 -->
            <div class="carousel-item active hero-slide relative" style="background-image: linear-gradient(rgba(13,60,20,0.7), rgba(27,94,32,0.8)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1600&q=80');">
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-4 text-center">
                        <div class="max-w-3xl mx-auto animate__animated animate__fadeInUp">
                            <h2 class="text-3xl md:text-5xl font-black text-white mb-4 leading-tight">Welcome to SARS</h2>
                            <p class="text-base md:text-lg text-green-50/90 mb-6 leading-relaxed">Thank you for visiting the official website of the Regional Examination System. We provide national assessment results for schools across Tanzania.</p>
                            <a href="{{ route('results.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-yellow-400 hover:bg-yellow-300 text-[#0d3c14] font-black rounded-lg transition-all duration-300 hover:shadow-xl uppercase tracking-wider text-sm">
                                Check Results <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item hero-slide relative" style="background-image: linear-gradient(rgba(13,60,20,0.7), rgba(27,94,32,0.8)), url('https://images.unsplash.com/photo-1503676265928-4335e85c8da1?w=1600&q=80');">
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-4 text-center">
                        <div class="max-w-3xl mx-auto animate__animated animate__fadeInUp">
                            <h2 class="text-3xl md:text-5xl font-black text-white mb-4 leading-tight">Examination Results</h2>
                            <p class="text-base md:text-lg text-green-50/90 mb-6 leading-relaxed">Access your examination results quickly and securely. Search by year, region, district, and school.</p>
                            <a href="{{ route('results.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-yellow-400 hover:bg-yellow-300 text-[#0d3c14] font-black rounded-lg transition-all duration-300 hover:shadow-xl uppercase tracking-wider text-sm">
                                View Results <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item hero-slide relative" style="background-image: linear-gradient(rgba(13,60,20,0.7), rgba(27,94,32,0.8)), url('https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=1600&q=80');">
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-4 text-center">
                        <div class="max-w-3xl mx-auto animate__animated animate__fadeInUp">
                            <h2 class="text-3xl md:text-5xl font-black text-white mb-4 leading-tight">School Performance</h2>
                            <p class="text-base md:text-lg text-green-50/90 mb-6 leading-relaxed">Track and compare school performance across regions and districts. Transparent and efficient results management.</p>
                            <a href="{{ route('results.tour') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-yellow-400 hover:bg-yellow-300 text-[#0d3c14] font-black rounded-lg transition-all duration-300 hover:shadow-xl uppercase tracking-wider text-sm">
                                Take a Tour <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Carousel Controls -->
        <a class="carousel-control-prev absolute left-0 top-0 bottom-0 flex items-center justify-center w-12 cursor-pointer" href="#heroCarousel" role="button" data-bs-slide="prev">
            <span class="text-white text-3xl"><i class="bi bi-chevron-left"></i></span>
        </a>
        <a class="carousel-control-next absolute right-0 top-0 bottom-0 flex items-center justify-center w-12 cursor-pointer" href="#heroCarousel" role="button" data-bs-slide="next">
            <span class="text-white text-3xl"><i class="bi bi-chevron-right"></i></span>
        </a>

        <!-- Indicators -->
        <ol class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 list-none">
            <li data-bs-target="#heroCarousel" data-bs-slide-to="0" class="w-3 h-3 rounded-full bg-white/50 cursor-pointer transition-all" data-bs-slide-to="0"></li>
            <li data-bs-target="#heroCarousel" data-bs-slide-to="1" class="w-3 h-3 rounded-full bg-white/50 cursor-pointer transition-all"></li>
            <li data-bs-target="#heroCarousel" data-bs-slide-to="2" class="w-3 h-3 rounded-full bg-white/50 cursor-pointer transition-all"></li>
        </ol>
    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= About Us / Events & News Section ======= -->
    <section id="about" class="py-16 bg-white">
        <div class="container mx-auto px-4" data-aos="fade-up">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Events / Announcements (Left) -->
                <div data-aos="fade-right">
                    <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ri-calendar-event-line text-primary-600"></i> Announcements
                    </h2>
                    <div class="space-y-4">
                        @forelse($announcements as $announcement)
                            <div class="flex gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-all duration-300">
                                <div class="flex-shrink-0 w-14 h-14 bg-primary-600 rounded-xl flex flex-col items-center justify-center text-white">
                                    <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($announcement->created_at)->format('M') }}</span>
                                    <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($announcement->created_at)->format('d') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 text-sm leading-snug mb-1">{{ $announcement->title }}</h4>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">{{ $announcement->type }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 bg-gray-50 rounded-xl text-center text-gray-500 text-sm">
                                <i class="ri-inbox-line text-3xl block mb-2 text-gray-300"></i>
                                Hakuna tangazo kwa sasa.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- News / Recent Results (Right) -->
                <div data-aos="fade-left">
                    <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-2">
                        <i class="ri-bar-chart-box-line text-primary-600"></i> Recent Exam Results
                    </h2>
                    <div class="space-y-3">
                        @forelse($resultTitles as $title)
                            @if($title->year && $title->region)
                                @php
                                    $params = [$title->year->year, $title->region->slug];
                                    if ($title->district) {
                                        $params[] = $title->district->slug;
                                        $params[] = $title->slug;
                                    }
                                @endphp
                                <a href="{{ $title->district ? route('results.final', $params) : route('results.districts', $params) }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-primary-200 hover:shadow-md transition-all duration-300 group">
                                    <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-600 transition-colors">
                                        <i class="ri-file-list-3-line text-xl text-primary-600 group-hover:text-white transition-colors"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-gray-900 text-sm truncate group-hover:text-primary-600 transition-colors">{{ $title->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $title->year->year }}
                                            @if($title->resultType) · {{ $title->resultType->name }} @endif
                                            @if($title->region) · {{ $title->region->name }} @endif
                                        </p>
                                    </div>
                                    <i class="ri-arrow-right-s-line text-gray-400 group-hover:text-primary-600 transition-colors"></i>
                                </a>
                            @endif
                        @empty
                            <div class="p-8 bg-gray-50 rounded-xl text-center text-gray-500 text-sm">
                                <i class="ri-inbox-line text-3xl block mb-2 text-gray-300"></i>
                                Hakuna matokeo yaliyowekwa.
                            </div>
                        @endforelse
                    </div>
                    <a href="{{ route('results.index') }}" class="inline-flex items-center gap-1 mt-4 text-primary-600 font-bold text-sm hover:gap-2 transition-all">
                        All Results <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->

    <!-- ======= Mission & Vision Section ======= -->
    <section id="mission" class="py-16 bg-gradient-to-b from-green-50 to-white">
        <div class="container mx-auto px-4" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 mb-3">Mission and Vision</h2>
                <div class="h-1.5 w-20 bg-primary-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div class="p-8 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ri-target-line text-2xl text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Our Mission</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">To provide efficient, transparent, and reliable examination results management system that serves schools, students, and educational stakeholders across Tanzania.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ri-eye-line text-2xl text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Our Vision</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">To be the leading regional examination results platform, leveraging technology to ensure accessible, accurate, and timely academic performance data for all.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= Core Values Section ======= -->
    <section id="core-values" class="py-16 bg-white">
        <div class="container mx-auto px-4" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 mb-3">Core Values</h2>
                <div class="h-1.5 w-20 bg-primary-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-5xl mx-auto">
                <div class="text-center p-6 bg-gray-50 rounded-2xl hover:shadow-md transition-all" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-12 h-12 mx-auto bg-primary-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="ri-shield-check-line text-xl text-primary-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Integrity</h4>
                    <p class="text-xs text-gray-500">Trustworthy results</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-2xl hover:shadow-md transition-all" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-12 h-12 mx-auto bg-primary-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="ri-flashlight-line text-xl text-primary-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Efficiency</h4>
                    <p class="text-xs text-gray-500">Fast and reliable</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-2xl hover:shadow-md transition-all" data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-12 h-12 mx-auto bg-primary-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="ri-eye-2-line text-xl text-primary-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Transparency</h4>
                    <p class="text-xs text-gray-500">Open and clear</p>
                </div>
                <div class="text-center p-6 bg-gray-50 rounded-2xl hover:shadow-md transition-all" data-aos="zoom-in" data-aos-delay="400">
                    <div class="w-12 h-12 mx-auto bg-primary-100 rounded-xl flex items-center justify-center mb-3">
                        <i class="ri-hand-heart-line text-xl text-primary-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Service</h4>
                    <p class="text-xs text-gray-500">Student centered</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= Roles Section ======= -->
    <section id="roles" class="py-16 bg-gradient-to-b from-green-50 to-white">
        <div class="container mx-auto px-4" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 mb-3">Our Roles</h2>
                <div class="h-1.5 w-20 bg-primary-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                    <i class="ri-database-2-line text-3xl text-primary-600 mb-3"></i>
                    <h4 class="font-bold text-gray-900 mb-2">Results Management</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Collecting, processing, and publishing examination results for schools across all regions and districts.</p>
                </div>
                <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="200">
                    <i class="ri-pie-chart-2-line text-3xl text-primary-600 mb-3"></i>
                    <h4 class="font-bold text-gray-900 mb-2">Performance Analysis</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Providing detailed statistical analysis and summaries of school performance for educational planning.</p>
                </div>
                <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm" data-aos="fade-up" data-aos-delay="300">
                    <i class="ri-share-forward-2-line text-3xl text-primary-600 mb-3"></i>
                    <h4 class="font-bold text-gray-900 mb-2">Public Access</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Ensuring students, parents, and the public have easy access to examination results online.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= Services Section ======= -->
    <section id="services" class="py-16 bg-white">
        <div class="container mx-auto px-4" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 mb-3">Our Services</h2>
                <div class="h-1.5 w-20 bg-primary-600 mx-auto rounded-full"></div>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">We provide a range of services to support examination results management and access.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service 1 -->
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ri-search-line text-2xl text-blue-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Check Results</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Search and view examination results by year, region, district, and school name.</p>
                    <a href="{{ route('results.index') }}" class="inline-flex items-center gap-1 mt-3 text-primary-600 font-bold text-sm hover:gap-2 transition-all">View Results <i class="ri-arrow-right-line"></i></a>
                </div>

                <!-- Service 2 -->
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ri-file-chart-line text-2xl text-orange-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Performance Summaries</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">View detailed performance summaries and statistics for regions, districts, and schools.</p>
                </div>

                <!-- Service 3 -->
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ri-school-line text-2xl text-pink-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">School Search</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Find any school by name or code and view their examination performance history.</p>
                </div>

                <!-- Service 4 -->
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="400">
                    <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ri-download-cloud-2-line text-2xl text-yellow-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Download Results</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Download examination results in PDF format for offline access and record keeping.</p>
                </div>

                <!-- Service 5 -->
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="500">
                    <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ri-newspaper-line text-2xl text-red-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Announcements</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Stay updated with the latest news and announcements about examinations and results.</p>
                </div>

                <!-- Service 6 -->
                <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-500" data-aos="zoom-in" data-aos-delay="600">
                    <div class="w-14 h-14 bg-teal-100 rounded-2xl flex items-center justify-center mb-4">
                        <i class="ri-customer-service-2-line text-2xl text-teal-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Support</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Get help and support with any issues related to accessing examination results.</p>
                </div>
            </div>
        </div>
    </section><!-- End Services Section -->

    <!-- ======= FAQ Section ======= -->
    <section id="faq" class="py-16 bg-gradient-to-b from-green-50 to-white">
        <div class="container mx-auto px-4" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 mb-3">Frequently Asked Questions</h2>
                <div class="h-1.5 w-20 bg-primary-600 mx-auto rounded-full"></div>
            </div>
            <div class="max-w-3xl mx-auto space-y-4">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <button onclick="toggleFAQ('faq1')" class="w-full flex items-center justify-between p-5 text-left font-bold text-gray-900 hover:bg-gray-50 transition-all">
                        <span>How can I check my examination results?</span>
                        <i class="bi bi-chevron-down text-gray-400 transition-transform" id="faq1-icon"></i>
                    </button>
                    <div id="faq1" class="mobile-dropdown-content">
                        <p class="px-5 pb-5 text-sm text-gray-600 leading-relaxed">Click on "Results" in the navigation menu, select the year, then choose your region and district to find your school's results.</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <button onclick="toggleFAQ('faq2')" class="w-full flex items-center justify-between p-5 text-left font-bold text-gray-900 hover:bg-gray-50 transition-all">
                        <span>Can I download results in PDF format?</span>
                        <i class="bi bi-chevron-down text-gray-400 transition-transform" id="faq2-icon"></i>
                    </button>
                    <div id="faq2" class="mobile-dropdown-content">
                        <p class="px-5 pb-5 text-sm text-gray-600 leading-relaxed">Yes, once you navigate to a specific result page, you can download the results in PDF format using the download button.</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <button onclick="toggleFAQ('faq3')" class="w-full flex items-center justify-between p-5 text-left font-bold text-gray-900 hover:bg-gray-50 transition-all">
                        <span>How do I search for a specific school?</span>
                        <i class="bi bi-chevron-down text-gray-400 transition-transform" id="faq3-icon"></i>
                    </button>
                    <div id="faq3" class="mobile-dropdown-content">
                        <p class="px-5 pb-5 text-sm text-gray-600 leading-relaxed">Navigate to the results page, select year, region, and district, then use the search bar to find your school by name or code.</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End FAQ Section -->

    <!-- ======= Contacts Section ======= -->
    <section id="contacts" class="py-16 bg-white">
        <div class="container mx-auto px-4" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 mb-3">Wasiliana Nasi</h2>
                <div class="h-1.5 w-20 bg-primary-600 mx-auto rounded-full"></div>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Kwa maswali, maoni au usaidizi, wasiliana nasi kupitia njia zifuatazo.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <div class="group p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary-200 hover:shadow-xl transition-all duration-500 text-center" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-16 h-16 mx-auto mb-4 bg-primary-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="ri-map-pin-line text-3xl text-primary-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Anwani</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">Mkurugenzi wa Mtihani,<br>Mkoa wa <strong>{{ $regions->first()?->name ?? 'Mkoa Wako' }}</strong>,<br>Tanzania</p>
                </div>
                <div class="group p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary-200 hover:shadow-xl transition-all duration-500 text-center" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-16 h-16 mx-auto mb-4 bg-primary-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="ri-phone-line text-3xl text-primary-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Simu</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        <a href="tel:+255123456789" class="hover:text-primary-600 transition-colors">+255 12 345 6789</a><br>
                        <a href="tel:+255987654321" class="hover:text-primary-600 transition-colors">+255 98 765 4321</a>
                    </p>
                </div>
                <div class="group p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary-200 hover:shadow-xl transition-all duration-500 text-center" data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-16 h-16 mx-auto mb-4 bg-primary-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="ri-mail-line text-3xl text-primary-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Barua Pepe</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        <a href="mailto:info@sars.ac.tz" class="hover:text-primary-600 transition-colors">info@sars.ac.tz</a><br>
                        <a href="mailto:support@sars.ac.tz" class="hover:text-primary-600 transition-colors">support@sars.ac.tz</a>
                    </p>
                </div>
            </div>
        </div>
    </section><!-- End Contacts Section -->

</main><!-- End #main -->

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Initialize hero carousel
var heroCarousel = new bootstrap.Carousel(document.getElementById('heroCarousel'), {
    interval: 5000,
    ride: 'carousel',
    wrap: true
});

// FAQ toggle
function toggleFAQ(id) {
    const el = document.getElementById(id);
    const icon = document.getElementById(id + '-icon');
    el.classList.toggle('open');
    if (icon) {
        icon.classList.toggle('bi-chevron-down');
        icon.classList.toggle('bi-chevron-up');
    }
}

// Announcement modal
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
