@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">KATEGORI</label>
                                <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori" value="{{ old('kategori', $kategori->kategori) }}" placeholder="Masukkan Nama Kategori">
                            
                                <!-- error message untuk nama -->
                                @error('kategori')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">JENIS</label>
    
                                <div class="form-check">
                                    <select class="form-select" name="jenis" aria-label="Default select example">
                                        @foreach($aKategori as $id => $namakategori)
                                        <option value="{{ $id }}" {{ old('jenis', $kategori->jenis) == $id ? 'selected' : '' }}>
                                            {{ $namakategori }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- error message untuk kategori -->
                                @error('jenis')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-md btn-secondary">BATAL</a>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
