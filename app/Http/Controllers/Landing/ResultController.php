<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ResultTitle;
use App\Models\Year;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function getExamsByYear(Request $request)
    {
        $yearValue = $request->query('year');
        $year = Year::where('year', $yearValue)->first();

        if (!$year) {
            return response()->json(['exams' => []]);
        }

        $exams = ResultTitle::with(['level'])
            ->where('year_id', $year->id)
            ->get()
            ->map(function ($exam) use ($yearValue) {
                return [
                    'name' => $exam->name,
                    'level' => $exam->level->name,
                    'url' => route('results.level', ['year' => $yearValue, 'level_slug' => $exam->level->slug]),
                    'icon' => $this->getIconForLevel($exam->level->slug),
                    'color' => $this->getColorForLevel($exam->level->slug)
                ];
            });

        return response()->json(['exams' => $exams]);
    }

    private function getIconForLevel($slug)
    {
        $icons = [
            'psle' => 'ri-user-smile-line',
            'csee' => 'ri-user-star-line',
            'acsee' => 'ri-user-settings-line',
            'dsee' => 'ri-book-read-line',
            'gatce' => 'ri-medal-line',
        ];
        return $icons[$slug] ?? 'ri-file-list-3-line';
    }

    private function getColorForLevel($slug)
    {
        $colors = [
            'psle' => 'bg-orange-50 text-orange-600 border-orange-100',
            'csee' => 'bg-blue-50 text-blue-600 border-blue-100',
            'acsee' => 'bg-green-50 text-green-600 border-green-100',
            'dsee' => 'bg-purple-50 text-purple-600 border-purple-100',
            'gatce' => 'bg-red-50 text-red-600 border-red-100',
        ];
        return $colors[$slug] ?? 'bg-gray-50 text-gray-600 border-gray-100';
    }
}
