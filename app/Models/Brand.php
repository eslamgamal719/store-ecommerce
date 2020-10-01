<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use translatable;

    protected $with = ['translations'];

    protected $translatedAttributes = ['name'];

    protected $fillable = ['is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];


    public function getActive() {
        return $this->is_active == 0 ? __('admin/brands.inactive') : __('admin/brands.active');
    }

    public function scopeActive($query) {
        return $query->where('is_active', 1);
    }


    public function getPhotoUrlAttribute() {
        return  asset('assets/images/brands/'. $this->photo);
    }

  /*  public function getPhotoAttribute($val) {
        return ($val !== null) ? asset('assets/images/brands/' . $val) : '';
    }*/
}
