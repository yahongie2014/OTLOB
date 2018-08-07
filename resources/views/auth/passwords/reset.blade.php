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
        <div class="m-t-10 card-box">
            <div class="text-center">
                <h4 class="text-uppercase font-bold m-b-0">استرجاع كلمه المرور</h4>
                @if (session('status'))
                    <div dir='ltr' class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong dir='ltr'>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20 m-b-0">
                        <div class="col-xs-12">
                            <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">ارسال</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
        <!-- end card-box -->
    </div>
@endsection
