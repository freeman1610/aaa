<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transporte La Garra</title>
  <link rel="shortcut icon" href="{{ asset('vendor/images/lagarra.png') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="{{asset('vendor/css/bootstrap.min.css') }} ">
  <link rel="stylesheet" href="{{ asset('vendor/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/css/chatbot.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/css/subir-boton.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.css')}}">
  <link rel="stylesheet" href="{{ asset('vendor/css/jquery.fancybox.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/css/owl.theme.default.min.css') }}" />

  <!-- Font Google -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <!-- PWA  -->
  <meta name="theme-color" content="#1e1f21" />
  <link rel="apple-touch-icon" href="{{ asset('lagarra.png') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container"> <a class="navbar-brand navbar-logo" href="#"> <img width="300" src="{{asset('vendor/images/lagarra_white.png')}}" alt="logo" class="logo-1"> </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="fas fa-bars"></span> </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="0">INICIO</a> </li>
          <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="1">ACERCA DE</a> </li>
          <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="2">CONTACTO</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{route('login')}}">¿ERES EMPLEADO?</a> </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->

  <!-- Banner Image -->

  <div class="banner text-center" data-scroll-index='0'>
    <div class="banner-overlay">
      <div class="container">
        <h1 class="text-capitalize">TRANSPORTE LA GARRA C.A</h1>
        <p>Tú Empresa de Transporte</p>
      </div>
    </div>
  </div>

  <!-- End Banner Image -->

  <!-- Services -->
  <div class="services section-padding bg-grey" data-scroll-index='1'>
    <div class="container">
      <div class="row">
        <div class="col-md-12 section-title text-center">
          <h3>¡Quienes Somos!</h3>


          <p>Somos Tú Empresa de Transporte</p>
          <span class="section-title-line"></span>
          <p class="pt-3">Somos una Empresa de Confianza con una Larga Trayectoria en el Transporte Transportarmos
            Alimentos de
            Empresas Polar C.A & Transporte de Ganaderia</p>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-30">
          <div class="service-box bg-white text-center">
            <div class="icon"> <i class="fas fa-box"></i> </div>
            <div class="icon-text">
              <h4 class="title-box">Transporte de Alimentos</h4>
              <p>Transportamos ALimentos a Cualquier Zona del País</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-30">
          <div class="service-box bg-white text-center">
            <div class="icon"> <i class="fas fa-cow"></i> </div>
            <div class="icon-text">
              <h4 class="title-box">Transporte de Ganaderia</h4>
              <p>Se Transporta Ganado a Cualquier Parte del Venezuela</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-30">
          <div class="service-box bg-white text-center">
            <div class="icon"> <i class="fas fa-truck"></i> </div>
            <div class="icon-text">
              <h4 class="title-box">Tienes Otro Tipo de Transporte</h4>
              <p>Si tienes Otro tipo de Transporte que no sea Alimentos o Ganaderia, Contactanos para Llegar a tu
                Solución</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- End Services -->

  <!-- Contact -->
  <div class="contact section-padding" data-scroll-index='2'>
    <div class="container">
      <div class="row d-flex justify-content-center text-center">
        <div class="col-md-12 section-title text-center pt-5">
          <h3>Contacto <i class="fas fa-address-card"></i></h3>

          <span class="section-title-line"></span>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-30">

          <h4 class="title-box text-primary">Direccion <i class="fas fa-map-marker-alt"></i> </h4>

          <p><a target="_blank" href="https://www.google.com/maps/@7.7652874,-72.2409211,20z">Madre Juana, San Cristóbal, Estado Táchira</a></p>

        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-30">

          <h4 class="title-box text-danger">Telefono de Contacto <i class="fas fa-phone"></i> </h4>
          <p><a href="tel:+5802763463524">+58 (0276) 3463524</a></p>

        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-30">

          <h4 class="title-box text-info">Email de Contacto <i class="fas fa-envelope"></i></h4>
          <p> <a href="mailto:transportelagarraca@gmail.com">transportelagarraca@gmail.com</a></p>

        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- End Contact -->
  <footer class="footer-section">
    <div class="container-fluid text-center pb-5 pt-5">
      <div class="row">
        <div class="col-md-12">
          <p class="copyright">
            <strong>Copyright &copy; 2022<b> Transporte la Garra C.A.</strong> RIF: J-40870635-0</b>
            <br>
            <strong>Created By: Islender Montilva - José González - Cesar Colmenares - Pedro Saavedra</strong>
          </p>
        </div>
      </div>
    </div>
    </div>
  </footer>
  <!-- CHAT BOT -->
  <div class="wrapper">
    <div id="divChat" class="chatbot ">
      <div class="title h2">Asistente Virtual</div>
      <div class="form">
        <div class="bot-inbox inbox">
          <div class="msg-header">
          </div>
        </div>
      </div>
      <div class="typing-field">
        <div class="input-data">
          <table class="table table-responsive" id="tablaXD">
            <tr class="text-white" id="preguntasTr"></tr>
          </table>
        </div>
      </div>
    </div>
    <div class="botonChaBot">
      <button type="button" class="btn btn-danger mr-3" id="cerrarChat">X Cerrar</button>
      <button type="button" class="btn btn-info" id="btn-ver-chat">Chat Bot</button>
    </div>
  </div>
  <div class="subir-contenedor">
    <div class="subir-boton">
      <img src="{{ asset('vendor/images/arriba.png')}}" width="50">
    </div>
  </div>
  <!-- FIN CHAT BOT -->
  <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/js/bootstrap.min.js') }}"></script>
  <!-- owl carousel js -->
  <!-- magnific-popup -->
  <script src="{{ asset('vendor/js/jquery.fancybox.min.js') }}"></script>

  <!-- scrollIt js -->
  <script src="{{ asset('vendor/js/scrollIt.min.js') }}"></script>

  <!-- isotope.pkgd.min js -->
  <script src="{{ asset('vendor/js/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendor/scripts/chat_bot_welcome.js') }}"></script>
  <script src="{{ asset('vendor/scripts/welcome.js') }}"></script>
  <script src="{{ asset('sw.js') }}"></script>
  <script>
    if (!navigator.serviceWorker.controller) {
      navigator.serviceWorker.register("sw.js").then(function(reg) {
        console.log("Service worker has been registered for scope: " + reg.scope);
      });
    }
  </script>
</body>

</html>