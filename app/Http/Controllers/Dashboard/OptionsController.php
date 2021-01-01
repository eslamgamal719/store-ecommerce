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

        $options = Option::with(['product' => function ($prod) {

            $prod->select('id');

        }, 'attribute' => function ($attr) {

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

            Option::create($request->all());

            return success('admin.options.index', __('admin/product.added successfully'));

        } catch (\Exception $ex) {

            return error('admin.options.index', __('admin/product.there is error'));
        }

    } //end of store


    public function edit(Option $option)
    {

        $data = [];

        $data['option'] = $option;

        $data['products'] = Product::active()->select('id')->orderBy('id', 'DESC')->get();

        $data['attributes'] = Attribute::select('id')->orderBy('id', 'DESC')->get();

        return view('dashboard.options.edit', $data);
    }


    public function update(OptionRequest $request, Option $option)
    {
        try {

            DB::beginTransaction();

            $option->update($request->only('product_id', 'attribute_id', 'price'));
            $option->translate('en')->name = $request->en['name'];
            $option->translate('ar')->name = $request->ar['name'];
            $option->save();

            DB::commit();

            return success('admin.options.index', __('admin/product.updated successfully'));

        } catch (\Exception $ex) {
            DB::rollback();
            return error('admin.options.index', __('admin/product.there is error'));
        }
    }




}
