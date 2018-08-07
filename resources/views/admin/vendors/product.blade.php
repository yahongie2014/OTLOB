@extends('layouts.adminv2')
@section('title')
منتجات العميل
@if(isset($vendor))
    {{$vendor->user_name}}
@endif
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
        @if(isset($status_count))
            @foreach($status_count as $k => $v)
            <div class="col-lg-4 col-md-6">
                <div class="card-box">

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1">
                            <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#f05050 "
                                   data-bgColor="#F9B9B9" value="{{$v->status_count}}"
                                   data-skin="tron" data-angleOffset="180" data-readOnly=true
                                   data-thickness=".15"/>
                        </div>

                        <div class="widget-detail-1">
                            <h2 class="p-t-10 m-b-0"> {{$v->status_count}} </h2>
                            <p class="text-muted">@if($v->status == 0)
                                في انتظار التفعيل
                                @elseif($v->status == 1)
                                مفعل
                                @else
                                موقوف
                                @endif</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <div class="portlet-title">

                </div>
                <div class="card-box table-responsive">

                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th> م. </th>
                            <th> رقم المنتج </th>
                            <th> اسم المنتج </th>
                            <th> النشاط </th>
                            <th> عرض </th>
                            <th> الحالة </th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($vendorsProducts as $k => $product)
                                <tr>

                                    <td> {{++$k}} </td>
                                    <td> {{$product->id}} </td>
                                    <td> {{$product->name}} </td>
                                    <td> {{$product['Category']->name}} </td>
                                    <td>
                                        <a href="{{url('/admin/getproduct/' . $product->id)}}" class="btn btn-info" role="button">عرض</a>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-flat {{$statusColors[$product->status]}} dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                                @if($product->status == 0)
                                                    في انتظار التفعيل
                                                @elseif($product->status == 1)
                                                مفعل
                                                @else
                                                موقوف
                                                @endif
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                @if($product->status != 1 )
                                                    <li role="presentation"><a href="{{url('/admin/productapprove/' . $product->id . '/1'  )}}" role="menuitem" tabindex="-1" id="edit">تفعيل</a></li>
                                                    @if($product->status != 2 )
                                                    <li role="presentation"><a href="{{url('/admin/productapprove/' . $product->id . '/2'  )}}" role="menuitem" tabindex="-1" id="edit">ايقاف</a></li>
                                                    @endif
                                                @else
                                                    <li role="presentation"><a href="{{url('/admin/productapprove/' . $product->id . '/2'  )}}" role="menuitem" tabindex="-1" id="edit">ايقاف</a></li>
                                                @endif

                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection
