<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WeUser;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;

class WeUserController extends Controller
{
    protected $guard = 'api';

    /**
     * 微信用户自动登陆
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $hasUser = WeUser::Where('email', $request->email)->first();
        if(!$hasUser){
            WeUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'open_id' => Hash::make($request->email),
                'nickname' => $request->name,
                'avatar' => 'https://i0.wp.com/wp.laravel-news.com/wp-content/uploads/2017/06/performant-laravel.jpg?resize=1400%2C709',
            ]);
        }
        $credentials=[
            'email' => $request->email,
            'password'  => $request->password,
        ];
        try {
            if (! $token = Auth::guard($this->guard)->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
}
