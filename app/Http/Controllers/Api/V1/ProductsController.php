<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use App\Product;
use App\Components\Helper\ImageProcessing;
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
            $product['product_image'] = Storage::url('public/sm_' . $product['product_image'] . '.png');
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
        //dd(mb_convert_encoding($request, 'UTF-8', 'UTF-8'));
        //$request = mb_convert_encoding($request, 'UTF-8', 'UTF-8');
        $specs = $request->product_specs;
        //return $request;
        $request->merge([
            'product_image' => $this->imgProcess->run($request->product_image[0]['dataURL'], 'products'),
            'product_slug' => $this->sluger($request->product_name)
        ]);
        $product = Product::create($request->except(['product_specs']));
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
        $product['product_image'] = Storage::url('public/sm_' . $product['product_image'] . '.png');
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
        if ($request->only_edit_visible) {
            $product->update(['product_visible' => $request->product_visible]);
            return $product;
        }



        if ($request->product_image) {
            $merge = [
                'product_image' => $this->imgProcess->run($request->product_image[0]['dataURL'], 'products'),
                'product_slug' => $this->sluger($request->product_name)
            ];
            $except = ['product_specs'];
        } else {
            $merge = [
                'product_slug' => $this->sluger($request->product_name)
            ];
            $except = ['product_image', 'product_specs'];
        }

        $request->merge($merge);
        $product->update($request->except($except));

        $specs = $request->product_specs;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->product_visible = false;
        $product->save();
        // Storage::disk('local')->delete('public/products/lg_'.$product->product_image);
        // Storage::disk('local')->delete('public/products/sm_'.$product->product_image);
        // $product->specs()->delete();
        // $product->delete();
        return '';
    }
}
