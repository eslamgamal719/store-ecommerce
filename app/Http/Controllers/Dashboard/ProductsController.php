<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\GeneralProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Traits\categories;
use Illuminate\Http\Request;
use DB;

class ProductsController extends Controller
{
    use categories;

    public function index()
    {
        $products = Product::select('id', 'slug', 'price', 'created_at')->paginate(PAGINATION_COUNT);
        return view('dashboard.products.general.index', compact('products'));
    }

    public function create()
    {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->orderBy('id', 'DESC')->get();
        $data['tags'] = Tag::select('id')->orderBy('id', 'DESC')->get();
        $data['categories'] = Category::active()->select('id')->orderBy('id', 'DESC')->get();

        return view('dashboard.products.general.create', $data);
    }

    public function store(GeneralProductRequest $request)
    {
        try{
            DB::beginTransaction();
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $product = Product::create($request->only(['slug', 'brand_id', 'is_active']));  //save in products table

            // save in product trandlations table
            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->save();

            //save many-to-many with categories and tags tables
            $product->categories()->attach($request->categories);
            $product->tags()->attach($request->tags);
            DB::commit();

            return $this->success('admin.products', 'تم الاضافه بنجاح');
        } catch(\Exception $ex) {
            DB::rollback();
            return $this->error('admin.products', 'هناك خطأ ما');

        }




    }
}
