<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request, $id)
    {
        $group = Group::find($id);
        $index = $request->index;

        $imageStr = $group->image;

        if(!$imageStr){
            return response()->json(['error'=>'no']);
        }

        $images = explode(",", $imageStr);

        $image_file = $images[$index];

        $isdel = Storage::disk('uploads')->delete($image_file);

        return response()->json(['data'=>$images,'file'=>$image_file,'message' => $isdel]);

    }

    public function del(Request $request, $id)
    {
        $group = Group::find($id);
        $index = $request->index;

        $imageStr = $group->image;

        if(!$imageStr){
            return response()->json(['error'=>'no']);
        }

        $images = explode(",", $imageStr);

        $image_file = $images[$index];


        return response()->json(['data'=>$images,'file'=>$image_file]);

    }

    public function delete(Request $request){
//        $uuId = $request->id;
        $img = $request->img;

        $user = $request->user();
//
//        if($user->id != $uuId){
//            return response()->json(['error'=>'no']);
//        }
        $image_file = 'uploads/group/'.$user->id.'/'.$img;
        $isdel = Storage::disk('uploads')->delete($image_file);

        return response()->json(['data'=>$img,'file'=>$image_file,'message' => $isdel]);
    }

    /**
     * 上传文件
     */
    public function uploadImages(Request $request)
    {
        $file = $request->file('image');

        if(!$file){
            return response()->json(['error'=>'what']);
        }

        $user = $request->user();

        // 第一个参数代表目录, 第二个参数代表我上方自己定义的一个存储媒介
        $time = date('Y-m-d');
        $path = $file->store("uploads/group/".$user->id."/".$time, 'uploads');

        $src = env('APP_URL')."/storage/".$path;

        return response()->json(compact('path','src'));
    }

    //    上传图片
    public function uploadpic(Request $request, $filename, $filepath)
    {
        //        1.首先检查文件是否存在
        if ($request::hasFile($filename)){
            //          2.获取文件
            $file = $request::file($filename);
            //          3.其次检查图片手否合法
            if ($file->isValid()){
                //      先得到文件后缀,然后将后缀转换成小写,然后看是否在否和图片的数组内
                if(in_array( strtolower($file->extension()),['jpeg','jpg','gif','gpeg','png'])){
                    //          4.将文件取一个新的名字
                    $newName = 'img'.time().rand(100000, 999999).$file->getClientOriginalName();
                    //           5.移动文件,并修改名字
                    if($file->move($filepath,$newName)){
                        return $filepath.'/'.$newName;   //返回一个地址
                    }else{
                        return 4;
                    }
                }else{
                    return 3;
                }

            }else{
                return 2;
            }
        }else{
            return 1;
        }
    }
}
