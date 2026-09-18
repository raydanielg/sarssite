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
                $resultsCount = Result::where('status', 'Published')->whereHas('school', function ($q) { $q->where('is_pc', false); })->whereHas('resultTitle', function ($q) use ($item) {
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
            })->filter(function ($exam) {
                return $exam->results_count > 0;
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
            $q->where('year_id', $yearData->id)
              ->whereHas('results', function ($sq) {
                  $sq->where('status', 'Published')->whereHas('school', function ($sq2) { $sq2->where('is_pc', false); });
              });
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
                    $q->where('year_id', $yearData->id)
                      ->whereHas('results', function ($sq) {
                          $sq->where('status', 'Published')->whereHas('school', function ($sq2) { $sq2->where('is_pc', false); });
                      });
                })
                ->orderBy('name')
                ->get();

            if ($districts->isEmpty()) {
                $districts = District::where('region_id', $region->id)->orderBy('name')->get();
            }
        }

        $regionSummaries = ResultSummary::where('status', 'Published')->whereHas('resultTitle', function ($q) use ($yearData, $region) {
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
            ->whereHas('results', function ($q) {
                $q->where('status', 'Published')->whereHas('school', function ($sq) { $sq->where('is_pc', false); });
            })
            ->withCount(['results' => function ($q) {
                $q->where('status', 'Published')->whereHas('school', function ($sq) { $sq->where('is_pc', false); });
            }])
            ->with('resultType')
            ->orderByDesc('id')
            ->get();

        $districtSummaries = ResultSummary::where('status', 'Published')->whereHas('resultTitle', function ($q) use ($yearData, $region, $district) {
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

        $resultTitleIds = ResultTitle::where('name', $resultTitle->name)
            ->where('year_id', $yearData->id)
            ->where('region_id', $region->id)
            ->where(function ($q) use ($district) {
                $q->where('district_id', $district->id)
                  ->orWhereNull('district_id');
            })
            ->pluck('id');

        if ($resultTitleIds->isEmpty()) {
            $resultTitleIds = [$resultTitle->id];
        }

        $query = Result::whereIn('result_title_id', $resultTitleIds)
            ->where('status', 'Published')
            ->whereHas('school', function ($q) { $q->where('is_pc', false); })
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

        $districtTitleIds = ResultTitle::where('name', $resultTitle->name)
            ->where('year_id', $yearData->id)
            ->where('region_id', $region->id)
            ->where('district_id', $district->id)
            ->pluck('id');

        $regionalTitleIds = ResultTitle::where('name', $resultTitle->name)
            ->where('year_id', $yearData->id)
            ->where('region_id', $region->id)
            ->whereNull('district_id')
            ->pluck('id');

        $summaries = ResultSummary::where('status', 'Published')->whereIn('result_title_id', $districtTitleIds)->get();
        $regionalSummaries = ResultSummary::where('status', 'Published')->whereIn('result_title_id', $regionalTitleIds)->get();

        return view('landing.results.final', compact('yearData', 'region', 'district', 'resultTitle', 'results', 'summaries', 'regionalSummaries'));
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
            $q->where('name', $examName)
              ->whereHas('results', function ($sq) {
                  $sq->where('status', 'Published')->whereHas('school', function ($sq2) { $sq2->where('is_pc', false); });
              });
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
            $q->where('name', $examName)->where('year_id', $yearData->id)
              ->whereHas('results', function ($sq) {
                  $sq->where('status', 'Published')->whereHas('school', function ($sq2) { $sq2->where('is_pc', false); });
              });
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
                    $q->where('name', $examName)->where('year_id', $yearData->id)
                      ->whereHas('results', function ($sq) {
                          $sq->where('status', 'Published')->whereHas('school', function ($sq2) { $sq2->where('is_pc', false); });
                      });
                })
                ->orderBy('name')
                ->get();

            if ($districts->isEmpty()) {
                $districts = District::where('region_id', $region->id)->orderBy('name')->get();
            }
        }

        return view('landing.results.exam_districts', compact('examName', 'examSlug', 'yearData', 'region', 'districts'));
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

        $resultTitleIds = ResultTitle::where('name', $examName)
            ->where('year_id', $yearData->id)
            ->where('region_id', $region->id)
            ->where(function ($q) use ($district) {
                $q->where('district_id', $district->id)
                  ->orWhereNull('district_id');
            })
            ->pluck('id');

        if ($resultTitleIds->isEmpty()) {
            $resultTitleIds = ResultTitle::where('name', $examName)
                ->where('year_id', $yearData->id)
                ->pluck('id');
        }

        if ($resultTitleIds->isEmpty()) {
            abort(404);
        }

        $resultTitle = ResultTitle::whereIn('id', $resultTitleIds)
            ->whereHas('results', function ($q) {
                $q->where('status', 'Published')->whereHas('school', function ($sq) { $sq->where('is_pc', false); });
            })
            ->latest()
            ->first();

        if (!$resultTitle) {
            $resultTitle = ResultTitle::whereIn('id', $resultTitleIds)->latest()->first();
        }

        $query = Result::whereIn('result_title_id', $resultTitleIds)
            ->where('status', 'Published')
            ->whereHas('school', function ($q) { $q->where('is_pc', false); })
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

        $districtTitleIds = ResultTitle::whereIn('id', $resultTitleIds)
            ->where('district_id', $district->id)
            ->pluck('id');

        $regionalTitleIds = ResultTitle::whereIn('id', $resultTitleIds)
            ->whereNull('district_id')
            ->pluck('id');

        $summaries = ResultSummary::where('status', 'Published')->whereIn('result_title_id', $districtTitleIds)->get();
        $regionalSummaries = ResultSummary::where('status', 'Published')->whereIn('result_title_id', $regionalTitleIds)->get();

        return view('landing.results.final', compact('yearData', 'region', 'district', 'resultTitle', 'results', 'summaries', 'regionalSummaries'));
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

        $result = Result::where('file_path', $filePath)->first();
        if ($result && ($result->status !== 'Published' || ($result->school && $result->school->is_pc))) {
            abort(404);
        }

        $summary = ResultSummary::where('file_path', $filePath)->first();
        if ($summary && $summary->status !== 'Published') {
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

        $result = Result::where('file_path', $filePath)->first();
        if ($result && ($result->status !== 'Published' || ($result->school && $result->school->is_pc))) {
            abort(404);
        }

        $summary = ResultSummary::where('file_path', $filePath)->first();
        if ($summary && $summary->status !== 'Published') {
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
