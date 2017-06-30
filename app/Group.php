<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'description',
        'type_id',
        'head_id',
        'avatar',
        'currency_id',
        'head_id',
        'image',
        'alias'
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
