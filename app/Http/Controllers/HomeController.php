<?php

namespace App\Http\Controllers;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\info;
use App\Logs;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['userActivation' , 'verifyResend']]);
       // dd(Auth::check());

    }

    public function userActivation($vcode,$email)
    {
        // dd($email);
        $input = ['email' => $email , 'v_code' => $vcode];
        $validator = Validator::make($input, [
            'email' => 'required|email|exists:users,email',
            'v_code' => 'required|string|max:4|exists:users,v_code',

        ],
            [
                'v_code.max' => 'Wrog Code',
                'v_code.required' => 'Wrog Code',
                'v_code.string' => 'Wrog Code',
                'v_code.exists' => 'Wrog Code'
            ]);
        //dd($validator->errors()->all());
        $errors = [];
        if($validator->fails()){
            $errors = $validator->errors()->all();
        }else{
            $user = User::where('v_code',$vcode)->where('email',$email)->first();

            if($user){
                $user->verified = 1;
                $user->is_vendor = 1;
        //$user->save();
                if($user->save()){
                    $this->sendNotifications(" تم تأكيد مقدم الخدمة " . $user->user_name . " - verified " , "تأكيد مقدم خدمة" , 1,"#");
                }

            }else{
                $errors[] = "Invalid verify link";
            }

        }
        /*if( ! $vcode)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::where('v_code',$vcode)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }*/

        \Session::flash('err' , $errors);

        //dd($user);
        return Redirect::to('/home')
            ->with('message',"your Account Activated")
            ->with('err' , $errors);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = info::first();

        \Session::flash('favicon' , $info->favicon);
        \Session::flash('logo' , $info->pic);
        if( Auth::user()->is_admin  == 1 ){
            return redirect('/admin');
        }else{

            return redirect('/vendors');
        }
	    return view('home');
    }

    public function verifyResend(Request $request){

        $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);
        //dd($validator->errors()->all());
        $errors = [];
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }else{
            $user = User::where('email',$request->email)->first();
            if($user->verified != 1) {
                if ($user->attempts < 4) {
                    $data = $user->toArray();
                    $user->attempts += 1;

                    $user->save();
                    $data['verify'] = $user->v_code;
                    \Mail::send('auth.emails.verify', $data, function ($message) use ($data) {
                        $message->to($data['email'], $data['user_name'])->subject('verify');
                    });
                    $msg = "تم ارسال رسالة التفعيل الى بريدك الالكتروني";
                } else {
                    $this->SendSms($user->phone, "رابط تفعيل حسابك \n" . URL::to('confirm/' . $user->v_code . '/' . $user->email));
                    $msg = "تم ارسال رابط التفعيل على هاتفك";
                }

                Request()->session()->flash('status', $msg);
                return redirect('/login');
            }else{
                Request()->session()->flash('status', "حسابك مفعل");
                return redirect('/login');
            }
        }
    }

    public function logs(){
        $logs = Logs::with('user')->orderBy('id', 'desc')->get();
        return view('admin.logs.index')
            ->with('logs',$logs);
    }
}
