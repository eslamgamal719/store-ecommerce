<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\OptionRequest;
use App\Models\Attribute;
use App\Models\Option;
use DB;
use App\Models\Tag;
use App\Models\Image;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductImageRequest;
use App\Http\Requests\Dashboard\ProductPriceRequest;
use App\Http\Requests\Dashboard\ProductStockRequest;
use App\Http\Requests\Dashboard\GeneralProductRequest;


class OptionsController extends Controller
{

    public function index()
    {

        $options = Option::with(['product' => function($prod) {

            $prod->select('id');

       } , 'attribute' => function($attr) {

           $attr->select('id');

       }])->selectOptions()->paginate(PAGINATION_COUNT);

        return view('dashboard.options.index', compact('options'));

    } // end of index


    public function create()
    {
        $data = [];

        $data['products'] = Product::active()->select('id')->orderBy('id', 'DESC')->get();

        $data['attributes'] = Attribute::select('id')->orderBy('id', 'DESC')->get();

        return view('dashboard.options.create', $data);

    } // end of create


    public function store(OptionRequest $request)
    {
        try {

            $product = Option::create($request->all());

            return redirect()->route('admin.options.index');

        } catch (\Exception $ex) {

            return $this->error('admin.options', __('admin/product.there is error'));
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
                          'photo'      => $image
                      ]);
                  }
              }

              return $this->success('admin.products', __('admin/product.added successfully'));
        } catch (\Exception $ex) {
            return $this->error('admin.products.index', __('admin/product.there is error'));
        }
    }



}
