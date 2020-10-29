<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use Storage;
use App\Models\Attribute;
use App\Traits\categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandsRequest;
use App\Http\Requests\Dashboard\AttributesRequest;


class AttributesController extends Controller
{
    use categories;

    public function index()
    {
        $attributes = Attribute::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.attributes.index', compact('attributes'));
    }


    public function create()
    {
        return view('dashboard.attributes.create');
    }


    public function store(AttributesRequest $request)
    {


            $attribute = Attribute::create($request->all());


            return $this->success('admin.attributes.index', __('admin/product.add successfully'));

    }


    public function edit($id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute)
            $this->notFoundMsg('admin.attributes.index', __('admin/attributes.attribute not found'));

        return view('dashboard.attributes.edit', compact('attribute'));
    }


    public function update($id, AttributesRequest $request)
    {
        try {
            $attribute = Attribute::find($id);
            if (!$attribute)
                $this->notFoundMsg('admin.attributes.index', __('admin/attributes.attribute not found'));

            $attribute->update($request->all());

            return $this->success('admin.attributes.index', __('admin/attributes.updated successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->error('admin.attributes.index', __('admin/attributes.fail'));
        }
    }


    public function destroy($id)
    {
        try {
            $attribute = Attribute::find($id);
            if (!$attribute)
                $this->notFoundMsg('admin.attributes.index', __('admin/attributes.attribute not found'));

            $attribute->translations()->delete();
            $attribute->delete();

            return $this->success('admin.attributes.index', __('admin/attributes.deleted successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->error('admin.attributes.index', __('admin/attributes.fail'));
        }
    }


}
