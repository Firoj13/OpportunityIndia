<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? config('app.name', 'Admin') }}</title>
    <!-- Scripts -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('admin/js/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/admin.css') }}">
    <!-- Pnotify -->
    <link type="text/css" rel="stylesheet" href="{{ url('admin/css/alert.css') }}">

    <link rel="stylesheet"
          href="{{ asset('admin/js/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('admin/js/plugins/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="{{ asset('admin/js/plugins/pNotify/PNotify.js') }}"></script>


    <script>
        var addedmsg = "<?=Session::get('added')?>";
        var updatedmsg = "<?=Session::get('updated')?>";
        var deletedmsg = "<?=Session::get('deleted')?>";
        var warningmsg = "<?=Session::get('warning')?>";
    </script>
    <!-- Custom alert -->
    <script src="{{ asset('admin/js/alert.js') }}"></script>
    @notify_css
    @yield('stylesheet')
    <script>
        var baseUrl = @json(url('/'));
    </script>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" title="Fullscreen" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" title="Logout" href="{{ route('admin.logout') }}"
                   onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{url('admin/img/AdminLTELogo.png')}}" alt="Opportunity India Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">OpportunityIndia</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{url('admin/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }} (<span class="role">{{ Auth::user()->getRole() }}</span>)</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{url('/admin/home')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @if(Auth::user()->hasPermissionTo('manage-users'))
                        <li class="nav-item">
                            <a href="{{url('admin/users')}}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item menu-is-opening menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tags nav-icon"></i>
                            <p>Manage Seo Tags</p>
                        </a>
                        <ul class="nav nav-treeview">

                            @if(Auth::user()->hasPermissionTo('manage-seo-tags'))
                                <li class="nav-item {{request()->is('admin/seo-tags')?'active':''}} ">
                                    <a href="{{url('admin/seo-tags')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>English</p>
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->hasPermissionTo('manage-seo-tags-hi'))
                                <li class="nav-item {{request()->is('admin/seo-tags-hi')?'active':''}} ">
                                    <a href="{{url('admin/seo-tags-hi')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> Hindi</p>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>

                    <li class="nav-item menu-is-opening menu-open">
                        <a href="#" class="nav-link">
                            <i class="fas fa-box nav-icon"></i>
                            <p>Manage Article</p>
                        </a>
                        <ul class="nav nav-treeview">

                            @if(Auth::user()->hasPermissionTo('manage-articles'))
                                <li class="nav-item {{request()->is('admin/articles')?'active':''}} ">
                                    <a href="{{url('admin/articles/english')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Articles English</p>
                                    </a>
                                </li>
                            @endif


                            @if(Auth::user()->hasPermissionTo('manage-articles-hi'))
                                <li class="nav-item {{request()->is('admin/articles-hi')?'active':''}} ">
                                    <a href="{{url('admin/articles/hindi')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Articles Hindi</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                   <!--  <li class="nav-item menu-is-opening menu-open">
                        <a href="#" class="nav-link">
                            <i class="fas fa-box nav-icon"></i>
                            <p>Manage News</p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Auth::user()->hasPermissionTo('manage-news-en'))
                                <li class="nav-item {{request()->is('admin/news/english')?'active':''}} ">
                                    <a href="{{url('admin/news/english')}}" class="nav-link">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <p>Manage News EN</p>
                                    </a>
                                </li>
                            @endif

                            @if(Auth::user()->hasPermissionTo('manage-news-hi'))
                                <li class="nav-item {{request()->is('admin/news/hindi')?'active':''}} ">
                                    <a href="{{url('admin/news/hindi')}}" class="nav-link">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <p>Manage News Hindi</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li> -->

                    @if(Auth::user()->hasPermissionTo('manage-authors'))
                        <li class="nav-item {{request()->is('admin/authors')?'active':''}} ">
                            <a href="{{url('admin/authors')}}" class="nav-link">
                                <i class="nav-icon fas fa-pen"></i>
                                <p>Manage Authors</p>
                            </a>
                        </li>
                    @endif

                    @if(Auth::user()->hasPermissionTo('manage-audio-files'))
                        <li class="nav-item {{request()->is('admin/audios')?'active':''}} ">
                            <a href="{{url('admin/audios')}}" class="nav-link">
                                <i class="nav-icon fas fa-file-audio"></i>
                                <p>Manage Audio Files</p>
                            </a>
                        </li>
                    @endif

                    @if(Auth::user()->isAdmin())
                        <li class="nav-item {{request()->is('admin/permissions')?'active':''}}">
                            <a href="{{url('admin/permissions')}}" class="nav-link">
                                <i class="nav-icon fas fa-user-tag"></i>
                                <p>Roles & Permissions</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

</div>
<div class="content-wrapper">
    <div class="row tile_count">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            <h5>{{$error}}</h5>
                        </li>

                    @endforeach
                </ul>
            </div>
        @endif
        @if (Session::has('added'))
            <script>
                success();
            </script>
        @elseif (Session::has('updated'))
            <script>
                update();
            </script>
        @elseif (Session::has('deleted'))
            <script>
                deleted();
            </script>

        @elseif (Session::has('warning'))
            <script>
                warning();
            </script>
        @endif
    </div>
    @yield('content')
</div>
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="{{config('app.url')}}">{{config('app.name')}}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0
    </div>
</footer>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
@notify_js
@notify_render
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('page-js-script')
<!-- jQuery -->


<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<!-- Bootstrap -->
<script src="{{ asset('admin/js/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('admin/js/adminlte.js') }}"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('admin/js/plugins/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('admin/js/pages/dashboard3.js')}}"></script>
<!-- JQUERY VALIDATION -->
<script src="{{ asset('admin/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<!-- Sweetalert -->
<script src="{{ asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

<script src="{{ asset('admin/js/plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('admin/js/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{ asset('admin/js/plugins/daterangepicker/daterangepicker.js')}}"></script>


</body>
</html>

