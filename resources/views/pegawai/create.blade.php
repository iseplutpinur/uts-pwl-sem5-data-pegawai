@extends('layout.master')

@section('title')
    Tambah Pegawai
@endsection

@section('content')
    <div class="container mt-4">
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-md-flex flex-row justify-content-between">
                <h5 class="card-title">Tambah Pegawai</h5>
                <div>
                    <a class="btn btn-secondary" href="{{ URL::previous() }}"> Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data" id="mainform">
                    @csrf
                    <div class="row mb-3">
                        <label for="nip" class="col-sm-2 col-form-label">Nomor Pokok Pegawai</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" value="{{ old('nip') }}"name="nip"
                                id="nip" required placeholder="Silahkan masukan Nomor Pokok Pegawai">
                        </div>
                    </div>
                    @error('nip')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                    <div class="row mb-3">
                        <label for="jabatan_id" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <select class="form-control" value="{{ old('jabatan_id') }}"name="jabatan_id" id="jabatan_id"
                                required>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}"
                                        {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                        {{ $jabatan->nama }}
                                        {{ $jabatan->divisi ? "| Divisi {$jabatan->divisi->nama}" : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('jabatan_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ old('nama') }}"name="nama"
                                id="nama" required placeholder="Silahkan masukan nama pegawai">
                        </div>
                    </div>
                    @error('nama')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                    <div class="row mb-3">
                        <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal lahir</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control"
                                value="{{ old('tanggal_lahir') }}"name="tanggal_lahir" id="tanggal_lahir" required>
                        </div>
                    </div>
                    @error('tanggal_lahir')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                    <div class="row mb-3">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>
                    </div>
                    @error('jenis_kelamin')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror


                    <div class="row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                        <div class="col-sm-10">
                            <textarea type="number" class="form-control" name="alamat" id="alamat" required
                                placeholder="Silahkan masukan alamat pegawai">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                    @error('thn_masuk')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                    <div class="row mb-3">
                        <label for="thn_masuk" class="col-sm-2 col-form-label">Tahun Masuk</label>
                        <div class="col-sm-10">
                            <input type="number" min="2000" max="{{ date('Y') }}" class="form-control"
                                value="{{ old('thn_masuk') }}"name="thn_masuk" id="thn_masuk" required
                                placeholder="Silahkan masukan tahun masuk pegawai">
                        </div>
                    </div>
                    @error('thn_masuk')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                    <div class="row mb-3">
                        <label for="thn_keluar" class="col-sm-2 col-form-label">Tahun Keluar/Lulus</label>
                        <div class="col-sm-10">
                            <input type="number" min="2000" max="{{ date('Y') }}" class="form-control"
                                value="{{ old('thn_keluar') }}"name="thn_keluar" id="thn_keluar"
                                placeholder="Silahkan masukan tahun Keluar/Lulus pegawai">
                        </div>
                    </div>
                    @error('thn_keluar')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror

                </form>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary ml-3" form="mainform">Simpan</button>
            </div>
        </div>
    </div>
@endsection
