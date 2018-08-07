<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Social meta -->
    <meta charset="UTF-8">
    <meta property="og:locale" content="ar_AR">
    <meta property="og:type" content="website">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:image" content="{{asset('landing_page')}}/img/bg-img/logo_copy.png" />
    <meta name="description" content="{{@$info->desc}}" />
    <meta property="og:title" content="Ratb.li | رتب. لي"/>
    <meta property="og:url" content="https://ratb.li"/>
    <meta property="fb:app_id" content="966242223397117" />
    <meta property="og:site_name" content="Ratb.li | رتب. لي"/>


    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Ratb.li | رتب. لي</title>

    <!-- Favicon -->
    <link rel="icon" href="{{asset('Info')}}/{{@$info->favicon}}">

    <!-- Core Stylesheet -->
    <link href="{{asset('landing_page')}}/style.css" rel="stylesheet">

    <!-- Responsive CSS -->
    <link href="{{asset('landing_page')}}/css/responsive.css" rel="stylesheet">

    <style>
        .countDounTimer{
            font-size: 70px;
            color:white;
        }
        @media(max-width:767px){
            .wellcome_area{
                height: 350px;
            }

            .countDounTimer{
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader">
        <div class="colorlib-load"></div>
    </div>

    <!-- ***** Header Area Start ***** -->
    <header class="header_area animated">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Menu Area Start -->
                <div class="col-12 col-lg-10">
                    <div class="menu_area">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <!-- Logo -->
                            <a class="navbar-brand" href="#">رتب. لي</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ca-navbar" aria-controls="ca-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                            <!-- Menu Area -->
                            <div class="collapse navbar-collapse" id="ca-navbar">
                                <ul class="navbar-nav ml-auto" id="nav">
                                    <li class="nav-item active"><a class="nav-link" href="#home">الرئيسية</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#about">من نحن</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#features">المميزات</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#screenshot">التطبيق</a></li>
                                    <li class="nav-item"></li>
                                    <li class="nav-item"><a class="nav-link" href="#testimonials">التقييمات</a></li>
                                    <li class="nav-item"></li>
                                    <li class="nav-item"><a class="nav-link" href="#contact">تواصل معنا</a></li>
                                </ul>
                                <div class="sing-up-button d-lg-none">
                                    {{-- <a href="#">Sign Up Free</a> --}}
                                    {{-- <a href="{{ url('/register') }}">انضم الآن</a> --}}
                                    <a href="{{ url('/login') }}">تسجيل الدخول</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- Signup btn -->
                <div class="col-12 col-lg-2">
                    <div class="sing-up-button d-none d-lg-block">
                        {{-- <a href="https://ratb.li/login">تسجيل الدخول</a> --}}
                        <a href="{{ url('/login') }}">تسجيل الدخول</a>
                    </div>
                </div>
				
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Wellcome Area Start ***** -->
    <section class="wellcome_area clearfix" id="home">
<div class="container h-100">
            <div class="row h-100 " >
                    <div class="col-12 col-md">
                        <div align="center" class="wellcome-heading" style="margin-top:100px;">
                            {{-- <div class="countDounTimer"> باقي <span id="countDounTimer" class="countDounTimer"></span> للانطلاق </div> --}}

    					    <img src="{{asset('landing_page')}}/img/bg-img/logo.png" alt="" style="width:50%;height:50%;"/>
    					</div>
                </div>
            </div>
        <!-- Welcome thumb -->
        <div class="welcome-thumb wow fadeInDown" data-wow-delay="0.5s"> </div>
    </section>
<!-- ***** Wellcome Area End ***** -->

    <!-- ***** Special Area Start ***** -->
    <section class="special-area bg-white section_padding_100" id="about">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Heading Area -->
                    <div class="section-heading text-center">
                      <h2>عن رتب. لي</h2>
                      <div class="line-shape"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Single Special Area -->
                <div class="col-12 col-md-4">
                    <div class="single-special text-center wow fadeInUp" data-wow-delay="0.2s">
                        <div class="single-icon">
                            <i class="ti-mobile" aria-hidden="true"></i>
                        </div>
                        <h4>ما هي قيمنا</h4>
						  <p>الابتكار والتطور المستمر </p>
						  <p>الدقة والإخلاص</p>
						  <p>خدمة المجتمع</p>
						<br><br><br>
                    </div>
                </div>
                <!-- Single Special Area -->
                <div class="col-12 col-md-4">
                    <div class="single-special text-center wow fadeInUp" data-wow-delay="0.4s">
                        <div class="single-icon">
                            <i class="ti-ruler-pencil" aria-hidden="true"></i>
                        </div>
                        <h4>ما هي رؤيتنا</h4>
                        <p>أن نكون من المبادرين في اتخاذ القرارات الجريئة لمنطقة الخليج، عند تقديم منصه مختصه بربط منسقي الحفلات بالعملاء دون التأثير سلبًا على الجودة العالية أو الفائدة المقدَّمة لعملائنا<br><br>
						</p>
                    </div>
                </div>
                <!-- Single Special Area -->
                <div class="col-12 col-md-4">
                    <div class="single-special text-center wow fadeInUp" data-wow-delay="0.6s">
                        <div class="single-icon">
                            <i class="ti-settings" aria-hidden="true"></i>
                        </div>
                        <h4>من نحن</h4>
                      <p>تطبيق رتب.لي هي احد مشاريع شركة الامر الذكية لتقنية المعلومات وهي منصه مختصه في ربط مزودي الخدمه مع المستهلك لنتمكن من تنسيق حفلتك بكافة التفاصيل المطلوبه بمكان واحد مع خيارات الدفع المتعدده
                      </p>
					</div>
                </div>
            </div>
        </div>
        <!-- Special Description Area -->
        @if($info->play_store || $info->app_store)
            <div class="special_description_area mt-150">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="special_description_img">
                                <img src="{{asset('landing_page')}}/img/bg-img/special.png" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-5 ml-xl-auto">
                            <div class="special_description_content" style="text-align: right;">
                                <h2>الحصول علي التطبيق</h2>
                                <p>رتب. لي منصة تفاعلية احترافية تساعد كافة المستخدمين علي تنظيم مناسباتهم في اسرع وقت بسهولة وبأقل تكلفة من خلال تقديم خيارات متعددة لمزودي خدمات تم اختيارهم بعناية فائقة بما يتناسب مع شروط منصة رتب.لي</p>
                                <div class="app-download-area">
                                    @if($info->play_store)
                                        <div class="app-download-btn wow fadeInUp" data-wow-delay="0.2s">
                                            <!-- Google Store Btn -->
                                            <a href="{{@$info->play_store}}">
                                                <i class="fa fa-android"></i>
                                                <p class="mb-0"><span>available on</span> Google Store</p>
                                            </a>
                                        </div>
                                    @endif
                                    @if($info->app_store)
                                        <div class="app-download-btn wow fadeInDown" data-wow-delay="0.4s">
                                            <!-- Apple Store Btn -->
                                            <a href="{{@$info->app_store}}">
                                                <i class="fa fa-apple"></i>
                                                <p class="mb-0"><span>available on</span> Apple Store</p>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    <!-- ***** Special Area End ***** -->

    <!-- ***** Awesome Features Start ***** -->
    <section class="awesome-feature-area bg-white section_padding_0_50 clearfix" id="features">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Heading Text -->
                    <div class="section-heading text-center">
                        <h2>لماذا رتب.لي</h2>
                        <div class="line-shape"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Single Feature Start -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature">
                        <i class="ti-user" aria-hidden="true"></i>
                        <h5 align="right">طرق الدفع</h5>
                        <p align="right">لك مطلق الحرية مع وجود خيارات متعددة للدفع لكافة خدمات منصة رتب. لي</p>
                    </div>
                </div>
                <!-- Single Feature Start -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature">
                        <i class="ti-pulse" aria-hidden="true"></i>
                        <h5 align="right">لا مجال للخطأ</h5>
                        <p align="right">مع رتب. لي نقوم بعرض التفاصيل المطلوبة الخاصة بمناسبتك قبل اتمام الطلب</p>
                    </div>
                </div>
                <!-- Single Feature Start -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature">
                        <i class="ti-dashboard" aria-hidden="true"></i>
                      <h5 align="right">البحث</h5>
                        <p align="right">يمكنك البحث بسهولة من خلال تطبيق رتب. لي عن كل ما تريده لاقامة مناسبتك</p>
                    </div>
                </div>
                <!-- Single Feature Start -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature">
                        <i class="ti-palette" aria-hidden="true"></i>
                        <h5 align="right">الحجز</h5>
                        <p align="right">إمكانية حجز أكثر من خدمة من جميع الأقسام في وقت واحد سواء كانت مناسبة واحدة او عدة مناسبات مختلفة</p>
                    </div>
                </div>
                <!-- Single Feature Start -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature">
                        <i class="ti-crown" aria-hidden="true"></i>
                        <h5 align="right">شاركنا رأيك</h5>
                        <p align="right">لأن يهمنا رأيك  في خدماتنا وفرنا لك صفحة شاركنا رأيك</p>
                    </div>
                </div>
                <!-- Single Feature Start -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature">
                        <i class="ti-headphone" aria-hidden="true"></i>
                        <h5 align="right">24/7 خدمة العملاء</h5>
                        <p align="right">التواصل مع خدمة العملاء متاح 24 ساعه للإجابة على استفساراتك والمقترحات والشكاوي وتعديل الطلبات</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ***** Awesome Features End ***** -->

    <!-- ***** Video Area Start ***** -->
    <div class="video-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Video Area Start -->
                    <div class="video-area" style="background-image: url({{asset('landing_page')}}/img/bg-img/video.jpg);">
                        <div class="video-play-btn">
                            <a href="{{asset('Info')}}/{{$info->video}}" class="video_btn"><i class="fa fa-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Video Area End ***** -->

    <!-- ***** Cool Facts Area Start ***** -->
    <section class="cool_facts_area clearfix">
        <div class="container">
            <!-- <div class="row">
                Single Cool Fact
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="single-cool-fact d-flex justify-content-center wow fadeInUp" data-wow-delay="0.2s">
                        <div class="counter-area">
                            <h3><span class="counter">{{@$statistics['download_apps']}}</span></h3>
                        </div>
                        <div class="cool-facts-content">
                            <i class="ion-arrow-down-a"></i>
                            <p>تحميل <br> للتطبيق</p>
                        </div>
                    </div>
                </div>
                Single Cool Fact
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="single-cool-fact d-flex justify-content-center wow fadeInUp" data-wow-delay="0.4s">
                        <div class="counter-area">
                            <h3><span class="counter">{{@$statistics['orders']}}</span></h3>
                        </div>
                        <div class="cool-facts-content">
                            <i class="ion-happy-outline"></i>
                            <p>طلب <br> مكتمل</p>
                        </div>
                    </div>
                </div>
                Single Cool Fact
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="single-cool-fact d-flex justify-content-center wow fadeInUp" data-wow-delay="0.6s">
                        <div class="counter-area">
                            <h3><span class="counter">{{@$statistics['vendors']}}</span></h3>
                        </div>
                        <div class="cool-facts-content">
                            <i class="ion-person"></i>
                            <p>مزود <br>خدمة</p>
                        </div>
                    </div>
                </div>
                Single Cool Fact
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="single-cool-fact d-flex justify-content-center wow fadeInUp" data-wow-delay="0.8s">
                        <div class="counter-area">
                            <h3><span class="counter">{{@$statistics['rate']}}</span></h3>
                        </div>
                        <div class="cool-facts-content">
                            <i class="ion-ios-star-outline"></i>
                            <p>اجمالي <br>التقييمات</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
    <!-- ***** Cool Facts Area End ***** -->

    <!-- ***** App Screenshots Area Start ***** -->
    <section class="app-screenshots-area bg-white section_padding_0_100 clearfix" id="screenshot">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <!-- Heading Text  -->
                    <div class="section-heading">
                        <h2>إلقي نظرة علي التطبيق</h2>
                        <div class="line-shape"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- App Screenshots Slides  -->
                    <div class="app_screenshots_slides owl-carousel">
                        <div class="single-shot">
                            <img src="{{asset('landing_page')}}/img/scr-img/app-1.jpg" alt="">
                        </div>
                        <div class="single-shot">
                            <img src="{{asset('landing_page')}}/img/scr-img/app-2.jpg" alt="">
                        </div>
                        <div class="single-shot">
                            <img src="{{asset('landing_page')}}/img/scr-img/app-3.jpg" alt="">
                        </div>
                        <div class="single-shot">
                            <img src="{{asset('landing_page')}}/img/scr-img/app-4.jpg" alt="">
                        </div>
                        <div class="single-shot">
                            <img src="{{asset('landing_page')}}/img/scr-img/app-5.jpg" alt="">
                        </div>
                        <div class="single-shot">
                            <img src="{{asset('landing_page')}}/img/scr-img/app-3.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** App Screenshots Area End *****====== -->

    <!-- ***** Pricing Plane Area Start *****==== -->    <!-- ***** Pricing Plane Area End ***** -->

    <!-- ***** Client Feedback Area Start ***** -->
    <!-- ***** Client Feedback Area End ***** -->

    <!-- ***** CTA Area Start ***** -->
    <section class="our-monthly-membership section_padding_50 clearfix">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="membership-description">
                      <h2>انضم إلي شركاء رتب. لي</h2>
                      <p>التسجيل كصاحب منتج او خدمة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="get-started-button wow bounceInDown" data-wow-delay="0.5s">
                        {{-- <a href="https://ratb.li/register">انضم الآن</a> --}}
                        <a href="{{ url('/register') }}">انضم الآن</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** CTA Area End ***** -->

    <!-- ***** Our Team Area Start ***** -->    <!-- ***** Our Team Area End ***** -->

    <!-- ***** Contact Us Area Start ***** -->
    <section class="footer-contact-area section_padding_100 clearfix" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- Heading Text  -->
                    <div class="section-heading">
                      <h2>تواصل معنا</h2>
                      <div class="line-shape"></div>
                    </div>
                    <div class="footer-text"> </div>
                    <div class="address-text">
                      <p><span>Address:</span> {{@$info->address}} </p>
                    </div>
                    <div class="phone-text">
                      <p><span>Phone:</span> {{@$info->phone}}</p>
                    </div>
                    <div class="email-text">
                        <p><span>Email:</span> {{@$info->email}}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Form Start-->
                    <div class="contact_from">
                        <form action="{{ url('/contacting') }}" role="form" method="post" enctype="application/x-www-form-urlencoded">

                            <!-- Message Input Area Start -->
                            {{ csrf_field() }}
                            <div class="contact_input_area">
                                <div class="row">
                                    <!-- Single Input Area Start -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name *" required>
                                        </div>
                                    </div>
                                    <!-- Single Input Area Start -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Your E-mail *" required>
                                        </div>
                                    </div>
                                    <!-- Single Input Area Start -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Your Message *" required></textarea>
                                        </div>
                                    </div>
                                    <!-- Single Input Area Start -->
                                    <div class="col-12">
                                        <button type="submit" class="btn submit-btn">Send Now</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Message Input Area End -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Contact Us Area End ***** -->

    <!-- ***** Footer Area Start ***** -->
    <footer class="footer-social-icon text-center section_padding_70 clearfix">
        <!-- footer logo -->
        <div class="footer-text">
          <h2>Ratb.li</h2>
        </div>
        <!-- social icon-->
        <div class="footer-social-icon">
            @if($info->facebook)
                <a href="{{@$info->facebook}}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            @endif
            @if($info->twitter)
                <a href="{{@$info->twitter}}"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            @endif
            @if($info->instagram)
                <a href="{{@$info->instagram}}"> <i class="fa fa-instagram" aria-hidden="true"></i></a>
            @endif
            @if($info->google)
                <a href="{{@$info->google}}"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
            @endif
        </div>
        <div class="footer-menu">
            <nav>
                <ul>
                    <li><a class="nav-link" href="#about">About</a></li>
                    <li><a target="_blank" href="https://ratb.li/policy">Terms &amp; Conditions</a></li>
                    <li><a target="_blank" href="https://ratb.li/policy">Policy</a></li>
                    <li><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
        <!-- Foooter Text-->
        <div class="copyright-text">
            <!-- ***** Removing this text is now allowed! This template is licensed under CC BY 3.0 ***** -->
            <p>Copyright ©2017-2018 iTSmart, LLC. Designed with ❤ <a href="https://colorlib.com" target="_blank">in </a><a href="https://itsmart.com.sa">Riyadh</a></p>
        </div>
    </footer>
    <!-- ***** Footer Area Start ***** -->

    <!-- Jquery-2.2.4 JS -->
    <script src="{{asset('landing_page')}}/js/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="{{asset('landing_page')}}/js/popper.min.js"></script>
    <!-- Bootstrap-4 Beta JS -->
    <script src="{{asset('landing_page')}}/js/bootstrap.min.js"></script>
    <!-- All Plugins JS -->
    <script src="{{asset('landing_page')}}/js/plugins.js"></script>
    <!-- Slick Slider Js-->
    <script src="{{asset('landing_page')}}/js/slick.min.js"></script>
    <!-- Footer Reveal JS -->
    <script src="{{asset('landing_page')}}/js/footer-reveal.min.js"></script>
    <!-- Active JS -->
    <script src="{{asset('landing_page')}}/js/active.js"></script>

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("Apr 23, 2018 09:00:00").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("countDounTimer").innerHTML =  hours + ":" + minutes + ":" + seconds;

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countDounTimer").innerHTML = "";
            }
        }, 1000);

    </script>
</body>

</html>
