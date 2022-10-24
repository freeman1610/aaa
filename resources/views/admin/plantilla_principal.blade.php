<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @yield('etiquetas_header')
  <title>Transporte | La Garra C.A</title>
  <link rel="shortcut icon" href="{{ asset('vendor/images/lagarra.png') }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/bs-stepper/css/bs-stepper.min.css') }}">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/dropzone/min/dropzone.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/toastr/toastr.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendor/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

</head>
<body class="hold-transition sidebar-mini layout-fixed" id="centro_central">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <div class="nav-link dropdown-toggle cursor-pointer" role="button" data-toggle="dropdown">
                        <img id="imgUser1" src="{{ asset('vendor/img-users/'.Auth::user()->imagen) }}" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-md-inline">{{ Auth::user()->nombre }}</span>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img id="imgUser2" src="{{ asset('vendor/img-users/'.Auth::user()->imagen) }}" aaa class="img-circle elevation-2" width="160px" alt="User Image">
                            <p>
                                <small>{{ Auth::user()->nombre }}</small>
                            </p>
                            <p>
                                <small>{{ Auth::user()->cargo }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <button id="btn-toggle" onclick="cambiarModo()" class="btn btn-default btn-flat"> Modo</button>
                            {{-- Enlace perfil personal --}}
                            <a href="{{ route('perfil') }}" class="btn btn-default btn-flat">Perfil</a>
                            {{-- Logout --}}
                            <a href="{{ route('logout.exitt') }}" class="btn btn-default btn-flat float-right">Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav><!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-dark-orange">
            <!-- Brand Logo -->
            <div class="brand-link">
                {{-- Icono de la Garra --}}
                <img src="{{ asset('vendor/images/lagarra.png') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Transp. La Garra C.A</span>
            </div>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img id="imgUser3" src="{{ asset('vendor/img-users/'.Auth::user()->imagen) }}" class="img-circle elevation-2" width="160px" alt="User Image">
                    </div>
                    <div class="info">
                        <div href="#" class="text-white d-block">{{ Auth::user()->nombre }}</div>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                {{-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('escritorio') }}" class="nav-link" id="escritorio">
                                <i class="nav-icon fas fa  fa-home (alias)"></i><p>Escritorio</p>
                            </a>
                        </li>

                          @if( Auth::user()->cargo == 'ADMINISTRADOR' || session()->get('sistema') == 1)

                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link" id="acc">
                                <i class="nav-icon fas fa-laptop"></i><p>Acceso<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('usuarios') }}" class="nav-link" id="usr">
                                        <i class="fas fa-user-circle nav-icon"></i><p>Usuarios y Sistema</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tipo_usuario') }}" class="nav-link" id="tpusr">
                                        <i class="fas fa-users nav-icon"></i><p>Tipos de Usuarios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('chat_bot') }}" class="nav-link" id="chat_bot">
                                        <i class="fas fa-comments nav-icon"></i><p>Config. Chat Bot</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->cargo == 'ADMINISTRADOR' || session()->get('administrativo') == 1)
                        <li class="nav-item">
                            <a href="{{ route('empleados') }}" class="nav-link" id="emp">
                                <i class="nav-icon fas fa-book"></i><p>Registro de Empleados</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="nom">
                                <i class="nav-icon fas fa-file-alt"></i><p>Nóminas<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('nomina_personal') }}" class="nav-link" id="nom_a">
                                        <i class="fas fa-users nav-icon"></i><p>Nómina Administrativa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nomina_chofer') }}" class="nav-link" id="nom_chofer">
                                        <i class="fas fa-address-card nav-icon"></i><p>Nómina Choferes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('presupuesto') }}" class="nav-link" id="presupuesto">
                                        <i class="fa fa-university nav-icon"></i><p>Asignar Presupuesto</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('departamentos') }}" class="nav-link" id="dep">
                                <i class="nav-icon fas fa-city"></i><p>Departamentos</p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->cargo == 'ADMINISTRADOR' || session()->get('administrativo') == 1)
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="transporte">
                                <i class="nav-icon fas fa-truck"></i><p>Transporte<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('chutos') }}" class="nav-link" id="chutos">
                                        <i class="fas fa-truck-pickup nav-icon"></i><p>Chutos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cavas') }}" class="nav-link" id="cavas">
                                        <i class="fas fa-trailer nav-icon"></i><p>Cavas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('fletes') }}" class="nav-link" id="fletes">
                                        <i class="fas fa-th-list nav-icon"></i><p>Fletes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('viajes') }}" class="nav-link" id="viajes">
                                        <i class="fas fa-shipping-fast nav-icon"></i><p>Viajes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('viajes_completados') }}" class="nav-link" id="viajes_comp">
                                        <i class="fas fa-flag-checkered nav-icon"></i><p>Viajes Completados</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->cargo == 'ADMINISTRADOR' || session()->get('sistema') == 1)

                        <li class="nav-item">
                            <a href="{{ route('auditoria') }}" class="nav-link" id="aud">
                                <i class="nav-icon fas fa-bars"></i><p>Auditoria</p>
                            </a>
                        </li>
                        @endif
                        @if(session()->get('almacen') == 1)
                        <li class="nav-item">
                            <a href="{{ route('almacen') }}" class="nav-link" id="alm">
                                <i class="nav-icon fas fa-database"></i><p>Almacen</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav><!-- /.sidebar-menu -->
            </div><!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                    @yield('contenidoCentral')

                </div><!-- /.container-fluid -->
            </div><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Versión 2022.3
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022<b> Transporte la Garra C.A</strong> Todos los derechos reservados.</b>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<script src="{{ asset('vendor/scripts/sweetalert2@11.js') }}"></script>
<script src="{{ asset('vendor/scripts/numeral.min.js') }}"></script>

<!-- jQuery -->
<script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('vendor/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('vendor/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('vendor/plugins/chart.js/Chart.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('vendor/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('vendor/plugins/toastr/toastr.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('vendor/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/js/adminlte.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('vendor/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendor/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Bootbox.alert alertas -->
<script src="{{ asset('vendor/js/bootbox.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('vendor/js/demo.js') }}"></script>
<script src="{{ asset('vendor/scripts/escritorio.js') }}"></script>
@yield('agregarScriptsJS')
</body>
</html>
