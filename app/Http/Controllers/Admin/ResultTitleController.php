<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResultTitle;
use App\Models\Year;
use App\Models\Level;
use App\Models\Region;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResultTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region', 'district', 'resultType'])
            ->withCount('results')
            ->latest()
            ->paginate(10);
        return view('admin.result-titles.index', compact('resultTitles'));
    }

    public function create()
    {
        $years = Year::orderByDesc('year')->get();
        $levels = Level::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $resultTypes = \App\Models\ResultType::orderBy('name')->get();
        return view('admin.result-titles.create', compact('years', 'levels', 'regions', 'resultTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year_id' => 'required|exists:years,id',
            'level_id' => 'required|exists:levels,id',
            'region_ids' => 'required|array',
            'region_ids.*' => 'exists:regions,id',
            'result_type_id' => 'nullable|exists:result_types,id',
        ]);

        $count = 0;
        foreach ($request->region_ids as $regionId) {
            $districtIds = $request->input('district_ids_' . $regionId, []);

            if (empty($districtIds)) {
                // Create for entire region (no specific district)
                ResultTitle::create([
                    'name' => $request->name,
                    'year_id' => $request->year_id,
                    'level_id' => $request->level_id,
                    'region_id' => $regionId,
                    'district_id' => null,
                    'result_type_id' => $request->result_type_id,
                    'slug' => Str::slug($request->name . '-' . $regionId . '-' . time() . '-' . rand(100, 999)),
                ]);
                $count++;
            } else {
                // Create for each selected district
                foreach ($districtIds as $districtId) {
                    ResultTitle::create([
                        'name' => $request->name,
                        'year_id' => $request->year_id,
                        'level_id' => $request->level_id,
                        'region_id' => $regionId,
                        'district_id' => $districtId,
                        'result_type_id' => $request->result_type_id,
                        'slug' => Str::slug($request->name . '-' . $districtId . '-' . time() . '-' . rand(100, 999)),
                    ]);
                    $count++;
                }
            }
        }

        $msg = $count === 1 ? 'Result Category created successfully.' : "{$count} Result Categories created successfully (for multiple regions/districts).";
        return redirect()->route('admin.result-titles.index')->with('success', $msg);
    }

    public function edit($id)
    {
        $resultTitle = ResultTitle::with(['district', 'resultType'])->findOrFail($id);
        $years = Year::orderByDesc('year')->get();
        $levels = Level::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $resultTypes = \App\Models\ResultType::orderBy('name')->get();
        $districts = collect();
        if ($resultTitle->region_id) {
            $districts = \App\Models\District::where('region_id', $resultTitle->region_id)->orderBy('name')->get();
        }
        return view('admin.result-titles.edit', compact('resultTitle', 'years', 'levels', 'regions', 'resultTypes', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $resultTitle = ResultTitle::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'year_id' => 'required|exists:years,id',
            'level_id' => 'required|exists:levels,id',
            'region_id' => 'required|exists:regions,id',
            'district_id' => 'nullable|exists:districts,id',
            'result_type_id' => 'nullable|exists:result_types,id',
        ]);

        $resultTitle->update([
            'name' => $request->name,
            'year_id' => $request->year_id,
            'level_id' => $request->level_id,
            'region_id' => $request->region_id,
            'district_id' => $request->district_id ?: null,
            'result_type_id' => $request->result_type_id ?: null,
            'slug' => Str::slug($request->name . '-' . time()),
        ]);

        return redirect()->route('admin.result-titles.index')->with('success', 'Result Category updated successfully.');
    }

    public function destroy($id)
    {
        $resultTitle = ResultTitle::findOrFail($id);
        $resultTitle->delete();

        return redirect()->route('admin.result-titles.index')->with('success', 'Result Category deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tafadhali chagua angalau item moja.'], 400);
        }

        try {
            ResultTitle::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Items zilizochaguliwa zimefutwa kikamilifu.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu imetokea: ' . $e->getMessage()], 500);
        }
    }
}
