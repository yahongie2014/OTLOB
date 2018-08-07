@extends('layouts.adminv2')
@section('title')
ايام خارج الخدمة
@endsection
@section('content')

<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12">
        <div class="card-box table-responsive">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <h4 class="header-title m-t-0 m-b-30">ايام خارج الخدمة</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-6  col-sm-12 col-xs-12">
                    <form method="post" action="{{url('/vendors/product/exception/' . $product_id)}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label mb-10 text-left">تاريخ جديد</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' onkeydown="return false"  class="form-control" id="exception_date" data-provide="datepicker" name="exception_date" />
                                    <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label class="control-label mb-10 text-left"> </label>
                                <div >
                                    <button type="submit" class="btn btn-danger btn-rounded">
                                        اضافة
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

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
                        <th>#</th>
                        <th> اليوم </th>
                        <th> مسح </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vendor_product_Exeption as $report)
                    <tr>

                        <td>{{$report->id}}</td>
                        <td>{{$report->date}}</td>
                        <td><a onclick="return confirm('هل تريد حذف هذا اليوم ؟');" class="مسح" href="{{URL('/vendors/product/exceptiondelete',$report->id)}}"> <i class="fa fa-trash"></i> </a></td>
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
@section('footer')
@parent
<script>
    $(document).ready(function() {
        $('#exception_date').datepicker({
            format: "yyyy-mm-dd",
        })
    });
</script>
@endsection
