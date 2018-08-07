@extends('layouts.adminv2')

@section('title')
    سلة المشتريات
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> م </th>
                            <th align="center"> اسم العميل </th>
                            <th align="center"> رقم الهاتتف </th>
                            <th align="center"> منتجات السلة </th>
                            @if(Auth::user()->id == 1)<th width='5%'> حذف </th>@endif
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td align="center"> {{++$key}}</td>
                            <td align="center">
                                <a href="{{url('/admin/user/' . @$user->id.'/cart')}}" class="btn" role="button">
                                    {{@$user->user_name}}
                                </a>
                            </td>
                            <td align="right">{{@$user->phone}}</td>
                            {{-- <td align="center">{{sizeof(@$user['cart'])}}</td> --}}
                            <td align="right">
                                @foreach($user['cart'] as $k => $cart)
                                        {{++$k}}- {{@$cart['products']->name . ' (' .$cart->amount.') ' . ' بتاريخ ' . $cart->created_at}}
                                        <br>
                                @endforeach
                            </td>
                            @if(Auth::user()->id == 1)
                                <td>
                                    <a onclick="return confirm('Are you sure you want to delete cart of {{$user->user_name}}?');" href="{{url('/admin/user/'.$user->id.'/cart/delete/')}}" >
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            @endif
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
