@extends('layouts.adminv2')
@section('title')
    اضافه طريقه دفع
@endsection
@section('content')
    <?php
            $countries = App\Nations::select('*')->get();
            $currencey = App\Currency::select('*')
                ->where('lang','=','ar')
                ->get();
            ?>
    <div class="portlet box blue " xmlns="http://www.w3.org/1999/html">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> اضافه حساب بنك </div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                <a href="javascript:;" class="reload"> </a>
                <a href="javascript:;" class="remove"> </a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form method="post" action="{{ URL::Route('payment_store') }}" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">اسم البنك</label>
                        <div class="col-md-9">
                            <input  required="required" name="bank_name" type="text" placeholder="بنك الراجحى" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">رقم الحساب</label>
                        <div class="col-md-9">
                            <input  required="required" name="accout_no" type="text" placeholder="123-45678-910/XXXX" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">IBAN</label>
                        <div class="col-md-9">
                            <input  required="required" name="iban" type="text" placeholder="SA03 8000 0000 6080 1016 7519" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Swift</label>
                        <div class="col-md-9">
                            <input  required="required" name="swift" type="text" placeholder="RJHISARIXXX" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">الدوله
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control select2me" name="country" required>
                                <option value="">اختر..</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">العمله
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control select2me" name="currency" required>
                                <option value="">اختر..</option>
                                @foreach($currencey as $currencies)
                                <option value="{{$currencies->id}}">{{$currencies->currency_name}}</option>
                                    @endforeach
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