<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    protected $dateFormat = 'U';
    public function productOrder()
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function orders(){
        return $this->belongsToMany('App\ProductOrder');
    }
}
