<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    {{-- <link rel="shortcut icon" href="{{asset('')}}assets/images/favicon.ico"> --}}
    <link rel="icon" href="{{asset('Info')}}/{{ Session::get('favicon')}}">

    <title> @yield('title')| رتب لي</title>

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{asset('')}}assets/plugins/morris/morris.css">

    <!-- App css -->
    <link href="{{asset('')}}assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/css/core.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/css/pages.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/css/menu.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/css/responsive.css" rel="stylesheet" type="text/css"/>
    <!-- extra css -->

    <link href="{{asset('')}}assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/plugins/fileuploads/css/dropify.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="{{asset('')}}assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"
          rel="stylesheet">
    <link href="{{asset('')}}assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="{{asset('')}}assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css"
          rel="stylesheet">
    <link href="{{asset('')}}assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet"/>
    <link href="{{asset('')}}assets/plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('')}}assets/plugins/select2/dist/css/select2.css" rel="stylesheet" type="text/css">
    <link href="{{asset('')}}assets/plugins/select2/dist/css/select2-bootstrap.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('')}}assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link rel="stylesheet" href="{{asset('')}}assets/plugins/jquery-datatables-editable/datatables.css"/>

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{asset('')}}assets/js/modernizr.min.js"></script>
    <style>
        @font-face {
            font-family: 'Conv_JF_FLAT_REGULAR';
            src: url('{{asset('')}}fonts/29ltbukraregular.ttf');
            src: local('☺'), url('{{asset('')}}p0ublic/fonts/29ltbukrabold.ttf') format('woff'), url('{{asset('')}}fonts/29ltbukralight.ttf') format('truetype'), url('{{asset('')}}public/fonts/JF_FLAT_REGULAR.svg') format('svg');
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
        }
    </style>


</head>


