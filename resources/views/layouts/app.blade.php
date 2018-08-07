<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coder79">

        {{-- <link rel="shortcut icon" href="{{asset('')}}web/images/favicon.ico"> --}}
        <link rel="icon" href="{{asset('Info')}}/{{ Session::get('favicon')}}">

        <title>Party</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <!-- Bootstrap core CSS -->
        <link href="{{asset('')}}web/css/bootstrap.min.css" rel="stylesheet">

        <!-- Owl Carousel CSS -->
        <link href="{{asset('')}}web/css/owl.carousel.css" rel="stylesheet">
        <link href="{{asset('')}}web/css/owl.theme.default.min.css" rel="stylesheet">

        <!-- Icon CSS -->
        <link href="{{asset('')}}web/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{asset('')}}web/css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="{{asset('')}}web/js/html5shiv.js"></script>
          <script src="{{asset('')}}web/js/respond.min.js"></script>
        <![endif]-->

    </head>


    <body data-spy="scroll" data-target="#navbar-menu">

        <!-- Navbar -->
        <div class="navbar navbar-custom sticky navbar-fixed-top" role="navigation" id="sticky-nav">
            <div class="container">

                <!-- Navbar-header -->
                <div class="navbar-header">

                    <!-- Responsive menu button -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- LOGO -->
                    <a class="navbar-brand logo" href="{{URL('/')}}">
                        <img src="{{asset('')}}web/images/Logo_Website_256.png" alt="logo" height="24">
                    </a>

                </div>
                <!-- end navbar-header -->

                <!-- menu -->
                <div class="navbar-collapse collapse" id="navbar-menu">

                    <!-- Navbar right -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active">
                            <a href="#home" class="nav-link">Home</a>
                        </li>
                        <li>
                            <a href="#features" class="nav-link">Features</a>
                        </li>
                        <li>
                            <a href="#pricing" class="nav-link">Plans</a>
                        </li>
                        <li>
                            <a href="#team" class="nav-link">Team</a>
                        </li>
                        @if (Auth::guest())
                            <li>
                                <a href="{{ url('/login') }}" class="btn btn-white-bordered navbar-btn">Login</a>
                            </li>
                        @else
                            <img width="50px" height="50px" src="{{ Auth::user()->pic }}"/>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                @if (Auth::user()->is_admin == 1 )
                                <li>
                                    <a href="{{URL('/dashboard')}}" class="nav-link">Dashboard</a>
                                </li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>

                            @elseif(Auth::user()->is_vendor == 1)
                                <li>
                                    <a href="{{URL('vendor')}}" class="nav-link">Dashboard</a>
                                </li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            @else
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                </ul>
                            @endif
                            </li>
                        @endif
                    </ul>

                </div>
                <!--/Menu -->
            </div>
            <!-- end container -->
        </div>
        <!-- End navbar-custom -->



@yield('content')

        <!-- FOOTER -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <a class="navbar-brand logo" href="{{URL('/')}}">
                            Par<span class="text-custom">ty</span>
                        </a>
                        <span class="copy-txt">&copy; 2017</span>
                    </div>
                    <div class="col-lg-4 col-lg-offset-3 col-md-7">
                        <ul class="nav navbar-nav">
                            <li><a href="#">How it works</a></li>
                            <li><a href="#">Features</a></li>
                            <li><a href="#">Pricing</a></li>
                            <li><a href="#">Team</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </footer>
        <!-- End Footer -->
        

        <!-- Back to top -->    
        <a href="#" class="back-to-top" id="back-to-top"> <i class="fa fa-angle-up"></i> </a>


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="{{asset('')}}web/js/jquery-2.1.4.min.js"></script>
        <script src="{{asset('')}}web/js/bootstrap.min.js"></script>

        <!-- Jquery easing -->                                                      
        <script type="text/javascript" src="{{asset('')}}web/js/jquery.easing.1.3.min.js"></script>

        <!-- Owl Carousel -->                                                      
        <script type="text/javascript" src="{{asset('')}}web/js/owl.carousel.min.js"></script>

        <!--sticky header-->
        <script type="text/javascript" src="{{asset('')}}web/js/jquery.sticky.js"></script>

        <!--common script for all pages-->
        <script src="{{asset('')}}web/js/jquery.app.js"></script>

        <script type="text/javascript">
            $('.owl-carousel').owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                autoplay: true,
                autoplayTimeout: 4000,
                responsive:{
                    0:{
                        items:1
                    }
                }
            })
        </script>

    </body>
</html>