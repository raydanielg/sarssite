<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\Level;
use App\Models\Region;
use App\Models\Result;
use App\Models\Announcement;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $years = Year::orderByDesc('year')->get();
        $levels = Level::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $announcements = Announcement::where('is_active', true)->latest()->take(5)->get();
        $latestResults = Result::with(['resultTitle.year', 'resultTitle.level', 'resultTitle.region', 'school'])
            ->where('status', 'Published')
            ->latest()
            ->take(6)
            ->get();

        return view('landing.index', compact('years', 'levels', 'regions', 'announcements', 'latestResults'));
    }
}
