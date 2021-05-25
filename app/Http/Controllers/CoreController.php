<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use Illuminate\Support\Collection;
use App\Product;
use App\Components\Helper\ImageProcessing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Input;

class CoreController extends Controller
{

    function __construct()
    {
        return view()->share('navbar_data', Category::where('category_visible',1)->get());
    }

    public function home()
    {
        $categories = Category::where('category_visible',1)->get();
        foreach ($categories as $category) {
            $category['products'] = $category->products()->where('product_visible', 1)->get();
            foreach ($category['products'] as $product) {
                $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
                if ($product->specs()->where("key","Brand")->count())
                $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
            }
        }
        // $products = Product::where('product_visible', 1)->get();
        // foreach ($products as $product) {
        //     $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
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
            $category['category_image'] = ImageProcessing::getURL($category['category_image'],'sm');
        }
        return view('categories', ['data' => $categories]);
    }

    public function products($category_slug)
    {
        $category = Category::where('category_slug', $category_slug)
        ->where('category_visible',1)
        ->firstOrFail();
        $products = Product::where('category_id', $category->id)->where('product_visible', 1)->paginate(8);
        foreach ($products as $product) {
            $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
            if ($product->specs()->where("key","Brand")->count())
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

        $product['product_image_sm'] = ImageProcessing::getURL($product['product_image'],'sm');
        $product['product_image_bg'] = ImageProcessing::getURL($product['product_image'],'bg');
        if ($product->specs()->where("key","Brand")->count())
        $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;

        return view('product_details' , [
            'category' => $category,
            'product' => $product]
        );
    }

    public function search($keyword = null) 
    {
        $products = Product::whereHas('specs', function (Builder $query) use($keyword) {
            $query->where('key', 'LIKE', "%{$keyword}%")->orWhere('value', 'LIKE', "%{$keyword}%");
        })->orWhere('product_name', 'LIKE', "%{$keyword}%")
        ->orWhere('product_desc', 'LIKE', "%{$keyword}%")
        ->where('product_visible', 1)->paginate(8);
        foreach ($products as $product) {
            $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
            if ($product->specs()->where("key","Brand")->count())
            $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
        }
        return view('search', [
            'data' => $products,
            'keyword' => $keyword,
        ]);
    }

    public function showFormSearch() {
        $categories = Category::where('category_visible',1)->get();
        return view('search_form',[
            'categories' => $categories,
        ]);
    }

    public function advancedSearch(Request $request) 
    {
        if ($request->min && $request->max) 
                if ($request->min >= $request->max)
                    return view('search', [
                        'data' => null,
                    ]);
        if ($request->category_id)
            $products = Product::where('category_id',$request->category_id)->where('product_visible', 1);
        else
            $products = Product::where('product_visible', 1);

        if ($request->keyword) {
            $keyword = $request->keyword;
            
            $products = $products->whereHas('specs', function (Builder $query) use($keyword) {
                $query->where('key', 'LIKE', "%{$keyword}%")->orWhere('value', 'LIKE', "%{$keyword}%");
            })
            ->orWhere('product_name', 'LIKE', "%{$keyword}%")
            ->orWhere('product_desc', 'LIKE', "%{$keyword}%");
        }

        if ($request->min)
                $products = $products->where('product_price', '>=', $request->min);

        if ($request->max)
            $products = $products->where('product_price', '>=', $request->max);

        $products = $products->paginate(8);
        
        
        foreach ($products as $product) {
            $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
            if ($product->specs()->where("key","Brand")->count())
            $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
        }
        return view('advanced_search', [
            'data' => $products,
            'param' => $request->query(),
        ]);
    }




    
}
