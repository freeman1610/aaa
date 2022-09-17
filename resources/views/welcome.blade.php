<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transporte La Garra</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#A1A1A1">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="shortcut icon" href="{{ asset('vendor/images/lagarra.png') }}">

    <!-- Bootstrap CSS Style -->
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.min.css') }}">

    <!-- Template CSS Style -->
    <link rel="stylesheet" href="{{ asset('vendor/css/style.css') }}">

    <!-- Animate CSS  -->
    <link rel="stylesheet" href="{{ asset('vendor/css/animate.css') }}">

    <!-- FontAwesome 4.3.0 Icons  -->
    <link rel="stylesheet" href="{{ asset('vendor/css/font-awesome.min.css') }}">

    <!-- et line font  -->
    <link rel="stylesheet" href="{{ asset('vendor/css/et-line-font/style.css') }}">

    <!-- BXslider CSS  -->
    <link rel="stylesheet" href="{{ asset('vendor/css/bxslider/jquery.bxslider.css') }}">

    <!-- Owl Carousel CSS Style -->
    <link rel="stylesheet" href="{{ asset('vendor/css/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/owl-carousel/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/owl-carousel/owl.transitions.css') }}">

    <!-- Magnific-Popup CSS Style -->
    <link rel="stylesheet" href="{{ asset('vendor/css/magnific-popup/magnific-popup.css') }}">

