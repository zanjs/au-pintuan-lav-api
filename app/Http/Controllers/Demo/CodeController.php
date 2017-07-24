<?php

namespace App\Http\Controllers\Demo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\WXController;

use App\Group;
use Curl\Curl;
use Libern\QRCodeReader\QRCodeReader;


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

//        $QRCodeReader = new QRCodeReader();
//        $qrcode_text = $QRCodeReader->decode(base64_encode($content));

//        var_dump($qrcode_text);
//        $code_name = 'public/wx-code/group/'.$id.'.png';
        $code_path_prefix = 'public/';
        $code_path = 'wx-code/group/'.$id.'/'.$id.'.png';
        $code_name = $code_path_prefix.$code_path;
        $req_file = Storage::put($code_name, $content);

        $group->qr_code_path = $code_path;

        $group->save();

        dd($req_file);
//        $gd = imagecreatefromstring($content);

//        imagepng($gd, '/home/wwwroot/au.anla.io/xxx.png');



//        $QRCodeReader = new QRCodeReader();
//        $qrcode_text = $QRCodeReader->decode(base64_encode($content));
//
//        dd($qrcode_text);
//        $group->qr_code = $qrcode_text;
//
//        $group->save();
//
//        return response($content, 200, [
//            'Content-Type' => 'image/png',
//        ]);
    }

    public function qrcode($token, $path){
        $curl = new Curl();
//        $url = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$token;

        $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$token;

        $data = array(
            'path' => $path,
            "width" => 300,
        );

        $curl->setHeader('Content-Type', 'application/json');

        $curl->post($url, $data);

        $curl->close();

        return $curl->response;
    }

    public function  codeT(Request $request){
        $QRCodeReader = new QRCodeReader();
        $url = $request->url;
        if(!$url){
            return response()->json(['error'=>'url is err']);
        }
        $qrcode_text = $QRCodeReader->decode($url);
        echo $qrcode_text;
    }
}
