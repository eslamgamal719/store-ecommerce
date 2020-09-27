<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandsRequest;
use App\Models\Brand;
use App\Traits\categories;
use Illuminate\Http\Request;
use DB;
use Storage;

class BrandsController extends Controller
{
    use categories;

    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.brands.index', compact('brands'));
    }


    public function create()
    {
        return view('dashboard.brands.create');
    }


    public function store(BrandsRequest $request)
    {
        try {
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            DB::beginTransaction();
            $fileName = '';
            if ($request->has('photo'))
                $fileName = uploadImage('brands', $request->photo);

            $brand = Brand::create($request->except('token', 'photo'));
            $brand->name = $request->name;
            $brand->photo = $fileName;
            $brand->save();
            DB::commit();

            return $this->success('admin.brands', __('admin/brands.add successfully'));
        } catch (\Exception $ex) {
            return $this->error('admin.brands', __('admin/brands.add fail'));
        }
    }


    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            $this->notFoundMsg('admin.brands', __('admin/brands.brand not found'));

        return view('dashboard.brands.edit', compact('brand'));
    }


    public function update($id, BrandsRequest $request)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand)
                $this->notFoundMsg('admin.brands', __('admin/brands.brand not found'));

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            DB::beginTransaction();
            if($request->has('photo')){
                Storage::disk('brands')->delete($brand->photo);
                $fileName = uploadImage('brands', $request->photo);
                $brand->photo = $fileName;
            }

            $brand->update($request->except('_token', 'photo'));
            $brand->name = $request->name;
            $brand->save();
            DB::commit();

            return $this->success('admin.brands', __('admin/brands.updated successfully'));
        } catch (\Exception $ex) {
            return $this->error('admin.brands', __('admin/brands.fail'));
        }
    }


    public function destroy($id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand)
                $this->notFoundMsg('admin.brands', __('admin/brands.brand not found'));

            $brand->translations()->delete();
            Storage::disk('brands')->delete($brand->photo);
            $brand->delete();

            return $this->success('admin.brands', __('admin/brands.deleted successfully'));

        } catch (\Exception $ex) {
            return $this->error('admin.brands', __('admin/brands.fail'));
        }
    }

}
