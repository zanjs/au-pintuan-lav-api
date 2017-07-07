<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Curl\Curl;

class CodeController extends Controller
{
    public function getCode($id){
        $group = Group::query()->find($id);

        if(!$group){
            return response()->json(['error','no'], 404);
        }

        $token = $this->access_token();

        $content = $this->qrcode($token,"page/placard/show/show?id=".$id);

        return response($content, 200, [
            'Content-Type' => 'image/png',
        ]);
    }

    public function access_token(){
        $curl = new Curl();

        $appid = config('wxxcx.appid');
        $secret = config('wxxcx.secret');

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;

        $curl->get($url);

        $curl->close();

        return $curl->response->access_token;
    }

    public function qrcode($token, $path){
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$token;

        $data = array(
            'path' => $path,
            "width" => 420,
        );

        $curl->setHeader('Content-Type', 'application/json');

        $curl->post($url, $data);

        $curl->close();

        return $curl->response;
    }

    public function baidu(){
        $curl = new Curl();
        $curl->get('https://www.baidu.com/');
        if ($curl->error) {
            echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
        } else {
            var_dump($curl->response);
        }
    }
}
