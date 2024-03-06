@extends('home')
@section('content')
@section('title','Dashboard')
@php
    $tanggal_sekarang = now()->format('y-m-d'); 
    $produk = \App\Models\Produk::count('produk_id');
    $bulan_ini = \App\Models\DetailPenjualan::whereYear('created_at', '=', now()->year) 
                         ->whereMonth('created_at', '=', now()->month) 
                         ->sum('jumlah_produk'); 
    $total = \App\Models\Penjualan::whereYear('created_at', '=', now()->year) 
                         ->whereMonth('created_at', '=', now()->month) 
                         ->sum('total_harga'); 
@endphp


<section class="section">
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card card-statistic-2">
        <div class="card-icon shadow-primary bg-primary">
          <i class="fas fa-archive"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Data Produk</h4>
          </div>
          <div class="card-body">
            {{ $produk }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card card-statistic-2">
        <div class="card-icon shadow-primary bg-primary">
          <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Penjualan Produk  Bulan ini</h4>
          </div>
          <div class="card-body">
           {{$bulan_ini}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card card-statistic-2">
        <div class="card-icon shadow-primary bg-primary">
          <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Penjualan Bulan ini</h4>
          </div>
          <div class="card-body">
           {{rupiah($total)}}
          </div>
        </div>
      </div>
    </div>
  </div> 
  <div class="card col-md-12">
    <div class="card-body d-flex align-items-center">
      <div class="mr-5 ">
        <h5>Congratulations {{ auth()->user()->name }} !!</h5>
        <p>Sekarang anda login sebagai <span class="bold">{{ auth()->user()->level }}</span>, for more information check your profile! </p>
      </div>
      <div class="ml-5">
        <img src="assets/img/work.png" width="250px">
      </div>
    </div>
</div>

</section>
@endsection