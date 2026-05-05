@extends('landing.layouts.results_layout')

@section('title', 'Results - ' . $resultTitle->name)

@push('css')
<style>
    .alpha-link {
        display: inline-block;
        padding: 2px 6px;
        margin: 2px;
        border: 1px solid #004085;
        background: #f8fafc;
        color: #004085;
        text-decoration: none;
        font-weight: bold;
        font-size: 13px;
        border-radius: 2px;
        transition: all 0.2s;
    }
    .alpha-link:hover, .alpha-link.active {
        background: #f59e0b; /* Yellow/Orange match */
        color: #000;
        border-color: #f59e0b;
    }
    .all-centres-btn {
        background: #f59e0b;
        color: #000;
        padding: 4px 12px;
        border: 1px solid #000;
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
    .col-green { background-color: #dcfce7; }

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
<div class="fixed top-0 left-0 w-full p-3 sm:p-4 z-50 flex flex-col gap-2 no-print">
    <div>
        <a href="{{ route('results.level', [$yearData->year, $level->slug]) }}" class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-white/90 backdrop-blur text-[#1e293b] text-xs sm:text-sm font-bold rounded-xl shadow-sm hover:shadow-md hover:text-blue-600 transition-all group border border-white/20">
            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Back to Results
        </a>
    </div>
</div>

<section class="pt-24 pb-12 bg-[#e2e2e2] min-h-screen">
    <div class="container mx-auto px-2 max-w-7xl">
        
        <!-- Filter Section -->
        <div class="text-center mb-6">
            <div class="flex justify-center gap-2 mb-4">
                <a href="{{ request()->fullUrlWithQuery(['letter' => 'ALL']) }}" class="all-centres-btn uppercase">All Centres</a>
                <button class="bg-[#dbeafe] text-[#1e40af] px-3 py-1 border border-blue-800 font-bold text-[13px] uppercase">Private Candidates (PC)</button>
            </div>
            
            <p class="text-[11px] font-bold text-gray-700 mb-2 tracking-wide">CLICK ANY LETTER BELOW TO FILTER SCHOOLS BY ALPHABET</p>
            
            <div class="flex flex-wrap justify-center gap-0.5 max-w-2xl mx-auto mb-6">
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
                           class="w-full pl-4 pr-10 py-2 border border-gray-400 text-sm focus:outline-none focus:border-blue-500 shadow-inner">
                    @if(request('search'))
                        <a href="{{ request()->fullUrlWithQuery(['search' => '']) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="ri-close-line"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Schools Grid -->
        @php
            $count = $results->count();
            // Kwenye PC tunataka 3 columns, kwenye Mobile 2 columns.
            // Tutatengeneza list moja kisha CSS itapanga columns.
        @endphp

        @if($count > 0)
            <div class="schools-container animate__animated animate__fadeIn">
                @foreach($results as $index => $result)
                    @php
                        // Hii logic ni kwa ajili ya kupanga rangi tu kulingana na index
                        $colColorClass = '';
                        $mod = $index % 3;
                        if ($mod == 0) $colColorClass = 'col-blue';
                        elseif ($mod == 1) $colColorClass = 'col-pink';
                        else $colColorClass = 'col-green';
                    @endphp
                    <div class="school-item {{ $colColorClass }}">
                        <a href="{{ route('results.view_pdf', ['file' => $result->file_path]) }}">
                            {{ $result->school->code }} – {{ strtoupper($result->school->name) }}
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-12 text-center border border-gray-300 rounded shadow-sm">
                <i class="ri-search-line text-4xl text-gray-300 mb-2"></i>
                <p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Hakuna shule iliyoonekana kwa utafutaji huu.</p>
                <a href="{{ url()->current() }}" class="text-blue-600 text-xs underline mt-2 inline-block">Reset search</a>
            </div>
        @endif

    </div>
</section>
@endsection
