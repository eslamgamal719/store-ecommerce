<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productsBySlug($slug)
    {
        $data = [];

        //product details
        $data['product'] = Product::where('slug', $slug)->first();
        if(!$data['product']) {

        }

        $product_id = $data['product']->id;
        $product_categories_ids = $data['product']->categories->pluck('id');

        //product attributes
        $data['product_attributes'] = Attribute::whereHas('options', function($q) use ($product_id) {
                $q->whereHas('product', function($qu) use ($product_id) {
                    $qu->where('product_id', $product_id);
                });
        })->get();

        //related products
        $data['related_products'] = Product::whereHas('categories', function($q) use ($product_categories_ids) {
            $q->whereIn('category_id', $product_categories_ids);
        })->limit(20)->latest()->get();

        return view('front.product-details', $data);
    }

}
