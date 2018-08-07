@extends('layouts.adminv2')
@section('title')
 {{Auth::user()->user_name}}
@endsection
@section('content')
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
     <form method="post" action="{{ URL::Route('AdminUserUpdateVendor') }}"class="form-horizontal form-bordered" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="id" value="<?= $users->id ?>">
      <div class="form-body">
       <div class="form-group">
        <label class="control-label col-md-3">إسم المستخدم</label>
        <div class="col-md-9">
         <input maxlength="30"  required="required" name="user_name" type="text" value="{{$users->user_name}}" class="form-control" />
        </div>
       </div>
       <div class="form-group">
        <label class="control-label col-md-3">الاميل</label>
        <div class="col-md-9">
         <input name="email"  type="text" value="{{$users->email}}" class="form-control" disabled/>
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
         <input type="password" maxlength='16' name="password"  placeholder="password" class="form-control" />
         @if ($errors->has('password'))
          <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
         @endif
        </div>
        <div class="form-group">
         <label class="control-label col-md-3">التيلفون</label>
         <div class="col-md-9">
          <input name="phone"  type="text" value="{{$users->phone}}" class="form-control" disabled/>
          <div class="has-error">
          <span class="help-block"><strong>الرجاء مراجعة الدعم الفني</strong></span>
         </div>
         </div>
        </div>
        <div class="form-group">
         <label class="control-label col-md-3">الوصف</label>
         <div class="col-md-9">
          <input name="address"  type="text" value="{{$users->address}}" class="form-control" />
         </div>
        </div>
        {{-- */$input='categories_list';/* --}}
        <div class="form-group {{ $errors->has($input) ? 'has-error' : '' }}">
            {!! Form::label($input,'النشاط التجاري',['class' => 'col-md-3 control-label']) !!}
            <div class="col-md-9">
                <select class="form-control chosen" multiple size="{{sizeof($categories)}}" name="categories_list[]">
                  @foreach($categories as $k => $cat)
                      <option value="{{$k}}" @if(in_array($k,$user_categories)) selected @endif>{{$cat}}</option>
                  @endforeach
                </select>
            </div>
        </div>
       <div class="form-group {{ $errors->has('charge_cost') ? ' has-error' : '' }}">
           <label class="control-label col-md-3">رسوم التوصيل</label>
           <div class="col-md-9">
               <input name="charge_cost" type="number" value="{{$users->charge_cost?$users->charge_cost:0}}" class="form-control" />
               @if ($errors->has('charge_cost'))
               <span class="help-block"><strong>{{ $errors->first('charge_cost') }}</strong></span>
               @endif
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
 </div>
@endsection