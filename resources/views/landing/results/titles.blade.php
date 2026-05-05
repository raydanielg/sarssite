@extends('landing.layouts.results_layout')

@section('title', 'Examinations - ' . $yearData->year)

@section('content')
<section class="py-12 sm:py-20 bg-[#e9ecef] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-6xl animate__animated animate__fadeIn">
        <div class="bg-[#f8fafc]/90 backdrop-blur-sm rounded-[2rem] shadow-xl overflow-hidden border border-white/20">
            <!-- Header Section -->
            <div class="p-6 sm:p-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-[#1e293b] mb-2">Examinations</h1>
                    <p class="text-gray-500 text-sm font-medium">Table with three columns as requested.</p>
                </div>
                <a href="{{ route('results.year', $yearData->year) }}" class="inline-flex items-center gap-2 px-5 py-2 bg-white border border-gray-200 text-[#1e293b] text-sm font-bold rounded-full shadow-sm hover:shadow-md hover:bg-gray-50 transition-all group">
                    <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i> Back
                </a>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#d1dbe4]/50">
                            <th class="px-6 sm:px-10 py-4 text-sm font-bold text-[#1e293b] tracking-tight border-b border-gray-200/50">Examination Name</th>
                            <th class="px-6 py-4 text-sm font-bold text-[#1e293b] tracking-tight border-b border-gray-200/50">Centres</th>
                            <th class="px-6 sm:px-10 py-4 text-sm font-bold text-[#1e293b] tracking-tight border-b border-gray-200/50 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white/40">
                        @forelse($resultTitles as $title)
                        <tr class="hover:bg-white/60 transition-colors group">
                            <td class="px-6 sm:px-10 py-6">
                                <div class="flex flex-col gap-2">
                                    <span class="text-[15px] font-bold text-[#1e293b]">{{ $title->name }}</span>
                                    <div class="flex flex-wrap gap-2">
                                        <!-- Level Badge -->
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-[#475569] text-[11px] font-bold rounded-full border border-gray-200">
                                            <i class="ri-stack-line"></i> {{ $level->name }}
                                        </span>
                                        <!-- Status Badge -->
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-[#dcfce7] text-[#166534] text-[11px] font-bold rounded-full border border-[#bbf7d0]">
                                            <i class="ri-checkbox-circle-fill"></i> Published
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-lg font-bold text-[#1e293b]">{{ $title->results_count }}</span>
                            </td>
                            <td class="px-6 sm:px-10 py-6 text-right">
                                <a href="{{ route('results.final', [$yearData->year, $level->slug, $title->slug]) }}" 
                                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#0061f2] text-white text-sm font-bold rounded-full shadow-lg shadow-blue-200 hover:bg-[#0052d1] hover:-translate-y-0.5 transition-all active:scale-95">
                                    <i class="ri-school-line"></i> View Schools
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="ri-folder-open-line text-4xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">No examinations found for this category.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Spacing -->
            <div class="h-10"></div>
        </div>
    </div>
</section>
@endsection
