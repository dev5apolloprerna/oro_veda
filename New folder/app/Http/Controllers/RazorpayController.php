<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Razorpay\Api\Api;
use Redirect, Response;
use App\Models\Order;
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
    public function payment_success(Request $request, $id)
    {
        try {
            $Order = Order::where("order_id", $id)->firstOrFail();

            Order::where("order_id", $id)->update([
                'isPayment' => 1
            ]);

            $StateName = State::where("stateId", $Order->shiiping_state)->first();
            $SendEmailDetails = DB::table('sendemaildetails')->where('id', 9)->first();
            $root = $_SERVER['DOCUMENT_ROOT'];
            $filePath = $root . '/mailers/checkoutmail.html';

            if (!file_exists($filePath)) {
                Log::error("Email template not found: $filePath");
                abort(500, "Email template not found.");
            }

            $file = file_get_contents($filePath);
            $address = $Order->shiiping_address1 . ',' . $Order->shiiping_address2;

            $replacements = [
                '#name' => $Order->shipping_cutomerName,
                '#email' => $Order->shipping_email,
                '#mobile' => $Order->shipping_mobile,
                '#mobile1' => $Order->shipping_mobile1,
                '#address' => $address,
                '#state' => $StateName->stateName ?? 'N/A',
                '#city' => $Order->shipping_city,
                '#pincode' => $Order->shipping_pincode,
                '#amount' => $Order->amount,
                '#netAmount' => $Order->netAmount
            ];

            foreach ($replacements as $key => $value) {
                $file = str_replace($key, $value, $file);
            }

            $OrderDetail = OrderDetail::select(
                'orderdetail.orderDetailId',
                'orderdetail.orderID',
                'orderdetail.productId',
                'orderdetail.created_at',
                'orderdetail.quantity',
                'orderdetail.rate',
                'orderdetail.amount',
                'orderdetail.size',
                'products.productname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id LIMIT 1) as photo'),
                'product_attributes.product_attribute_qty',
                'attributes.name',
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

            $html = '';
            $i = 1;

            foreach ($OrderDetail as $cartItem) {

                $Total = $cartItem['quantity'] * $cartItem['rate'];

                $html .= '<tr>
                    <td style="text-align: center">
                        ' . $i++ . '
                    </td>
                    <td style="text-align: center">
                        ' . $cartItem['productname'] . '
                    </td>
                    <td style="text-align: center">
                        <img width="48" height="48" src="https://www.sparshcosmo-group.com/uploads/product/thumbnail/' . $cartItem->photo . '">
                    </td>
                    <td style="text-align: center">
                        ' . $cartItem['product_attribute_qty'] . " (" . $cartItem->name . ")" . '
                    </td>
                    <td style="text-align: center">
                        ' . $cartItem['quantity'] . '
                    </td>
                    <td style="text-align: center">
                        ' . $cartItem['rate'] . '
                    </td>
                    <td style="text-align: center">
                        ' . $Total . '
                    </td>
                </tr>';
            }

            $file = str_replace('#tableProductTr', $html, $file);
            $setting = DB::table("setting")->select('email')->first();

            // Send mail to admin
            if (!empty($setting->email)) {
                $adminMailData = [
                    'FromMail' => $SendEmailDetails->strFromMail,
                    'Title' => $SendEmailDetails->strTitle,
                    'ToEmail' => $setting->email,
                    'Subject' => $SendEmailDetails->strSubject . "#$id"
                    // 'Subject' => "Order Detail From The Wardrobe Fashion Order No #$id"
                ];

                Mail::send('emails.checkoutmail', [
                    'Order' => $Order,
                    'OrderDetail' => $OrderDetail,
                    'htmlRows' => $html, // optional if rendering rows in controller
                    'StateName' => $StateName,
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
                    // 'Subject' => "Order Detail From The Wardrobe Fashion Order No #$id"
                ];

                Mail::send('emails.checkoutmail', [
                    'Order' => $Order,
                    'OrderDetail' => $OrderDetail,
                    'htmlRows' => $html, // optional if rendering rows in controller
                    'StateName' => $StateName,
                ], function ($message) use ($customerMailData) {
                    $message->from($customerMailData['FromMail'], $customerMailData['Title']);
                    $message->to($customerMailData['ToEmail'])->subject($customerMailData['Subject']);
                });
            }

            return redirect()->route('razorpay.thank_you');
        } catch (\Throwable $e) {
            Log::error("RazorpayController@payment_success failed for Order ID: $id", [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()->route('checkout')->with('error', 'Something went wrong while processing your order.');
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
