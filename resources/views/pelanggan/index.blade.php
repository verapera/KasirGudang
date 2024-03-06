@extends('home')
@section('content')
@section('title','Pelanggan')
<div class="card">
    <div class="card-body">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        + Pelanggan
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form tambah pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addpelanggan') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="" class="form-label">Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukan nama pelanggan..." required>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" placeholder="Masukan alamat..." required>
                            </div>
                        </div>
                        <div class="">
                            <label for="" class="form-label">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" class="form-control" placeholder="Masukan nomor telepon..." required>
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
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                   </tr>
              </thead>
              <tbody>
                @forelse ($pelanggan as $item)
                   <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_pelanggan }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->nomor_telepon }}</td>
                   <td>
                    <form  onsubmit="return confirm('Yakin ingin menghapus data ini?')" action="{{ route('deletepelanggan',$item->pelanggan_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button  class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
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