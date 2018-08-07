@extends('layouts.adminv2')
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
<th> اسم المنتج </th>
<th> التقييم </th>
<th> الملاحظات </th>
<th> تم انشائه </th>
</tr>
</thead>
<tbody>
@if(Auth::User()->is_vendor == 1)
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
@else()
@foreach($rate as $rates)
<tr>
<td> # {{$rates->feed_name_pro}} </td>
<td>{{$rates->feed_rate}}</td>
<td>{{$rates->feed_notes}}</td>
<td class="center">
{{date("d M Y", strtotime($rates->feed_time))}}
<br>
{{date("g:iA", strtotime($rates->feed_time))}}
</td>
</tr>
@endforeach
@endif
</tbody>
</table>
</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
@endsection
