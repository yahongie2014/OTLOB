@extends('layouts.adminv2')
@section('title')
تعديل معلومات الشركه
@endsection
@section('content')
<div class="portlet box blue " xmlns="http://www.w3.org/1999/html">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-gift"></i> تعديل معلومات الشركه </div>
<div class="tools">
<a href="javascript:;" class="collapse"> </a>
<a href="#portlet-config" data-toggle="modal" class="config"> </a>
<a href="javascript:;" class="reload"> </a>
<a href="javascript:;" class="remove"> </a>
</div>
</div>
<div class="portlet-body form">
<!-- BEGIN FORM-->
<form method="post" action="{{ URL::Route('InfoUpdate') }}"class="form-horizontal form-bordered" enctype="multipart/form-data">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" value="{{$info->id}}">
<div class="form-body">
<div class="form-group">
<label class="control-label col-md-3">اسم الشركه</label>
<div class="col-md-9">
<input  required="required" name="title" type="text" value="{{$info->title}}" placeholder="اسم الشركه" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">اميل الشركه</label>
<div class="col-md-9">
<input required="required" name="email"  type="email" placeholder="اميل الشركه" value="{{$info->email}}" class="form-control" />
<span class="help-block"> This is Email </span>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">تيلفون الشركه</label>
<div class="col-md-9">
<input name="phone"  type="text" placeholder="تيلفون الشركه" value="{{$info->phone}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">عنوان الشركه</label>
<div class="col-md-9">
<input name="address"  type="text" placeholder="عنوان الشركه" value="{{$info->address}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">معلومات عن الشركه</label>
<div class="col-md-9">
<textarea type="text" name="desc" data-required="1"  placeholder="معلومات عن الشركه"  class="form-control" />{{$info->desc}}</textarea>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">سياسه الشركه</label>
<div class="col-md-9">
<textarea type="text" name="policy" data-required="1"  placeholder="سياسه الشركه" class="form-control" />{{$info->policy}}</textarea>
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">الترقيم الرأسى للخريطه</label>
<div class="col-md-9">
<input name="lat"  type="text" placeholder="lat"  value="{{$info->lat}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">الترقيم الافقى للخريطه</label>
<div class="col-md-9">
<input name="long"  type="text" placeholder="long" value="{{$info->long}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">App Store</label>
<div class="col-md-9">
<input name="app_store"  type="text" placeholder="App Store" value="{{$info->app_store}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">Play Store</label>
<div class="col-md-9">
<input name="play_store"  type="text" placeholder="Play Store" value="{{$info->play_store}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">Facebook</label>
<div class="col-md-9">
<input name="facebook" type="text" placeholder="Facebook" value="{{$info->facebook}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">Twitter</label>
<div class="col-md-9">
<input name="twitter"  type="text" placeholder="Twitter" value="{{$info->twitter}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">Instagram</label>
<div class="col-md-9">
<input name="instagram"  type="text" placeholder="instagram" value="{{$info->instagram}}" class="form-control" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-3">Google</label>
<div class="col-md-9">
<input name="google"  type="text" placeholder="Google" value="{{$info->google}}" class="form-control" />
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3">شعار الشركه</label>
<img width="200px" height="200px" src="{{$info->pic}}"/>
<div class="col-md-9">
{!! Form::file('pic', null) !!}
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3">favicon</label>
<img width="200px" height="200px" src="{{asset('Info')}}/{{@$info->favicon}}"/>
<div class="col-md-9">
{!! Form::file('favicon', null) !!}
</div>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3">الفيديو</label>
<a href="{{asset('Info')}}/{{@$info->video}}" class="video_btn"><i class="fa fa-play" aria-hidden="true"></i></a>
<div class="col-md-9">
{!! Form::file('video', null) !!}
</div>
</div>


<div class="form-group">
<label class="control-label col-md-3">اللغه</label>
<div class="col-md-9">
<select class="form-control select2me" name="lang">
<option value="<?= $info->lang ?>">اختر</option>
<option value="en" {{($info->lang == 'en')?"selected":""}}>English</option>
<option value="ar" {{($info->lang == 'ar')?"selected":""}}>Arabic</option></select>
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