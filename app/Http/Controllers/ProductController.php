<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(){
        $produk = Produk::all();
        return response()->json($produk);
    }

    public function show($id){
        $produk = Produk::find($id);
        if(!$produk){
            return response()->json(['message' => 'produkss not found'], 404);
        }
        return response()->json($produk);
    }

    public function create(Request $request){

        $this->validate($request, [
           'nama' => 'required|string',
            'harga' => 'required|integer',
            'warna' => 'required|string',
            'kondisi' => 'required|in:baru, lama',
            'deskripsi' => 'string'
        ]);
        $data = $request->all();
        $product = Produk::create($data);

        return response()->json($product);
    }

    public function update(Request $request, $id){
        $produk = Produk::find($id);
        if(!$produk){
            return response()->json(['message' => 'Produk not found'], 404);
        }
        $this->validate($request, [
            'nama' => 'string',
            'harga' => 'integer',
            'warna' => 'string',
            'kondisi' => 'in:baru, lama',
            'deskripsi' => 'string'
        ]);
        $data = $request->all();

        $produk->fill($data);

        $produk->save();
        return response()->json($produk);
    }

    public function destroy($id){
        $produk = Produk::find($id);
        if(!$produk){
            return response()->json(['message' => 'Produk not found'], 404);
        }

        $produk->delete();
        return response()->json(['message' => 'Product deleted']);
    }



    //
}
