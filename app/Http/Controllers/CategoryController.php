<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;



class CategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $Category = Category::where('isDelete', 0)
                ->orderBy('strSequence', 'asc')
                ->paginate(25);

            return view('admin.category.index', compact('Category'));
        } catch (\Throwable $e) {
            Log::error("Category index error: " . $e->getMessage());
            return back()->with('error', 'Failed to load category list.');
        }
    }

    public function create(Request $request)
    {
        try {
            $Category = Category::where('isDelete', 0)->orderBy('categoryname')->get();

            return view('admin.category.add', compact('Category'));
        } catch (\Throwable $e) {
            Log::error("Category create error: " . $e->getMessage());
            return back()->with('error', 'Failed to load create form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'categoryname' => 'required|string|max:255|unique:categories,categoryname',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $img = "";
            if ($request->hasFile('photo')) {

                $image = $request->file('photo');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(FolderPath('/uploads/category'), $imageName);
                $img = $imageName;
            }

            $slugName = Str::slug($request->categoryname);
            $Data = array(
                'subcategoryid' => $request->subcategoryid ?? 0,
                'categoryname' => $request->categoryname,
                'slugname' => $slugName,
                'strSequence' => $request->strSequence ?? 0,
                'strGST' => $request->strGST ?? 0,
                'photo' => $img,
                'created_at' => now(),
                'strIP' => $request->ip(),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'head' => $request->head,
                'body' => $request->body,
            );
            Category::create($Data);

            return redirect()->route('category.index')->with('success', 'Category Created Successfully.');
        } catch (\Throwable $e) {
            Log::error("Category store error: " . $e->getMessage());
            return back()->with('error', 'Failed to create category.')->withInput();
        }
    }

    public function editview(Request $request, $id)
    {
        try {
            $Category = Category::where('isDelete', 0)->orderBy('categoryname')->get();
            $data = Category::where('isDelete', 0)->findOrFail($id);

            return view('admin.category.edit', compact('data', 'Category'));
        } catch (\Throwable $e) {
            Log::error("Category edit view error: " . $e->getMessage());
            return back()->with('error', 'Failed to load category edit page.');
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'categoryname' => 'required|string|max:255|unique:categories,categoryname,' . $request->categoryId . ',id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            // Find category safely
            $category = Category::where('isDelete', 0)->where('id', $request->categoryId)->firstOrFail();

            $img = $category->photo;

            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $destinationPath = FolderPath('/uploads/category');

                // Ensure folder exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $imageName);
                $img = $imageName;

                // Delete old image if exists
                $oldImagePath = $destinationPath . '/' . $category->photo;
                if ($category->photo && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $category->update([
                'subcategoryid' => $request->subcategoryid ?? 0,
                'categoryname' => $request->categoryname,
                'slugname' => Str::slug($request->categoryname),
                'strSequence' => $request->strSequence ?? 0,
                'strGST' => $request->strGST ?? 0,
                'photo' => $img,
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'head' => $request->head,
                'body' => $request->body,
            ]);

            return redirect()->route('category.index')->with('success', 'Category Updated Successfully.');
        } catch (\Throwable $e) {
            Log::error("Category update error: " . $e->getMessage());
            return back()->with('error', 'Failed to update category.')->withInput();
        }
    }

    public function delete(Request $request)
    {
        try {
            $category = Category::where('isDelete', 0)->findOrFail($request->categoryId);

            $imagePath = FolderPath('/uploads/category') . '/' . $category->photo;

            if ($category->photo && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $category->delete();

            return back()->with('success', 'Category Deleted Successfully!');
        } catch (\Throwable $e) {
            Log::error("Category delete error: " . $e->getMessage());
            return back()->with('error', 'Failed to delete category.');
        }
    }

    public function updateStatus($category_id, $status)
    {
        try {
            $validate = Validator::make([
                'category_id' => $category_id,
                'status' => $status
            ], [
                'category_id' => 'required|exists:categories,id',
                'status' => 'required|in:0,1',
            ]);

            if ($validate->fails()) {
                return redirect()->route('category.index')->with('error', $validate->errors()->first());
            }

            Category::where('id', $category_id)->update(['iStatus' => $status]);

            return redirect()->route('category.index')->with('success', 'Status Updated Successfully!');
        } catch (\Throwable $e) {
            Log::error("Category updateStatus error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update status.');
        }
    }
}
