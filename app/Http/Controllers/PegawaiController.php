<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawais = Pegawai::with(['jabatan', 'jabatan.divisi'])->orderBy('nip')->paginate(10);
        // $pegawais = Pegawai::orderBy('nip')->paginate(100);
        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatans = Jabatan::with('divisi')->orderBy('nama')->get();
        return view('pegawai.create', compact('jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan_id' => 'required|int',
            'nip' => 'required|int|unique:pegawais',
            'thn_masuk' => 'required|int',
            'thn_keluar' => 'nullable|int',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
        ]);
        DB::beginTransaction();
        // simpan data pegawai
        Pegawai::create($request->post());

        // tambah jumlah pegawai di jabatan dan divisi
        // set jml_pgw jabatan
        $jabatan = Jabatan::find($request->jabatan_id);
        if ($jabatan) {
            $jabatan->jml_pgw += 1;
            $jabatan->save();
        }

        if ($jabatan->divisi) {
            // set jml_pgw divisi
            $divisi = $jabatan->divisi;
            $divisi->jml_pgw += 1;
            $divisi->save();
        }

        DB::commit();
        return redirect()->route('pegawai.index')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        $jabatans = Jabatan::orderBy('nama')->get();
        return view('pegawai.edit', compact('jabatans', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan_id' => 'required|int',
            'nip' => 'required|int|unique:pegawais,nip,' . $pegawai->id,
            'thn_masuk' => 'required|int',
            'thn_keluar' => 'nullable|int',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
        ]);

        DB::beginTransaction();
        // hapus jumlah pegawai di jabatan dan divisi
        // set jml_pgw jabatan 
        $jabatan = $pegawai->jabatan;
        if ($jabatan) {
            $jabatan->jml_pgw -= 1;
            $jabatan->save();
        }

        if ($jabatan->divisi) {
            // set jml_pgw divisi
            $divisi = $jabatan->divisi;
            $divisi->jml_pgw -= 1;
            $divisi->save();
        }

        // tambah jumlah yang baru pegawai di jabatan dan divisi
        // set jml_pgw jabatan
        $jabatan = Jabatan::find($request->jabatan_id);
        if ($jabatan) {
            $jabatan->jml_pgw += 1;
            $jabatan->save();
        }

        if ($jabatan->divisi) {
            // set jml_pgw divisi
            $divisi = $jabatan->divisi;
            $divisi->jml_pgw += 1;
            $divisi->save();
        }

        // simpan data pegawai
        $pegawai->fill($request->post())->save();

        DB::commit();
        return redirect()->route('pegawai.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        DB::beginTransaction();
        // hapus jumlah pegawai di jabatan dan divisi
        // set jml_pgw jabatan 
        $jabatan = Jabatan::find($pegawai->jabatan_id);
        if ($jabatan) {
            $jabatan->jml_pgw -= 1;
            $jabatan->save();
        }

        if ($jabatan->divisi) {
            // set jml_pgw divisi
            $divisi = $jabatan->divisi;
            $divisi->jml_pgw -= 1;
            $divisi->save();
        }

        // hapus pegawai
        $pegawai->delete();
        DB::commit();
        return redirect()->route('pegawai.index')->with('success', 'Data berhasil dihapus');
    }
}
