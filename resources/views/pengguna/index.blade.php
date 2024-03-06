@extends('home')
@section('content')
@section('title','Pengguna')
<div class="card">
    <div class="card-body">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        + Pengguna
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form tambah pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addpengguna') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukan name..." required>
                            </div>
                            <div class="col">
                                <label for="" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukan username..." required>
                            </div>
                        </div>
                        <div class="">
                            <label for="" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukan password..." required>
                        </div>
                        <div class="">
                            <label for="" class="form-label">Level</label>
                            <select name="level" id="" class="form-control">
                              <option value="Administrator">Administrator</option>
                              <option value="Petugas">Petugas</option>
                            </select>
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
                    <th>Name</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Aksi</th>
                   </tr>
              </thead>
              <tbody>
                @forelse ($pengguna as $item)
                   <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->level }}</td>
                   <td>
                    <form  onsubmit="return confirm('Yakin ingin menghapus data ini?')" action="{{ route('deletepengguna',$item->id) }}" method="POST">
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