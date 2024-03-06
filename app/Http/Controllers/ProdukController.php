<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    //
    public function index(){
        $produk = Produk::all();
        return view('produk.index')->with(compact('produk'));
    }
    public function create(Request $request){
        
        Produk::create([
            'kode_produk' => Produk::kodeproduk(),
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
        ]);
        return redirect()->route('produk')->with('success', 'Data produk berhasil ditambahkan!');
    }
    public function delete($produk_id){
        $produk = Produk::findOrFail($produk_id);
        $produk->delete();
        return redirect()->route('produk')->with('error', 'Data produk berhasil dihapus!');
    }
    public function showupdate($produk_id){
        $produk = Produk::findOrFail($produk_id);
       return view('produk.update')->with(compact('produk'));
    }
    public function update( Request $request, $produk_id){
        $produk = Produk::findOrFail($produk_id);
        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);
        return redirect()->route('produk')->with('success', 'Data produk berhasil diupdate!');
    }
}
