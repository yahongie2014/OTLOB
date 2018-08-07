@extends('layouts.login')
@section('content')
<div class="wrapper-page">
        <div class="text-center">
            <a href="{{URL('/login')}}" class="logo"><span>Admin<span>to</span></span></a>
            <h5 class="text-muted m-t-0 font-600">Responsive Admin Dashboard</h5>
        </div>
        <div class="m-t-40 card-box">
            <div class="text-center">
                <h4 class="text-uppercase font-bold m-b-0">تسجيل الدخول</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal m-t-20" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group ">
                        <div class="col-xs-12{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input class="form-control" type="text" required="" value="{{ old('email') }}" name="email" placeholder="email">
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif

                    </div>

                    <div class="form-group">
                        <div class="col-xs-12{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input class="form-control" type="password" value="{{ old('password') }}" name="password" required="" placeholder="Password">
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
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
                            <a href="{{ url('/password/reset') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i> نسيت كلمه المرور؟</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- end card-box-->

        <div class="row">
            <div class="col-sm-12 text-center">
                <p class="text-muted">ليس لديك اى حساب ؟ <a href="page-register.html" class="text-primary m-l-5"><b>تسجيل الان</b></a></p>
            </div>
        </div>

    </div>

@endsection
