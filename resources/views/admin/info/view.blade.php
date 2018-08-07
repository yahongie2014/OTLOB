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
<br>
<div class="btn-group">
{{-- <a href="{{URL('/admin/info')}}">
<button id="sample_تعديلable_1_new" class="btn green"> اضافه معلومات جديده
<i class="fa fa-plus"></i>
</button>
</a> --}}
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
{{-- <th> حذف </th> --}}
</tr>
</thead>
<tbody>
{{-- @foreach($info as $infos) --}}
<tr>
<td>{{$info->title}} </td>
<td> {{$info->phone}} </td>
<td>{{$info->email}}</td>
<td>{{$info->desc}}</td>
<td><a class="تعديل" href="{{URL('/admin/info/edit', $info->id)}}"> <i class="fa fa-edit"></i> </a></td>
{{-- <td><a onclick="return confirm('Are you sure you want to delete this item?');" class="مسح" href="{{URL('/admin/info/delete', $info->id)}}"> <i class="fa fa-trash"></i> </a></td> --}}
</tr>
{{-- @endforeach --}}
</tbody>
</table>
</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
@endsection
