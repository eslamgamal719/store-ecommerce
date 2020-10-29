<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use Storage;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\Dashboard\CategoryRequest;


class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::with('_parent')
            ->orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT);

        return view('dashboard.categories.index', compact('categories'));

    }//end of index



    public function edit(Category $category)
    {
        $allCategories = Category::parent()
            ->select('id', 'parent_id')
            ->get();

        return view('dashboard.categories.edit', compact('category', 'allCategories'));

    }//end of create



    public function update(CategoryRequest $request, Category $category)
    {
        try {

            isActive($request); // add 1 for active and 0 for inactive

            DB::beginTransaction();
            $category->update($request->except('photo'));

            if ($request->has('photo')) {
                if ($category->photo != 'default.jpeg') {
                    Storage::disk('categories')->delete($category->photo);
                }

                $fileName = uploadImage('categories', $request->photo);
                $category->photo = $fileName;
                $category->save();
            }

            DB::commit();
            return success('admin.categories.index', __('admin/category.updated successfully'));

        } catch (\Exception $ex) {

            DB::rollback();
            return error('admin.categories.index', __('admin/category.there is error'));
        }

    }//end of update



    public function create()
    {
        $categories = Category::parent()
            ->select('id', 'parent_id')
            ->get();

        return view('dashboard.categories.create', compact('categories'));

    }//end of create



    public function store(CategoryRequest $request)
    {
        try {

            isActive($request);

            if ($request->type == CategoryType::MainCategory) {
                $request->request->add(['parent_id' => null]);
            }

            DB::beginTransaction();

            $category = Category::create($request->except('_token', 'photo'));

            if ($request->has('photo')) {

                $fileName = uploadImage('categories', $request->photo);
                $category->photo = $fileName;
                $category->save();

            }

            DB::commit();

            return success('admin.categories.index', __('admin/category.added successfully'));

        } catch (\Exception $ex) {
            DB::rollback();
            return error('admin.categories.index', __('admin/category.there is error'));
        }

    }//end of store



    public function destroy(Category $category)
    {
        try {

            DB::beginTransaction();

            if ($category->photo != 'default.jpeg') {

                Storage::disk('categories')->delete($category->photo);

            }

            $category->translations()->delete();

            if (isset($category->_child))
                foreach ($category->_child as $subCat) {
                    $subCat->delete();
                }

            $category->delete();

            DB::commit();

            return success('admin.categories.index', __('admin/category.deleted successfully'));

        } catch (\Exception $ex) {
            DB::rollback();
            return error('admin.categories.index', __('admin/category.there is error'));
        }

    }//end of destroy


}//end of controller
