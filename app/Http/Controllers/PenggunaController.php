<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    //
    public function index(){
        $pengguna = User::orderBy('created_at','DESC')->get();
        return view('pengguna.index')->with(compact('pengguna'));
    }
    public function create(Request $request){
        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'level'    => $request->level,
        ]);
        return redirect()->route('pengguna')->with('success', 'Data pengguna berhasil ditambahkan!');
    }
    public function delete($id){
        $pengguna = User::findOrFail($id);
        $pengguna->delete();
        return redirect()->route('pengguna')->with('error', 'Data pengguna berhasil dihapus!');
    }
}
