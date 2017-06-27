<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WeUser;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Iwanli\Wxxcx\Wxxcx;
use Auth;

class WeUserController extends Controller
{
    protected $guard = 'api';

    protected $wxxcx;

    function __construct(Wxxcx $wxxcx)
    {
        $this->wxxcx = $wxxcx;
    }

    /**
     * 小程序登录获取用户信息
     */
    public function getWxUserInfo()
    {
        //code 在小程序端使用 wx.login 获取
        $code = request('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');

        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);

        //获取解密后的用户信息
        return $this->wxxcx->getUserInfo($encryptedData, $iv);
    }

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
