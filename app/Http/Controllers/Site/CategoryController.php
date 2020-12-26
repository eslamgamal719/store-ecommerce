<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function productsBySlug($slug)
    {
        $data = [];

        $data['categories'] = Category::parent()->select('id', 'slug')->with(['children' => function($q) {
            $q->select('id', 'slug', 'parent_id');
            $q->with(['children' => function($qu) {
                $qu->select('id', 'slug', 'parent_id');
            }]);
        }])->get();

        $data['category'] = Category::where('slug', $slug)->first();

        if($data['category']) {
            $data['products'] = $data['category']->products;
        }
        return view('front.products', $data);
    }

}
