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

    public function index($type)
    {
        if($type == 'main'){
            $categories = Category::parent()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
            return view('dashboard.categories.index', compact('categories'));

        }elseif ($type == 'sub'){
            $categories = Category::child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
            return view('dashboard.categories.index', compact('categories'));
        }else{
            return $this->errorMsg('main',  __('admin/category.there is error'));
        }


    }

    public function edit($id)
    {
        $category = $this->getCategoryById($id);
        if (!$category)
            return $this->notFoundMsg(__('admin/category.category not found'));

        $mainCategories = Category::parent()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.edit', compact('category', 'mainCategories'));
    }



    public function update(CategoryRequest $request, $id)
    {
        try {
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = $this->getCategoryById($id);
            if (!$category)
                return $this->notFoundMsg(__('admin/category.category not found'));

            DB::beginTransaction();
            $category->update($request->all());
            $category->name = $request->name;
            $category->save();
            DB::commit();

            if($category->parent_id == null)
                return $this->successMsg('main', __('admin/category.updated successfully'));

                return $this->successMsg('sub', __('admin/category.updated successfully'));

        } catch (\Exception $ex) {
            return $this->errorMsg('main',  __('admin/category.there is error'));
        }
    }



    public function destroy($id)
    {
        try {
            $category = $this->getCategoryById($id);
            if (!$category)
                return $this->notFoundMsg(__('admin/category.category not found'));

            $category->delete();
            if($category->parent_id == null)
            return $this->successMsg('main', __('admin/category.deleted successfully'));

            return $this->successMsg('sub', __('admin/category.deleted successfully'));

        } catch (\Exception $ex) {
            return $this->errorMsg('main',  __('admin/category.there is error'));
        }
    }



    public function create($type)
    {
        if($type == 'main')
             return view('dashboard.categories.create');

        elseif($type == 'sub'){
             $mainCategories = Category::parent()->orderBy('id', 'DESC')->get();
             return view('dashboard.categories.create', compact('mainCategories'));
        }else{
            return $this->errorMsg('main',  __('admin/category.there is error'));
        }
    }



    public function store(CategoryRequest $request)
    {
        try {
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            DB::beginTransaction();
            $category = Category::create($request->except('_token')); //can use all
            $category->name = $request->name;
            $category->save();
            DB::commit();

           if(isset($request->parent_id) && $request->parent_id != null)
           return $this->successMsg('sub', __('admin/category.added sub successfully'));

           return $this->successMsg('main', __('admin/category.added main successfully'));

        } catch (\Exception $ex) {
            return $this->errorMsg('main',  __('admin/category.there is error'));
        }
    }



}
