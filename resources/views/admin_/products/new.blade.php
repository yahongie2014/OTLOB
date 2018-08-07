@extends('layouts.product')
@section('title')
اضافه منتج جديد
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
                    <i class="fa fa-gift"></i> اضافه منتج جديد
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal"  enctype="multipart/form-data" accept-charset="UTF-8" action="{{URL('product/add/new')}}" method="post" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">اسم المنتج
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="name" data-required="1"  placeholder="الاسم" class="form-control" required /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">سعر المنتج
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="number" min='0' name="price" data-required="1"  placeholder="سعر المنتج" class="form-control" required /> </div>س.ر
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">العدد المتاح
                                    </label>
                                    <div class="col-md-4">
                                        <input type="number" min='0' name="max_num" data-required="1"  placeholder="العدد المتاح" class="form-control" required /> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="widget">
                                                <div class="widget-body">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-lg btn-success btn-block waves-effect waves-light">
                                                                <i class="fa fa-plus"></i> اصافه كميات
                                                            </a>
                                                            <div id="external-events" class="m-t-20">
                                                                <br>
                                                                <p>اضف الى النتيجه</p>
                                                            </div>

                                                            <!-- checkbox -->
                                                            <div class="checkbox m-t-40">
                                                                <input id="drop-remove" type="checkbox">
                                                                <label for="drop-remove">
                                                                    Remove after drop
                                                                </label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card-box">
                                                <div id="calendar"></div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">نوع الخدمه
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control select2me" name="cat_id" required>
                                                <option value="">اختر..</option>
                                                @foreach($cat as $cats)
                                                <option value="{{$cats->id}}">{{$cats->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label class="control-label col-md-3">وقت التحضير</label>
                                        <div class="col-md-3">
                                            <div class="input-group m-b-15">
                                                <div class="bootstrap-timepicker">
                                                    <input id="timepicker2" name="prepration_time" type="text" class="form-control">
                                                </div>
                                                <span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">معلومات المنتج
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-4">
                                                <textarea type="text" name="desc" data-required="1"  placeholder="ملاحظات" class="form-control" /> </textarea>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">مقدم الخدمه
                                            </label>
                                            <div class="col-md-4">
                                                <select class="form-control select2me" name="gender" required>
                                                    <option value="">اختر..</option>
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
                                                <input type="text" name="requirement" value="requirement" data-role="tagsinput" placeholder="المتطلبات" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">صوره المنتج
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-4">
                                                <input type="file" class="form-control" name="img[]" placeholder="Upload Image" multiple="true" required>
                                                <p class="help-block"> صور المنتج </p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="file" class="form-control" name="pic" placeholder="Upload Image" required>
                                                <p class="help-block"> صوره المنتج </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn blue ">اضافه</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade none-border" id="add-category">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><strong>اضافه كميه للوقت </strong></h4>
                        </div>
                        <div class="modal-body">
                            <form role="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">الكميه</label>
                                        <input class="form-control form-white" placeholder="Quantity" type="text" name="quantity"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">الوقت</label>
                                        <select class="form-control form-white" data-placeholder="ختر وقت الكميه" name="time">
                                            <option value="صباحاُ">صباحاٌ</option>
                                            <option value="ظهراً">ظهراُ</option>
                                            <option value="مساءُ">مساءٌ</option>
                                            <option value="طول اليوم">طول اليوم</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button href="{{url('/product/view')}}" type="button" class="btn btn-default waves-effect" data-dismiss="modal">الغاء</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">حفظ</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade none-border" id="event-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><strong>تعديل</strong></h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">اغلاق</button>
                            <button type="button" class="btn btn-success save-event waves-effect waves-light">تم</button>
                            <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">مسح</button>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" type="text/javascript"></script>

            @endsection


