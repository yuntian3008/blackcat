<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Order;
use App\Customer;
use Illuminate\Database\Eloquent\Builder;

class StatisticsController extends Controller
{
    protected function timeRange(Request $request) {
        Validator::make($request->all(), [
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ])->validate();

        $start = Carbon::parse($request->start_date)->setTimezone(config('app.timezone'));
        $end = Carbon::parse($request->end_date)->setTimezone(config('app.timezone'));;

        $diff = $start->diffInSeconds($end);
        $time['pre'] = new Carbon($start);
        $time['pre']->subSeconds($diff);
        
        return [
            'start' => $start->toDateTimeString(),
            'end' => $end->toDateTimeString(),
            'pre' => $time['pre']->toDateTimeString(),
        ];
    }


    public function sales(Request $request)
    {
        $time = $this->timeRange($request);

        $orders = Order::where('completion_date','>=',$time['start'])->where('completion_date','<=',$time['end'])
            // ->whereTime('completion_date','>=',$time['start']->toTimeString())
            // ->whereDate('completion_date','<=',$time['end']->toDateString())
            // ->whereTime('completion_date','<=',$time['end']->toTimeString())            
            ->get();
        $sales = $orders->sum('total_amount');
        $total_quantity = $orders->sum('total_quantity');

       

        $pre_orders = Order::where('completion_date','>=',$time['pre'])->where('completion_date','<',$time['start'])
            //->whereTime('completion_date','>=',$time['pre']->toTimeString())                      
            //->whereDate('completion_date','<=',$time['start']->toDateString())
            //->whereTime('completion_date','<',$time['start'])
            ->get();
        $pre_sales = $pre_orders->sum('total_amount');
        $pre_total_quantity = $pre_orders->sum('total_quantity');
        

        $growth_rate_sales = $pre_sales == 0 ? 100 :($sales - $pre_sales) / $pre_sales * 100;
        $growth_rate_quantity = $pre_total_quantity == 0 ? 100 : ($total_quantity - $pre_total_quantity) / $pre_total_quantity * 100;
        return [
            'start' => $time['start'],
            'end' => $time['end'],
            'previous' => $time['pre'],
            //'orders' => $orders,
            //'pre_orders' => $pre_orders,
            'sales' => $sales,
            'growth_rate_sales' => $growth_rate_sales,
            'quantity' => $total_quantity,
            'growth_rate_quantity' => $growth_rate_quantity,
        ];
    }

    public function customer(Request $request)
    {
        $time = $this->timeRange($request);

        $customer = Customer::where('created_at','>=',$time['start'])->where('created_at','<=',$time['end'])
            // ->whereTime('completion_date','>=',$time['start']->toTimeString())
            // ->whereDate('completion_date','<=',$time['end']->toDateString())
            // ->whereTime('completion_date','<=',$time['end']->toTimeString())            
            ->get();
        $new = $customer->count();

        $hasOrderCustomer = Customer::whereHas('orders', function(Builder $query) use ($time) {
            $query->where('created_at','>=',$time['start'])->where('created_at','<=',$time['end']);
        })->get();
        $order_count = $hasOrderCustomer->count();


        $pre_customer = Customer::where('created_at','>=',$time['pre'])->where('created_at','<',$time['start'])
            //->whereTime('completion_date','>=',$time['pre']->toTimeString())                      
            //->whereDate('completion_date','<=',$time['start']->toDateString())
            //->whereTime('completion_date','<',$time['start'])
            ->get();
        $pre_new = $pre_customer->count();

        $pre_hasOrderCustomer = Customer::whereHas('orders', function(Builder $query) use ($time) {
            $query->where('created_at','>=',$time['pre'])->where('created_at','<',$time['start']);
        })->get();
        $pre_order_count = $pre_hasOrderCustomer->count();
        

        $growth_rate_new = $pre_new == 0 ? 100 :($new - $pre_new) / $pre_new * 100;
        $growth_rate_order_count = $pre_order_count == 0 ? 100 : ($order_count - $pre_order_count) / $pre_order_count * 100;
        return [
            'start' => $time['start'],
            'end' => $time['end'],
            'previous' => $time['pre'],
            //'orders' => $orders,
            //'pre_orders' => $pre_orders,
            'new_customers' => $new,
            'growth_rate_new' => $growth_rate_new,
            'orders_count' => $order_count,
            'growth_rate_order_count' => $growth_rate_order_count,
        ];
    }
}