<body class="fixed-left">
<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            {{-- <a href="{{URL('/')}}" class="logo"><span>رتبـ .<span>لي</span></span><i class="zmdi zmdi-layers"></i></a> --}}
            <img src="{{URL('/assets/images/big/Logo_Website_1080.png')}}" alt="Rtb.li"
                 style="display: inline-block; background-color: white;" title="Rtb.li" class="img img-responsive"
                 height="180" width="180">
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container" style="">

                <!-- Page title -->
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <button class="button-menu-mobile open-left">
                            <i class="zmdi zmdi-menu"></i>
                        </button>
                    </li>
                    <li>
                        <h4 class="page-title">@yield('title')</h4>
                    </li>
                </ul>

                <!-- Right(Notification and Searchbox -->
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <!-- Notification -->

                        <div class="notification-box">
                            <ul class="list-inline m-b-0">
                                <li>
                                    <a href="{{url('/notifications')}}" class="right-bar-toggle">
                                        <i class="zmdi zmdi-notifications-none"></i>
                                    </a>
                                    <div class="noti-dot">
                                        <span class="dot"></span>
                                        <span class="pulse"></span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- End Notification bar -->
                    </li>
                </ul>
                <!-- Right(go back button -->
                <ul class="nav navbar-nav navbar-center">
                    <li>
                        <div style="padding-right:1000px; padding-top:15px">
                            <ul class="list-inline m-b-0">
                                <li>
                                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-danger">
                                        <i class="fa fa-backward"></i> Go back
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

            </div>
            <!-- end container -->
        </div>
        <!-- end navbar -->
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">

            <!-- User -->
            <div class="user-box">
                <br>
                <br>
                <br>
                <br>
                <div class="user-img">

                    <img src="{{ Auth::user()->pic }}" width="50" height="50" alt="user-img"
                         title="{{ Auth::user()->user_name }}" class="img-circle img-thumbnail img-responsive">
                    <div class="user-status online"><i class="zmdi zmdi-dot-circle"></i>
                    </div>
                </div>
                <h5><a href="#">{{ Auth::user()->user_name }}</a></h5>
                <ul class="list-inline">
                <!-- <li>
                        <a href="{{URL('/admin/profile',Auth::User()->user_name)}}" >
                            <i class="zmdi zmdi-settings" title='Settings'></i>
                        </a>
                    </li> -->
                    @if (Auth::User()->is_admin == 1)
                        <li>
                            <a href="{{URL('/admin/edit',Auth::User()->id)}}">
                                <i class="zmdi zmdi-edit" title='Edit'></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL('/admin/lock')}}">
                                <i class="zmdi zmdi-lock" title='Lock'></i>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{URL('/vendors/edit',Auth::User()->id)}}">
                                <i class="zmdi zmdi-edit" title='Edit'></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL('/vendors/lock')}}">
                                <i class="zmdi zmdi-lock" title='Lock'></i>
                            </a>
                        </li>

                    @endif
                    <li>
                        <a href="{{URl('/logout')}}" class="text-custom">
                            <i class="zmdi zmdi-power" title='Logout'></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End User -->

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <ul>
                    @if (Auth::User()->is_vendor != 1)
                        <li class="text-muted menu-title">ادوات تحكم المستخدم</li>

                        <li>
                            <a href="{{Url('/dashboard')}}" class="waves-effect"><i
                                        class="zmdi zmdi-view-dashboard"></i> <span>الرئيسيه</span> </a>
                        </li>

                        <li><a href="{{URL('/admin/orders/view/0')}}" class="waves-effect"><i
                                        class="fa fa-object-group"></i>الطلبات</a></li>
                        <li>
                            <a href="{{Url('/admin/transaction')}}" class="waves-effect"><i class="zmdi zmdi-money"></i>
                                <span> التحويلات البنكيه </span> </a>
                        </li>


                        {{-- <li><a href="{{URL('/admin/users/carts')}}" class="waves-effect"><i class="fa fa-object-group"></i>سلة المشتريات</a></li> --}}

                    <!--<li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-invert-colors"></i> <span> المنتجات </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{URL('/product/view')}}">عرض</a></li>
                            <li><a href="{{URL('/product/add')}}">اضافه</a></li>
                        </ul>
                    </li>-->
                        {{--
                        <li class="has_sub"> --}} {{-- <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-chart"></i> <span> الطلبات </span> <span class="menu-arrow"></span></a> --}} {{--
                            <ul class="list-unstyled"> --}}
                        {{-- <li><a href="{{URL('orders/view')}}" class="waves-effect"><i class="zmdi zmdi-chart"></i> عدد الطلبات</a> --}}
                        {{-- </li> --}}
                        {{-- </ul> --}} {{-- </li> --}} {{--
                        <li class="has_sub"> --}} {{-- <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-star"></i> <span> التقيميات  </span> <span class="menu-arrow"></span></a> --}} {{--
                            <ul class="list-unstyled"> --}}
                        {{--<li c lass="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-object-group"></i><span> الطلبات </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/orders/view/1')}}">الطلبات الجديدة</a>
                                </li>
                                <li><a href="{{URL('/orders/view/2')}}">الطلبات المقبولة</a>
                                </li>
                                <li><a href="{{URL('/orders/view/3')}}">الطلبات المرفوضة</a>
                                </li>
                            </ul>
                        </li> --}}

                        <li>
                            <a href="{{URL('/rates/view')}}" class="waves-effect"> <i class="fa fa-star"></i>التقييميات
                            </a>
                        </li>
                        {{-- </ul> --}} {{-- </li> --}}
                        <li>
                            <a href="{{Url('/admin/getvendores')}}" class="waves-effect"><i class="zmdi zmdi-label"></i>
                                <span> مزودي الخدمات </span> </a>
                        </li>

                        <li><a href="{{URL('/admin/countries')}}" class="waves-effect"><i
                                        class="fa fa-flag"></i>الدول</a>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-object-group"></i><span> الخدمات </span>
                                <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/admin/category/view')}}">عرض الخدمات</a>
                                </li>
                                <li><a href="{{URL('/admin/category/add')}}">اضافة خدمه جديدة</a>
                                </li>
                            </ul>
                        </li>



                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i><span> المستخدمين </span>
                                <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/admin/user/view/2')}}">جميع المستخدمين</a>
                                </li>
                                <li><a href="{{URL('/unverifiedusers')}}">مستخدمين غير مفعلين</a>
                                <li><a href="{{URL('/admin/user')}}">اضافة مستخدم جديد</a>
                                </li>
                                {{-- <li><a href="{{URL('/admin/user/permission')}}">الصلاحيات</a>
                                </li> --}}
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i><span> النشاط اليومي </span>
                                <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{URL('/admin/user/view/0/1')}}">المستخدمين</a>
                                </li>

                                <li>
                                    <a href="{{URL('/admin/user/view/2/1')}}">مزودي الخدمه</a>
                                </li>

                                <li>
                                    <a href="{{URL('/admin/product/view/1')}}">المنتجات</a>
                                </li>

                                <li>
                                    <a href="{{URL('/admin/orders/view/0/1')}}">الطلبات</a>
                                </li>

                                <li>
                                    <a href="{{URL('/admin/logs')}}">History</a>
                                </li>
                            </ul>
                        </li>

                        <li><a href="{{URL('/admin/promo')}}" class="waves-effect"><i class="fa fa-info"></i>اكواد الخصم</a>
                        </li>
                        <li><a href="{{URL('admin/info/view')}}" class="waves-effect"><i class="fa fa-info"></i>معلومات
                                البرنامج</a>
                        </li>
                        <li><a href="{{URL('/admin/payment/view')}}" class="waves-effect"><i class="fa fa-money"></i>عرض
                                الحسابات البنكيه</a>
                        </li>
                    @elseif(Auth::user()->is_vendor == 1)
                        <li class="text-muted menu-title">ادوات تحكم المستخدم</li>
                        <li>
                            <a href="{{Url('/vendors')}}" class="waves effect"> <i class="zmdi zmdi-view-dashboard"></i><span>الرئيسيه</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{Url('/vendors/orders/view/0')}}" class="waves effect"> <i
                                        class="fa fa-object-group"></i><span>
                                الطلبات 
                            </span>
                            </a>
                        </li>
                    <!--
                        <li>
                            <a href="{{URL('/vendors/orders/view')}}" class="waves-effect"><i class="zmdi zmdi-chart"></i>الطلبات</a>
                        </li>
                        -->
                    <!-- <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-object-group"></i><span> الطلبات </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/vendors/orders/view/1')}}">الطلبات الجديدة</a>
                                </li>
                                <li><a href="{{URL('/vendors/orders/view/2')}}">الطلبات المقبولة</a>
                                </li>
                                <li><a href="{{URL('/vendors/orders/view/3')}}">الطلبات المرفوضة</a>
                                </li>
                            </ul>
                        </li> -->

                        <li><a href="{{URL('/vendors/rates/view')}}" class="waves-effect"><i class="fa fa-star"></i>التقييمات</a>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i><span> طاقم العمل </span>
                                <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/vendors/user/view')}}">جميع العاملين</a>
                                </li>
                                <li><a href="{{URL('/vendors/user')}}">اضافة عامل جديد</a>
                                </li>
                                {{-- <li><a href="{{URL('/admin/user/permission')}}">الصلاحيات</a>
                                </li> --}}
                            </ul>
                        </li>

                    <!--<li><a href="{{URL('/vendors/branch')}}" class="waves-effect"><i class="fa fa-star"></i>بيانات الفرع</a>
                        </li>-->
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-invert-colors"></i>
                                <span>
                                    المنتجات 
                                </span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/vendors/product/view')}}">عرض</a>
                                </li>
                                <li><a href="{{URL('/vendors/product/add')}}">اضافة</a>
                                </li>
                            </ul>
                        </li>
                    @elseif(Auth::user()->is_privillage == 1 && Auth::user()->is_vendor == 0 &&Auth::user()->is_admin == 0)
                        <li>
                            <a href="{{Url('/accountant')}}" class="waves effect"> <i class="zmdi zmdi-view-dashboard"></i><span>الرئيسيه</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{Url('/accountant')}}" class="waves effect"> <i
                                        class="fa fa-object-group"></i><span>
                                الطلبات
                            </span>
                            </a>
                        </li>


                    @elseif(Auth::user()->is_privillage == 2 && Auth::user()->is_vendor == 0 &&Auth::user()->is_admin == 0)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-invert-colors"></i>
                                <span>
                                    المنتجات
                                </span><span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/sales')}}">عرض</a>
                                </li>
                                <li><a href="{{URL('/sales/add')}}">اضافة</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{URL('/vendors/rates/view')}}" class="waves-effect"><i class="fa fa-star"></i>التقييمات</a>

                    @elseif(Auth::user()->is_privillage == 3 && Auth::user()->is_vendor == 0 &&Auth::user()->is_admin == 0)
                        <li>
                            <a href="{{Url('/accountant')}}" class="waves effect"> <i
                                        class="fa fa-object-group"></i><span>
                                الطلبات
                            </span>
                            </a>
                        </li>

                    @endif
                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>

        </div>

    </div>
    <!-- Left Sidebar End -->


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container" style="margin-top: 130px;">
                @if(session()->has('errormsg'))
                    <div class="alert alert-danger">
                        {{ session()->get('errormsg') }}
                    </div>
                @endif @yield('content')
            </div>
            <!-- container -->

        </div>
        <!-- content -->

        <footer class="footer text-right">
            <div class="page-footer-inner">
                <?php echo date('Y')?> - 2017 &copy; Ratb.li
                <a href="http://itsmart.com.sa/" title="iTSmart" target="_blank">IT Smart</a>
            </div>
        </footer>

    </div>


