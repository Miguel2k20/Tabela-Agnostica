<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicRecord extends Model
{
    protected $fillable = ['reference', 'dados'];

    protected  $casts = [
        'dados' => 'array'
    ];

}
