
@extends('layouts.product')
@section('title')
    اضافه منتج جديد
@endsection
@section('content')
<style>
    table {
        font-family: sans-serif;
        width: 100%;
        border-spacing: 0;
        border-collapse: separate;
        table-layout: fixed;
        margin-bottom: 50px;
        direction: ltr;
    }
    table thead tr th {
        background: #626E7E;
        color: #d1d5db;
        padding: 0.5em;
        overflow: hidden;
        text-align: center;
    }
    table thead tr th:first-child {
        border-radius: 3px 0 0 0;
    }
    table thead tr th:last-child {
        border-radius: 0 3px  0 0;
    }
    table thead tr th .day {
        display: block;
        font-size: 1.2em;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        margin: 0 auto 5px;
        padding: 5px;
        line-height: 1.8;
    }
    table thead tr th .day.active {
        background: #d1d5db;
        color: #626E7E;
    }
    table thead tr th .short {
        display: none;
    }
    table thead tr th i {
        vertical-align: middle;
        font-size: 2em;
    }
    table tbody tr {
        background: #d1d5db;
    }
    table tbody tr:nth-child(odd) {
        background: #c8cdd4;
    }
    table tbody tr:nth-child(6n+0) td {
        border-bottom: 1px solid #626E7E;
    }
    table tbody tr td {
        text-align: center;
        vertical-align: middle;
        border-left: 1px solid #626E7E;
        position: relative;
        height: 32px;
        cursor: pointer;
    }
    table tbody tr td:last-child {
        /*border-right: 1px solid #626E7E;*/
    }
    table tbody tr td.hour {
        font-size: 2em;
        padding: 0;
        color: #626E7E;
        background: #fff;
        border-bottom: 1px solid #626E7E;
        border-collapse: separate;
        min-width: 100px;
        cursor: default;
    }
    table tbody tr td.hour span {
        display: block;
    }
    @media (max-width: 60em) {
        table thead tr th .long {
            display: none;
        }
        table thead tr th .short {
            display: block;
        }
        table tbody tr td.hour span {
            transform: rotate(270deg);
            -webkit-transform: rotate(270deg);
            -moz-transform: rotate(270deg);
        }
    }
    @media (max-width: 27em) {
        table thead tr th {
            font-size: 65%;
        }
        table thead tr th .day {
            display: block;
            font-size: 1.2em;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            margin: 0 auto 5px;
            padding: 5px;
        }
        table thead tr th .day.active {
            background: #d1d5db;
            color: #626E7E;
        }
        table tbody tr td.hour {
            font-size: 1.7em;
        }
        table tbody tr td.hour span {
            transform: translateY(16px) rotate(270deg);
            -webkit-transform: translateY(16px) rotate(270deg);
            -moz-transform: translateY(16px) rotate(270deg);
        }
    }

</style>
    <?php
    $cat = App\Category::Select('*')->get();
    ?>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> اضافه منتج جديد
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal"  enctype="multipart/form-data" accept-charset="UTF-8" action="{{URL('/vendors/product/add/new')}}" method="post" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">اسم المنتج
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="name" data-required="1"  placeholder="الاسم" class="form-control" required maxlength='35' /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">سعر المنتج
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" min='0' name="price" data-required="1" onkeypress="return isNumberKey(event)"  placeholder="سعر المنتج" class="form-control" required /> </div>س.ر
                            </div>
                            <!--<div class="form-group">
                                <label class="control-label col-md-3">العدد المتاح
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" min='0' name="max_num" data-required="1" onkeypress="return isNumberKey(event)"  placeholder="العدد المتاح" class="form-control" required /> </div>
                            </div>
