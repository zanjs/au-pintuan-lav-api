<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Group;
use Curl\Curl;

class CodeController extends WXController
{
    public function getCode($id){
        $group = Group::query()->find($id);

        if(!$group){
            return response()->json(['error','no'], 404);
        }

        $token = $this->access_token();

        $path = "page/placard/show/show?id=";

        if($group->type_id == 2){
            $path = "page/product/show/show?id=";
        }

        $content = $this->qrcode($token,$path.$id);

        $code_path_prefix = 'public/';
        $code_path = 'wx-code/group/'.$id.'/'.$id.'.png';
        $code_name = $code_path_prefix.$code_path;
        Storage::put($code_name, $content);

        $group->qr_code_path = $code_path;

        $group->save();

        return response($content, 200, [
            'Content-Type' => 'image/png',
        ]);
    }

    public function qrcode($token, $path){
        $curl = new Curl();
//        $url = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$token;
        $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$token;

        $data = array(
            'path' => $path,
            "width" => 200,
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
