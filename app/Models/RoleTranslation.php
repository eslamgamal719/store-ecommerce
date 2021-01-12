<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleTranslation extends Model
{
    protected $fillable = ['name', 'role_id'];

    public $timestamps = false;
}
