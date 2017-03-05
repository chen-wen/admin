<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use SearchTrait;

    public  $timestamp = true;
    protected $table = 'system_roles';
    protected $fillable = array('name', 'permissions');
    protected $casts = [
        'permissions' => 'array',
    ];

    function getSearchHandles()
    {
        return [
            'name'=>function($query,$value,$request){
                $query->where('name','like','%'.$value.'%');
            }
        ];
    }
}
