@extends('layouts.admin')
@section('title')
جميع التقييميات
@endsection
@section('content')
    @if(session()->has('danger'))
        <div class="alert alert-danger">
            {{ session()->get('danger') }}
        </div>
    @endif
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="row">
<div class="col-md-12">
<div class="card-box table-responsive">
<div class="portlet-title">
<div class="caption">
<i class="icon-settings font-red"></i>
<h4 class="header-title m-t-0 m-b-30">جميع التقييميات</h4>
</div>
</div>
<div class="card-box table-responsive">
<br>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
<tr>
<th> اسم المنتج </th>
<th> التقييم </th>
<th> الملاحظات </th>
<th> تم انشائه </th>
</tr>
</thead>
<tbody>
@foreach($rate_vendor as $vendors)
<tr>
<td> # {{$vendors->feed_name_pro}} </td>
<td>{{$vendors->feed_rate}}</td>
<td>{{$vendors->feed_notes}}</td>
<td class="center">
{{date("d M Y", strtotime($vendors->feed_time))}}
<br>
{{date("g:iA", strtotime($vendors->feed_time))}}
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
