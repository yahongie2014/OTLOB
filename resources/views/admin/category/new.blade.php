@extends('layouts.adminv2')
@section('title')
اضافه خدمات الشركه
@endsection
@section('content')
    <div class="portlet box blue " xmlns="http://www.w3.org/1999/html">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> اضافه خدمات الشركه </div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                <a href="javascript:;" class="reload"> </a>
                <a href="javascript:;" class="remove"> </a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form method="post" action="{{ URL::Route('AdminCategoryNew') }}"class="form-horizontal form-bordered" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">اسم الخدمه</label>
                        <div class="col-md-9">
                            <input  required="required" name="name" type="text" placeholder="اسم الخدمه" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">اسم الخدمه (EN)</label>
                        <div class="col-md-9">
                            <input  required="required" name="name_en" type="text" placeholder="اسم الخدمه (EN)" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">معلموات الخدمه</label>
                        <div class="col-md-9">
                            <textarea type="text" name="desc" data-required="1"  placeholder="معلموات الخدمه" class="form-control" /> </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">معلموات الخدمه (EN)</label>
                        <div class="col-md-9">
                            <textarea type="text" name="desc" data-required="1"  placeholder="معلموات الخدمه (EN)" class="form-control" /> </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="control-label col-md-3">الحاله
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <select class="form-control select2me" name="published" required>
                                    <option value="1">مفعل</option>
                                    <option value="0">غير مفعل </option>
                                </select>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">عرض</label>
                        <div class="col-md-9">
                            <input type="radio" name="is_offer" value="1"> عرض
                            <input type="radio" name="is_offer" value="0"> خدمة عاديه<br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">صوره الخدمه</label>
                        <div class="col-md-9">
                            {!! Form::file('img', null) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">صوره الخدمه (EN)</label>
                        <div class="col-md-9">
                            {!! Form::file('img_en', null) !!}
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="control-label col-md-3">اللغه</label>
                    <div class="col-md-9">
                        <select class="form-control select2me" name="lang">
                            <option value="lang">اختر..</option>
                            <option value="en">English</option>
                            <option value="ar">Arabic</option>
                        </select>
                    </div>
                </div> -->

                <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">
                                            <i class="fa fa-check"></i> اضافه</button>
                                        <button type="button" class="btn default">الغاء</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>

@endsection