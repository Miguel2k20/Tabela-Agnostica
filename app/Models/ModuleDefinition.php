<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleDefinition extends Model
{
    protected $fillable = [
        'reference',
        'name',
        'schema_json'
    ];
    
    protected $casts = [
        'schema_json' => 'array'
    ];

    public function getRouteKeyName()
    {
        return 'reference';
    }
}
