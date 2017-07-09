<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Comment;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $group = Group::where('head_id', $user->id)->orderBy('created_at','desc')->get();

        return response()->json(compact('group'));
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
        $image = request('image', '');
        $user = $request->user();
        $head_id = $user->id;
        $alias = $user->nickname;
        $avatar = $user->avatar;



       $products = $request->products;

        $group = Group::create([
            'type_id' => $type_id,
            'description' => $description,
            'head_id' => $head_id,
            'alias' => $alias,
            'avatar' => $avatar,
            'image' => $image
        ]);

       if(!$products){

           return response()->json(compact('description','type_id','user','group'));
       }

        $group_id = $group->id;

        $arr = array();

        foreach ($products as $product) {
            $product["group_id"] = $group_id;
            $product["created_at"] = date("Y-m-d H:i:s");
            array_push($arr,$product);
        }

        $insert = DB::table('products')->insert($arr);

        return response()->json(compact('insert','arr','group_id','products','description','type_id','user','group'));

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

//        $group->image = json_decode($group->image);

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
        $group = Group::find($id);

        return response()->json(compact('group'));
    }

    public function updateOpen(Request $request, $id){

        $group = Group::find($id);

        if(!$group){
            return response()->json(['error','no']);
        }

        $user = $request->user();

        $open = $request->open;

        $group->open = $open;

        $group->save();

        return response()->json(compact('group'));

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
        $group = Group::query()->find($id);

        if(!$group){
            return response()->json(['error','no']);
        }

        $group->description = request('description', '');
        $group->type_id = request('type_id', 1);
        $group->image = request('image', '');
        $user = $request->user();
        $group->head_id = $user->id;
        $group->alias = $user->nickname;
        $group->avatar = $user->avatar;

        $group->save();

        return response()->json(compact('description','type_id','user','group'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $group = Group::find($id);

        if(!$group){
            return response()->json(['error'=>'no']);
        }

        $user = $request->user();

        if($user->id != $group->head_id){
            return response()->json(['error'=>'no']);
        }

        $count = Comment::query()->where('group_id', $group->id)->count();

        if($count != 0){
            return response()->json(['error'=>'no','message'=>'已经有人报名了, 不可以删除哦','count'=>$count ]);
        }

        $images = $group->image;

        if($images){


        }

        $group->delete();

        return response()->json(['message'=>'ok']);
    }
}
