@extends('layouts.admin')
@section('title')
    جميع المنتجات
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
        <div class="card-box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <h4 class="header-title m-t-0 m-b-30">جميع المنتجات</h4>
                </div>
            </div>
            <div class="card-box">
                <div class="table-toolbar">
                    <div class="row">
                    </div>
                </div>
                <br>
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th> رقم المنتج </th>
                            <th> اسم المنتج </th>
                            <!--<th> العدد المتاج </th>-->
                            <th> سعر المنتج </th>
                            <th> صور المنتج </th>
                            <th> صوره رئيسيه </th>
                            <th> نوع الخدمه </th>
                            {{-- <th> وقت التحضير </th> --}}
                            <th> تم انشائه </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendor as $vendors)
                            <tr>
                                <td>{{@++$key}}</td>
                                <td> {{$vendors->product_id}} </td>
                                <td> {{$vendors->product_name}} </td>
                                <!--<td>
                                    @if($vendors->product_num == 0)
                                        <div class="alert alert-danger">
                                            <b>هذا المنتج لقد نفذ</b>
                                        </div>
                                    @else
                                        {{$vendors->product_num}}
                                    @endif
                                </td>-->
                                <td> {{round($vendors->product_price , 2)}} {{$currRatio}} </td>
                                <td>
                                    @foreach($vendors->images as $pics)
                                        <img width="50px" height="50px" src="{{$pics->pic}}"/>
                                    @endforeach
                                </td>
                                <td><img width="50px" height="50px" src="{{$vendors->product_pic_cover}}"/></td>
                                <td>{{$vendors->products_cat_name}}</td>
                                {{-- <td>

                                    {{$vendors->preperationHour}} ساعة
                                    {{$vendors->preperationMin}} دقيقه

                                </td> --}}
                                <td class="center">
                                    {{date("d M Y", strtotime($vendors->product_created))}}
                                    <br>
                                    {{date("g:iA", strtotime($vendors->product_created))}}
                                </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
@endsection
