<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        try {
            $Offer = Offer::orderBy('id', 'desc')->paginate(config('app.per_page', 10));

            return view('admin.offer.index', compact('Offer'));
        } catch (\Throwable $th) {
            Log::error('Offer index error: ' . $th->getMessage());
            return back()->with('error', 'Failed to load offers.');
        }
    }

    public function create(Request $request)
    {
        try {

            return view('admin.offer.add');
        } catch (\Throwable $th) {
            Log::error('Offer create error: ' . $th->getMessage());
            return back()->with('error', 'Failed to load offers.');
        }
    }

    public function store(Request $request)
    {
        // dd($request);
        try {

            $img = "";
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(FolderPath('/uploads/offer'), $imageName);
                $img = $imageName;
            }

            $Data = array(
                'text' => $request->text,
                'percentage' => $request->percentage,
                'offercode' => $request->offercode,
                'minvalue' => $request->minvalue,
                'startdate' => date('Y-m-d', strtotime($request->fromdate)),
                'enddate' => date('Y-m-d', strtotime($request->todate)),
                'photo' => $img ?? null,
                'created_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip()
            );
            Offer::create($Data);

            return redirect()->route('offer.index')->with('success', 'Offer Created Successfully.');
        } catch (\Throwable $th) {
            Log::error('Offer store error: ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to create offer.');
        }
    }

    public function editview(Request $request, $id)
    {
        try {
            $data = Offer::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

            $getData = array(
                'id'    => $data->id,
                'text'    => $data->text,
                'photo'    => $data->photo,
                'percentage' => $data->percentage,
                'offercode' => $data->offercode,
                'minvalue' => $data->minvalue,
                'startdate' => date('d-m-Y', strtotime($data->startdate)),
                'enddate' => date('d-m-Y', strtotime($data->enddate))
            );
            // dd($getData);
            // echo json_encode($getData);
            return view('admin.offer.edit', compact('getData'));
        } catch (\Throwable $th) {
            Log::error('Offer editview error: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to load offer data.'], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $offer = Offer::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->offerId])->firstOrFail();

            $img = $offer->photo;

            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $destinationPath = FolderPath('/uploads/offer');

                // Ensure folder exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $imageName);
                $img = $imageName;

                // Delete old image if exists
                $oldImagePath = $destinationPath . '/' . $offer->photo;
                if ($offer->photo && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $offer->update([
                'text' => $request->text,
                'percentage' => $request->percentage,
                'offercode' => $request->offercode,
                'minvalue' => $request->minvalue,
                'startdate' => date('Y-m-d', strtotime($request->fromdate)),
                'enddate' => date('Y-m-d', strtotime($request->todate)),
                'photo' => $img ?? null,
                'updated_at' => now()
            ]);

            return redirect()->route('offer.index')->with('success', 'Offer Updated Successfully.');
        } catch (\Throwable $th) {
            Log::error('Offer update error: ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to update offer.');
        }
    }


    public function delete(Request $request)
    {
        try {
            $offer = Offer::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->firstOrFail();

            $imagePath = FolderPath('/uploads/offer') . '/' . $offer->photo;

            if ($offer->photo && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $offer->delete();

            return back()->with('success', 'Offer Deleted Successfully!');
        } catch (\Throwable $th) {
            Log::error('Offer delete error: ' . $th->getMessage());
            return back()->with('error', 'Failed to delete offer.');
        }
    }
}
