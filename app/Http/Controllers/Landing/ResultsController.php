<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function index()
    {
        $years = Year::orderBy('year', 'desc')->get();
        return view('landing.results.index', compact('years'));
    }

    public function showYear($year)
    {
        $yearData = Year::where('year', $year)->firstOrFail();
        $levels = \App\Models\Level::all();
        return view('landing.results.year', compact('yearData', 'levels'));
    }

    public function showLevelResults($year, $level_slug)
    {
        $yearData = Year::where('year', $year)->firstOrFail();
        $level = \App\Models\Level::where('slug', $level_slug)->firstOrFail();
        
        // Tunachukua result titles na kuhesabu idadi ya shule (centres) kwa kila title
        $resultTitles = \App\Models\ResultTitle::where('year_id', $yearData->id)
                                             ->where('level_id', $level->id)
                                             ->withCount('results')
                                             ->with('resultType')
                                             ->get();
        
        return view('landing.results.titles', compact('yearData', 'level', 'resultTitles'));
    }

    public function showFinalResults(Request $request, $year, $level_slug, $title_slug)
    {
        $yearData = Year::where('year', $year)->firstOrFail();
        $level = \App\Models\Level::where('slug', $level_slug)->firstOrFail();
        $resultTitle = \App\Models\ResultTitle::where('slug', $title_slug)->firstOrFail();
        
        $query = \App\Models\Result::where('result_title_id', $resultTitle->id)
                                   ->with('school');

        // Filtering by search text
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('school', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        // Filtering by alphabet
        if ($request->has('letter') && $request->letter != 'ALL') {
            $letter = $request->letter;
            $query->whereHas('school', function($q) use ($letter) {
                $q->where('name', 'like', $letter . '%');
            });
        }

        $results = $query->get();

        return view('landing.results.final', compact('yearData', 'level', 'resultTitle', 'results'));
    }

    public function viewPdf(Request $request)
    {
        $filePath = $request->query('file');
        if (!$filePath) {
            abort(404);
        }

        return view('landing.results.pdf_viewer', compact('filePath'));
    }
}
