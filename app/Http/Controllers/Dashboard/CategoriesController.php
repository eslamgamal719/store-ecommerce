<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use App\Traits\categories;
use Illuminate\Http\Request;
use DB;
use Storage;

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

        $allCategories = Category::parent()->select('id', 'parent_id')->get();
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

            Storage::disk('categories')->delete($category->photo);
            $fileName = uploadImage('categories', $request->photo);

            DB::beginTransaction();
            $category->update($request->all());
            $category->name = $request->name;
            $category->photo = $fileName;
            $category->save();
            DB::commit();

            return $this->success('admin.categories', __('admin/category.updated successfully'));
        } catch (\Exception $ex) {
            return $this->error('admin.categories', __('admin/category.there is error'));
        }
    }


    public function create()
    {
        $categories = Category::parent()->select('id', 'parent_id')->get();
        return view('dashboard.categories.create', compact('categories'));
    }


    public function store(CategoryRequest $request)
    {
        try {
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            if ($request->type == CategoryType::MainCategory) {
                $request->request->add(['parent_id' => null]);
            }

            $fileName = uploadImage('categories', $request->photo);

            DB::beginTransaction();
            $category = Category::create($request->except('_token', 'photo')); //can use all
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

            Storage::disk('categories')->delete($category->photo);
            $category->translations()->delete();

            if (isset($category->_child))
                foreach ($category->_child as $subCat) {
                    $subCat->delete();
                }

            $category->delete();

            return $this->success('admin.categories', __('admin/category.deleted successfully'));

        } catch (\Exception $ex) {
            return $this->error('admin.categories', __('admin/category.there is error'));
        }

    }


}
