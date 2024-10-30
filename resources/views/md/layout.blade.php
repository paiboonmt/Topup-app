<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/5543/5543070.png">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{ asset('font/font.css') }}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
  {{-- sweetalert2 --}}
  <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
  {{-- bootstrap4-toggle --}}
  <link rel="stylesheet" href="{{ asset('toggle/bootstrap4-toggle.min.css') }}">
  {{-- @include('admin.datatable_header') --}}

</head>
<body class="sidebar-mini layout-fixed" style="height: auto;">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Dropdown Menu -->
      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">
            {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="route('logout')"
                    class="dropdown-item dropdown-footer"
                    onclick="event.preventDefault();
                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>

        </div>

      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('md.dashboard') }}" class="brand-link">
        {{-- https://cdn-icons-png.flaticon.com/512/5543/5543070.png --}}
      <img src="https://cdn-icons-png.flaticon.com/512/5543/5543070.png"
            class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">TIGER APPICATION</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2" style="text-transform: uppercase">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('md.dashboard') }}" class="nav-link {{ request()->routeIs('md.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>แดช บอร์ด</p>
                </a>
            </li>

            {{-- Topup --}}
            {{-- {{ request()->routeIs(['admin.topup_index','admin.topup_show']) ? 'menu-open' : '' }} --}}
            {{-- {{ request()->routeIs(['admin.topup_index','admin.topup_show']) ? 'active' : '' }} --}}
            <li class="nav-item  menu-open">
                <a href="#" class="nav-link {{ request()->routeIs(['md.report_daily','md.report_ticket','md.report_summary','md.report_checkin']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-credit-card"></i>
                    <p>
                        รายงาน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    {{-- {{ request()->routeIs('admin.topup_index') ? 'active' : '' }} --}}
                    <li class="nav-item ">
                        <a href="{{ route('md.report_daily') }}" class="nav-link {{ request()->routeIs('md.report_daily') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายงานประจำ วัน</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('md.report_ticket') }}" class="nav-link {{ request()->routeIs('md.report_ticket') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายงานขาย ticket</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('md.report_summary') }}" class="nav-link {{ request()->routeIs('md.report_summary') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายงานยอดรวม รายวัน</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('md.report_checkin') }}" class="nav-link {{ request()->routeIs('md.report_checkin') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายงานการเช็คอิน</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายงานขายสินค้า</p>
                        </a>
                    </li>

                </ul>

            </li>

            {{-- Trainer --}}
            {{-- <li class="nav-item">
                <a href="{{ route('admin.trainer_index') }}"
                class="nav-link {{ request()->routeIs(['admin.trainer_index','admin.trainer_create','admin.trainer_show']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-ninja"></i>
                    <p>Trainer</p>
                </a>
            </li> --}}

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Main Sidebar Container -->

  {{-- content-wrapper --}}
  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
  </div>
  {{-- content-wrapper --}}

</div>

<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
{{-- sweetalert2 --}}
<script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>
{{-- bootstrap4-toggle --}}
<script src="{{ asset('toggle/bootstrap4-toggle.min.js') }}"></script>
{{-- datatable --}}
{{-- @include('admin.datatable_footer') --}}

{{-- <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        "buttons": ["excel"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script> --}}



</body>
</html>
