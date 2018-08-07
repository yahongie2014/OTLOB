@extends('layouts.adminv2')
@section('title')
 | عرض المنتج {{$pro_dic->name}}
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('/assets/js/xzoom/foundation.css')}}" />
<link rel="stylesheet" href="{{asset('/assets/js/xzoom/demo.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('/assets/js/xzoom/xzoom.css')}}" media="all" />

<style>
    table {
        font-family: sans-serif;
        width: 100%;
        border-spacing: 0;
        border-collapse: separate;
        table-layout: fixed;
        margin-bottom: 50px;
        direction: ltr;
    }
    table thead tr th {
        background: #626E7E;
        color: #d1d5db;
        padding: 0.5em;
        overflow: hidden;
        text-align: center;
    }
    table thead tr th:first-child {
        border-radius: 3px 0 0 0;
    }
    table thead tr th:last-child {
        border-radius: 0 3px  0 0;
    }
    table thead tr th .day {
        display: block;
        font-size: 1.2em;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        margin: 0 auto 5px;
        padding: 5px;
        line-height: 1.8;
    }
    table thead tr th .day.active {
        background: #d1d5db;
        color: #626E7E;
    }
    table thead tr th .short {
        display: none;
    }
    table thead tr th i {
        vertical-align: middle;
        font-size: 2em;
    }
    table tbody tr {
        background: #d1d5db;
    }
    table tbody tr:nth-child(odd) {
        background: #c8cdd4;
    }
    table tbody tr:nth-child(6n+0) td {
        border-bottom: 1px solid #626E7E;
    }
    table tbody tr td {
        text-align: center;
        vertical-align: middle;
        border-left: 1px solid #626E7E;
        position: relative;
        height: 32px;
        cursor: pointer;
    }
    table tbody tr td:last-child {
        /*border-right: 1px solid #626E7E;*/
    }
    table tbody tr td.hour {
        font-size: 2em;
        padding: 0;
        color: #626E7E;
        background: #fff;
        border-bottom: 1px solid #626E7E;
        border-collapse: separate;
        min-width: 100px;
        cursor: default;
    }
    table tbody tr td.hour span {
        display: block;
    }
    @media (max-width: 60em) {
        table thead tr th .long {
            display: none;
        }
        table thead tr th .short {
            display: block;
        }
        table tbody tr td.hour span {
            transform: rotate(270deg);
            -webkit-transform: rotate(270deg);
            -moz-transform: rotate(270deg);
        }
    }
    @media (max-width: 27em) {
        table thead tr th {
            font-size: 65%;
        }
        table thead tr th .day {
            display: block;
            font-size: 1.2em;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            margin: 0 auto 5px;
            padding: 5px;
        }
        table thead tr th .day.active {
            background: #d1d5db;
            color: #626E7E;
        }
        table tbody tr td.hour {
            font-size: 1.7em;
        }
        table tbody tr td.hour span {
            transform: translateY(16px) rotate(270deg);
            -webkit-transform: translateY(16px) rotate(270deg);
            -moz-transform: translateY(16px) rotate(270deg);
        }
    }

</style>

<br>
<div class="row">
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>  | عرض المنتج {{$pro_dic->name}}
                        <div class="dropdown">
                            <button class="btn btn-flat {{$statusColors[$pro_dic->status]}} dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                @if($pro_dic->status == 0)
                                في انتظار التفعيل
                                @elseif($pro_dic->status == 1)
                                مفعل
                                @else
                                موقوف
                                @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                @if($pro_dic->status != 1 )
                                <li role="presentation"><a href="{{url('/admin/productapprove/' . $pro_dic->id . '/1'  )}}" role="menuitem" tabindex="-1" id="edit">تفعيل</a></li>
                                @if($pro_dic->status != 2 )
                                <li role="presentation"><a href="{{url('/admin/productapprove/' . $pro_dic->id . '/2'  )}}" role="menuitem" tabindex="-1" id="edit">ايقاف</a></li>
                                @endif
                                @else
                                <li role="presentation"><a href="{{url('/admin/productapprove/' . $pro_dic->id . '/2'  )}}" role="menuitem" tabindex="-1" id="edit">ايقاف</a></li>
                                @endif

                            </ul>
                        </div>
                    </br>
                        <div>
                            <a href="{{url('/notifyvendorproduct/' . $pro_dic->id)}}" class="btn btn-flat btn-info ">
                                تنبيه مزود الخدمة
                            </a>
                        </div>
                        </br>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{-- <form action="{{URL('vendors/product/update')}}" method="post" class="form-horizontal"> --}}
                    <form action="{{URL('admin/update_product')}}" method="post" class="form-horizontal">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="id" value="{{$pro_dic->id}}">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">رقم المنتج

                                </label>
                                <div class="col-md-4">
                                    <input type="text" min='0' name="name" data-required="1"  placeholder="الاسم" value="{{$pro_dic->id}}" class="form-control" disabled />
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">اسم المنتج

                                </label>
                                <div class="col-md-4">
                                    <input type="text" min='0' name="name" data-required="1"  placeholder="الاسم" value="{{$pro_dic->name}}" class="form-control" disabled /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">سعر المنتج

                                </label>
                                <div class="col-md-4">
                                    <input type="number" min='0' name="price" data-required="1" value="{{$pro_dic->price}}"  placeholder="سعر المنتج" class="form-control"  disabled/> </div>س.ر
                            </div>
                            {{-- <div class="form-group">
                                <label class="control-label col-md-3">العدد المتاح

                                </label>
                                <div class="col-md-4">
                                    <input value="{{$pro_dic->max_num}}" type="number" name="max_num" data-required="1"  placeholder="العدد المتاح" class="form-control" disabled/> </div>
                            </div> --}}
                            <div class="form-group">
                                <label class="control-label col-md-3">نوع الخدمه

                                </label>
                                <div class="col-md-4 control-label">

                                    {{-- <input value="{{$userCategories}}" class="form-control"/> --}}

                                    <select name="cat_id" required>
                                        @foreach($categories as $key => $value)
                                            <option value="{{$key}}" {{ ($pro_dic->cat_id == $key)?'selected':''}}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                           {{--  <div class="form-group">
                                <label class="control-label col-md-3">وقت التحضير</label>

                                <div class="col-md-3">
                                    <div class="input-icon">

                                        <input  value="{{$pro_dic->prepration_time}}" name="prepration_time" type="text" class="form-control timepicker timepicker-default" disabled> </div>
                                </div>
                            </div> --}}
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">معلومات المنتج

                                    </label>
                                    <div class="col-md-4">
                                        <textarea type="text" name="desc" data-required="1"  placeholder="ملاحظات" class="form-control" disabled />{{$pro_dic->desc}}</textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">مقدم الخدمه
                                    </label>
                                    <div class="col-md-4">
                                        <select class="form-control select2me" name="gender" disabled>
                                            <option>اختر..</option>
                                            <option value="0" {{$pro_dic->gender == 0?'selected':''}}>رجال</option>
                                            <option value="1" {{$pro_dic->gender == 1?'selected':''}}>نساء</option>
                                            <option value="2" {{$pro_dic->gender == 2?'selected':''}}>رجال ونساء</option>
                                            <option value="3" {{$pro_dic->gender == 3?'selected':''}}>لا يحتاج مقدمي خدمة</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">مزود الخدمه

                                </label>
                                <div class="col-md-4">
                                    <input type="text" min='0' name="name" data-required="1"  placeholder="الاسم" value="{{$pro_dic['user']->user_name}}" class="form-control" disabled /> </div>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">المتطلبات

                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" name="requirement" value="{{$pro_dic->requirement}}" data-role="tagsinput" placeholder="المتطلبات" class="form-control" disabled/>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">صور المنتج
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        @foreach($pro_dic->images as $pics)
                                            <img width="300px"  src="{{$pics->pic}}"/>
                                        @endforeach

                                    </div>
                                    <div class="col-md-4">
                                      <img width="300px"  src="{{$pro_dic->img}}"/>

                                    </div>
                                </div>
                            </div>-->
                            <!-- lens options start -->
                            <section id="lens">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-4">
                                        <div class="large-5 column" style="width: 100%;">
                                            <div class="xzoom-container">
                                                <!--<img class="xzoom3" src="" xoriginal="images/gallery/original/01_b_car.jpg" />-->
                                                <div style="width:400px">
                                                    <img class="xzoom3" src="{{$pro_dic->img}}" xoriginal="{{$pro_dic->img}}"  />
                                                </div>
                                                <div class="xzoom-thumbs">
                                                    <div style="display: inline">
                                                        <i class="fa fa-check-circle" style="color:green" ></i>
                                                        <a href="{{$pro_dic->img}}"><img class="xzoom-gallery3" style="max-height: 50px;" width="80" src="{{$pro_dic->img}}"  xpreview="{{$pro_dic->img}}" ></a>
                                                    </div>
                                                    @foreach($pro_dic->images as $pics)
                                                    <div id="productImg-{{$pics->id}}" style="display: inline">

                                                        <a href="{{$pics->pic}}"><img class="xzoom-gallery3" style="max-height: 50px;" width="80" src="{{$pics->pic}}"  xpreview="{{$pics->pic}}" ></a>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="large-7 column"></div>
                                    </div>

                                </div>
                            </section>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>

                                                <span class="long">افطار</span>

                                            </th>
                                            <th>

                                                <span class="long">عشاء</span>

                                            </th>
                                            <th>

                                                <span class="long">سحور</span>

                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($weekDays as $k => $v)
                                        <tr>
                                            <td class="hour" rowspan="6"><span>{{$v}}</span></td>
                                            <td>رجال</td>
                                            <td>رجال</td>
                                            <td>رجال</td>
                                        </tr>
                                        <tr>

                                            <td><input type="number" min='0' name="qunt[{{$k}}][1][1]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][1][1])) {{ $availablePeriodesProduct[$k][1][1] }} @else {{0}} @endif disabled /></td>
                                            <td><input type="number" min='0' name="qunt[{{$k}}][1][2]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][1][2])) {{ $availablePeriodesProduct[$k][1][2] }} @else {{0}} @endif disabled /> </td>
                                            <td><input type="number" min='0' name="qunt[{{$k}}][1][3]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][1][3])) {{ $availablePeriodesProduct[$k][1][3] }} @else {{0}} @endif disabled /></td>
                                        </tr>
                                        <tr>
                                            <td>نساء</td>
                                            <td>نساء</td>
                                            <td>نساء</td>
                                        </tr>
                                        <tr>
                                            <td><input type="number" min='0' name="qunt[{{$k}}][2][1]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][2][1])) {{ $availablePeriodesProduct[$k][2][1] }} @else {{0}} @endif disabled /></td>
                                            <td><input type="number" min='0' name="qunt[{{$k}}][2][2]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][2][2])) {{ $availablePeriodesProduct[$k][2][2] }} @else {{0}} @endif disabled /> </td>
                                            <td><input type="number" min='0' name="qunt[{{$k}}][2][3]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][2][3])) {{ $availablePeriodesProduct[$k][2][3] }} @else {{0}} @endif disabled /></td>
                                        </tr>
                                        <tr>
                                            <td>غير محدد</td>
                                            <td>غير محدد</td>
                                            <td>غير محدد</td>
                                        </tr>
                                        <tr>
                                            <td><input type="number" min='0' name="qunt[{{$k}}][3][1]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][3][1])) {{ $availablePeriodesProduct[$k][3][1] }} @else {{0}} @endif disabled /></td>
                                            <td><input type="number" min='0' name="qunt[{{$k}}][3][2]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][3][2])) {{ $availablePeriodesProduct[$k][3][2] }} @else {{0}} @endif disabled /> </td>
                                            <td><input type="number" min='0' name="qunt[{{$k}}][3][3]" class="form-control" value=@if(isset($availablePeriodesProduct[$k][3][3])) {{ $availablePeriodesProduct[$k][3][3] }} @else {{0}} @endif disabled /></td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <input type="submit" value="تعديل">
                    </form>
                </div>
            </div>
        </div>
</div>
                </div>
                </form>
            </div>
        </div>
</div>
</div>


@endsection
@section('footer')
@parent
<script type="text/javascript" src="{{asset('/assets/js/xzoom/xzoom.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/js/hammer.js/1.0.5/jquery.hammer.min.js')}}"></script>
<script src="{{asset('/assets/js/xzoom/foundation.min.js')}}"></script>

<script type="text/javascript">

    $(function(){
//        console.log("ddd");
        $('.xzoom3, .xzoom-gallery3').xzoom({position: 'lens', lensShape: 'circle', sourceClass: 'xzoom-hidden'});
        var isTouchSupported = 'ontouchstart' in window;

        if (isTouchSupported) {
            //If touch device
            $('.xzoom3').each(function () {
                var xzoom = $(this).data('xzoom');
                xzoom.eventunbind();
            });

            $('.xzoom3').each(function () {
                var xzoom = $(this).data('xzoom');
                $(this).hammer().on("tap", function (event) {
                    event.pageX = event.gesture.center.pageX;
                    event.pageY = event.gesture.center.pageY;
                    var s = 1, ls;

                    xzoom.eventmove = function (element) {
                        element.hammer().on('drag', function (event) {
                            event.pageX = event.gesture.center.pageX;
                            event.pageY = event.gesture.center.pageY;
                            xzoom.movezoom(event);
                            event.gesture.preventDefault();
                        });
                    }

                    xzoom.eventleave = function (element) {
                        element.hammer().on('tap', function (event) {
                            xzoom.closezoom();
                        });
                    }
                    xzoom.openzoom(event);
                });
            });
        }else {
            //If not touch device

            //Integration with fancybox plugin
            $('#xzoom-fancy').bind('click', function(event) {
                var xzoom = $(this).data('xzoom');
                xzoom.closezoom();
                $.fancybox.open(xzoom.gallery().cgallery, {padding: 0, helpers: {overlay: {locked: false}}});
                event.preventDefault();
            });

            //Integration with magnific popup plugin
            $('#xzoom-magnific').bind('click', function(event) {
                var xzoom = $(this).data('xzoom');
                xzoom.closezoom();
                var gallery = xzoom.gallery().cgallery;
                var i, images = new Array();
                for (i in gallery) {
                    images[i] = {src: gallery[i]};
                }
                $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                event.preventDefault();
            });
        }


    });


</script>
@endsection
