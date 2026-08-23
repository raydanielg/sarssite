@extends('landing.layouts.results_layout')

@section('title', 'Results - ' . $resultTitle->name)

@push('css')
<style>
    .alpha-link {
        display: inline-block;
        padding: 2px 6px;
        margin: 2px;
        border: 1px solid #1f7a35;
        background: #f8fafc;
        color: #1f7a35;
        text-decoration: none;
        font-weight: bold;
        font-size: 13px;
        border-radius: 2px;
        transition: all 0.2s;
    }
    .alpha-link:hover, .alpha-link.active {
        background: #1f7a35;
        color: #fff;
        border-color: #1f7a35;
    }
    .all-centres-btn {
        background: #1f7a35;
        color: #fff;
        padding: 4px 12px;
        border: 1px solid #145524;
        font-weight: bold;
        font-size: 13px;
    }
    .schools-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border: 1px solid #9ca3af;
        background: #fff;
    }
    .school-item {
        padding: 6px 10px;
        border: 1px solid #e5e7eb;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: transform 0.2s;
    }
    .school-item:hover {
        transform: scale(1.02);
        z-index: 10;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
    .school-item a {
        color: #0000ee;
        text-decoration: none;
        font-weight: 500;
    }
    .school-item a:hover {
        text-decoration: underline;
    }
    .col-blue { background-color: #d1e9ff; }
    .col-pink { background-color: #fce4ec; }
    .summary-item {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        font-size: 14px;
        font-weight: bold;
        transition: all 0.3s;
    }
    .summary-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }
    .summary-item a {
        color: #1e40af;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tab-btn {
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
    }
    .tab-btn.active {
        background: #1f7a35;
        color: #fff;
        border-bottom-color: #145524;
    }

    @media (max-width: 768px) {
        .schools-container {
            grid-template-columns: repeat(2, 1fr);
        }
        .school-item {
            font-size: 11px;
            padding: 8px 6px;
        }
    }
</style>
@endpush

@section('content')
<div class="breadcrumb-bar fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2 no-print">
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('results.index') }}" class="results-link inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-[#1e293b] text-xs sm:text-sm font-bold rounded-lg transition-all group">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Rudi Mitihani
        </a>
        <div class="flex items-center gap-1 text-[10px] sm:text-xs font-bold text-gray-500 px-3 py-1.5">
            <span class="text-[#1f7a35]">{{ $resultTitle->name }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span>{{ $yearData->year }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-[#1f7a35]">{{ $region->name }}</span>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-blue-700">{{ $district->name }}</span>
        </div>
    </div>
</div>

<section class="pt-24 pb-12 min-h-screen">
    <div class="container mx-auto px-2 max-w-7xl">
        <div class="results-card p-4 sm:p-6 animate__animated animate__fadeInUp">
        
        <!-- Filter & Tabs Section -->
        <div class="text-center mb-6">
            <div class="flex justify-center gap-2 mb-6 flex-wrap">
                <button onclick="switchTab('schools')" id="schools-tab-btn" class="tab-btn active px-6 py-2 bg-white border border-gray-300 font-black text-[13px] uppercase shadow-sm">
                    <i class="ri-school-line mr-1"></i> School List
                </button>
                @if($districtSummaries->isNotEmpty())
                <button onclick="switchTab('districtSummaries')" id="districtSummaries-tab-btn" class="tab-btn px-6 py-2 bg-white border border-gray-300 font-black text-[13px] uppercase shadow-sm">
                    <i class="ri-file-list-3-line mr-1"></i> Summary za Wilaya
                </button>
                @endif
                @if($regionSummaries->isNotEmpty())
                <button onclick="switchTab('regionSummaries')" id="regionSummaries-tab-btn" class="tab-btn px-6 py-2 bg-white border border-gray-300 font-black text-[13px] uppercase shadow-sm">
                    <i class="ri-map-line mr-1"></i> Summary za Mkoa
                </button>
                @endif
            </div>
            
            <div id="schools-filters">
                <p class="text-[11px] font-bold text-gray-700 mb-2 tracking-wide">CLICK ANY LETTER BELOW TO FILTER SCHOOLS BY ALPHABET</p>
                
                <div class="flex flex-wrap justify-center gap-0.5 max-w-2xl mx-auto mb-6">
                    <a href="{{ request()->fullUrlWithQuery(['letter' => 'ALL']) }}" 
                       class="alpha-link {{ request('letter') == 'ALL' || !request('letter') ? 'active' : '' }}">
                        ALL
                    </a>
                    @foreach(range('A', 'Z') as $char)
                        <a href="{{ request()->fullUrlWithQuery(['letter' => $char]) }}" 
                           class="alpha-link {{ request('letter') == $char ? 'active' : '' }}">
                            {{ $char }}
                        </a>
                    @endforeach
                </div>

                <!-- Search Input -->
                <div class="max-w-md mx-auto relative mb-8">
                    <form action="{{ url()->current() }}" method="GET">
                        @if(request('letter')) <input type="hidden" name="letter" value="{{ request('letter') }}"> @endif
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Andika jina la shule, mf. 'Nyakato' au 'Girls'"
                               class="w-full pl-4 pr-10 py-2 border border-gray-400 text-sm focus:outline-none focus:border-blue-500 shadow-inner rounded-sm">
                        @if(request('search'))
                            <a href="{{ request()->fullUrlWithQuery(['search' => '']) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="ri-close-line"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Sections -->
        <div id="schools-content">
            @php
                $count = $results->count();
            @endphp

            @if($count > 0)
                <div class="schools-container animate__animated animate__fadeIn">
                    @foreach($results as $index => $result)
                        @php
                            $colColorClass = '';
                            $mod = $index % 3;
                            if ($mod == 0) $colColorClass = 'col-blue';
                            elseif ($mod == 1) $colColorClass = 'col-pink';
                            else $colColorClass = 'col-green';
                        @endphp
                        <div class="school-item {{ $colColorClass }}">
                            <a href="{{ route('results.view_pdf', ['file' => $result->file_path, 'name' => $result->school->code . '-' . $result->school->name]) }}">
                                {{ $result->school->code }} – {{ strtoupper($result->school->name) }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-12 text-center border border-gray-300 rounded shadow-sm">
                    <i class="ri-search-line text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500 font-bold uppercase tracking-widest text-xs">Hakuna shule iliyopatikana.</p>
                </div>
            @endif
        </div>

        <!-- District Summaries Tab -->
        <div id="districtSummaries-content" class="hidden">
            <div class="max-w-3xl mx-auto bg-white border border-gray-300 shadow-sm animate__animated animate__fadeIn">
                <div class="bg-gray-50 p-4 border-b border-gray-200">
                    <h4 class="text-sm font-black text-[#1e293b] uppercase tracking-wider flex items-center gap-2">
                        <i class="ri-file-info-line text-blue-600"></i> Summary za Wilaya ya {{ $district->name }}
                    </h4>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($districtSummaries as $summary)
                        <div class="summary-item bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-file-pdf-fill text-red-600 text-xl"></i>
                                    <span>{{ strtoupper($summary->name) }}</span>
                                </div>
                                <a href="{{ route('results.view_pdf', ['file' => $summary->file_path, 'name' => $summary->name]) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                                    <i class="ri-eye-line"></i> View
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <i class="ri-file-list-off-line text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Hakuna muhtasari wa Wilaya uliowekwa.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Region Summaries Tab -->
        <div id="regionSummaries-content" class="hidden">
            <div class="max-w-3xl mx-auto bg-white border border-gray-300 shadow-sm animate__animated animate__fadeIn">
                <div class="bg-gray-50 p-4 border-b border-gray-200">
                    <h4 class="text-sm font-black text-[#1e293b] uppercase tracking-wider flex items-center gap-2">
                        <i class="ri-map-line text-green-600"></i> Summary za Mkoa wa {{ $region->name }}
                    </h4>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($regionSummaries as $summary)
                        <div class="summary-item bg-white">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ri-file-pdf-fill text-red-600 text-xl"></i>
                                    <span>{{ strtoupper($summary->name) }}</span>
                                </div>
                                <a href="{{ route('results.view_pdf', ['file' => $summary->file_path, 'name' => $summary->name]) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                                    <i class="ri-eye-line"></i> View
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <i class="ri-file-list-off-line text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Hakuna muhtasari wa Mkoa uliowekwa.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        </div>
    </div>
</section>

<script>
    function switchTab(tab) {
        const tabs = ['schools', 'districtSummaries', 'regionSummaries'];
        const filters = document.getElementById('schools-filters');

        tabs.forEach(t => {
            const btn = document.getElementById(t + '-tab-btn');
            const content = document.getElementById(t + '-content');
            if (btn && content) {
                if (t === tab) {
                    btn.classList.add('active');
                    content.classList.remove('hidden');
                } else {
                    btn.classList.remove('active');
                    content.classList.add('hidden');
                }
            }
        });

        if (filters) {
            if (tab === 'schools') {
                filters.classList.remove('hidden');
            } else {
                filters.classList.add('hidden');
            }
        }
    }

    // Auto-switch to schools tab if there's a search or letter filter
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search') || (urlParams.has('letter') && urlParams.get('letter') !== 'ALL')) {
            switchTab('schools');
        }
    };
</script>
@endsection
