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
        $query = ResultSummary::with(['resultTitle.year', 'resultTitle.level', 'resultTitle.region'])->latest();

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
        $resultTitles = ResultTitle::with(['year', 'level', 'region'])->get();
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
        $resultTitles = ResultTitle::with(['year', 'level', 'region'])->get();
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
        $resultTitles = ResultTitle::with(['year', 'level', 'region'])->get();
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
}
