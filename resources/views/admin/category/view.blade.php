@extends('layouts.adminv2')
@section('title')
    خدمات الشركه
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
<a href="{{URL('/admin/category/add')}}">
<button id="sample_تعديلable_1_new" class="btn green"> اضافه خدمه جديده
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
<span class="caption-subject font-red sbold uppercase">خدمات الشركه</span>
</div>
</div>
<div class="portlet-body">
<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
<thead>
<tr>
<th> اسم الخدمه </th>
<th> تفاصيل الخدمه </th>
<th> صوره الخدمه </th>
<th> صوره الخدمه(EN) </th>
<th> إظهار / إخفاء </th>
<th> تعديل </th>
{{-- <th> حذف </th> --}}
</tr>
</thead>
<tbody>
@foreach($categories as $category)
    <tr>
        <td>{{$category->name}}</td>
        <td>{{$category->desc}}</td>
        <td><img width="55px" height="55px" src="{{$category->img}}"></td>
        <td><img width="55px" height="55px" src="{{$category->img_en}}"></td>
        <td class="center">
            @if ($category->published == 1)
                <a class="btn" href="{{url('/admin/category/published/' . $category->id)}}/0">
                    <img src="{{asset('')}}/assets/images/check.png" alt="تقعيل إلغاء">
                </a>
            @else
                <a class="btn" href="{{url('/admin/category/published/' . $category->id)}}/1">
                    <img src="{{asset('')}}assets/images/close.png" alt="تقعيل">
                </a>
            @endif
        </td>
        <td><a class="تعديل" href="{{URL('/admin/category/edit', $category->id)}}"> <i class="fa fa-edit"></i> </a></td>
        {{-- <td><a onclick="return confirm('Are you sure you want to delete this item?');" class="مسح" href="{{URL('/admin/category/delete', $category->id)}}"> <i class="fa fa-trash"></i> </a></td> --}}
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
