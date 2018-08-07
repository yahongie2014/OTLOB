@extends('layouts.register')
@section('title')
Register in party
@endsection
<?php
$city = App\Country::Select('*')
    ->where('lang','=','ar')
    ->where('area_id','=', 1)
    ->get();

$cat = App\Category::Select('*')->get();
$nations = App\Nations::where('status',1)->Select('*')->get();
//dd($nations);
?>
<link rel="stylesheet" href="{{asset('')}}build/css/intlTelInput.css">
<link rel="stylesheet" href="{{asset('')}}build/css/demo.css">
@section('register')
    
<div class="wrapper-page">
        <div class="text-center">
            {{-- <a href="{{URL('/')}}" class="logo"><span>Par<span>ty</span></span></a> --}}
            <img src="{{URL('/assets/images/big/Logo_Website_1080.png')}}" alt="Rtb.li" style="display: inline-block;" title="Rtb.li" class="img img-responsive" height="256" width="256" >
        </div>
        <div class="m-t-10 card-box">
            <div class="text-center">
                <h4 class="text-uppercase font-bold m-b-0">تسجيل كمزود خدمة</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal m-t-20" role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
                    <div class="form-group ">
                        <div class="col-xs-12{{ $errors->has('user_name') ? ' has-error' : '' }}">
                            <input id="user_name" placeholder="إسم المستخدم *" type="text" maxlength="100" class="form-control" name="user_name" value="{{ old('user_name') }}" required>
                        </div>
                        @if ($errors->has('user_name'))
                            <span class="help-block" dir="ltr">
                                <strong>{{ $errors->first('user_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input  placeholder="البريد الإلكتروني *" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block" dir="ltr">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <input type="phone" id="phone" placeholder="0593911111 *" maxlength="11" class="form-control" name="phone" value="{{ old('phone') }}" required autocomplete="off" dir="rtl">
                        </div>
                        <input type="hidden" value="20" name="dialcode" id="dialcode">
                        @if ($errors->has('phone'))
                            <span class="help-block" dir="ltr">
                             <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <input type='hidden' name='is_vendor' value='1'>

                    <div class="form-group">
                        <div class="col-xs-12{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input placeholder="كلمه المرور *" maxlength='16' id="password" type="password" class="form-control" name="password" required>
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block" dir="ltr">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input placeholder="تأكيد كلمه المرور *" maxlength='16' id="password-confirm" type="password" class="form-control" name="password_confirmation" oninput="check(this)" required>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block" dir="ltr">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">الدولة *
                        </label>
                        <div class="col-md-4">

                            <select class="form-control " name="nation_id"  required>
                                @foreach($nations as $nation)
                                    <option value="{{$nation->id}}">{{$nation->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('nation_id'))
                            <span class="help-block" dir="ltr">
                                <strong>{{ $errors->first('nation_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">النشاط التجارى *
                        </label>
                        <div class="col-md-4">

                            <select multiple name="cat_id[]" size="{{count($cat)}}" required>
                                @foreach($cat as $cats)
                                    <option value="{{$cats->id}}">{{$cats->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('cat_id'))
                            <span class="help-block" dir="ltr">
                                <strong>{{ $errors->first('cat_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <!--<div class="form-group">
                        <label class="control-label col-md-3">نوع مقدم الخدمه *
                        </label>
                        <div class="col-md-4">
                            <select class="form-control select2me" name="type"  required>
                                <option value="">اختر..</option>
                                <option value="1">نساء</option>
                                <option value="2">رجال</option>
                                <option value="3">الكل</option>
                            </select>
                        </div>
                    </div>-->


                    <!--<div class="form-group">
                        <label class="control-label col-md-3">صورة
                        </label>
                        <div class="col-xs-6">
                            <input type="file" name="pic" class="dropify" data-max-file-size="1M" />
                        </div>
                    </div>-->

                    <!--<div class="form-group">
                        <label class="control-label col-md-3">المنطقه *
                        </label>
                        <div class="col-md-4{{ $errors->has('country') ? ' has-error' : '' }}">
                            <select class="form-control select2me" name="country" required>
                                <option value="">اختر..</option>
                                @foreach($city as $cities)
                                <option value="{{$cities->id}}">{{$cities->country}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <span class="help-block" dir="ltr">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>-->
                    <div class="col-xs-12">

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="checkbox checkbox-custom">
                                        <input id="checkbox-signup" type="checkbox" checked="checked" required style="z-index: -1">
                                        <label for="checkbox-signup" id="policy">انا اوافق على </label>
                                        <a  href="{{url('/policy')}}" target="_blank">سياسه الاستخدام</a>
                                    </div>

                                </div>
                            </div>



                    </div>
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">
                                انشاء حساب
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
        <!-- end card-box -->

        <div class="row">
            <div class="col-sm-12 text-center">
                <p class="text-muted">
                    <font color='#505458'>
                        هل لديك حساب مسبق ؟
                    </font>
                    <a href="{{ url('/login') }}" class="text-primary m-l-5">
                        <b>تسجيل الدخول</b>
                    </a>
                </p>
            </div>
        </div>

    </div>
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script>
    /*$('.dropify').dropify({
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove': 'Remove',
            'error': 'Ooops, something wrong appended.'
        },
        error: {
            'fileSize': 'The file size is too big (1M max).'
        }
    });*/
</script>
<script src="{{asset('')}}build/js/intlTelInput.js"></script>
<script>
    /*$("#phone").intlTelInput({
        utilsScript: "{{asset('')}}build/js/utils.js"
    });*/
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Password Must be Matching.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }
    $(document).ready(function() {
        $("#checkbox-signup").click(function(){
            console.log("sssss");
        })
    /*$("#phone").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $('#phone').keypress(function(e){ 
       if (this.value.length == 0 && e.which == 48 ){
          return false;
       }
    });*/

    $(".country").on('click',function(){
       $selectedContry = $(this).attr('data-dial-code');
       //console.log($selectedContry);
       $("#dialcode").val($selectedContry);
    });
});
</script>
@endsection
