<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

use App\Components\Helper\Search;

class ProductController extends Controller
{
    public function index(Request $request) {
        if ($request->has('sort') && !is_array($request->sort)) {
           $request->merge([
                'sort' =>json_decode($request->sort,true),
            ]);
        }
        return Search::product($request);
    }
}
