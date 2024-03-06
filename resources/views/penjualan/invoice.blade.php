@extends('home')
@section('content')
@section('title','Invoice')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <h6>From :</h6> 
                <strong>SANJAYA</strong><br>
                Jl. Mangkunegara, 106, Surakarta <br>
                089672284197 <br>
                sanjaya@gmail.com <br>
            </div>
            <div class="col-md-4">
                <h6>To :</h6>
                <strong>{{ $penjualan->nama_pelanggan }}</strong><br>
                {{ $penjualan->alamat }}<br>
                {{ $penjualan->nomor_telepon }} <br>
                {{ $penjualan->tanggal_penjualan}}
            </div>
            <div class="col-md-4 ">
                <h3 class="mt-5">#{{ $nota }}</h3> <br>
            </div>

            <div class="table-responsive text-nowrap ml-3 mr-3">
                <h6 class="mb-3 mt-4">Daftar produk</h6>
                  <table class="table table-stripped">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                       </tr>
                  </thead>
                  <tbody>
                    <?php $total=0; ?>
                    @forelse ($detail as $item)
                       <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_produk }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->jumlah_produk }}</td>
                        <td>{{ rupiah($item->harga) }}</td>
                        <td>{{ rupiah($item->harga * $item->jumlah_produk) }}</td>
                       </tr>
                    <?php $total += $item->harga * $item->jumlah_produk?>
                    @empty
                    <div class="alert alert-danger col-md-12">
                        Data Belum Tersedia
                    </div>
                    @endforelse
                  
                    @if (session('success'))
                        <div class="alert alert-primary">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                        
                    @endif
                    <tr>
                        <td>Nominal  : </td>
                        <td >{{ rupiah($penjualan->pembayaran) }}</td>
                    </tr>
                    <tr>
                        <td>Total  : </td>
                        <td >{{ rupiah($total) }}</td>
                    </tr>
                    <tr>
                        <td>Kembalian : </td>
                        <td >{{rupiah( $penjualan->pembayaran - $total) }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-primary" href="{{ route('penjualan') }}">Back</a>
            <a class="btn btn-danger" href="{{ route('report', $penjualan->kode_penjualan) }}"><i class="bx bxs-printer"></i> Cetak</a>
            </div>

        </div>
    </div>
</div>
@endsection