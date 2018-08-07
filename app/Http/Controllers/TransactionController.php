<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use View;
use Input;

class TransactionController extends Controller
{
    public function __construct(CookieJar $cookieJar, Request $request)
    {
        $this->middleware('auth')->except('contact');

        $id = \Request::segment(4);
        Cookie::queue('referrer', true, 15);

        if($request->referrer){
            $cookieJar->queue(cookie('referrer', $request->referrer, 45000));
        }
    }

    public function Transaction_view(){

        $payment = Payment::select('*')
            ->leftjoin('users','payment.user_id','=','users.id')
            ->leftjoin('order_product','payment.order_description','=','order_product.order_id')
            ->select('users.user_name as tran_username','payment.status as tran_status',
                'payment.order_number as tran_order_number','payment.customer_ip as tran_ip',
                'payment.payment_status as tran_status','payment.created_at as tran_created','payment.payment_option as tran_type')
            ->get();
        return view('admin.transaction')->with('payment',$payment);
    }

    //Make Purshace for Authorise
    public function Purchase_Trancaction($tran_order_number){

        $success = Input::get('success');

        if ($tran_order_number) {
            $orfort = Payment::select('*')
                ->where('payment.order_number','=',$tran_order_number)
                ->limit(1)->get();
            $capture = $this->payfort_capture($orfort[0]->order_number,$orfort[0]->order_description,$orfort[0]->amount,$orfort[0]->fort_id);
             $done = Payment::where('payment.order_number','=',$tran_order_number)->update(['payment_status'=>1]);

            return Redirect::to("/admin/transaction?success=$tran_order_number")
                ->with('message', "order number $tran_order_number  Complete Transaction");
        }else{
            return Redirect::to("/admin/transaction?fail=$tran_order_number")
                ->with('danger',"No Success Transaction");
        }
    }

    //Make Refund for Authorise
    public function Refund_Trancaction($tran_order_number){
        if ($tran_order_number) {
            $orfort = Payment::select('*')
                ->where('payment.order_number',$tran_order_number)
                ->limit(1)->get();

            $refund = $this->payfort_refund($orfort[0]->order_number,$orfort[0]->order_description,$orfort[0]->amount,$orfort[0]->fort_id);
             $done = Payment::where('payment.order_number','=',$tran_order_number)->update(['payment_status'=>2]);

            return Redirect::to("/admin/transaction?success=$tran_order_number")
                ->with('message', "order number $tran_order_number  Refund Transaction");
        }else{
            return Redirect::to("/admin/transaction?fail=$tran_order_number")
                ->with('danger',"No Success Refund");
        }
    }


}
