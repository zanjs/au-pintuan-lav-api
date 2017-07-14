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
    public function OrderSignUp($open_id,$form_id,$page,$description,$product,$comment){
        $template_id = 'p1l2FQ52OnaxzeFdrpDv5RA14awbLdSqahVu6OIN-w4';

        $data = array(
            'keyword1' => array(
                'value' => '澳洲群一键接龙',
                "color" => "#173177",
            ),
            'keyword2' => array(
                'value' => $description,
                "color" => "#173177",
            ),
            'keyword3' => array(
                'value' => $product,
                "color" => "#173177",
            ),
            'keyword4' => array(
                'value' => $comment,
                "color" => "#173177",
            ),
        );

       return $this->wxopenMessage($open_id,$template_id,$form_id,$page,$data);
    }
}
