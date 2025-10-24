<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cartList(Request $request)
    {
        try {
            $cartItems = \Cart::getContent();

            $session = Session::get('customerid');

            $subtotal = \Cart::getSubTotal();
            $discount = session()->get('discount', 0);
            $total = $subtotal - $discount;

            $ip = $request->ip();
            $countryCode = getCountryCode($ip);

            return view('frontview.cart', compact('cartItems',  'subtotal', 'discount', 'total', 'countryCode'));
        } catch (\Throwable $th) {
            Log::error('Cart List Error: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return back()->with('error', 'Failed to load cart.');
        }
    }


    public function addToCart(Request $request)
    {
        try {
            \Cart::add([
                'id' => $request->attribute_id,
                // 'id' => $request->productid,
                'productid' => $request->productid,
                'categoryId' => $request->categoryId,
                'attribute_text' => $request->attribute_text,
                'name' => $request->productname,
                'price' => $request->price,
                'symbol' => $request->symbol,
                'quantity' => $request->quantity,
                'attributes' => array(
                    'image' => $request->image,
                )
            ]);

            return back()->with('success', 'Product is Added to Cart Successfully !');
        } catch (\Throwable $th) {
            Log::error('Add to Cart Error: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to add product to cart.');
        }
    }



    public function removeCart(Request $request)
    {
        try {
            \Cart::remove($request->id);
            session()->flash('success', 'Cart Item Remove Successfully !');
            return back();
        } catch (\Throwable $th) {
            Log::error('Remove Cart Item Error: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to remove item from cart.');
        }
    }

    public function clearAllCart()
    {
        try {
            \Cart::clear();
            session()->flash('success', 'All Item Cart Clear Successfully !');
            return back();
        } catch (\Throwable $th) {
            Log::error('Clear Cart Error: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to clear cart.');
        }
    }


    public function updateCart(Request $request)
    {
        try {
            \Cart::update(
                $request->id,
                [
                    'quantity' => [
                        'relative' => false,
                        'value' => $request->quantity
                    ],
                ]
            );

            $subtotal = \Cart::getSubTotal();
            $total = $subtotal;

            return response()->json([
                'success' => true,
                'cart_summary' => [
                    'subtotal' => $subtotal,
                    'total' => $total
                ]
            ]);
        } catch (\Throwable $th) {
            Log::error('Update Cart Error: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart item.'
            ], 500);
        }
    }
}
