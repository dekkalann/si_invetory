<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $rsetBarang = Barang::orderBy('id', 'asc')->paginate(10);
        return view('vbarang.index',compact('rsetBarang'));
        // $rsetBarang = Barang::all();
        // return view('v_barang.1',compact('rsetBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aKategori = Kategori::pluck('kategori', 'id'); // Ganti 'nama_kolom_kategori' dengan nama kolom kategori yang sesuai di tabel
        $aKategori->prepend('Pilih Kategori', ''); // Tambahkan opsi default
        
        return view('vbarang.create', compact('aKategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input sesuai kebutuhan Anda
        $request->validate([
            'merk' => 'required',
            'seri' => 'required',
            'spesifikasi' => 'required',
            // 'stok' => 'required',
            'kategori_id' => 'required',
        ]);

        // Proses menyimpan data barang ke tabel 'barang'
        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Data Barang berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);

        return view('vbarang.show', compact('rsetBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $aKategori = Kategori::pluck('kategori', 'id');

        return view('vbarang.edit', compact('barang', 'aKategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'merk' => 'required',
            'seri' => 'required',
            'spesifikasi' => 'required',
            // 'stok' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarang = Barang::find($id);
        //delete image
        Storage::delete('public/foto_barang/'. $rsetBarang->foto);

        //delete post
        $rsetBarang->delete();

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}

