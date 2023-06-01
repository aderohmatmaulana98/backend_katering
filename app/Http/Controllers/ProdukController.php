<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB as DB;

class ProdukController extends Controller
{
    public function index()
    {
        return Produk::all();
    }

    public function create(Request $request)
    {
        $data = $request->only(
            'namaProduk',
            'harga',
            'gambar',
            'stok',
            'keterangan',
            'idPaket'
        );

        $validator = Validator::make($data,[
            'namaProduk' => 'required',
            'harga' => 'required',
            'gambar' => 'required',
            'stok' => 'required',
            'keterangan' => 'required',
            'idPaket' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }

        $nameFile = $request->file('gambar')->getClientOriginalName();
        $path = $request->file('gambar')->storeAs('images', $nameFile, 'public');

        $produk = Produk::create([
            'nama_produk' => $request->namaProduk,
            'harga' => $request->harga,
            'gambar' => asset("/storage/".$path),
            'stok' => $request->stok,
            'keterangan' => $request->keterangan,
            'id_paket' => $request->idPaket
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'produk created',
            'data' => $produk
        ], Response::HTTP_OK);
    }

    public function getProdukByPaketId(Request $request, $id)
    {   
        $produk = DB::table('produk')
            ->where('id_paket', '=', $id)
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'produk updated',
            'data' => $produk
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(
            'namaProduk',
            'harga',
            'gambar',
            'stok',
            'keterangan',
            'idPaket'
        );

        Produk::findOrFail($id)->delete();

        $validator = Validator::make($data,[
            'namaProduk' => 'required',
            'harga' => 'required',
            'gambar' => 'required',
            'stok' => 'required',
            'keterangan' => 'required',
            'idPaket' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->messages()
            ]);
        }

        $nameFile = $request->file('gambar')->getClientOriginalName();
        $path = $request->file('gambar')->storeAs('images', $nameFile, 'public');

        $produk = Produk::create([
            'nama_produk' => $request->namaProduk,
            'harga' => $request->harga,
            'gambar' => asset("/storage/".$path),
            'stok' => $request->stok,
            'keterangan' => $request->keterangan,
            'id_paket' => $request->idPaket
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'produk created',
            'data' => $produk
        ], Response::HTTP_OK);

        return response()->json([
            'status' => 'success',
            'message' => 'produk updated',
            'data' => $request->all()
        ], Response::HTTP_OK);
    }

    public function delete($id)
    {
        Produk::findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => "produk with id $id deleted",
        ], Response::HTTP_OK);
    }
}
