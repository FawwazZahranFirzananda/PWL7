@extends('mahasiswas.layout')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-2">JURUSAN TEKNOLOGI INFORMASI - POLITEKNIK NEGERI MALANG</h2>
        <h2 class="text-center mb-4">KARTU HASIL STUDI (KHS)</h2>

        <div class="card-body">
            <table class="table table-responsive" style="width: 25em">
                <tr>
                    <th>NAMA</th>
                    <th>:</th>
                    <td>{{ $mahasiswa->Nama }}</td>
                </tr>

                <tr>
                    <th>NIM</th>
                    <th>:</th>
                    <td>{{ $mahasiswa->Nim }}</td>
                </tr>

                <tr>
                    <th>KELAS</th>
                    <th>:</th>
                    <td>{{ $mahasiswa->Kelas->nama_kelas }}</td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr class="text-center">
                    <th>MATA KULIAH</th>
                    <th>SKS</th>
                    <th>SEMESTER</th>
                    <th>NILAI</th>
                </tr>
                @foreach ($mahasiswa->matakuliah as $nilai)
                    <tr class="text-center" >
                        <td>{{ $nilai->nama_matkul }}</td>
                        <td>{{ $nilai->sks }}</td>
                        <td>{{ $nilai->semester }}</td>
                        <td>{{ $nilai->pivot->nilai }}</td>
                    </tr>
                @endforeach
            </table>

            <a class="btn btn-success mt-3" href="{{ route('mahasiswas.index') }}">Kembali</a>
        </div>

        <div class="text-center" style="margin-top: 37px">
            <a href="{{ route('mahasiswa.cetak_khs', $mahasiswa->Nim) }}" class="btn" style="background: #DB1514; color: white; font-weight: 600;">Cetak ke PDF</a>
        </div>

    </div>