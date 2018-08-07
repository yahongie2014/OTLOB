@extends('layouts.product')
@section('title')
اضافه دولة
@endsection
@section('content')

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <!--<div class="caption">
                    <i class="fa fa-gift"></i> اضافه منتج جديد
                </div>-->
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form class="form-horizontal" enctype="multipart/form-data" accept-charset="UTF-8"
                      action="{{URL('/admin/countries')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">اسم الدولة
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="name" data-required="1" placeholder="اسم الدولة"
                                       class="form-control" value="{{ old('name') }}" /></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">اسم الدولة (EN)
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="name_en" data-required="1" placeholder="اسم الدولة (EN)"
                                       class="form-control" value="{{ old('name_en') }}" /></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">رمز الدولة
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="code" data-required="1" placeholder="رمز الدولة"
                                       class="form-control" value="{{ old('code') }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">اسم العملة
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="currency_name" placeholder="اسم العملة"
                                       class="form-control" value="{{ old('currency_name') }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">اسم العملة (EN)
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="currency_name_en" placeholder="اسم العملة"
                                       class="form-control" value="{{ old('currency_name_en') }}" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">رمز العملة
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="currency_code" placeholder="رمز العملة"
                                       class="form-control" value="{{ old('currency_code') }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">العلم</label>
                            <div class="col-md-3">
                                <input type="file" onchange="readURL(this);" accept=".ico,.png" value="{{ old('flag') }}" name="flag">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"> </label>
                            <div class="col-md-3">
                                <img id="countryImage" style="max-width: 16px;" src="{{asset('/uploads/flag.png')}}" />
                            </div>
                        </div>
                        <!--<div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">صوره المنتج الرئيسية
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="file" class="form-control" name="pic" placeholder="Upload Image"
                                           required>
                                </div>
                            </div>
                        </div>-->
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

@endsection


@section('footer')
@parent

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#countryImage').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

