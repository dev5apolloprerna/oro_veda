<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $table = "orderdetail";
    protected $fillable = [
        'orderDetailId',
        'orderID',
        'customerid',
        'productId',
        'categoryId',
        'size',
        'quantity',
        'rate',
        'amount',
        'currency',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at',
        'strIP'
    ];
}
