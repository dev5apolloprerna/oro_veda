<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerCouponApplyed;
use App\Models\Gallery;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\Productphotos;
use App\Models\Testimonial;
use App\Models\Shipping;
use App\Models\Setting;
use App\Models\State;
use App\Models\Wishlist;
use App\Models\OtherPages;
use App\Models\Banner;
use App\Models\Inquiry;
use App\Models\Ledger;
use App\Models\Payment;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class FrontController extends Controller
{
    public function index(Request $request)
    {
            $currency = session('currency', 'USD');

        try {
            $Banner = Banner::orderBy('banner.bannerId', 'desc')
                ->where(['banner.iStatus' => 1, 'banner.isDelete' => 0])
                ->get();
                
            $Video = Video::orderBy('id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->first();    

            $offers = Offer::orderBy('id', 'desc')
                ->take(1)
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->get();

            $featuredProduct = Product::select(
                'products.id',
                'products.categoryId',
                'products.productname',
                'products.rate',
                'products.cut_price',
                'products.weight',
                'products.description',
                'products.isStock',
                'products.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id  LIMIT 1) as photo'),
                DB::raw('(SELECT categories.slugname FROM categories WHERE  categories.id=products.categoryId ORDER BY products.id  LIMIT 1) as category_slug')
            )
                ->orderBy('id', 'desc')
                ->where(['products.iStatus' => 1, 'products.isDelete' => 0, 'products.isFeatures' => 1])
                ->get();

            $recentproducts = Product::select(
                'products.id',
                'products.categoryId',
                'products.productname',
                'products.rate',
                'products.cut_price',
                            'products.usd_rate',
            'products.usd_cut_price',

                'products.weight',
                'products.description',
                'products.isStock',
                'products.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE productphotos.productid=products.id ORDER BY products.id LIMIT 1) as photo'),
                DB::raw('(SELECT categories.slugname FROM categories WHERE  categories.id=products.categoryId ORDER BY products.id  LIMIT 1) as category_slug'),
                DB::raw('(
                        SELECT MIN(CAST(product_attribute_price AS DECIMAL(10,2)))
                        FROM product_attributes
                        WHERE product_attributes.product_id = products.id
                    ) AS min_attr_price')
            )
                ->orderBy('id', 'desc')
                ->take(8)
                ->where(['products.iStatus' => 1, 'products.isDelete' => 0, 'products.isFeatures' => 0])
                ->get();

            return view('frontview.index', compact('Banner', 'featuredProduct', 'recentproducts', 'offers', 'Video'));
        } catch (\Throwable $th) {
            Log::error('Home Page Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return redirect()->back()->withInput()->with('error', 'Failed to load homepage. Please try again.');
        }
    }

    public function about(Request $request)
    {
        try {
            return view('frontview.about');
        } catch (\Throwable $th) {
            Log::error('About Page Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return redirect()->back()->withInput()->with('error', 'Failed to load about page.');
        }
    }

    public function product_list(Request $request, $categoryid)
    {

        try {
            $Category = Category::orderBy('id', 'desc')->where(['isDelete' => 0, 'slugname' => $categoryid])->first();

            if (!$Category) {
                return redirect()->back()->with('error', 'Category not found.');
            }

            $sort = $request->input('sort', 'latest'); // default: latest
            $limit = $request->input('limit',  16); // default: 16

            $products = Product::select(
                'products.id',
                'products.categoryId',
                'products.subcategoryid',
                'products.productname',
                'products.description',
                'products.slugname',
                'products.rate',
                'products.cut_price',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id LIMIT 1) as photo'),
                DB::raw('(SELECT MIN(product_attribute_price) FROM product_attributes WHERE  product_attributes.product_id=products.id ORDER BY products.id  LIMIT 1) as product_attribute_price')
            )
                ->join('categories', 'products.categoryId', '=', 'categories.id')
                ->where('categories.slugname', $categoryid)
                ->where(['products.iStatus' => 1, 'products.isDelete' => 0]);

            // Apply sorting logic
            switch ($sort) {
                case 'popular':
                    $products->orderBy('products.views', 'desc'); // example column
                    break;
                case 'rating':
                    $products->orderBy('products.rating', 'desc'); // example column
                    break;
                case 'latest':
                default:
                    $products->orderBy('products.id', 'desc');
                    break;
            }

            // Apply pagination with dynamic limit
            $products = $products->paginate($limit)->appends($request->all());

            return view('frontview.products', compact('products', 'Category', 'categoryid'));
        } catch (\Throwable $th) {
            Log::error('Product List Page Error: ' . $th->getMessage(), [
                'categoryid' => $categoryid,
                'request' => $request->all(),
                'exception' => $th
            ]);
            return redirect()->back()->withInput()->with('error', 'Something went wrong while loading the product list.');
        }
    }

    public function product_detail(Request $request, $category_id = null, $product_id = null)
    {
        try {
            $ProductDetail = Product::select(
                'products.id',
                'products.productname',
                'products.rate',
                'products.weight',
                'products.description',
                'products.isStock',
                'products.categoryId',
                'products.subcategoryid',
                'products.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id  LIMIT 1) as photo'),
                // DB::raw('(SELECT MIN(product_attribute_price) FROM product_attributes WHERE product_attributes.product_id=products.id ORDER BY products.id LIMIT 1) as product_attribute_price')
                // ⬇ keep your min() but cast to numeric so "100" vs "30" compares correctly
                    DB::raw('(
                        SELECT MIN(CAST(product_attribute_price AS DECIMAL(10,2)))
                        FROM product_attributes
                        WHERE product_attributes.product_id = products.id
                    ) AS product_attribute_price'),
                
                    // ⬇ id of the cheapest attribute (ties broken by id)
                    DB::raw('(
                        SELECT pa1.id
                        FROM product_attributes pa1
                        WHERE pa1.product_id = products.id
                        ORDER BY CAST(pa1.product_attribute_price AS DECIMAL(10,2)) ASC, pa1.id ASC
                        LIMIT 1
                    ) AS min_attr_id')
            )
                ->orderBy('products.id', 'DESC')
                ->where(['products.iStatus' => 1, 'products.isDelete' => 0, 'products.slugname' => $product_id])
                ->first();

            $minPrice = ProductAttributes::where('product_id', $ProductDetail->id)
                ->where('product_attribute_price', $ProductDetail->rate)
                ->select('product_attribute_price')
                ->first();
            // dd($minPrice);

            $Category = Category::where(['slugname' => $category_id])->first();

            $Photos = "";
            if ($ProductDetail) {
                $Photos = Productphotos::where([
                    'productphotos.iStatus' => 1,
                    'productphotos.isDelete' => 0,
                    'productphotos.productid' => $ProductDetail->id
                ])
                    ->get();
            }

            $RelatedProduct = Product::select(
                'products.id',
                'products.productname',
                'products.rate',
                'products.cut_price',
                'products.description',
                'products.isStock',
                'products.slugname',
                'products.categoryId',
                'products.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT categories.id FROM categories inner join multiplecategory on categories.id=multiplecategory.categoryid where multiplecategory.productid=products.id ORDER BY products.id LIMIT 1) as categoryId')
            )
                ->orderBy('id', 'DESC')
                ->take(4)
                ->where([
                    'products.iStatus' => 1,
                    'products.isDelete' => 0,
                    'products.categoryId' => $Category->id,
                ])
                ->where('products.slugname', '!=', $product_id)
                ->get();

            $attributes = ProductAttributes::select(
                'product_attributes.*',
                'attributes.name as attribute_name'
            )
                ->leftJoin('attributes', 'product_attributes.product_attribute_id', '=', 'attributes.id')
                ->where('product_attributes.product_id', $ProductDetail->id)
                ->orderByRaw('CAST(product_attributes.product_attribute_qty AS UNSIGNED) desc')
                ->get();
            // dd($attributes)    ;






            return view('frontview.productdetail', compact('ProductDetail', 'Photos',  'Category', 'category_id', 'product_id', 'RelatedProduct', 'attributes', 'minPrice'));
        } catch (\Throwable $th) {
            Log::error('Product Detail Page Error: ' . $th->getMessage(), [
                'category_id' => $category_id,
                'product_id' => $product_id,
                'exception' => $th
            ]);
            return redirect()->back()->withInput()->with('error', 'Something went wrong while loading the product details.');
        }
    }

    public function contactus(Request $request)
    {
        try {
            return view('frontview.contact');
        } catch (\Throwable $th) {
            Log::error('Contact Page Load Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to load contact page. Please try again.');
        }
    }

    public function contact_us_store(Request $request)
    {
        try {
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'mobileNumber' => 'required|digits:10',
                    'email' => 'required|email',
                    'subject' => 'required|string|max:255',
                    'message' => 'required|string',
                    'captcha' => 'required|captcha'
                ],
                [
                    'captcha.captcha' => 'Invalid captcha code.'
                ]
            );

            $data = array(
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'mobileNumber' => $request->mobileNumber,
                'message' => $request->message,
                "strIp" => $request->ip(),
                "created_at" => now()
            );
            Inquiry::create($data);

            $SendEmailDetails = DB::table('sendemaildetails')->where(['id' => 4])->first();

            if ($SendEmailDetails) {
                $msg = [
                    'FromMail' => $SendEmailDetails->strFromMail,
                    'Title' => $SendEmailDetails->strTitle,
                    'ToEmail' => "contact@sparshcosmo-group.com",
                    'Subject' => $SendEmailDetails->strSubject
                ];

                // ✅ Send email
                Mail::send('emails.contactemail', ['data' => $data], function ($message) use ($msg) {
                    $message->from($msg['FromMail'], $msg['Title']);
                    $message->to($msg['ToEmail'])->subject($msg['Subject']);
                });
            }

            return redirect()->route('contactthankyou');
        } catch (\Throwable $th) {
            Log::error('Contact Form Submission Error: ' . $th->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while submitting the form. Please try again later.');
        }
    }

    public function contactthankyou()
    {
        try {
            return view('frontview.contactthankyou');
        } catch (\Throwable $th) {
            Log::error('Contact Thank You Page Load Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to load the thank you page. Please try again.');
        }
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function checkout(Request $request)
    {
        try {
            $Coupon = $request->session()->get('data');
            $session = Session::get('customerid');
            $cartItems = \Cart::getContent();

            if ($cartItems->isEmpty()) {
                return redirect()->route('FrontIndex')->with('error', 'Your cart is empty!');
            }

            $Shipping = Shipping::orderBy('id', 'desc')->first();
            $State = State::orderBy('stateName', 'asc')->get();

            return view('frontview.checkout', compact('Shipping', 'Coupon', 'State'));
        } catch (\Throwable $th) {
            Log::error('Checkout View Error', [
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);
            return redirect()->back()->with('error', 'Failed to load checkout page. Please try again.');
        }
    }

    public function couponcodeapply(Request $request)
    {
        try {
            $session = Session::get('customerid');
            $couponInput = $request->coupon ?? '';
            $totalAmount = $request->totalAmount ?? 0;

            Log::info("Attempting to apply coupon", [
                'coupon' => $couponInput,
                'customer' => $session,
                'total' => $totalAmount
            ]);

            $Offer = Offer::where([
                'iStatus' => 1,
                'isDelete' => 0,
                'offercode' => $request->coupon
            ])->first();

            if (!$Offer) {
                Log::warning("Invalid or inactive coupon: $couponInput");
                return redirect()->back()->with('couponnotfound', 'Invalid or inactive coupon.');
            }

            $alreadyApplied = CustomerCouponApplyed::where([
                'customerId' => $session,
                'offerId' => $Offer->id
            ])->count();

            $today = date('Y-m-d');

            if ($couponInput !== $Offer->offercode) {
                return redirect()->back()->with('error', 'Coupon Code does not match.');
            }

            if ($totalAmount < $Offer->minvalue) {
                return redirect()->back()->with('error', 'Cart total is below the minimum coupon value.');
            }

            if (!($today >= $Offer->startdate && $today <= $Offer->enddate)) {
                return redirect()->back()->with('error', 'Coupon is expired!');
            }

            $discount = round(($totalAmount * $Offer->percentage) / 100);

            CustomerCouponApplyed::create([
                'offerId' => $Offer->id ?? 0,
                'customerId' => $session ?? 0,
                'result' => $discount ?? 0,
                'created_at' => now(),
                "strIP" => $request->ip()
            ]);

            Session::put('discount', $discount);
            Session::put('applied_coupon_code', $couponInput);

            Log::info("Coupon applied successfully", [
                'customerId' => $session,
                'discount' => $discount,
                'coupon' => $couponInput
            ]);

            return back()->with([
                'success' => 'Coupon Code Applied Successfully!',
            ]);
        } catch (\Throwable $e) {
            Log::error('Coupon Apply Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Something went wrong while applying the coupon.');
        }
    }
    
    public function removeCoupon(Request $request)
    {
        try {
            Session::forget('discount');
            Session::forget('applied_coupon_code');
    
            return redirect()->back()->with('success', 'Coupon removed successfully!');
        } catch (\Throwable $e) {
            Log::error('Remove Coupon Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Something went wrong while removing the coupon.');
        }
    }


    public function checkoutstore(Request $request)
    {
        $request->validate([
            'billFirstName' => 'required|string|max:255',
            'billLastName' => 'required|string|max:255',
            'billPhone' => 'required|digits:10',
            'billEmail' => 'nullable|email',
            'billStreetAddress1' => 'required|string|max:255',
            'billState' => 'required|string|max:100',
            'shipping_city' => 'required|string|max:100',
            'billPinCode' => 'required|digits_between:5,10',
            'strCountry' => 'required|string|max:100',
        ]);

        $cartItems = \Cart::getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();
        try {
            $subtotal = \Cart::getSubTotal();
            $discount = Session::get('discount', 0);
            $amount = $subtotal - $discount;

            $existingCustomer = Customer::where([
                'isDelete' => 0,
                'iStatus' => 1,
                'customermobile' => $request->billPhone
            ])->first();

            $customerid = $existingCustomer ? $existingCustomer->customerid : 0;
            $uniqueNumber = Str::uuid();

            if (!$existingCustomer) {
                $customer = Customer::create([
                    'firstname' => $request->billFirstName,
                    'lastname' =>  $request->billLastName,
                    'customername' => $request->billFirstName . ' ' . $request->billLastName,
                    'guid' => $uniqueNumber,
                    'customermobile' => $request->billPhone,
                    'customeremail' => $request->billEmail,
                    'address' => $request->billStreetAddress1,
                    'address1' => $request->billStreetAddress2,
                    'state' => $request->billState,
                    'city' => $request->shipping_city,
                    'pincode' => $request->billPinCode,
                    'country' => $request->strCountry,
                    'created_at' => now(),
                    'strIP' => $request->ip()
                ]);
                $customerid = $customer->customerid;
            } else {
                $existingCustomer->update([
                    'firstname' => $request->billFirstName,
                    'lastname' =>  $request->billLastName,
                    'customername' => $request->billFirstName . ' ' . $request->billLastName,
                    'customermobile' => $request->billPhone,
                    'customeremail' => $request->billEmail,
                    'address' => $request->billStreetAddress1,
                    'address1' => $request->billStreetAddress2,
                    'state' => $request->billState,
                    'city' => $request->shipping_city,
                    'pincode' => $request->billPinCode,
                    'country' => $request->strCountry,
                    'updated_at' => now(),
                    'strIP' => $request->ip()
                ]);
            }

            $order = Order::create([
                'customerid' => $customerid ?? 0,
                'shipping_cutomerName' => $request->billFirstName . ' ' . $request->billLastName,
                'shipping_mobile' => $request->billPhone,
                'shipping_email' => $request->billEmail,
                'shiiping_address1' => $request->billStreetAddress1,
                'shiiping_address2' => $request->billStreetAddress2,
                'shipping_city' => $request->shipping_city,
                'shiiping_state' => $request->billState,
                'shipping_pincode' => $request->billPinCode,
                'country' => $request->strCountry,
                'amount' => $subtotal, // original cart amount
                'discount' => $discount,
                'netAmount' => $amount,
                'created_at' => now(),
                'strIP' => $request->ip()
            ]);

            foreach ($cartItems as $cartItem) {
                OrderDetail::create([
                    'orderID' => $order->id,
                    'customerid' => $customerid,
                    'categoryId' => $cartItem->categoryId,
                    'productId' => $cartItem->productid,
                    'quantity' => $cartItem->quantity,
                    'size' => $cartItem->id,
                    'rate' => $cartItem->price,
                    'amount' => $cartItem->price * $cartItem->quantity,
                    'created_at' => now(),
                    "strIP" => $request->ip()
                ]);
            }

            $api = new Api(config('app.razorpay_key'), config('app.razorpay_secret'));
            $razorpayOrder = $api->order->create([
                'receipt' => $order->id . '-' . date('YmdHis'),
                'amount' => $amount * 100,
                'currency' => 'INR',
            ]);

            Payment::create([
                'order_id' => $razorpayOrder['id'],
                'oid' => $order->id,
                'amount' => $amount,
                'currency' => 'INR',
                'receipt' => $razorpayOrder['receipt'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $amount,
                'email' => $request->billEmail,
                'mobile' => $request->billPhone,
                'customer_name' => $request->billFirstName . ' ' . $request->billLastName,
                'order_id' => $order->id
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Checkout Store Error', [
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'input' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Something went wrong while processing your order.');
        }
    }

    public function payment_success()
    {
        try {
            return view('frontview.payment_success');
        } catch (\Throwable $th) {
            Log::error('Payment Success Page Error: ' . $th->getMessage());
            return redirect()->route('FrontIndex')->with('error', 'Failed to load success page.');
        }
    }

    public function payment_fail()
    {
        try {
            return view('frontview.payment_fail');
        } catch (\Throwable $th) {
            Log::error('Payment Fail Page Error: ' . $th->getMessage());
            return redirect()->route('FrontIndex')->with('error', 'Failed to load failure page.');
        }
    }

    public function frontlogin(Request $request)
    {
        try {
            return view('frontview.login');
        } catch (\Throwable $th) {
            Log::error('Front Login Page Error: ' . $th->getMessage());
            return redirect()->route('FrontIndex')->with('error', 'Failed to load login page.');
        }
    }

    public function frontloginstore(Request $request)
    {
        $request->validate([
            'customermobile' => 'required|digits:10',
            'password' => 'required',
        ]);

        try {
            $customer = Customer::where('customermobile', $request->customermobile)->first();

            if ($customer && Hash::check($request->password, $customer->password)) {
                // Login successful – set session
                session()->put('customerid', $customer->customerid);
                session()->put('customername', $customer->customername);
                session()->put('customermobile', $customer->customermobile);
                session()->put('customeremail', $customer->customeremail);

                return redirect()->route('FrontIndex')->with('success', 'Login successful!');
            }

            return back()->with('error', 'Invalid mobile or password');
        } catch (\Throwable $th) {
            Log::error('Front Login Error: ' . $th->getMessage(), [
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function forgotpassword(Request $request)
    {
        try {
            return view('frontview.forgotpassword');
        } catch (\Throwable $th) {
            Log::error('Forgot Password Page Error: ' . $th->getMessage());
            return redirect()->route('FrontIndex')->with('error', 'Unable to load forgot password page.');
        }
    }

    public function forgotpasswordsubmit(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:customer,customeremail',
            ]);

            $user = Customer::where('customeremail', $request->email)->firstOrFail();
            $token = Str::random(64);

            DB::table('password_resets')->updateOrInsert(
                ['email' => $user->customeremail],
                ['token' => $token, 'created_at' => Carbon::now()]
            );

            $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($user->customeremail));
            Mail::to($user->customeremail)->send(new PasswordResetMail($user, $resetLink));


            return back()->with('success', 'Password reset link sent to your email.');
        } catch (\Throwable $e) {
            Log::error('Forgot Password Submit Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function showResetForm(Request $request)
    {
        try {
            $token = $request->route('token');
            $email = $request->query('email');

            return view('frontview.newpassword', compact('token', 'email'));
        } catch (\Throwable $e) {
            Log::error('Show Reset Form Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('FrontIndex')->with('error', 'Invalid or broken reset link.');
        }
    }

    public function set_new_password_submit(Request $request)
    {
        try {

            $request->validate([
                'token' => 'required',
                'email' => 'required|email|exists:customer,customeremail',
                'password' => 'required|min:6|confirmed',
            ]);

            $tokenData = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();

            if (!$tokenData) {
                return back()->withErrors(['email' => 'Invalid or expired password reset token.']);
            }

            if (Carbon::parse($tokenData->created_at)->addMinutes(5)->isPast()) {
                return back()->with(['error' => 'This password reset link has expired. Please request a new one.']);
            }

            Customer::where(['customeremail' => $request->email])->update([
                "password"  => Hash::make($request->password)
            ]);

            DB::table('password_resets')->where('email', $request->email)->delete();

            return redirect()->route('FrontIndex')->with('success', 'Your password has been reset successfully!');
        } catch (\Throwable $e) {
            Log::error('Set New Password Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Unable to reset password. Please try again.');
        }
    }

    public function profile(Request $request)
    {
        try {
            if (Session::get('customerid')) {
                return view('frontview.profile');
            } else {
                return redirect()->route('FrontLogin')->with('error', 'Please login to access your profile.');
            }
        } catch (\Throwable $th) {
            Log::error('Profile Page Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function myaccount(Request $request)
    {
        try {
            if (Session::get('customerid')) {
                return view('frontview.myaccount');
            } else {
                return redirect()->route('FrontLogin')->with('error', 'Please login to access your account.');
            }
        } catch (\Throwable $th) {
            Log::error('My Account Page Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function myaccountedit(Request $request)
    {
        try {
            $session = Session::get('customerid');

            if (!$session) {
                return redirect()->route('FrontLogin')->with('error', 'Session expired. Please login again.');
            }

            Session::forget(['customername', 'customeremail', 'customermobile']);

            $update = DB::table('customer')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session])
                ->update([
                    'customername' => $request->customername,
                    'customeremail' => $request->customeremail,
                    'customermobile' => $request->customermobile,
                    'updated_at' => now()
                ]);

            Session::put('customername', $request->customername);
            Session::put('customeremail', $request->customeremail);
            Session::put('customermobile', $request->customermobile);

            return back()->with('myaccountupdatesuccess', 'Profile Updated Successfully!');
        } catch (\Throwable $th) {
            Log::error('My Account Update Error: ' . $th->getMessage(), [
                'input' => $request->all(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);
            return redirect()->back()->withInput()->with('error', 'Something went wrong while updating your account.');
        }
    }

    public function changepassword(Request $request)
    {
        try {
            if (Session::get('customerid')) {
                return view('frontview.changepassword');
            } else {
                return redirect()->route('FrontLogin')->with('error', 'Please login to change your password.');
            }
        } catch (\Throwable $th) {
            Log::error('Change Password Page Error: ' . $th->getMessage());
            return redirect()->route('FrontIndex')->with('error', 'Failed to load password change page.');
        }
    }

    public function changepasswordsubmit(Request $request)
    {
        try {
            $session = Session::get('customerid');
            $newpassword = $request->newpassword;
            $confirmpassword = $request->confirmpassword;

            if ($newpassword !== $confirmpassword) {
                return back()->with('passworderror', 'New password and confirm password do not match.');
            }

            DB::table('customer')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session])
                ->update(['password' => Hash::make($confirmpassword)]);

            return back()->with('passwordsuccess', 'Password changed successfully!');
        } catch (\Throwable $th) {
            Log::error('Change Password Error: ' . $th->getMessage(), [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->withInput()->with('error', 'Something went wrong while changing your password.');
        }
    }

    public function myorders(Request $request)
    {
        try {
            $customerId = Session::get('customerid');

            if (!$customerId) {
                return redirect()->route('FrontLogin')->with('error', 'Please login to view your orders.');
            }

            $orderItems  = OrderDetail::select(
                'order.order_id as order_id_in_order',
                'order.isPayment',
                'orderdetail.*',
                'products.id',
                'products.productname',
                'products.rate',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id  LIMIT 1) as photo'),
                'product_attributes.product_attribute_qty',
                'attributes.name',
            )
                ->where([
                    'orderdetail.iStatus' => 1,
                    'orderdetail.isDelete' => 0,
                    'orderdetail.customerid' => $customerId
                ])
                ->leftjoin('products', 'orderdetail.productId', '=', 'products.id')
                ->leftjoin('order', 'orderdetail.orderID', '=', 'order.order_id')
                ->leftJoin('product_attributes', 'orderdetail.size', '=', 'product_attributes.id')
                ->leftJoin('attributes', 'product_attributes.product_attribute_id', '=', 'attributes.id')
                ->orderBy('orderdetail.orderID', 'desc')
                ->paginate(10);

            $groupedOrders = $orderItems->groupBy('orderID');

            $orders = $groupedOrders->map(function ($items, $orderId) {
                return (object)[
                    'order_id' => $orderId,
                    'items' => $items,
                    'isPayment' => $items->first()->isPayment,
                ];
            });

            return view('frontview.after_login.myorders', compact('orders'));
        } catch (\Throwable $th) {
            Log::error('My Orders Error: ' . $th->getMessage(), ['line' => $th->getLine()]);
            return redirect()->back()->with('error', 'Unable to load orders. Please try again later.');
        }
    }

    public function myordersdetails(Request $request, $id)
    {
        try {
            $session = Session::get('customerid');

            if (!$session) {
                return redirect()->route('FrontLogin')->with('error', 'Please login to view order details.');
            }

            $Order = OrderDetail::select(
                'orderdetail.orderID',
                'orderdetail.created_at',
                'orderdetail.quantity',
                'orderdetail.weight',
                'orderdetail.rate',
                'orderdetail.amount',
                'product.productname',
                DB::raw('(SELECT product_attribute_size FROM product_attributes WHERE  product_attributes.id=orderdetail.size  LIMIT 1) as size'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo')
            )
                ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.customerid' => $session, 'orderdetail.orderID' => $id])
                ->get();

            return response()->json($Order);
        } catch (\Throwable $th) {
            Log::error('Order Details Error: ' . $th->getMessage(), ['line' => $th->getLine()]);
            return redirect()->back()->with('error', 'Unable to load order details.');
        }
    }

    public function mywish_list(Request $request)
    {
        try {

            $session = Session::get('customerid');

            if (!$session) {
                return redirect()->route('FrontLogin')->with('error', 'Please login to access wishlist.');
            }

            $wishlist = wishlist::select(
                'products.id',
                'products.productname',
                'products.slugname',
                'products.rate',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id  LIMIT 1) as photo')
            )
                ->join("products", "wishlist.productid", '=', 'products.id')
                ->where(['wishlist.iStatus' => 1, 'wishlist.isDelete' => 0, 'wishlist.customerid' => $session])
                ->orderBY('id', 'desc')
                ->get();

            return view('frontview.after_login.mywishlist', compact('wishlist'));
        } catch (\Throwable $th) {
            Log::error('My Wishlist Error: ' . $th->getMessage(), ['line' => $th->getLine()]);
            return redirect()->back()->with('error', 'Unable to load wishlist.');
        }
    }

    public function wishlist_store(Request $request)
    {
        try {
            $session = Session::get('customerid');

            if (!$session) {
                return redirect()->route('FrontLogin')->with('error', 'Please login to use wishlist.');
            }

            $wishlist = Wishlist::where([
                'wishlist.iStatus' => 1,
                'wishlist.isDelete' => 0,
                'wishlist.customerid' => $session,
                'productid' => $request->productid
            ])
                ->count();

            if ($wishlist == 0) {
                Wishlist::create([
                    "customerid" => $session,
                    "productid" => $request->productid,
                    "price" => $request->price,
                    'created_at' => now(),
                    'strIP' => $request->ip()
                ]);

                return back()->with('success', 'Product Added To Wishlist!');
            } else {
                return back()->with('error', 'Product is already in your wishlist.');
            }
        } catch (\Throwable $th) {
            Log::error('Wishlist Store Error: ' . $th->getMessage(), ['line' => $th->getLine()]);
            return redirect()->back()->with('error', 'Unable to update wishlist.');
        }
    }

    public function CancellationandRefund()
    {
        try {
            $datas = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => 2])->first();
            return view('frontview.CancellationandRefund', compact('datas'));
        } catch (\Throwable $th) {
            Log::error('Cancellation and Refund Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function cms_pages($slugname)
    {
        try {
            $datas = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'slugname' => $slugname])->first();

            return view('frontview.cms_pages', compact('datas'));
        } catch (\Throwable $th) {
            Log::error('CMS Page Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Page not found or unavailable.');
        }
    }

    public function Frontlogout(Request $request)
    {
        try {
            $request->session()->forget([
                'customerid',
                'customername',
                'customermobile',
                'customeremail'
            ]);

            return redirect()->route('FrontIndex');
        } catch (\Throwable $th) {
            Log::error('Logout Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to logout.');
        }
    }

    public function HeaderSearch(Request $request)
    {
        try {
            $headerSearch = $request->headersearch;

            // Only proceed if there's a search term
            if (!$headerSearch) {
                return redirect()->back()->with('error', 'Please enter a search term.');
            }

            $products = Product::select(
                'products.id',
                'products.categoryId',
                'products.subcategoryid',
                'products.productname',
                'products.slugname',
                'products.rate',
                'products.cut_price',
                'categories.slugname as category_slug',
                DB::raw('( SELECT strphoto FROM productphotos WHERE productphotos.productid = products.id ORDER BY productphotos.productphotosid LIMIT 1 ) as photo'),
                DB::raw('( SELECT MIN(product_attribute_price) FROM product_attributes WHERE product_attributes.product_id = products.id ) as product_attribute_price')
            )
                ->leftJoin('categories', 'products.categoryId', '=', 'categories.id')
                ->where('products.iStatus', 1)
                ->where('products.isDelete', 0)
                ->where('products.productname', 'LIKE', '%' . $headerSearch . '%')
                ->orderByDesc('products.id')
                ->paginate(16)
                ->appends($request->all());

            $productCount = $products->total();

            return view('frontview.Searchdata', compact('products', 'productCount', 'headerSearch'));
        } catch (\Throwable $th) {
            Log::error('Header Search Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Search failed. Please try again.');
        }
    }

    public function checkmobile(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'phone' => 'required|digits:10', // Ensure phone field is required and has exactly 10 digits
            ]);

            $Data = Customer::orderBy('customerid', 'DESC')
                ->where(['customermobile' => $request->phone])
                ->first();

            return response()->json($Data);
        } catch (\Throwable $th) {
            Log::error('Check Mobile Error: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to check mobile.'], 500);
        }
    }

    public function customerorder(Request $request, $ORDER_ID, $guid)
    {
        try {
            $Total = Order::where(['isDelete' => 0, 'iStatus' => 1, 'order_id' => $ORDER_ID])->first();

            if ($Total) {
                // dd('if');
                $Customer = Customer::where(['isDelete' => 0, 'iStatus' => 1, 'guid' => $guid])->first();
                //   dd($Customer);
                $Order = OrderDetail::select(
                    'product.productname',
                    'orderdetail.quantity',
                    'orderdetail.productId',
                    'orderdetail.customerid',
                    'orderdetail.orderID',
                    'orderdetail.rate',
                    'orderdetail.size',
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),

                )
                    ->where(['orderdetail.isDelete' => 0, 'orderdetail.iStatus' => 1, 'orderdetail.orderID' => $ORDER_ID, 'orderdetail.customerid' => $Customer->customerid])
                    ->leftjoin('product', 'orderdetail.productId', '=', 'product.productId')
                    ->get();
                //  dd($Order);
                // if(isset($Order) && $Order != "" && $Order != null && $Order != []){
                return view('frontview.customerorder', compact('Customer', 'Order', 'Total'));
            } else {
                // dd('else');
                return redirect()->route('ordernotavailable');
            }
        } catch (\Throwable $th) {
            Log::error('Customer Order Error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Unable to retrieve order.');
        }
    }
}