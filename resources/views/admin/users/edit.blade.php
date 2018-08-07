@extends('layouts.adminv2')
@section('title')
{{Auth::user()->user_name}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> تعديل {{Auth::user()->user_name}}
                    </div>
                </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form method="post" action="{{ URL::Route('AdminUserUpdate') }}"class="form-horizontal form-bordered" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="<?= $users->id ?>">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">إسم المستخدم</label>
                        <div class="col-md-9">
                            <input maxlength="30" required="required" name="user_name" type="text" value="{{$users->user_name}}" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الاميل</label>
                        <div class="col-md-9">
                            <input name="email" type="text" value="{{$users->email}}" class="form-control" disabled/>
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                            <div class="has-error">
                                <span class="help-block"><strong>الرجاء مراجعة الدعم الفني</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="control-label col-md-3">كلمه المرور</label>
                        <div class="col-md-9">
                            <input required="required" type="password" name="password" placeholder="password" class="form-control" />
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">التيلفون</label>
                        <div class="col-md-9">
                            <input name="phone" type="text" value="{{$users->phone}}" class="form-control" disabled/>
                            <div class="has-error">
                                <span class="help-block"><strong>الرجاء مراجعة الدعم الفني</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">العنوان</label>
                        <div class="col-md-9">
                            <input name="address" type="text" value="{{$users->address}}" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الصوره الشخصيه</label>
                        <div class="col-md-9">
                            <img style = "width:200px; height:200px;"  src="{{asset($users->pic)}} "/>
                            {!! Form::file('pic', null) !!}
                            <p class="help-block"> الصوره الشخصيه </p>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">
                                            <i class="fa fa-check"></i> تعديل</button>
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
    </div>
@endsection