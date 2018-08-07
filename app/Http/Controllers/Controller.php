<?php

namespace App\Http\Controllers;

use DB;
use FCM;
use Log;
use App\User;
use App\Logs;
use App\Product;
use App\WebNotification;
use App\ProductAvailibility;
use LaravelFCM\Message\Topics;
use LaravelFCM\Message\OptionsBuilder;
use Gloudemans\Shoppingcart\Facades\Cart;
use LaravelFCM\Message\PayloadDataBuilder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
define('TEAM','team');

define('MESSAGE' , 'message');

define("GOOGLE_API_KEY", "AAAAYxMtu7s:APA91bGpiW2SkGbc5zxsztDWjAEjKU512kReDKN4nc4iIBIGC-vy5uc7yS-9HyApk_ChP6IJGa4niL0cA1mKEeDAPDCIsmA7quzNpmEbRn-W6NFq6wqFl7AeJsTHube6GCdM7IpZfqrK");
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test(){
        //$this->sendNotifications("Test Test" ,"fffffff", 1);
        \Mail::send('auth.emails.verify2',[], function($message) {
            $message->to("amr.najip@gmail.com","Amr")->subject('verify');
        });
    }

    public function updateProductsWithNewGeder(){
        $productIds = Product::where('id',"<>",54)->pluck("id");
        //dd($productIds);
        DB::beginTransaction();
        foreach ($productIds as $productId){
            for($i = 0 ; $i <= 6 ; $i++) {
                for($j = 1 ; $j <= 3 ; $j++){
                    $productDayQunt = new ProductAvailibility();
                    $productDayQunt->product_id = $productId;
                    $productDayQunt->day_no = $i;
                    $productDayQunt->gender = "3";
                    $productDayQunt->period = $j;
                    $productDayQunt->quantity = 0;
                    $productDayQunt->save();
                }

            }
        }
        DB::commit();
    }

    public function sendNotifications($msg,$msgTitle,$type , $clickAction = "" ,$user = null){

        $message = array(TEAM => "test", MESSAGE => $msg);
        $url = "https://fcm.googleapis.com/fcm/send";

        if($type == 1){ // Admin
            $userTokens = User::where('is_admin',1)->where('token',"<>","");
        }elseif ($type == 2){ // Vendor
            $userTokens = User::where('is_vendor',1)->where('token',"<>","");
            if($user != null){
                $userTokens = $userTokens->where('id',$user);
            }
        }
        //dd($userTokens->pluck('token')->toArray());
        $usersData = $userTokens;
        $usersData = $usersData->pluck('id')->toArray();
        $userTokens = $userTokens->pluck('token')->toArray();

        foreach ($usersData as $userToNotify){
            WebNotification::create([
                'user_id' => $userToNotify,
                'title' => $msgTitle,
                'body' => $msg,
                'action_link' => $clickAction
            ]);
        }

        //$userTokens = implode("," , $userTokens);
        $fields = array(
            'registration_ids' => $userTokens,
            //'data' => $message,
            'notification' => [
                "title" => $msgTitle,
                "body" => $msg,
                "icon" => "http://www.iconarchive.com/download/i99487/webalys/kameleon.pics/Party-Poppers.ico",
                "click_action" => $clickAction
            ]
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        //        dd($result);
        if ($result === FALSE) {
            //die('Curl failed: ' . curl_error($ch));
            Log::error('Curl failed: ' . curl_error($ch));
        }
        else{
            //echo $result;
            Log::info($result);
        }

        return true;

        // Close connection
        /*curl_close($ch);*/


        //return response()->json(['result' => $downstreamResponse,'success' => true]);
    }

    public function sendNotificationsToUser($msg,$msgTitle,$user){

        $message = array(TEAM => "test", MESSAGE => $msg);
        $url = "https://fcm.googleapis.com/fcm/send";

        $userTokens = User::where('id',$user)->pluck('firebase_token')->toArray();

        WebNotification::create([
            'user_id' => $user,
            'title' => $msgTitle,
            'body' => $msg,

        ]);

        //$userTokens = implode("," , $userTokens);
        if(count($userTokens) > 0) {
            $fields = array(
                'registration_ids' => $userTokens,
                //'data' => $message,
                'notification' => [
                    "title" => $msgTitle,
                    "body" => $msg,
                ]
            );

            $headers = array(
                'Authorization: key=' . GOOGLE_API_KEY,
                'Content-Type: application/json'
            );
            // Open connection
            $ch = \curl_init();

            // Set the url, number of POST vars, POST data
            \curl_setopt($ch, CURLOPT_URL, $url);

            \curl_setopt($ch, CURLOPT_POST, true);
            \curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
           \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            \curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            // Execute post
            $result = \curl_exec($ch);
            //        dd($result);
            if ($result === FALSE) {
                //die('Curl failed: ' . curl_error($ch));
                Log::error('Curl failed: ' . curl_error($ch));
            } else {
                //echo $result;
                Log::info($result);
            }
        }
        return true;

        // Close connection
        /*curl_close($ch);*/


        //return response()->json(['result' => $downstreamResponse,'success' => true]);
    }

    public function getCurrencyRate($from_code , $to_code){
        $connectionString = "http://currencies.apps.grandtrunk.net/getrate/" . date("Y-m-d") . "/" . $from_code . "/" . $to_code ;
        $currRate = file_get_contents($connectionString);

        if($currRate){
            return $currRate;
        }else{
            return 1;
        }
    }

    public function SendSms($phone ,$message)
    {
        $data = array(
            "Username" => "966593930003",
            "Password" => "75627",
            "Tagname" => "Ratb.li",
            "RecepientNumber" => $phone,
            "VariableList" => "[Name]",
            "ReplacementList" => "Ahmed,9000",
            "Message" => $message,
            "SendDateTime" => 0,
            " EnableDR" => true
        );
        $data_string = json_encode($data);

        $ch = curl_init('http://api.yamamah.com/SendSMS');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        if ($result === FALSE) {
            Log::error('Curl failed: ' . curl_error($ch));
        }
        else{
            //echo $result;
            Log::info($result);
        }
    
        return true;
    
    }

    public function storeLogs($item_id, $type, $user_id, $description){
        $logs = new Logs;
        $logs->description = $description;
        $logs->item_id = $item_id;
        $logs->user_id = $user_id;
        $logs->type = $type;

        $logs->save();

        return true;
    }


/*    public function payfort_capture($merchant_reference, $order_description ,$amount,$fort_id){

        $signture = hash('sha256',"PASSaccess_code=B2XgLdkd9Rzt2ehZbbs3amount=".$amount."command=CAPTUREcurrency=SARfort_id=".$fort_id."language=armerchant_identifier=TETHkecgmerchant_reference=".$merchant_reference."order_description=".$order_description."PASS");

        $data = array(
            "command"=>"CAPTURE",
            "access_code"=> env("PAYFORT_ACCESS_CODE","B2XgLdkd9Rzt2ehZbbs3"),
            "merchant_identifier"=> env("PAYFORT_MERCHANT_IDENTIFIER","TETHkecg"),
            "merchant_reference"=>$merchant_reference,
            "amount"=> $amount,
            "currency"=> env("PAYFORT_CURRENCY","SAR"),
            "language"=> "ar",
            "fort_id"=> $fort_id,
            "signature"=> $signture,
            "order_description" => $order_description
        );
        $data_string = json_encode($data);

        $ch = curl_init('https://sbpaymentservices.payfort.com/FortAPI/paymentApi');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        if($result === false) {
            die(curl_error($ch));
        }

    }

    public function payfort_refund($merchant_reference, $order_description ,$amount,$fort_id){

        $signture = hash('sha256',"PASSaccess_code=B2XgLdkd9Rzt2ehZbbs3amount=".$amount."command=REFUNDcurrency=SARfort_id=".$fort_id."language=armerchant_identifier=TETHkecgmerchant_reference=".$merchant_reference."order_description=".$order_description."PASS");

        $data = array(
            "command"=>"REFUND",
            "access_code"=> env("PAYFORT_ACCESS_CODE","B2XgLdkd9Rzt2ehZbbs3"),
            "merchant_identifier"=> env("PAYFORT_MERCHANT_IDENTIFIER","TETHkecg"),
            "merchant_reference"=>$merchant_reference,
            "amount"=> $amount,
            "currency"=> env("PAYFORT_CURRENCY","SAR"),
            "language"=> "ar",
            "fort_id"=> $fort_id,
            "signature"=> $signture,
            "order_description" => $order_description
        );
        $data_string = json_encode($data);

        $ch = curl_init('https://sbpaymentservices.payfort.com/FortAPI/paymentApi');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        if($result === FALSE) {
            die(curl_error($ch));
        }
    }


*/
}