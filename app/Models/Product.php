<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use translatable,
        softDeletes;

    protected $table = 'products';

    protected $with = ['translations'];

    protected $translatedAttributes =['name', 'description', 'short_description'];

    protected $fillable = [
        'brand_id',
        'slug',
        'sku',
        'price',
        'special_price',
        'special_price_type',
        'special_price_start',
        'special_price_end',
        'selling_price',
        'manage_stock',
        'qty',
        'in_stock',
        'is_active',
    ];

    //protected $hidden = ['translations'];

    protected $casts = [
        'is_active' => 'boolean',
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean'
    ];

    protected $dates = [
        'special_price_start',
        'special_price_end',
        'start_date',
        'end_date',
        'deleted_at'
    ];



    //Relations
    public function brand() {
        return $this->belongsTo(Brand::class)->withDefault();
    }


    public function categories() {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }


    public function options() {
        return $this->hasMany(Option::class, 'product_id');
    }



    //Methods
    public function getActive() {
        return $this->is_active == 0 ? __('admin/product.inactive') : __('admin/product.active');
    }



    //Scopes
    public function scopeSelectProducts($query) {
        return $query->select('id', 'slug', 'price', 'created_at');
    }
}
