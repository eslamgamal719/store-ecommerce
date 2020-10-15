<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\GeneralProductRequest;
use App\Http\Requests\Dashboard\ProductImageRequest;
use App\Http\Requests\Dashboard\ProductPriceRequest;
use App\Http\Requests\Dashboard\ProductStockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
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

    } // end of index


    public function create()
    {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->orderBy('id', 'DESC')->get();
        $data['tags'] = Tag::select('id')->orderBy('id', 'DESC')->get();
        $data['categories'] = Category::active()->select('id')->orderBy('id', 'DESC')->get();

        return view('dashboard.products.general.create', $data);

    } // end of create


    public function store(GeneralProductRequest $request)
    {
        try {

            DB::beginTransaction();
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $product = Product::create($request->except('categories', 'tags'));  //save in products table

            //save many-to-many with categories and tags tables
            $product->categories()->attach($request->categories);
            $product->tags()->attach($request->tags);
            DB::commit();

            return redirect()->route('admin.products.price', $product->id);

        } catch (\Exception $ex) {

            DB::rollback();
            return $this->error('admin.products', __('admin/product.there is error'));
        }

    } //end of store


    public function getPrice($product_id)
    {

        return view('dashboard.products.price.create')->with('id', $product_id);

    } // end of get price


    public function saveProductPrice(ProductPriceRequest $request)
    {
        try {
            // ->update($request->only(['price', 'special_price', 'special_price_start', 'special_price_end', 'spectail_price_type']));
            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));

            return redirect()->route('admin.products.stock', $request->product_id);

        } catch (\Exception $ex) {

            DB::rollback();
            return $this->error('admin.products', __('admin/product.there is error'));

        }

    } // end of save product price


    public function getStock($product_id)
    {

        return view('dashboard.products.stock.create')->with('id', $product_id);

    } // end of get stock


    public function saveProductStock(ProductStockRequest $request)
    {

        try {
            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));

            return redirect()->route('admin.products.images', $request->product_id);

        } catch (\Exception $ex) {

            return $this->error('admin.products', __('admin/product.there is error'));
        }

    } //end of save product stock


    public function addImage($product_id)
    {

        return view('dashboard.products.images.create')->withId($product_id);

    } // end of add Image


    //save images in folder only
    public function saveProductImage(Request $request)
    {

        $file = $request->file('dzfile');
        $fileName = uploadImage('products', $file);

        return response()->json([
            'name' => $fileName,
            'original_name' => $file->getClientOriginalName()
        ]);

    } // end of save product image


    public function saveProductImageDb(ProductImageRequest $request)
    {
        try {
              if($request->has('document') && count($request->document) > 0) {
                  foreach ($request->document as $image) {
                      Image::create([
                          'product_id' => $request->product_id,
                          'photo' => $image
                      ]);
                  }
              }

              return $this->success('admin.products', __('admin/product.added successfully'));
        } catch (\Exception $ex) {
            return $this->error('admin.products.index', __('admin/product.there is error'));
        }
    }


}
