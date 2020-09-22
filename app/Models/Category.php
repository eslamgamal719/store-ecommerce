<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use translatable;

    protected $table = 'categories';

    protected $with = ['translations'];

    protected $translatedAttributes =['name'];

    protected $fillable = ['parent_id', 'slug', 'is_active', 'photo'];

    protected $hidden = ['translations'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    #################################################################################
    public function scopeParent($query) {
        return $query->whereNull('parent_id');
    }

    public function scopeChild($query) {
        return $query->whereNotNull('parent_id');
    }


    public function getActive() {
        return $this->is_active == 0 ? __('admin/category.inactive') : __('admin/category.active');
    }


    public function _parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function _child() {
        return $this->hasMany(self::class, 'parent_id');
    }


    public function getPhotoAttribute($val)
    {
        return ($val != null) ? asset('assets/images/categories/' . $val) : '';
    }


}
