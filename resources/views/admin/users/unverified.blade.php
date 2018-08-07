@extends('layouts.adminv2')
@section('title')
مستخدمين غير مفعلين
@endsection
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <h4 class="header-title m-t-0 m-b-30">مستخدمين غير مفعلين</h4>
                </div>
            </div>
            <div class="card-box table-responsive">
                <br>
                <div class="btn-group">
                </div>
                <br>
                <br>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="1" width="100%">
                    <thead>
                    <tr>
                        <th> رقم المستخدم</th>
                        <th> هاتف المستخدم</th>
                        <th> كود التفعيل</th>
                        <th> تاربخ التسجيل</th>
                        <th>إرسال</th>
                        <th>تفعيل</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->v_code}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <a href="{{url('admin/twiloResend?phone='.$user->phone.'&v_code='.$user->v_code)}}" class="btn btn-flat btn-info">إعادة إرسال</a>
                            </td>
                            <td>
                                <a href="{{url('/admin/verifyuser/' . $user->id)}}" class="btn btn-flat btn-info">تفعيل</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection
