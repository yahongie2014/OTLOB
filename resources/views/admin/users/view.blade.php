@extends('layouts.adminv2')
@section('title')
جميع المستخدمين
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
<h4 class="header-title m-t-0 m-b-30">جميع المستخدمين</h4>
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
<a href="{{URL('/admin/user')}}">
<button id="sample_تعديلable_1_new" class="btn green"> اضافه مستخدم جديد
<i class="fa fa-plus"></i>
</button>
</a>
</div>
@if(is_null($today))
<div align="center">
    <a href="{{URL('/admin/user/view/1')}}">
        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
            مدير النظام
        </button>
    </a>
    <a href="{{URL('/admin/user/view/2')}}">
        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
            مزود الخدمه
        </button>
    </a>
    <a href="{{URL('/admin/user/view/0')}}">
        <button class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
            عميل
        </button>
    </a>
</div>
@endif
<br>
<br>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
<tr>
<th> ID </th>
<th> إسم المستخدم </th>
<th> الاميل </th>
<th style="width: 40.006px;"> رقم الهاتف </th>
<th> العنوان </th>
<th> الكود التفعيلى </th>
<th> تعديل نوع الحساب </th>
<th> تفعيل / ايقاف </th>
<th> تعديل </th>
{{-- <th> حذف </th> --}}
</tr>
</thead>
<tbody>
@foreach($user as $users)
<tr>
<td>{{$users->id}}</td>
<td>{{$users->user_name}}</td>
<td>{{$users->email}}</td>
<td dir='ltr'>{{$users->phone}}</td>
<td>{{$users->address}}</td>
<td>{{$users->v_code}}</td>
<td>
@if($users->verified == 1)
 <div class="dropdown">
<button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
الصلاحيات
<span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
<li role="presentation"><a href="{{URL::Route('MakeAdmin',[$users->id, $user_type])}}" role="menuitem" tabindex="-1" id="edit" href="">مدير نظام</a></li>
<li role="presentation"><a href="{{URL::Route('MakeVendor',[$users->id, $user_type])}}" role="menuitem" tabindex="-1" id="history" href="">مزود خدمة</a></li>
<li role="presentation"><a href="{{URL::Route('MakeRegular',[$users->id, $user_type])}}" role="menuitem" tabindex="-1" id="coupon" href="">عميل</a></li>
</ul>
</div>
@else
<div class="alert alert-warning">
<b>الرجاء تفعيل هذا الحساب</b>
</div>
@endif
</td>
<td>
<div class="dropdown">
<button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
 حالة الحساب
<span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
<li role="presentation"><a href="{{URL::Route('PermissionVerify',[$users->id, $user_type])}}" role="menuitem"
    @if($users->verified == 1) style='font-weight: bold;' @endif tabindex="-1" id="edit" href="">مفعل</a></li>
<li role="presentation"><a href="{{URL::Route('PermissionUNVerify',[$users->id, $user_type])}}"role="menuitem" 
    @if($users->verified == 0) style='font-weight: bold;' @endif tabindex="-1" id="coupon" href="">غير مفعل</a></li>
</ul>
</div>

</td>
<td><a class="تعديل" href="{{URL('/admin/edit',$users->id)}}"> <i class="fa fa-edit"></i> </a></td>
<!-- <td><a onclick="return confirm('Are you sure you want to delete this item?');" class="مسح" href="{{URL('/admin/user/delete',$users->id)}}"> <i class="fa fa-trash"></i> </a></td> -->
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
