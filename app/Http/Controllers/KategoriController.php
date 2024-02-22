<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\Barang;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aKategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Barang Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        $rsetKategori = Kategori::orderBy('id', 'asc')->paginate(30);
        return view('vkategori.index', compact('rsetKategori','aKategori'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aKategori = [
            'blank' => 'Pilih Kategori',
            'M' => 'Barang Modal',
            'A' => 'Alat',
            'BHP' => 'Bahan Habis Pakai',
            'BTHP' => 'Bahan Tidak Habis Pakai'
        ];
    
        // Tambahkan opsi Pilih Jenis ke array
        $aKategori = ['blank' => 'Pilih Jenis'] + $aKategori;
    
        return view('vkategori.create', compact('aKategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input sesuai kebutuhan Anda
        $request->validate([
            'kategori' => 'required',
            'jenis' => 'required',
        ]);

        // Proses menyimpan data barang ke tabel 'barang'
        Kategori::create($request->all());

        // Redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $aKategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Barang Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        $rsetKategori = Kategori::find($id);

        return view('vkategori.show', compact('aKategori','rsetKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $kategori = Kategori::findOrFail($id);
    $aKategori = [
        'blank' => 'Pilih Kategori',
        'M' => 'Barang Modal',
        'A' => 'Alat',
        'BHP' => 'Bahan Habis Pakai',
        'BTHP' => 'Bahan Tidak Habis Pakai'
    ];

    // Tambahkan opsi Pilih Jenis ke array
    $aKategori = ['blank' => 'Pilih Jenis'] + $aKategori;

    // Debugging
    // dd($kategori);

    return view('vkategori.edit', compact('kategori', 'aKategori'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required',
            'jenis' => 'required',
        ]);

        $kategori = Kategori::findOrFail($id);

        // // Debugging
        // dd($request->all(), $kategori);


        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //cek apakah kategori_id ada di tabel barang.kategori_id ?
        if (DB::table('barang')->where('kategori_id', $id)->exists()){

            return redirect()->route('kategori.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
            
        } else {

            $rsetKategori = Kategori::find($id);

            $rsetKategori->delete();

            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);

        }

    }
}