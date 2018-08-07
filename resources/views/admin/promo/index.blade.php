@extends('layouts.adminv2')
@section('title')
اكواد الخصومات
@endsection
@section('content')


<div class="row">
    <div class="col-md-12">
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
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <h4 class="header-title m-t-0 m-b-30">جميع اكواد الخصم</h4>
                </div>
            </div>

            <div class="card-box table-responsive">
                <div class="row">
                    <div class="table-toolbar">
                        <form method="post" action="{{url('/admin/promo/add')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="btn-group">
                                            <label >نسبة الخصم</label>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group">
                                            <input class="form-control" type="number" name="promo_value"  />


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group">

                                                <button type="submit" id="sample_تعديلable_1_new" class="btn green"> اضافه كود خصم
                                                    <i class="fa fa-plus"></i>
                                                </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th> رقم </th>
                        <th> الكود </th>
                        <th> نسبة الخصم </th>

                        <th> الحالة </th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($promoCodes as $code)
                    <tr>
                        <td> {{$code->id}} </td>
                        <td> {{$code->code}} </td>
                        <td> {{$code->value}} </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-flat dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                    @if($code->status == 0)
                                    غير مفعل
                                    @else
                                    مفعل
                                    @endif
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    @if($code->status == 0 )
                                    <li role="presentation"><a href="{{url('/admin/promo/update/' . $code->id . '/1'  )}}" role="menuitem" tabindex="-1" id="edit">تفعيل</a></li>
                                    @else
                                    <li role="presentation"><a href="{{url('/admin/promo/update/' . $code->id . '/0'  )}}" role="menuitem" tabindex="-1" id="edit">ايقاف</a></li>
                                    @endif


                                </ul>
                            </div>
                        </td>

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

