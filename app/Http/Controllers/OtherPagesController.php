<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherPages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OtherPagesController extends Controller
{
    public function index(Request $request)
    {

        $Setting = OtherPages::orderBy('id', 'desc')->paginate(10);

        return view('admin.setting.otherpages', compact('Setting'));
    }


    public function editview(Request $request, $id)
    {
        $data = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'pagename' => $request->pagename,
                'slugname' => Str::slug($request->pagename),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'head' => $request->head,
                'body' => $request->body,
                'description' => $request->description,
                'updated_at' => now(),
                'strIP' => $request->ip(),
            ]);

        return  back()->with('success', 'Updated Successfully.');
    }

    public function viewdetail($id)
    {
        $data = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }
}
