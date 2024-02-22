<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rsetBarangKeluar = BarangKeluar::orderBy('id', 'asc')->paginate(10);
        return view('vbarangkeluar.index',compact('rsetBarangKeluar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aBarang = Barang::select('id', \DB::raw("CONCAT(merk, ' - ', seri) AS merkseri"))
        ->pluck('merkseri', 'id');        
        $aBarang->prepend('Pilih Barang', ''); // Tambahkan opsi default
        
        return view('vbarangkeluar.create', compact('aBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validasi input sesuai kebutuhan Anda
         $request->validate([
            'tgl_keluar' => 'required',
            'qty_keluar' => 'required',
            'barang_id' => 'required',
        ]);

        // Proses menyimpan data barang ke tabel 'barang'
        BarangKeluar::create($request->all());

        return redirect()->route('barangkeluar.index')->with('success', 'Data Barang Keluar berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarangKeluar = BarangKeluar::find($id);

        return view('vbarangkeluar.show', compact('rsetBarangKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barangkeluar = BarangKeluar::findOrFail($id);
        $aBarang = Barang::select('id', \DB::raw("CONCAT(merk, ' - ', seri) AS merkseri"))
        ->pluck('merkseri', 'id');

        return view('vbarangkeluar.edit', compact('barangkeluar', 'aBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_keluar' => 'required',
            'qty_keluar' => 'required',
            'barang_id' => 'required|exists:barang,id',
        ]);

        $barangkeluar = BarangKeluar::findOrFail($id);
        $barangkeluar->update($request->all());

        return redirect()->route('barangkeluar.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarangKeluar = BarangKeluar::find($id);

        //delete post
        $rsetBarangKeluar->delete();

        //redirect to index
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
