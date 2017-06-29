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
        'alias'
    ];
}
