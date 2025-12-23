@extends('layouts.app')

@section('content')
     <!-- Page Heading -->
      
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah penduduk</h1>
        </div>

        <!-- form-start -->
        <div>
            <form action="/resident" method="post">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="nik">NIK</label>
                                <input type="number" inputmode="numeric" 
                                name="nik" id="nik" class="form-control
                                @error ('nik') is-inValid @enderror">
                                @error('nik')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" name="nama" 
                                id="nama" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="gender">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" 
                                id="tanggal_lahir" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" 
                                id="tempat_lahir" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" cols="30"
                                rows="10" class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="agama">agama</label>
                                <input type="text" name="agama" 
                                id="agama" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="status_perkawinan">Status Perkawinan</label>
                                <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                                    <option value="belum_menikah">Belum Menikah</option>
                                    <option value="menikah">Sudah Menikah</option>
                                    <option value="cerai_hidup">Cerai</option>
                                    <option value="cerai_mati">Janda/Duda</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" name="pekerjaan" 
                                id="pekerjaan" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="no_hp">No HP</label>
                                <input type="text" inputmode="numeric" name="no_hp" 
                                id="no_hp" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="aktif">Aktif</option>
                                    <option value="pindah">Pindah</option>
                                    <option value="meinggal">Almarhum</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end" style="gap: 10px;">
                                <a href="/resident" class="btn btn-outline-secondary">
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
<!-- form-end -->

@endsection
