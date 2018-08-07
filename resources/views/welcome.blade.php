@extends('layouts.app')
@section('title')
Party
@endsection
@section('content')
    <!-- HOME -->
    <section class="home bg-img-1" id="home">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home-fullscreen">
                        <div class="full-screen">
                            <div class="home-wrapper home-wrapper-alt">
                                <h1 class="text-white">Party is backend app with Dashboard multi Permission</h1>
                                <h4 class="text-white"></h4>

                                <p class="text-white">you can get post man json import to test Response</p>
                                <p class="text-white">you must replace party_test for that url "https://partypro.000webhostapp.com/public/api"</p>

                                <ul class="list-inline">
                                    <li><a href="" title="Microsoft"><img src="{{asset('')}}web/images/clients/microsoft_white.png" alt="clients"></a></li>
                                    <li><a href="" title="Google"><img src="{{asset('')}}web/images/clients/google_white.png" alt="clients"></a></li>
                                </ul>

                                <a href="https://documenter.getpostman.com/view/2836787/party-test/6tjSf6H" target="_blank" class="btn btn-custom m-t-20">Run On Post Man</a>
                                <a href="https://github.com/yahongie2014/Party-Backend" target="_blank" class="btn btn-custom m-t-20">Github Profile Source Code</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END HOME -->


    <!-- Features -->
    <section class="section" id="features">
        <div class="container">

            <div class="row">
                <div class="col-sm-12 text-center">
                    <p class="text-muted text-uppercase"><b>Contrary to popular</b></p>
                    <h3 class="title">It's designed for describing your app, agency or business</h3>
                    <p class="text-muted sub-title">The clean and well commented code allows easy customization of the theme.It's <br/> designed for describing your app, agency or business.</p>
                </div>
            </div> <!-- end row -->

            <div class="row">
                <div class="col-sm-4">
                    <div class="features-box">
                        <i class="fa fa-ioxhost"></i>
                        <h4>Responsive Layouts</h4>
                        <p class="text-muted m-b-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="features-box">
                        <i class="fa fa-cubes"></i>
                        <h4>Bootstrap UI based</h4>
                        <p class="text-muted m-b-0">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin litera..</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="features-box">
                        <i class="fa fa-umbrella"></i>
                        <h4>Creative Design</h4>
                        <p class="text-muted m-b-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                    </div>
                </div>

            </div> <!-- end row -->


            <div class="row">
                <div class="col-sm-4">
                    <div class="features-box">
                        <i class="fa fa-shirtsinbulk"></i>
                        <h4>Strategy Solutions</h4>
                        <p class="text-muted m-b-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="features-box">
                        <i class="fa fa-free-code-camp"></i>
                        <h4>Digital Design</h4>
                        <p class="text-muted m-b-0">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin litera..</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="features-box">
                        <i class="fa fa-language"></i>
                        <h4>Analystics Solutions</h4>
                        <p class="text-muted m-b-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                    </div>
                </div>

            </div> <!-- end row -->

        </div> <!-- end container -->
    </section>
    <!-- end Features -->



    <!-- Features Alt -->
    <section class="section bg-gray">
        <div class="container">

            <div class="row">
                <div class="col-sm-6">
                    <img src="{{asset('')}}web/images/macbook.png" alt="img" class="img-responsive">
                </div>

                <div class="col-sm-5 col-sm-offset-1">
                    <div class="feat-description">
                        <h4>Praesent et viverra massa non varius magna eget nibh vitae velit posuere efficitur.</h4>
                        <p class="text-muted"><i>The clean and well commented code allows easy customization of the theme.It's designed for describing your app, agency or business.</i></p>

                        <p class="text-muted">We put a lot of effort in design, as it’s the most important ingredient of successful website.Sed ut perspiciatis unde omnis iste natus error sit.We put a lot of effort in design.</p>

                        <a href="" class="btn btn-custom">Learn More</a>
                    </div>
                </div>

            </div><!-- end row -->

        </div> <!-- end container -->
    </section>
    <!-- end features alt -->



    <!-- Testimonials section -->
    <section class="section bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <div class="owl-carousel text-center">
                        <div class="item">
                            <div class="testimonial-box">
                                <h4>Excellent support for a tricky issue related to our customization of the template. Author kept us updated as he made progress on the issue and emailed us a patch when he was done.</h4>
                                <img src="{{asset('')}}web/images/team/team-1.jpg" class="testi-user img-circle" alt="testimonials-user">
                                <p>- Ubold User</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-box">
                                <h4>Flexible, Everything is in, Suuuuuper light, even for the code is much easier to cut and make it a theme for a productive app..</h4>
                                <img src="{{asset('')}}web/images/team/team-2.jpg" class="testi-user img-circle" alt="testimonials-user">
                                <p>- Ubold User</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimonial-box">
                                <h4>Not only the code, design and support are awesome, but they also update it constantly the template with new content, new plugins. I will buy surely another coderthemes template!</h4>
                                <img src="{{asset('')}}web/images/team/team-3.jpg" class="testi-user img-circle" alt="testimonials-user">
                                <p>- Ubold User</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-sm-12">
                    <ul class="list-inline client-list">
                        <li><a href="" title="Microsoft"><img src="{{asset('')}}web/images/clients/microsoft.png" alt="clients"></a></li>
                        <li><a href="" title="Google"><img src="{{asset('')}}web/images/clients/google.png" alt="clients"></a></li>
                        <li><a href="" title="Instagram"><img src="{{asset('')}}web/images/clients/instagram.png" alt="clients"></a></li>
                        <li><a href="" title="Converse"><img src="{{asset('')}}web/images/clients/converse.png" alt="clients"></a></li>
                    </ul>
                </div> <!-- end Col -->

            </div><!-- end row -->

        </div>
    </section>

    <!-- End Testimonials section -->


    <!-- PRICING -->
    <section class="section" id="pricing">
        <div class="container">

            <div class="row">
                <div class="col-sm-12 text-center">
                    <h3 class="title">Pricing</h3>
                    <p class="text-muted sub-title">The clean and well commented code allows easy customization of the theme.It's <br> designed for describing your app, agency or business.</p>
                </div>
            </div> <!-- end row -->


            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="row">

                        <!--Pricing Column-->
                        <article class="pricing-column col-lg-4 col-md-4">
                            <div class="inner-box">
                                <div class="plan-header text-center">
                                    <h3 class="plan-title">Ragular</h3>
                                    <h2 class="plan-price">$24</h2>
                                    <div class="plan-duration">Per License</div>
                                </div>
                                <ul class="plan-stats list-unstyled">
                                    <li> <i class="fa fa-check-square-o"></i>Number of end products <b>1</b></li>
                                    <li> <i class="fa fa-check-square-o"></i>Customer support</li>
                                    <li> <i class="fa fa-check-square-o"></i>Free Updates</li>
                                    <li> <i class="fa fa-check-square-o"></i>No Domain</li>
                                    <li> <i class="fa fa-check-square-o"></i>24x7 Support</li>
                                </ul>

                                <div class="text-center">
                                    <a href="#" class="btn btn-sm btn-custom">Purchase Now</a>
                                </div>
                            </div>
                        </article>


                        <!--Pricing Column-->
                        <article class="pricing-column col-lg-4 col-md-4">
                            <div class="inner-box active">
                                <div class="plan-header text-center">
                                    <h3 class="plan-title">Multiple</h3>
                                    <h2 class="plan-price">$120</h2>
                                    <div class="plan-duration">Per License</div>
                                </div>
                                <ul class="plan-stats list-unstyled">
                                    <li> <i class="fa fa-check-square-o"></i>Number of end products <b>1</b></li>
                                    <li> <i class="fa fa-check-square-o"></i>Customer support</li>
                                    <li> <i class="fa fa-check-square-o"></i>Free Updates</li>
                                    <li> <i class="fa fa-check-square-o"></i>5 Domains</li>
                                    <li> <i class="fa fa-check-square-o"></i>24x7 Support</li>
                                </ul>

                                <div class="text-center">
                                    <a href="#" class="btn btn-sm btn-custom">Purchase Now</a>
                                </div>
                            </div>
                        </article>


                        <!--Pricing Column-->
                        <article class="pricing-column col-lg-4 col-md-4">
                            <div class="inner-box">
                                <div class="plan-header text-center">
                                    <h3 class="plan-title">Extended</h3>
                                    <h2 class="plan-price">$999</h2>
                                    <div class="plan-duration">Per License</div>
                                </div>
                                <ul class="plan-stats list-unstyled">
                                    <li> <i class="fa fa-check-square-o"></i>Number of end products <b>1</b></li>
                                    <li> <i class="fa fa-check-square-o"></i>Customer support</li>
                                    <li> <i class="fa fa-check-square-o"></i>Free Updates</li>
                                    <li> <i class="fa fa-check-square-o"></i>Unlimited Domains</li>
                                    <li> <i class="fa fa-check-square-o"></i>24x7 Support</li>
                                </ul>

                                <div class="text-center">
                                    <a href="#" class="btn btn-sm btn-custom">Purchase Now</a>
                                </div>
                            </div>
                        </article>

                    </div>
                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- end container -->
    </section>
    <!-- End Pricing -->


    <!-- Get Started -->
    <section class="section bg-custom">
        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <div class="get-started text-center">
                        <h2><b>Get Started for FREE</b></h2>
                        <h4>The clean and well commented code allows easy customization of the theme.It's designed for describing your app, agency or business.</h4>

                        <a href="" class="btn btn-white-bordered">Join for FREE</a>
                    </div>
                </div>

            </div><!-- end row -->

        </div> <!-- end container -->
    </section>
    <!-- end Get Started -->


    <!-- Clients -->
    <section class="section" id="team">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h3 class="title">Behind People</h3>
                    <p class="text-muted sub-title">The clean and well commented code allows easy customization of the theme.It's <br/> designed for describing your app, agency or business.</p>
                </div>
            </div>
            <!-- end row -->


            <div class="row team text-center">
                <!-- team-member -->
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="{{asset('')}}web/images/team/team-1.jpg" alt="team-member" class="img-responsive">
                        <h4>Holden McGroin</h4>
                        <p class="text-muted">Product Designer & Founder</p>
                    </div>
                </div>

                <!-- team-member -->
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="{{asset('')}}web/images/team/team-2.jpg" alt="team-member" class="img-responsive">
                        <h4>Mike Oxbigg</h4>
                        <p class="text-muted">Developer & Co-founder</p>
                    </div>
                </div>
                <!-- team-member -->
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="{{asset('')}}web/images/team/team-3.jpg" alt="team-member" class="img-responsive">
                        <h4>Eilean Dover</h4>
                        <p class="text-muted">UI/UX Designer</p>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!--End  Clients -->
@endsection
