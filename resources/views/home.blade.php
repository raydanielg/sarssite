@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Summary')

@section('content')
<!-- KPI Cards -->
<div class="row">
    <div class="col-lg-2 col-6">
        <div class="small-box bg-info elevation-2">
            <div class="inner">
                <h3>{{ number_format($yearsCount ?? 0) }}</h3>
                <p>Years</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <a href="{{ route('admin.years.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-success elevation-2">
            <div class="inner">
                <h3>{{ number_format($levelsCount ?? 0) }}</h3>
                <p>Levels</p>
            </div>
            <div class="icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <a href="{{ route('admin.levels.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-warning elevation-2">
            <div class="inner">
                <h3>{{ number_format($regionsCount ?? 0) }}</h3>
                <p>Regions</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe-africa"></i>
            </div>
            <a href="{{ route('admin.regions.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-danger elevation-2">
            <div class="inner">
                <h3>{{ number_format($schoolsCount ?? 0) }}</h3>
                <p>Schools</p>
            </div>
            <div class="icon">
                <i class="fas fa-school"></i>
            </div>
            <a href="{{ route('admin.schools.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-primary elevation-2">
            <div class="inner">
                <h3>{{ number_format($resultsCount ?? 0) }}</h3>
                <p>Results</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-pdf"></i>
            </div>
            <a href="{{ route('admin.results.index') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-secondary elevation-2">
            <div class="inner">
                <h3>{{ number_format($draftsCount ?? 0) }}</h3>
                <p>Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('admin.results.index', ['status' => 'Draft']) }}" class="small-box-footer">Drafts <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Graphs Section -->
<div class="row">
    <div class="col-md-8">
        <div class="card card-card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Results Uploaded per Year</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Results per Level</h3>
            </div>
            <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- Recent Activity -->
        <div class="card card-outline card-dark">
            <div class="card-header">
                <h3 class="card-title">Recent Activity</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>School</th>
                            <th>Year</th>
                            <th>Level</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentResults ?? [] as $r)
                            <tr>
                                <td>{{ optional($r->school)->name ?? '-' }}</td>
                                <td>{{ optional(optional($r->resultTitle)->year)->year ?? '-' }}</td>
                                <td>{{ optional(optional($r->resultTitle)->level)->name ?? '-' }}</td>
                                <td>
                                    @if(($r->status ?? '') === 'Published')
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No recent activity</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- System Status & Alerts -->
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title">System Alerts & Status</h3>
            </div>
            <div class="card-body">
                @if(!empty($latestYearLevelMissing))
                    <div class="alert alert-warning alert-dismissible">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        No results uploaded for {{ $latestYearLevelMissing }} yet.
                    </div>
                @endif
                
                <div class="progress-group">
                    Storage Usage
                    <span class="float-right"><b>160</b>/200 GB</span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 80%"></div>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="mb-1 text-sm text-muted">Server Status: <span class="text-success">Online</span></p>
                    <p class="mb-1 text-sm text-muted">Database: <span class="text-info">{{ strtoupper($dbDriver ?? '-') }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendor/adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script>
    $(function () {
        // Line Chart
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        var lineChartData = {
            labels: @json(($yearLabels ?? [])),
            datasets: [
                {
                    label: 'Results Uploaded',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: @json(($yearData ?? []))
                }
            ]
        }
        var lineChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: { display: false },
            scales: {
                xAxes: [{ gridLines: { display: false } }],
                yAxes: [{ gridLines: { display: false } }]
            }
        }
        new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        })

        // Pie Chart
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData = {
            labels: @json(($levelLabels ?? [])),
            datasets: [
                {
                    data: @json(($levelData ?? [])),
                    backgroundColor: ['#28a745', '#007bff'],
                }
            ]
        }
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    })
</script>
@endpush
