<?php

namespace App\Http\Controllers;

use App\Models\HistoriPemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class HistoriPemesananController extends Controller
{
    public function index()
    {
        return HistoriPemesanan::all();
    }

    public function create(Request $request)
    {
        $data = $request->only(
            'idPemesanan',
        );

        $messages = [
            "username.required" => "idPemesanan is required",
            "username.exists" => "idPemesanan doesn't exists"
       ];

        $validator = Validator::make($data,[
            'idPemesanan' => 'required|integer|exists:pemesanan,id',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()->first(),
            ], 400);
        }


        $status = HistoriPemesanan::create([
            'id_pemesanan' => $request->idPemesanan,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'history pemesanan created',
            'data' => $status
        ], Response::HTTP_OK);
    }
    
    public function update(Request $request, $id)
    {
        $data = $request->only(
            'idPemesanan',
        );

        $history = HistoriPemesanan::findOrFail($id);
        $history->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'history pemesanan updated',
            'data' => $request->all()
        ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        HistoriPemesanan::findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => "history pemesanan with id $id deleted",
        ], Response::HTTP_OK);
    }
}
