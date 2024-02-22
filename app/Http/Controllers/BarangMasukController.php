<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rsetBarangMasuk = BarangMasuk::orderBy('id', 'asc')->paginate(10);
        return view('vbarangmasuk.index',compact('rsetBarangMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aBarang = Barang::select('id', \DB::raw("CONCAT(merk, ' - ', seri) AS merkseri"))
        ->pluck('merkseri', 'id');        
        $aBarang->prepend('Pilih Barang', ''); // Tambahkan opsi default
        
        return view('vbarangmasuk.create', compact('aBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validasi input sesuai kebutuhan Anda
         $request->validate([
            'tgl_masuk' => 'required',
            'qty_masuk' => 'required',
            'barang_id' => 'required',
        ]);

        // Proses menyimpan data barang ke tabel 'barang'
        BarangMasuk::create($request->all());

        return redirect()->route('barangmasuk.index')->with('success', 'Data Barang Masuk berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarangMasuk = BarangMasuk::find($id);

        return view('vbarangmasuk.show', compact('rsetBarangMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barangmasuk = BarangMasuk::findOrFail($id);
        $aBarang = Barang::select('id', \DB::raw("CONCAT(merk, ' - ', seri) AS merkseri"))
        ->pluck('merkseri', 'id');

        return view('vbarangmasuk.edit', compact('barangmasuk', 'aBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_masuk' => 'required',
            'qty_masuk' => 'required',
            // 'barang_id' => 'required|exists:barang,id',
        ]);

        $barangmasuk = BarangMasuk::findOrFail($id);
        $barangmasuk->update($request->all());

        return redirect()->route('barangmasuk.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarangMasuk = BarangMasuk::find($id);
        //delete image

        //delete post
        $rsetBarangMasuk->delete();

        //redirect to index
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
