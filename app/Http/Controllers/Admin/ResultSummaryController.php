<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResultSummary;
use App\Models\ResultTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResultSummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = ResultSummary::with(['resultTitle.year', 'resultTitle.level', 'resultTitle.region', 'resultTitle.district'])->latest();

        if ($request->has('type') && $request->type === 'region') {
            $query->whereHas('resultTitle', function ($q) {
                $q->whereNull('district_id');
            });
        } elseif ($request->has('type') && $request->type === 'district') {
            $query->whereHas('resultTitle', function ($q) {
                $q->whereNotNull('district_id');
            });
        }

        if ($request->ajax()) {
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('resultTitle', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            }

            if ($limit === 'all') {
                $summaries = $query->get();
            } else {
                $summaries = $query->paginate($limit);
            }

            return view('admin.result_summaries.partials.table', compact('summaries', 'limit'))->render();
        }

        $summaries = $query->paginate($limit);
        return view('admin.result_summaries.index', compact('summaries', 'limit'));
    }

    public function create()
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region', 'district'])->latest()->get();
        return view('admin.result_summaries.create', compact('resultTitles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'name' => 'required|max:255',
            'file' => 'required|mimes:pdf|max:20480', // 20MB
        ]);

        $path = $request->file('file')->store('summaries', 'public');

        ResultSummary::create([
            'result_title_id' => $request->result_title_id,
            'name' => $request->name,
            'file_path' => $path,
            'status' => 'Published',
        ]);

        return redirect()->route('admin.result-summaries.index')->with('success', 'Summary uploaded successfully.');
    }

    public function edit(ResultSummary $resultSummary)
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region', 'district'])->latest()->get();
        return view('admin.result_summaries.edit', compact('resultSummary', 'resultTitles'));
    }

    public function update(Request $request, ResultSummary $resultSummary)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'name' => 'required|max:255',
            'file' => 'nullable|mimes:pdf|max:20480',
        ]);

        $data = [
            'result_title_id' => $request->result_title_id,
            'name' => $request->name,
            'status' => $request->status ?? 'Published',
        ];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($resultSummary->file_path);
            $data['file_path'] = $request->file('file')->store('summaries', 'public');
        }

        $resultSummary->update($data);

        return redirect()->route('admin.result-summaries.index')->with('success', 'Summary updated successfully.');
    }

    public function destroy(ResultSummary $resultSummary)
    {
        Storage::disk('public')->delete($resultSummary->file_path);
        $resultSummary->delete();
        return redirect()->route('admin.result-summaries.index')->with('success', 'Summary deleted successfully.');
    }

    public function bulkUploadForm()
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region', 'district'])->latest()->get();
        return view('admin.result_summaries.bulk', compact('resultTitles'));
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'files' => 'required|array',
            'files.*' => 'required|mimes:pdf|max:51200',
        ]);

        $count = 0;
        DB::beginTransaction();
        try {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $name = pathinfo($originalName, PATHINFO_FILENAME);
                
                $path = $file->store('summaries', 'public');

                ResultSummary::create([
                    'result_title_id' => $request->result_title_id,
                    'name' => $name,
                    'file_path' => $path,
                    'status' => 'Published',
                ]);
                $count++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'message' => "Successfully uploaded $count summaries."]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tafadhali chagua angalau item moja.'], 400);
        }

        try {
            $summaries = \App\Models\ResultSummary::whereIn('id', $ids)->get();
            foreach ($summaries as $summary) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($summary->file_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($summary->file_path);
                }
                $summary->delete();
            }
            return response()->json(['success' => true, 'message' => 'Summaries zilizochaguliwa zimefutwa kikamilifu.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu imetokea: ' . $e->getMessage()], 500);
        }
    }

    // Region-level summaries (district_id is null)
    public function createRegion()
    {
        $regions = \App\Models\Region::orderBy('name')->get();
        return view('admin.result_summaries.create_region', compact('regions'));
    }

    public function storeRegion(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'name' => 'required|max:255',
            'file' => 'required|mimes:pdf|max:20480',
        ]);

        $title = ResultTitle::findOrFail($request->result_title_id);
        if ($title->district_id !== null) {
            $baseName = preg_replace('/\s*-\s*.+$/', '', $title->name);
            $title = ResultTitle::firstOrCreate(
                [
                    'name' => $baseName,
                    'year_id' => $title->year_id,
                    'level_id' => $title->level_id,
                    'region_id' => $title->region_id,
                    'district_id' => null,
                ],
                [
                    'result_type_id' => $title->result_type_id,
                    'slug' => \Illuminate\Support\Str::slug($baseName . '-' . $title->region_id . '-' . time() . '-' . rand(100, 999)),
                ]
            );
        }

        $path = $request->file('file')->store('summaries', 'public');

        ResultSummary::create([
            'result_title_id' => $title->id,
            'name' => $request->name,
            'file_path' => $path,
            'status' => 'Published',
        ]);

        return redirect()->route('admin.result-summaries.index', ['type' => 'region'])->with('success', 'Summary ya Mkoa imepakiwa kikamilifu.');
    }

    public function bulkRegionForm()
    {
        $regions = \App\Models\Region::orderBy('name')->get();
        return view('admin.result_summaries.bulk_region', compact('regions'));
    }

    public function bulkRegionUpload(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'files' => 'required|array',
            'files.*' => 'required|mimes:pdf|max:51200',
        ]);

        $title = ResultTitle::findOrFail($request->result_title_id);
        if ($title->district_id !== null) {
            $baseName = preg_replace('/\s*-\s*.+$/', '', $title->name);
            $title = ResultTitle::firstOrCreate(
                [
                    'name' => $baseName,
                    'year_id' => $title->year_id,
                    'level_id' => $title->level_id,
                    'region_id' => $title->region_id,
                    'district_id' => null,
                ],
                [
                    'result_type_id' => $title->result_type_id,
                    'slug' => \Illuminate\Support\Str::slug($baseName . '-' . $title->region_id . '-' . time() . '-' . rand(100, 999)),
                ]
            );
        }

        $count = 0;
        DB::beginTransaction();
        try {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $name = pathinfo($originalName, PATHINFO_FILENAME);
                $path = $file->store('summaries', 'public');

                ResultSummary::create([
                    'result_title_id' => $title->id,
                    'name' => $name,
                    'file_path' => $path,
                    'status' => 'Published',
                ]);
                $count++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'message' => "Successfully uploaded $count region summaries."]);
    }

    // District-level summaries (district_id is not null)
    public function createDistrict()
    {
        $districts = \App\Models\District::whereHas('resultTitles', function ($q) {
            $q->whereNotNull('district_id');
        })->with('region')->orderBy('name')->get();
        return view('admin.result_summaries.create_district', compact('districts'));
    }

    public function getTitlesByRegion($regionId)
    {
        $titles = ResultTitle::with(['year', 'level', 'region', 'district'])
            ->where('region_id', $regionId)
            ->orderByDesc('year_id')
            ->get();

        $grouped = $titles->groupBy(function ($t) {
            $baseName = preg_replace('/\s*-\s*.+$/', '', $t->name);
            return $baseName . '|' . $t->year_id . '|' . $t->level_id;
        })->map(function ($group) use ($regionId) {
            $regionLevel = $group->firstWhere('district_id', null);
            if (!$regionLevel) {
                $first = $group->first();
                $baseName = preg_replace('/\s*-\s*.+$/', '', $first->name);
                $regionLevel = ResultTitle::firstOrCreate(
                    [
                        'name' => $baseName,
                        'year_id' => $first->year_id,
                        'level_id' => $first->level_id,
                        'region_id' => $regionId,
                        'district_id' => null,
                    ],
                    [
                        'result_type_id' => $first->result_type_id,
                        'slug' => \Illuminate\Support\Str::slug($baseName . '-' . $regionId . '-' . time() . '-' . rand(100, 999)),
                    ]
                );
            }
            $baseName = preg_replace('/\s*-\s*.+$/', '', $regionLevel->name);
            return [
                'id' => $regionLevel->id,
                'name' => $baseName,
                'year' => $regionLevel->year->year ?? '',
                'level' => $regionLevel->level->name ?? '',
                'region' => $regionLevel->region->name ?? '',
            ];
        })->values();

        return response()->json($grouped);
    }

    public function getDistrictsByRegion($regionId)
    {
        $districts = \App\Models\District::where('region_id', $regionId)->orderBy('name')->get();
        return response()->json($districts->map(function ($d) {
            return ['id' => $d->id, 'name' => $d->name];
        }));
    }

    public function getTitlesByDistrict($districtId)
    {
        $titles = ResultTitle::with(['year', 'level', 'region', 'district'])
            ->where('district_id', $districtId)
            ->whereNotNull('district_id')
            ->orderByDesc('year_id')
            ->get();

        return response()->json($titles->map(function ($t) {
            return [
                'id' => $t->id,
                'name' => $t->name,
                'year' => $t->year->year ?? '',
                'level' => $t->level->name ?? '',
                'region' => $t->region->name ?? '',
            ];
        }));
    }

    public function storeDistrict(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'name' => 'required|max:255',
            'file' => 'required|mimes:pdf|max:20480',
        ]);

        $title = ResultTitle::findOrFail($request->result_title_id);
        if ($title->district_id === null) {
            return back()->withErrors(['result_title_id' => 'Tafadhali chagua category ya Wilaya, sio Mkoa.'])->withInput();
        }

        $path = $request->file('file')->store('summaries', 'public');

        ResultSummary::create([
            'result_title_id' => $request->result_title_id,
            'name' => $request->name,
            'file_path' => $path,
            'status' => 'Published',
        ]);

        return redirect()->route('admin.result-summaries.index', ['type' => 'district'])->with('success', 'Summary ya Wilaya imepakiwa kikamilifu.');
    }

    public function bulkDistrictForm()
    {
        $districts = \App\Models\District::whereHas('resultTitles', function ($q) {
            $q->whereNotNull('district_id');
        })->with('region')->orderBy('name')->get();
        return view('admin.result_summaries.bulk_district', compact('districts'));
    }

    public function bulkDistrictUpload(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'files' => 'required|array',
            'files.*' => 'required|mimes:pdf|max:51200',
        ]);

        $title = ResultTitle::findOrFail($request->result_title_id);
        if ($title->district_id === null) {
            return response()->json(['success' => false, 'message' => 'Tafadhali chagua category ya Wilaya, sio Mkoa.'], 400);
        }

        $count = 0;
        DB::beginTransaction();
        try {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $name = pathinfo($originalName, PATHINFO_FILENAME);
                $path = $file->store('summaries', 'public');

                ResultSummary::create([
                    'result_title_id' => $request->result_title_id,
                    'name' => $name,
                    'file_path' => $path,
                    'status' => 'Published',
                ]);
                $count++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'message' => "Successfully uploaded $count district summaries."]);
    }
}
