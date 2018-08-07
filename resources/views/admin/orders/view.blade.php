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
            <div class="card-box table-responsive">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <h4 class="header-title m-t-0 m-b-30">جميع الطلبات</h4>
                    </div>
                </div>
                <div class="card-box table-responsive">
                    <button onclick="view_orders(1)" >الطلبات الجديده</button>
                    <button onclick="view_orders(2)">الطلبات المقبوله</button>
                    <button onclick="view_orders(3)">الطلبات المفروضه</button>
                    <br>
                    <table hidden id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th> رقم الطلب </th>
                            <th> المنتج </th>
                            <th> الكميه </th>
                            <th> حاله الطلب </th>
                            <th> تأكيد الطلب </th>
                            <th> طريقة الدفع </th>
                            <th> اسم العميل </th>
                            <th> تم انشائه </th>
                            <th> عرض </th>
                            <th> قبول|رفض </th>
                            <th> تعديل حاله الطلب </th>
                        </tr>
                        </thead>
                        <tbody id="order1" hidden>
                            @foreach($new_orders as $key => $order)
                                <tr>
                                    <td>{{@++$key}}</td>
                                    <td>{{@$order->order->order_id}}</td>
                                    <td>
                                        {{@$order->products->name}}
                                    </td>
                                    <td>
                                        {{@$order->amount}}
                                    </td>
                                    <td>
                                        @if(@$order->status == 1)
                                            <div class="alert alert-warning">
                                                <b>قيد الانتظار</b>
                                            </div>
                                        @elseif(@$order->status == 2)
                                            <div class="alert alert-info">
                                                <b>تم الدفع</b>
                                            </div>
                                        @elseif(@$order->status == 3)
                                            <div class="alert alert-warning">
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
                                                <b>راجع حسابك مع البنك</b>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->order->payment_type == 0)
لم يتم الدفع
                                        @elseif($order->order->payment_type == 1)
عند الاستلام
                                        @elseif($order->order->payment_type == 2)
بنك
                                        @elseif($order->order->payment_type == 3)
مندوب
                                        @endif
                                    </td>
                                    <td>{{@$order->order->user['user_name']}}</td>
                                    <td class="center">
                                        {{date("d M Y", strtotime(@$order->created_at))}}
                                        <br>
                                        {{date("g:iA", strtotime(@$order->created_at))}}
                                    </td>
                                    <td>
                                        <div style="margin: 3px">
                                            <a href="{{url('/orderdetails/' . @$order->id)}}" class="btn btn-info" role="button">عرض</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                                التأكيد<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                <li role="presentation"><a href="{{URL('/vendors/acceptitemorder',@$order->id)}}" role="menuitem" tabindex="-1" id="edit" href="">قبول</a></li>
                                                <li role="presentation"><a href="{{URL('/vendors/refuseitemorder',@$order->id)}}" role="menuitem" tabindex="-1" id="edit" href="">رفض</a></li>
                                            </ul>
                                        </div>


                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                                حاله الطلب
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                @if($order->status == 3 || $order->status == 5 || $order->status == 6 || $order->status == 7)
                                                    <li role="presentation"><a href="{{URL('/vendors/started',$order->id)}}" role="menuitem" tabindex="-1" id="edit" href="">قيد الانتظار</a></li>
                                                    {{--<li role="presentation"><a href="{{URL('/vendors/inprogress',$vendors->ord_id)}}" role="menuitem" tabindex="-1" id="history" href="">مدفوع</a></li>--}}
                                                    <li role="presentation"><a href="{{URL('/vendors/Prepare',$order->id)}}" role="menuitem" tabindex="-1" id="coupon" href="">قيد التحضير</a></li>
                                                    <li role="presentation"><a href="{{URL('/vendors/processing',$order->id)}}" role="menuitem" tabindex="-1" id="coupon" href="">قيد التجهيز</a></li>
                                                    <li role="presentation"><a href="{{URL('/vendors/Completed',$order->id)}}" role="menuitem" tabindex="-1" id="coupon" href="">مكتمل</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        
                        </tbody>
                        <tbody id="order2" hidden>
                            @foreach($accepted_orders as $key => $order)
                                <tr>
                                    <td>{{@++$key}}</td>
                                    <td>{{@$order->order->id}}</td>
                                    <td>
                                        {{@$order->products->name}}
                                    </td>
                                    <td>
                                        {{@$order->amount}}
                                    </td>
                                    <td>
                                        @if(@$order->status == 1)
                                            <div class="alert alert-warning">
                                                <b>قيد الانتظار</b>
                                            </div>
                                        @elseif(@$order->status == 2)
                                            <div class="alert alert-info">
                                                <b>تم الدفع</b>
                                            </div>
                                        @elseif(@$order->status == 3)
                                            <div class="alert alert-warning">
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
                                                <b>راجع حسابك مع البنك</b>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->order->payment_type == 0)
لم يتم الدفع
                                        @elseif($order->order->payment_type == 1)
عند الاستلام
                                        @elseif($order->order->payment_type == 2)
بنك
                                        @elseif($order->order->payment_type == 3)
مندوب
                                        @endif
                                    </td>
                                    <td>{{@$order->order->user['user_name']}}</td>
                                    <td class="center">
                                        {{date("d M Y", strtotime(@$order->created_at))}}
                                        <br>
                                        {{date("g:iA", strtotime(@$order->created_at))}}
                                    </td>
                                    <td>
                                        <div style="margin: 3px">
                                            <a href="{{url('/orderdetails/' . @$order->id)}}" class="btn btn-info" role="button">عرض</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                                التأكيد<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                <li role="presentation"><a href="{{URL('/vendors/acceptitemorder',@$order->id)}}" role="menuitem" tabindex="-1" id="edit" href="">قبول</a></li>
                                                <li role="presentation"><a href="{{URL('/vendors/refuseitemorder',@$order->id)}}" role="menuitem" tabindex="-1" id="edit" href="">رفض</a></li>
                                            </ul>
                                        </div>


                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-to