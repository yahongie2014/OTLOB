@extends('layouts.adminv2')
@section('title')
    جميع الطلبات
@endsection
@section('content')

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



<div class="row">
    <div class="col-md-12">
        <div class="card-box ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <h4 class="header-title m-t-0 m-b-30">{{$page_title}}</h4>
                </div>
            </div>
            <div class="card-box">
                @if(is_null($today))
                <div align="center">
                    <a href="{{URL((Auth::user()->is_vendor)?'/vendors/orders/view/0':'/admin/orders/view/0')}}" class="order-status-date">
                        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5 ">
                            جميع الطلبات
                        </button>
                    </a>
                    <a href="{{URL((Auth::user()->is_vendor)?'/vendors/orders/view/4':'/admin/orders/view/4')}}" class="order-status-date">
                        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5 ">
                            الطلبات المرفوضة
                        </button>
                    </a>
                    <a href="{{URL((Auth::user()->is_vendor)?'/vendors/orders/view/3':'/admin/orders/view/3')}}" class="order-status-date">
                        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5 ">
                            الطلبات المقبولة
                        </button>
                    </a>
                    <a href="{{URL((Auth::user()->is_vendor)?'/vendors/orders/view/1':'/admin/orders/view/1')}}" class="order-status-date">
                        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5 ">
                            قيد الإنتظار
                        </button>
                    </a>
                    <a href="{{URL((Auth::user()->is_vendor)?'/vendors/orders/view/5':'/admin/orders/view/5')}}" class="order-status-date">
                        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5 ">
                            الطلبات الجاري تحضيرها
                        </button>
                    </a>
                    <a href="{{URL((Auth::user()->is_vendor)?'/vendors/orders/view/6':'/admin/orders/view/6')}}" class="order-status-date">
                        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5 ">
                            الطلبات الجاري تجهيزها
                        </button>
                    </a>
                    <a href="{{URL((Auth::user()->is_vendor)?'/vendors/orders/view/7':'/admin/orders/view/7')}}" class="order-status-date">
                        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
                            الطلبات المكتملة
                        </button>
                    </a>
                    <!--<input id="datepickers" data-provide="datepicker">-->
                </div>
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="control-label mb-10 text-left">تاريخ الطلب</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' onkeydown="return false"  class="form-control" id="datepickers" data-provide="datepicker" value=@if($orderDate) "{{$orderDate}}" @else "" @endif />
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label class="control-label mb-10 text-left"> </label>
                                <div >
                                    <a href="#" id="orderDateClear" class="btn btn-danger btn-rounded">
                                        مسح
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                @endif
                <br><br>
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th width='2%'> رقم الطلب </th>
                        <th width='5%'> قبول|رفض </th>
                        <th width='5%'> تعديل حاله الطلب </th>
                        <th width='10%'> المنتج </th>
                        <th width='2%'> الكميه </th>
                        <th width='10%'> حاله الطلب </th>
                        <th width='5%'> تأكيد الطلب </th>
                        <th width='5%'> طريقة الدفع </th>
                        <th width='10%'> اسم العميل </th>
                        <th width='5%'> تم انشائه </th>
                        @if(Auth::user()->is_admin)
                            <th width='10%'> تنبيه </th>
                        @endif
                        @if(Auth::user()->id == 1)
                            <th width='5%'> حذف </th>
                        @endif
                        {{-- <th> عرض </th> --}}

                    </tr>
                    </thead>

                    <tbody>
                        @foreach(@$orders as $key => $order)
                            <tr>
                                <td>{{@++$key}}</td>
                                <td>{{@$order->order->order_id}}</td>
                                <td>
                                    @if($order->status == 0 || $order->status == 1 || $order->status == 2)
                                    <a href="{{URL('/vendors/acceptitemorder',@$order->id)}}" class="btn btn-flat btn-success btn-block" role="menuitem" tabindex="-1" id="edit" href="">قبول</a>

                                    </br>
                                    <a href="{{URL('/vendors/refuseitemorder',@$order->id)}}" class="btn btn-flat btn-danger btn-block" role="menuitem" tabindex="-1" id="edit" href="">رفض</a>
                                    @endif
                                </td>

                                <td>
                                    @if($order->status == 1 || $order->status == 2 || $order->status == 3 || $order->status == 5 || $order->status == 6 || $order->status == 7)
                                        @if($order->status <= 3)
                                            <a href="{{URL('/vendors/started',$order->id)}}" class="btn btn-flat btn-info btn-block" role="menuitem" tabindex="-1" id="edit" href="">قيد الانتظار</a>
                                        @endif
                                        </br>
                                        @if($order->status <= 5)
                                            <a href="{{URL('/vendors/Prepare',$order->id)}}" class="btn btn-flat btn-warning btn-block" role="menuitem" tabindex="-1" id="coupon" href="">قيد التحضير</a>
                                        @endif
                                        </br>
                                        @if($order->status != 7 )
                                            <a href="{{URL('/vendors/Completed',$order->id)}}" class="btn btn-flat btn-success btn-block" role="menuitem" tabindex="-1" id="coupon" href="">مكتمل</a>
                                        @endif
                                    @endif
                                </td>

                                <td align="center">
                                    <a href="{{url('/orderdetails/' . @$order->id)}}" class="btn" role="button">
                                        {{mb_substr(@$order->products->name, 0 , 30, 'UTF-8')}}
                                        {{(strlen(@$order->products->name) > 30)? '...' : ''}}
                                    </a>
                                </td>
                                <td>
                                    {{@$order->amount}}
                                </td>
                                <td>
                                    @if(@$order->status == 1)
                                        <div class="alert alert-dark">
                                            <b>الطلب قيد الانتظار</b>
                                        </div>
                                    @elseif(@$order->status == 2)
                                        <div class="alert alert-info">
                                            <b>تم اختيار وسيلة الدفع</b>
                                        </div>
                                    @elseif(@$order->status == 3)
                                        <div class="alert alert-success">
                                            <b>تم قبول الطلب</b>
                                        </div>
                                    @elseif(@$order->status == 4)
                                        <div class="alert alert-danger">
                                            <b>تم رفض الطلب</b>
                                        </div>
                                    @elseif(@$order->status == 5)
                                        <div class="alert alert-warning">
                                            <b>جاري تحضير الطلب</b>
                                        </div>
                                    @elseif(@$order->status == 6)
                                        <div class="alert alert-info">
                                            <b>جاري تجهيز الطلب</b>
                                        </div>
                                    @elseif(@$order->status == 7)
                                        <div class="alert alert-success">
                                            <b>تم اكتمال الطلب</b>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if(@$order->status == 3 || @$order->status == 5 || @$order->status == 6 || @$order->status == 7)
                                        <div class="alert alert-success">
                                            <b>مقبول</b>
                                        </div>
                                    @elseif(@$order->status == 4)
                                        <div class="alert alert-danger">
                                            <b>مرفوض</b>
                                        </div>
                                    @elseif(@$order->status == 2)
                                        <div class="alert alert-warning">
                                            <b>غير محدد</b>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($order->order->payment_type == 0)
                                        لم يتم اختيار وسيلة الدفع
                                    @elseif($order->order->payment_type == 1)
                                        الدفع عند الاستلام
                                    @elseif($order->order->payment_type == 2)
                                        الدفع عن طريق البنك
                                    @elseif($order->order->payment_type == 3)
                                        الدفع عن طريق مندوب
                                    @endif
                                </td>
                                <td>
                                    @if(Auth::user()->is_vendor)
                                        {{@$order->order->user['user_name']}}
                                    @elseif(Auth::user()->is_admin)
                                        {{@$order->order->user['user_name']}}
                                    @else

                                    @endif
                                </td>
                                <td class="center">
                                    {{date("d M Y", strtotime(@$order->created_at))}}
                                    <br>
                                    {{date("g:iA", strtotime(@$order->created_at))}}
                                </td>
                                @if(Auth::user()->is_admin)
                                    <td>
                                        @if($order->status == 1 || $order->status == 2)
                                            <a href="{{url('/notifyvendor/' .@$order->id)}}" class="btn btn-flat btn-info btn-block">
                                                تنبيه مزود الخدمة
                                            </a>
                                        @endif
                                    </td>
                                @endif
                                @if(Auth::user()->id == 1)
                                    <td>
                                        <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{url('/admin/orders/delete/' .@$order->id)}}" >
                                            {{-- خدف --}}
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                @endif
                                {{-- <td>
                                    <div style="margin: 3px">
                                        <a href="{{url('/orderdetails/' . @$order->id)}}" class="btn btn-info" role="button">عرض</a>
                                    </div>
                                </td> --}}

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script>
    function view_orders(id){
        // $('table[name^="order"]').hide();
        // $('table[name="order'+id+'"]').show();
        $('#datatable-responsive').hide();
        $('tbody[id^="order"]').hide();
        $('#order'+id).show();
        $('#datatable-responsive').show();
    }
</script>
@endsection
@section('footer')
@parent
<script>
    $(document).ready(function() {
        $('#datepickers').datepicker({
            format : "yyyy-mm-dd",
        })
            .on("changeDate", function(e) {
                // `e` here contains the ex tra attributes
                var selectedDate = $(this).val();
                var url = window.location.href;
                url = url.split('?');
                console.log(selectedDate);
                window.location.href = url[0] + "?orderDate=" + selectedDate;
            });
        $('.order-status-date').click(function(){
            var url = $(this).attr('href');
            var selectedDate = $('#datepickers').val();
            if(selectedDate)
                url = url + "?orderDate=" + selectedDate;

            window.location.href = url;
            console.log($(this).attr('href'));
            return false;
        })

        $("#orderDateClear").click(function(){
            var url = window.location.href;
            url = url.split('?');

            window.location.href = url[0];
            return false
        });
        /*$("#datepickers").on('change',function(){
            var selectedDate = $(this).val();
            var url = window.location.href;
            console.log(selectedDate)
            //window.location.href = "http://stackoverflow.com";
        })*/
    })
</script>
@endsection