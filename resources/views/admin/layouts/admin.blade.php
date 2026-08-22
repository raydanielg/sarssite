<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Dashboard') | EMAS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
  @stack('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          <span class="ml-1">{{ optional(auth()->user())->name ?? 'Admin' }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-success elevation-4">
    <a href="#" class="brand-link">
      <img src="{{ asset('emblem.png') }}" alt="EMAS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">EMAS ADMIN</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-header">MANAGEMENT</li>

          <!-- Years -->
          <li class="nav-item {{ request()->is('admin/years*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/years*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Years
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.years.index') }}" class="nav-link {{ request()->is('admin/years') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Years</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.years.create') }}" class="nav-link {{ request()->is('admin/years/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Year</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Result Types -->
          <li class="nav-item {{ request()->is('admin/result-types*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/result-types*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Result Types
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.result-types.index') }}" class="nav-link {{ request()->is('admin/result-types') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Types</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.result-types.create') }}" class="nav-link {{ request()->is('admin/result-types/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Type</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Levels -->
          <li class="nav-item {{ request()->is('admin/levels*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/levels*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Levels
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.levels.index') }}" class="nav-link {{ request()->is('admin/levels') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Levels</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.levels.create') }}" class="nav-link {{ request()->is('admin/levels/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Level</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Regions -->
          <li class="nav-item {{ request()->is('admin/regions*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/regions*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-globe-africa"></i>
              <p>
                Regions
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.regions.index') }}" class="nav-link {{ request()->is('admin/regions') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Regions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.regions.create') }}" class="nav-link {{ request()->is('admin/regions/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Region</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Districts -->
          <li class="nav-item {{ request()->is('admin/districts*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/districts*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-map-marked-alt"></i>
              <p>
                Districts (Wilaya)
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.districts.index') }}" class="nav-link {{ request()->is('admin/districts') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Districts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.districts.create') }}" class="nav-link {{ request()->is('admin/districts/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add District</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.districts.bulk-create-form') }}" class="nav-link {{ request()->is('admin/districts-bulk-create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bulk Add Districts</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Schools -->
          <li class="nav-item {{ request()->is('admin/schools*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/schools*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-school"></i>
              <p>
                Schools
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.schools.index') }}" class="nav-link {{ request()->is('admin/schools') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Schools</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.schools.create') }}" class="nav-link {{ request()->is('admin/schools/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add School</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">RESULTS</li>

          <!-- Result Categories (Titles) -->
          <li class="nav-item {{ request()->is('admin/result-titles*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/result-titles*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Result Titles
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.result-titles.index') }}" class="nav-link {{ request()->is('admin/result-titles') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Titles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.result-titles.create') }}" class="nav-link {{ request()->is('admin/result-titles/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Title</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Result Summaries -->
          <li class="nav-item {{ request()->is('admin/result-summaries*') || request()->is('admin/bulk-summaries') || request()->is('admin/region-summaries*') || request()->is('admin/district-summaries*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/result-summaries*') || request()->is('admin/bulk-summaries') || request()->is('admin/region-summaries*') || request()->is('admin/district-summaries*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Result Summaries
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.result-summaries.index') }}" class="nav-link {{ request()->is('admin/result-summaries') && !request()->has('type') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Summaries</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.result-summaries.index', ['type' => 'region']) }}" class="nav-link {{ request()->get('type') === 'region' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Summaries za Mikoa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.result-summaries.index', ['type' => 'district']) }}" class="nav-link {{ request()->get('type') === 'district' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Summaries za Wilaya</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.region-summaries.create') }}" class="nav-link {{ request()->is('admin/region-summaries/create') ? 'active' : '' }}">
                  <i class="fas fa-map-marked-alt nav-icon text-success"></i>
                  <p>Upload Summary ya Mkoa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.region-summaries.bulk-form') }}" class="nav-link {{ request()->is('admin/region-summaries/bulk') ? 'active' : '' }}">
                  <i class="fas fa-layer-group nav-icon text-success"></i>
                  <p>Bulk Upload - Mikoa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.district-summaries.create') }}" class="nav-link {{ request()->is('admin/district-summaries/create') ? 'active' : '' }}">
                  <i class="fas fa-map-pin nav-icon text-primary"></i>
                  <p>Upload Summary ya Wilaya</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.district-summaries.bulk-form') }}" class="nav-link {{ request()->is('admin/district-summaries/bulk') ? 'active' : '' }}">
                  <i class="fas fa-layer-group nav-icon text-primary"></i>
                  <p>Bulk Upload - Wilaya</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Results -->
          <li class="nav-item {{ request()->is('admin/results*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/results*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>
                Results
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.results.index') }}" class="nav-link {{ request()->is('admin/results') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Results</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.results.create') }}" class="nav-link {{ request()->is('admin/results/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Upload Result</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>Find Result</p>
            </a>
          </li>

          <li class="nav-header">COMMUNICATION</li>

          <!-- Announcements -->
          <li class="nav-item {{ request()->is('admin/announcements*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/announcements*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>
                Announcements
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->is('admin/announcements') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Announcements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.announcements.create') }}" class="nav-link {{ request()->is('admin/announcements/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Announcement</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">SYSTEM</li>

          <!-- Admins -->
          <li class="nav-item {{ request()->is('admin/admins*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/admins*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Admins
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->is('admin/admins') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Admins</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.admins.create') }}" class="nav-link {{ request()->is('admin/admins/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Admin</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Settings -->
          <li class="nav-item {{ request()->is('admin/settings*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Settings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Logo & System Name</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item mt-3">
            <a href="{{ route('logout') }}" class="nav-link bg-danger" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-power-off"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('page_title')</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">EMAS</a>.</strong>
    All rights reserved.
  </footer>
</div>

<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    $(function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if(session('status'))
            toastr.success("{{ session('status') }}");
        @endif
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        // Global Form Loading State
        $(document).on('submit', 'form', function() {
            var $btn = $(this).find('button[type="submit"]');
            if ($btn.length && !$btn.hasClass('no-loading')) {
                // Check if the button is within a SweetAlert (don't disable those here)
                if (!$btn.closest('.swal2-container').length) {
                    $btn.attr('data-original-text', $btn.html());
                    $btn.prop('disabled', true);
                    $btn.html('<i class="fas fa-spinner fa-spin"></i> Please wait...');
                }
            }
        });

        $(document).on('click', '[data-confirm-delete]', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const title = $(this).data('confirm-title') || 'Are you sure?';
            const text = $(this).data('confirm-text') || 'This action cannot be undone.';
            const confirmText = $(this).data('confirm-button') || 'Yes, delete it';

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed && form.length) {
                    // Show a loading state on the swal button
                    Swal.fire({
                        title: 'Deleting...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            });
        });
    });
</script>
@stack('js')
</body>
</html>
