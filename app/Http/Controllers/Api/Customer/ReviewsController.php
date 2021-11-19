<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use Carbon\Carbon;
use App\Components\Helper\ImageProcessing;
use App\Rules\OrderNotProcessedYet;
class ReviewsController extends Controller
{
    protected $user = null;
    protected $imgProcess;

    function __construct() {

        $this->user = Auth::guard('web_api')->user();
        $this->imgProcess = new ImageProcessing();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $collection = collect(json_decode($request->data,true));
        
        
        Validator::make($collection->toArray(), [
                'comment' => 'string|nullable',
                'level' => 'required|integer|between:1,5',
                'order_detail_id' => 'required|exists:App\OrderDetail,id|unique:App\Review,order_detail_id',
            ])->validate();

        
        if ($request->has('review_image')) {
            $collection = $collection->merge([
                'review_image' => $this->imgProcess->run($request->review_image, 'reviews'),
            ]);
        }

        $review = Review::create($collection->all());

        return $review;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
