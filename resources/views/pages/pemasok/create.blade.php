@extends('templates.default')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('main') }}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Pemasok</li>
                <li class="breadcrumb-item" aria-current="page">Tambah</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pembelian Stok</h4>
                        <form class="cmxform" id="signupForm" method="post" action="{{ route('pemasok.store') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="created_by" id="created_by" value="{{Auth::user()->name}}">
                                <input type="hidden" name="id_toko" id="id_toko" value="{{Auth::user()->id_toko}}">
                                <label for="name" class="form-label">Nama</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                    name="name" type="text" value="{{ old('name') }}"
                                    placeholder="Nama Pemasok/Perusahaan" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </strong>
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input id="address" class="form-control @error('address') is-invalid @enderror"
                                    name="address" type="text" value="{{ old('address') }}"
                                    placeholder="Alamat Pemasok/Perusahaan" required autofocus>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @error('address')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </strong>
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" type="text" value="{{ old('phone') }}"
                                    placeholder="No. Telp Pemasok/Perusahaan" required autofocus>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @error('phone')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </strong>
                                    @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" type="email" value="{{ old('email') }}"
                                    placeholder="email Pemasok/Perusahaan" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </strong>
                                    @enderror
                            </div>
                            <input class="btn btn-primary" type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
