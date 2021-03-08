<div class="slim-header">
  <div class="container">
    <div class="slim-header-left">
      <h2 class="slim-logo"><a href="index.html">ALC <small>Staff</small></a></h2>
    </div><!-- slim-header-left -->
    <div class="slim-header-right">
      <div id="app">
        <connection-checking></connection-checking>
      </div>
      <div class="dropdown dropdown-c">
        <a href="#" class="logged-user" data-toggle="dropdown">
          <img src="http://via.placeholder.com/500x500" alt="">
          <span>{{ Auth::user()->name }}</span>
          <i class="fa fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <nav class="nav">
            {{-- <a href="page-edit-profile.html" class="nav-link"><i class="icon ion-compose"></i> Ubah Profil</a>--}}
            <a href="{{ route('transItemView') }}" class="nav-link"><i class="icon ion-bag"></i> Transaksi Item</a>
            <a href="{{ route('transTicketView') }}" class="nav-link"><i class="icon ion-bag"></i> Transaksi Tiket</a>
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
        <a class="nav-link" href="{{ route('cashTicketView') }}">
          <i class="icon ion-ios-home-outline"></i>
          <span>Kasir Tiket Wahana</span>
        </a>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('cashItemView') }}">
          <i class="icon ion-ios-home-outline"></i>
          <span>Kasir Penjualan Item</span>
        </a>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route('counterRace') }}">
          <i class="icon ion-ios-home-outline"></i>
          <span>Counter Wahana</span>
        </a>
      </li>
    </ul>
  </div><!-- container -->
</div>
