@extends('layouts.adminv2')
@section('title')
    سلة المشتريات
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                <span class="caption-subject font-red sbold uppercase">سلة المشتريات الخاصة بالعميل : {{$user->user_name}}</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> م </th>
                            <th align="center"> المنتجات في سلة العميل </th>
                            <th align="center"> الكمية </th>
                            <th align="center"> تاريخ إضافتها للسلة </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($cart_products as $key => $product)
                        <tr>
                            <td>{{++$key}}</td>
                            <td align="center">{{@$product['Products']->name}}</td>
                            <td align="center">{{@$product->amount}}</td>
                            <td align="center">{{@$product->created_at}}</td>
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
