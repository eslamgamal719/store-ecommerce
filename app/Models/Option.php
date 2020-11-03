<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use translatable;


    protected $with = ['translations'];

    protected $translatedAttributes =['name'];

    protected $fillable = ['attribute_id', 'product_id', 'price'];

    protected $hidden = ['translations'];



    //relations
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function attribute() {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }




    //Scopes
    public function scopeSelectOptions($query) {
        return $query->select('id', 'attribute_id', 'product_id', 'price');
    }


}
