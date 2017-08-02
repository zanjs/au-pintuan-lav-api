<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type_id',
        'head_id',
        'avatar',
        'currency_id',
        'head_id',
        'image',
        'alias',
        'required_u_name',
        'required_u_phone',
        'required_u_wechat',
        'required_u_address',
    ];


    public function getImageJsonAttribute($value)
    {
        return json_decode($value);
    }

    public function setImageJsonAttribute($value)
    {
        $this->attributes['image'] = json_encode($value);
    }
}
