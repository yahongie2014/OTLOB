@extends('layouts.adminv2')
@section('title')
History
@endsection
@section('content')

<div class="row">
<div class="col-md-12">
<div class="card-box table-responsive">
<div class="portlet-title">
<div class="caption">
<i class="icon-settings font-red"></i>
<h4 class="header-title m-t-0 m-b-30">History</h4>
</div>
</div>
<div class="card-box table-responsive">
<br>
<div class="btn-group">
</div>
<br>
<br>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="1" width="100%">
<thead>
<tr>
<th> No. </th>
<th> log </th>
<th> Type </th>
<th> Item ID </th>
<th> by </th>
<th> Time </th>
</tr>
</thead>
<tbody>
@foreach($logs as $log)
<tr>
<td>{{$log->id}}</td>
<td>{{$log->description}}</td>
<td>{{$log->type}}</td>
<td>{{$log->item_id}}</td>
<td>{{$log->user['user_name']}}</td>
<td>{{$log->created_at}}</td>
@endforeach
</tbody>
</table>
</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
@endsection
