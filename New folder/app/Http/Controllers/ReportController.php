<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\Courier;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function paymentReport(Request $request)
    {
        // dd($request);
        try{
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
            'order.netAmount',
            'order.isPayment',
            'courier.name',
            'state.stateName',
            'order.docketNo',
            'order.isDispatched',
            
            )
            ->orderBy('order_id', 'desc')
            ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isDispatched' => 1])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->join('courier', 'order.courier', '=', 'courier.id')
            ->join('state', 'order.shiiping_state', '=', 'state.stateId')    
            ->paginate(15);
        //dd($Dispatched);

        return view('order.paymentReport', compact('Dispatched', 'FromDate', 'ToDate'));
    } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }   
    }

    public function orderTracking(Request $request)
    {
        try{
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $Mobile = $request->mobile;
        $Name = $request->strName;

        $Dispatched = Order::orderBy('order_id', 'desc')
            ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isDispatched' => 1])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->when($request->mobile, fn ($query, $Mobile) => $query
                ->where('order.shipping_mobile', '=', $Mobile))
            ->when($request->strName, fn ($query, $Name) => $query
                ->where('order.shipping_cutomerName', 'like', '%' . $Name . '%'))        
            ->join('courier', 'order.courier', '=', 'courier.id')
            ->join('state', 'order.shiiping_state', '=', 'state.stateId')    
            ->paginate(15);
        //dd($Dispatched);

        return view('order.orderTracking', compact('Dispatched', 'FromDate', 'ToDate','Name'));
    } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }   
        
    }
    
    public function searchCustomer(Request $request)
    {
        try{
        $Name = $request->strName;
        $Mobile = $request->strMobile;
        $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
        $datas = [];
        $count = [];
        if ($request->strName != "" || $request->strMobile != "") {
            $datas = Order::orderBy('order_id', 'desc')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0])
                ->when($request->strName, fn ($query, $Name) => $query
                    ->Where('order.shipping_cutomerName', 'LIKE', '%' . $Name . '%'))
                ->when($request->strMobile, fn ($query, $Mobile) => $query
                    ->Where('order.shipping_mobile', 'LIKE', '%' . $Mobile . '%'))    
                    ->join('courier', 'order.courier', '=', 'courier.id')
                ->paginate(15);
            // dd($datas);
            $count= $datas->count();
        }    

        return view('order.searchcustomer', compact('Name', 'Mobile', 'datas','Courier','count'));
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }   
    }
}
