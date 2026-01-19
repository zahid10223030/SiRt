@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ajukan Surat</h1>
</div>

<div>
    <form action="/letter" method="post">
        @csrf
        @method('POST')
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="type">Jenis Surat</label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                        <option value="">Pilih Jenis Surat</option>
                        <option value="surat_keterangan" {{ old('type') == 'surat_keterangan' ? 'selected' : '' }}>Surat Keterangan</option>
                        <option value="surat_izin" {{ old('type') == 'surat_izin' ? 'selected' : '' }}>Surat Izin</option>
                        <option value="surat_rekomendasi" {{ old('type') == 'surat_rekomendasi' ? 'selected' : '' }}>Surat Rekomendasi</option>
                        <option value="surat_pengantar" {{ old('type') == 'surat_pengantar' ? 'selected' : '' }}>Surat Pengantar</option>
                    </select>
                    @error('type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="purpose">Tujuan Surat</label>
                    <input type="text" 
                        name="purpose" 
                        id="purpose" 
                        class="form-control @error('purpose') is-invalid @enderror" 
                        value="{{ old('purpose') }}"
                        placeholder="Contoh: Untuk keperluan administrasi, izin usaha, dll.">
                    @error('purpose')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="content">Isi/Keterangan</label>
                    <textarea name="content" 
                        id="content" 
                        cols="30"
                        rows="10" 
                        class="form-control @error('content') is-invalid @enderror"
                        placeholder="Jelaskan keperluan surat secara detail...">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end" style="gap: 10px;">
                    <a href="/letter" class="btn btn-outline-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Ajukan Surat</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection