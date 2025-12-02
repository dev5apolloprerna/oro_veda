<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;

class OrderController extends Controller
{
    public function pending(Request $request)
    {

        if (Auth::user()->id == 1) {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $Status = $request->strStatus;

            $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

            $Pend = Order::select(
                'order.*',
                'countries.countryName'
            )
                ->orderBy('order_id', 'desc')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isDispatched' => 0, 'order.dispatchCourierId' => 0, 'order.isPayment' => 1])
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->leftJoin('countries', 'order.country', '=', 'countries.id');

            if ($request->strStatus != "") {
                $Pend->where('order.isPayment', '=', $request->strStatus);
            }

            $Pending = $Pend->paginate(15);

            return view('admin.order.pending', compact('Pending', 'FromDate', 'ToDate', 'Courier', 'Status'));
        }
    }

    public function dispatched(Request $request)
    {
        if (Auth::user()->id  == 1) {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;

            $Dispatched = Order::select(
                'order.order_id',
                'order.created_at',
                'order.shipping_cutomerName',
                'order.shipping_email',
                'order.shipping_mobile',
                'order.shipping_city',
                'order.shipping_pincode',
                'order.shiiping_state',
                'order.netAmount',
                'order.isPayment',
                'courier.name',
                'courier.url',
                'countries.countryName',
                'order.docketNo',
                'order.isDispatched',
                'order.currency',

            )
                ->orderBy('order_id', 'desc')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isDispatched' => 1])
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->join('courier', 'order.courier', '=', 'courier.id')
                ->leftJoin('countries', 'order.country', '=', 'countries.id')
                ->paginate(15);
            //dd($Dispatched);

            return view('admin.order.dispatched', compact('Dispatched', 'FromDate', 'ToDate'));
        }
    }

    public function cancel(Request $request)
    {
        if (Auth::user()->id  == 1) {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;

            $Cancel = Order::select(
                'order.*',
                'countries.countryName'
            )
                ->orderBy('order_id', 'desc')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isDispatched' => 2])
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->leftJoin('countries', 'order.country', '=', 'countries.id')
                ->paginate(15);

            return view('admin.order.cancel', compact('Cancel', 'FromDate', 'ToDate'));
        }
    }

    public function statustocancel(Request $request, $id)
    {
        try {
            $status = DB::table('order')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
                ->update([
                    'isDispatched' => 2,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            return redirect()->route('order.cancel')->with('success', 'Status Updated Successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function statustodispatched(Request $request)
    {
        // dd($request);
        $request->validate([
            'courier' => 'required|integer',
            'docketNo' => 'required|string|max:255',
            'order_id' => 'required|exists:order,order_id'
        ]);

        $session = Auth::user()->id;

        try {

            $CheckCourier = Order::where([
                'iStatus' => 1,
                'isDelete' => 0,
                'courier' => $request->courier,
                'docketNo' => $request->docketNo
            ])->exists();

            if (!$CheckCourier) {

                Order::where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])
                    ->update([
                        'courier' => $request->courier,
                        'docketNo' => $request->docketNo,
                        'isDispatched' => 1,
                        'isDispatchedBy' => $session,
                        'updated_at' => now()
                    ]);

                $Order = Order::where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])->first();
                $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->courier])->first();

                if (!$Order || !$Courier) {
                    return back()->with('error', 'Order or courier not found.');
                }

                $urlToClient = $Courier->url;

                $SendEmailDetails = DB::table('sendemaildetails')->where(['id' => 10])->first();

                if ($SendEmailDetails && !empty($Order->shipping_email)) {
                    $emailData = [
                        'orderNo' => $request->order_id,
                        'shippingmobile' => $Order->shipping_mobile,
                        'courierName' => $Courier->name,
                        'docketNo' => $request->docketNo,
                        'link' => $urlToClient
                    ];

                    $emailConfig = [
                        'FromMail' => $SendEmailDetails->strFromMail,
                        'Title' => $SendEmailDetails->strTitle,
                        'ToEmail' => $Order->shipping_email,
                        'Subject' => $SendEmailDetails->strSubject
                    ];

                    // Send email
                    Mail::send('emails.dispatchemail', ['data' => $emailData], function ($message) use ($emailConfig) {
                        $message->from($emailConfig['FromMail'], $emailConfig['Title']);
                        $message->to($emailConfig['ToEmail'])->subject($emailConfig['Subject']);
                    });
                }

                // $Customer = Customer::where(["customerid" => $Order->customerid])->first();
                // $Setting = Setting::where(["id" => 1])->first();

                // if ($Customer && $Setting && $Order->shipping_mobile) {
                //     $MobileNumber = $Order->shipping_mobile;
                //     $key = $Setting->api_key;

                //     $whatsappmsg = "*Dear Customer*,\n\nClick on the below link to track your order:\n$urlToClient\n\nRegards,\nTeam The Wardrobe Fashion.";

                //     $customer = new Customer();

                //     // Optional: Call your WhatsApp API method here
                //     // If implemented in Customer model
                //     // $status = $customer->WhatsappMessage($MobileNumber, $whatsappmsg);
                // }

                return redirect()->route('order.dispatched')->with('success', 'Status updated and customer notified successfully.');
            } else {
                return back()->with('error', 'Docket number already exists for selected courier.');
            }
        } catch (\Throwable $th) {
            Log::error("statustodispatched failed", [
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);
            return redirect()->back()->with('error', 'An error occurred while updating the status.');
        }
    }


