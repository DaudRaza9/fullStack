<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=[
        'roleName',
        'permission',
         'isAdmin'
    ];

    public function users(){
        return $this->hasMany('App\User');
    }
}