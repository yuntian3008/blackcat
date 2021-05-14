<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Category;
use App\Components\Helper\ImageProcessing;

class CategoriesController extends Controller
{

    private $imageProcessing;

    function __construct()
    {
        $this->imageProcessing = new ImageProcessing();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('permission:1');
        $categories = Category::all();
        
        foreach ($categories as $category) {
            // $id_images = collect(json_decode($category['category_image'],true))->collapse();
            $category['category_image'] = $this->imageProcessing->getURL($category['category_image'],'sm');
        }
        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //USE VUEJS
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
           'category_image' => $this->imageProcessing->run($request->category_image[0]['dataURL'],'categories'),
           'category_slug' => $this->sluger($request->category_name),
        ]);
        $category = Category::create($request->all());
        return $category;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $category['category_image'] = $this->imageProcessing->getURL($category['category_image'],'sm');
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //USE VUEJS
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
        $category = Category::findOrFail($id);
        
        
        if ($request->category_image) {
            $request->merge([ 
            'category_image' => $this->imageProcessing->run($request->category_image[0]['dataURL'],'categories'),
            'category_slug' => $this->sluger($request->category_name)
        ]);
            $category->update($request->all());
        } else {
            $request->merge([
                'category_slug' => $this->sluger($request->category_name)
            ]);
            $category->update($request->except(['category_image']));
        }

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
        $category = Category::findOrFail($id);
        // Storage::disk('local')->delete('public/categories/lg_'.$category->category_image);
        // Storage::disk('local')->delete('public/categories/sm_'.$category->category_image);
        // foreach ($category->plants as $plant) {
        //     Storage::disk('local')->delete('public/plants/lg_'.$plant->plant_image);
        //     Storage::disk('local')->delete('public/plants/sm_'.$plant->plant_image);
        // }
        $category->plants()->delete();
        $category->delete();
        return '';
    }
}
