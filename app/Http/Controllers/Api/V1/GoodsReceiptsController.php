<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\GoodsReceipt;
use App\GoodsReceiptDetail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class GoodsReceiptsController extends Controller
{
    protected $staff = null;

    function __construct() {
        $this->staff = Auth::guard('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GoodsReceipt::with('goodsReceiptDetails','staff:id,firstname,lastname','supplier:id,company_name')->orderBy('created_at','desc')->paginate(5);
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
        Validator::make($request->all(), [
            'supplier_id' => ['required','exists:suppliers,id'],
            'details' => ['required','array'],
            'details.*.product_id' => ['required','exists:products,id'],
            'details.*.quantity' => ['required','numeric','min:1'],
            'details.*.unit_price' => ['required','numeric','min:0'],
        ])->validate();

        $total_amount = 0;

        foreach ($request->details as $index => $detail) {
            $total_amount = $detail['quantity'] * $detail['unit_price'];
        }

        $gr = GoodsReceipt::create([
            'supplier_id' => $request->supplier_id,
            'staff_id' => $this->staff->id,
            'total_amount' => $total_amount,
        ]);

        foreach ($request->details as $index => $detail) {
            $gr->goodsReceiptDetails()->create([
                'product_id' => $detail['product_id'],
                'quantity' => $detail['quantity'],
                'unit_price' => $detail['unit_price'],
             ]);
        }

        foreach($gr->goodsReceiptDetails as $detail) {
            $detail->product->addStock($detail->quantity);
            $detail->trackingGoods()->create();
        }

        return $gr;        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Validator::make(['id' => $id], [
            'id' => ['required','exists:goods_receipt_details,id'],
        ])->validate();

        return GoodsReceiptDetail::with('product')->where('goods_receipt_id',$id)->get();
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
        // Validator::make(['id' => $id], [
        //     'id' => ['required','exists:goods_receipts,id'],
        // ])->validate();

        // $gr = GoodsReceipt::find($id);

        // Validator::make($request->all(), [
        //     'staff_id' => ['exists:staff,id'],
        //     'details' => ['required','array','size:'$gr->count()],
        //     'details.*.detail_id' => ['required','exists:goods_receipt_details,id','distinct'],
        //     'details.*.unit_price' => ['required','numeric','min:0'],
        // ])->validate();

        // foreach ($request->details as $detail) {
        //     GoodsReceiptDetail::find($detail['detail_id'])->update([
        //         'unit_price' => $detail['unit_price'],
        //     ]);
        // }

        // $receipt_date = Carbon::now();
        // $total_amount = 0;

        // foreach ($gr->goodsReceiptDetails as $details) {
        //     $total_amount += $details->quantity * $request->unit_price;
        // }

        // $gr = GoodsReceipt::create([
        //     'supplier_id' => $request->supplier_id,
        // ]);

        // foreach ($request->details as $index => $detail) {
        //     $gr->goodsReceiptDetails()->create([
        //         'product_id' => $detail['product_id'],
        //         'quantity' => $detail['quantity'],
        //      ]);
        // }

        // return $gr;        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Validator::make(['id' => $id], [
            'id' => ['required',Rule::exists('goods_receipts')->where(function ($query) {
                    $query->where('created_at','>',Carbon::now()->subDay(1));
                }),],
        ])->validate();
        $goodReceipt = GoodsReceipt::find($id);

        foreach ($goodReceipt->goodsReceiptDetails as $detail) {
            $remain = $detail->product->stock - $detail->quantity;
            if($remain < 0) {
                return response()->json([
                    'message' => 'something went wrong',
                    'errors' => [
                        'stock' => ['Cannot delete this Goods Receipt, Some of the newly imported products may have already been purchased by customers']
                    ]
                ], 400);
                /** 
                    UPDATE IN THE FUTURE

                 */
                // $recentOrder = [];
                // $productSoldOut = $detail->product;
                // $detailsHaveProductSoldOut = OrderDetail::where('product_id',$productSoldOut->id)->orderBy('created_at','desc')->get();
                // foreach ($detailsHaveProductSoldOut as $value) {
                //     $remain-=$value->quantity;
                //     array_push($recentOrder,$value->order);
                //     if ($remain < 0) break;
                // }
                // return $recentOrder;
            }
        }

        foreach ($goodReceipt->goodsReceiptDetails as $detail) {
            $detail->product->subStock($detail->quantity);
            $detail->trackingGoods()->delete();
        }
        $goodReceipt->goodsReceiptDetails()->delete();
        $goodReceipt->delete();

        return '';
    }
}
