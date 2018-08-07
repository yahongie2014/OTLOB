@extends('layouts.login')
@section('title')
استرجاع كلمه المرور
@endsection
@section('content')
<div class="wrapper-page">
        <div class="text-center">
            {{-- <a href="{{URL('/')}}" class="logo"><span>Par<span>ty</span></span></a> --}}
            <img src="{{URL('/assets/images/big/Logo_Website_1080.png')}}" alt="Rtb.li" style="display: inline-block;" title="Rtb.li" class="img img-responsive" height="256" width="256" >
        </div>
        <div class="m-t-40 card-box">
            <div class="text-center">
                <h4 class="text-uppercase font-bold m-b-0">استرجاع كلمه المرور</h4>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="text-muted m-b-0 font-13 m-t-20" dir="rtl">ادخل بريدك الإلكتروني و سوف تصلك رساله لإستعادة كلمة المرور.  </p>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <div class="col-xs-12{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input placeholder="الاميل" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group text-center m-t-20 m-b-0">
                        <div class="col-xs-12">
                            <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">ارسال</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <p class="text-muted"> 
                    <font color='#505458'>    
                        تذكرت كلمه المرور ؟
                    </font> 
                    <a href="{{URL('/login')}}" class="text-primary m-l-5"><b>الرجوع لتسجيل الدخول</b></a></p>
            </div>
        </div>
    </div>
@endsection
