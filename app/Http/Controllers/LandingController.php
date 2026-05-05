<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Level;
use App\Models\Region;
use App\Models\Result;
use App\Models\Announcement;
use App\Models\ResultTitle;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $years = Year::orderBy('year', 'desc')->get();
        
        // Tunapitisha $years pia kwenye landing view ili Mega Menu ifanye kazi
        $levels = \App\Models\Level::all();
        $regions = \App\Models\Region::all();
        $announcements = \App\Models\Announcement::where('is_active', true)->latest()->get();
        $latestResults = \App\Models\Result::with(['school', 'resultTitle.year', 'resultTitle.level', 'resultTitle.region'])->latest()->take(6)->get();

        return view('landing.index', compact('years', 'levels', 'regions', 'announcements', 'latestResults'));
    }

    public function sitemap()
    {
        $years = Year::orderBy('year', 'desc')->get();
        $levels = Level::orderBy('name')->get();

        $resultTitles = ResultTitle::with(['year', 'level'])
            ->orderByDesc('id')
            ->get();

        return view('landing.sitemap', compact('years', 'levels', 'resultTitles'));
    }

    public function sitemapXml(Request $request)
    {
        $baseUrl = rtrim(config('app.url') ?: $request->getSchemeAndHttpHost(), '/');

        $urls = [];
        $urls[] = [
            'loc' => $baseUrl . route('landing', [], false),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];
        $urls[] = [
            'loc' => $baseUrl . route('results.index', [], false),
            'changefreq' => 'daily',
            'priority' => '0.9',
        ];
        $urls[] = [
            'loc' => $baseUrl . route('sitemap', [], false),
            'changefreq' => 'weekly',
            'priority' => '0.4',
        ];

        foreach (Year::orderBy('year', 'desc')->get() as $year) {
            $urls[] = [
                'loc' => $baseUrl . route('results.year', [$year->year], false),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        foreach (ResultTitle::with(['year', 'level'])->get() as $title) {
            if (!$title->year || !$title->level) {
                continue;
            }

            $urls[] = [
                'loc' => $baseUrl . route('results.final', [$title->year->year, $title->level->slug, $title->slug], false),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        $xml = view('landing.sitemap_xml', compact('urls'));
        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
