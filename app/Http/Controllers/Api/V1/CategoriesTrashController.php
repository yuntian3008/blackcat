<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tmp = Category::onlyTrashed();
        $categories['recursive'] = $tmp->with('childrenOnlyTrashRecursive')->whereNull('parent_id')->get();
        $categories['original'] = $tmp->get();
        
        
        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        return $category;//$category->parent()->withTrashed()->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        if ($request->withChildren) {
            $category->children()->restore();
        }
        else {
            $category->childrenWithTrash()->update(['parent_id' => null]);
        }
        $category->parent_id = null;
        $category->save();
        $category->restore();
        
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $category->children()->forceDelete();
        $category->products()->delete();
        $category->forceDelete();

        return $category;
    }
}
