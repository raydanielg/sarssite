<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResultTitle;
use App\Models\Year;
use App\Models\Level;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResultTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region'])->latest()->paginate(10);
        return view('admin.result-titles.index', compact('resultTitles'));
    }

    public function create()
    {
        $years = Year::orderByDesc('year')->get();
        $levels = Level::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('admin.result-titles.create', compact('years', 'levels', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year_id' => 'required|exists:years,id',
            'level_id' => 'required|exists:levels,id',
            'region_id' => 'required|exists:regions,id',
        ]);

        ResultTitle::create([
            'name' => $request->name,
            'year_id' => $request->year_id,
            'level_id' => $request->level_id,
            'region_id' => $request->region_id,
            'slug' => Str::slug($request->name . '-' . time()),
        ]);

        return redirect()->route('admin.result-titles.index')->with('success', 'Result Category created successfully.');
    }

    public function edit($id)
    {
        $resultTitle = ResultTitle::findOrFail($id);
        $years = Year::orderByDesc('year')->get();
        $levels = Level::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        return view('admin.result-titles.edit', compact('resultTitle', 'years', 'levels', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $resultTitle = ResultTitle::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'year_id' => 'required|exists:years,id',
            'level_id' => 'required|exists:levels,id',
            'region_id' => 'required|exists:regions,id',
        ]);

        $resultTitle->update([
            'name' => $request->name,
            'year_id' => $request->year_id,
            'level_id' => $request->level_id,
            'region_id' => $request->region_id,
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
