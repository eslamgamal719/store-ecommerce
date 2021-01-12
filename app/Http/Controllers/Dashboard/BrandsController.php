<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use Storage;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandsRequest;


class BrandsController extends Controller
{

    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT);

        return view('dashboard.brands.index', compact('brands'));

    }//end of index


    public function create()
    {
        return view('dashboard.brands.create');

    }//end of create


    public function store(BrandsRequest $request)
    {
        try {

            isActive($request);

            DB::beginTransaction();

            $brand = Brand::create($request->except('token', 'photo'));

            $fileName = '';
            if ($request->has('photo')){

                $fileName = uploadImage('brands', $request->photo);

                $brand->photo = $fileName;

                $brand->save();
            }

            DB::commit();

            return success('admin.brands.index', __('admin/brands.add successfully'));

        } catch (\Exception $ex) {
            DB::rollback();
            return error('admin.brands.index', __('admin/brands.add fail'));

        }

    } //end of store


    public function edit(Brand $brand)
    {
        return view('dashboard.brands.edit', compact('brand'));

    }//end of edit


    public function update(Brand $brand, BrandsRequest $request)
    {
        try {
            isActive($request);

            DB::beginTransaction();

            $brand->update($request->except('_token', 'photo'));

            if($request->has('photo')){

                if($brand->photo != 'default.jpeg'){

                    Storage::disk('brands')->delete($brand->photo);
                }

                $fileName = uploadImage('brands', $request->photo);

                $brand->photo = $fileName;

                $brand->save();
            }

            DB::commit();

            return success('admin.brands.index', __('admin/brands.updated successfully'));

        } catch (\Exception $ex) {

            DB::rollback();
            return error('admin.brands.index', __('admin/brands.fail'));

        }
    } //end of update


    public function destroy(Brand $brand)
    {
        try {

            $brand->translations()->delete();

            if($brand->photo != 'default.jpeg'){

                Storage::disk('brands')->delete($brand->photo);

            }

            $brand->delete();

            return success('admin.brands.index', __('admin/brands.deleted successfully'));

        } catch (\Exception $ex) {

            return error('admin.brands.index', __('admin/brands.fail'));
        }

    } //end of destroy


} //end of controller
