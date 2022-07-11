<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
      try {
        $request->validate([
          'email' => 'email|required',
          'password' => 'required'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
          return response()->json(
              ['result' => "User does not exist or You have entered incorrect credentials"],404
            )->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        }
        $user = User::where('email', $request->email)->first();
        if ( ! Hash::check($request->password, $user->password, [])) {
           throw new \Exception('Error in Login');
        }
        $tokenResult = $user->createToken('authToken')->plainTextToken;
        return response()->json([
          'status_code' => 200,
          'access_token' => $tokenResult,
          'token_type' => 'Bearer',
        ]);
      } catch (Exception $error) {
        return response()->json([
          'status_code' => 500,
          'message' => 'Error in Login',
          'error' => $error,
        ]);
      }
    }
}
