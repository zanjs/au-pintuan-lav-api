<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductOrder;

class ProductOrderController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = ProductOrder::query()->where('group_id',$id)->get();

        return response()->json(compact('products'));
    }
}