    public function statustopending(Request $request, $id)
    {
        try {
            $status = DB::table('order')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
                ->update([
                    'isDispatched' => 0,
                    'dispatchCourierId' => 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            return redirect()->route('order.pending')->with('success', 'Status Updated Successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function orderdetail(Request $request, $id)
    {

        $Shipping = Shipping::select('rate as shippingcharge')->orderBy('id', 'desc')->first();
        $data = Order::select(
            'order.*',
            'countries.countryName'
        )
            ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.order_id' => $id])
            ->leftJoin('countries', 'order.country', '=', 'countries.id')
            ->first();
        // dd($data);
        $detail = OrderDetail::select(
            'order.shipping_cutomerName',
            'order.shipping_mobile',
            'order.shipping_email',
            'order.shiiping_address1',
            'order.shiiping_address2',
            'order.shiiping_state',
            'order.shipping_city',
            'order.shipping_pincode',
            'order.currency',
            'order.amount as totalamount',
            'orderdetail.quantity',
            'orderdetail.rate',
            'orderdetail.amount',
            'orderdetail.size',
            'products.productname',
            'products.productname',
            'product_attributes.product_attribute_qty',
            'attributes.name',

            DB::raw('(SELECT product_attribute_size FROM product_attributes WHERE product_attributes.id=orderdetail.size) as product_attribute_size'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id  LIMIT 1) as photo'),
        )
            ->orderBy('orderDetailId', 'DESC')
            ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $data->order_id])
            ->leftJoin('order', 'orderdetail.orderID', '=', 'order.order_id')
            ->leftJoin('products', 'orderdetail.productId', '=', 'products.id')
            ->leftJoin('product_attributes', 'orderdetail.size', '=', 'product_attributes.id')
            ->leftJoin('attributes', 'product_attributes.product_attribute_id', '=', 'attributes.id')
            ->get();
        // dd($detail);

        return  view('admin.order.productdetail', compact('data', 'detail', 'id', 'Shipping'));
    }

    public function DetailPDF(Request $request, $id)
    {
        if (Auth::user()->id  == 1) {

            $Shipping = Shipping::select('rate as shippingcharge')->orderBy('id', 'desc')->first();

            $data = Order::select(
                'order.*',
                'courier.id',
                'courier.name as couriername',
                'countries.countryName'
            )
                ->orderBy('order_id', 'DESC')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.order_id' => $id])
                ->leftJoin('countries', 'order.country', '=', 'countries.id')
                ->leftjoin('courier', 'order.courier', '=', 'courier.id')
                ->first();

            $detail = OrderDetail::select(
                'order.order_id',
                'order.shipping_cutomerName',
                'order.shipping_mobile',
                'order.shipping_email',
                'order.shiiping_address1',
                'order.shiiping_address2',
                'order.shiiping_state',
                'order.shipping_city',
                'order.shipping_pincode',
                'order.docketNo',
                'order.discount',
                'order.netAmount',
                'order.currency',
                'order.amount as totalamount',
                'orderdetail.orderID',
                'orderdetail.quantity',
                'orderdetail.rate',
                'orderdetail.amount',
                'orderdetail.size',
                'products.productname',
                'courier.id',
                'courier.name as couriername',
                'product_attributes.product_attribute_qty',
                'attributes.name',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id LIMIT 1) as photo'),
                DB::raw('(SELECT product_attribute_size FROM product_attributes WHERE product_attributes.id=orderdetail.size) as product_attribute_size')
            )
                ->orderBy('orderDetailId', 'DESC')
                ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $data->order_id])
                ->leftJoin('order', 'orderdetail.orderID', '=', 'order.order_id')
                ->leftJoin('products', 'orderdetail.productId', '=', 'products.id')
                ->leftjoin('courier', 'order.courier', '=', 'courier.id')
                ->leftJoin('product_attributes', 'orderdetail.size', '=', 'product_attributes.id')
                ->leftJoin('attributes', 'product_attributes.product_attribute_id', '=', 'attributes.id')
                ->get();

            $pdf = PDF::loadView('admin.order.invoice', ['data' => $data, 'detail' => $detail, 'Shipping' => $Shipping]);

            return $pdf->stream('Report.pdf');

            Route::get(
                "/admin/order/pdf/ .'$id'.",
                function () {
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML('<h1>Test</h1>');
                    return $pdf->download('invoice.pdf');
                }
            );
        }
    }

