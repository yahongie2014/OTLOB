@extends('layouts.adminv2')
@section('title')
 | تعديل المنتج {{$pro_dic->name}}
@endsection
@section('content')
<?php
$cat = App\Category::Select('*')->get();
?>
<br>
<div class="row">
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>  | تعديل المنتج {{$pro_dic->name}}

                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{URL('vendor/product/update')}}" method="post" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="id" value="{{$pro_dic->id}}">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">اسم المنتج
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" min='0' name="name" data-required="1"  placeholder="الاسم" value="{{$pro_dic->name}}" class="form-control" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">سعر المنتج
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" min='0' name="price" data-required="1" value="{{$pro_dic->price}}"  placeholder="سعر المنتج" class="form-control" /> </div>س.ر
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">العدد المتاح
                                </label>
                                <div class="col-md-4">
                                    <input value="{{$pro_dic->price}}" type="text" name="max_num" data-required="1"  placeholder="العدد المتاح" class="form-control" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">نوع الخدمه
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="cat_id">
                                        <option value="{{$pro_dic->cat_id}}">{{$pro_dic->cat_id}}</option>
                                        @foreach($cat as $cats)
                                            <option value="{{$cats->id}}">{{$cats->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">الجنس
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="gender">
                                        <option value="{{$pro_dic->gender}}">{{$pro_dic->gender}}</option>
                                        <option value="women">Women</option>
                                        <option value="men">Men</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">وقت التحضير</label>
                                <div class="col-md-3">
                                    <div class="input-icon">
                                        <i class="fa fa-clock-o"></i>
                                        <input  value="{{$pro_dic->prepration_time}}" name="prepration_time" type="text" class="form-control timepicker timepicker-default"> </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">معلومات المنتج
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <textarea type="text" name="desc" data-required="1"  placeholder="ملاحظات" class="form-control" />{{$pro_dic->desc}}</textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">مقدم الخدمه
                                    </label>
                                    <div class="col-md-4">
                                        <select class="form-control select2me" name="gender">
                                            <option value="{{$pro_dic->gender}}">اختر..</option>
                                            <option value="0">رجال</option>
                                            <option value="1">نساء</option>
                                            <option value="2">الكل</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">المتطلبات
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" name="requirement" value="{{$pro_dic->requirement}}" data-role="tagsinput" placeholder="المتطلبات" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">صوره المنتج
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        @foreach($pro_dic->images as $pics)
                                            <img width="50px" height="50px" src="{{$pics->pic}}"/>
                                        @endforeach
                                        <br>
                                        <input type="file" name="img[]" multiple/>
                                        <p class="help-block"> صوره المنتج </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn blue ">تعديل</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