</div>
<!-- END wrapper -->


@section('footer')
    <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="{{asset('')}}assets/js/jquery.min.js"></script>
    <script src="{{asset('')}}assets/js/bootstrap-rtl.min.js"></script>
    <script src="{{asset('')}}assets/js/detect.js"></script>
    <script src="{{asset('')}}assets/js/fastclick.js"></script>
    <script src="{{asset('')}}assets/js/jquery.blockUI.js"></script>
    <script src="{{asset('')}}assets/js/waves.js"></script>
    <script src="{{asset('')}}assets/js/jquery.nicescroll.js"></script>
    <script src="{{asset('')}}assets/js/jquery.slimscroll.js"></script>
    <script src="{{asset('')}}assets/js/jquery.scrollTo.min.js"></script>

    <!-- KNOB JS -->
    <!--[if IE]>
    <script type="text/javascript" src="{{asset('')}}assets/plugins/jquery-knob/excanvas.js"></script>
    <![endif]-->
    <script src="{{asset('')}}assets/plugins/jquery-knob/jquery.knob.js"></script>

    <!--Morris Chart-->
    <script src="{{asset('')}}assets/plugins/morris/morris.min.js"></script>
    <script src="{{asset('')}}assets/plugins/raphael/raphael-min.js"></script>


    <!-- App js -->
    <script src="{{asset('')}}assets/js/jquery.core.js"></script>
    <script src="{{asset('')}}assets/js/jquery.app.js"></script>
    <script src="{{asset('')}}assets/js/avoid-char.js"></script>

    <!--extra-->
    <script src="{{asset('')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/jszip.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="{{asset('')}}assets/plugins/datatables/dataTables.scroller.min.js"></script>
    <script src="{{asset('')}}assets/pages/datatables.init.js"></script>
    <script src="{{asset('')}}assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
    <script src="{{asset('')}}assets/pages/jquery.sweet-alert.init.js"></script>
    <script src="{{asset('')}}assets/plugins/fileuploads/js/dropify.min.js"></script>
    <script src="{{asset('')}}assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="{{asset('')}}assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="{{asset('')}}assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('')}}assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="{{asset('')}}assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"
            type="text/javascript"></script>
    <script src="{{asset('')}}assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript" src="{{asset('')}}assets/plugins/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="{{asset('')}}assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
    <script src="{{asset('')}}assets/plugins/select2/dist/js/select2.min.js" type="text/javascript"></script>
    <script src="{{asset('')}}assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"
            type="text/javascript"></script>
    <script src="{{asset('')}}assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"
            type="text/javascript"></script>
    <script src="{{asset('')}}assets/plugins/moment/moment.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-messaging.js"></script>
    <script>
        /*var config = {
                apiKey: "AIzaSyB11eakCFO3jf_aSdxQZJYKI5OXwOVv53s",
                authDomain: "party-2e6be.firebaseapp.com",
                databaseURL: "https://party-2e6be.firebaseio.com",
                projectId: "party-2e6be",
                storageBucket: "party-2e6be.appspot.com",
                messagingSenderId: "425523526587"
            };*/
        var config = {
            apiKey: "AIzaSyB11eakCFO3jf_aSdxQZJYKI5OXwOVv53s",
            authDomain: "party-2e6be.firebaseapp.com",
            databaseURL: "https://party-2e6be.firebaseio.com",
            projectId: "party-2e6be",
            storageBucket: "party-2e6be.appspot.com",
            messagingSenderId: "425523526587"
        };
        firebase.initializeApp(config);

        const messaging = firebase.messaging();
        navigator.serviceWorker.register('{{url("/")}}/firebase-messaging-sw.js')
            .then((registration) = > {


            messaging.useServiceWorker(registration);
        // Request permission and get token.....
        messaging.requestPermission()
            .then(function () {
                console.log('Notification permission granted.');
                return messaging.getToken();
            })
            .then(function (token) {
                console.log(token); // Display user token
                var postData = {
                    _token: $("input[name='_token']").val(),
                    fcmtoken: token
                }
                $.ajax({
                    url: '{{url(' / ')}}' + "/setuserwebtoken",
                    type: 'POST',
                    data: postData,
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);


                    }
                });
            })
            .catch(function (err) { // Happen if user deney permission
                console.log('Unable to get permission to notify.', err);
            });


        })
        ;

        messaging.onMessage(function (payload) {
            $(".user-list").append('<li class="list-group-item">' + '<a href="' + payload.notification.click_action + '" class="user-list-item">'

                + '<div class="user-desc">' + '<span class="name">' + payload.notification.title + '</span>' + '<span class="desc">' + payload.notification.body + '</span>'

                + '</div>' + '</a>' + '</li>');
            //window.webkitNotifications.createNotification('icon.png', 'Notification Title', 'Notification content...');
            console.log('onMessage', payload);
            console.log(payload.notification.body);
            var e = new Notification(payload.notification.title, {
                body: payload.notification.body,
                icon: payload.notification.icon,
                data: payload.notification.click_action
            })

            e.onclick = function (n) {
                window.location.href = n.target.data;
            }
        })
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').DataTable({
                pageLength: 50,
                "language": {
                    "info": "عرض _START_ الى _END_ من اجمالي _TOTAL_",
                }
            });
            $('#datatable-keytable').DataTable({
                pageLength: 50,
                keys: true,
                "language": {
                    "info": "عرض _START_ الى _END_ من اجمالي _TOTAL_",
                }
            });
            $('#datatable-responsive').DataTable({
                pageLength: 50,
                "language": {
                    "info": "عرض _START_ الى _END_ من اجمالي _TOTAL_",
                }
            });
            $('#datatable-scroller').DataTable({
                ajax: "assets/plugins/datatables/json/scroller-demo.json",
                deferRender: true,
                scrollY: 380,
                scrollCollapse: true,
                scroller: true,
                pageLength: 50,
                "language": {
                    "info": "عرض _START_ الى _END_ من اجمالي _TOTAL_",
                }
            });
            var table = $('#datatable-fixed-header').DataTable({
                fixedHeader: true
            });
        });
        TableManageButtons.init();
    </script>
    <script>
        jQuery(document).ready(function () {
            // Time Picker
            jQuery('#timepicker').timepicker({
                defaultTIme: false
            });
            jQuery('#timepicker2').timepicker({
                showMeridian: false
            });
            jQuery('#timepicker3').timepicker({
                minuteStep: 15
            });

            //colorpicker start

            $('.colorpicker-default').colorpicker({
                format: 'hex'
            });
            $('.colorpicker-rgba').colorpicker();

            // Date Picker
            jQuery('#datepicker').datepicker();
            jQuery('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true
            });
            jQuery('#datepicker-inline').datepicker();
            jQuery('#datepicker-multiple-date').datepicker({
                format: "mm/dd/yyyy",
                clearBtn: true,
                multidate: true,
                multidateSeparator: ","
            });
            jQuery('#date-range').datepicker({
                toggleActive: true
            });

            //Date range picker
            /*$('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-default',
            cancelClass: 'btn-primary'
        });
        $('.input-daterange-timepicker').daterangepicker({
            timePicker: true,
            format: 'MM/DD/YYYY h:mm A',
            timePickerIncrement: 30,
            timePicker12Hour: true,
            timePickerSeconds: false,
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-default',
            cancelClass: 'btn-primary'
        });
        $('.input-limit-datepicker').daterangepicker({
            format: 'MM/DD/YYYY',
            minDate: '06/01/2016',
            maxDate: '06/30/2016',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-default',
            cancelClass: 'btn-primary',
            dateLimit: {
                days: 6
            }
        });
*/
            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            /*$('#reportrange').daterangepicker({
            format: 'MM/DD/YYYY',
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2016',
            maxDate: '12/31/2016',
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-default',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });
*/
            //Bootstrap-MaxLength
            $('input#defaultconfig').maxlength()

            $('input#thresholdconfig').maxlength({
                threshold: 20
            });

            $('input#moreoptions').maxlength({
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger"
            });

            $('input#alloptions').maxlength({
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger",
                separator: ' out of ',
                preText: 'You typed ',
                postText: ' chars available.',
                validate: true
            });

            $('textarea#textarea').maxlength({
                alwaysShow: true
            });

            $('input#placement').maxlength({
                alwaysShow: true,
                placement: 'top-left'
            });
        });
    </script>
	<script type="text/javascript">
    (function(p,u,s,h){
        p._pcq=p._pcq||[];
        p._pcq.push(['_currentTime',Date.now()]);
        s=u.createElement('script');
        s.type='text/javascript';
        s.async=true;
        s.src='https://cdn.pushcrew.com/js/9a0a95c980448575ebe6719e0afd25b5.js';
        h=u.getElementsByTagName('script')[0];
        h.parentNode.insertBefore(s,h);
    })(window,document);
</script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "e5798616-ab96-4ca3-b6e4-8c251d69cd58",
                autoRegister: false,
                notifyButton: {
                    enable: true,
                },
            });
        });
    </script>
@show

</body>

</html>