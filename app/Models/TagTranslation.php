<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    protected $fillable = ['name', 'tag_id'];

    public $timestamps = false;
}
