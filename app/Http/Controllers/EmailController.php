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
        if (empty($request->id)) {
            return response()->json(['error'=> 'id']);
        }
        $email = $request->email;
        $id = $request->id;

        $group = Group::query()->find($id);

        if(!$group){
            return response()->json(['error'=> 'not find']);
        }

        $comments = Comment::query()->where('group_id',$id)->get();

        if(count($comments) < 1){
            return response()->json(['error'=> '还没有人报名']);
        }

        $this->exportData($email,'团长大人.🤴.这是您要导出的接龙信息',$comments,$group);

        return response()->json(['message'=> '发送成功']);

    }

    public function exportData($email,$title,$comments,$group){
        $name = '团长';
        $flag = Mail::send('emails.order',['name'=>$name,'comments'=> $comments, 'group'=> $group],function($message) use ($title, $email) {
            $message ->to($email)->subject($title);
        });
        return  $flag;
    }
}
