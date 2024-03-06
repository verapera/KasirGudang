<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Kasir | @yield('title')</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="/assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="/assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="/assets/modules/owlcarousel2/dist//assets/owl.carousel.min.css">
  <link rel="stylesheet" href="/assets/modules/owlcarousel2/dist//assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block"></div>{{ auth()->user()->username }}</a>
            <div class="dropdown-menu dropdown-menu-right">
             
              <div class="dropdown-divider"></div>
              <a href="/" class="dropdown-item has-icon">
                <i class="far fa-user"></i> {{ auth()->user()->level }}
              </a>
              <a href="/logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="/">Sanjaya</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="/">SJ</a>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class="dropdown {{ Request::is('/') ? 'active' : '' }}">
                    <a href="/" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Menu</li>
                <li class="dropdown {{ Request::is('produk*') ? 'active' : '' }}">
                    <a href="/produk" class="nav-link"><i class="fas fa-columns"></i><span>Produk</span></a>
                </li>
                <li class="dropdown {{ Request::is('pelanggan*') ? 'active' : '' }}">
                    <a href="/pelanggan" class="nav-link"><i class="fas fa-users"></i><span>Pelanggan</span></a>
                </li>
                <li class="dropdown {{ Request::is('penjualan*') ? 'active' : '' }}">
                    <a href="/penjualan" class="nav-link"><i class="fas fa-shopping-cart"></i><span>Penjualan</span></a>
                </li>
                @if (auth()->check() && auth()->user()->level == 'Administrator')
                <li class="menu-header">Pages</li>
                <li class="dropdown {{ Request::is('pengguna*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i><span>Auth</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/pengguna" class="nav-link">Pengguna</a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </aside>
    </div>

      <!-- Main Content -->
      <div class="main-content">
      
            @yield('content')
      </div>
   
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="/assets/modules/jquery.min.js"></script>
  <script src="/assets/modules/popper.js"></script>
  <script src="/assets/modules/tooltip.js"></script>
  <script src="/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="/assets/modules/moment.min.js"></script>
  <script src="/assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="/assets/modules/jquery.sparkline.min.js"></script>
  <script src="/assets/modules/chart.min.js"></script>
  <script src="/assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
  <script src="/assets/modules/summernote/summernote-bs4.js"></script>
  <script src="/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="/assets/js/page/index.js"></script>
  
  <!-- Template JS File -->
  <script src="/assets/js/scripts.js"></script>
  <script src="/assets/js/custom.js"></script>
</body>
</html>