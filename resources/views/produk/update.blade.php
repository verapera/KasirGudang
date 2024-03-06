@extends('home')
@section('content')
@section('title','Update Produk')

<div class="card col-md-8">
    <div class="card-body">
        <h6 class="mb-3">Form update produk</h6>
        <form action="{{ route('processupdate',$produk->produk_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="input-group flex-nowrap">
                <span class="input-group-text">Kode Produk</span>
                <input type="text" class="form-control" name="kode_produk" value="{{ old('kode_produk',$produk->kode_produk) }}">
            </div>
            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text">Nama Produk</span>
                <input type="text" class="form-control" name="nama_produk" value="{{ old('nama_produk',$produk->nama_produk) }}">
            </div>
            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text">Harga</span>
                <input type="number" class="form-control" name="harga" value="{{ old('harga',$produk->harga) }}">
            </div>
            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text">Stok</span>
                <input type="number" class="form-control"  name="stok"value="{{ old('stok',$produk->stok) }}">
            </div>
            <button class="btn btn-primary mt-3" type="submit">Update</button>
        </form>
    </div>
</div>

@endsection