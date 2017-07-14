<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Comment;
use App\Group;

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

        $group = Group::query()->find(97);

        $comments = Comment::query()->where('group_id',97)->orderBy('created_at','desc')->get();

        $this->exportData($email,'团长大人.🤴.这是您要导出的接龙信息',$comments,$group);

    }

    public function exportData($email,$title,$comments,$group){
        $name = '团长';
        $flag = Mail::send('emails.order',['name'=>$name,'comments'=> $comments, 'group'=> $group],function($message) use ($title, $email) {
            $message ->to($email)->subject($title);
        });
        return  $flag;
    }
}
