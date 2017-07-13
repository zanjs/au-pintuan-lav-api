<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl\Curl;

class WXMessageController extends WXController
{
    public function wxopenMessage($open_id,$template_id,$form_id,$page,$data){
        $token = $this->access_token();
        $curl = new Curl();
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token;

        $data = array(
            'touser' => $open_id,
            "template_id" => $template_id,
            'page' => $page,
            'form_id' => $form_id,
            'data' => $data,
        );

        $curl->setHeader('Content-Type', 'application/json');

        $curl->post($url, $data);

        $curl->close();

        return $curl->response;
    }

    /**
     * 报名成功
     * @param $open_id
     * @param $form_id
     * @param $data
     */
    public function OrderSignUp($open_id,$form_id,$page,$val){
        $template_id = 'p1l2FQ52OnaxzeFdrpDv5fC6keU2ffjX2xSG9Lo1aZI';

        $data = array(
            'keyword1' => array(
                'value' => '澳洲群一键接龙',
                "color" => "#173177",
            ),
            'keyword2' => array(
                'value' => $val,
                "color" => "#173177",
            ),
        );

       return $this->wxopenMessage($open_id,$template_id,$form_id,$page,$data);
    }
}
