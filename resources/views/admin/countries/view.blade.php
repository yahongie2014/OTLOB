@extends('layouts.adminv2')
@section('title')
الدول
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
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <div class="portlet-title">
                    <!--<div class="caption">
                        <i class="icon-settings font-red"></i>
                        <h4 class="header-title m-t-0 m-b-30">جميع المنتجات</h4>
                    </div>-->
                </div>

                <div class="card-box table-responsive">

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{URL('/admin/newcountry')}}">
                                        <button id="sample_تعديلable_1_new" class="btn green"> اضافه دولة
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th> رقم الدولة </th>
                            <th> اسم الدولة </th>
                            <th> رمز الدولة </th>
                            <th> عملة الدولة </th>
                            <th> رمز عملة الدولة </th>
                            <th> العلم </th>
                            <th> الحالة </th>
                            <th> تعديل </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($nations as $nation)
                        <tr>
                            <td> {{$nation->id}} </td>
                            <td> {{$nation->name}} </td>
                            <td> {{$nation->code}} </td>
                            <td> {{$nation->currency_name}} </td>
                            <td> {{$nation->currency_code}} </td>
                            <td> <img id="countryImage" style="max-width: 16px;" src="@if($nation->flag){{asset('/' . $nation->flag)}}@else {{asset('/uploads/flag.png')}} @endif" /> </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-flat {{$statusColors[$nation->status]}} dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                        @if($nation->status == 0)
غير مفعل
                                        @else
                                        مفعل
                                        @endif
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        @if($nation->status == 0 )
                                        <li role="presentation"><a href="{{url('/admin/countrystatus/' . $nation->id . '/1'  )}}" role="menuitem" tabindex="-1" id="edit">تفعيل</a></li>
                                        @else
                                        <li role="presentation"><a href="{{url('/admin/countrystatus/' . $nation->id . '/0'  )}}" role="menuitem" tabindex="-1" id="edit">ايقاف</a></li>
                                        @endif


                                    </ul>
                                </div>
                            </td>
                            <td><a class="تعديل" href="{{URL('/admin/countries/edit',$nation->id)}}"> <i class="fa fa-edit"></i> </a></td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection

