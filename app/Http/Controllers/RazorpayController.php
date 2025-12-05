<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Payment;
use Razorpay\Api\Api;
use Redirect, Response;
use App\Models\Order;
use App\Services\ShiprocketService;

use Illuminate\Support\Facades\Mail;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\State;
use App\Models\Ledger;
use App\Models\Customer;
use App\Models\ProductAttributes;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{
    public function index($id)
    {
        DB::beginTransaction();

        try {
            $Order = Order::where("order_id", $id)
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->first();

            if (!$Order) {
                return redirect()->back()->with('error', 'Order not found or already deleted.');
            }

            $price = $Order->netAmount;

            $api = new Api(config('app.razorpay_key'), config('app.razorpay_secret'));
            $OrderAmount = $price * 100;

            $orderData = [
                'receipt'  => $id . '-' . date('dmYHis'),
                'amount'   => $OrderAmount,
                'currency' => 'INR',
            ];

            $razorpayOrder = $api->order->create($orderData);
            $orderId = $razorpayOrder['id'];

            $data = array(
                'order_id' => $orderId,
                'oid' => $id,
                'amount' => $price,
                'currency' => 'INR',
                'receipt' => $razorpayOrder['receipt'],
            );
            Payment::insert($data);

            DB::commit();

            return view('razorpay', compact('Order', 'orderId'));
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Razorpay Payment Page Error', [
                'message' => $th->getMessage(),
                'line'    => $th->getLine(),
                'file'    => $th->getFile(),
                'order_id' => $id,
            ]);

            return redirect()->back()->with('error', 'Something went wrong while initiating payment.');
        }
    }

    //
    public function razorPaySuccess(Request $request)
    {
        try {
            $orderId = $request->orderId;

            Payment::where('oid', $orderId)->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'razorpay_order_id' => $request->razorpay_order_id,
            ]);

            $stringdata = $request->razorpay_order_id . '|' . $request->razorpay_payment_id;
            $generated_signature = hash_hmac('sha256', $stringdata, config('app.razorpay_secret'));

            if ($generated_signature === $request->razorpay_signature) {

                Log::info('Payment verified for order: ' . $orderId);

                Payment::where('oid', $orderId)->update([
                    'status' => 'Success',
                    'iPaymentType' => 1,
                    'Remarks' => 'Online Payment',
                ]);

                Order::where('order_id', $orderId)->update(['isPayment' => 1]);

                $cart_Items = OrderDetail::where('orderID', $orderId)->get();

                foreach ($cart_Items as $cartItem) {

                    $opening = Ledger::where([
                        'ledger.iStatus' => 1,
                        'ledger.isDelete' => 0,
                        'iProductId' => $cartItem->productId,
                        'iSize' => $cartItem->size
                    ])
                        ->orderBy('ledger.ledgerId', 'DESC')
                        ->first();

                    $dr = $cartItem->quantity;
                    $openingBalance = $opening->closingBalance ?? 0;
                    $closing = ($openingBalance - $dr);

                    $Ledger = array(
                        'iSize' => $cartItem->size,
                        'iInwardId' =>  0,
                        'iOrderId' => $orderId,
                        'iOrderDetailId' => $cartItem->orderDetailId,
                        'openingBalance' => $openingBalance,
                        'cr' => 0,
                        'dr' =>  $dr,
                        'closingBalance' =>  $closing,
                        'created_at' => now(),
                        'strIP' => $request->ip()
                    );
                    DB::table('ledger')->insert($Ledger);
                }

                // ✅ Clear cart and session data
                Session::forget(['discount', 'applied_coupon_code']);
                \Cart::clear();

                return response()->json(['id' => $orderId]);
            } else {

                Payment::where('oid', $orderId)->update(['status' => 'Fail']);
                \Cart::clear();

                Log::warning('Signature mismatch on payment verification', ['order_id' => $orderId]);

                return response()->json(['id' => 0]);
            }
        } catch (\Throwable $e) {
            Log::error('RazorpayController@razorPaySuccess failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->all(),
            ]);

            \Cart::clear();
            return response()->json(['id' => 0]);
        }
    }

    //after payment success function
    public function payment_success(Request $request, $id, ShiprocketService $shiprocket)
    {
    try {

        $Order = Order::where("order_id", $id)->firstOrFail();
        $Order->update(['isPayment' => 1]);

        $CountryName = Country::where("id", $Order->country)->first();

        $OrderDetail = OrderDetail::select(
            'orderdetail.orderDetailId',
            'orderdetail.orderID',
            'orderdetail.productId',
            'orderdetail.created_at',
            'orderdetail.quantity',
            'orderdetail.rate',
            'orderdetail.amount',
            'orderdetail.size',
            'orderdetail.currency',
            'products.productname',
            'products.height',
            'products.length',
            'products.breadth',
            'products.weight',
            DB::raw('(SELECT strphoto FROM productphotos WHERE productphotos.productid=products.id LIMIT 1) as photo'),
            'product_attributes.product_attribute_qty',
            'attributes.name'
        )
        ->where([
            'orderdetail.iStatus' => 1,
            'orderdetail.isDelete' => 0,
            'orderdetail.orderID' => $id
        ])
        ->leftJoin('products', 'orderdetail.productId', '=', 'products.id')
        ->leftJoin('product_attributes', 'orderdetail.size', '=', 'product_attributes.id')
        ->leftJoin('attributes', 'product_attributes.product_attribute_id', '=', 'attributes.id')
        ->get();
         $SendEmailDetails = DB::table('sendemaildetails')->where('id', 9)->first();

         $setting = DB::table("setting")->select('email')->first();
          // Send mail to admin
            if (!empty($setting->email)) {
                $adminMailData = [
                    'FromMail' => $SendEmailDetails->strFromMail,
                    'Title' => $SendEmailDetails->strTitle,
                    'ToEmail' => $setting->email,
                    'Subject' => $SendEmailDetails->strSubject . "#$id"
                ];


                $mail =  Mail::send('emails.checkoutmail', [
                    'Order' => $Order,
                    'OrderDetail' => $OrderDetail,
                    'CountryName' => $CountryName->countryName,
                ], function ($message) use ($adminMailData) {
                    $message->from($adminMailData['FromMail'], $adminMailData['Title']);
                    $message->to($adminMailData['ToEmail'])->subject($adminMailData['Subject']);
                });
            }
            
          // Send mail to customer
            if (!empty($Order->shipping_email)) {
                $customerMailData = [
                    'FromMail' => $SendEmailDetails->strFromMail,
                    'Title' => $SendEmailDetails->strTitle,
                    'ToEmail' => $Order->shipping_email,
                    'Subject' => $SendEmailDetails->strSubject . "#$id"
                ];
    
                Mail::send('emails.checkoutmail', [
                    'Order' => $Order,
                    'OrderDetail' => $OrderDetail,
                    'CountryName' => $CountryName->countryName,
                ], function ($message) use ($customerMailData) {
                    $message->from($customerMailData['FromMail'], $customerMailData['Title']);
                    $message->to($customerMailData['ToEmail'])->subject($customerMailData['Subject']);
                });
            }
    

        // ---------------- PHONE CLEAN FUNCTION ----------------
        $cleanPhone = function($phone) {
            $phone = preg_replace('/\D/', '', trim($phone)); // Keep only numbers

            if (strlen($phone) === 12 && substr($phone, 0, 2) === "91") {
                $phone = substr($phone, 2);
            }

            return $phone;
        };


        // ---------------- SAFE PHONE FALLBACK ----------------
        $shippingPhoneRaw = 
            $Order->shipping_mobile 
            ?: $Order->shipping_phone
            ?: $Order->billing_mobile
            ?: $Order->billing_phone
            ?: '';

        $billingPhoneRaw = 
            $Order->billing_phone
            ?: $Order->billing_mobile
            ?: $Order->shipping_mobile
            ?: $Order->shipping_phone
            ?: '';

        $shippingPhone = $cleanPhone($shippingPhoneRaw);
        $billingPhone = $cleanPhone($billingPhoneRaw);


        // ---------------- VALIDATE PHONE ----------------
        if (strlen($shippingPhone) !== 10) {
            Log::error("Invalid Shipping Phone", ['raw' => $shippingPhoneRaw, 'cleaned' => $shippingPhone]);
            throw new \Exception("Invalid shipping phone number (10 digits required)");
        }

        if (strlen($billingPhone) !== 10) {
            Log::error("Invalid Billing Phone", ['raw' => $billingPhoneRaw, 'cleaned' => $billingPhone]);
            throw new \Exception("Invalid billing phone number (10 digits required)");
        }


        // ---------------- SHIPROCKET PAYLOAD ----------------
        $shipPayload = [
            "order_id" => (string)$Order->order_id,
            "order_date" => $Order->created_at->format('Y-m-d H:i'),
            "pickup_location" => $Order->pickup_location ?? "work",

            "billing_customer_name" => $Order->shipping_cutomerName ?? '',
            "billing_last_name" => $Order->billing_last_name ?? '',
            "billing_address" => $Order->shiiping_address1 ?? '',
            "billing_address_2" => $Order->shiiping_address2 ?? '',
            "billing_city" => $Order->shipping_city ?? '',
            "billing_pincode" => (string)($Order->shipping_pincode ?? ''),
            "billing_state" => $Order->shiiping_state ?? '',
            "billing_country" => $CountryName->countryName ?? 'India',
            "billing_email" => $Order->billing_email ?? $Order->shipping_email ?? '',
            "billing_phone" => $billingPhone,

            "shipping_is_billing" => (bool)($Order->shipping_is_billing ?? true),

            "shipping_customer_name" => $Order->shipping_cutomerName ?? '',
            "shipping_last_name" => $Order->shipping_last_name ?? '',
            "shipping_address" => $Order->shiiping_address1 ?? '',
            "shipping_address_2" => $Order->shipping_address2 ?? '',
            "shipping_city" => $Order->shipping_city ?? '',
            "shipping_pincode" => (string)($Order->shipping_pincode ?? ''),
            "shipping_state" => $Order->shiiping_state ?? '',
            "shipping_country" => $Order->shipping_country ?? 'India',
            "shipping_email" => $Order->shipping_email ?? '',
            "shipping_phone" => $shippingPhone,

            "order_items" => [],
            "payment_method" => $Order->payment_method === 'COD' ? 'COD' : 'Prepaid',

            "shipping_charges" => (float)($Order->shipping_charges ?? 0),
            "giftwrap_charges" => (float)($Order->giftwrap_charges ?? 0),
            "transaction_charges" => (float)($Order->transaction_charges ?? 0),
            "total_discount" => (float)($Order->total_discount ?? 0),
            "sub_total" => (float)($Order->sub_total ?? $Order->amount ?? 0),

            "length" => 0,
            "breadth" => 0,
            "height" => 0,
            "weight" => 0,
        ];
        

        // ---------------- DIMENSIONS & ITEMS ----------------
        $totalLength = $totalBreadth = $totalHeight = $totalWeight = 0;

        foreach ($OrderDetail as $item) {

            $qty = (int)($item->quantity ?? 1);

            $totalLength += ($item->length ?? 10) * $qty;
            $totalBreadth += ($item->breadth ?? 15) * $qty;
            $totalHeight += ($item->height ?? 20) * $qty;
            $totalWeight += ($item->weight ?? 0.5) * $qty;

            $shipPayload['order_items'][] = [
                "name" => $item->productname ?? 'Item',
                "sku" => 'sku-' . ($item->productId ?? 'item'),
                "units" => $qty,
                "selling_price" => (float)($item->rate ?? 0),
                "discount" => 0,
                "tax" => 0,
                "hsn" => $item->hsn ?? ""
            ];
        }

        $shipPayload["length"] = (float)$totalLength;
        $shipPayload["breadth"] = (float)$totalBreadth;
        $shipPayload["height"] = (float)$totalHeight;
        $shipPayload["weight"] = (float)$totalWeight;
        
       // dd($shipPayload);

        // ---------------- SEND TO SHIPROCKET ----------------
        $response = $shiprocket->createAdhocOrder($shipPayload);

        if (!empty($response['order_id'])) {
            $Order->update([
                'shiprocket_order_id' => $response['order_id'],
                'shiprocket_shipment_id' => $response['shipment_id'] ?? null,
                'shiprocket_status' => $response['status'] ?? null,
                'shiprocket_status_code' => $response['status_code'] ?? null,
                'shiprocket_response' => json_encode($response)
            ])->where('order_id',$response['order_id']);
        }

        return redirect()->route('razorpay.thank_you');

    } catch (\Throwable $e) {

        Log::error("RazorpayController@payment_success failed for Order ID: $id", [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return redirect()->route('front.checkout')
            ->with('error', 'Something went wrong while processing your order.');
    }
}


    public function RazorFail()
    {
        try {
            \Cart::clear();

            return view('paymentFail');
        } catch (\Throwable $e) {
            Log::error('RazorpayController@RazorFail failed', [
                'message' => $e->getMessage(),
            ]);
            abort(500);
        }
    }

    public function thank_you(Request $request)
    {
        try {
            return view('thankyouPage');
        } catch (\Throwable $e) {
            Log::error('RazorpayController@thank_you failed', [
                'message' => $e->getMessage(),
            ]);
            abort(500);
        }
    }

    public function payment_cancel_by_user(Request $request)
    {
        try {
            $orderId = $request->orderId;

            Payment::where('oid', $orderId)->update([
                'status' => 'Fail',
                'Remarks' => 'Payment window closed',
            ]);

            return response()->json(['status' => 'fail']);
        } catch (\Throwable $e) {
            Log::error('RazorpayController@payment_cancel_by_user failed', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            \Cart::clear();
            return response()->json(['status' => 'fail']);
        }
    }
}
