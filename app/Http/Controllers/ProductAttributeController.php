<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Productphotos;
use App\Models\Inward;
use App\Models\CategoryMultiple;
use Illuminate\Support\Facades\DB;
use Image;
use App\Models\Attributes;
use App\Models\ProductAttributes;
use App\Models\Ledger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductAttributeController extends Controller
{

    public function product_attribute(Request $request, $id)
    {
        $Product = Product::select(
            'products.*',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id  LIMIT 1) as photo')
        )
            ->orderBy('id', 'desc')
            ->where(['products.isDelete' => 0, 'products.id' => $id])
            ->first();

        $ProductAttributes = ProductAttributes::select(
            'product_attributes.id',
            'product_attributes.product_id',
            'product_attributes.product_attribute_id',
            'product_attributes.product_attribute_size',
            'product_attributes.product_attribute_qty',
            'product_attributes.product_attribute_price',
            'product_attributes.product_attribute_usd_price',
            'product_attributes.product_attribute_price_without_gst',
            'product_attributes.product_attribute_photo',
            'attributes.name'
        )
            ->orderBY('product_attributes.id', 'desc')
            ->where(['product_id' => $id])
            ->join('attributes', 'product_attributes.product_attribute_id', '=', 'attributes.id')
            ->paginate(25);
        // dd($ProductAttributes);
        $Attribute = Attributes::get();

        return view('admin.product.attribute', compact('Product', 'Attribute', 'ProductAttributes', 'id'));
    }

    public function product_attribute_store(Request $request)
    {
        $id = $request->productid;

        $img = "";
        if ($request->hasFile('product_attribute_photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('product_attribute_photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/ProductAttribute/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }

        $ProductAttribute = ProductAttributes::orderBy('id', 'desc')
            ->where(["product_attributes.product_id" => $request->productid, 'product_attributes.product_attribute_size' => $request->product_attribute_size])
            ->first();
        // dd($ProductAttribute);

        // if (isset($ProductAttribute) && $ProductAttribute != "" && $ProductAttribute != null) {
        //     return redirect()->back()->with('error', 'Size Already Exists');
        // } else {
        $Data = array(
            'product_id' => $request->productid ?? 0,
            'product_attribute_id' => $request->product_attribute_id ?? 0,
            'product_attribute_size' => $request->product_attribute_size,
            'product_attribute_qty' => $request->product_attribute_qty,
            'product_attribute_price' => $request->product_attribute_price,
            'product_attribute_usd_price' => $request->product_attribute_usd_price,
            'product_attribute_photo' => $img ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        );
        $product_attributesId = DB::table('product_attributes')->insertGetId($Data);

        $GetProductAttributes = ProductAttributes::where(['id' => $product_attributesId])->first();

        $opening = Ledger::select('openingBalance', 'closingBalance', 'cr', 'dr', 'iProductId', 'iOrderId')
            ->orderBy('ledger.ledgerId', 'DESC')
            ->where([
                'ledger.iStatus' => 1,
                'ledger.isDelete' => 0,
                'iProductId' => $request->productid,
                'iSize' => $request->product_attribute_size
            ])
            ->first();
        // dd($opening);

        $cr = $request->product_attribute_qty;
        $dr = 0;
        $openingBalance = $opening->closingBalance ?? 0;
        $closing = ($openingBalance + $cr);

        $Inward = array(
            'iProductId' => $request->productid ?? 0,
            'iSize' => $GetProductAttributes->id ?? 0,
            'iQty' => $request->product_attribute_qty,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        $InsetedId = DB::table('inward')->insertGetId($Inward);

        $Ledger = array(
            'iProductId' => $request->productid ?? 0,
            'iSize' => $GetProductAttributes->id ?? 0,
            'iInwardId' =>  $InsetedId,
            'iOrderId' =>  0,
            'iOrderDetailId' =>  0,
            'openingBalance' => $openingBalance,
            'cr' => $request->product_attribute_qty ?? 0,
            'dr' =>  $dr,
            'closingBalance' =>  $closing,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        // dd($Ledger);
        DB::table('ledger')->insert($Ledger);

        return redirect()->route('product.product_attribute', $request->productid)->with('success', 'Product Attribute Created Successfully.');
        // }
    }

    public function product_attribute_editview(Request $request, $id)
    {
        $ProductAttributes = ProductAttributes::where(['id' => $id])->first();

        echo json_encode($ProductAttributes);
    }

    public function product_attribute_update(Request $request)
    {
        $update = DB::table('product_attributes')
            ->where(['id' => $request->attributeid])
            ->update([
                'product_attribute_qty' => $request->product_attribute_qty,
                'product_attribute_price' => $request->product_attribute_price,
                'product_attribute_usd_price' => $request->product_attribute_usd_price,
                'product_attribute_size' => $request->product_attribute_size,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Product Attribute Updated Successfully.');
    }

    public function product_attribute_delete(Request $request)
    {

        DB::table('product_attributes')->where(['id' => $request->id])->delete();


        return back()->with('success', 'Product Attribute Deleted Successfully!.');
    }
}
