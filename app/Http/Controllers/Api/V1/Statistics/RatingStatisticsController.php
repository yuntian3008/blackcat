<?php

namespace App\Http\Controllers\Api\V1\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Review;
use App\Product;
use Illuminate\Support\Facades\DB;

class RatingStatisticsController extends Controller
{
    public function top($top = 10)
    {
        $r = DB::table('products')
            ->join('order_details','products.id','=','order_details.product_id')
            ->join('reviews','order_details.id','=','reviews.order_detail_id')
            ->selectRaw('avg(reviews.level) as avg_rating, products.id, products.product_name')
            ->groupBy('products.id','products.product_name')
            ->orderBy('avg_rating','desc')
            ->take($top)
            ->get();
        while ($r->count() < $top)
            $r->push([
                'avg_rating' => 0,
                'id' => null,
                'product_name' => '',
            ]);
        return $r;
    }

    public function countProductByRating() {
        $data = [0];
        for ($i=0; $i < 5; $i++) { 
            $count = DB::table(DB::table('products')
            ->join('order_details','products.id','=','order_details.product_id')
            ->join('reviews','order_details.id','=','reviews.order_detail_id')
            ->selectRaw('avg(reviews.level) as avg_rating, products.id')
            ->groupBy('products.id')
            ->havingRaw('avg_rating > ? AND avg_rating <= ?',[$i,$i+1]))->count();
            array_push($data,$count);
        }
        
        return $data;
    }
}
