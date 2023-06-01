<?php

namespace App\Http\Controllers;

use App\Models\status_pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class StatusPemesananController extends Controller
{
    public function index()
    {
        return status_pemesanan::all();
    }

    public function create(Request $request)
    {
        $data = $request->only(
            'namaStatus',
        );

        $validator = Validator::make($data,[
            'namaStatus' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }


        $status = status_pemesanan::create([
            'nama_status' => $request->namaStatus,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'status pemesanan created',
            'data' => $status
        ], Response::HTTP_OK);
    }
    
    public function update(Request $request, $id)
    {
        $data = $request->only(
            'namaStatus',
        );

        $paket = status_pemesanan::findOrFail($id);
        $paket->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'status pemesanan updated',
            'data' => $request->all()
        ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        status_pemesanan::findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => "status pemesanan with id $id deleted",
        ], Response::HTTP_OK);
    }
    
}
