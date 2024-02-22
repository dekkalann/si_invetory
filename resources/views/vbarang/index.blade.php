<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('barang.create') }}" class="btn btn-md btn-success mb-3">TAMBAH BARANG</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('barangmasuk.index') }}" class="btn btn-md btn-success mb-3">BARANG MASUK</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('barangkeluar.index') }}" class="btn btn-md btn-success mb-3">BARANG KELUAR</a>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>MERK</th>
                            <th>SERI</th>
                            <th>SPESIFIKASI</th>
                            <th>STOK</th>
                            <th>KATEGORI</th>
                            <th style="width: 15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rsetBarang as $rowbarang)
                            <tr>
                                <td>{{ $rowbarang->id  }}</td>
                                <td>{{ $rowbarang->merk  }}</td>
                                <td>{{ $rowbarang->seri  }}</td>
                                <td>{{ $rowbarang->spesifikasi  }}</td>
                                <td>{{ $rowbarang->stok  }}</td>
                                <td>{{ $rowbarang->kategori->kategori  }}</td>
                                <td class="text-center"> 
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barang.destroy', $rowbarang->id) }}" method="POST">
                                        <a href="{{ route('barang.show', $rowbarang->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('barang.edit', $rowbarang->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                                
                                
                            </tr>
                        @empty
                            <div class="alert">
                                Data Siswa belum tersedia
                            </div>
                        @endforelse
                    </tbody>
                    
                </table>
                {{-- {{ $barang->links() }} --}}

            </div>
        </div>
    </div>
@endsection
</body>
</html>


