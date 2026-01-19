@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pengumuman</h1>
    <a href="/announcement" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4 border-left-{{ $announcement->isCurrentlyPinned() ? 'warning' : 'primary' }}">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="m-0 font-weight-bold text-primary">
                        {{ $announcement->title }}
                        {!! $announcement->isCurrentlyPinned() ? '<span class="badge badge-warning ml-2"><i class="fas fa-thumbtack"></i> Dipin</span>' : '' !!}
                    </h4>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-user"></i> Oleh: {{ $announcement->creator->name ?? 'Admin' }}
                        </small>
                        <small class="text-muted ml-3">
                            <i class="fas fa-calendar"></i> Dibuat: {{ $announcement->created_at_label }}
                        </small>
                        @if($announcement->updated_at->gt($announcement->created_at))
                            <small class="text-muted ml-3">
                                <i class="fas fa-edit"></i> Diperbarui: {{ $announcement->updated_at_label }}
                            </small>
                        @endif
                    </div>
                </div>
                
                @if(auth()->user()->role_id == 1)
                    <div class="btn-group">
                        <a href="/announcement/{{ $announcement->id }}/edit" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm delete-announcement" 
                            data-id="{{ $announcement->id }}"
                            data-title="{{ $announcement->title }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-4">
                    {!! $announcement->formatted_content !!}
                </div>
                
                @if($announcement->attachment)
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-paperclip"></i> Lampiran</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                @php
                                    $extension = pathinfo($announcement->attachment, PATHINFO_EXTENSION);
                                    $icon = match(strtolower($extension)) {
                                        'pdf' => 'fa-file-pdf text-danger',
                                        'doc', 'docx' => 'fa-file-word text-primary',
                                        'jpg', 'jpeg', 'png' => 'fa-file-image text-success',
                                        default => 'fa-file text-secondary'
                                    };
                                @endphp
                                <i class="fas {{ $icon }} fa-2x mr-3"></i>
                                <div>
                                    <h6 class="mb-0">File Terlampir</h6>
                                    <small class="text-muted">
                                        <a href="/announcement/{{ $announcement->id }}/download" class="btn btn-primary btn-sm mt-2">
                                            <i class="fas fa-download"></i> Download File
                                        </a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if($announcement->isCurrentlyPinned() && $announcement->pinned_until)
                    <div class="mt-4">
                        <div class="alert alert-warning">
                            <i class="fas fa-clock"></i> 
                            <strong>Pengumuman ini dipin</strong> sampai 
                            {{ \Carbon\Carbon::parse($announcement->pinned_until)->format('d F Y, H:i') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengumuman "<span id="announcementTitle"></span>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete Announcement
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-announcement')) {
            e.preventDefault();
            const btn = e.target.closest('.delete-announcement');
            const id = btn.getAttribute('data-id');
            const title = btn.getAttribute('data-title');
            
            document.getElementById('announcementTitle').textContent = title;
            document.getElementById('deleteForm').action = `/announcement/${id}`;
            
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    });
});
</script>
@endpush