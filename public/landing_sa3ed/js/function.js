(function ($) {
    "use strict";
	
	var $window = $(window); 
	var $body = $('body'); 
	
	/* Preloader Effect */
	$window.load(function() {
	   $(".preloader").fadeOut(600);
    });
	
	/* slick nav */
	$('#main-menu').slicknav({prependTo:'#responsive-menu',label:'', closeOnClick:true});
		
	/* Submenu */
	$('.nav li').hover(
		function(){
			$(this).children('ul').stop().slideDown(200);
		},
		function(){
			$(this).children('ul').stop().slideUp(200);
		}
	);
	
	/* Top Menu */
	var mainnav = $("#main-nav");
	$body.attr( 'data-offset', mainnav.outerHeight() );
	$(document).on('click','#navigation ul li a, #responsive-menu ul li a',function(){
		var id = $(this).attr('href');
		var h = Math.ceil( parseFloat($(id).offset().top) );
		$('body,html').stop().animate({
			scrollTop: h - 70
		}, 800);
		return false;
	});
		
	/* Sticky header */
	$window.scroll(function(){
    	if ($window.scrollTop() > 200) {
			$('.navbar').addClass('sticky-header');
		} else {
			$('.navbar').removeClass('sticky-header');
		}
	});
	
	/* Testimonial Swiper Slider */
	var swiper = new Swiper('.testimonial-slider', {
		speed: 400,
		spaceBetween: 30,
		slidesPerView: 2,
		navigation: {
			nextEl: '.testimonial-next',
			prevEl: '.testimonial-prev',
		},
		breakpoints: {
			768: {
				slidesPerView: 1,
				spaceBetween: 0
			}
		}
	});
	
	/* Screenshot Swiper Slider */
	var swiper = new Swiper('.screenshot-slider', {
		speed: 400,
		spaceBetween: 30,
		slidesPerView: 3,
		centeredSlides: true,
		navigation: {
			nextEl: '.screenshot-next',
			prevEl: '.screenshot-prev',
		},
		breakpoints: {
			768: {
				slidesPerView: 1
			}
		}
	});
	
	/* Popup video */
	$('.popup-video').magnificPopup({
        type: 'iframe',
        preloader: true,
    });
	
	/* Contact form validation */
	var $contactform=$("#contactForm");
	$contactform.validator({focus: false}).on("submit", function (event) {
		if (!event.isDefaultPrevented()) {
			event.preventDefault();
			submitForm();
		}
	});

	function submitForm(){
		/* Initiate Variables With Form Content*/
		var name = $("#name").val();
		var email = $("#email").val();
		var subject = $("#subject").val();
		var message = $("#message").val();

		$.ajax({
			type: "POST",
			url: "form-process.php",
			data: "name=" + name + "&email=" + email + "&subject=" + subject + "&message=" + message,
			success : function(text){
				if (text == "success"){
					formSuccess();
				} else {
					submitMSG(false,text);
				}
			}
		});
	}

	function formSuccess(){
		$contactform[0].reset();
		submitMSG(true, "Message Sent Successfully!")
	}

	function submitMSG(valid, msg){
		if(valid){
			var msgClasses = "h3 text-center text-success";
		} else {
			var msgClasses = "h3 text-center text-danger";
		}
		$("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
	}
	/* Contact form validation end */
	
	/* Animate with wow js */
    new WOW({mobile:false}).init(); 
	
})(jQuery);