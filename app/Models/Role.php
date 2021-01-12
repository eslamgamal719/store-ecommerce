<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use translatable;

    protected $with = ['translations'];

    protected $translatedAttributes = ['name'];

    protected $hidden = ['translations'];

    protected $fillable = [
        'name',
        'permissions'  //json
    ];

    public $timestamps = false;


    public function getPermissionsAttribute($permissions) {
        return json_decode($permissions, true);
    }
}
