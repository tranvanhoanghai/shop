<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
        <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" type="image/x-icon" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/admin/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{-- Style --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/sweetalert2.min.css') }}">
    @yield('css')
</head>
@yield('style')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <div>
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </div>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ asset('dashboard') }}" class="nav-link">Home</a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- SEARCH FORM -->
            {{-- <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form> --}}
            <span id="app"></span>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ asset('dashboard') }}" class="brand-link">
                <img src="{{ asset('img/LOGO.png') }}" alt="AdminLTE Logo" class="brand-image  elevation-3" style="float:none; width: 80%;">
                
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview z">
                            <a href="#" class="nav-link ">

                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    {{ Auth::user()->full_name }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('dashboard/profile') }}" class="nav-link" id="profile">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Profile</p>
                                    </a>
                                </li>

                                @if(Auth::user()->id_user_type == 1)
                                    <li class="nav-item">
                                        <a href="{{ asset('dashboard/staffs') }}" class="nav-link" id="staffs">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nhân viên</p>
                                        </a>
                                    </li>
                                @endif

                                @if(Auth::user()->id_user_type == 1)
                                    <li class="nav-item">
                                        <a href="{{ asset('dashboard/roles') }}" class="nav-link" id="roles">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Phân quyền</p>
                                        </a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt nav-icon"></i>
                                        <p>Logout</p>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <hr style="border: 1px solid #eee;width:100%; margin-top: 0">

                        <li class="nav-item has-treeview a">
                            <a href="{{ asset('dashboard') }}" class="nav-link">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <p>Tổng quan</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview b">
                            <a href="{{ asset('dashboard/sales') }}" class="nav-link" target="_blank">
                                <i class="fa fa-shopping-cart nav-icon"></i>
                                <p>Bán hàng</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview c">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cube"></i>
                                <p>
                                    Sản phẩm
                                    <i class="fas fa-angle-left right"></i>
                                    <span class="badge badge-info right"></span>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('/dashboard/products') }}" class="nav-link" id="products">
                                        <i class="fas fa-tshirt nav-icon"></i>
                                        <p>Danh sách sản phẩm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('/dashboard/categorys') }}" class="nav-link" id="categorys">
                                        <i class="fa fa-th nav-icon"></i>
                                        <p>Danh mục Sản phẩm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('/dashboard/prices') }}" class="nav-link" id="prices">
                                        <i class="fa fa-tag nav-icon"></i>
                                        <p>Thiết lập giá</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('/dashboard/coupon') }}" class="nav-link" id="coupon">
                                        <i class="fa fa-percent nav-icon"></i>
                                        <p>Mã giảm giá</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview d">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-exchange-alt"></i>
                                <p> 
                                    Hoá đơn 
                                    <i class="right fas fa-angle-left"></i>
                                    @if($bill->total_bill > 0)
                                        <span class="badge badge-info right">
                                            {{ $bill->total_bill }}
                                        </span>
                                    @endif
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('/dashboard/orders') }}" class="nav-link" id="orders">
                                        <i class="fa fa-file nav-icon"></i>
                                        <p>Đặt hàng
                                           
                                            @if($bill->total_bill > 0)
                                                <span class="badge badge-info right">
                                                    {{ $bill->total_bill }}
                                                </span>
                                            @endif
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('/dashboard/retails') }}" class="nav-link" id="retails">
                                        <i class="fa fa-reply-all nav-icon"></i>
                                        <p>Bán lẻ</p>
                                    </a>
                                </li> 
                                {{-- <li class="nav-item">
                                    <a href="pages/charts/flot.html" class="nav-link">
                                        <i class="fa fa-reply-all nav-icon"></i>
                                        <p>Trả hàng</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ asset('dashboard/imports') }}" class="nav-link" id="imports">
                                        <i class="far fa-share-square nav-icon"></i>
                                        <p>Nhập hàng</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="pages/charts/inline.html" class="nav-link">
                                        <i class="fa fa-share-square nav-icon"></i>
                                        <p>Trả hàng nhập</p>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                        <li class="nav-item has-treeview e">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-male"></i>
                                <p>
                                    Đối tác
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('/dashboard/customers') }}" class="nav-link" id="customers">
                                        <i class="fa fa-user nav-icon"></i>
                                        <p>Khách hàng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('/dashboard/suppliers') }}" class="nav-link" id="suppliers">
                                        <i class="fa fa-undo nav-icon"></i>
                                        <p>Nhà cung cấp</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview f">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-globe-americas"></i>
                                <p>
                                    Website
                                    <i class="fa fa-angle-left right"></i>
                                </p> 
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('dashboard/sliders') }}" class="nav-link" id="sliders">
                                        <i class="nav-icon fas fa-sliders-h"></i>
                                        <p>Slider</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ asset('dashboard/blogs') }}" class="nav-link" id="blogs">
                                        <i class="nav-icon fas fa-blog"></i>
                                        <p>Blog</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ asset('dashboard/contacts') }}" class="nav-link" id="contacts">
                                        <i class="nav-icon fas fa-file-contract"></i>
                                        <p>Contact</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview g">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-chart-bar"></i>
                                <p>
                                    Báo cáo
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('dashboard/report/overview/thisYear') }}" class="nav-link" id="overview">
                                        <i class="fas fa-chart-pie nav-icon"></i>
                                        <p>Tổng quan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="{{ asset('/home/') }}" class="nav-link" target="_blank">
                                <i class="nav-icon far fa-eye"></i>
                                {{-- <p>
                                    Báo cáo
                                </p> --}}
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
           
            <!-- /.content-header -->

            <!-- Main content -->
                @yield('content')
                <!-- ner-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer  example-screen">
            <strong>Copyright &copy; 2019-2020 <a href="https://www.facebook.com/profile.php?id=100008643964487" target="target">Hoàng Hải</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0-beta.1
            </div>
        </footer>
    </div>


<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('js/jquery-3.4.1.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('js/admin/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('js/admin/Chart.min.js') }}"></script>
<script src="{{ asset('js/admin/demo.js') }}"></script>

@yield('js')

</body>

</html>