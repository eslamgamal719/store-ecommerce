<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TagsRequest;
use App\Models\Tag;
use App\Traits\categories;
use Illuminate\Http\Request;
use DB;

class TagsController extends Controller
{

    use categories;

    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }


    public function create()
    {
        return view('dashboard.tags.create');
    }


    public function store(TagsRequest $request)
    {
        try {

            DB::beginTransaction();
            $tag = Tag::create($request->except('token'));
            $tag->name = $request->name;
            $tag->save();
            DB::commit();

            return $this->success('admin.tags', __('admin/tags.add successfully'));
        } catch (\Exception $ex) {
            return $this->error('admin.tags', __('admin/tags.add fail'));
        }
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
        if (!$tag)
            $this->notFoundMsg('admin.tags', __('admin/tags.tag not found'));

        return view('dashboard.tags.edit', compact('tag'));
    }


    public function update($id, TagsRequest $request)
    {
        try {
            $tag = Tag::find($id);
            if (!$tag)
                $this->notFoundMsg('admin.tags', __('admin/tags.tag not found'));

            DB::beginTransaction();

            $tag->update($request->except('_token'));
            $tag->name = $request->name;
            $tag->save();
            DB::commit();

            return $this->success('admin.tags', __('admin/tags.updated successfully'));
        } catch (\Exception $ex) {
            return $this->error('admin.tags', __('admin/tags.add fail'));
        }
    }


    public function destroy($id)
    {
        try {
            $tag = Tag::find($id);
            if (!$tag)
                $this->notFoundMsg('admin.tags', __('admin/tags.tag not found'));

            $tag->translations()->delete();
            $tag->delete();

            return $this->success('admin.tags', __('admin/tags.deleted successfully'));

        } catch (\Exception $ex) {
            return $this->error('admin.tags', __('admin/tags.fail'));
        }
    }



}
