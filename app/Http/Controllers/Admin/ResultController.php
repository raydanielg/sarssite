<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Year;
use App\Models\Level;
use App\Models\Region;
use App\Models\School;
use App\Models\ResultTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $results = Result::with(['resultTitle.year', 'resultTitle.level', 'resultTitle.region', 'school'])->latest()->paginate(10);
        return view('admin.results.index', compact('results'));
    }

    public function create()
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region'])->get();
        $schools = School::orderBy('name')->get();
        return view('admin.results.create', compact('resultTitles', 'schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'school_id' => 'required|exists:schools,id',
            'description' => 'nullable|string',
            'file' => 'required|mimes:pdf|max:20480',
            'status' => 'required|in:Published,Draft',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('results/pdfs', 'public');
            
            Result::create([
                'result_title_id' => $request->result_title_id,
                'school_id' => $request->school_id,
                'description' => $request->description,
                'file_path' => $path,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.results.index')->with('success', 'Result uploaded successfully.');
        }

        return back()->with('error', 'File upload failed.');
    }

    public function edit($id)
    {
        $result = Result::findOrFail($id);
        $resultTitles = ResultTitle::with(['year', 'level', 'region'])->get();
        $schools = School::orderBy('name')->get();
        return view('admin.results.edit', compact('result', 'resultTitles', 'schools'));
    }

    public function update(Request $request, $id)
    {
        $result = Result::findOrFail($id);

        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'school_id' => 'required|exists:schools,id',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:20480',
            'status' => 'required|in:Published,Draft',
        ]);

        $data = [
            'result_title_id' => $request->result_title_id,
            'school_id' => $request->school_id,
            'description' => $request->description,
            'status' => $request->status,
        ];

        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($result->file_path)) {
                Storage::disk('public')->delete($result->file_path);
            }
            $data['file_path'] = $request->file('file')->store('results/pdfs', 'public');
        }

        $result->update($data);

        return redirect()->route('admin.results.index')->with('success', 'Result updated successfully.');
    }

    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        
        if (Storage::disk('public')->exists($result->file_path)) {
            Storage::disk('public')->delete($result->file_path);
        }

        $result->delete();

        return redirect()->route('admin.results.index')->with('success', 'Result deleted successfully.');
    }
}
