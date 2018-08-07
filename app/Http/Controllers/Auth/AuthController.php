<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Nations;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Validator;
use Input;
use Twilio;
use Event;
use Session;
use DB;
use Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite as Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Socialite $socialite,Guard $auth)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->socialite = $socialite;
        $this->auth = $auth;

    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //dd("sss");
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
//            dd(Auth::guard($this->getGuard())->user()->toArray());
            $user = Auth::guard($this->getGuard())->user();
            if($user->is_admin == 1 || $user->is_vendor == 1)
                return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }


    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    //facebook
    public function handleProviderCallback()
    {
            try  {
                $user = Socialite::driver('facebook')->user();
            } catch (Exception $e) {
                return Redirect::to('auth/facebook');
            }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    private function findOrCreateUser($facebookUser)
    {
        if ($authUser = User::where('email', $facebookUser->email)->first()) {
            return $authUser;
        }
        return User::create([
            'user_name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'fb_id' => $facebookUser->id,
            'pic' => $facebookUser->avatar
        ]);
        $token = Session::get('remember_token');
        $fb->setDefaultAccessToken($token);
    }

    //twitter
    public function redirectToProvidertwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProvidetwitter()
    {
        try  {
            $user = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/twitter');
        }

        $authUser = $this->findOrCreateUsertwitter($user);

        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    private function findOrCreateUsertwitter($twitterUser)
    {
        if ($authUser = User::where('user_name', $twitterUser->user_name)->first()) {
            return $authUser;
        }
        return User::create([
            'user_name' => $twitterUser->name,
            'twitter_id' => $twitterUser->id,
            'pic' => $twitterUser->avatar
        ]);
    }

    //github
    public function redirectToProvidergit()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProvidegit()
    {

        try  {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/github');
        }
        $authUser = $this->findOrCreateUsergit($user);

        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    private function findOrCreateUsergit($gitUser)
    {
        if ($authUser = User::where( 'email' ,$gitUser->email )->first()) {
            return $authUser;
        }
        return User::create([
            'user_name' => $gitUser->name,
            'email' => $gitUser->email,
            'github_id' => $gitUser->id,
            'pic' => $gitUser->avatar
        ]);
    }

    //google
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProvideGoogle()
    {

        try  {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {

            return Redirect::to('auth/google');
        }
        $authUser = $this->findOrCreateUsergoogle($user);

        Auth::login($authUser, true);

        return Redirect::to('/');
    }

    private function findOrCreateUsergoogle($googleUser)
    {
        if ($authUser = User::where('email', $googleUser->email)->first()) {
            return $authUser;
        }
        return User::create([
            'user_name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'pic' => $googleUser->avatar
        ]);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //$data['phone'] = '+' . $data['dialcode'] . $data['phone'];
        if($data['phone'] && $data['nation_id']){
            $data['phone'] = $this->getPhoneWithCode(ltrim($data['phone'],"0"),$data['nation_id']);
        }
        return Validator::make($data, [
            'user_name' => 'required|max:255',
            'phone' => 'required|digits_between:8,15|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6|max:9|string',
            'cat_id' => 'required|array',
            'nation_id' => 'required|exists:nations,id'
        ]);
    }

    protected function getPhoneWithCode($phone,$country_id){
        $countryCode = Nations::where('id', $country_id)->first();

        if ($countryCode)
            $phone = $countryCode->code . $phone;

        return $phone;
    }

    public function userActivation($email)
    {

        if( ! $email)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::where('email',$email)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->verified = 1;
        $user->is_vendor = 1;
        $user->save();


        //return Redirect::to('/home')->with('message',"your Account Activated");

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        //$this->redirectTo = '/login';
        $url = asset('');
        $verify = rand(0000,9999);
        $token = str_random(64);
        $data['verify'] = $verify;
        $data['phone'] = $this->getPhoneWithCode(ltrim($data['phone'],"0"),$data['nation_id']);
        DB::beginTransaction();
           $user = User::create([
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                //'phone' => "+" . $data['dialcode'] . $data['phone'],
                'phone' => $data['phone'],
                'v_code' => $verify,
                'token' => $token,
                //'country' => $data['country'],
                'type' => 3,
                'is_vendor' => $data['is_vendor']?$data['is_vendor']:0,
                'password' => bcrypt($data['password']),
               'nation_id' => intval($data['nation_id']),
            ]);

        \Mail::send('auth.emails.verify',$data, function($message)use($data) {
            $message->to($data['email'],$data['user_name'])->subject('verify');
        });
            if($user){
                $user->categories()->sync($data['cat_id']);
            }

        DB::commit();

        Request()->session()->flash('status', 'تم انشاء حسابك برجاء مراجعة بريدك الالكتروني للتفعيل');

        return $user;
    }
}
