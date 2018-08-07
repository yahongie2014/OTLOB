@extends('layouts.adminv2')
@section('title')
History
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <h4 class="header-title m-t-0 m-b-30">History</h4>
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
                        <th> No.</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td>{{$report->id}}</td>
                        <td><a href="{{Url('/admin/report/')}}/{{$report->date}}">{{$report->date}}</a></td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection
