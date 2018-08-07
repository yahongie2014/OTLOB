<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ahmed Magdy - a.magdymedany@gmail.com">
    <meta property="og:image" content="{{asset('landing_page')}}/img/bg-img/logo_copy.png" />
    <meta name="description" content="رتب. لي منصة تفاعلية احترافية تساعد كافة المستخدمين علي تنظيم مناسباتهم في اسرع وقت بسهولة وبأقل تكلفة من خلال تقديم خيارات متعددة لمزودي خدمات تم اختيارهم بعناية فائقة بما يتناسب مع شروط منصة رتب.لي">
    <meta property="og:title" content="Ratb.li | رتب. لي - شروط مقدِمي الخدمة"/>
    <meta property="og:url" content="https://ratb.li/policy">
    <meta property="fb:app_id" content="966242223397117" />
    <meta property="og:site_name" content="Ratb.li | رتب. لي"/>
    <meta name="keywords" content="party, ratbli, ratb.li, party management">

    <!-- App Favicon -->
    {{-- <link rel="shortcut icon" href="{{asset('')}}assets/images/favicon.ico"> --}}
    <link rel="icon" href="{{asset('Info')}}/{{ Session::get('favicon')}}">

    <!-- App title -->
    <title>شروط مقدِمي الخدمة</title>

    <!-- App CSS -->
    <link href="{{asset('')}}assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <style>
        @font-face {
            font-family: 'Conv_JF_FLAT_REGULAR';
            src: url('{{asset('')}}fonts/29ltbukraregular.ttf');
            src: local('☺'), url('{{asset('')}}/fonts/29ltbukrabold.ttf') format('woff'), url('{{asset('')}}fonts/29ltbukralight.ttf')
            format('truetype'), url('{{asset('')}}/fonts/JF_FLAT_REGULAR.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        .login {
            background-image: url("{{asset('')}}Logo/smoke.jpg");
        }
        body,a,h4{font-family: 'Conv_JF_FLAT_REGULAR';}
    </style>
    <script src="{{asset('')}}assets/js/modernizr.min.js"></script>
</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
@yield('policy')



<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{asset('')}}assets/js/jquery.min.js"></script>
<script src="{{asset('')}}assets/js/bootstrap-rtl.min.js"></script>
<script src="{{asset('')}}assets/js/detect.js"></script>
<script src="{{asset('')}}assets/js/fastclick.js"></script>
<script src="{{asset('')}}assets/js/jquery.slimscroll.js"></script>
<script src="{{asset('')}}assets/js/jquery.blockUI.js"></script>
<script src="{{asset('')}}assets/js/waves.js"></script>
<script src="{{asset('')}}assets/js/wow.min.js"></script>
<script src="{{asset('')}}assets/js/jquery.nicescroll.js"></script>
<script src="{{asset('')}}assets/js/jquery.scrollTo.min.js"></script>

<!-- App js -->
<script src="{{asset('')}}assets/js/jquery.core.js"></script>
<script src="{{asset('')}}assets/js/jquery.app.js"></script>

</body>
</html>