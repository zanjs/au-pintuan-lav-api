<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * @param Request $request
     */
    public function  send(Request $request){

        if (empty($request->email)) {
            return response()->json(['error'=> 'email']);
        }
        $email = $request->email;

        $name = '邓老板你好';
        $flag = Mail::send('emails.order',['name'=>$name],function($message) use ($email) {
            $message ->to($email)->subject('邮件测试');
        });

        echo $flag;

    }
}
