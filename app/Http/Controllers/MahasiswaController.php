<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
    * Display a listing of the resource.
    * @return \Illuminate\Http\Response
    */

        public function index()
    {
    //fungsi eloquent menampilkan data menggunakan pagination
    $mahasiswas = Mahasiswa::orderBy('Nim', 'desc')->paginate(5);
    // Mengambil semua isi tabel
    $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
    return view('mahasiswas.index', compact('mahasiswas'));
    //with('i', (request()->input('page', 1) - 1) * 5);
    }
    

    /**
     * Show the form for creating a new resource.
     */
        public function create()
    {
        return view('mahasiswas.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    //melakukan validasi data
    $request->validate([ 
        'Nim' => 'required',
        'Nama' => 'required', 
        'Kelas' => 'required',
        'Jurusan' => 'required', 
        'No_Handphone' => 'required',
        'Email' => 'required',
        'Tanggal_Lahir' => 'required',]);

    Mahasiswa::create($request->all());

    //fungsi eloquent untuk menambah data Mahasiswa::create($request->all());

    //jika data berhasil ditambahkan, akan kembali ke halaman utama return redirect()
    return redirect()->route('mahasiswas.index')
    ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $Nim)
    {

        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa

        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Nim)
    {
    
    //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
    $Mahasiswa = Mahasiswa::find($Nim);
    return view('mahasiswas.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, $Nim)
    {
    //melakukan validasi data

    $request->validate([ 
        'Nim' => 'required',
        'Nama' => 'required', 
        'Kelas' => 'required',
        'Jurusan' => 'required', 
        'No_Handphone' => 'required',
        'Email' => 'required',
        'Tanggal_Lahir' => 'required',]);


    //fungsi eloquent untuk mengupdate data inputan kita 
    Mahasiswa::find($Nim)->update($request->all());

    //jika data berhasil diupdate, akan kembali ke halaman utama 
    return redirect()->route('mahasiswas.index')
    ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy( $Nim)
    {
    //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function search(Request $request)
    {
        $cari = $request->search;
        $posts = Mahasiswa::where('Nama', 'LIKE', '%' . $cari . '%')->paginate(6);
        return view('mahasiswas.index', ['posts'=>$posts]);
    }
};