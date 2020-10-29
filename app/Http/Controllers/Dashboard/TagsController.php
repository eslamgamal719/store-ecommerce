<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TagsRequest;


class TagsController extends Controller
{

    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT);

        return view('dashboard.tags.index', compact('tags'));

    }//end of index


    public function create()
    {
        return view('dashboard.tags.create');

    }//end of create


    public function store(TagsRequest $request)
    {
        try {
            $tag = Tag::create($request->except('token'));

            return success('admin.tags.index', __('admin/tags.add successfully'));

        } catch (\Exception $ex) {

            return error('admin.tags.index', __('admin/tags.add fail'));

        }

    }//end of store



    public function edit(Tag $tag)
    {
        return view('dashboard.tags.edit', compact('tag'));

    }//end of edit



    public function update(Tag $tag, TagsRequest $request)
    {
        try {

            $tag->update($request->except('_token'));

            return success('admin.tags.index', __('admin/tags.updated successfully'));

        } catch (\Exception $ex) {

            return error('admin.tags.index', __('admin/tags.add fail'));

        }

    }//end of update


    public function destroy(Tag $tag)
    {
        try {
            $tag->translations()->delete();
            $tag->delete();

            return success('admin.tags.index', __('admin/tags.deleted successfully'));

        } catch (\Exception $ex) {

            return error('admin.tags.index', __('admin/tags.fail'));
        }

    }//end of destroy



}//end of controller
