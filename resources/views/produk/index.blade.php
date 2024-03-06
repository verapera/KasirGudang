@extends('home')
@section('content')
@section('title','Produk')
<div class="card">
    <div class="card-body">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        + Produk
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form tambah produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addproduk') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="" class="form-label">Kode produk</label>
                                <input type="text" class="form-control" name="kode_produk"  value="{{ old('kode_produk', \App\Models\Produk::kodeproduk()) }}" readonly>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Nama produk</label>
                                <input type="text" name="nama_produk" class="form-control" placeholder="Masukan nama produk..." required>
                            </div>
                        </div>
                        <div class="">
                            <label for="" class="form-label">Harga produk</label>
                            <input type="number" name="harga" class="form-control" placeholder="Masukan harga produk..." required>
                        </div>
                        <div class="">
                            <label for="" class="form-label">Stok produk</label>
                            <input type="number" name="stok" class="form-control" placeholder="Masukan stok produk..." required>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <h6 class="mb-3 mt-3">Daftar produk</h6>
              <table class="table table-stripped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga Produk</th>
                    <th>Stok Produk</th>
                    <th>Aksi</th>
                   </tr>
              </thead>
              <tbody>
                @forelse ($produk as $item)
                   <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_produk }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{rupiah( $item->harga) }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>
                        <form  onsubmit="return confirm('Yakin ingin menghapus data ini?')" action="{{ route('deleteproduk',$item->produk_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button  class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                            <a href="{{ route('update',$item->produk_id) }}" class="btn btn-info"><i class="fas fa-pencil-alt"></i></a>
                        </form>
                    </td>
                   </tr>
                   @empty
                   <div class="alert alert-danger">
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
              </tbody>
              </table>
            </div>
    </div>
</div>
   
@endsection