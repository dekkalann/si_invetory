<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;


class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $rsetSiswa = Siswa::latest()->paginate(10);        
        return view('vsiswa.index',compact('rsetSiswa'));
    }
    public function create()
    {
        return view('vsiswa.create');
    }

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'nama'    => 'required',
            'nis'     => 'required',
            'gender'  => 'required',
            'kelas'   => 'required|not_in:blank',
            'rombel'  => 'required',
            'foto'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $foto = $request->file('foto');
        $foto->storeAs('public/foto', $foto->hashName());

        //create post
        Siswa::create([
            'nama'     => $request->nama,
            'nis'      => $request->nis,
            'gender'   => $request->gender,
            'kelas'    => $request->kelas,
            'rombel'   => $request->rombel,
            'foto'     => $foto->hashName()
        ]);

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetSiswa = Siswa::find($id);

        //return $rsetSiswa;

        //return view
        return view('vsiswa.show', compact('rsetSiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $akelas = array('blank'=>'Pilih Kelas',
                                    'X'=>'X - Sepuluh',
                                    'XI'=>'XI - Sebelas',
                                    'XII'=>'XII - Dua Belas',
                                    'XIII'=>'XIII - Tiga Belas'
                        );

        $rsetSiswa = Siswa::find($id);
        return view('vsiswa.edit', compact('rsetSiswa','akelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama'    => 'required',
            'nis'     => 'required',
            'gender'  => 'required',
            'kelas'   => 'required|not_in:blank',
            'rombel'  => 'required',
            'foto'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $rsetSiswa = Siswa::find($id);

        //check if image is uploaded
        if ($request->hasFile('foto')) {

            //upload new image
            $foto = $request->file('foto');
            $foto->storeAs('public/foto', $foto->hashName());

            //delete old image
            Storage::delete('public/foto/'.$rsetSiswa->foto);

            //update post with new image
            $rsetSiswa->update([
                'nama'    => $request->nama,
                'nis'     => $request->nis,
                'gender'  => $request->gender,
                'kelas'   => $request->kelas,
                'rombel'  => $request->rombel,
                'foto'    => $foto->hashName()
            ]);

        } else {

            //update post without image
            $rsetSiswa->update([
                'nama'    => $request->nama,
                'nis'     => $request->nis,
                'gender'  => $request->gender,
                'kelas'   => $request->kelas,
                'rombel'  => $request->rombel
            ]);
        }

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetSiswa = Siswa::find($id);
        //delete image
        Storage::delete('public/foto/'. $rsetSiswa->foto);

        //delete post
        $rsetSiswa->delete();

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
