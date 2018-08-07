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
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <br>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th> رقم الطلب </th>
                            <th> المنتج </th>
                            <th> الكميه </th>
                            <th> حاله الطلب </th>
                            <th> تأطيد الطلب </th>
                            <th> اسم العميل </th>
                            <th> تم انشائه </th>
                            <th> قبول|رفض </th>
                            <th> تعديل حاله الطلب </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(Auth::User()->is_vendor == 1)
                            @foreach($order_vendor as $vendors)
                                <tr>
                                    <td> # {{$vendors->ord_number}} </td>
                                    <td> {{$vendors->ord_name}}</td>
                                    <td>{{$vendors->ord_qty}}</td>
                                    <td>
                                        @if($vendors->ord_status == 1)
                                            <div class="alert alert-warning">
                                                <b>Request Pending</b>
                                            </div>
                                        @elseif($vendors->ord_status == 2)
                                            <div class="alert alert-warning">
                                                <b>Customer paid</b>
                                            </div>
                                        @elseif($vendors->ord_status == 3)
                                            <div class="alert alert-success">
                                                <b>Request accepted</b>
                                            </div>
                                        @elseif($vendors->ord_status == 4)
                                            <div class="alert alert-danger">
                                                <b>Request Refused</b>
                                            </div>
                                        @elseif($vendors->ord_status == 5)
                                            <div class="alert alert-success">
                                                <b>Request in perpareing</b>
                                            </div>
                                        @elseif($vendors->ord_status == 6)
                                            <div class="alert alert-success">
                                                <b>Request processing</b>
                                            </div>
                                        @elseif($vendors->ord_status == 7)
                                            <div class="alert alert-success">
                                                <b>Request Completed</b>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($vendors->ord_status == 3 || $vendors->ord_status == 5 || $vendors->ord_status == 6 || $vendors->ord_status == 7)
                                            <div class="alert alert-success">
                                                <b>مقبول</b>
                                            </div>
                                        @elseif($vendors->ord_status == 4)
                                            <div class="alert alert-danger">
                                                <b>مرفوض</b>
                                            </div>
                                        @elseif($vendors->ord_status == 2)
                                            <div class="alert alert-warning">
                                                <b>راجع حسابك مع البنك</b>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{$vendors->ord_user}}</td>
                                    <td class="center">
                                        {{date("d M Y", strtotime($vendors->ord_time_created))}}
                                        <br>
                                        {{date("g:iA", strtotime($vendors->ord_time_created))}}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                                التأكيد<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                <li role="presentation"><a href="{{URL('/vendors/accept',$vendors->ord_id)}}" role="menuitem" tabindex="-1" id="edit" href="">قبول</a></li>
                                                <li role="presentation"><a href="{{URL('/vendors/refuse',$vendors->ord_id)}}" role="menuitem" tabindex="-1" id="edit" href="">رفض</a></li>
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
                                                @if($vendors->ord_status == 3 || $vendors->ord_status == 5 || $vendors->ord_status == 6 || $vendors->ord_status == 7)
                                                    <li role="presentation"><a href="{{URL('/vendors/started',$vendors->ord_id)}}" role="menuitem" tabindex="-1" id="edit" href="">Pending</a></li>
                                                    {{--<li role="presentation"><a href="{{URL('/vendors/inprogress',$vendors->ord_id)}}" role="menuitem" tabindex="-1" id="history" href="">Paid</a></li>--}}
                                                    <li role="presentation"><a href="{{URL('/vendors/Prepare',$vendors->ord_id)}}" role="menuitem" tabindex="-1" id="coupon" href="">Perpearing</a></li>
                                                    <li role="presentation"><a href="{{URL('/vendors/processing',$vendors->ord_id)}}" role="menuitem" tabindex="-1" id="coupon" href="">Processing</a></li>
                                                    <li role="presentation"><a href="{{URL('/vendors/Completed',$vendors->ord_id)}}" role="menuitem" tabindex="-1" id="coupon" href="">Completed</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        @else()
                            @foreach($order as $orders)
                                <tr>
                                    <td> # {{$orders->ord_number}} </td>
                                    <td>
                                   {{$orders->ord_name}}
                                    </td>

                                    <td>{{$orders->ord_qty}}</td>
                                    <td>
                                        @if($orders->ord_status == 1)
                                            <div class="alert alert-true bg-yellow">
                                                <b>Request Pending</b>
                                            </div>
                                        @elseif($orders->ord_status == 2)
                                            <div class="alert alert-warning">
                                                <b>Customer paid</b>
                                            </div>
                                        @elseif($orders->ord_status == 3)
                                            <div class="alert alert-success">
                                                <b>Request accepted</b>
                                            </div>
                                        @elseif($orders->ord_status == 4)
                                            <div class="alert alert-danger">
                                                <b>Request Refused</b>
                                            </div>
                                        @elseif($orders->ord_status == 5)
                                            <div class="alert alert-success">
                                                <b>Request in perpareing</b>
                                            </div>
                                        @elseif($orders->ord_status == 6)
                                            <div class="alert alert-success">
                                                <b>Request processing</b>
                                            </div>
                                        @elseif($orders->ord_status == 7)
                                            <div class="alert alert-success">
                                                <b>Request Completed</b>
                                            </div>
                                        @endif
                                    </td>

                                    </td>
                                    <td>
                                        @if($orders->ord_status == 3 || $orders->ord_status == 5 || $orders->ord_status == 6 || $orders->ord_status == 7)
                                            <div class="alert alert-success">
                                                <b>مقبول</b>
                                            </div>
                                        @elseif($orders->ord_status == 4)
                                            <div class="alert alert-danger">
                                                <b>مرفوض</b>
                                            </div>
                                        @elseif($orders->ord_status == 2)
                                            <div class="alert alert-warning">
                                                <b>راجع حسابك مع البنك</b>
                                            </div>
                                        @endif
                                    </td>

                                    <td>{{$orders->ord_user}}</td>
                                    <td class="center">
                                        {{date("d M Y", strtotime($orders->ord_time_created))}}
                                        <br>
                                        {{date("g:iA", strtotime($orders->ord_time_created))}}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                                التأكيد<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                <li role="presentation"><a href="{{URL('/admin/accept',$orders->ord_id)}}" role="menuitem" tabindex="-1" id="edit" href="">قبول</a></li>
                                                <li role="presentation"><a href="{{URL('/admin/refuse',$orders->ord_id)}}" role="menuitem" tabindex="-1" id="edit" href="">رفض</a></li>
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
                                                @if($orders->ord_status == 3 || $orders->ord_status == 5 || $orders->ord_status == 6 || $orders->ord_status == 7)
                                                    <li role="presentation"><a href="{{URL('/admin/started',$orders->ord_id)}}" role="menuitem" tabindex="-1" id="edit" href="">Pending</a></li>
                                                    {{--<li role="presentation"><a href="{{URL('/admin/inprogress',$orders->ord_id)}}" role="menuitem" tabindex="-1" id="history" href="">Paid</a></li>--}}
                                                    <li role="presentation"><a href="{{URL('/admin/Prepare',$orders->ord_id)}}" role="menuitem" tabindex="-1" id="coupon" href="">Perpearing</a></li>
                                                    <li role="presentation"><a href="{{URL('/admin/processing',$orders->ord_id)}}" role="menuitem" tabindex="-1" id="coupon" href="">Processing</a></li>
                                                    <li role="presentation"><a href="{{URL('/admin/Completed',$orders->ord_id)}}" role="menuitem" tabindex="-1" id="coupon" href="">Completed</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div></div>
@endsection
