<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::parent()->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function edit($id)
    {

        $category = Category::find($id);
        if (!$category)
            return redirect()->back()->with(['error', 'هذا القسم غير موجود']);

        return view('dashboard.categories.edit', compact('category'));
    }


    public function update(MainCategoryRequest $request, $id)
    {

        try {
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => __('admin/category.there is error')]);

            DB::beginTransaction();
            $category->update($request->all());
            $category->name = $request->name;
            DB::commit();

            return redirect()->route('admin.maincategories')->with(['success' => __('admin/category.updated successfuly')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => __('admin/category.there is error')]);
        }
    }
}
