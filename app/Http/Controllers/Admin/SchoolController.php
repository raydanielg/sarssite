<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Region;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = School::with(['region', 'levels'])->latest();

        if ($request->ajax()) {
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            }
            
            $schools = $query->paginate(10);
            return view('admin.schools.partials.table', compact('schools'))->render();
        }

        $schools = $query->paginate(10);
        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        $levels = Level::orderBy('name')->get();
        return view('admin.schools.create', compact('regions', 'levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:schools,code|max:50',
            'name' => 'required|max:255',
            'region_id' => 'required|exists:regions,id',
            'levels' => 'required|array',
            'levels.*' => 'exists:levels,id',
        ]);

        $school = School::create([
            'code' => $request->code,
            'name' => $request->name,
            'is_pc' => $request->has('is_pc'),
            'region_id' => $request->region_id,
            'slug' => Str::slug($request->name . '-' . $request->code),
        ]);

        $school->levels()->sync($request->levels);

        return redirect()->route('admin.schools.index')->with('success', 'School created successfully.');
    }

    public function edit($id)
    {
        $school = School::with('levels')->findOrFail($id);
        $regions = Region::orderBy('name')->get();
        $levels = Level::orderBy('name')->get();
        return view('admin.schools.edit', compact('school', 'regions', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $request->validate([
            'code' => 'required|max:50|unique:schools,code,' . $school->id,
            'name' => 'required|max:255',
            'region_id' => 'required|exists:regions,id',
            'levels' => 'required|array',
            'levels.*' => 'exists:levels,id',
        ]);

        $school->update([
            'code' => $request->code,
            'name' => $request->name,
            'is_pc' => $request->has('is_pc'),
            'region_id' => $request->region_id,
            'slug' => Str::slug($request->name . '-' . $request->code),
        ]);

        $school->levels()->sync($request->levels);

        return redirect()->route('admin.schools.index')->with('success', 'School updated successfully.');
    }

    public function destroy($id)
    {
        $school = School::findOrFail($id);
        $school->levels()->detach();
        $school->delete();

        return redirect()->route('admin.schools.index')->with('success', 'School deleted successfully.');
    }
}
