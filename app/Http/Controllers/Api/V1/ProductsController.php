<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use App\Product;
use App\Components\Helper\ImageProcessing;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{

    protected $imgProcess;

    function __construct()
    {
        $this->imgProcess = new ImageProcessing();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->page) {
            $products = Product::with('category:id,category_name')->paginate(5);
        }
        else $products = Product::with('category:id,category_name')->get();

        foreach ($products as $product) {
            $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
            // Storage::url('public/sm_' . $product['product_image'] . '.' . config('image-processing')['format']);
            //
            // $id_images = collect(json_decode($product['product_image'],true))->collapse();
            // $product['product_image'] = self::DRIVE_CONFIG_URL.$id_images['sm'];
            //asset('storage/sm_'.$product['product_image']);
        }
        return $products;
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
        // $collection = collect(json_decode($request->data,true));

        // dd($request->all());

        $request->merge([
            'product_image' => $this->imgProcess->runForArray($request->product_image, 'products'),
            'product_slug' => $this->sluger($request->product_name),
        ]);

        // $collection = $collection->merge([
        //     'product_image' => $this->imgProcess->run($request->product_image, 'products'),
        //     'product_slug' => $this->sluger($collection->get('product_name')),
        // ]);

        $specs = $request->product_specs;
        // $product = Product::create($collection->except(['product_specs'])->toArray());
        $product = Product::create(
            $request->except(['product_specs'])
        );
        $product->update(['product_slug' => $this->sluger($product->id.'-'.$product->product_name)]);
        $product->specs()->createMany($specs);
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        // $id_images = collect(json_decode($product['product_image'],true))->collapse();
        // $product['product_image'] = self::DRIVE_CONFIG_URL.$id_images['sm'];
        // $product['product_image'] = ImageProcessing::getURL($product['product_image'],'sm');
        $product['product_specs'] = $product->specs;
        return $product;
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
        $product = Product::findOrFail($id);
        if ($request->has('data')) {
            $collection = collect(json_decode($request->data,true));
            $collection = $collection->merge([
                'product_slug' => $this->sluger($id.'-'.$collection->get('product_name'))
            ]);

            $product->update($collection->toArray());

            $specs = $collection->get('product_specs');
            $id = collect($specs)->pluck('id');

            $product->specs()->whereNotIn('id', $id)->delete();

            foreach ($specs as $spec) {
                $product->specs()->updateOrCreate(
                    ['key' => $spec["key"]],
                    ['value' => $spec["value"]]
                );
            }

            return $product;
        }

        if ($request->has('product_image')) {
            $product->update([
                'product_image' => $this->imgProcess->run($request->product_image, 'products')
            ]);

            return $product;
        }

        if ($request->has('visible')) {
            $visible = json_decode($request->visible);
            $product->update(['product_visible' => $visible]);
            return $product;
        }

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // $product->product_visible = false;
        // $product->save();
        // Storage::disk('local')->delete('public/products/lg_'.$product->product_image);
        // Storage::disk('local')->delete('public/products/sm_'.$product->product_image);
        // $product->specs()->delete();
        $product->delete();
        return '';
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'base64_image',
            'dir' => 'required',
        ]);
        return response()->json([
            'file' => $this->imgProcess->runForArray($request->images, 'products',$request->dir)
        ], 200); ;
    }

    public function destroyImage($dir,$image)
    {
        $img = array_filter(Storage::disk('public')->files($dir), function ($item) {
                    //only png's
                    return strpos($item, 'sm');
                 });
        if (count($img) > 1) {
            if (Storage::disk('public')->exists($dir.'/'.$image)) {
                Storage::disk('public')->delete($dir.'/'.$image);
                Storage::disk('public')->delete($dir.'/'.str_replace('sm','bg',$image));
            }
            else
                return response()->json([
                    'message' => 'File not found'
                ], 422);
        } else {
            return response()->json([
                'message' => 'A product must have at least one photo'
            ], 422);
        }

        return '';
    }
}
