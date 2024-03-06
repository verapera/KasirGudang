@extends('home')
@section('content')
@section('title','Transaksi')
<div class="row ">
    <div class="card col-md-4 mr-5 ml-4">
        <div class="card-body">
           <form action="{{ route('tambahkeranjang',$pelanggan_id) }}" method="POST">
            @csrf
            <h4>#{{ $nota }}</h4>
            <input type="hidden" name="pelanggan_id" class="form-control" value="{{ $pelanggan_id }}" readonly>
            <div class="mt-3">
                <label for="" class="form-label">Nota</label>
                <input  name="kode_penjualan" class="form-control" value="{{ $nota }}" readonly>
            </div>
            <div class="mt-3">
                <label for="" class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" class="form-control" value="{{ $pelanggan->nama_pelanggan }}" readonly>
            </div>
            <div class="mt-3">
                <label for="" class="form-label">Produk</label>
                <select name="produk_id" id="" class="form-control">
                        @foreach ($produk as $item)
                        <option value="{{ $item->produk_id }}">{{ $item->nama_produk }} - {{ $item->harga }} ({{ $item->stok  }})</option>
                        @endforeach
                    </select>
            </div>
            <div class="mt-3">
                <label for="" class="form-label">Jumlah produk</label>
                <input type="number" name="jumlah_produk" class="form-control" placeholder="Masukan jumlah produk..." required>
            </div>
            <button class="btn btn-primary mt-3">Tambah keranjang</button>
           </form>
        </div>
    </div>
    <div class="card col-md-7">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <h6 class="mb-3 mt-3">Daftar produk</h6>
                  <table class="table table-stripped">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
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
                        <td>{{ $item->harga }}</td>
                        <td>{{ $item->harga * $item->jumlah_produk }}</td>
                        <td>
                            <form action="{{ route('deletekeranjang',$item->detail_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button  class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                       </tr>
                    <?php $total += $item->harga * $item->jumlah_produk?>
                    @empty
                    <div class="alert alert-danger col-md-12">
                        Keranjang masih kosong
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
                        <td>Total Harga : </td>
                        <td >{{ $total }}</td>
                    </tr>
                </tbody>
                </table>
                <form action="{{ route('bayar',$nota) }}" method="POST">
                    @csrf
                    <label for="" class="form-label">Nominal :</label>
                    <input type="number" class="form-control mb-3 col-md-4" name="pembayaran" placeholder="Nominal pembayaran...">
                    <input type="hidden" name="pelanggan_id" value="{{ $pelanggan_id }}">
                    <input type="hidden" name="kode_penjualan" value="{{ $nota }}">
                    <input type="hidden" name="total_harga" value="{{ $total }}">
                    <button class="btn btn-primary col-md-4 mb-3" type="submit">Bayar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection