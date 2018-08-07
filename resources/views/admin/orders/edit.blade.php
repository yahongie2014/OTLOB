@extends('layouts.adminv2')
@section('title')
 | عرض الطلب
@endsection
@section('content')
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
    table tbody tr:nth-child(4n+0) td {
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
    <div class="col-md-6">
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>  بيانات المنتج

            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="{{URL('vendors/product/update')}}" method="post" class="form-horizontal">
                    <!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->


                    <div class="form-body">
                        <div align="left" class="form-group">
                            @if(@$details->status == 0 || @$details->status == 1 || @$details->status == 2)
                                <div class="dropdown col-md-3">
                                    <button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        قبول / رفض<span class="caret"></span>
                                    </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <li role="presentation"><a href="{{URL('/vendors/acceptitemorder',@$details->id)}}" role="menuitem" tabindex="-1" id="edit" href="">قبول</a></li>
                                            <li role="presentation"><a href="{{URL('/vendors/refuseitemorder',@$details->id)}}" role="menuitem" tabindex="-1" id="edit" href="">رفض</a></li>
                                        </ul>
                                </div>
                            @endif
                            {{-- @if(Auth::user()->is_admin) --}}
                                <div class="dropdown col-md-3">
                                    <li class="btn btn-flat">
                                        <a href="{{URL('/admin/sendLocation',@$details->id)}}" role="menuitem" tabindex="-1">
                                            إرسال العنوان لمزود الخدمة
                                        </a>
                                    </li>
                                </div>
                                <div class="dropdown col-md-3">
                                    <li class="btn btn-flat">
                                        <a href="https://www.google.com/maps/place?q={{$details->order_lat}},{{$details->order_long}}" target="_blank">
                                            موقع العميل
                                        </a>
                                    </li>
                                </div>
                            {{-- @endif --}}
                            @if(Auth::user()->id == 1 && $details->status >= 3)
                                <div class="dropdown col-md-3">
                                    <button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        حالة الطلب
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        @if($details->status < 3)
                                            <li role="presentation"><a href="{{URL('/vendors/started',$details->id)}}" role="menuitem" tabindex="-1" id="edit" href="">قيد الانتظار</a></li>
                                        @endif
                                        @if($details->status < 5)
                                            <li role="presentation"><a href="{{URL('/vendors/Prepare',$details->id)}}" role="menuitem" tabindex="-1" id="coupon" href="">قيد التحضير</a></li>
                                        @endif
                                        {{-- <li role="presentation"><a href="{{URL('/vendors/processing',$details->id)}}" role="menuitem" tabindex="-1" id="coupon" href="">قيد التجهيز</a></li> --}}
                                        @if($details->status < 7 && $details->status != 7)
                                            <li role="presentation"><a href="{{URL('/vendors/Completed',$details->id)}}" role="menuitem" tabindex="-1" id="coupon" href="">مكتمل</a></li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">اسم المنتج

                            </label>
                            <div class="col-md-8">
                                <input type="text" min='0' name="name" data-required="1"  placeholder="الاسم" value="{{$details->products->name}}" class="form-control" disabled />
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">نوع مقدم الخدمة

                            </label>
                            <div class="col-md-8">
                                <input type="text" min='0' name="proType" data-required="1"  placeholder="الاسم" value="@if($details->gender == 'male')رجال  @elseif($details->gender == 'female') نساء @else لا يحتاج مقدم خدمة @endif" class="form-control" disabled /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">العنوان

                            </label>
                            <div class="col-md-8">
                                <input type="text"  name="orderaddress"  value="{{$details->address}}"  class="form-control"  disabled/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">الفترة

                            </label>
                            <div class="col-md-8">
                                <input value="{{$details->time}}" type="text"  class="form-control" disabled/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">التاريخ

                            </label>
                            <div class="col-md-8">

                                <input value="{{$details->date}}" type="text"  class="form-control" disabled/> </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">الكمية</label>

                            <div class="col-md-8">
                                <div class="input-icon">

                                    <input value="{{$details->amount}}" type="text"  class="form-control" disabled/>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">السعر</label>

                            <div class="col-md-8">
                                <div class="input-icon">

                                    <input value="{{$details->total}}" type="text"  class="form-control" disabled/>
                                </div>
                            </div>

                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-4">العنوان

                                </label>
                                <div class="col-md-8">
                                    <textarea  class="form-control" disabled />{{$details->address}}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-4">ملاحظات

                                </label>
                                <div class="col-md-8">
                                    <textarea  class="form-control" disabled />{{$details->notes}}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>  بيانات مزود الخدمة
                </div>

            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="{{URL('vendors/product/update')}}" method="post" class="form-horizontal">
                    <!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->


                    <div class="form-body">
                        <div align="left" class="form-group">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">الإسم
                            </label>
                            <div class="col-md-8">
                                <input type="text" min='0' name="name" data-required="1"  placeholder="الاسم" value="{{$details->products['user']->user_name}}" class="form-control" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">الهاتف

                            </label>
                            <div class="col-md-8">
                                <input type="text" min='0' name="proType" data-required="1"  placeholder="الاسم" value="{{$details->products['user']->phone}}" class="form-control" disabled /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">البريد الالكتروني

                            </label>
                            <div class="col-md-8">
                                <input type="text"  name="orderaddress"  value="{{$details->products['user']->email}}"  class="form-control"  disabled/> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--</div>
<div class="row">-->
    <div class="col-md-6">
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>  بيانات المستخدم

                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{URL('vendors/product/update')}}" method="post" class="form-horizontal">
                        <!--                        <input type="hidden" name="_token" value="{{ csrf_token() }}">-->


                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-4">الاسم

                                </label>
                                <div class="col-md-8">
                                    <input type="text" min='0' name="name" data-required="1"  placeholder="الاسم" value="{{$details->order->user->user_name}}" class="form-control" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">الهاتف

                                </label>
                                <div class="col-md-8">
                                    <input type="text" min='0' name="proType" data-required="1"  placeholder="الاسم" value="{{$details->order->user->phone}}" class="form-control" disabled /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">البريد الالكتروني

                                </label>
                                <div class="col-md-8">
                                    <input type="text"  name="orderaddress"  value="{{$details->order->user->email}}"  class="form-control"  disabled/> </div>
                            </div>

                        </div>

                </div>
                </form>
            </div>
        </div>
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> الخريطة

                </div>
                <div class="portlet-body form">
                    <div id="googleMap" style="width:100%;height:400px;"></div>
                </div>
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
<script>
    function myMap() {
//        var mapProp= {
//            center:new google.maps.LatLng({{$details->order_lat}},{{$details->order_long}}),
//            zoom:10,
//        };
//        var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
        var myCenter = new google.maps.LatLng({{$details->order_lat}},{{$details->order_long}});
        var mapCanvas = document.getElementById("googleMap");
        var mapOptions = {center: myCenter, zoom: 15};
        var map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({position:myCenter});
        marker.setMap(map);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgIKx-8qqL3I3a-cVETwnf2UbgVzm1zus&callback=myMap"></script>
@endsection