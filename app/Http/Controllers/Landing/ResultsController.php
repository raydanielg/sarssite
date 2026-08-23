<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Year;
use App\Models\Region;
use App\Models\District;
use App\Models\ResultTitle;
use App\Models\Result;
use App\Models\ResultSummary;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResultsController extends Controller
{
    public function index()
    {
        $exams = ResultTitle::selectRaw('name, MAX(created_at) as latest, MAX(level_id) as level_id')
            ->with(['level'])
            ->groupBy('name')
            ->orderByDesc('latest')
            ->get()
            ->map(function ($item) {
                $level = Level::find($item->level_id);
                $title = ResultTitle::where('name', $item->name)->latest()->first();
                $yearsCount = ResultTitle::where('name', $item->name)->select('year_id')->distinct()->count('year_id');
                $resultsCount = Result::whereHas('resultTitle', function ($q) use ($item) {
                    $q->where('name', $item->name);
                })->count();
                return (object) [
                    'name' => $item->name,
                    'slug' => Str::slug($item->name),
                    'level' => $level,
                    'result_type' => $title?->resultType,
                    'years_count' => $yearsCount,
                    'results_count' => $resultsCount,
                    'created_at' => $item->latest,
                ];
            });

        return view('landing.results.index', compact('exams'));
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

        $hasRegionLevelTitles = ResultTitle::where('year_id', $yearData->id)
            ->where('region_id', $region->id)
            ->whereNull('district_id')
            ->exists();

        if ($hasRegionLevelTitles) {
            $districts = District::where('region_id', $region->id)->orderBy('name')->get();
        } else {
            $districts = District::where('region_id', $region->id)
                ->whereHas('resultTitles', function ($q) use ($yearData) {
                    $q->where('year_id', $yearData->id);
                })
                ->orderBy('name')
                ->get();

            if ($districts->isEmpty()) {
                $districts = District::where('region_id', $region->id)->orderBy('name')->get();
            }
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
            ->where(function ($q) use ($district) {
                $q->where('district_id', $district->id)
                  ->orWhereNull('district_id');
            })
            ->withCount('results')
            ->with('resultType')
            ->orderByDesc('id')
            ->get();

        $districtSummaries = ResultSummary::whereHas('resultTitle', function ($q) use ($yearData, $region, $district) {
            $q->where('year_id', $yearData->id)
              ->where('region_id', $region->id)
              ->where(function ($sq) use ($district) {
                  $sq->where('district_id', $district->id)
                    ->orWhereNull('district_id');
              });
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

        $districtSummaries = ResultSummary::where('result_title_id', $resultTitle->id)
            ->whereHas('resultTitle', function ($q) {
                $q->whereNotNull('district_id');
            })->get();

        $regionSummaries = ResultSummary::whereHas('resultTitle', function ($q) use ($yearData, $region, $resultTitle) {
            $q->where('name', $resultTitle->name)
              ->where('year_id', $yearData->id)
              ->where('region_id', $region->id)
              ->whereNull('district_id');
        })->get();

        return view('landing.results.final', compact('yearData', 'region', 'district', 'resultTitle', 'results', 'districtSummaries', 'regionSummaries'));
    }

    public function viewPdf(Request $request)
    {
        $filePath = $request->query('file');
        if (!$filePath) {
            abort(404);
        }

        return view('landing.results.pdf_viewer', compact('filePath'));
    }

    public function showExamYears($examSlug)
    {
        $examName = $this->resolveExamName($examSlug);
        if (!$examName) {
            abort(404);
        }

        $years = Year::whereHas('resultTitles', function ($q) use ($examName) {
            $q->where('name', $examName);
        })->orderBy('year', 'desc')->get();

        $level = ResultTitle::where('name', $examName)->with('level')->first()->level ?? null;

        return view('landing.results.exam_years', compact('examName', 'examSlug', 'years', 'level'));
    }

    public function showExamRegions($examSlug, $year)
    {
        $examName = $this->resolveExamName($examSlug);
        if (!$examName) {
            abort(404);
        }

        $yearData = Year::where('year', $year)->firstOrFail();

        $regions = Region::whereHas('resultTitles', function ($q) use ($examName, $yearData) {
            $q->where('name', $examName)->where('year_id', $yearData->id);
        })->orderBy('name')->get();

        if ($regions->isEmpty()) {
            $regions = Region::orderBy('name')->get();
        }

        return view('landing.results.exam_regions', compact('examName', 'examSlug', 'yearData', 'regions'));
    }

    public function showExamDistricts($examSlug, $year, $region_slug)
    {
        $examName = $this->resolveExamName($examSlug);
        if (!$examName) {
            abort(404);
        }

        $yearData = Year::where('year', $year)->firstOrFail();
        $region = Region::where('slug', $region_slug)->firstOrFail();

        $hasRegionLevelTitles = ResultTitle::where('name', $examName)
            ->where('year_id', $yearData->id)
            ->where('region_id', $region->id)
            ->whereNull('district_id')
            ->exists();

        if ($hasRegionLevelTitles) {
            $districts = District::where('region_id', $region->id)->orderBy('name')->get();
        } else {
            $districts = District::where('region_id', $region->id)
                ->whereHas('resultTitles', function ($q) use ($examName, $yearData) {
                    $q->where('name', $examName)->where('year_id', $yearData->id);
                })
                ->orderBy('name')
                ->get();

            if ($districts->isEmpty()) {
                $districts = District::where('region_id', $region->id)->orderBy('name')->get();
            }
        }

        $regionSummaries = ResultSummary::whereHas('resultTitle', function ($q) use ($examName, $yearData, $region) {
            $q->where('name', $examName)
              ->where('year_id', $yearData->id)
              ->where('region_id', $region->id)
              ->whereNull('district_id');
        })->get();

        return view('landing.results.exam_districts', compact('examName', 'examSlug', 'yearData', 'region', 'districts', 'regionSummaries'));
    }

    public function showExamFinal(Request $request, $examSlug, $year, $region_slug, $district_slug)
    {
        $examName = $this->resolveExamName($examSlug);
        if (!$examName) {
            abort(404);
        }

        $yearData = Year::where('year', $year)->firstOrFail();
        $region = Region::where('slug', $region_slug)->firstOrFail();
        $district = District::where('slug', $district_slug)
            ->where('region_id', $region->id)
            ->firstOrFail();

        $resultTitle = ResultTitle::where('name', $examName)
            ->where('year_id', $yearData->id)
            ->where(function ($q) use ($region, $district) {
                $q->where('region_id', $region->id)
                  ->where(function ($sq) use ($district) {
                      $sq->where('district_id', $district->id)
                        ->orWhereNull('district_id');
                  });
            })
            ->latest()
            ->first();

        if (!$resultTitle) {
            $resultTitle = ResultTitle::where('name', $examName)
                ->where('year_id', $yearData->id)
                ->latest()
                ->firstOrFail();
        }

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

        $districtSummaries = ResultSummary::where('result_title_id', $resultTitle->id)
            ->whereHas('resultTitle', function ($q) {
                $q->whereNotNull('district_id');
            })->get();

        $regionSummaries = ResultSummary::whereHas('resultTitle', function ($q) use ($examName, $yearData, $region) {
            $q->where('name', $examName)
              ->where('year_id', $yearData->id)
              ->where('region_id', $region->id)
              ->whereNull('district_id');
        })->get();

        return view('landing.results.final', compact('yearData', 'region', 'district', 'resultTitle', 'results', 'districtSummaries', 'regionSummaries'));
    }

    private function resolveExamName($examSlug)
    {
        $titles = ResultTitle::select('name')->distinct()->get();
        foreach ($titles as $t) {
            if (Str::slug($t->name) === $examSlug) {
                return $t->name;
            }
        }
        return null;
    }

    public function servePdf(Request $request)
    {
        $filePath = $request->query('file');
        if (!$filePath) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($filePath);
        $mime = Storage::disk('public')->mimeType($filePath);

        return response($file, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
            'Cache-Control' => 'public, max-age=3600',
        ]);
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
