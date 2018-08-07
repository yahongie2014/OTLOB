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
      <i class="fa fa-gift"></i> تعديل {{$users->user_name}}
    </div>
  </div>
  <div class="portlet-body form">
   <!-- BEGIN FORM-->
   <form method="post" action="{{ URL::Route('AdminUserUpdate') }}"class="form-horizontal form-bordered" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{$users->id}}">
    <div class="form-body">
     <div class="form-group">
      <label class="control-label col-md-3">إسم المستخدم</label>
      <div class="col-md-9">
       <input maxlength="8" required name="user_name" type="text" placeholder="{{$users->user_name}}" value="{{$users->user_name}}" class="form-control" />
     </div>
   </div>
   <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
    <label class="control-label col-md-3">الاميل</label>
    <div class="col-md-9">
     <input required name="email" type="email" placeholder="{{$users->email}}" value="{{$users->email}}" class="form-control" {{(!$can_update?'readonly':'')}}/>
     @if ($errors->has('email'))
     <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
     @endif
   </div>
 </div>
 <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
  @if($can_update)
  <label class="control-label col-md-3">كلمه المرور</label>
  <div class="col-md-9">
   <input required type="password" maxlength='16' name="password"  placeholder="password" class="form-control" />
   @if ($errors->has('password'))
   <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
   @endif
 </div>
 @endif
 <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
   <label class="control-label col-md-3">التيلفون</label>
   <div class="col-md-3">
    <input name="phone"  type="text" placeholder="{{$users->phone}}" maxlength='15' value="{{$users->phone}}" class="form-control" />
    @if ($errors->has('phone'))
      <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
    @endif
  </div>
</div>
<div class="form-group">
 <label class="control-label col-md-3">الوصف</label>
 <div class="col-md-9">
  <input name="address" type="text" placeholder="{{$users->address}}" value="{{$users->address}}" class="form-control" />
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
 <label class="control-label col-md-3">مصاريف الشحن</label>
 <div class="col-md-9">
  <input name="charge_cost" type="number" placeholder="{{$users->charge_cost}}" value="{{$users->charge_cost?$users->charge_cost:0}}" class="form-control" />
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
       <i class="fa fa-check"></i> تعديل</button>
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
<script src="{{asset('')}}build/js/intlTelInput.js"></script>
<script>
    $("#phone").intlTelInput({
        utilsScript: "{{asset('')}}build/js/utils.js"
    });
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Password Must be Matching.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }
    $(document).ready(function() {
        $("#phone").keydown(function (e) {
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
        });
    });
</script>
@endsection