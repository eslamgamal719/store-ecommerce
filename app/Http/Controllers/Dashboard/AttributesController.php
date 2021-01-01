<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use Storage;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AttributesRequest;


class AttributesController extends Controller
{


    public function index()
    {
        $attributes = Attribute::orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT);

        return view('dashboard.attributes.index', compact('attributes'));

    }//end of index


    public function create()
    {
        return view('dashboard.attributes.create');

    }//end of create


    public function store(AttributesRequest $request)
    {
            $attribute = Attribute::create($request->all());

            return success('admin.attributes.index', __('admin/product.add successfully'));

    }//end of store


    public function edit(Attribute $attribute)
    {
        return view('dashboard.attributes.edit', compact('attribute'));

    }//end of edit


    public function update(Attribute $attribute, AttributesRequest $request)
    {
        try {

            $attribute->update($request->all());

            return success('admin.attributes.index', __('admin/attributes.updated successfully'));

        } catch (\Exception $ex) {

            return error('admin.attributes.index', __('admin/attributes.fail'));
        }

    }//end of update


    public function destroy(Attribute $attribute)
    {
        try {
            $attribute->translations()->delete();
            $attribute->delete();

            return success('admin.attributes.index', __('admin/attributes.deleted successfully'));

        } catch (\Exception $ex) {

            return error('admin.attributes.index', __('admin/attributes.fail'));

        }

    }//end of destroy

}//end of controller
