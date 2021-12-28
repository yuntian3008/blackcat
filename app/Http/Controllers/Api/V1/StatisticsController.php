<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Order;
class StatisticsController extends Controller
{
    public function sales(Request $request)
    {
        // date default 0:00  
        Validator::make($request->all(), [
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ])->validate();

        //$start = new Carbon($request->start_date,config('app.timezone'));
        $start = Carbon::parse($request->start_date)->setTimezone(config('app.timezone'));
        $end = Carbon::parse($request->end_date)->setTimezone(config('app.timezone'));;

        $orders = Order::where('completion_date','>=',$start->toDateTimeString())->where('completion_date','<=',$end->toDateTimeString())
            // ->whereTime('completion_date','>=',$start->toTimeString())
            // ->whereDate('completion_date','<=',$end->toDateString())
            // ->whereTime('completion_date','<=',$end->toTimeString())            
            ->get();
        $sales = $orders->sum('total_amount');
        $total_quantity = $orders->sum('total_quantity');

        $diff = $start->diffInSeconds($end);
        $previous = new Carbon($start);
        $previous->subSeconds($diff);

        $pre_orders = Order::where('completion_date','>=',$previous->toDateTimeString())->where('completion_date','<',$start->toDateTimeString())
            //->whereTime('completion_date','>=',$previous->toTimeString())                      
            //->whereDate('completion_date','<=',$start->toDateString())
            //->whereTime('completion_date','<',$start->toDateTimeString())
            ->get();
        $pre_sales = $pre_orders->sum('total_amount');
        $pre_total_quantity = $pre_orders->sum('total_quantity');
        

        $growth_rate_sales = $pre_sales == 0 ? 100 :($sales - $pre_sales) / $pre_sales * 100;
        $growth_rate_quantity = $pre_total_quantity == 0 ? 100 : ($total_quantity - $pre_total_quantity) / $pre_total_quantity * 100;
        return [
            'start' => $start->toDateTimeString(),
            'end' => $end->toDateTimeString(),
            'previous' => $previous->toDateTimeString(),
            //'orders' => $orders,
            //'pre_orders' => $pre_orders,
            'sales' => $sales,
            'growth_rate_sales' => $growth_rate_sales,
            'quantity' => $total_quantity,
            'growth_rate_quantity' => $growth_rate_quantity,
        ];
    }
}
