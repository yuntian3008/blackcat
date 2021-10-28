<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Order;

class OrderNotProcessedYet implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Order::find($value)->whereNotNull("request_date")->whereNull("get_date")->whereNull("ship_date")->whereNull("completion_date")->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Order #:attribute has been processed';
    }
}