</head>
<body>

    <!-- Preload the Whole Page -->
  <div id="preloader">      
    <div id="loading-animation">&nbsp;</div>
  </div>
  <!-- Navbar -->
  <header class="header">
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation-nav">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
           <a class="navbar-brand" href="#"><img src="{{ asset('vendor/images/lagarra_welcome.png') }}" height="40" ></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navigation-nav">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a class="section-scroll" href="#wrapper">Home</a></li>
            <li><a href="#landing-offer">Acerca de</a></li>
            <li><a href="#banner-services">Contacto</a></li>
            <li><a href="{{ route('login') }}">¿Eres Empleado?</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>
  </header>
  <!-- End Navbar -->

  <div id="wrapper">

  <!-- Hero
  ================================================== -->
    <section>
      <div id="hero-section" class="landing-hero" data-stellar-background-ratio="0">
        <div class="hero-content">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2">

                <div class="hero-text">
                  <div class="herolider">
                    <ul class="caption-slides">

                      <li class="caption">
                        <h1>Transporte La Garra</h1>
                        <div class="div-line"></div>
                        <p class="hero">Tú Empresa de Transporte</p>
                      </li>

                      <li class="caption">
                        <h1>Necesitas Transportar Mercancia</h1>
                        <div class="div-line"></div>
                        <p class="hero">Transporte La Garra Te da la Solución</p>
                      </li>

                      <li class="caption">
                        <h1>¡Estamos Ubicados!</h1>
                        <div class="div-line"></div>
                        <p class="hero">San Cristóbal - Estado Táchira</p>
                      </li>

                    </ul>
                  </div> <!-- end herolider -->
                </div> <!-- end hero-text -->

                <div class="hero-btn">
                  <a href="#landing-offer" class="btn btn-clean">Leer Más</a>
                </div> <!-- end hero-btn -->

              </div> <!-- end col-md-6 -->
            </div> <!-- end row -->
          </div> <!-- End container -->
        </div> <!-- End hero-content -->
      </div> <!-- End hero-section -->
    </section>
    <!-- End hero section -->

    <!-- Offer
    ================================================== -->
    <section>
      <div id="landing-offer" class="pad-sec">
        <div class="container">

          <div class="title-section big-title-sec animated out" data-animation="fadeInUp" data-delay="0">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                <h2 class="big-title">¡Quienes Somos!</h2>
                <h1 class="big-subtitle">Somos Tú Empresa de Transporte</h1>
                <hr>
                <p class="about-text">Somos una Empresa de Confianza con una Larga Trayectoria en el Transporte
                Transportarmos Alimentos de Empresas Polar C.A  &amp; Transporte de Ganaderia</p>
              </div>
            </div> <!-- End row -->
          </div> <!-- end title-section -->

          <div class="offer-boxes">

            <div class="row">
            <div class="col-sm-4">
              <div class="offer-post text-center animated out" data-animation="fadeInLeft" data-delay="0">
                <div class="offer-icon">
                  <span class="icon-desktop"></span>
                </div>
                <h4>Transporte de Alimentos</h4>
                <p>Transportamos ALimentos a Cualquier Zona del País</p>
              </div> <!-- End offer-post -->
            </div> <!-- End col-sm-4 -->

            <div class="col-sm-4">
              <div class="offer-post text-center animated out" data-animation="fadeInUp" data-delay="0">
                <div class="offer-icon">
                  <span class="icon-piechart"></span>
                </div>
                <h4>Transporte de Ganaderia</h4>
                <p>Se Transporta Ganado a Cualquier Parte del Venezuela</p>
              </div> <!-- End offer-post -->
            </div> <!-- End col-sm-4 -->

            <div class="col-sm-4">
              <div class="offer-post text-center animated out" data-animation="fadeInRight" data-delay="0">
                <div class="offer-icon">
                  <span class="icon-lifesaver"></span>
                </div>
                <h4>Tienes Otro Tipo de Transporte</h4>
                <p>Si tienes Otro tipo de Transporte que no sea Alimentos o Ganaderia, Contactanos para Llegar a tu Solución</p>
              </div> <!-- End offer-post -->
            </div> <!-- End col-sm-4 -->

            </div> <!-- End row -->

          </div> <!-- End offer-boxes -->
        </div> <!-- End container -->
      </div> <!-- End landing-offer-section -->
    </section>
    <!-- End offer section -->

    <section>
      <div class="sep-section"></div>
    </section>

    <!-- Banner-Services
    ================================================== -->
    <section>
      <div id="banner-services" data-stellar-background-ratio="0">
        <div class="container">
          <div class="row">

            <div class="col-sm-6">
              <div class="banner-content animated out" data-animation="fadeInUp" data-delay="0">
                <h3 class="banner-heading">Deseas Usar Nuestros Servicios?</h3>
                <div class="banner-decription">
                  Contactanos A traves de los Numeros Telefonicos +58 (0276) 3463524<br>
                  O Traves de Nuestro Correo Electronico transportelagarraca@gmail.com
                </div> <!-- end banner-decription -->
              </div> <!-- end banner-content -->
            </div> <!-- end col-sm-6 -->

            <div class="col-sm-6">
              <div class="banner-image animated out" data-animation="fadeInUp" data-delay="0">
                <img src="vendor/images/temp/banner-img.png" alt="">
              </div> <!-- end banner-image -->
            </div> <!-- end col-sm-6 -->
            
          </div> <!-- end row -->
        </div> <!-- end container -->
      </div>
    </section>
    <!-- End Banner services section -->

    <section>
      <div class="sep-section"></div>
    </section>

    <section>
      <div class="sep-section"></div>
    </section>
    
    <section>
      <div class="sep-section"></div>
    </section>

    <section>
      <div class="sep-section"></div>
    </section>

    <!-- Contact-info
    ================================================== -->
    <section>
      <div class="contact-info">
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
              <a href="#"><i class="pe-7s-map-marker"></i>Madre Juana - San Cristóbal</a>
            </div> <!-- End col-sm-4 -->
            <div class="col-sm-4">
            <a href="tel:+5802763463524"><i class="pe-7s-phone"></i>+58 (0276) 3463524</a>
            </div>
             <div class="col-sm-4">
              <a href="mailto:transportelagarraca@gmail.com"><i class="pe-7s-mail"></i>transportelagarraca@gmail.com</a>
             </div>
          </div> <!-- End row -->
        </div> <!-- End container -->
      </div> <!-- End contact-info -->
    </section>

    <!-- Footer
    ================================================== -->
    <footer>
      <div id="footer-section" class="text-center">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <p class="copyright">
                <strong>Copyright &copy; 2022<b> Transporte la Garra C.A.</strong> RIF: J-40870635-0</b>
                <br>
                <strong>Created By: Islender Montilva - José González - Cesar Colmenares - Pedro Saavedra</strong>
              </p>
            </div> <!-- End col-sm-8 -->
          </div> <!-- End row -->
        </div> <!-- End container -->
      </div> <!-- End footer-section  -->
    </footer>
    <!-- End footer -->

  </div> <!-- End wrapper -->

  <!-- Back-to-top
  ================================================== -->
  <div class="back-to-top">
    <i class="fa fa-angle-up fa-3x"></i>
</div> <!-- end back-to-top -->
    <!-- JS libraries and scripts -->
    <script src="{{ asset('vendor/js/jquery-1.11.3.min.js')}}"></script>
    <script src="{{ asset('vendor/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/js/bootstrap-hover-dropdown.min.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.appear.min.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.bxslider.min.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.owl.carousel.min.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.countTo.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.easing.1.3.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.imagesloaded.min.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.isotope.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.placeholder.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.smoothscroll.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.stellar.min.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.waypoints.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.fitvids.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.countdown.js')}}"></script>
    <script src="{{ asset('vendor/js/jquery.navbar-scroll.js')}}"></script>
    <script src="{{ asset('vendor/js/main.js')}}"></script>
</body>
</html>
