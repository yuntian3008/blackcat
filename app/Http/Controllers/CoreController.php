<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use Illuminate\Support\Collection;
use App\Plant;
use App\Components\Helper\ImageProcessing;

class CoreController extends Controller
{
    private $imgProcess;

    function __construct()
    {
        $this->imgProcess = new ImageProcessing();
    }

    public function categories()
    {
        $categories = Category::where('category_visible',1)->get();
        foreach ($categories as $category) {
            $category['category_image'] = $this->imgProcess->getURL($category['category_image'],'sm');
        }
        return view('categories', ['data' => $categories]);
    }

    public function plants($category_slug)
    {
        $category = Category::where('category_slug', $category_slug)
        ->where('category_visible',1)
        ->firstOrFail();
        $plants = Plant::where('category_id', $category->id)->get();

        foreach ($plants as $plant) {
            $plant['plant_image'] = $this->imgProcess->getURL($plant['plant_image'],'sm');
        }
        return view('plants', [
            'data' => $plants,
            'current_category' => $category->category_name
        ]);
    }

    public function detail_plant($category_slug,$plant_slug)
    {
        $category = Category::where('category_slug', $category_slug)
        ->where('category_visible',1)
        ->firstOrFail();
        $plant = Plant::where('category_id', $category->id)->where('plant_slug' , $plant_slug)->firstOrFail();

        $plant['plant_image'] = $this->imgProcess->getURL($plant['plant_image'],'sm');

        return view('detail_plant' , [
            'current_category_name' => $category->category_name,
            'current_category_slug' => $category->category_slug,
            'current_plant' => $plant->plant_name,
            'data' => $plant]
        );
    }



    
}
