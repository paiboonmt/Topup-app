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
    @include('admin.datatable_header')

</head>

<body class="sidebar-mini layout-fixed" style="height: auto;">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            {{-- <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                       ยินดีต้อนรับ : {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')" class="dropdown-item dropdown-footer"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>

                </li>
            </ul> --}}
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="text-transform: uppercase">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                {{-- https://cdn-icons-png.flaticon.com/512/5543/5543070.png --}}
                <img src="https://cdn-icons-png.flaticon.com/512/5543/5543070.png"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">WEB APPLICATION</span>
            </a>

            <a class="brand-link" data-toggle="dropdown" href="#">
                ยินดีต้อนรับ : {{ Auth::user()->name }}
             </a>

             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="route('logout')" class="dropdown-item dropdown-footer"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>

            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        {{-- Dashboard --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>แดซบอร์ด</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.cart_index') }}"
                                class="nav-link {{ request()->routeIs('admin.cart_index') ? 'active' : '' }}">
                                <i class="fas fa-shopping-cart nav-icon"></i>
                                <p>ขายสินค้า</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.report_ticket') }}"
                                class="nav-link {{ request()->routeIs(['admin.report_ticket', 'admin.view_bill', 'admin.edit_bill']) ? 'active' : '' }}">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>รายงานการขาย</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.product_index') }}"
                                class="nav-link {{ request()->routeIs('admin.product_index') ? 'active' : '' }}">
                                <i class="fab fa-product-hunt nav-icon"></i>
                                <p>สินค้า และ บริการ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.payment') }}"
                                class="nav-link {{ request()->routeIs('admin.payment') ? 'active' : '' }}">
                                <i class="far fa-money-bill-alt nav-icon"></i>
                                <p>วิธีการชำระ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.discount_index') }}"
                                class="nav-link {{ request()->routeIs('admin.discount_index') ? 'active' : '' }}">
                                <i class="fas fa-percentage nav-icon"></i>
                                <p>ส่วนลด</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>Teamplate</p>
                            </a>
                        </li>



                        {{-- Topup --}}
                        {{-- <li
                            class="nav-item  {{ request()->routeIs(['admin.topup_index','admin.topup_show']) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->routeIs(['admin.topup_index','admin.topup_show']) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-credit-card"></i>
                                <p>
                                    ระบบเติมเงิน
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin.topup_index') }}"
                                        class="nav-link {{ request()->routeIs('admin.topup_index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>เติมเงิน</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href=""
                                        class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>ตรวจสอบบัตร</p>
                                    </a>
                                </li>

                            </ul>

                        </li> --}}

                        {{-- Card --}}
                        {{-- <li
                            class="nav-item {{ request()->routeIs(['admin.card_index', 'admin.card_show']) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->routeIs(['admin.card_index', 'admin.card_show']) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-credit-card"></i>
                                <p>
                                    Card
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.card_index') }}"
                                        class="nav-link {{ request()->routeIs('admin.card_index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Card Register</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.card_show') }}"
                                        class="nav-link {{ request()->routeIs('admin.card_show') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Card Check</p>
                                    </a>
                                </li>
                            </ul>

                        </li> --}}

                        {{-- Customer --}}
                        {{-- <li
                            class="nav-item {{ request()->routeIs(['admin.customers', 'admin.customer_create','admin.customer_expired']) ? 'menu-open' : '' }}">
                            <a href="{{ route('admin.customers') }}"
                                class="nav-link {{ request()->routeIs(['admin.customers', 'admin.customer_create','admin.customer_expired']) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    customer
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin.customer_create') }}"
                                        class="nav-link {{ request()->routeIs('admin.customer_create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Register customer</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.customers') }}"
                                        class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>customer active</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.customer_expired') }}"
                                        class="nav-link {{ request()->routeIs('admin.customer_expired') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>customer expired</p>
                                    </a>
                                </li>

                            </ul>

                        </li> --}}

                        {{-- Fighter --}}
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.fighters') }}"
                                class="nav-link {{ request()->routeIs(['admin.fighters','admin.fighter_profile']) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-ninja"></i>
                                <p>fighters</p>
                            </a>
                        </li> --}}

                        {{-- Trainer --}}
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.trainer_index') }}"
                                class="nav-link {{ request()->routeIs(['admin.trainer_index', 'admin.trainer_create', 'admin.trainer_show']) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-ninja"></i>
                                <p>Trainer</p>
                            </a>
                        </li> --}}

                        {{-- report --}}
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.report_index') }}"
                                class="nav-link {{ request()->routeIs('admin.report_index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-signature"></i>
                                <p>Report</p>
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
    @include('admin.datatable_footer')

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                "buttons": ["excel"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        $(function() {
            $(".cart").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#cart_wrapper .col-md-6:eq(0)');
        });

        $(function() {
            $("#product").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
            }).buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');
        }), $("#discount").DataTable() ,$("#payments").DataTable();
        
    </script>

</body>
</html>
