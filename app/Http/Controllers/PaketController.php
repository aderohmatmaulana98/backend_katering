<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PaketController extends Controller
{
    public function index()
    {
        return Paket::all();
    }

    public function create(Request $request)
    {
        $data = $request->only(
            'namaPaket',
            'harga'
        );

        $validator = Validator::make($data, [
            'namaPaket' => 'required',
            'harga' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }

        $paket = Paket::create([
            'nama_paket' => $request->namaPaket,
            'harga' => $request->harga
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'paket created',
            'data' => $paket
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(
            'namaPaket',
            'harga'
        );

        $paket = Paket::findOrFail($id);
        $paket->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'paket updated',
            'data' => $request->all()
        ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        Paket::findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => "paket with id $id deleted",
        ], Response::HTTP_OK);
    }
}
