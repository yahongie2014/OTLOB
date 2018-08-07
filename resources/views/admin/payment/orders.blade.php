@extends('layouts.adminv2')
@section('title')
الطلبات المرتبطة بالحساب البنكي : {{$bank->bank_name}}
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

</div>
<br>
<br>
<div class="col-md-12">
<div class="portlet light portlet-fit bordered">
<div class="portlet-title">
<div class="caption">
<i class="icon-settings font-red"></i>
<span class="caption-subject font-red sbold uppercase"></span>
</div>
</div>
<div class="portlet-body">
<table class="table table-striped table-bordered table-hover order-column" id="datatable-responsive">
<thead>
<tr>
<th> رقم الطلب </th>
<th> المستخدم </th>
<th> رقم الايداع </th>
<th> صورة الايداع </th>
    <th> اجمالي </th>

</tr>
</thead>
<tbody>
@foreach($orders as $order)
    <tr>
        <td> {{$order->id}}</td>
        <td>({{$order->user->id}}) {{ $order->user->user_name }} </td>
        <td>{{$order->payment_no}}</td>
        <td>
            @if($order->payment_image != "")
            <a class="btn btn-info" target="_blank" role="button" href="{{asset('/transactions/' . $order->payment_image)}}"> عرض </a>
            @endif
        </td>
        <td>
            {{$order->total}}
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

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endsection
