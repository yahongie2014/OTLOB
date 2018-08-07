@extends('layouts.adminv2')
@section('title')
تعديل معلومات الخدمه
@endsection
@section('content')
<div class="portlet box blue " xmlns="http://www.w3.org/1999/html">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-gift"></i> تعديل معلومات الخدمه </div>
<div class="tools">
<a href="javascript:;" class="collapse"> </a>
<a href="#portlet-config" data-toggle="modal" class="config"> </a>
<a href="javascript:;" class="reload"> </a>
<a href="javascript:;" class="remove"> </a>
</div>
</div>
<div class="portlet-body form">
<!-- BEGIN FORM-->
<form method="post" action="{{ URL::Route('CategoryUpdate') }}"class="form-horizontal form-bordered" enctype="multipart/form-data">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" value="{{$category->id}}">
<div class="form-body">
<div class="form-group">
<label class="control-label col-md-3">اسم الخدمه</label>
<div class="col-md-9">
<input  required="required" name="name" type="text" value="{{$category->name}}" placeholder="اسم الخدمه" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">اسم الخدمه (EN)</label>
<div class="col-md-9">
<input  required="required" name="name_en" type="text" value="{{$category->name_en}}" placeholder="اسم الخدمه" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">معلومات عن الخدمه</label>
<div class="col-md-9">
<textarea type="text" name="desc" data-required="1"  placeholder="معلومات عن الخدمه"  class="form-control" />{{$category->desc}}</textarea>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">معلومات عن الخدمه (EN)</label>
<div class="col-md-9">
<textarea type="text" name="desc_en" data-required="1"  placeholder="معلومات عن الخدمه (EN)"  class="form-control" />{{$category->desc_en}}</textarea>
</div>
</div>
<div class="form-group">
    <label class="control-label col-md-3">نوع الخدمة</label>
    <div class="col-md-9">
        <input type="radio" name="is_offer" value="1" {{$category->is_offer?'checked':''}}> عرض
        <input type="radio" name="is_offer" value="0" {{!$category->is_offer?'checked':''}}> خدمة عاديه<br>
    </div>
</div>
<div class="form-body">
    <div class="form-group">
        <label class="control-label col-md-3">الحاله
            <span class="required"> * </span>
        </label>
        <div class="col-md-4">
            <select class="form-control select2me" name="published" required>
                <option value="1" {{($category->published==1)?'selected':''}}>مفعل</option>
                <option value="0" {{($category->published==0)?'selected':''}}>غير مفعل</option>
            </select>
        </div>
    </div>
</div>
<div class="form-group">
<label class="control-label col-md-3">شعار الخدمه</label>
<img width="200px" height="200px" src="{{$category->img}}"/>
<div class="col-md-9">
{!! Form::file('img', null) !!}
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">شعار الخدمه(EN)</label>
<img width="200px" height="200px" src="{{$category->img_en}}"/>
<div class="col-md-9">
{!! Form::file('img_en', null) !!}
</div>
</div>


</div>
<div class="form-actions">
<div class="row">
<div class="col-md-12">
<div class="row">
<div class="col-md-offset-3 col-md-9">
<button type="submit" class="btn green">
<i class="fa fa-check"></i> تعديل</button>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
</div>
@endsection