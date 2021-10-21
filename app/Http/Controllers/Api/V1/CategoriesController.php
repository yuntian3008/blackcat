<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Category;
use App\Components\Helper\ImageProcessing;
use Illuminate\Support\Facades\Storage;

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
        //$categories = 
        $categories['recursive'] = Category::with('childrenRecursive')->whereNull('parent_id')->get();
        $categories['original'] = Category::all();
        
        
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
           'category_slug' => $this->sluger( $request->category_name),
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
        $category['products'] = $category->products()->with('category:id,category_name')->get();
        foreach ($category['products'] as $product) {
            $product['product_image'] = Storage::url('public/sm_'.$product['product_image'].'.png');
            // $id_images = collect(json_decode($product['product_image'],true))->collapse();
            // $product['product_image'] = self::DRIVE_CONFIG_URL.$id_images['sm'];
            //asset('storage/sm_'.$product['product_image']);
        }
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
        if ($request->parent_id) {
            if ($request->parent_id == $id) return response('The parent category is not itself',405);
            $parent = Category::findOrFail($request->parent_id);
            
            while (!is_null($parent->parent_id)) {
                if ($parent->parent_id == $id) return response('Sorry! You can\'t set subcategories of this category to parent of category',405);
                $parent = Category::findOrFail($parent->parent_id);
            }

            
        }
        
        $category = Category::findOrFail($id);        
            $request->merge([
                'category_slug' => $this->sluger($request->category_name)
            ]);
        $category->update($request->toArray());
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $isChild = null)
    {
        $category = Category::findOrFail($id);
        // Storage::disk('local')->delete('public/categories/lg_'.$category->category_image);
        // Storage::disk('local')->delete('public/categories/sm_'.$category->category_image);
        // foreach ($category->plants as $plant) {
        //     Storage::disk('local')->delete('public/plants/lg_'.$plant->plant_image);
        //     Storage::disk('local')->delete('public/plants/sm_'.$plant->plant_image);
        // // }
        // $category->products()->delete();
        $children = $category->childrenRecursive()->get();
        foreach ($children as $child) {
            $this->destroy($child->id, true);
        }
        if (!$isChild)
            $category->update([
                'parent_id' => null,
            ]);
        $category->delete();
        return '';
    }
}
