@extends('landing.layouts.app')

@section('title', 'Karibu')

@section('content')
<!-- Hero Section (Based on Image) -->
<div class="hero-wrap bg-white py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <!-- New Badge -->
            <div class="mb-4">
                <span class="badge badge-pill badge-light border px-3 py-2" style="font-size: 13px; color: #555;">
                    <span class="badge badge-success badge-pill mr-2 px-2 py-1">New</span> 
                    EMaS v2.0 is out! See what's new <i class="fas fa-chevron-right ml-1 small"></i>
                </span>
            </div>
            
            <!-- Main Title -->
            <h1 class="display-3 font-weight-bold text-dark mb-4">
                We digitize the <span style="color: #28a745;">education</span> potential
            </h1>
            
            <!-- Subtitle -->
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <p class="lead text-secondary" style="font-size: 18px; line-height: 1.6;">
                        Electronic Marking System (EMaS) focus on markets where technology and innovation can 
                        unlock long-term value and drive school performance growth.
                    </p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex justify-content-center align-items-center mb-5">
                <a href="#" class="btn btn-success btn-lg px-4 py-3 mr-3" style="background-color: #0d3c14; border: none; font-size: 16px; border-radius: 8px;">
                    Get started <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="#" class="btn btn-light btn-lg px-4 py-3 border" style="font-size: 16px; border-radius: 8px; background: white;">
                    <i class="fas fa-video mr-2"></i> Watch demo
                </a>
            </div>

            <!-- Recognized By Section -->
            <div class="mt-5 pt-5">
                <p class="text-uppercase small font-weight-bold text-muted mb-4" style="letter-spacing: 2px;">Officially Recognized By</p>
                <div class="row justify-content-center align-items-center opacity-7">
                    <div class="col-md-2 col-4 mb-4">
                        <div class="d-flex align-items-center justify-content-center text-muted">
                            <i class="fas fa-university fa-2x mr-2"></i>
                            <span class="font-weight-bold h6 mb-0">TAMISEMI</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-4 mb-4">
                        <div class="d-flex align-items-center justify-content-center text-muted">
                            <i class="fas fa-landmark fa-2x mr-2"></i>
                            <span class="font-weight-bold h6 mb-0">NECTA</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-4 mb-4">
                        <div class="d-flex align-items-center justify-content-center text-muted">
                            <i class="fas fa-graduation-cap fa-2x mr-2"></i>
                            <span class="font-weight-bold h6 mb-0">MOEST</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Section (Previously Hero, now a section below Hero) -->
<div class="search-section py-5" style="background: #f8f9fa; border-top: 1px solid #eee;">
    <div class="container py-4">
        <div class="text-center mb-4">
            <h3 class="font-weight-bold">Tafuta Matokeo Hapa</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="#" method="GET">
                            <div class="row align-items-end">
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="font-weight-bold small text-uppercase">Mwaka</label>
                                    <select class="form-control select2">
                                        <option value="">-- Mwaka --</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year->id }}">{{ $year->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="font-weight-bold small text-uppercase">Level</label>
                                    <select class="form-control select2">
                                        <option value="">-- Level --</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="font-weight-bold small text-uppercase">Mkoa</label>
                                    <select class="form-control select2">
                                        <option value="">-- Mkoa --</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success btn-block font-weight-bold py-2">
                                        <i class="fas fa-search mr-2"></i> TAFUTA
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Announcements -->
<div class="bg-dark text-white py-3 overflow-hidden">
    <div class="container d-flex align-items-center">
        <span class="badge badge-success mr-3 px-3">BREAKING</span>
        <marquee behavior="scroll" direction="left">
            @forelse($announcements as $announcement)
                <span class="mx-4 font-weight-bold"><i class="fas fa-bullhorn text-warning mr-2"></i> {{ $announcement->title }}</span>
            @empty
                <span>Hakuna matangazo mapya kwa sasa.</span>
            @endforelse
        </marquee>
    </div>
</div>

<!-- Featured Results -->
<div class="container py-5 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="font-weight-bold mb-0">Matokeo Mapya</h2>
        <a href="#" class="text-success font-weight-bold">See all results <i class="fas fa-arrow-right ml-1"></i></a>
    </div>

    <div class="row">
        @forelse($latestResults as $result)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 result-card p-2" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="badge badge-light border text-success px-2 py-1">{{ $result->resultTitle->level->name }}</span>
                            <span class="text-muted small"><i class="far fa-calendar-alt"></i> {{ $result->resultTitle->year->year }}</span>
                        </div>
                        <h5 class="card-title font-weight-bold mb-2">{{ $result->school->name }}</h5>
                        <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt mr-1"></i> {{ $result->resultTitle->region->name }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                        <a href="{{ asset('storage/' . $result->file_path) }}" target="_blank" class="btn btn-outline-success btn-block btn-sm font-weight-bold">
                            View PDF Result
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No results found.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .hero-wrap {
        background: radial-gradient(circle at 50% 50%, #fefefe 0%, #f5f5f5 100%);
    }
    .result-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
    .opacity-7 { opacity: 0.7; }
</style>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function () {
  $('.select2').select2({
      theme: 'bootstrap4'
  });
});
</script>
@endpush
