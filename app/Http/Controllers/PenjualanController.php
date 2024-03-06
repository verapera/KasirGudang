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
        TCPDF::SetTitle('Struk Pembayaran Kasir Sanjaya '); 
        TCPDF::AddPage(); 
        TCPDF::SetFont('helvetica', 'B', 12);
        TCPDF::Cell(0, 10, 'Struk Pembayaran Kasir Sanjaya', 0, 1, 'L');
        
        $penjualan = DB::table('penjualans as a')
                    ->leftJoin('pelanggans as b', 'a.pelanggan_id','=','b.pelanggan_id')
                    ->where('a.kode_penjualan',$kode_penjualan)
                    ->orderBy('tanggal_penjualan','DESC')
                    ->first();


        $detail     = DB::table('detail_penjualans as a')
                    ->leftJoin('produks as b', 'a.produk_id', '=','b.produk_id')
                    ->where('kode_penjualan',$kode_penjualan)
                    ->get();
       
        
        TCPDF::SetFont('helvetica', '', 10);
        TCPDF::Cell(0, 14, '# ' . $penjualan->kode_penjualan, 0, 1, 'L'); 
        TCPDF::Cell(0, 10, 'Kasir: Sanjaya | ' . $penjualan->tanggal_penjualan, 0, 1, 'L');
        TCPDF::Cell(0, 10, '=============================', 0, 1, 'L');
        
        foreach ($detail as $index => $item) {
            TCPDF::Cell(0, 10, 'Kode Produk: ' . $item->kode_penjualan, 0, 1, 'L');
            TCPDF::Cell(0, 10, 'Nama Produk: ' . $item->nama_produk, 0, 1, 'L');
            TCPDF::Cell(0, 10, 'Harga: ' . $item->harga, 0, 1, 'L');
            TCPDF::Cell(0, 10, 'Jumlah: ' . $item->jumlah_produk, 0, 1, 'L');
            TCPDF::Cell(0, 10, 'Subtotal: ' . $item->jumlah_produk * $item->harga, 0, 1, 'L');
            TCPDF::Cell(0, 10, '-------------------------------------------------', 0, 1, 'L');
        }
        
        TCPDF::Cell(0, 10, 'Total Harga: ' . $penjualan->total_harga, 0, 1, 'L');
        TCPDF::Cell(0, 10, 'Nominal Pembayaran: ' .$penjualan->pembayaran, 0, 1, 'L');
        TCPDF::Cell(0, 10, 'Kembalian: ' . $penjualan->pembayaran - $penjualan->total_harga, 0, 1, 'L');
        
        TCPDF::Output('invoice.pdf', 'I');
    }
}
