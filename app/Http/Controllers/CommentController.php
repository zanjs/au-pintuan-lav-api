<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Group;
use Illuminate\Http\Request;

class CommentController extends WXMessageController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $comments = Comment::where('user_id', $user->id)->orderBy('created_at','desc')->with('group')->get();

        return response()->json(compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = $request->user();
        $user_id = $user->id;
        $open_id = $user->open_id;
        $alias = $user->nickname;
        $avatar = $user->avatar;
        $group_id = $request->group_id;
        $commentInfo = $request->comment;
        $productommentInfo = $request->product_comment;
        $products = $request->products;
        $total_price = $request->total_price;
        $form_id = $request->form_id;
        $name = $request->name;
        $phone = $request->phone;

        $open_message = "";

        if($form_id){
            $group = Group::query()->find($group_id);
            $page = "/page/placard/show/show?id=";
            if($group->type_id == 2){
                $page = "/page/product/show/show?id=";
            }
            $page = $page.$group_id;
            $open_message = $this->OrderSignUp($open_id,$form_id,$page,$group->description,$productommentInfo,$commentInfo);
        }

        $comment = Comment::where(['group_id'=>$group_id,'user_id'=>$user_id])->first();

        if($comment){

            $comment->comment = $commentInfo;
            $comment->product_comment = $productommentInfo;
            $comment->product_json = json_encode($products);
            $comment->total_price = $total_price;
            $comment->name = $name;
            $comment->phone = $phone;

            $comment->save();

            $message = "更新成功";

            return response()->json(compact('open_message','productommentInfo','products','comment','message'));
        }

        $count = Comment::where('group_id',$group_id)->count();

        $comment = new Comment;

        $comment->index = $count+1;
        $comment->group_id = $group_id;
        $comment->comment = $commentInfo;
        $comment->product_comment = $productommentInfo;
        $comment->product_json = json_encode($products);
        $comment->total_price = $total_price;
        $comment->user_id = $user_id;
        $comment->alias = $alias;
        $comment->avatar = $avatar;
        $comment->name = $name;
        $comment->phone = $phone;

        $comment->save();

        $message = "报名成功啦";

        return response()->json(compact('products','comment','message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comment::where('group_id',$id)->orderBy('created_at','desc')->get();

        return response()->json(compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $comment_id = $id;

        if(!$comment_id){
            return response()->json(['error','no']);
        }

        $comment = Comment::query()->find($comment_id);

        if(!$comment){
            return response()->json(['error','no']);
        }
        $group_id = $comment->group_id;

        $group = Group::query()->find($group_id);
        $user = $request->user();

        if($group->head_id != $user->id){
            return response()->json(['error','no']);
        }

        $comment->delete();
        return response()->json(['message'=>'ok']);

    }

}
