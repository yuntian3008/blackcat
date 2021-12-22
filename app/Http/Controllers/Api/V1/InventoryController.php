<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\GoodsReceipt;
use App\GoodsReceiptDetail;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\TrackingGoods;

class InventoryController extends Controller
{
     /**
     * goodsReceiptsRequest
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      object $request-> { parameter_description }
     */
    public function goodsReceiptsRequest(Request $request)
    {

        Validator::make($request->all(), [
            'staff_id' => ['required','exists:staff,id'],
            'supplier_id' => ['required','exists:suppliers,id'],
            'goods_receipt_details' => ['required', 'array'],
            'goods_receipt_details.*.product_id' => ['required','exists:products,id'],
            'goods_receipt_details.*.quantity' => ['required','integer','min:1']
        ])->validate();

        $goodsReceipt = GoodsReceipt::create($request->only('staff_id','supplier_id'));

        return $goodsReceipt->goodsReceiptDetails()->createMany($request->goods_receipt_details);
    }

    public function goodsReceipts(Request $request)
    {
        Validator::make($request->all(), [
            'goods_receipt_id' => ['required',
                Rule::exists('goods_receipts','id')->where(function ($query) {
                    $query->whereNull('receipt_date');
                }),
            ],
            'goods_receipt_details' => ['required', 'array','size:'.GoodsReceipt::find($request->goods_receipt_id)->goodsReceiptDetails()->count()],
            'goods_receipt_details.*.id' => 
            [
                'required',
                'distinct',
                Rule::exists('goods_receipt_details')->where(function ($query) use ($request) {
                    $query->where('goods_receipt_id', $request->goods_receipt_id);
                }),
            ],
            'goods_receipt_details.*.quantity' => ['required','integer','min:0'],
            'goods_receipt_details.*.unit_price' => ['required','integer','min:0']
        ])->validate();

        $goods_receipt = GoodsReceipt::find($request->goods_receipt_id);

        $total_amount = 0;
        foreach ($request->goods_receipt_details as $value) {
            $total_amount += $value['quantity'] * $value['unit_price'];

            $detail = $goods_receipt->goodsReceiptDetails()->find($value['id']);

            $detail->update([
                'quantity' => $value['quantity'],
                'unit_price' => $value['unit_price'],
            ]);

            $product = Product::find($detail->product_id)->addStock($detail->quantity);

            TrackingGoods::create([
                'goods_receipt_detail_id' => $detail->id,
            ]);
        }

        
        $goods_receipt->update([
            'total_amount' => $total_amount,
            'receipt_date' => \Carbon\Carbon::now(),
        ]);

        

        return $total_amount;
    }

    public function goodsIssue(Request $request)
    {

    }
}
