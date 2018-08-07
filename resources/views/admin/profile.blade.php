@extends('layouts.adminv2')
@section('title')
{{ Auth::user()->user_name }}
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
<div class="col-sm-8">
<div class="bg-picture card-box">
<div class="profile-info-name">
<img src="{{ Auth::user()->pic }}" class="img-thumbnail" alt="profile-image">

<div class="profile-info-detail">
<h3 class="m-t-0 m-b-0">{{ Auth::user()->user_name }}</h3>
<p class="text-muted m-b-20"><i>{{ Auth::user()->phone }}</i></p>
<p>Hi I'm Alexandra Clarkson,has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type.Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC,making it over 2000 years old.Contrary to popular belief, Lorem Ipsum is not simplyrandom text. It has roots in a piece of classical Latin literature from 45 BC.</p>

<div class="button-list m-t-20">
<button type="button" class="btn btn-facebook btn-sm waves-effect waves-light">
<i class="fa fa-facebook"></i>
</button>

<button type="button" class="btn btn-sm btn-twitter waves-effect waves-light">
<i class="fa fa-twitter"></i>
</button>

<button type="button" class="btn btn-sm btn-linkedin waves-effect waves-light">
<i class="fa fa-linkedin"></i>
</button>

<button type="button" class="btn btn-sm btn-dribbble waves-effect waves-light">
<i class="fa fa-dribbble"></i>
</button>

</div>
</div>

<div class="clearfix"></div>
</div>
</div>
<!--/ meta -->



<form method="post" class="card-box">
<span class="input-icon icon-right">
<textarea rows="2" class="form-control" placeholder="Post a new message"></textarea>
</span>
<div class="p-t-10 pull-right">
<a class="btn btn-sm btn-primary waves-effect waves-light">Send</a>
</div>
<ul class="nav nav-pills profile-pills m-t-10">
<li>
<a href="#"><i class="fa fa-user"></i></a>
</li>
<li>
<a href="#"><i class="fa fa-location-arrow"></i></a>
</li>
<li>
<a href="#"><i class=" fa fa-camera"></i></a>
</li>
<li>
<a href="#"><i class="fa fa-smile-o"></i></a>
</li>
</ul>

</form>


</div>

</div>
@endsection