@extends('layouts.adminv2')
@section('title')
معلومات الشركه
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
<h4 class="header-title m-t-0 m-b-30">معلومات الشركه</h4>
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
<div class="btn-group">
<a href="{{URL('/admin/info')}}">
<button id="sample_تعديلable_1_new" class="btn green"> اضافه معلومات جديده
<i class="fa fa-plus"></i>
</button>
</a>
</div>
<br>
<br>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
<tr>
<th> اسم الشركه </th>
<th> التيلفون </th>
<th> الاميل </th>
<th> المعلومات </th>
<th> تعديل </th>
<th> حذف </th>
</tr>
</thead>
<tbody>
@foreach($info as $infos)
<tr>
<td>{{$infos->title}} </td>
<td> {{$infos->phone}} </td>
<td>{{$infos->email}}</td>
<td>{{$infos->desc}}</td>
<td><a class="تعديل" href="{{URL('/admin/info/edit', $infos->id)}}"> <i class="fa fa-edit"></i> </a></td>
<td><a onclick="return confirm('Are you sure you want to delete this item?');" class="مسح" href="{{URL('/admin/info/delete', $infos->id)}}"> <i class="fa fa-trash"></i> </a></td>
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
