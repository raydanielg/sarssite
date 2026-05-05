@extends('landing.layouts.app')

@section('title', 'System Sitemap')

@section('content')
<section class="bg-white">
    <div class="max-w-6xl mx-auto px-4 py-12 sm:py-16">
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-gray-900">System Sitemap</h1>
            <p class="mt-3 text-gray-500 font-medium">Chagua link yoyote hapa chini kwenda kwenye sehemu ya mfumo, ikiwemo Results mpaka PDF.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
                <h2 class="text-sm font-black uppercase tracking-widest text-gray-900 flex items-center gap-2">
                    <i class="ri-links-line text-primary-600"></i> Quick Pages
                </h2>
                <div class="mt-5 space-y-3">
                    <a href="{{ route('landing') }}" class="block text-gray-700 hover:text-primary-600 font-bold">Home</a>
                    <a href="{{ route('results.index') }}" class="block text-gray-700 hover:text-primary-600 font-bold">Results Portal</a>
                    <a href="{{ route('results.tour') }}" class="block text-gray-700 hover:text-primary-600 font-bold">System Tour</a>
                    <a href="/login" class="block text-gray-700 hover:text-primary-600 font-bold">Staff Login</a>
                    <a href="{{ route('sitemap.xml') }}" class="block text-gray-700 hover:text-primary-600 font-bold">Sitemap XML</a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 lg:col-span-2">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <h2 class="text-sm font-black uppercase tracking-widest text-gray-900 flex items-center gap-2">
                        <i class="ri-file-list-3-line text-primary-600"></i> Results Navigation
                    </h2>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Year → Level → Examination → Schools/PDF</div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-900">Years</h3>
                        <div class="mt-3 space-y-2">
                            @forelse($years as $y)
                                <a class="block text-sm font-bold text-gray-700 hover:text-primary-600" href="{{ route('results.year', $y->year) }}">{{ $y->year }}</a>
                            @empty
                                <div class="text-sm text-gray-500">Hakuna years zilizowekwa.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-900">Recent Examinations</h3>
                        <div class="mt-3 space-y-2">
                            @forelse($resultTitles->take(12) as $t)
                                @if($t->year && $t->level)
                                    <a class="block text-sm font-bold text-gray-700 hover:text-primary-600" href="{{ route('results.final', [$t->year->year, $t->level->slug, $t->slug]) }}">
                                        {{ $t->name }}
                                    </a>
                                @endif
                            @empty
                                <div class="text-sm text-gray-500">Hakuna examinations zilizowekwa.</div>
                            @endforelse
                        </div>
                        <div class="mt-4 text-[11px] text-gray-500">
                            Kuona list yote ya examinations, nenda kwenye Results Portal kisha chagua Year/Level.
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-primary-50 border border-primary-100 rounded-xl p-5">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-600 text-white flex items-center justify-center">
                            <i class="ri-information-line text-xl"></i>
                        </div>
                        <div>
                            <div class="text-sm font-black text-gray-900">Tip</div>
                            <div class="text-sm text-gray-600 font-medium">
                                Ukishafika kwenye “School List” au “Result Summary”, bonyeza item yoyote kufungua PDF viewer.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
