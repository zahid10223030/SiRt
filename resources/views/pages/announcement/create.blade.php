<!-- [file name]: create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat Pengumuman</h1>
</div>

<div>
    <form action="/announcement" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="title">Judul Pengumuman *</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title') }}"
                           required>
                    @error('title')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="content">Isi Pengumuman *</label>
                    <textarea name="content" 
                              id="content" 
                              rows="8" 
                              class="form-control @error('content') is-invalid @enderror"
                              required>{{ old('content') }}</textarea>
                    @error('content')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="photo">Gambar Pendukung (Opsional)</label>
                    <input type="file" 
                           name="photo" 
                           id="photo" 
                           class="form-control @error('photo') is-invalid @enderror"
                           accept="image/*">
                    <small class="form-text text-muted">
                        Format: JPG, PNG, JPEG (Max: 2MB)
                    </small>
                    @error('photo')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="card-footer">
                <div class="d-flex justify-content-end" style="gap: 10px;">
                    <a href="/announcement" class="btn btn-outline-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection