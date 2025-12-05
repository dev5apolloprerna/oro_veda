<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $table = "order";
    protected $fillable = [
        'order_id',
        'customerid',
        'shipping_cutomerName',
        'shipping_companyName',
        'shipping_mobile',
        'shipping_mobile1',
        'shipping_email',
        'shiiping_address1',
        'shiiping_address2',
        'shiiping_state',
        'shipping_city',
        'shipping_pincode',
        'country',
        'amount',
        'currency',
        'discount',
        'shipping_Charges',
        'netAmount',
        'isPayment',
        'orderNote',
        'courier',
        'docketNo',
        'iStatus',
        'isDelete',
        'strIP',
        'created_at',
        'updated_at',
        'isDispatched',
        'isDispatchedBy',
        'dispatchCourierId',
        'shiprocket_order_id',
        'shiprocket_shipment_id',
        'shiprocket_status',
        'shiprocket_status_code',
        'shiprocket_response',
    ];
}