    public function DispatchPDF(Request $request, $id)
    {
        if (Auth::user()->id  == 1) {

            $data = Order::select(
                'order.*',
                'countries.countryName'
            )
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.order_id' => $id])
                ->leftJoin('countries', 'order.country', '=', 'countries.id')
                ->first();
            // dd($data);

            $pdf = PDF::loadView('admin.order.DispatchPDF', ['data' => $data]);
            return $pdf->stream('Dispatch.pdf');

            Route::get(
                "/admin/dispatch/pdf/ .'$id'.",
                function () {
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML('<h1>Test</h1>');
                    return $pdf->download('Dispatch.pdf');
                }
            );
        }
    }

    public function pendingOrder(Request $request)
    {
        // dd($request);

        if (Auth::user()->id  == 1) {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $Mobile = $request->mobile;
            $Name = $request->strName;

            $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

            $Pend = Order::orderBy('order_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'isDispatched' => 0, 'dispatchCourierId' => 0, 'order.isPayment' => 0])
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->when($request->mobile, fn($query, $Mobile) => $query
                    ->where('order.shipping_mobile', 'like', '%' . $Mobile . '%'))
                ->when($request->strName, fn($query, $Name) => $query
                    ->where('order.shipping_cutomerName', 'like', '%' . $Name . '%'))
                ->join('state', 'order.shiiping_state', '=', 'state.stateId');

            $Pending = $Pend->paginate(15);


            return view('admin.order.paymentPendingOrder', compact('Pending', 'FromDate', 'ToDate', 'Courier', 'Name', 'Mobile'));
        }
    }

    public function linkSendToCustomer(Request $request, $id)
    {
        //  dd($request);

        try {
            $Order = Order::where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])->first();
            $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $Order->courier])->first();

            $Customer = Customer::where(["customerid" => $Order->customerid])->first();
            $InsertedId =  $Customer->customerid;
            $ORDER_ID = $Order->order_id;
            $MobileNumber = $Order->shipping_mobile;
            $Setting = Setting::where(["id" => 1])->first();
            $key = $Setting->api_key;
            $urlToClient = $Courier->url . $Order->docketNo;
            // dd($urlToClient);
            $whatsappmsg = "*Dear Customer*,

        Click on the below link to track your order:
        $urlToClient

        Regards,
        Team The Wardrobe Fashion.";

            $message = "Dear Customer, Click on the link below to track your order: $urlToClient Regards , Team The Wardrobe Fashion";
            $docketNo = $Order->docketNo;

            $customer = new Customer();
            // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

            if ($Order->docketNo == 1) {
                $status = $customer->tirupatiMsg($MobileNumber, $docketNo);
            } else {
                $status = $customer->delhiveryMsg($MobileNumber, $docketNo);
            }
            $mobile = $MobileNumber;
            //Whatsapp
            $whatsapp = $customer->WhatsappMessage($mobile, $whatsappmsg);

            return redirect()->route('order.dispatched')->with('success', 'Link Send Successfully.');
        } catch (\Throwable $th) {
            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function dispatchThroughPaymentPendingOrder(Request $request)
    {
        // dd($request);
        try {
            $CheckCourier = Order::where(['iStatus' => 1, 'isDelete' => 0, 'courier' => $request->courier, 'docketNo' => $request->docketNo])->first();
            // dd($CheckCourier);
            if (!($CheckCourier) && $CheckCourier == null) {
                // dd('if');
                $status = DB::table('order')
                    ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])
                    ->update([
                        'courier' => $request->courier,
                        'docketNo' => $request->docketNo,
                        'isDispatched' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $updateData = array(
                    'isPayment' => 1
                );
                Order::where("order_id", $request->order_id)->update($updateData);

                $cart_Items = OrderDetail::where("orderID", $request->order_id)->get();

                $iCounter = 0;
                foreach ($cart_Items as $cartItem) {

                    $opening = Ledger::select('openingBalance', 'closingBalance', 'cr', 'dr', 'iProductId', 'iOrderId')
                        ->orderBy('ledger.ledgerId', 'DESC')
                        ->where([
                            'ledger.iStatus' => 1,
                            'ledger.isDelete' => 0,
                            'iProductId' => $cartItem->productId,
                            'iSize' => $cartItem->size
                        ])
                        ->first();


                    $dr = $cartItem->quantity;
                    $openingBalance = $opening->closingBalance ?? 0;
                    $closing = ($openingBalance - $dr);

                    $Ledger = array(
                        'iProductId' => $cartItem->productId,
                        'iSize' => $cartItem->size,
                        'iInwardId' =>  0,
                        'iOrderId' => $request->order_id,
                        'iOrderDetailId' =>  $cartItem->orderDetailId,
                        'openingBalance' => $openingBalance,
                        'cr' => 0,
                        'dr' =>  $dr,
                        'closingBalance' =>  $closing,
                        'created_at' => date('Y-m-d H:i:s'),
                        'strIP' => $request->ip()
                    );
                    // dd($Ledger);
                    DB::table('ledger')->insert($Ledger);

                    if ($closing < 0) {
                        OrderDetail::where("orderDetailId", '=', $cartItem->orderDetailId)->update(['isRefund' => 1]);
                        $iCounter++;
                    }
                }
                if ($iCounter > 0) {
                    $orderNote = $iCounter . " Product need to Refund.";
                    Order::where("order_id", $request->order_id)->update(["orderNote" => $orderNote]);
                }


                $Order = Order::where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])->first();
                $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->courier])->first();

                $SendEmailDetails = DB::table('sendemaildetails')
                    ->where(['id' => 10])
                    ->first();

                $urlToClient = "";
                $urlToClient = $Courier->url . $request->docketNo;
                $root = $_SERVER['DOCUMENT_ROOT'];
                $file = file_get_contents($root . '/mailers/dispatchemail.html', 'r');
                $file = str_replace('#orderNo', $request->order_id, $file);
                $file = str_replace('#courierName', $Courier->name, $file);
                $file = str_replace('#docketNo', $request->docketNo, $file);
                $file = str_replace('#link', $urlToClient, $file);

                $toMail = $Order->shipping_email;

                $to = $toMail;
                $subject = $SendEmailDetails->strSubject;
                $message = $file;
                $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= "Content-type: text/html\r\n";

                $retval = mail($to, $subject, $message, $header);

                $Customer = Customer::where(["customerid" => $Order->customerid])->first();
                $InsertedId =  $Customer->customerid;
                $ORDER_ID = $Order->order_id;
                $MobileNumber = $Order->shipping_mobile;
                $Setting = Setting::where(["id" => 1])->first();
                $key = $Setting->api_key;
                //         $msg = "*Dear Customer*,

                // Click on the below link to track your order:
                // $urlToClient

                // Regards,
                // Team Wardrobefashion.";

                $message = "Dear Customer, Click on the link below to track your order: $urlToClient Regards , Team The Wardrobe Fashion";

                $customer = new Customer();
                // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

                $docketNo = $request->docketNo;

                if ($request->courier == 1) {
                    $status = $customer->tirupatiMsg($MobileNumber, $docketNo);
                } else {
                    $status = $customer->delhiveryMsg($MobileNumber, $docketNo);
                }

                return redirect()->route('order.dispatched')->with('success', 'Status Updated Successfully.');
            } else {
                // dd('else');
                return back()->with('error', 'Docket No Already Exists.');
            }
        } catch (\Throwable $th) {
            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
