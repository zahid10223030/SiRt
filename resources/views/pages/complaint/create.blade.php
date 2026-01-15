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
                                @error ('nik') is-invalid @enderror" value="{{ old('nik') }}">
                                @error('nik')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" name="nama" 
                                id="nama" class="form-control
                                @error ('nama') is-invalid @enderror" value="{{ old('nama') }}">
                                @error('nama')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="gender">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control
                                @error ('gender') is-invalid @enderror">
                                    @foreach ([
                                        (object)[
                                            "label"=>"Laki-Laki",
                                            "value"=>"laki-laki",
                                            ],
                                        (object)[
                                            "label"=>"Perempuan",
                                            "value"=>"perempuan",
                                            ],
                                            ] as $item)
                                            <option value="{{ $item->value }}" @selected(old('gender') == $item->value)>
                                            {{ $item->label }}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                id="tanggal_lahir" class="form-control
                                @error ('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" 
                                id="tempat_lahir" class="form-control
                                @error ('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                                @error('tempat_lahir')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" cols="30"
                                rows="10" class="form-control
                                @error ('alamat') is-invalid @enderror">
                                {{ old('alamat') }}
                                </textarea>
                                @error('alamat')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="agama">agama</label>
                                <input type="text" name="agama" 
                                id="agama" class="form-control
                                @error ('agama') is-invalid @enderror" value="{{ old('agama') }}">
                                @error('agama')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="status_perkawinan">Status Perkawinan</label>
                                <select name="status_perkawinan" id="status_perkawinan" class="form-control
                                @error ('status_perkawinan') is-invalid @enderror">
                                    @foreach ([
                                        (object)[
                                            "label"=>"Belum Menikah",
                                            "value"=>"belum_menikah",
                                            ],
                                        (object)[
                                            "label"=>"Sudah Menikah",
                                            "value"=>"menikah",
                                            ],
                                        (object)[
                                            "label"=>"Cerai",
                                            "value"=>"cerai_hidup",
                                            ],
                                        (object)[
                                            "label"=>"Janda/Duda",
                                            "value"=>"cerai_mati",
                                            ],
                                            ] as $item)
                                            <option value="{{ $item->value }}" @selected(old('status_perkawinan') == $item->value)>
                                            {{ $item->label }}</option>
                                    @endforeach
                                </select>
                                @error('status_perkawinan')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" name="pekerjaan" 
                                id="pekerjaan" class="form-control
                                @error ('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan') }}">
                                @error('pekerjaan')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="no_hp">No HP</label>
                                <input type="text" inputmode="numeric" name="no_hp" 
                                id="no_hp" class="form-control
                                @error ('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
                                @error('no_hp')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control
                                @error ('status') is-invalid @enderror">
                                    @foreach ([
                                        (object)[
                                            "label"=>"Aktif",
                                            "value"=>"aktif",
                                            ],
                                        (object)[
                                            "label"=>"Pindah",
                                            "value"=>"pindah",
                                            ],
                                        (object)[
                                            "label"=>"Almarhum",
                                            "value"=>"meninggal",
                                            ],
                                            ] as $item)
                                            <option value="{{ $item->value }}" @selected(old('status') == $item->value)>
                                            {{ $item->label }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <span class="invalid-feedback">
                                        {{$message}}
                                    </span>
                                @enderror
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
