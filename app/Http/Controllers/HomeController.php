<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Region;
use App\Models\Result;
use App\Models\ResultTitle;
use App\Models\School;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $yearsCount = Year::count();
        $levelsCount = Level::count();
        $regionsCount = Region::count();
        $schoolsCount = School::count();
        $resultsCount = Result::count();
        $draftsCount = Result::where('status', 'Draft')->count();

        $recentResults = Result::with(['school', 'resultTitle.year', 'resultTitle.level'])
            ->latest()
            ->take(8)
            ->get();

        $resultsPerYear = Year::leftJoin('result_titles', 'result_titles.year_id', '=', 'years.id')
            ->leftJoin('results', 'results.result_title_id', '=', 'result_titles.id')
            ->select('years.year', DB::raw('COUNT(results.id) as total'))
            ->groupBy('years.year')
            ->orderBy('years.year')
            ->get();

        $yearLabels = $resultsPerYear->pluck('year')->map(fn ($y) => (string) $y)->values();
        $yearData = $resultsPerYear->pluck('total')->map(fn ($t) => (int) $t)->values();

        $resultsPerLevel = Level::leftJoin('result_titles', 'result_titles.level_id', '=', 'levels.id')
            ->leftJoin('results', 'results.result_title_id', '=', 'result_titles.id')
            ->select('levels.name', DB::raw('COUNT(results.id) as total'))
            ->groupBy('levels.name')
            ->orderBy('levels.name')
            ->get();

        $levelLabels = $resultsPerLevel->pluck('name')->values();
        $levelData = $resultsPerLevel->pluck('total')->map(fn ($t) => (int) $t)->values();

        $latestYear = Year::orderBy('year', 'desc')->first();
        $latestYearLevelMissing = null;

        if ($latestYear) {
            $candidate = ResultTitle::where('year_id', $latestYear->id)
                ->select('level_id')
                ->groupBy('level_id')
                ->get();

            if ($candidate->count() > 0) {
                $missingTitle = ResultTitle::where('year_id', $latestYear->id)
                    ->whereDoesntHave('results')
                    ->with('level')
                    ->latest('id')
                    ->first();

                if ($missingTitle && $missingTitle->level) {
                    $latestYearLevelMissing = $latestYear->year . ' ' . $missingTitle->level->name;
                }
            }
        }

        $dbDriver = config('database.default');

        return view('home', compact(
            'yearsCount',
            'levelsCount',
            'regionsCount',
            'schoolsCount',
            'resultsCount',
            'draftsCount',
            'recentResults',
            'yearLabels',
            'yearData',
            'levelLabels',
            'levelData',
            'latestYearLevelMissing',
            'dbDriver'
        ));
    }
}
