<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $Courier = Courier::orderBy('id', 'desc')->paginate(10);
        return view('admin.courier.index', compact('Courier'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:courier',
            'url' => 'required',
        ]);

        $Data = array(
            'name' => $request->name,
            'url' => $request->url,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        DB::table('courier')->insert($Data);
        return back()->with('success', 'Courier Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $data = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();
        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => 'required|unique:courier,name,' . $id . ',id',
            'url' => 'required',
        ]);

        $update = DB::table('courier')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'name' => $request->name,
                'url' => $request->url,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        return back()->with('success', 'Courier Updated Successfully.');
    }


    public function delete(Request $request)
    {
        // dd($request);
        DB::table('courier')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
        return back()->with('success', 'Courier Deleted Successfully!.');
    }

    public function validatename(Request $request)
    {
        $data = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'name' => $request->courier])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function validateeditname(Request $request)
    {
        $data = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'name' => $request->editcourier])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
