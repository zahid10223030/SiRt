<!-- [file name]: edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ubah Pengumuman</h1>
</div>

<div>
    <form action="/announcement/{{ $announcement->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="title">Judul Pengumuman *</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $announcement->title) }}"
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
                              required>{{ old('content', $announcement->content) }}</textarea>
                    @error('content')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="photo">Gambar Pendukung</label>
                    
                    @if($announcement->photo)
                    <div class="mb-2">
                        <img src="{{ $announcement->photo_url }}" 
                             alt="Gambar saat ini" 
                             class="img-fluid rounded" 
                             style="max-height: 150px;">
                        <div class="form-check mt-2">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="delete_photo" 
                                   name="delete_photo">
                            <label class="form-check-label text-danger" for="delete_photo">
                                Hapus gambar ini
                            </label>
                        </div>
                    </div>
                    @endif
                    
                    <input type="file" 
                           name="photo" 
                           id="photo" 
                           class="form-control @error('photo') is-invalid @enderror"
                           accept="image/*">
                    <small class="form-text text-muted">
                        Biarkan kosong jika tidak ingin mengubah gambar
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
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection