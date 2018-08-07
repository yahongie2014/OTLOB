<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App Favicon -->
    {{-- <link rel="shortcut icon" href="{{asset('')}}assets/images/favicon.ico"> --}}
    <link rel="icon" href="{{asset('Info')}}/{{ Session::get('favicon')}}">

    <!-- App title -->
    <title> @yield('title')| رتب لي</title>

    <!--calendar css-->
    <link href="{{asset('')}}assets/plugins/fullcalendar/dist/fullcalendar.css" rel="stylesheet" />

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
    <link href="{{asset('')}}assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="{{asset('')}}assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="{{asset('')}}assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="{{asset('')}}assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    
    <script src="{{asset('')}}assets/js/modernizr.min.js"></script>
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
        body,a,h4{font-family: 'Conv_JF_FLAT_REGULAR';}
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
            <img src="{{URL('/assets/images/big/Logo_Website_256.png')}}" alt="Rtb.li" style="display: inline-block;" title="Rtb.li" class="img img-responsive" height="180" width="180" >
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">

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
                    <li class="hidden-xs">
                        <!-- <form role="search" class="app-search">
                            <input type="text" placeholder="Search..."
                                   class="form-control">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form> -->
                    </li>
                </ul>

            </div><!-- end container -->
        </div><!-- end navbar -->
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">
            <br><br><br><br>
            <!-- User -->
            <div class="user-box">
                <div class="user-img">
                    <img src="{{ Auth::user()->pic }}" alt="user-img" title="{{ Auth::user()->user_name }}" class="img-circle img-thumbnail img-responsive">
                    <div class="user-status offline"><i class="zmdi zmdi-dot-circle"></i></div>
                </div>
                <h5><a href="#">{{ Auth::user()->user_name }}</a> </h5>
                <ul class="list-inline">
                    <!-- <li>
                        <a href="{{URL('/admin/profile',Auth::User()->user_name)}}" >
                            <i class="zmdi zmdi-settings"></i>
                        </a>
                    </li> -->
                    @if (Auth::User()->is_vendor != 1)
                        <li>
                            <a href="{{URL('/admin/edit',Auth::User()->id)}}" >
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL('/admin/lock')}}" >
                                <i class="zmdi zmdi-lock"></i>
                            </a>
                        </li>
                    @elseif(Auth::User()->is_vendor == 1)
                        <li>
                            <a href="{{URL('/vendors/edit',Auth::User()->id)}}" >
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL('/vendors/lock')}}" >
                                <i class="zmdi zmdi-lock"></i>
                            </a>
                        </li>

                    @endif
                    <li>
                        <a href="{{URl('/logout')}}" class="text-custom">
                            <i class="zmdi zmdi-power"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End User -->

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <ul>
                    @if (Auth::User()->is_vendor != 1)
                        <li class="text-muted menu-title">أدوات تحكم المستخدم</li>

                        <li>
                            <a href="{{Url('/dashboard')}}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i> <span> الرئيسية </span> </a>
                        </li>

                        <!--<li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-invert-colors"></i> <span> المنتجات </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/product/view')}}">عرض</a></li>
                                <li><a href="{{URL('/product/add')}}">اضافه</a></li>
                            </ul>
                        </li>-->
                    <li>
                        <a href="{{Url('/admin/getvendores')}}" class="waves-effect"><i class="zmdi zmdi-label"></i> <span> أصحاب الأعمال </span> </a>
                    </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-star"></i> <span> التقييميات </span> <span class="menu-arrow"></span></a>

                            <ul class="list-unstyled">
                                <li><a href="{{URL('/rates/view')}}">عرض</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-chart"></i> <span> أرباحي </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('orders/view')}}">عدد الطلبات</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-gear"></i><span> الإعدادات </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('admin/info/view')}}">معلومات البرنامج</a></li>
                                <li><a href="{{URL('/admin/user/view')}}">جميع المستخدمين</a></li>
                                <li><a href="{{URL('/admin/user')}}">اضافه مستخدم جديد</a></li>
                                {{-- <li><a href="{{URL('/admin/user/permission')}}">الصلاحيات</a></li> --}}
                                <li><a href="{{URL('/admin/category/view')}}">عرض الخدمات</a></li>
                                <li><a href="{{URL('/admin/category/add')}}">اضافه خدمه جديده</a></li>
                                <li><a href="{{URL('/admin')}}">اضافه بلاد</a></li>
                                <li><a href="{{URL('/admin')}}">عرض البلاد</a></li>
                                <li><a href="{{URL('/admin')}}">اعدادت النظام</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="text-muted menu-title">أدوات تحكم المستخدم</li>

                        <li>
                            <a href="{{Url('/vendors')}}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i> <span> الرئيسية </span> </a>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-invert-colors"></i> <span> المنتجات </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/vendors/product/view')}}">عرض</a></li>
                                <li><a href="{{URL('/vendors/product/add')}}">اضافه</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-star"></i> <span> التقييميات </span> <span class="menu-arrow"></span></a>

                            <ul class="list-unstyled">
                                <li><a href="{{URL('/vendors/rates/view')}}">عرض</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-chart"></i> <span> أرباحي </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{URL('/vendors/orders/view')}}">عدد الطلبات</a></li>
                            </ul>
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
            <div class="container">
                @if(session()->has('errormsg'))
                <div class="alert alert-danger">
                    {{ session()->get('errormsg') }}
                </div>
                @endif
@yield('content')

            </div> <!-- container -->

        </div> <!-- content -->

        <div class="footer">
            <div class="page-footer-inner"> <?php echo date('Y')?> - 2017 &copy; Ratb.li
                <a href="http://itsmart.com.sa/" title="coder_79" target="_blank">IT Smart</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>

    </div>


    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->


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
<script src="{{asset('')}}assets/js/jquery.slimscroll.js"></script>
<script src="{{asset('')}}assets/js/jquery.blockUI.js"></script>
<script src="{{asset('')}}assets/js/waves.js"></script>
<script src="{{asset('')}}assets/js/jquery.nicescroll.js"></script>
<script src="{{asset('')}}assets/js/jquery.scrollTo.min.js"></script>

<!-- App js -->
<script src="{{asset('')}}assets/js/jquery.core.js"></script>
<script src="{{asset('')}}assets/js/jquery.app.js"></script>

<!-- Jquery-Ui -->
<script src="{{asset('')}}assets/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- BEGIN PAGE SCRIPTS -->
<script src="{{asset('')}}assets/plugins/moment/moment.js"></script>
<script src='{{asset('')}}assets/plugins/fullcalendar/dist/fullcalendar.min.js'></script>
<script src="{{asset('')}}assets/pages/jquery.fullcalendar.js"></script>
<script src="{{asset('')}}assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="{{asset('')}}assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="{{asset('')}}assets/plugins/switchery/switchery.min.js"></script>
<script src="{{asset('')}}assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="{{asset('')}}assets/plugins/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="{{asset('')}}assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
<script src="{{asset('')}}assets/plugins/select2/dist/js/select2.min.js" type="text/javascript"></script>
<script src="{{asset('')}}assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
<script src="{{asset('')}}assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script src="{{asset('')}}assets/plugins/moment/moment.js"></script>
<script src="{{asset('')}}assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="{{asset('')}}assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="{{asset('')}}assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{asset('')}}assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{asset('')}}assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
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
        .then((registration) => {


        messaging.useServiceWorker(registration);
    // Request permission and get token.....
    messaging.requestPermission()
        .then(function() {
            console.log('Notification permission granted.');
            return messaging.getToken();
        })
        .then(function(token) {
            console.log(token); // Display user token
            var postData = {_token: $("input[name='_token']").val(),fcmtoken:token}
            $.ajax({
                url: '{{url('/')}}' + "/setuserwebtoken",
                type: 'POST',
                data: postData,
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);


                }
            });
        })
        .catch(function(err) { // Happen if user deney permission
            console.log('Unable to get permission to notify.', err);
        });


    });

    messaging.onMessage(function(payload){
        $(".user-list").append('<li class="list-group-item">'
            +'<a href="' + payload.notification.click_action +'" class="user-list-item">'

            +'<div class="user-desc">'
            +'<span class="name">'+ payload.notification.title + '</span>'
            +'<span class="desc">' + payload.notification.body + '</span>'

            +'</div>'
            +'</a>'
            +'</li>');
        //window.webkitNotifications.createNotification('icon.png', 'Notification Title', 'Notification content...');
        console.log('onMessage',payload);
        console.log(payload.notification.body);
        var e = new Notification(payload.notification.title,{
            body : payload.notification.body,
            icon : payload.notification.icon,
            data : payload.notification.click_action
        })

        e.onclick = function(n){
            window.location.href = n.target.data;
        }
    })

</script>

<script>
    jQuery(document).ready(function() {

        //advance multiselect start
        $('#my_multi_select3').multiSelect({
            selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (ms) {
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function (e) {
                        if (e.which === 40) {
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function (e) {
                        if (e.which == 40) {
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
            },
            afterSelect: function () {
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function () {
                this.qs1.cache();
                this.qs2.cache();
            }
        });

        // Select2
        $(".select2").select2();

        $(".select2-limiting").select2({
            maximumSelectionLength: 2
        });

    });

    //Bootstrap-TouchSpin
    $(".vertical-spin").TouchSpin({
        verticalbuttons: true,
        buttondown_class: "btn btn-primary",
        buttonup_class: "btn btn-primary",
        verticalupclass: 'ti-plus',
        verticaldownclass: 'ti-minus'
    });
    var vspinTrue = $(".vertical-spin").TouchSpin({
        verticalbuttons: true
    });
    if (vspinTrue) {
        $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
    }

    $("input[name='demo1']").TouchSpin({
        min: 0,
        max: 100,
        step: 0.1,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        buttondown_class: "btn btn-primary",
        buttonup_class: "btn btn-primary",
        postfix: '%'
    });
    $("input[name='demo2']").TouchSpin({
        min: -1000000000,
        max: 1000000000,
        stepinterval: 50,
        buttondown_class: "btn btn-primary",
        buttonup_class: "btn btn-primary",
        maxboostedstep: 10000000,
        prefix: '$'
    });
    $("input[name='demo3']").TouchSpin({
        buttondown_class: "btn btn-primary",
        buttonup_class: "btn btn-primary"
    });
    $("input[name='demo3_21']").TouchSpin({
        initval: 40,
        buttondown_class: "btn btn-primary",
        buttonup_class: "btn btn-primary"
    });
    $("input[name='demo3_22']").TouchSpin({
        initval: 40,
        buttondown_class: "btn btn-primary",
        buttonup_class: "btn btn-primary"
    });

    $("input[name='demo5']").TouchSpin({
        prefix: "pre",
        postfix: "post",
        buttondown_class: "btn btn-primary",
        buttonup_class: "btn btn-primary"
    });
    $("input[name='demo0']").TouchSpin({
        buttondown_class: "btn btn-primary",
        buttonup_class: "btn btn-primary"
    });

    // Time Picker
    jQuery('#timepicker').timepicker({
        defaultTIme : false
    });
    jQuery('#timepicker2').timepicker({
        showMeridian : false
    });
    jQuery('#timepicker3').timepicker({
        minuteStep : 15
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
    $('.input-daterange-datepicker').daterangepicker({
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

    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange').daterangepicker({
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
</script>
@show
<script src="{{asset('')}}assets/js/avoid-char.js"></script>
</body>
</html>