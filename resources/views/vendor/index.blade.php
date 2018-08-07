@extends('layouts.admin')
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
    {{ csrf_field() }}
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
        {{-- <div class="widget-chart-box-1">
            <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="pink"
                   data-bgColor="#F9B9B9" value="{{$product_count}}"
                   data-skin="tron" data-angleOffset="180" data-readOnly=true
                   data-thickness=".15"/>{{$product_count}}
        </div> --}}

        <div class="widget-chart-box-1" style="border-radius: 50%;display:inline;width:80px;height:80px;border: 6px solid #F9B9B9;vertical-align: middle;text-align: center;">
            <div style="font-size: 20px; color:red;margin-top: 28%;">
                {{@$product_count}}
            </div>

        </div>

        <div class="widget-detail-1">
            <h2 class="p-t-10 m-b-0"> {{$product_count}} </h2>
            <p class="text-muted">إجمالى المنتجات </p>
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
        <!--<div class="widget-chart-box-1">
            <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#0da357"
                   data-bgColor="#FFE6BA" value="{{$user_count}}"
                   data-skin="tron" data-angleOffset="200" data-readOnly=true
                   data-thickness=".15"/>
        </div>-->
    <div class="widget-chart-box-1" style="border-radius: 50%;display:inline;width:80px;height:80px;border: 6px solid #F9B9B9;vertical-align: middle;text-align: center;">
        <div style="font-size: 20px; color:red;margin-top: 28%;">
            {{@$user_count}}
        </div>

    </div>
        <div class="widget-detail-1">
            <h2 class="p-t-10 m-b-0"> {{@$user_count}} </h2>
            <p class="text-muted">جميع المستخدمين</p>
        </div>
    </div>
</div>
</div>

@endif
    @if(Auth::User()->is_admin == 1)
        @foreach(@$status_count as $k => $v)
        <a href="{{url('/admin/getproductsbystatus/' . $v->status)}}">
        <div class="col-lg-4 col-md-6">
            <div class="card-box">

                <div class="widget-chart-1">
                    <div class="widget-chart-box-1">
                        <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="#f05050 "
                               data-bgColor="#F9B9B9" value="{{$v->status_count}}"
                               data-skin="tron" data-angleOffset="180" data-readOnly=true
                               data-thickness=".15"/>
                    </div>

                    <div class="widget-detail-1">
                        <h2 class="p-t-10 m-b-0"> {{$v->status_count}} </h2>
                        <p class="text-muted">@if($v->status == 0)
                            في انتظار التفعيل
                            @elseif($v->status == 1)
                            مفعل
                            @else
                            موقوف
                            @endif</p>
                    </div>
                </div>
            </div>
        </div>
        </a>
        @endforeach
    @endif
</div>

<div class="row">

    <div class="col-lg-12">
        <div class="card-box">

            <h4 class="header-title m-t-0">عدد المشاهدات</h4>

            <div class="widget-chart text-center">
                <div id="morris-donut-example"style="height: 245px;"></div>
                <ul class="list-inline chart-detail-list m-b-0" id="mainCtegories">


                </ul>
            </div>
        </div>
    </div><!-- end col -->
    <div class="col-lg-12">
        <div class="card-box">

            <h4 class="header-title m-t-0">الطلبات</h4>

            <div class="widget-chart text-center">
                <div id="morris-donut-example2"style="height: 245px;"></div>
                <ul class="list-inline chart-detail-list m-b-0" id="ordersByStatus">


                </ul>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-12">
        <div class="card-box">
            <h4 class="header-title m-t-0">إجمالى المبيعات السنوية</h4>
            <div id="morris-bar-example" style="height: 280px;"></div>
        </div>
    </div><!-- end col -->

    <div class="col-lg-12">
        <div class="card-box">
            <h4 class="header-title m-t-0">إجمالى المكاسب</h4>
            <div id="morris-line-example" style="height: 280px;"></div>
        </div>
    </div>
</div>
@endsection


@section('footer')
@parent
<!-- Dashboard init -->
<script src="{{asset('')}}assets/pages/jquery.dashboard.js"></script>
<script type="text/javascript">
    //$.Dashboard1.init();
    $(function(){
        var postData = {_token: $("input[name='_token']").val()}
        $.ajax({
            url: '{{url('/')}}' + "/statistics",
            type: 'GET',
            data: postData,
            dataType: 'JSON',
            success: function (data) {
                //
                createCategoriesBarColors(data.data.viewsall,function(categoriesColors){
                    $.Dashboard1.init(data.data.sales , data.data.catSales , data.data.viewsall,categoriesColors);
                })

                createOrderByStatusColors(data.data.orders,function(orderStatusColors){
                    $.Dashboard1.init2(data.data.orders,orderStatusColors);
                })
            }
        });
    })

    function createCategoriesBarColors(categories,callback){
        $("#mainCtegories").html("");
        var selectedColors = [];
        $.each(categories,function(key,value){
            var catColor = getRandomColor();
            selectedColors.push(catColor);
            var newCategoryIntheBar = '<li><h4 style="color: ' + catColor + ';"><i class="fa fa-circle m-r-2"></i>  ' + value.label + ' </h4></li>';
            $("#mainCtegories").append(newCategoryIntheBar);
        })
        callback(selectedColors);
    }

    function createOrderByStatusColors(ordersByStatus,callback){
        $("#ordersByStatus").html("");
        var selectedColors = [];
        $.each(ordersByStatus,function(key,value){
            var catColor = getRandomColor();
            selectedColors.push(catColor);
            var newOrderStatusIntheBar = '<li><a href ="'+value.link+'"><h4 style="color: ' + catColor + ';"><i class="fa fa-circle m-r-2"></i>  '+ value.label+'</h4></a></li>';
            $("#ordersByStatus").append(newOrderStatusIntheBar);
        })
        callback(selectedColors);
    }


    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>
@endsection