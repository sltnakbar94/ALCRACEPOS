@extends('core::layouts/master')
@section('title','Member')
@section('content')
<div class="slim-mainpanel">
  <div class="container-fluid">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item""><a href="#">Member</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Member</li>
      </ol>
      <h6 class="slim-pagetitle">Member <small>(Tambah Member)</small></h6>
    </div><!-- slim-pageheader -->

    <div class="card card-body">
      <div class="row">
        <div class="col-lg">
          @include('flash::message')
          {{ Form::open(['route' => 'employeeStore']) }}
            <h5 class="card-title">Data Diri</h5>
            <hr>
            <div class="form-group">
              <label for="">Nama Lengkap</label>
              <input type="text" name="name" value="{{ old('name') }}" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="form-group">
              <label for="">Nomor Telepon</label>
              <input type="text" name="phone" value="{{ old('phone') }}" id="" class="form-control">
              <span class="text-danger">{{ $errors->first('phone') }}</span>
            </div>
            <div class="form-group">
              <label for="">Alamat Rumah Lengkap</label>
              <textarea name="address" id="" cols="30" rows="2" class="form-control">{{ old('address') }}</textarea>
              <span class="text-danger">{{ $errors->first('address') }}</span>
            </div>
            <h5 class="card-title">Akun POS</h5>
            <hr>
            <div class="form-group">
              <div class="form-group">
                <label for="">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" id="" class="form-control">
                <span class="text-danger">{{ $errors->first('username') }}</span>
              </div>
              <div class="form-group">
                <label for="">PIN <small>(6 Digit)</small></label>
                <input type="number" name="pin" value="{{ old('pin') }}" id="" maxlength="6" class="form-control">
                <span class="text-danger">{{ $errors->first('pin') }}</span>
              </div>
            </div>
            <div class="form-group">
              <label for="">Level Akses</label>
              <select name="level" id="" class="form-control select2-search" data-placeholder="- Pilih -">
                <option label="- Pilih -"></option>
                @role('superadministrator')
                  @foreach ($role as $item)
                      <option value="{{ $item->id }}">{{ $item->display_name }}</option>
                  @endforeach
                @endrole
                @role('storemanager')
                  <option value="4">Staff</option>
                @endrole
              </select>
              <span class="text-danger">{{ $errors->first('level') }}</span>
            </div>
            {{-- <div class="form-group">
              <label for="">Status</label>
              <select name="status" id="" class="form-control select2-search" data-placeholder="- Pilih -">
                <option label="- Pilih -"></option>
                <option value="Publish">Active</option>
                <option value="Unpublish">Non Active</option>
                <option value="Suspend">Suspend</option>
              </select>
              <span class="text-danger">{{ $errors->first('status') }}</span>
            </div> --}}
            <div class="form-group">
              <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              <a href="{{ route('employeeView') }}" class="btn btn-secondary"><i class="fa fa-angle-double-left"></i> Kembali</a>
            </div>
          {{ Form::close() }}
        </div>
      </div><!-- row -->
    </div><!-- card -->

  </div><!-- container -->
</div><!-- slim-mainpanel -->
@endsection