-->

                            <input type="hidden" min='1' name="max_num" value="2" />
                            <div class="form-group">
                                <label class="control-label col-md-3">نوع الخدمه
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="cat_id" required>
                                        <option value="">اختر..</option>
                                        @foreach($userCategories as $cats)
                                            <option value="{{$cats->id}}">{{$cats->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label class="control-label col-md-3">وقت التحضير <span class="required"> * </span></label>
                                <div class="col-md-3">
                                    <div class="input-group m-b-15">
                                        <div class="bootstrap-timepicker">
<!--                                            <input id="timepicker2" name="prepration_time" type="text" class="form-control">-->
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="number" min='0' name="preperation_min" class="form-control" value="0" />

                                                </div>
                                                <div class="col-md-2" style="font-size: 25px;text-align: center;">
                                                :
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" min='0' name="preperation_hour" class="form-control" value="0" placeholder="ساعة" />
                                                </div>
                                            </div>
                                        </div>

                                        <span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">معلومات المنتج
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <textarea type="text" name="desc" data-required="1"  placeholder="ملاحظات" class="form-control" /> </textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">مقدم الخدمه
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <select class="form-control select2me" name="gender" id="genderSelector" required>
                                            <option value="-1">اختر..</option>
                                            <option value="0">رجال</option>
                                            <option value="1">نساء</option>
                                            <option value="2">رجال ونساء</option>
                                            <option value="3">لا يحتاج مقدمي خدمة</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">متطلبات التشغيل
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" name="requirement" value="" data-role="tagsinput" placeholder="متطلبات التشغل" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <input type="radio" name="fawry" value="0"checked> هذا الطلب يحتاج وقت للتحضير *<br>
                            <hr>
                            <input type="radio" name="fawry" value="1" > هذا الطلب لا يحتاج وقت للتحضير *<br>
                            <hr>

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">صوره المنتج الرئيسية
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="file" class="form-control" name="pic" placeholder="Upload Image" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">صور المنتج في المعرض
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="file" class="form-control" name="img[]" placeholder="Upload Image" multiple="true" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>

                                                    <span class="long">صباحا</span>

                                                </th>
                                                <th>

                                                    <span class="long">ظهرا</span>

                                                </th>
                                                <th>

                                                    <span class="long">ليلا</span>

                                                </th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($weekDays as $k => $v)
                                                <tr>
                                                    <td class="hour" rowspan="6"><span>{{$v}}</span></td>
                                                    <td class="colsman gendercols">رجال</td>
                                                    <td class="colsman gendercols">رجال</td>
                                                    <td class="colsman gendercols">رجال</td>
                                                </tr>
                                                <tr>
                                                    <td class="colsman gendercols"><input type="number" min='0' name="qunt[{{$k}}][1][1]" class="form-control gendercolsinput" value="0" /></td>
                                                    <td class="colsman gendercols"><input type="number" min='0' name="qunt[{{$k}}][1][2]" class="form-control gendercolsinput" value="0" /> </td>
                                                    <td class="colsman gendercols"><input type="number" min='0' name="qunt[{{$k}}][1][3]" class="form-control gendercolsinput" value="0"/></td>
                                                </tr>
                                                <tr>
                                                    <td class="colswoman gendercols">نساء</td>
                                                    <td class="colswoman gendercols">نساء</td>
                                                    <td class="colswoman gendercols">نساء</td>
                                                </tr>
                                                <tr>
                                                    <td class="colswoman gendercols"><input type="number" min='0' name="qunt[{{$k}}][2][1]" class="form-control gendercolsinput" value="0" /></td>
                                                    <td class="colswoman gendercols"><input type="number" min='0' name="qunt[{{$k}}][2][2]" class="form-control gendercolsinput" value="0" /> </td>
                                                    <td class="colswoman gendercols"><input type="number" min='0' name="qunt[{{$k}}][2][3]" class="form-control gendercolsinput" value="0" /></td>
                                                </tr>
                                                <tr>
                                                    <td class="colscount gendercols"> </td>
                                                    <td class="colscount gendercols"> </td>
                                                    <td class="colscount gendercols"> </td>
                                                </tr>
                                                <tr>
                                                    <td class="colscount gendercols"><input type="number" min='0' name="qunt[{{$k}}][3][1]" class="form-control gendercolsinput" value="0" /></td>
                                                    <td class="colscount gendercols"><input type="number" min='0' name="qunt[{{$k}}][3][2]" class="form-control gendercolsinput" value="0" /> </td>
                                                    <td class="colscount gendercols"><input type="number" min='0' name="qunt[{{$k}}][3][3]" class="form-control gendercolsinput" value="0" /></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn blue ">اضافه</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade none-border" id="add-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><strong>اضافه كميه للوقت </strong></h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">الكميه</label>
                                <input class="form-control form-white" placeholder="Quantity" type="text" name="quantity"/>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">الوقت</label>
                                <select class="form-control form-white" data-placeholder="ختر وقت الكميه" name="time">
                                    <option value="صباحاُ">افطار</option>
                                    <option value="ظهراً">عشاء</option>
                                    <option value="مساءُ">سحور</option>
                                    <option value="طول اليوم">طول اليوم</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button href="{{url('/product/view')}}" type="button" class="btn btn-default waves-effect" data-dismiss="modal">الغاء</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade none-border" id="event-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><strong>تعديل</strong></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-success save-event waves-effect waves-light">تم</button>
                    <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">مسح</button>
                </div>
            </div>
        </div>
    </div>
    <!--<script src="https://code.jquery.com/jquery-latest.min.js"></script>-->


@endsection

@section('footer')
@parent
<script language=Javascript>
    <!--
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    //-->
</script>
<script type="text/javascript">

$(function(){
    console.log("ddd");
    showGenderOnPeriodes($("#genderSelector").val())
    $("#genderSelector").change(function () {
        showGenderOnPeriodes($(this).val());
    })

    function showGenderOnPeriodes(genderType){
        console.log(genderType)
        switch(genderType){
            case "-1":
                $(".colsman , .colswoman").show();

                break;
            case "2":
                $(".colsman , .colswoman").show();
                $(".colscount").hide();
                    $(".gendercolsinput").val("0");
                break;
            case "0":
                $(".gendercols").hide();
                $(".colsman").show();
                    $(".gendercolsinput").val("0")
                break;
            case "1":
                $(".gendercols").hide();
                $(".colswoman").show();
                    $(".gendercolsinput").val("0")
                break;
            case "3":
                $(".gendercols").hide();
                $(".colscount").show();
                    $(".gendercolsinput").val("0");
                break;
        }
    }

});


</script>
@endsection



