@extends('layouts.adminv2')
@section('title')
اضافه معلومات الشركه
@endsection
@section('content')
    <div class="portlet box blue " xmlns="http://www.w3.org/1999/html">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> اضافه معلومات الشركه </div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                <a href="javascript:;" class="reload"> </a>
                <a href="javascript:;" class="remove"> </a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form method="post" action="{{ URL::Route('InfoAdd') }}"class="form-horizontal form-bordered" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">اسم الشركه</label>
                        <div class="col-md-9">
                            <input  required="required" name="title" type="text" placeholder="اسم الشركه" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">اميل الشركه</label>
                        <div class="col-md-9">
                            <input required="required" name="email"  type="text" placeholder="اميل الشركه"  class="form-control" required />
                            <span class="help-block"> This is Email </span>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">تيلفون الشركه</label>
                            <div class="col-md-9">
                                <input name="phone"  type="text" placeholder="تيلفون الشركه"  class="form-control" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">معلومات عن الشركه</label>
                            <div class="col-md-9">
                                <textarea type="text" name="desc" data-required="1"  placeholder="معلومات عن الشركه" class="form-control" required /> </textarea>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">سياسه الشركه</label>
                        <div class="col-md-9">
                            <textarea type="text" name="policy" data-required="1"  placeholder="سياسه الشركه" class="form-control" required /> </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الترقيم الرأسى للخريطه</label>
                        <div class="col-md-9">
                            <input name="lat"  type="text" placeholder="lat"  class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الترقيم الافقى للخريطه</label>
                        <div class="col-md-9">
                            <input name="long"  type="text" placeholder="long"  class="form-control" required />
                        </div>
                    </div>

                    <div class="form-group">
                            <label class="control-label col-md-3">شعار الشركه</label>
                            <div class="col-md-9">
                                {!! Form::file('pic', null ) !!}
                            </div>
                        </div>
                    </div>
                <div class="form-group">
                    <label class="control-label col-md-3">اللغه</label>
                    <div class="col-md-9">
                        <select class="form-control select2me" name="lang" required>
                            <option value="lang">اختر..</option>
                                <option value="en">English</option>
                                <option value="ar">Arabic</option>
                        </select>
                    </div>
                </div>
        <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">
                                            <i class="fa fa-check"></i> اضافه</button>
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