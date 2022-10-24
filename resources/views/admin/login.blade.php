<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Trans La Garra C.A - Login</title>
  <link rel="shortcut icon" href="{{ asset('vendor/images/lagarra.png') }}">
  <link rel="stylesheet" href="{{ asset('vendor/css/login.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('vendor/plugins/toastr/toastr.min.css') }}">
</head>
<body onload="document.getElementById('login').focus()" class="hold-transition login-page">
  
  <div class="container">
   
    <div class="container-sl">
      <div class="slide">
      <div class="slide__item is-active"></div>
      <div class="slide__item"></div>
      <div class="slide__item"></div>
      </div>
    </div>

    <div class="row formulario">
      <div class="login-caja">
        <a href="{{ route('principio') }}" class="boton-regresar"><span class="fas fa-arrow-left"></span> Regresar</a>
            <h1>Bienvenido</h1>
            <form method="post" name="frmAcceso" id="frmAcceso">
              <label for="login">Usuario</label>
              <input type="text" id="login" name="login" placeholder="Usuario" autocomplete="off" required>
              <label for="contra_usuario">Contraseña</label>
              <input type="password" id="password" name="password" placeholder="Contraseña" required>
              <button type="submit" class="boton-submit">Entrar</button>
            </form>
      </div>

    
  <!-- 			Slide -- End 			-->
    
    <div class="title__container">
      
      <h2 class="title" align="center">"La Garra C.A"</h2>
    </div>
    </div>
  </div>
<!-- jQuery -->
<script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('vendor/plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->

<script src="{{ asset('vendor/scripts/login.js') }}"></script>
<script src="{{ asset('vendor/scripts/slide.js') }}"></script>
<script src="{{ asset('vendor/scripts/passwd.js') }}"></script>
{{-- <script src="{{ asset('vendor/script/script.js') }}"></script> --}}
</body>
</html>
