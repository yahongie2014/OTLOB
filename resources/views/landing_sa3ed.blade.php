<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="coder79">
	<meta property="og:image" content="{{asset('landing_page')}}/img/bg-img/logo_copy.png" />
	<meta name="description" content="{{@$info->desc}}" />
	<meta property="og:title" content="Ratb.li | رتب. لي"/>
	<meta property="og:author" content="Ratb.li | رتب. لي"/>
	<meta property="og:url" content="https://ratb.li"/>
	<meta property="fb:app_id" content="966242223397117" />
	<meta property="og:site_name" content="Ratb.li | رتب. لي"/>
	<meta name="keywords" content="beautiful,creative, unique, layout, features, cross, browser, compatible">
	<!-- Page Title -->
	<title>Ratb.li | رتب. لي</title>
	<!-- Google Fonts css-->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	<!-- Bootstrap css -->
	<link href="{{asset('landing_sa3ed')}}/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Font Awesome icon css-->
	<link href="{{asset('landing_sa3ed')}}/css/font-awesome.min.css" rel="stylesheet" media="screen">
	<link href="{{asset('landing_sa3ed')}}/css/flaticon.css" rel="stylesheet" media="screen">
	<!-- Swiper's CSS -->
	<link rel="stylesheet" href="{{asset('landing_sa3ed')}}/css/swiper.min.css">
	<!-- Slick nav css -->
	<link rel="stylesheet" href="{{asset('landing_sa3ed')}}/css/slicknav.css">
	<!-- Animated css -->
	<link href="{{asset('landing_sa3ed')}}/css/animate.css" rel="stylesheet">
	<!-- Magnific Popup CSS -->
	<link href="{{asset('landing_sa3ed')}}/css/magnific-popup.css" rel="stylesheet">
	<!-- Main custom css -->
	<link href="{{asset('landing_sa3ed')}}/css/custom.css" rel="stylesheet" media="screen">
    <style>
        @font-face {
            font-family: 'Conv_JF_FLAT_REGULAR';
            src: url('{{asset("landing_sa3ed")}}/fonts/29ltbukraregular.ttf');
            src: local('☺'), url('{{asset("landing_sa3ed")}}/fonts/29ltbukrabold.ttf') format('woff'), url('{{asset("landing_sa3ed")}}/fonts/29ltbukralight.ttf') format('truetype'), url('{{asset("landing_sa3ed")}}/fonts/JF_FLAT_REGULAR.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        .page-header.navbar .page-logo .logo-default {
            margin: 16px 0 0;
            width: 103px;
        }
        body,
        a,
        h4 {
            font-family: 'Conv_JF_FLAT_REGULAR';
			direction: rtl;
        }
    </style>

</head>
<body data-spy="scroll" data-target="#navigation" data-offset="71">
	
	<!-- Preloader starts -->
	<div class="preloader">
		<div class="sk-wave">
			<div class="sk-rect sk-rect1"></div>
			<div class="sk-rect sk-rect2"></div>
			<div class="sk-rect sk-rect3"></div>
			<div class="sk-rect sk-rect4"></div>
			<div class="sk-rect sk-rect5"></div>
		</div>
	</div>
	<!-- Preloader Ends -->

	<!-- Header Section Starts-->
	<header>
		<nav id="main-nav" class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<!-- Logo starts -->
					<a class="navbar-brand" href="https://ratb.li/">
						<img src="{{asset('landing_sa3ed')}}/images/logo.png" alt="Logo" />
					</a>
					<!-- Logo Ends -->
					
					<!-- Responsive Menu button starts -->
					<div class="navbar-toggle">
					</div>
					<!-- Responsive Menu button Ends -->
				</div>
				<div id="responsive-menu"></div>
				<!-- Navigation starts -->
				<div class="navbar-collapse collapse" id="navigation">
					<ul class="nav navbar-nav navbar-right main-navigation">
						<li><a href="https://ratb.li/login">تسجيل الدخول</a></li>
						<li><a href="#contact">تواصل معنا</a></li>
						<li><a href="#features">مميزات تطبيق رتب.لى</a></li>
						<li><a href="#hotitworks">عن رتب.لي</a></li>
						<li><a href="#overview">رؤيه عامة</a></li>
						<li class="active"><a href="#home">رئيسية</a></li>

					</ul>
				</div>

				<div class="hello" style="display: none">
					<ul class="hello" id="main-menu">
						<li class="active"><a href="#home">رئيسية</a></li>
						<li><a href="#overview">رؤيه عامة</a></li>
						<li><a href="#hotitworks">عن رتب.لي</a></li>
						<li><a href="#features">مميزات تطبيق رتب.لى</a></li>
						<li><a href="#contact">تواصل معنا</a></li>
						<li><a href="https://ratb.li/login">تسجيل الدخول</a></li>
					</ul>
				</div>

				<!-- Navigation Ends -->
			</div>
		</nav>
	</header>
	<!-- Header Section Ends-->
	
	<!-- Banner Section Starts -->
	<section class="banner" id="home">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<!-- Header image start -->
					<div class="banner-image wow fadeInLeft">
						<img src="{{asset('landing_sa3ed')}}/images/special.png" alt="" />
					</div>
					<!-- Header image end -->
				</div>
				
				<div class="col-md-6 col-sm-6">
					<div class="download-app-top">
						@if($info->app_store)

							<a href="{{@$info->app_store}}" ><img width="200" height="60" src="{{asset('landing_sa3ed')}}/images/ios.png"/> </a>
						@endif
&nbsp&nbsp

						@if($info->play_store)

							<a href="{{@$info->play_store}}" ><img width="200" height="60" src="{{asset('landing_sa3ed')}}/images/android.png"/> </a>
						@endif

					</div>

					<!-- Header Content start -->
					<div style="direction: rtl" class="header-content wow fadeInUp">
						<h4>الحصول على التطبيق</h4>
						<h2>رتب. لي</h2>
						<p>رتب. لي منصة تفاعلية احترافية تساعد كافة المستخدمين علي تنظيم مناسباتهم في اسرع وقت بسهولة وبأقل تكلفة من خلال تقديم خيارات متعددة لمزودي خدمات تم اختيارهم بعناية فائقة بما يتناسب مع شروط منصة رتب.لي</p>
					</div>
					<div class="download-app-button">
						<a href="https://ratb.li/register" >
							<button class="btn-contact disabled">سجل كمزود خدمه</button></a>
						<a href="https://ratb.li/login" >
							<button class="btn-contact disabled">تسجيل الدخول</button></a>

					</div>
					<!-- Header Content end -->
				</div>
			</div>
		</div>	
	</section>
	<!-- Banner Section Ends -->
	<section class="cool_facts_area clearfix">
		<div class="container">
		<!-- <div class="row">
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

	<!-- Services section ends -->
	
	<!-- Intro Video section starts -->
	<section class="intro-video" id="overview">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<!-- Intro video content start -->
					<div  class="video-entry wow fadeInUp">
						<div class="section" style="direction: rtl">
							<h2>اكتشف رتب.لي</h2>
						</div>
						<p>رتب. لي منصة تفاعلية احترافية تساعد كافة المستخدمين علي تنظيم مناسباتهم في اسرع وقت بسهولة وبأقل تكلفة من خلال تقديم خيارات متعددة لمزودي خدمات تم اختيارهم بعناية فائقة بما يتناسب مع شروط منصة رتب.لي</p>
					</div>
					<!-- Intro video content end -->
				</div>
				
				<div class="col-md-7 text-center">
					<!-- Intro video play button start -->
					<div class="video-image wow fadeInRight">
						<a href="{{asset('Info')}}/{{$info->video}}" class="btn-play popup-video"><i class="flaticon-play-button"></i></a>
						<img src="{{asset('landing_sa3ed')}}/images/video.png" alt="">
					</div>
					<!-- Intro video play button end -->
				</div>
			</div>
		</div>
	</section>
	<!-- Intro Video section ends -->
	
	<!-- Overview section starts -->
	<!-- Overview section ends -->
	
	<!-- How it works section starts -->
	<section class="how-it-works" id="hotitworks">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title wow fadeInUp">
						<h2>عن رتب. لي</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
                <div class="col-md-4 col-sm-4">
                    <!-- How it work single start -->
                    <div class="how-it-work-single howitwork-pink wow fadeInUp" data-wow-delay="0.6s">
                        <div class="icon-box">
                            <i class="flaticon-eye-tracking"></i>
                        </div>

                        <h3> قيمنا</h3>
                        <p>الابتكار والتطور المستمر
                            <br>
                            الدقة والإخلاص
                            <br>
                            خدمة المجتمع</p>
                    </div>
                    <!-- How it work single end -->
                </div>

                <div class="col-md-4 col-sm-4">
                    <!-- How it work single start -->
                    <div class="how-it-work-single howitwork-yellow wow fadeInUp" data-wow-delay="0.4s">
                        <div class="icon-box">
                            <i class="flaticon-connection"></i>
                        </div>

                        <h3> رؤيتنا</h3>
                        <p>أن نكون من المبادرين في اتخاذ القرارات الجريئة لمنطقة الخليج، عند تقديم منصه مختصه بربط منسقي الحفلات بالعملاء دون التأثير سلبًا على الجودة العالية أو الفائدة المقدَّمة لعملائنا</p>
                    </div>
                    <!-- How it work single end -->
                </div>

                <div class="col-md-4 col-sm-4">
					<!-- How it work single start -->
					<div class="how-it-work-single howitwork-skyblue wow fadeInUp" data-wow-delay="0.2s">
						<div class="icon-box">
							<i class="flaticon-login"></i>
						</div>
						
						<h3>من نحن</h3>
						<p>تطبيق رتب.لي هي احد مشاريع شركة الامر الذكية لتقنية المعلومات وهي منصه مختصه في ربط مزودي الخدمه مع المستهلك لنتمكن من تنسيق حفلتك بكافة التفاصيل المطلوبه بمكان واحد مع خيارات الدفع المتعدده </p>
					</div>
					<!-- How it work single end -->
				</div>

			</div>
		</div>
	</section>
	<!-- How it works section ends -->
	
	<!-- Awesome features section starts -->
	<section class="awesome-features" id="features">
		<div class="container">
			<div class="row">	
				<div class="col-md-12">
					<div class="section wow fadeInUp">
						<h2>المميزات</h2>
						<p>مميزات تطبيق رتب.لى</p>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<!-- Feature single start -->
						<div class="col-md-6 col-sm-6">
							<div class="feature-single feature-pink wow fadeInUp" data-wow-delay="0.2s">
								<h4>01</h4>
								<h3>البحث</h3>
								<p>يمكنك البحث بسهولة من خلال تطبيق رتب. لي عن كل ما تريده لاقامة مناسبتك</p>
							</div>
						</div>
						<!-- Feature single start -->
						
						<!-- Feature single start -->
						<div class="col-md-6 col-sm-6">
							<div class="feature-single feature-yellow wow fadeInUp" data-wow-delay="0.4s">
								<h4>02</h4>
								<h3>لا مجال للخطأ</h3>
								<p>مع رتب. لي نقوم بعرض التفاصيل المطلوبة الخاصة بمناسبتك قبل اتمام الطلب</p>
							</div>
						</div>
						<!-- Feature single end -->
						
						<!-- Feature single start -->
						<div class="col-md-6 col-sm-6">
							<div class="feature-single feature-skyblue wow fadeInUp" data-wow-delay="0.6s">
								<h4>03</h4>
								<h3>24/7 خدمة العملاء</h3>
								<p>التواصل مع خدمة العملاء متاح 24 ساعه للإجابة على استفساراتك والمقترحات والشكاوي وتعديل الطلبات</p>
							</div>
						</div>
						<!-- Feature single end -->
						
						<!-- Feature single start -->
						<div class="col-md-6 col-sm-6">
							<div class="feature-single feature-blue wow fadeInUp" data-wow-delay="0.8s">
								<h4>04</h4>
								<h3>طرق الدفع</h3>
								<p>لك مطلق الحرية مع وجود خيارات متعددة للدفع لكافة خدمات منصة رتب. لي</p>
							</div>
						</div>
						<!-- Feature single end -->
					</div>
				</div>
				
				<div class="col-md-6">
					<!-- Awesome Feature Image start -->
					<div class="awesome-features-image wow fadeInRight" data-wow-delay="0.4s">
						<img src="{{asset('landing_sa3ed')}}/images/overview-1.png" alt="" />
					</div>
					<!-- Awesome Feature Image end -->
				</div>
			</div>
		</div>
	</section>
	<!-- Screenshot section starts -->
	<section class="screenshots">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title wow fadeInUp">
						<h2>إلقي نظرة علي التطبيق</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="swiper-container screenshot-slider">
						<div class="swiper-wrapper">
							<!-- Screenshot slide start -->
							<div class="swiper-slide">
								<div class="screenshot-slide">
									<img src="{{asset('landing_sa3ed')}}/images/app-1.jpg" alt="" />
								</div>
							</div>
							<!-- Screenshot slide end -->
							
							<!-- Screenshot slide start -->
							<div class="swiper-slide">
								<div class="screenshot-slide">
									<img src="{{asset('landing_sa3ed')}}/images/app-2.jpg" alt="" />
								</div>
							</div>
							<!-- Screenshot slide end -->
							
							<!-- Screenshot slide start -->
							<div class="swiper-slide">
								<div class="screenshot-slide">
									<img src="{{asset('landing_sa3ed')}}/images/app-3.jpg" alt="" />
								</div>
							</div>
							<!-- Screenshot slide end -->
							
							<!-- Screenshot slide start -->
							<div class="swiper-slide">
								<div class="screenshot-slide">
									<img src="{{asset('landing_sa3ed')}}/images/app-4.jpg" alt="" />
								</div>
							</div>

							<div class="swiper-slide">
								<div class="screenshot-slide">
									<img src="{{asset('landing_sa3ed')}}/images/app-5.jpg" alt="" />
								</div>
							</div>

							<!-- Screenshot slide end -->
						</div>					
					</div>
					
					<!-- Screenshot Pagination button start -->
					<div class="screenshot-pagination">
						<div class="screenshot-next"><i class="fa fa-arrow-right"></i></div>
						<div class="screenshot-prev"><i class="fa fa-arrow-left"></i></div>
					</div>
					<!-- Screenshot Pagination button end -->
				</div>
			</div>
		</div>
	</section>
	<!-- Screenshot section ends -->

	<!-- Download App Section starts -->
	<section class="download-app">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title wow fadeInUp">
						<h2>حمل التطبيق الان</h2>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="download-app-button">
						@if($info->app_store)

							<a href="{{@$info->app_store}}" ><img width="200" height="60" src="{{asset('landing_sa3ed')}}/images/ios.png"/> </a>
						@endif

						@if($info->play_store)

							<a href="{{@$info->play_store}}" ><img width="200" height="60" src="{{asset('landing_sa3ed')}}/images/android.png"/> </a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Download App Section ends -->
	
	<!-- Contact us section starts -->
	<section class="contact-us" id="contact">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title wow fadeInUp">
						<h2>تواصل معنا</h2>
						<p>
							انضم إلي شركاء رتب. لي
						</p>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<!-- Contact form start -->
					<div class="contact-form">
						<form id="contactForm" action="{{ url('/contacting') }}" method="post" data-toggle="validator">
							{{ csrf_field() }}
							<div class="row">
								<div class="form-group col-md-12 col-sm-12">
									<input type="name" name="email" id="name" class="form-control" placeholder="الاسم" required>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group col-md-12 col-sm-12">
									<input type="email" name="email" id="email" class="form-control" placeholder="البريد الالكتروني" required>
									<div class="help-block with-errors"></div>
								</div>

								<div class="form-group col-md-12 col-sm-12">
									<textarea rows="6" name="message" id="message" class="form-control" placeholder="كيف يمكننا مساعدتك؟" required></textarea>
									<div class="help-block with-errors"></div>
								</div>
								
								<div class="col-md-12 col-sm-12 text-center">
									<button type="submit" class="btn-contact" title="Submit Your Message!">ارسال</button>
									<div id="msgSubmit" class="h3 text-left hidden"></div>
								</div>
							</div>
						</form>
					</div>
					<!-- Contact Form end -->
				</div>
			</div>
		</div>
	</section>
	<!-- Contact us section ends -->
	
	<!-- Footer section starts -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<!-- Footer logo start -->
				<div class="col-md-3">
					<div class="footer-logo wow fadeInLeft" >
						<a href="#"><img src="{{asset('landing_sa3ed')}}/images/logo.png" alt="" /></a>
					</div>
				</div>
				<!-- Footer logo end -->
				
				<!-- Footer info start -->
				<div class="col-md-6">
					<div class="footer-info wow fadeInUp">
						<p dir="ltr" >Copyright ©2017-2018 <a href="http://itsmart.com.sa/">iTSmart, LLC.</a> <br /> Designed with ❤ in Riyadh</p>
					</div>
				</div>
				<!-- Footer info end -->
				
				<!-- Footer social links start -->
				<div class="col-md-3">
					<div class="footer-social-links wow fadeInRight">
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
				</div>
				<!-- Footer social links end -->
			</div>
		</div>
	</footer>
	<!-- Footer section ends -->
	
    <!-- Jquery Library File -->
	<script src="{{asset('landing_sa3ed')}}/js/jquery-1.12.4.min.js"></script>
	<!-- Bootstrap js file -->
	<script src="{{asset('landing_sa3ed')}}/js/bootstrap.min.js"></script>
	<!-- Bootstrap form validator -->
	<script src="{{asset('landing_sa3ed')}}/js/validator.min.js"></script>
	<!-- Slick Nav js file -->
	<script src="{{asset('landing_sa3ed')}}/js/jquery.slicknav.js"></script>
	<!-- Wow js file -->
	<script src="{{asset('landing_sa3ed')}}/js/wow.js"></script>
	<!-- Swiper Carousel js file -->
	<script src="{{asset('landing_sa3ed')}}/js/swiper.min.js"></script>
	<!-- Magnific Popup core JS file -->
	<script src="{{asset('landing_sa3ed')}}/js/jquery.magnific-popup.min.js"></script>
	<!-- SmoothScroll -->
	<script src="{{asset('landing_sa3ed')}}/js/SmoothScroll.js"></script>
    <!-- Main Custom js file -->
	<script src="{{asset('landing_sa3ed')}}/js/function.js"></script>
</body>
</html>