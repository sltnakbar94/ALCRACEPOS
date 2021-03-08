<style>
  .cabang {
    font-size: 17px;
    font-weight: 100;
    letter-spacing: normal;
  }
</style>
<div class="slim-header">
  <div class="container">
    <div class="slim-header-left">
      <h2 class="slim-logo"><a href="{{ url('/') }}">ALC <small>Store Manager <span class="cabang"> - (Cabang Kutabumi , Tanggerang)</span></small></a></h2>
    </div><!-- slim-header-left -->
    <div class="slim-header-right">
      <div class="dropdown dropdown-c">
        <a href="#" class="logged-user" data-toggle="dropdown">
          <img src="http://via.placeholder.com/500x500" alt="">
          <span>{{ Auth::user()->name }}</span>
          <i class="fa fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <nav class="nav">
            {{-- <a href="page-profile.html" class="nav-link"><i class="icon ion-person"></i> View Profile</a>
            <a href="page-edit-profile.html" class="nav-link"><i class="icon ion-compose"></i> Edit Profile</a>
            <a href="page-activity.html" class="nav-link"><i class="icon ion-ios-bolt"></i> Activity Log</a>
            <a href="page-settings.html" class="nav-link"><i class="icon ion-ios-gear"></i> Account Settings</a> --}}
            <a href="{{ route('changeUserPass') }}" class="nav-link"><i class="icon ion-ios-gear"></i> Ganti PIN</a>
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="icon ion-forward"></i> {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </nav>
        </div><!-- dropdown-menu -->
      </div><!-- dropdown -->
    </div><!-- header-right -->
  </div><!-- container -->
</div><!-- slim-header -->
<div class="slim-navbar">
  <div class="container">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/dashboard') }}">
          <i class="icon ion-stats-bars"></i>
          <span>Dashboard</span>
          {{-- <span class="square-8"></span> --}}
        </a>
      </li>
      <li class="nav-item with-sub">
        <a class="nav-link" href="#">
          <i class="icon ion-stats-bars"></i>
          <span>Laporan</span>
        </a>
        <div class="sub-item">
          <ul>
            <li><a href="{{ route('transItemView',['staff'=>'','from' => date('d-m-Y'),'to' => date('d-m-Y')]) }}">Laporan Transaksi Item</a></li>
            <li><a href="{{ route('transTicketView',['staff'=>'','from' => date('d-m-Y'),'to' => date('d-m-Y')]) }}">Laporan Transaksi Tiket</a></li>
            <li><a href="{{ route('reportShift',['staff'=>'','from' => date('d-m-Y'),'to' => date('d-m-Y')]) }}">Laporan Shift</a></li>
          </ul>
        </div><!-- sub-item -->
      </li>
      <li class="nav-item with-sub">
        <a class="nav-link" href="#">
          <i class="icon ion-star"></i>
          <span>Wahana</span>
        </a>
        <div class="sub-item">
          <ul>
            <li><a href="{{ route('wahanaView',['type' => 'One Time']) }}">One Time</a></li>
            <li><a href="{{ route('wahanaView',['type' => 'With Timer']) }}">With Timer</a></li>
            <li><a href="{{ route('changePriceWhView') }}">Request Perubahan Harga</a></li>
          </ul>
        </div><!-- dropdown-menu -->
      </li>
      <li class="nav-item with-sub">
        <a class="nav-link" href="#" data-toggle="dropdown">
          <i class="icon ion-folder"></i>
          {{-- <span>Produk Item</span>
        </a>
        <div class="sub-item">
          <ul>
            <li><a href="{{ route('itemView') }}">Daftar Produk</a></li>
            <li><a href="{{ route('stockView') }}">Informasi Stok</a></li>
            <li><a href="{{ route('receivingView') }}">Tambah Stok</a></li>
            <li><a href="{{ route('changePriceView') }}">Request Perubahan Harga</a></li>
          </ul>
        </div><!-- dropdown-menu -->
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('employeeView') }}">
          <i class="icon ion-person-stalker"></i>
          <span>Karyawan</span>
          {{-- <span class="square-8"></span> --}}
        </a>
      </li>
    </ul>
  </div><!-- container -->
</div>
