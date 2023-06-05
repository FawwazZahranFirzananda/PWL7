<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MahasiswaController extends Controller
{
    /**
    * Display a listing of the resource.
    * @return \Illuminate\Http\Response
    */

    public function index()
    {
        //yang semula Mahasiswa::all, diubah menjadi with() yang menyatakan relasi
        $mahasiswas = Mahasiswa::with('kelas')->get();
        $posts = Mahasiswa::orderBy('Nim', 'asc')->paginate(3);
        return view('mahasiswas.index', compact('posts'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswas.create',['kelas' => $kelas]);
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
            'foto' => 'mimes:jpg,png,jpeg',
            'kelas_id' => 'required',
            'Jurusan' => 'required', 
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',]);

        if ($request->file('foto')) {
            // $nama_foto = $request->file('foto')->store('fotoMahasiswa', 'public');
            $nama_foto = $request->file('foto')->store('fotoMahasiswa');
        } else {
            dd('foto kosong');
        }

        $mahasiswas = new Mahasiswa;
        $mahasiswas->Nim = $request->get('Nim');
        $mahasiswas->Nama = $request->get('Nama');
        $mahasiswas->foto = $nama_foto;
        $mahasiswas->Jurusan = $request->get('Jurusan');
        $mahasiswas->kelas_id = $request->get('kelas_id');
        $mahasiswas->No_Handphone = $request->get('No_Handphone');
        $mahasiswas->Email = $request->get('Email');
        $mahasiswas->Tanggal_Lahir = $request->get('Tanggal_Lahir');
        $mahasiswas->save();

        //$kelas = new Kelas;
        //$kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        //$mahasiswas->kelas()->associate($kelas);
        //$mahasiswas->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $Nim)
    {
        //Menampilkan detail data berdasarkan Nim Mahasiswa
        //code sebelum dibuat relasi --> $mahasiswa = Mahasiswa::find($Nim);
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();

        return view('mahasiswas.detail', ['Mahasiswa' => $Mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Nim)
    {
    
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
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
            'foto' => 'mimes:jpg,png,jpeg',
            'kelas_id' => 'required',
            'Jurusan' => 'required', 
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',]);
        
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

    public function nilai($Nim){
        $mahasiswa = Mahasiswa::with('kelas', 'matakuliah')->find($Nim);
        return view('mahasiswas.nilai', compact('mahasiswa'));        
    }

    public function cetak_khs(Mahasiswa $mahasiswa)
    {
        $matkuls = $mahasiswa->matakuliah;
        $pdf = pdf::loadview('mahasiswas.cetak_khs', [
            'matkuls' => $matkuls,
            'mahasiswa' => $mahasiswa,
        ]);
        return $pdf->stream();
    }
};