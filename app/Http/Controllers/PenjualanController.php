<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    //
    public function index(){
        $tanggal = Carbon::now()->format('y-m-d');
        $penjualan = Penjualan::with('pelanggans')
                    ->where('tanggal_penjualan', $tanggal)
                    ->orderBy('tanggal_penjualan','DESC')
                    ->get();
        $pelanggan = Pelanggan::all();
        return view('penjualan.index')->with(compact('penjualan','pelanggan'));
    }
    public function transaksi($pelanggan_id){
        $pelanggan = Pelanggan::findOrFail($pelanggan_id);
        $produk    = Produk::where('stok','>',0)->orderBy('nama_produk','ASC')->get();
        $tanggal   = Carbon::now()->format('Y-m');
        $jumlah    = Penjualan::whereRaw("DATE_FORMAT(tanggal_penjualan,'%Y-%m')=?",[$tanggal])->count();
        $nota      = date('ymd').($jumlah+1);
 
        $detail    = DB::table('detail_penjualans as a')
                    ->leftJoin('produks as b', 'a.produk_id', '=','b.produk_id')
                    ->where('kode_penjualan',$nota)
                    ->where('pelanggan_id',$pelanggan_id)
                    ->get();
        $data      = [
            'pelanggan_id' => $pelanggan_id, 
            'produk'       => $produk, 
            'nota'         => $nota, 
            'detail'       => $detail, 
            'pelanggan'    => $pelanggan, 
        ];
        return view('penjualan.transaksi',$data);
    }
    public function tambahkeranjang(Request $request, $pelanggan_id){
        $produk = Produk::where('produk_id',$request->produk_id)->first();
        $harga  = $produk->harga;
        $stok_lama  = $produk->stok;
        $stok_sekarang  = $stok_lama - $request->jumlah_produk;
        $subtotal  = $harga * $request->jumlah_produk;

        $data = [
            'kode_penjualan' => $request->kode_penjualan,
            'produk_id' => $request->produk_id,
            'jumlah_produk' => $request->jumlah_produk,
            'subtotal' => $subtotal, 
            'pelanggan_id' => $pelanggan_id,
        ];
        // dd($subtotal);
        if($stok_lama >= $request->jumlah_produk){
            DetailPenjualan::create($data);
            Produk::where('produk_id',$request->produk_id)
                    ->update(['stok'=>$stok_sekarang]);
            $penjualan = Penjualan::with('detail_penjualans')
                        ->where('pelanggan_id',$pelanggan_id)
                        ->get();
            return redirect()->back()->with(compact('penjualan'))->with('success', 'Data produk berhasil ditambah keranjang!');
        }else{
            return redirect()->back()->with('error', 'Stok terbatas!');

        }

    }
    public function bayar(Request $request, $kode_penjualan){
        $validator = Validator::make($request->all(), [
            'pembayaran' => 'required|numeric|min:' . $request->total_harga,
        ]);
        
        if($validator->fails()){
            return back()
            ->withErrors($validator)
            ->with('error','Pembayaran tidak cukup!')
            ->withInput();
        }
        Penjualan::create([
            'kode_penjualan' => $request->kode_penjualan,
            'tanggal_penjualan' => Carbon::now()->format('y-m-d'),
            'pembayaran' => $request->pembayaran,
            'total_harga' => $request->total_harga,
            'pelanggan_id' => $request->pelanggan_id,
        ]);
        return redirect()->route('invoice',$kode_penjualan)->with('success', 'Penjualan berhasil!');
    }
    public function invoice($kode_penjualan){
        $penjualan = DB::table('penjualans as a')
                    ->leftJoin('pelanggans as b', 'a.pelanggan_id','=','b.pelanggan_id')
                    ->where('a.kode_penjualan',$kode_penjualan)
                    ->orderBy('tanggal_penjualan','DESC')
                    ->first();


        $detail     = DB::table('detail_penjualans as a')
                    ->leftJoin('produks as b', 'a.produk_id', '=','b.produk_id')
                    ->where('kode_penjualan',$kode_penjualan)
                    ->get();
        $data = [
            'penjualan'  =>$penjualan,
            'detail'     =>$detail,
            'nota'       =>$kode_penjualan,
        ];
        return view('penjualan.invoice',$data);
    }
    public function deletekeranjang($detail_id)
    {
        $detail_penjualan = DetailPenjualan::findOrFail($detail_id);
        $produk = Produk::findOrFail($detail_penjualan->produk_id);
        $produk->increment('stok', $detail_penjualan->jumlah_produk);
        $detail_penjualan->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang');
       
    }
    public function report($kode_penjualan) {
        $penjualan = DB::table('penjualans as a')
        ->leftJoin('pelanggans as b', 'a.pelanggan_id','=','b.pelanggan_id')
        ->where('a.kode_penjualan',$kode_penjualan)
        ->orderBy('tanggal_penjualan','DESC')
        ->first();
        
        
        $detail     = DB::table('detail_penjualans as a')
        ->leftJoin('produks as b', 'a.produk_id', '=','b.produk_id')
        ->where('kode_penjualan',$kode_penjualan)
        ->get();
        
        TCPDF::SetTitle('Invoice | '.$penjualan->kode_penjualan); 
        TCPDF::AddPage(); 
        TCPDF::SetFont('helvetica', 'B', 12);
        TCPDF::Cell(0, 10, '                    Toserba Sanjaya', 0, 1, 'L');
        
        
        TCPDF::SetFont('helvetica', '', 10);
        TCPDF::Cell(0, 10, '                                   Pusat' ,0, 1, 'L'); 
        TCPDF::Cell(0, 10, 'Jl . Lawu Simpanglima, Lampu merah, Bejen, Kra ' ,0, 1, 'L'); 
        TCPDF::Cell(0, 10, '           HP. 089672284196 / 087654228109 ' ,0, 1, 'L'); 
        TCPDF::Cell(0, 10, '======================================', 0, 1, 'L');

        TCPDF::Cell(0, 7, $penjualan->tanggal_penjualan .'                                             #'.$penjualan->kode_penjualan, 0, 1, 'L');
        TCPDF::Cell(0, 7, 'User            : ' . auth()->user()->username, 0, 1, 'L');
        TCPDF::Cell(0, 7, 'Pelanggan  : ' . $penjualan->nama_pelanggan, 0, 1, 'L');


        TCPDF::Cell(0,  5, '-------------------------------------------------------------------' , 0, 1, 'L');
        TCPDF::Cell(10, 7, 'No', 0, 0, 'L');
        TCPDF::Cell(20, 7, 'Kd Brg', 0, 0, 'L'); 
        TCPDF::Cell(10, 7, 'Qty', 0, 0, 'L'); 
        TCPDF::Cell(25, 7, 'Harga', 0, 0, 'L'); 
        TCPDF::Cell(30, 7, 'Subtotal', 0, 0, 'L');
        TCPDF::Cell(0,  7, '', 0, 1, 'L');
        TCPDF::Cell(0,  7, '-------------------------------------------------------------------' , 0, 1, 'L');

        $no = 1;
        foreach ($detail as $detail) {
            TCPDF::Cell(10, 7, $no++, 0, 0, 'L');
            TCPDF::Cell(20, 7, $detail->kode_produk, 0, 0, 'L'); 
            TCPDF::Cell(10, 7, $detail->jumlah_produk, 0, 0, 'L'); 
            TCPDF::Cell(25, 7, $detail->harga, 0, 0, 'L'); 
            TCPDF::Cell(30, 7, $detail->harga * $detail->jumlah_produk, 0, 0, 'L');
            TCPDF::Cell(0, 7, '', 0, 1, 'L'); 
            TCPDF::Cell(0, 7, 'Brg  : ' . $detail->nama_produk, 0, 1, 'L');
        }
        TCPDF::Cell(0, 0, '', 0, 1, 'L'); 
        TCPDF::Cell(0, 7, '======================================', 0, 1, 'L');
        TCPDF::Cell(0, 7, 'Total      :  Rp. ' . number_format($penjualan->total_harga), 0, 1, 'L');
        TCPDF::Cell(0, 7, 'Bayar     :  Rp. ' .number_format($penjualan->pembayaran), 0, 1, 'L');
        TCPDF::Cell(0, 7, 'Kembali  :  Rp. ' . number_format($penjualan->pembayaran - $penjualan->total_harga), 0, 1, 'L');

        TCPDF::Output('invoice.pdf', 'I');
    }
}
