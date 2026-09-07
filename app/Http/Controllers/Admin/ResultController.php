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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $query = Result::with(['school', 'resultTitle.year', 'resultTitle.level', 'resultTitle.region'])->latest();

        if ($request->has('type') && $request->type === 'pc') {
            $query->whereHas('school', function ($q) {
                $q->where('is_pc', true);
            });
        } elseif ($request->has('type') && $request->type === 'school') {
            $query->whereHas('school', function ($q) {
                $q->where('is_pc', false);
            });
        }

        if ($request->ajax()) {
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->whereHas('school', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            }

            if ($limit === 'all') {
                $results = $query->get();
            } else {
                $results = $query->paginate($limit);
            }

            return view('admin.results.partials.table', compact('results', 'limit'))->render();
        }

        $results = $query->paginate($limit);
        return view('admin.results.index', compact('results', 'limit'));
    }

    public function bulkUploadForm()
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region', 'district'])->get();
        return view('admin.results.bulk', compact('resultTitles'));
    }

    public function create()
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region', 'district'])->get();
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

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'files' => 'required|array',
            'files.*' => 'required|mimes:pdf|max:51200', // 50MB per file max
        ]);

        $resultTitle = ResultTitle::with(['region'])->findOrFail($request->result_title_id);
        $count = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName(); // e.g., S0104-BWIRU BOYS SECONDARY.pdf
                $filename = pathinfo($originalName, PATHINFO_FILENAME);
                
                // Extract code and name using regex: S0104-BWIRU BOYS SECONDARY or S0104 - BWIRU BOYS SECONDARY
                if (preg_match('/^([A-Z0-9]+)\s*-\s*(.*)$/i', $filename, $matches)) {
                    $schoolCode = trim($matches[1]);
                    $schoolName = trim($matches[2]);

                    // Find or create school
                    $school = School::firstOrCreate(
                        ['code' => $schoolCode],
                        [
                            'name' => $schoolName,
                            'region_id' => $resultTitle->region_id,
                            'slug' => Str::slug($schoolName . '-' . $schoolCode),
                            'is_pc' => str_starts_with(strtoupper($schoolCode), 'P') ? 1 : 0
                        ]
                    );

                    // Store PDF
                    $path = $file->store('results/pdfs', 'public');

                    // Create Result
                    Result::create([
                        'result_title_id' => $resultTitle->id,
                        'school_id' => $school->id,
                        'file_path' => $path,
                        'status' => 'Published',
                    ]);
                    $count++;
                } else {
                    $errors[] = "Fomu ya jina la faili '$originalName' si sahihi. Lazima iwe: CODE-SCHOOL NAME.pdf";
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuna hitilafu imetokea: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Kuna hitilafu imetokea: ' . $e->getMessage());
        }

        $message = "Mafaili $count yamepakiwa kikamilifu.";

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $count,
                'errors' => $errors,
            ]);
        }

        if (!empty($errors)) {
            return redirect()->route('admin.results.index')->with('success', $message)->with('warning_list', $errors);
        }

        return redirect()->route('admin.results.index')->with('success', $message);
    }

    public function createPc()
    {
        $resultTitles = ResultTitle::with(['year', 'level', 'region', 'district'])
            ->whereNull('district_id')
            ->latest()
            ->get();
        $schools = School::where('is_pc', true)->orderBy('name')->get();
        return view('admin.results.create_pc', compact('resultTitles', 'schools'));
    }

    public function storePc(Request $request)
    {
        $request->validate([
            'result_title_id' => 'required|exists:result_titles,id',
            'school_id' => 'required|exists:schools,id',
            'description' => 'nullable|string',
            'file' => 'required|mimes:pdf|max:20480',
            'status' => 'required|in:Published,Draft',
        ]);

        $school = School::findOrFail($request->school_id);
        if (!$school->is_pc) {
            return back()->withErrors(['school_id' => 'Shule iliyochaguliwa si ya Private Candidates (PC).'])->withInput();
        }

        $title = ResultTitle::findOrFail($request->result_title_id);
        if ($title->district_id !== null) {
            return back()->withErrors(['result_title_id' => 'Tafadhali chagua category ya Mkoa (bila Wilaya) kwa watahiniwa wa PC.'])->withInput();
        }

        $path = $request->file('file')->store('results/pdfs', 'public');

        Result::create([
            'result_title_id' => $request->result_title_id,
            'school_id' => $request->school_id,
            'description' => $request->description,
            'file_path' => $path,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.results.index')->with('success', 'Matokeo ya Private Candidate yamepakiwa kikamilifu.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tafadhali chagua angalau item moja.'], 400);
        }

        try {
            $results = Result::whereIn('id', $ids)->get();
            foreach ($results as $result) {
                if (Storage::disk('public')->exists($result->file_path)) {
                    Storage::disk('public')->delete($result->file_path);
                }
                $result->delete();
            }
            return response()->json(['success' => true, 'message' => 'Results zilizochaguliwa zimefutwa kikamilifu.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu imetokea: ' . $e->getMessage()], 500);
        }
    }

    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|in:Published,Draft',
        ]);

        try {
            $count = Result::whereIn('id', $request->ids)->update(['status' => $request->status]);
            $label = $request->status === 'Published' ? 'zimechapishwa' : 'zimefanywa Draft';
            return response()->json(['success' => true, 'message' => "Matokeo {$count} {$label} kikamilifu."]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hitilafu imetokea: ' . $e->getMessage()], 500);
        }
    }
}
