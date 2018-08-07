@extends('layouts.adminv2')
@section('title')
    التحويلات البنكيه
@endsection
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

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-box ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <h4 class="header-title m-t-0 m-b-30">التحويلات البنكيه</h4>
                    </div>
                </div>
                <div class="card-box ">
                    <br><br>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th> رقم الطلب</th>
                            <th> اكتمال|استرجاع</th>
                            <th>  حاله التحويل</th>
                            <th> طريقة الدفع</th>
                            <th> عنوان التحويل</th>
                            <th> اسم العميل</th>
                            <th> تم انشائه</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($payment as $key => $payments)
                            <tr>
                                <td>{{@++$key}}</td>
                                <td>{{@$payments->tran_order_number}}</td>
                                <td>
                                    @if($payments->tran_status == 0 )
                                    <a href="{{URL('/admin/purchase',@$payments->tran_order_number)}}"
                                       class="btn btn-flat btn-success btn-block" role="menuitem" tabindex="-1"
                                       id="edit" href="">اكتمال الطلب</a>

                                    </br>
                                        <a href="{{URL('/admin/refund',@$payments->tran_order_number)}}"
                                           class="btn btn-flat btn-danger btn-block" role="menuitem" tabindex="-1" id="edit"
                                           href="">استرجاع التحويل</a>

                                    @elseif($payments->tran_status == 1 )
                                        <a href="{{URL('/admin/refund',@$payments->tran_order_number)}}"
                                       class="btn btn-flat btn-danger btn-block" role="menuitem" tabindex="-1" id="edit"
                                       href="">استرجاع التحويل</a>
                                  @endif
                                </td>
                                <td>
                                    @if($payments->tran_status == 0 )
                                        <a href="#"
                                           class="btn btn-flat btn-info btn-block" role="menuitem" tabindex="-1"
                                           id="edit" href="">قيد الانتظار</a>
                                    @elseif($payments->tran_status == 1)
                                        </br>
                                        <a href="#"
                                           class="btn btn-flat btn-success btn-block" role="menuitem" tabindex="-1"
                                           id="coupon" href="">اكتمل الدفع</a>
                                        </br>
                                        @elseif($payments->tran_status == 2)
                                        </br>
                                        <a href="#"
                                           class="btn btn-flat btn-warning btn-block" role="menuitem" tabindex="-1"
                                           id="coupon" href="">تم استرجاع التحويل</a>
                                        </br>
                                    @endif

                                </td>
                                <td class="center">
                                    {{$payments->tran_type}}
                                </td>
                                <td>{{$payments->tran_ip}}</td>
                                <td>{{$payments->tran_username}}</td>
                                <td>
                                    {{date("d M Y", strtotime(@$payments->tran_created))}}
                                    <br>
                                    {{date("g:iA", strtotime(@$payments->tran_created))}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection