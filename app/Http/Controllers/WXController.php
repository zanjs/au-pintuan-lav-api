<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl\Curl;

class WXController extends Controller
{
    public function access_token(){
        $curl = new Curl();

        $appid = config('wxxcx.appid');
        $secret = config('wxxcx.secret');

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;

        $curl->get($url);

        $curl->close();

        return $curl->response->access_token;
    }
}
