@extends('layouts.adminv2')
@section('title')
اشعارات المستخدم
@endsection
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <h4 class="header-title m-t-0 m-b-30"></h4>
                    </div>
                </div>
                <div class="card-box table-responsive">
                    @foreach($userNotifications as $k => $notification)
                        <div class="list-group">
                            <a href="{{$notification->action_link}}" class="list-group-item @if($notification->seen == 0 ) list-group-item-success @else list-group-item-info @endif">
                                <h4 class="list-group-item-heading">{{$notification->title}}</h4>
                                <p class="list-group-item-text" style="color: black;font-weight: bold;">{{$notification->body}}</p>
                            </a>
                        </div>
                    @endforeach

                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection
