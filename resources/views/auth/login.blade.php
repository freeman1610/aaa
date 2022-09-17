<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#ab540a">
  <meta name="MobileOptimized" content="width">
  <meta name="HandheldFriendly" content="true">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <title>Trans La Garra C.A - Login</title>
  <link rel="shortcut icon" href="../files/principal/lagarra.ico">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
  {{-- <link rel="apple-touch-icon" href="../files/principal/img01.png"> --}}
  {{-- <link rel="apple-touch-startup-image" href="../files/principal/imageapp.png"> --}}
  {{-- <link rel="manifest" href="./manifest.json">  --}}
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Inicio de Sesión</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Ingresa para Iniciar Sesión</p>

      <form method="post" id="frmAcceso">
        <div class="input-group mb-3">
          <input type="text" id="logina" name="logina" class="form-control" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="clavea" id="clavea" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
                <span class="fa fa-eye mr-2" id="show"></span>
                <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <a href="../index.html" class="btn btn-primary btn-block">Regresar</a>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
    </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('vendor/plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('vendor/scripts/login.js') }}"></script>
<script src="{{ asset('vendor/scripts/passwd.js') }}"></script>
<script src="{{ asset('vendor/script/script.js') }}"></script>
</body>
</html>
