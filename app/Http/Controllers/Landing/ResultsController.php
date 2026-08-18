<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Year;
use App\Models\Region;
use App\Models\District;
use App\Models\ResultTitle;
use App\Models\Result;
use App\Models\ResultSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultsController extends Controller
{
    public function index()
    {
        $years = Year::orderBy('year', 'desc')->get();
        return view('landing.results.index', compact('years'));
    }

    public function tour()
    {
        return view('landing.results.tour');
    }

    public function showYear($year)
    {
        $yearData = Year::where('year', $year)->firstOrFail();

        $regions = Region::whereHas('resultTitles', function ($q) use ($yearData) {
            $q->where('year_id', $yearData->id);
        })->orderBy('name')->get();

        if ($regions->isEmpty()) {
            $regions = Region::orderBy('name')->get();
        }

        return view('landing.results.year', compact('yearData', 'regions'));
    }

    public function showDistricts($year, $region_slug)
    {
        $yearData = Year::where('year', $year)->firstOrFail();
        $region = Region::where('slug', $region_slug)->firstOrFail();

        $districts = District::where('region_id', $region->id)
            ->whereHas('resultTitles', function ($q) use ($yearData) {
                $q->where('year_id', $yearData->id);
            })
            ->orderBy('name')
            ->get();

        if ($districts->isEmpty()) {
            $districts = District::where('region_id', $region->id)->orderBy('name')->get();
        }

        $regionSummaries = ResultSummary::whereHas('resultTitle', function ($q) use ($yearData, $region) {
            $q->where('year_id', $yearData->id)
              ->where('region_id', $region->id)
              ->whereNull('district_id');
        })->get();

        return view('landing.results.districts', compact('yearData', 'region', 'districts', 'regionSummaries'));
    }

    public function showTitles($year, $region_slug, $district_slug)
    {
        $yearData = Year::where('year', $year)->firstOrFail();
        $region = Region::where('slug', $region_slug)->firstOrFail();
        $district = District::where('slug', $district_slug)
            ->where('region_id', $region->id)
            ->firstOrFail();

        $resultTitles = ResultTitle::where('year_id', $yearData->id)
            ->where('region_id', $region->id)
            ->where('district_id', $district->id)
            ->withCount('results')
            ->with('resultType')
            ->orderByDesc('id')
            ->get();

        $districtSummaries = ResultSummary::whereHas('resultTitle', function ($q) use ($yearData, $region, $district) {
            $q->where('year_id', $yearData->id)
              ->where('region_id', $region->id)
              ->where('district_id', $district->id);
        })->get();

        return view('landing.results.titles', compact('yearData', 'region', 'district', 'resultTitles', 'districtSummaries'));
    }

    public function showFinalResults(Request $request, $year, $region_slug, $district_slug, $title_slug)
    {
        $yearData = Year::where('year', $year)->firstOrFail();
        $region = Region::where('slug', $region_slug)->firstOrFail();
        $district = District::where('slug', $district_slug)
            ->where('region_id', $region->id)
            ->firstOrFail();
        $resultTitle = ResultTitle::where('slug', $title_slug)
            ->where('year_id', $yearData->id)
            ->firstOrFail();

        $query = Result::where('result_title_id', $resultTitle->id)
            ->with('school');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('school', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('letter') && $request->letter != 'ALL') {
            $letter = $request->letter;
            $query->whereHas('school', function ($q) use ($letter) {
                $q->where('name', 'like', $letter . '%');
            });
        }

        $results = $query->get();

        $summaries = ResultSummary::where('result_title_id', $resultTitle->id)->get();

        return view('landing.results.final', compact('yearData', 'region', 'district', 'resultTitle', 'results', 'summaries'));
    }

    public function viewPdf(Request $request)
    {
        $filePath = $request->query('file');
        if (!$filePath) {
            abort(404);
        }

        return view('landing.results.pdf_viewer', compact('filePath'));
    }

    public function downloadPdf(Request $request)
    {
        $filePath = $request->query('file');
        $name = $request->query('name');

        if (!$filePath) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        $safeBase = $name ? preg_replace('/[^A-Za-z0-9 _\-]/', '', $name) : pathinfo($filePath, PATHINFO_FILENAME);
        $safeBase = trim(preg_replace('/\s+/', ' ', $safeBase));
        if ($safeBase === '') {
            $safeBase = 'results';
        }

        $downloadName = $safeBase . '.pdf';

        return Storage::disk('public')->download($filePath, $downloadName);
    }
}
