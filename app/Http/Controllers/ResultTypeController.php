<?php

namespace App\Http\Controllers;

use App\Models\ResultType;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResultTypeController extends Controller
{
    public function index()
    {
        $resultTypes = ResultType::with('levels')->latest()->paginate(10);
        return view('admin.result_types.index', compact('resultTypes'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('admin.result_types.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:result_types,name',
            'level_ids' => 'nullable|array',
            'level_ids.*' => 'exists:levels,id',
            'description' => 'nullable'
        ]);

        $resultType = ResultType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        if ($request->has('level_ids')) {
            $resultType->levels()->sync($request->level_ids);
        }

        return redirect()->route('admin.result-types.index')->with('success', 'Aina ya mtihani imeongezwa!');
    }

    public function edit(ResultType $resultType)
    {
        $levels = Level::all();
        $resultType->load('levels');
        return view('admin.result_types.edit', compact('resultType', 'levels'));
    }

    public function update(Request $request, ResultType $resultType)
    {
        $request->validate([
            'name' => 'required|unique:result_types,name,' . $resultType->id,
            'level_ids' => 'nullable|array',
            'level_ids.*' => 'exists:levels,id',
            'description' => 'nullable'
        ]);

        $resultType->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        $resultType->levels()->sync($request->level_ids ?? []);

        return redirect()->route('admin.result-types.index')->with('success', 'Aina ya mtihani imerekebishwa!');
    }

    public function destroy(ResultType $resultType)
    {
        $resultType->delete();
        return redirect()->route('admin.result-types.index')->with('success', 'Aina ya mtihani imefutwa!');
    }
}
