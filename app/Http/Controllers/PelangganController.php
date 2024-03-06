<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    //
    public function index(){
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index')->with(compact('pelanggan'));
    }
    public function create(Request $request){
        Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
        ]);
        return redirect()->route('pelanggan')->with('success', 'Data pelanggan berhasil ditambahkan!');
    }
    public function delete($pelanggan_id){
        $pelanggan = Pelanggan::findOrFail($pelanggan_id);
        $pelanggan->delete();
        return redirect()->route('pelanggan')->with('error', 'Data pelanggan berhasil dihapus!');
    }
}
