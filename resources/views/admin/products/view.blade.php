@extends('layouts.adminv2')
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
            <div class="card-box table-responsive">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <h4 class="header-title m-t-0 m-b-30">جميع المنتجات</h4>
                    </div>
                </div>
                <div class="card-box table-responsive">

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{URL('/product/add')}}">
                                        <button id="sample_تعديلable_1_new" class="btn green"> اضافه منتج جديد
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th> رقم المنتج </th>
                            <th> اسم المنتج </th>
                            <th> عدد المشاهدات </th>
                            <th> العدد المتاج </th>
                            <th> سعر المنتج </th>
                            <th> صور المنتج </th>
                            <th> صوره رئيسيه </th>
                            <th> نوع الخدمه </th>
                            {{-- <th> وقت التحضير </th> --}}
                            <th> تم انشائه </th>
                            <th> تعديل </th>
                            <th> حذف </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(Auth::User()->is_vendor == 1)
                            @foreach($vendor as $vendors)
                                <tr>
                                    <input type="hidden" name="id" value="<?= $vendors->product_id ?>">
                                    <td> {{$vendors->product_id}} </td>
                                    <td> {{$vendors->product_name}} </td>
                                    <td> {{$vendors->product_viewer}} </td>
                                    <td>
                                        @if($vendors->product_num == 0)
                                        <div class="alert alert-danger">
                                            <b>هذا المنتج لقد نفذ</b>
                                        </div>
                                        @else
                                            {{$vendors->product_num}}
                                        @endif
                                    </td>
                                    <td> {{$vendors->product_price}}س.ر </td>
                                    <td>
                                        @foreach($vendors->images as $pics)
                                            <img width="50px" height="50px" src="{{$pics->pic}}"/>
                                        @endforeach
                                    </td>
                                    <td><img width="50px" height="50px" src="{{$vendors->product_pic_cover}}"/></td>
                                    <td>{{$vendors->products_cat_name}}</td>
                                    <!-- <td>
                                        {{date("g:i", strtotime($vendors->product_time))}} دقيقه
                                    </td> -->
                                    <td class="center">
                                        {{date("d M Y", strtotime($vendors->product_created))}}
                                        <br>
                                        {{date("g:iA", strtotime($vendors->product_created))}}
                                    </td>
                                    <td><a class="تعديل" href="{{URL('/vendors/product/edit',$vendors->product_id)}}"> <i class="fa fa-edit"></i> </a></td>
                                    {{-- <td><a onclick="return confirm('Are you sure you want to delete this item?');" class="مسح" href="{{URL('/vendors/product/delete',$vendors->product_id)}}"> <i class="fa fa-trash"></i> </a></td> --}}
                                </tr>
                                </tr>
                            @endforeach
                        @else()
                            @foreach($product as $products)
                                <tr>
                                    <td> {{$products->product_id}} </td>
                                    <td> {{$products->product_name}} </td>
                                    <td> {{$products->product_viewer}} </td>
                                    <td>
                                    @if($products->product_num == 0)
                                        <div class="alert alert-danger">
                                            <b>هذا المنتج لقد نفذ</b>
                                        </div>
                                    @else
                                            {{$products->product_num}}
                                     @endif
                                    </td>
                                    <td> {{$products->product_price}} س.ر </td>
                                    <td>
                                        @foreach($products->images as $pics)
                                            <img width="50px" height="50px" src="{{$pics->pic}}"/>
                                        @endforeach
                                    </td>
                                    <td><img width="50px" height="50px" src="{{$products->product_pic_cover}}"/></td>

                                    <td>{{$products->products_cat_name}}</td>
                                    <td>
                                        {{-- {{$products->product_time}} --}}
                                        {{-- {{date("g:i", strtotime($products->product_time))}} دقيقه --}}
                                        {{date("d M Y", strtotime($products->product_time))}}
                                        <br>
                                        {{date("g:iA", strtotime($products->product_time))}}
                                    </td>
                                    <td class="center">
                                        {{date("d M Y", strtotime($products->product_created))}}
                                        <br>
                                        {{date("g:iA", strtotime($products->product_created))}}
                                    </td>
                                    <td>
                                        <a class="تعديل" href="{{URL('/admin/product/edit',$products->product_id)}}"> <i class="fa fa-edit"></i> </a>
                                    </td>
                                    {{-- <td>
                                        <a onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger waves-effect waves-light btn-sm" href="{{URL('/admin/product/delete',$products->product_id)}}"> <i class="fa fa-trash"></i> </a>
                                    </td> --}}
                                </tr>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection

