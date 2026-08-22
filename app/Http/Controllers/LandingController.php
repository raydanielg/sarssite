<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Level;
use App\Models\Region;
use App\Models\Result;
use App\Models\Announcement;
use App\Models\ResultTitle;
use App\Models\ResultType;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $years = Year::orderBy('year', 'desc')->get();
        $levels = Level::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $announcements = Announcement::where('is_active', true)->latest()->take(6)->get();
        $latestResults = Result::with(['school', 'resultTitle.year', 'resultTitle.level', 'resultTitle.region'])->latest()->take(6)->get();
        $resultTypes = ResultType::where('is_active', true)->orderBy('name')->get();

        $resultTitles = ResultTitle::select('name', 'id')->orderByDesc('id')->get()
            ->unique('name')
            ->take(8)
            ->map(function ($t) {
                return (object) ['name' => $t->name];
            });

        return view('landing.sitemap', compact('years', 'levels', 'regions', 'announcements', 'latestResults', 'resultTitles', 'resultTypes'));
    }

    public function sitemap()
    {
        $years = Year::orderBy('year', 'desc')->get();
        $levels = Level::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $announcements = Announcement::where('is_active', true)->latest()->get();

        $resultTitles = ResultTitle::select('name', 'id')->orderByDesc('id')->get()
            ->unique('name')
            ->map(function ($t) {
                return (object) ['name' => $t->name];
            });
        $resultTypes = ResultType::where('is_active', true)->orderBy('name')->get();

        return view('landing.sitemap', compact('years', 'levels', 'regions', 'announcements', 'resultTitles', 'resultTypes'));
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

        foreach (ResultTitle::with(['year', 'region', 'district'])->get() as $title) {
            if (!$title->year || !$title->region) {
                continue;
            }

            $params = [$title->year->year, $title->region->slug];
            if ($title->district) {
                $params[] = $title->district->slug;
                $params[] = $title->slug;
                $urls[] = [
                    'loc' => $baseUrl . route('results.final', $params, false),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            } else {
                $urls[] = [
                    'loc' => $baseUrl . route('results.districts', $params, false),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }
        }

        $xml = view('landing.sitemap_xml', compact('urls'));
        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
