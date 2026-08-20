<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = District::with('region')->orderBy('name');

        if ($request->has('region_id') && $request->region_id) {
            $query->where('region_id', $request->region_id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $districts = $query->paginate(20);
        $regions = Region::orderBy('name')->get();

        return view('admin.districts.index', compact('districts', 'regions'));
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        return view('admin.districts.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        District::create([
            'name' => $request->name,
            'region_id' => $request->region_id,
            'slug' => Str::slug($request->name . '-' . time()),
        ]);

        return redirect()->route('admin.districts.index')->with('success', 'Wilaya imeongezwa kikamilifu.');
    }

    public function edit($id)
    {
        $district = District::findOrFail($id);
        $regions = Region::orderBy('name')->get();
        return view('admin.districts.edit', compact('district', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $district = District::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $district->update([
            'name' => $request->name,
            'region_id' => $request->region_id,
            'slug' => Str::slug($request->name . '-' . time()),
        ]);

        return redirect()->route('admin.districts.index')->with('success', 'Wilaya imesasishwa kikamilifu.');
    }

    public function destroy($id)
    {
        $district = District::findOrFail($id);
        $district->delete();

        return redirect()->route('admin.districts.index')->with('success', 'Wilaya imefutwa kikamilifu.');
    }

    public function bulkCreateForm()
    {
        $regions = Region::orderBy('name')->get();
        $jsonPath = database_path('data/tanzania_districts.json');
        $tanzaniaData = [];

        if (file_exists($jsonPath)) {
            $tanzaniaData = json_decode(file_get_contents($jsonPath), true);
        }

        return view('admin.districts.bulk', compact('regions', 'tanzaniaData'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'districts' => 'required|array',
            'districts.*' => 'required|string|max:255',
        ]);

        $region = Region::findOrFail($request->region_id);
        $count = 0;
        $skipped = 0;

        foreach ($request->districts as $name) {
            $name = trim($name);
            if (empty($name)) continue;

            $existing = District::where('region_id', $region->id)
                ->where('name', $name)
                ->first();

            if ($existing) {
                $skipped++;
                continue;
            }

            District::create([
                'name' => $name,
                'region_id' => $region->id,
                'slug' => Str::slug($name . '-' . time() . '-' . rand(100, 999)),
            ]);
            $count++;
        }

        $message = "Wilaya {$count} zimeongezwa kikamilifu.";
        if ($skipped > 0) {
            $message .= " Wilaya {$skipped} zilikuwa zipo tayari (zimepuzwa).";
        }

        return redirect()->route('admin.districts.index')->with('success', $message);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tafadhali chagua angalau wilaya moja.'], 400);
        }

        try {
            District::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Wilaya zilizochaguliwa zimefutwa kikamilifu.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu imetokea: ' . $e->getMessage()], 500);
        }
    }

    public function getByRegion($regionId)
    {
        $districts = District::where('region_id', $regionId)
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json($districts);
    }
}
