@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">MERK</label>
                                <input type="text" class="form-control @error('merk') is-invalid @enderror" name="merk" value="{{ old('merk', $barang->merk) }}" placeholder="Masukkan Merk Barang">
                            
                                <!-- error message untuk nama -->
                                @error('merk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">SERI</label>
                                <input type="text" class="form-control @error('seri') is-invalid @enderror" name="seri" value="{{ old('seri', $barang->seri) }}" placeholder="Masukkan Seri Barang">
                            
                                <!-- error message untuk nis -->
                                @error('seri')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">SPESIFIKASI</label>
                                <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror" name="spesifikasi" value="{{ old('spesifikasi', $barang->spesifikasi) }}" placeholder="Masukkan Spesifikasi Barang">
                            
                                <!-- error message untuk nis -->
                                @error('spesifikasi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- <div class="form-group">
                                <label class="font-weight-bold">STOK</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok', $barang->stok) }}" placeholder="Masukkan Stok Barang">
                             -->
                                <!-- error message untuk nis -->
                                <!-- @error('stok')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> -->

                            <div class="form-group">
                                <label class="font-weight-bold">KATEGORI</label>
    
                                <div class="form-check">
                                    <select class="form-select" name="kategori_id" aria-label="Default select example">
                                        @foreach($aKategori as $id => $kategori)
                                            <option value="{{ $id }}" {{ old('kategori_id', $barang->kategori_id) == $id ? 'selected' : '' }}>
                                                {{ $kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- error message untuk kategori -->
                                @error('kategori_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>                       

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <a href="{{ route('barang.index') }}" class="btn btn-md btn-secondary">BATAL</a>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
