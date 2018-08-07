@extends('layouts.adminv2')
@section('title')
صلاحيات المستخدمين
@endsection
@section('content')
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
<h4 class="header-title m-t-0 m-b-30">صلاحيات المستخدمين</h4>
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
<th> إسم المستخدم </th>
<th> حالة الحساب </th>
<th> نوع الحساب </th>
<th> تعديل نوع الحساب </th>
<th> تفعيل / ايقاف </th>
</tr>
</thead>
<tbody>
@foreach($userss as $users)
<tr>
<td>{{$users->user_name}} </td>
<td>
@if($users->verified == 0 )
<?php print "غير مفعل" ?>
@else
<?php print "مفعل" ?>
@endif
</td>
<td>
@if($users->is_vendor == 0 && $users->is_admin == 0 )
<?php print "مستخدم عادى" ?>
@elseif($users->is_vendor == 1 && $users->is_admin == 0)
<?php print "مستخدم صاحب شركه" ?>
@else
<?php print "مستخدم له كل الصلاحيات" ?>
@endif
</td>
<td>
@if($users->verified == 1)
 <div class="dropdown">
<button class="btn btn-flat btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
الصلاحيات
<span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
<li role="presentation"><a href="{{URL::Route('MakeAdmin',$users->id)}}" role="menuitem" tabindex="-1" id="edit" href="">مستخدم له كل الصلاحيات</a></li>
<li role="presentation"><a href="{{URL::Route('MakeVendor',$users->id)}}" role="menuitem" tabindex="-1" id="history" href="">مستخدم صاحب شركه</a></li>
<li role="presentation"><a href="{{URL::Route('MakeRegular',$users->id)}}" role="menuitem" tabindex="-1" id="coupon" href="">مستخدم عادى</a></li>
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
<li role="presentation"><a href="{{URL::Route('PermissionVerify',$users->id)}}" role="menuitem" tabindex="-1" id="edit" href="">مفعل</a></li>
<li role="presentation"><a href="{{URL::Route('PermissionUNVerify',$users->id)}}"role="menuitem" tabindex="-1" id="coupon" href="">غير مفعل</a></li>
</ul>
</div>

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
