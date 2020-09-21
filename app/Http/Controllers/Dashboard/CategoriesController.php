<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use App\Traits\categories;
use Illuminate\Http\Request;
use DB;

class CategoriesController extends Controller
{
    use categories;

    public function index()
    {
        $categories = Category::with('_parent')->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }



    public function edit($id)
    {
        $category = $this->getElementById($id);
        if (!$category)
            return $this->notFoundMsg('admin.categories', __('admin/category.category not found'));

        $allCategories = Category::select('id', 'parent_id');
        return view('dashboard.categories.edit', compact('category', 'allCategories'));
    }


    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = $this->getElementById($id);
            if (!$category)
                return $this->notFoundMsg('admin.categories', __('admin/category.category not found'));

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            DB::beginTransaction();
            $category->update($request->all());
            $category->name = $request->name;
            $category->save();
            DB::commit();

            if ($category->parent_id == null)
                return $this->successMsg('main', __('admin/category.updated successfully'));

            return $this->successMsg('sub', __('admin/category.updated successfully'));

        } catch (\Exception $ex) {
            return $this->errorMsg('main', __('admin/category.there is error'));
        }
    }





    public function create()
    {
        $allCategories = Category::select('id', 'parent_id')->get();
        return view('dashboard.categories.create', compact('allCategories'));
    }



    public function store(CategoryRequest $request)
    {
        try {
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            if ($request->type == 1) {
                $request->request->add(['parent_id' => null]);
            }

            $fileName = uploadImage('categories', $request->photo);

            DB::beginTransaction();
            $category = Category::create($request->except('_token')); //can use all
            $category->name = $request->name;
            $category->photo = $fileName;
            $category->save();
            DB::commit();

            return $this->success('admin.categories', __('admin/category.added successfully'));

        } catch (\Exception $ex) {
            return $this->error('admin.categories', __('admin/category.there is error'));
        }
    }






    public function destroy($id)
    {
        try {
            $category = $this->getElementById($id);
            if (!$category)
                return $this->notFoundMsg('admin.categories', __('admin/category.category not found'));

            $category->translations()->delete();
            $category->delete();

            return $this->success('admin.categories', __('admin/category.deleted successfully'));

        } catch (\Exception $ex) {
            return $this->error('admin.categories', __('admin/category.there is error'));
        }
    }


}
