<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $datas = Banner::orderBy('banner.bannerId', 'desc')
                ->where(['banner.iStatus' => 1, 'banner.isDelete' => 0])
                ->paginate(config('app.per_page', 10));

            return view('admin.banner.index', compact('datas'));
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error fetching banners: ' . $e->getMessage());
            // Optionally, handle the exception gracefully with a custom message
            return back()->with('error', 'Error fetching banners. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'strPhoto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $img = "";
            if ($request->hasFile('strPhoto')) {
                $image = $request->file('strPhoto');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(FolderPath('uploads/banner'), $imageName);
                $img = $imageName;
            }

            Banner::create([
                'strPhoto' => $img,
                'created_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip()
            ]);
            return back()->with('success', 'Banner Uploaded Successfully.');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error uploading banner: ' . $e->getMessage());
            // Optionally, handle the exception gracefully with a custom message
            return back()->with('error', 'Error uploading banner. Please try again.');
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete = Banner::where(['iStatus' => 1, 'isDelete' => 0, 'bannerId' => $request->bannerId])->first();
            $destinationpath = FolderPath('uploads/banner/');

            if ($delete->strPhoto && file_exists($destinationpath . $delete->strPhoto)) {
                unlink($destinationpath  . $delete->strPhoto);
            }

            Banner::where(['iStatus' => 1, 'isDelete' => 0, 'bannerId' => $request->bannerId])->delete();

            return back()->with('success', 'Banner Deleted Successfully!.');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error deleting banner: ' . $e->getMessage());
            // Optionally, handle the exception gracefully with a custom message
            return back()->with('error', 'Error deleting banner. Please try again.');
        }
    }
}
