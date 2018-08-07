<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="سجيل كمزود خدمة">
    <meta name="author" content="Coderthemes">

    <!-- App Favicon -->
    {{-- <link rel="shortcut icon" href="{{asset('')}}assets/images/favicon.ico"> --}}
    <link rel="icon" href="{{asset('Info')}}/{{ Session::get('favicon')}}">

    <!-- App title -->
    <title>تسجيل كمزود خدمة</title>

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

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{asset('')}}assets/js/modernizr.min.js"></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
@yield('register')



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