@extends('home')
@section('content')
@section('title','Pelanggan')
<div class="card">
    <div class="card-body">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            + Pilih Pelanggan
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive text-nowrap">
                            <h6 class="mb-3 mt-3">Daftar pelanggan</h6>
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
                                        <a href="{{ route('transaksi',$item->pelanggan_id) }}" class="btn btn-warning">Pilih</a>
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
                </div>
            </div>
            <div class="table-responsive text-nowrap ml-3 mr-3">
                <h6 class="mb-3 mt-4">Daftar produk</h6>
                  <table class="table table-stripped">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penjualan</th>
                        <th>Nama Pelanggan</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                       </tr>
                  </thead>
                  <tbody>
                    @forelse ($penjualan as $item)
                       <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_penjualan }}</td>
                        <td>{{ $item->pelanggans->nama_pelanggan }}</td>
                        <td>{{ rupiah($item->total_harga) }}</td>
                        <td>
                            <a href="{{ route('invoice',$item->kode_penjualan )}}" class="btn btn-primary">Cek</a>
                        </td>
                       </tr>
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
                </tbody>
            </table>
            </div>
    </div>
</div>
@endsection