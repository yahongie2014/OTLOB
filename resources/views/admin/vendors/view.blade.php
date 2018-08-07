@extends('layouts.adminv2')
@section('title')
أصحاب الأعمال
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
                        <h4 class="header-title m-t-0 m-b-30">أصحاب الأعمال</h4>
                    </div>
                </div>
                <div class="card-box table-responsive">

                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th width="5%"> م. </th>
                            <th width="10%"> رقم العميل </th>
                            <th width="13%"> اسم العميل </th>
                            <th width="15%"> البريد الالكتروني </th>
                            <th> النشاط التجاري </th>
                            <th width="5%"> عرض المنتجات </th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($vendors as $k => $vendor)
                                <tr>

                                    <td> {{++$k}} </td>
                                    <td> {{$vendor->id}} </td>
                                    <td> {{$vendor->user_name}} </td>
                                    <td> {{$vendor->email}} </td>
                                    <td>
                                        @foreach($vendor->categories as $category)
                                            - {{$category->name}} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{url('/admin/getvendorsproducts/' . $vendor->id)}}" class="btn btn-info" role="button">المنتجات</a>
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
