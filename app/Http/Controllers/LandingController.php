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
        $years = Year::orderBy('year', 'desc')->get();
        
        // Tunapitisha $years pia kwenye landing view ili Mega Menu ifanye kazi
        $levels = \App\Models\Level::all();
        $regions = \App\Models\Region::all();
        $announcements = \App\Models\Announcement::where('is_active', true)->latest()->get();
        $latestResults = \App\Models\Result::with(['school', 'resultTitle.year', 'resultTitle.level', 'resultTitle.region'])->latest()->take(6)->get();

        return view('landing.index', compact('years', 'levels', 'regions', 'announcements', 'latestResults'));
    }
}
