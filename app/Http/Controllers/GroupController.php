<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Comment;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $description = request('description', '');
        $type_id = request('type_id', 1);
        $user = $request->user();
        $head_id = $user->id;
        $alias = $user->nickname;
        $avatar = $user->avatar;

       $group = Group::create([
            'type_id' => $type_id,
            'description' => $description,
            'head_id' => $head_id,
            'alias' => $alias,
            'avatar' => $avatar,
        ]);

        return response()->json(compact('description','type_id','user','group'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $group = Group::find($id);

        $user = $request->user();

        $comment = Comment::where(['group_id'=>$id,'user_id'=>$user->id])->first();

        return response()->json(compact('group','user','comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
