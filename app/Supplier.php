<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'company_name', 'phone', 'email', 'address',    ];  

    public function goodsReceipts()
    {
        return $this->hasMany('App\GoodsReceipt');
    }
}
