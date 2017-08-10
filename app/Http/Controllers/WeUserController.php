<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WeUser;
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

        return $this->getWxUserInfoFun($code,$encryptedData,$iv);
    }

    public function getWxUserInfoFun($code,$encryptedData,$iv){
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

        //code 在小程序端使用 wx.login 获取
        $code = request('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');

        $wxUserInfo = $this->getWxUserInfoFun($code,$encryptedData,$iv);

//        dd($wxUserInfo);
        $jsonWxUserInfo = json_decode($wxUserInfo);
//        return $jsonWxUserInfo->openId;
        $emailFix = env('WX_EMAIL');
        $email = $jsonWxUserInfo->openId.$emailFix;

        $passwordFix = env('WX_PWD');
        $password = $jsonWxUserInfo->openId.$passwordFix;

        $hasUser = WeUser::Where('email', $email)->first();
//        $uniodID = $jsonWxUserInfo->unionId;
//        $hasUser2 = WeUser::Where('email', $jsonWxUserInfo->unionId.$emailFix)->first();
//
//        if($hasUser2){
//            $hasUser = $hasUser2;
//        }


        if(!$hasUser){
            WeUser::create([
                'name' => $jsonWxUserInfo->nickName,
                'email' => $jsonWxUserInfo->openId.$emailFix,
                'password' => bcrypt($password),
                'open_id' => $jsonWxUserInfo->openId,
                'nickname' => $jsonWxUserInfo->nickName,
                'avatar' => $jsonWxUserInfo->avatarUrl,
                'union_id' => $jsonWxUserInfo->unionId,
            ]);
        }

//        if(!$hasUser->union_id) {
//            $hasUser->union_id = $jsonWxUserInfo->unionId;
//            $email = $jsonWxUserInfo->union_id.$emailFix;
//            $hasUser->save();
//        }


        $credentials=[
            'email' => $email,
            'password'  => $password,
        ];
        try {
            if (! $token = Auth::guard($this->guard)->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token','hasUser','jsonWxUserInfo'));
    }
}
