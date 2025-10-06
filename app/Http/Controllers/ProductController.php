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

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $ProductName = $request->productName;
        $Product = Product::select(
            'products.id',
            'products.categoryId',
            'products.subcategoryid',
            'products.productname',
            'products.rate',
            'products.isFeatures',
            'products.iStatus',
            DB::raw('(SELECT categoryname FROM categories WHERE categories.id = products.subcategoryid) AS subcategoryname'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=products.id ORDER BY products.id  LIMIT 1) as photo'),
            'categories.categoryname'
        )
            ->orderBy('id', 'desc')
            ->where(['products.isDelete' => 0])
            ->when($request->productName, fn($query, $ProductName) => $query
                ->where('products.productname', 'like', "%$ProductName%"))
            ->leftjoin('categories', 'products.categoryId', '=', 'categories.id')
            ->paginate(config('ap.per_page', 10));
        // dd($Product);

        return view('admin.product.index', compact('Product', 'ProductName'));
    }

    public function createview()
    {

        $Category = Category::orderBy('categoryname', 'asc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

        return view('admin.product.add', compact('Category'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'categoryId' => 'required',
                'productname' => 'required|unique:products,productname',
                'photo' => 'required',
            ]);

            $isFeatures = $request->isFeatures == "on" ? 1 : 0;

            $Data = array(
                'categoryId' => $request->categoryId ?? 0,
                'subcategoryid' => $request->subcategoryid ?? 0,
                'productname' => $request->productname,
                'slugname' => Str::slug($request->productname),
                'rate' => $request->rate,
                'cut_price' => $request->cut_price,
                'usd_rate' => $request->usd_rate,
                'usd_cut_price' => $request->usd_cut_price,
                'description' => $request->description,
                'isFeatures' => $isFeatures ?? 0,
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'head' => $request->head,
                'body' => $request->body,
                'created_at' => now(),
                'strIP' => $request->ip()
            );
            $insertedProduct = Product::create($Data);
            $insertedId = $insertedProduct->id;

            foreach ($request->file('photo') as $file) {
                $root = $_SERVER['DOCUMENT_ROOT'];

                // Unique image name
                $imgName = time() . '_' . mt_rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

                // Resize & Save Thumbnail
                if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
                    $thumbnailPath = $root . '/uploads/product/thumbnail/';
                } else {
                    $thumbnailPath = $root . '/uploads/product/thumbnail/';
                }
                if (!file_exists($thumbnailPath)) {
                    mkdir($thumbnailPath, 0755, true);
                }

                $img = Image::make($file->getRealPath());
                
                // 👇 Resize to fixed 4:3 ratio (800x600)
                $img->resize(800, 600)->save($thumbnailPath . '/' . $imgName);
                
                // $img->resize(540, 720, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($thumbnailPath . '/' . $imgName);

                // Save original image
                if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
                    $originalPath = $root . '/uploads/product/';
                } else {
                    $originalPath = $root . '/uploads/product/';
                }
                if (!file_exists($originalPath)) {
                    mkdir($originalPath, 0755, true);
                }
                $file->move($originalPath, $imgName);

                $data = array(
                    'productid' => $insertedId,
                    'strphoto' => $imgName,
                    'strIP' => $request->ip(),
                    'created_at' => now()
                );
                Productphotos::create($data);
            }

            return redirect()->route('product.index')->with('success', 'Product Created Successfully.');
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while creating the product.');
        }
    }

    public function editview(Request $request, $id)
    {
        $Category = Category::orderBy('categoryname', 'asc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

        $product = Product::where(['isDelete' => 0, 'id' => $id])->first();

        $SubCategory = Category::where(['isDelete' => 0, 'id' => $product->subcategoryid])->get();

        return view('admin.product.edit', compact('product', 'Category', 'SubCategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'categoryId' => 'required',
            'productname' => 'required|unique:products,productname,' . $id . ',id',
        ]);

        $isFeatures = $request->isFeatures == "on" ? 1 : 0;

        Product::where(['isDelete' => 0, 'id' => $id])
            ->update([
                'categoryId' => $request->categoryId ?? 0,
                'subcategoryid' => $request->subcategoryid ?? 0,
                'productname' => $request->productname,
                'slugname' => Str::slug($request->productname),
                'rate' => $request->rate,
                'cut_price' => $request->cut_price,
                'usd_rate' => $request->usd_rate,
                'usd_cut_price' => $request->usd_cut_price,
                'description' => $request->description,
                'isFeatures' => $isFeatures ?? 0,
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'head' => $request->head,
                'body' => $request->body,
                'updated_at' => now()
            ]);

        $img = "";
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $root = $_SERVER['DOCUMENT_ROOT'];

                // Unique image name
                $imgName = time() . '_' . mt_rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

                // Resize & Save Thumbnail
                if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
                    $thumbnailPath = $root . '/uploads/product/thumbnail/';
                } else {
                    $thumbnailPath = $root . '/uploads/product/thumbnail/';
                }
                if (!file_exists($thumbnailPath)) {
                    mkdir($thumbnailPath, 0755, true);
                }

                $img = Image::make($file->getRealPath());
                
                // 👇 Resize to fixed 4:3 ratio (800x600)
                $img->resize(800, 600)->save($thumbnailPath . '/' . $imgName);
                
                // $img->resize(540, 720, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($thumbnailPath . '/' . $imgName);

                // Save original image
                if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
                    $originalPath = $root . '/uploads/product/';
                } else {
                    $originalPath = $root . '/uploads/product/';
                }
                if (!file_exists($originalPath)) {
                    mkdir($originalPath, 0755, true);
                }
                $file->move($originalPath, $imgName);

                $data = array(
                    'productid' => $id,
                    'strphoto' => $imgName,
                    'strIP' => $request->ip(),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                Productphotos::create($data);
            }
        }

        return redirect()->route('product.index')->with('success', 'Product Updated Successfully.');
    }

    //Product Index Page Delete
    public function delete(Request $request)
    {
        try {
            $productId = $request->productId;
            $photos = Productphotos::where([
                'isDelete' => 0,
                'productid' => $productId
            ])->get();

            $root = $_SERVER['DOCUMENT_ROOT'];
            if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
                $thumbnailPath = $root . '/uploads/product/thumbnail/';
                $originalPath = $root . '/uploads/product/';
            } else {
                $thumbnailPath = $root . '/uploads/product/thumbnail/';
                $originalPath = $root . '/uploads/product/';
            }

            foreach ($photos as $photo) {
                if ($photo->strphoto) {
                    $thumbFile = $thumbnailPath . $photo->strphoto;
                    $originalFile = $originalPath . $photo->strphoto;

                    if (file_exists($thumbFile)) {
                        unlink($thumbFile);
                    }

                    if (file_exists($originalFile)) {
                        unlink($originalFile);
                    }
                }
            }

            Productphotos::where(['isDelete' => 0, 'productId' => $productId])->delete();

            Product::where(['isDelete' => 0, 'productId' => $productId])->delete();

            return redirect()->route('product.index')->with('success', 'Product Deleted Successfully!.');
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while deleting the product.');
        }
    }

    //Product Image Delete In Edit Page
    public function productimage(Request $request, $id)
    {
        try {
            $photo = Productphotos::where(['isDelete' => 0, 'productphotosid' => $id])->first();

            if ($photo && $photo->strphoto) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
                    $originalPath = $root . '/uploads/product/' . $photo->strphoto;
                    $thumbPath = $root . '/uploads/product/thumbnail/' . $photo->strphoto;
                } else {
                    $originalPath = $root . '/uploads/product/' . $photo->strphoto;
                    $thumbPath = $root . '/uploads/product/thumbnail/' . $photo->strphoto;
                }

                if (file_exists($thumbPath)) {
                    unlink($thumbPath);
                }

                if (file_exists($originalPath)) {
                    unlink($originalPath);
                }
                // Delete DB record
                Productphotos::where([
                    'isDelete' => 0,
                    'productphotosid' => $id
                ])->delete();

                echo 1;
            } else {
                echo 0; // Photo not found
            }
        } catch (\Exception $e) {
            Log::error('Error deleting product image: ' . $e->getMessage());
            echo 0;
        }
    }

    //Product Photos Listing Page
    public function productphotos(Request $request, $id)
    {
        $datas = Productphotos::orderby('productphotosid', 'desc')
            ->where(['isDelete' => 0, 'productid' => $id])
            ->paginate(config('app.per_page', 10));

        return view('admin.product.photoslist', compact('datas'));
    }

    //In Product Photos Listing Page Photo Delete
    public function productphotosdelete(Request $request)
    {
        try {
            $photo = Productphotos::where(['isDelete' => 0, 'productphotosid' => $request->productphotosid])->first();

            if ($photo && $photo->strphoto) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
                    $thumbnailPath = $root . '/uploads/product/thumbnail/' . $photo->strphoto;
                    $originalPath = $root . '/uploads/product/' . $photo->strphoto;
                } else {
                    $thumbnailPath = $root . '/uploads/product/thumbnail/' . $photo->strphoto;
                    $originalPath = $root . '/uploads/product/' . $photo->strphoto;
                }

                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }

                if (file_exists($originalPath)) {
                    unlink($originalPath);
                }

                DB::table('productphotos')->where([
                    'isDelete' => 0,
                    'productphotosid' => $request->productphotosid
                ])->delete();

                return back()->with('success', 'Product Photo Deleted Successfully!');
            } else {
                return back()->with('error', 'Photo not found or already deleted.');
            }
        } catch (\Exception $e) {
            \Log::error('Error deleting product photo: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the product photo.');
        }
    }

    public function updateStatus($product_id, $status)
    {

        $validate = Validator::make([
            'product_id'   => $product_id,
            'status'    => $status
        ], [
            'product_id'   =>  'required|exists:products,id',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('product.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            Product::where('id', $product_id)->update(['iStatus' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Status Updated Successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Status update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the status.');
        }
    }
}
