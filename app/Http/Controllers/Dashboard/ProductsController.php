<?php

namespace App\Http\Controllers\Dashboard;

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


class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::selectProducts()
            ->paginate(PAGINATION_COUNT);

        return view('dashboard.products.general.index', compact('products'));

    }//end of index


    public function create()
    {
        $data = [];

        $data['tags'] = Tag::select('id')->orderBy('id', 'DESC')->get();

        $data['brands'] = Brand::active()->select('id')->orderBy('id', 'DESC')->get();

        $data['categories'] = Category::active()->select('id')->orderBy('id', 'DESC')->get();

        return view('dashboard.products.general.create', $data);

    }//end of create


    public function store(GeneralProductRequest $request)
    {
        try {

            DB::beginTransaction();

            isActive($request);

            $product = Product::create($request->except('categories', 'tags'));  //save in products table

            //save many-to-many with categories and tags tables
            $product->categories()->attach($request->categories);

            $product->tags()->attach($request->tags);

            DB::commit();

            return redirect()->route('admin.products.price', $product->id);

        } catch (\Exception $ex) {

            DB::rollback();
            return error('admin.products', __('admin/product.there is error'));
        }

    }//end of store


    public function getPrice($product_id)
    {
        return view('dashboard.products.price.create')->with('id', $product_id);

    }// end of get price


    public function saveProductPrice(ProductPriceRequest $request)
    {
        try {
            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));

            return redirect()->route('admin.products.stock', $request->product_id);

        } catch (\Exception $ex) {

            DB::rollback();
            return error('admin.products', __('admin/product.there is error'));

        }

    }//end of save product price


    public function getStock($product_id)
    {
        return view('dashboard.products.stock.create')->with('id', $product_id);

    }// end of get stock


    public function saveProductStock(ProductStockRequest $request)
    {

        try {
            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));

            return redirect()->route('admin.products.images', $request->product_id);

        } catch (\Exception $ex) {

            return error('admin.products', __('admin/product.there is error'));
        }

    }//end of save product stock


    public function addImage($product_id)
    {

        return view('dashboard.products.images.create')->withId($product_id);

    }// end of add Image


    //save images in folder only
    public function saveProductImage(Request $request)
    {

        $file = $request->file('dzfile');

        $fileName = uploadImage('products', $file);

        return response()->json([

            'name' => $fileName,
            'original_name' => $file->getClientOriginalName()

        ]);

    }//end of save product image


    public function saveProductImageDb(ProductImageRequest $request)
    {
        try {

            if ($request->has('document') && count($request->document) > 0) {

                foreach ($request->document as $image) {

                    Image::create([

                        'product_id' => $request->product_id,
                        'photo' => $image

                    ]);

                }//end of foreach

            }//end of if condition

            return success('admin.products', __('admin/product.added successfully'));

        } catch (\Exception $ex) {

            return error('admin.products.index', __('admin/product.there is error'));
        }

    }//end of saveProductImageDb


/////////////////////////////////////edit products //////////////////////////////

    public function edit($product_id)
    {

        $tags = Tag::select('id')->orderBy('id', 'DESC')->get();

        $brands = Brand::active()->select('id')->orderBy('id', 'DESC')->get();

        $categories = Category::active()->select('id')->orderBy('id', 'DESC')->get();

        $product = Product::find($product_id);

        return view('dashboard.products.general.edit', compact(['tags', 'brands', 'categories', 'product']));

    }//end of edit


    public function update(GeneralProductRequest $request, $product_id)
    {

        try {

            DB::beginTransaction();

            isActive($request);

            $product = Product::find($product_id);

            $product->update($request->except('categories', 'tags'));  //save in products table

            //save many-to-many with categories and tags tables
            $product->categories()->sync($request->categories);

            $product->tags()->sync($request->tags);

            DB::commit();

            return redirect()->route('admin.products.price.edit', $product_id);

        } catch (\Exception $ex) {

            DB::rollback();

            return error('admin.products', __('admin/product.there is error'));
        }

    }//end of update


    public function editPrice($product_id)
    {

        $product = Product::find($product_id);

        return view('dashboard.products.price.edit', compact('product'));

    }//end of edit price


    public function updateProductPrice(ProductPriceRequest $request)
    {
        try {

            $product = Product::find($request->product_id);

            $product->update($request->except('token', 'product_id'));

            return redirect()->route('admin.products.stock.edit', $request->product_id);

        } catch (\Exception $ex) {

            return error('admin.products', __('admin/product.there is error'));

        }

    }//end of update price


    public function editStock($product_id)
    {

        $product = Product::find($product_id);

        return view('dashboard.products.stock.edit', compact('product'));

    }//end of edit stock


    public function updateProductStock(ProductStockRequest $request)
    {
        try {

            $product = Product::find($request->product_id);

            $product->update($request->except('_token', 'product_id'));

            return redirect()->route('admin.products.images.edit', $request->product_id);

        } catch (\Exception $ex) {

            return error('admin.products', __('admin/product.there is error'));

        }

    }//end of update stock


    public function editImage($product_id)
    {
        $photos = Image::where('product_id', $product_id)->get();

        $product = Product::find($product_id);

        return view('dashboard.products.images.edit', compact('photos', 'product'));

    }//end of edit image


}//end of controller
