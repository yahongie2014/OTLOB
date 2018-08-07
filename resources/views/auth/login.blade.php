@extends('layouts.login')
@section('title')
تسجيل الدخول 
@endsection

@section('content')

    <div class="wrapper-page">
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif

        @if(session()->has('danger'))
            <div class="alert alert-danger">
                {{ session()->get('danger') }}
            </div>
        @endif

        @if(session()->has('err'))
        <div class="alert alert-danger">
            {{ session()->get('err') }}
        </div>
        @endif

        @if(Session::has('status'))
            <div class="alert alert-success">
                {{Session::get('status')}}
            </div>
        @endif
        <div class="text-center">
            {{-- <a href="{{URL('/')}}" class="logo"><span>رتبـ .<span>لي</span></span><i class="zmdi zmdi-layers"></i></a> --}}
            <img src="{{URL('/assets/images/big/Logo_Website_1080.png')}}" alt="Rtb.li" style="display: inline-block;" title="Rtb.li" class="img img-responsive" height="256" width="256" >
        </div>
        <div class="m-t-10 card-box">
            <div class="text-center">
                <h4 class="text-uppercase font-bold m-b-0">تسجيل الدخول</h4>
            </div>
            <div class="panel-body">
                <form method="post" class="form-horizontal m-t-20" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" value="{{ old('email') }}" name="email" placeholder="البريد الإلكتروني" required>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" maxlength='16' type="password" value="{{ old('password') }}" name="password" required placeholder="الرقم السرى">
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-custom">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup">
                                    تذكرنى
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group text-center m-t-30">
                        <div class="col-xs-12">
                            <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">تسجيل الدخول</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30 m-b-0">
                        <div class="col-sm-12">
                            <a href="{{ url('/password/reset') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i>هل نسيت كلمه المرور ؟</a>
                        </div>
                    </div>
                    <div class="form-group m-t-30 m-b-0">
                        <div class="col-sm-12">
                            <a href="{{ url('/verify/resend') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i>اعادة ارسال كود التفعيل</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- end card-box-->

        <div class="row">
            <div class="col-sm-12 text-center">
                <p class="text-muted"> <font color='#505458'>ليس لديك اى حساب ؟ </font><a href="{{ url('/register') }}" class="text-primary m-l-5"><b>تسجيل كمزود خدمه</b></a></p>
            </div>
        </div>

    </div>

@endsection
