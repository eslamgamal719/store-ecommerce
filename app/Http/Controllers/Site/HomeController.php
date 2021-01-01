<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $data = [];
        $data['sliders'] = Slider::get('photo');
        $data['categories'] = Category::parent()->select('id', 'slug')->with(['children' => function($q) {
            $q->select('id', 'slug', 'parent_id');
            $q->with(['children' => function($qu) {
                $qu->select('id', 'slug', 'parent_id');
            }]);
        }])->get();

        return view('front.home', $data);
    }
}
