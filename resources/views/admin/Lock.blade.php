<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="{{asset('')}}assets/images/favicon.ico">

    <!-- App title -->
    <title>الشاشه مغلقه</title>
    <style>
        @font-face {
            font-family: 'Conv_JF_FLAT_REGULAR';
            src: url('{{asset('')}}fonts/29ltbukraregular.ttf');
            src: local('☺'), url('{{asset('')}}p0ublic/fonts/29ltbukrabold.ttf') format('woff'), url('{{asset('')}}fonts/29ltbukralight.ttf')
            format('truetype'), url('{{asset('')}}public/fonts/JF_FLAT_REGULAR.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        .page-header.navbar .page-logo .logo-default {
            margin: 16px 0 0;
            width: 103px;
        }
        body{font-family: 'Conv_JF_FLAT_REGULAR';}
        h2{font-family: 'Conv_JF_FLAT_REGULAR';}
    </style>

    <!-- App CSS -->
    <link href="{{asset('')}}assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{asset('')}}assets/js/modernizr.min.js"></script>

</head>
<body>
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if(session()->has('danger'))
    <div class="alert alert-danger">
        {{ session()->get('danger') }}
    </div>
@endif

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="text-center">
        <a href="{{URL('/admin/lock')}}" class="logo"><span>Admin<span>to</span></span></a>
        <h5 class="text-muted m-t-0 font-600">{{Auth::user()->user_name}}</h5>
    </div>
    <div class="m-t-40 card-box">
        <div class="text-center">
            <h2 class="text-uppercase font-bold m-b-0">اهلا بك</h2>
        </div>
        <div class="panel-body">
            <form class="lock-form pull-left" action="{{ url('/admin/lock/auth') }}" method="post">
                {{ csrf_field() }}
                <div class="user-thumb">
                    <img src="{{Auth::user()->pic}}" class="img-responsive img-circle img-thumbnail" alt="thumbnail">
                </div>
                <div class="form-group">
                    <p class="text-muted m-t-10">
                        Enter your password to access the admin.
                    </p>
                    <div class="input-group m-t-30">
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="كلمه المرور" name="password" />
                        @if ($errors->has('password'))
                            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                        <span class="input-group-btn"><button type="submit" class="btn btn-pink w-sm waves-effect waves-light">الدخول</button></span>
                    </div>
                </div>

            </form>


        </div>
    </div>
    <!-- end card-box -->

    <div class="row">
        <div class="col-sm-12 text-center">
            <p class="text-muted">Not {{Auth::user()->user_name}}?<a href="{{URl('/logout')}}" class="text-primary m-l-5"><b>Sign In</b></a></p>
        </div>
    </div>

</div>
<!-- end wrapper -->




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