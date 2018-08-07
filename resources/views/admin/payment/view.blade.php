@extends('layouts.adminv2')
@section('title')
جميع حسابات البنوك
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
<div class="col-md-6">
<div class="btn-group">
<a href="{{URL('/admin/payment/new')}}">
<button id="sample_تعديلable_1_new" class="btn green"> اضافه حساب بنك جديد
<i class="fa fa-plus"></i>
</button>
</a>
</div>
</div>
<br>
<br>
<div class="col-md-12">
<div class="portlet light portlet-fit bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-settings font-red"></i>
<span class="caption-subject font-red sbold uppercase">حسابات البنوك</span>
</div>
</div>
<div class="portlet-body">
<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
<thead>
<tr>
<th> اسم حساب البنك </th>
<th> رقم الحساب </th>
<th> مدين </th>
<th> الطلبات </th>
<th> تعديل </th>
</tr>
</thead>
<tbody>
@foreach($payment as $payments)
    <tr>
        <td> {{$payments->bank_name}}</td>
        <td>{{$payments->accout_no}} </td>

        <td>
            {{$payments->order->sum('total')}}
        </td>
        <td><a class="btn btn-info" role="button" href="{{URL('/admin/payment/orders',$payments->id)}}"> عرض </a></td>
        <td><a class="تعديل" href="{{URL('/admin/payment/edit',$payments->id)}}"> <i class="fa fa-edit"></i> </a></td>
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
