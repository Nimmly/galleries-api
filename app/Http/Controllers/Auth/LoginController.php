<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

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
    public function authenticate(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        
        try{
            if(!$token = \JWTAuth::attempt($credentials))
            {
                return response()->json(['error' => 'invalid credentials!'], 401);
            }
        }catch(JWTException $error)
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = auth()->user();
        
        return response()->json(compact(['token', 'user']));
    }
}
