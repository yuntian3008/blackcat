<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use Illuminate\Support\Collection;
use App\Product;
use Illuminate\Support\Facades\Validator;
use App\Components\Helper\ImageProcessing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class CoreController extends Controller
{

    function __construct()
    {
        //return view()->share('navbar_data', Category::all());
    }

    public function home()
    {
        return view('welcome');
    }
    public function shop()
    {
        $categories = Category::whereNull('parent_id')->get();
        // foreach ($categories as $category) {
        //     $category['products'] = $category->products()->where('product_visible', 1)->get();
        //     foreach ($category['products'] as $product) {
        //         $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
        //         if ($product->specs()->where("key","Brand")->count())
        //         $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
        //     }
        // }
        // $products = Product::where('product_visible', 1)->get();
        // foreach ($products as $product) {
        //     $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
        //     $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
        // }
        return view('shop', [
            'categories' => $categories,
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

    public function flatten($array)
    {
            $flatArray = [];

            if (!is_array($array)) {
                $array = (array)$array;
            }

            foreach($array as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $flatArray = array_merge($flatArray, $this->flatten($value));
                } else {
                    $flatArray[0][$key] = $value;
                }
            }

            return $flatArray;
    }

    public function search(Request $request)
    {
        Validator::make($request->all(), [
            'search' => 'nullable|string'
        ])->validate();
        if( !empty($request->search) ) {
            $products = Product::whereHas('category', function (Builder $query) use($request) {
                $query->where('category_name', 'like', "%{$request->search}%");
                })
                ->orWhere('product_name', 'like', "%{$request->search}%")
                ->orWhere('product_desc', 'like', "%{$request->search}%")
                ->orWhere('product_price', 'like', "%{$request->search}%")->where('product_visible', 1)->get();
            foreach ($products as $product) {
                //$product->product_image = ImageProcessing::getURL($product->product_image,'sm');
                $product["href"] = route('product.details', [
                    'category_slug' => $product->category->category_slug,
                    'product_slug' => $product->product_slug,
                ]);
            }
            return $products;
        }
        return [];
    }

    public function products(Request $request,$category_slug = null)
    {
        if (is_null($category_slug)) {
            $data = Category::all('id','category_name','category_slug');
            foreach ($data as $key => $value) {
                if ($value->randomProducts()->count() == 0) {
                    unset($data[$key]);
                    continue;
                }
                $data[$key] = [
                    'category' => $value,
                    'products' => $value->randomProducts(4),
                ];
            }
            return view('shop', [
                'data' => $data,
                'category' => null
                //'current_category' => $category->category_name
            ]);
        }
        //$category = Category::where('category_slug',$category_slug)->firstOrFail();
        $categories = Category::with('children')->where('category_slug',$category_slug)->get();
        $products = new Collection();
        while(count($categories) > 0){
            $nextCategories = [];
            foreach ($categories as $category) {
                $products = $products->merge($category->products()->where('product_visible', 1)->get());
                $nextCategories = array_merge($nextCategories, $category->children->all());
            }
            $categories = $nextCategories;
        }


        //$data = $category->products()->where('product_visible', 1);

        if ($request->sort && $request->sortBy) {
            Validator::make($request->all(), [
                'sort' => 'string|in:product_name,product_price',
                'sortBy' => 'numeric|between:0,1',
            ])->validate();
            $products = $request->sortBy ? $products->sortBy($request->sort) :  $products->sortByDesc($request->sort);
        }

        $total= $products->count();
        $per_page = 8;
        $current_page = $request->input("page") ?? 1;

        $starting_point = ($current_page * $per_page) - $per_page;

        $array = array_slice($products->all(), $starting_point, $per_page, true);

        $data = new Paginator($array, $total, $per_page, $current_page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

       // dd($products->all());
        //$data = $data->paginate(8);
        return view('shop', [
            'data' => $data,
            'category' => $category,
            //'current_category' => $category->category_name
        ]);
    }

    public function product_details($category_slug,$product_slug)
    {
        $product = Product::where('product_slug' , $product_slug)->where('product_visible', 1)->firstOrFail();
        $category = $product->category;
        //$product['product_image_sm'] = ImageProcessing::getURL($product['product_image'],'sm');
        //$product['product_image_bg'] = ImageProcessing::getURL($product['product_image'],'bg');
        if ($product->specs()->where("key","Brand")->count())
        $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;

        return view('product_details' , [
            'category' => $category,
            'product' => $product,
            'stars' => $product->reviews->avg('level'),
            ]
        );
    }

    // public function search($keyword = null)
    // {
    //     $products = Product::whereHas('specs', function (Builder $query) use($keyword) {
    //         $query->where('key', 'LIKE', "%{$keyword}%")->orWhere('value', 'LIKE', "%{$keyword}%");
    //     })->orWhere('product_name', 'LIKE', "%{$keyword}%")
    //     ->orWhere('product_desc', 'LIKE', "%{$keyword}%")
    //     ->where('product_visible', 1)->paginate(8);
    //     foreach ($products as $product) {
    //         $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
    //         if ($product->specs()->where("key","Brand")->count())
    //         $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
    //     }
    //     return view('search', [
    //         'data' => $products,
    //         'keyword' => $keyword,
    //     ]);
    // }

    public function showFormSearch() {

    }

    public function advancedSearch()
    {
        return view('advanced_search');
        // if ($request->min && $request->max)
        //         if ($request->min >= $request->max)
        //             return view('search', [
        //                 'data' => null,
        //             ]);
        // if ($request->category_id)
        //     $products = Product::where('category_id',$request->category_id)->where('product_visible', 1);
        // else
        //     $products = Product::where('product_visible', 1);

        // if ($request->keyword) {
        //     $keyword = $request->keyword;

        //     $products = $products->whereHas('specs', function (Builder $query) use($keyword) {
        //         $query->where('key', 'LIKE', "%{$keyword}%")->orWhere('value', 'LIKE', "%{$keyword}%");
        //     })
        //     ->orWhere('product_name', 'LIKE', "%{$keyword}%")
        //     ->orWhere('product_desc', 'LIKE', "%{$keyword}%");
        // }

        // if ($request->min)
        //         $products = $products->where('product_price', '>=', $request->min);

        // if ($request->max)
        //     $products = $products->where('product_price', '>=', $request->max);

        // $products = $products->paginate(8);


        // foreach ($products as $product) {
        //     $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
        //     if ($product->specs()->where("key","Brand")->count())
        //     $product['product_brand'] = $product->specs()->where("key","Brand")->first()->value;
        // }
        // return view('advanced_search', [
        //     'data' => $products,
        //     'param' => $request->query(),
        // ]);
    }





}
