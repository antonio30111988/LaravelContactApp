<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @param Provider name
     *
     * @return Response
     */
    public function redirectionToProvider($provider)
    {
        if($provider=="google" )
		return Socialite::driver($provider)->scopes(['profile','email'])->redirect();
	
	return Socialite::driver($provider)->redirect(); 
    }

    /**
     * Retrieve user info from provider. Check if user already exists in our
     * database.
     *
     * @param Provider name
     *
     * @return Response
     */
    public function handlingProviderCallback(Request $request,$provider)
    {
        if($provider=="facebook" )
		$user = Socialite::with($provider)->user();
		else
		$user = Socialite::driver($provider)->user();
		
		//if($user->name==null)
		//	$user->name="No name";

        $authUser = $this->findOrCreateUser($user, $provider);
		
		if(!$authUser) 
			return redirect('/')->withNotification("User with same email adress already exist!");
        
        //login and redirect to homepage
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    /**
     * Check if a user has registered.If yes return the user
     * else, create and save new user object.
     *
     * @param  $user Socialite user object
     * @param $provider Auth provider
     * @return  User object
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
		$emailExists=User::where('email', $user->email)->first();
		
		if($emailExists)
			return false;
		
		
        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }
}
