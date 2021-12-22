<?php

namespace App\Components\Helper;

/**
 * Class ImageProcessing
 * @package App\Components\Helper
 */

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Product;
class Search
{
	public static function product($request) {
		$products = new Product();
		Validator::make($request->all(), [
			'min_price' => 'numeric|between:0,1000000000',
			'max_price' => 'numeric|between:1,1000000000',
			'category_id' => 'exists:App\Category,id',
			'keywords' => 'string|max:100',
			'sort.field' => 'required_with:sort.by|in:product_name,product_price|string|nullable',
			'sort.by' => 'required_with:sort.field|in:asc,desc|string|nullable',
		])->validate();
		if (!is_null($request->min_price) && !is_null($request->max_price) && ($request->min_price > $request->max_price)) {
			return [];
		}
		if (!is_null($request->min_price)) $products = $products->where('product_price', '>=',$request->min_price);
		if (!is_null($request->max_price)) $products = $products->where('product_price', '<=',$request->max_price);
		if (!is_null($request->category_id)) $products = $products->where('category_id',$request->category_id);		
		if (!is_null($request->keywords)) {
			$products = $products->whereHas('category', function (Builder $query) use($request) {
		                $query->where('category_name', 'like', "%{$request->keywords}%");
		                })
		                ->orWhere('product_name', 'like', "%{$request->keywords}%")
		                ->orWhere('product_desc', 'like', "%{$request->keywords}%")
		                ->orWhere('product_price', 'like', "%{$request->keywords}%");
	        }
		if (!is_null($request->sort) && !is_null($request->sort['field']) && !is_null($request->sort['by'])) $products = $products->orderBy($request->sort['field'],$request->sort['by']);		


		return $products->get();
	}
}