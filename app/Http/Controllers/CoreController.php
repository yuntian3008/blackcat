<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use Illuminate\Support\Collection;
use App\Product;
use App\Components\Helper\ImageProcessing;

class CoreController extends Controller
{
    private $imgProcess;

    function __construct()
    {
        $this->imgProcess = new ImageProcessing();
        return view()->share('navbar_data', Category::where('category_visible',1)->get());
    }

    public function home()
    {
        $categories = Category::where('category_visible',1)->get();
        foreach ($categories as $category) {
            $category['products'] = $category->products()->where('product_visible', 1)->get();
            foreach ($category['products'] as $product) {
                $product['product_image'] = $this->imgProcess->getURL($product['product_image'],'sm');
                $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
            }
        }
        // $products = Product::where('product_visible', 1)->get();
        // foreach ($products as $product) {
        //     $product['product_image'] = $this->imgProcess->getURL($product['product_image'],'sm');
        //     $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
        // }
        return view('home', [
            'data' => $categories,
        ]);
    }

    public function categories()
    {
        $categories = Category::where('category_visible',1)->get();
        foreach ($categories as $category) {
            $category['category_image'] = $this->imgProcess->getURL($category['category_image'],'sm');
        }
        return view('categories', ['data' => $categories]);
    }

    public function products($category_slug)
    {
        $category = Category::where('category_slug', $category_slug)
        ->where('category_visible',1)
        ->firstOrFail();
        $products = Product::where('category_id', $category->id)->where('product_visible', 1)->get();

        foreach ($products as $product) {
            $product['product_image'] = $this->imgProcess->getURL($product['product_image'],'sm');
            $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
        }
        return view('products', [
            'data' => $products,
            'current_category' => $category->category_name
        ]);
    }

    public function product_details($category_slug,$product_slug)
    {
        $product = Product::where('product_slug' , $product_slug)->where('product_visible', 1)->firstOrFail();
        $category = $product->category;

        $product['product_image_sm'] = $this->imgProcess->getURL($product['product_image'],'sm');
        $product['product_image_bg'] = $this->imgProcess->getURL($product['product_image'],'bg');
        $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;

        return view('product_details' , [
            'category' => $category,
            'product' => $product]
        );
    }



    
}
