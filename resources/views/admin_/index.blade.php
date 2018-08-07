@extends('layouts.adminv2')
@section('title')
التقارير
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

<div class="col-lg-3 col-md-6">
<div class="card-box">
<h4 class="header-title m-t-0 m-b-30">إجمالى المبيعات</h4>
<div class="widget-chart-1">
<div class="widget-chart-box-1">
<input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#f05050 "
   data-bgColor="#F9B9B9" value="{{$order_count}}"
   data-skin="tron" data-angleOffset="180" data-readOnly=true
   data-thickness=".15"/>
</div>

<div class="widget-detail-1">
<h2 class="p-t-10 m-b-0"> {{$order_count}} </h2>
<p class="text-muted">إجمالى المبيعات</p>
</div>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card-box">
<h4 class="header-title m-t-0 m-b-30">عدد المنتجات</h4>
<div class="widget-chart-1">
        <div class="widget-chart-box-1">
            <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="pink"
                   data-bgColor="#F9B9B9" value="{{$product_count}}"
                   data-skin="tron" data-angleOffset="180" data-readOnly=true
                   data-thickness=".15"/>
        </div>

        <div class="widget-detail-1">
            <h2 class="p-t-10 m-b-0"> {{$product_count}} </h2>
            <p class="text-muted">إجمالى مبيعات </p>
        </div>
    </div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card-box">
<h4 class="header-title m-t-0 m-b-30">عدد التقييميات</h4>

<div class="widget-chart-1">
<div class="widget-chart-box-1">
<input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#ffbd4a"
   data-bgColor="#FFE6BA" value="{{$feed_count}}"
   data-skin="tron" data-angleOffset="180" data-readOnly=true
   data-thickness=".15"/>
</div>
<div class="widget-detail-1">
<h2 class="p-t-10 m-b-0"> {{$feed_count}} </h2>
<p class="text-muted">جميع التقييميات </p>
</div>
</div>
</div>
</div>
@if(Auth::User()->is_admin == 1)
<div class="col-lg-3 col-md-6">
<div class="card-box">
<h4 class="header-title m-t-0 m-b-30">جميع المستخدمين</h4>
<div class="widget-chart-1">
        <div class="widget-chart-box-1">
            <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#0da357"
                   data-bgColor="grey" value="{{$user_count}}"
                   data-skin="tron" data-angleOffset="180" data-readOnly=true
                   data-thickness=".15"/>
        </div>

        <div class="widget-detail-1">
            <h2 class="p-t-10 m-b-0"> {{$user_count}} </h2>
            <p class="text-muted">جميع المستخدمين المسجلين</p>
        </div>
    </div>
</div>
</div>
@else
@endif
</div>

<div class="row">

    <div class="col-lg-4">
        <div class="card-box">

            <h4 class="header-title m-t-0">عدد المشاهدات</h4>

            <div class="widget-chart text-center">
                <div id="morris-donut-example"style="height: 245px;"></div>
                <ul class="list-inline chart-detail-list m-b-0">
                    <li>
                        <h4 style="color: #ff8acc;"><i class="fa fa-circle m-r-7"></i>مطاعم</h4>
                    </li>
                    <li>
                        <h4 style="color: #5b69bc;"><i class="fa fa-circle m-r-2"></i>حفلات</h4>
                    </li>
                    <li>
                        <h4 style="color: #ff3111;"><i class="fa fa-circle m-r-3"></i>طباخات</h4>
                    </li>
                    <li>
                        <h4 style="color: #0da357;"><i class="fa fa-circle m-r-4"></i>احتيجات الخدمه</h4>
                    </li>
                    <li>
                        <h4 style="color: #8a1f11;"><i class="fa fa-circle m-r-6"></i>منسق حفلات</h4>
                    </li>

                </ul>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-4">
        <div class="card-box">
            <h4 class="header-title m-t-0">إجمالى المبيعات السنوية</h4>
            <div id="morris-bar-example" style="height: 280px;"></div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-4">
        <div class="card-box">
            <h4 class="header-title m-t-0">إجمالى المكاسب</h4>
            <div id="morris-line-example" style="height: 280px;"></div>
        </div>
    </div>
</div>
@endsection
