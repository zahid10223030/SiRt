<!-- [file name]: index.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengumuman</h1>

    @if(auth()->user()->role_id == 1)
    <a href="/announcement/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pengumuman
    </a>
    @endif
</div>

@if (session('success'))
<script>
    Swal.fire({
        title: "Berhasil",
        text: "{{ session()->get('success') }}",
        icon: "success",
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        title: "Terjadi Kesalahan",
        text: "{{ session()->get('error') }}",
        icon: "error",
    });
</script>
@endif

<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                @if (count($announcements) < 1)
                <div class="text-center py-5">
                    <i class="fas fa-bullhorn fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">Belum ada pengumuman</p>
                </div>
                @else
                <div class="list-group">
                    @foreach ($announcements as $item)
                    <div class="list-group-item list-group-item-action mb-3 rounded border 
                        {{ $item->is_pinned ? 'border-warning' : '' }}">
                        <div class="d-flex w-100 justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <h5 class="mb-0">
                                        @if($item->is_pinned)
                                        <span class="badge badge-warning mr-2">
                                            <i class="fas fa-thumbtack"></i> Pinned
                                        </span>
                                        @endif
                                        {{ $item->title }}
                                    </h5>
                                </div>
                                <p class="mb-2 text-muted">
                                    <small>
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $item->created_at_label }}
                                    </small>
                                </p>
                                <div class="mb-3">
                                    {!! nl2br(e($item->content)) !!}
                                </div>
                                
                                @if($item->photo)
                                <div class="mb-3">
                                    <img src="{{ $item->photo_url }}" 
                                         alt="Gambar Pengumuman" 
                                         class="img-fluid rounded" 
                                         style="max-height: 200px;">
                                </div>
                                @endif
                            </div>
                            
                            @if(auth()->user()->role_id == 1)
                            <div class="ml-3">
                                <div class="btn-group btn-group-sm">
                                    <form action="/announcement/{{ $item->id }}/toggle-pin" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm {{ $item->is_pinned ? 'btn-warning' : 'btn-outline-warning' }}"
                                                title="{{ $item->is_pinned ? 'Unpin' : 'Pin' }}">
                                            <i class="fas fa-thumbtack"></i>
                                        </button>
                                    </form>
                                    
                                    <a href="/announcement/{{ $item->id }}/edit" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            data-toggle="modal" 
                                            data-target="#deleteModal{{ $item->id }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Delete Modal -->
                    @if(auth()->user()->role_id == 1)
                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus pengumuman "{{ $item->title }}"?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="/announcement/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>
            
            @if ($announcements->lastPage() > 1)
            <div class="card-footer">
                {{ $announcements->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection