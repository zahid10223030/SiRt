@extends('layouts.app')

@section('content')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ auth()->user()->role_id == 1 ? 'Permohonan Surat' : 'Surat Saya' }}</h1>

        @if(isset(auth()->user()->resident) && auth()->user()->role_id == 2)
        <a href="/letter/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajukan Surat
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

 <!-- table -->
 <div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            @if(auth()->user()->role_id == 1)
                                <th>Nama Warga</th>
                            @endif
                            <th>Jenis Surat</th>
                            <th>Tujuan</th>
                            <th>Status</th>
                            <th>Catatan Admin</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Diproses</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @if (count($letters) < 1)
                        <tbody>
                            <tr>
                                <td colspan="11">
                                    <p class="pt-3 text-center">Tidak ada data</p>
                                </td>  
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @foreach ($letters as $item)
                            <tr>
                                <td>{{ $loop->iteration + $letters->firstItem() - 1 }}</td>
                                @if(auth()->user()->role_id == 1)
                                    <td>{{ $item->resident->nama }}</td>
                                @endif
                                <td>{{ $item->type_label }}</td>
                                <td>{{ $item->purpose }}</td>
                                <td>
                                    <span class="badge badge-{{ $item->status_color }}">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td>{{ $item->admin_notes ?? '-' }}</td>
                                <td>{{ $item->request_date_label }}</td>
                                <td>{{ $item->processed_date_label }}</td>
                                <td>
                                    @if(auth()->user()->role_id == 2 && isset(auth()->user()->resident))
                                        @if($item->status == 'pending')
                                            <div class="d-flex align-items-center" style="gap: 10px;">
                                                <a href="/letter/{{ $item->id }}" class="d-inline-block btn btn-sm btn-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                    data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @elseif($item->status == 'approved' && $item->file_path)
                                            <a href="/letter/download/{{ $item->id }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada aksi</span>
                                        @endif
                                    @elseif(auth()->user()->role_id == 1 && $item->status == 'pending')
                                        <div class="d-flex" style="gap: 5px;">
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" 
                                                data-bs-target="#modalApprove-{{ $item->id }}">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                data-bs-target="#modalReject-{{ $item->id }}">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </div>
                                    @elseif(auth()->user()->role_id == 1 && $item->status != 'pending')
                                        <span class="text-muted">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                            
                            <!-- Modal Delete -->
                            @if(auth()->user()->role_id == 2 && $item->status == 'pending')
                                @include('pages.letter.confirmation-delete')
                            @endif
                            
                            <!-- Modal Approve (Admin) -->
                            @if(auth()->user()->role_id == 1 && $item->status == 'pending')
                                @include('pages.letter.modal-approve')
                            @endif
                            
                            <!-- Modal Reject (Admin) -->
                            @if(auth()->user()->role_id == 1 && $item->status == 'pending')
                                @include('pages.letter.modal-reject')
                            @endif
                            
                            @endforeach
                        </tbody>  
                    @endif
                </table>
            </div>
            @if ($letters->lastPage() > 1)
            <div class="card-footer">
                {{ $letters->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
 </div>
@endsection