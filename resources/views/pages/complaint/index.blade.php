@extends('layouts.app')

@section('content')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaduan</h1>
        <a href="/complaint/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-plus fa-sm text-white-50"></i> Buat Aduan</a>
 </div>

        <!-- table -->
         <div class="row">
                <div class="col">
                        <div class="card shadow">
                                <div class="card-body">
                                        <table class="table table-responsive table-bordered table-hovered">
                                              <thead>
                                                <tr>
                                                        <th>No</th>
                                                        <th>Judul</th>
                                                        <th>Isi Aduan</th>
                                                        <th>Status</th>
                                                        <th>Foto Bukti</th>
                                                        <th>Tanggal Laporan</th>
                                                        <th>Aksi</th>
                                                </tr>
                                              </thead>
                                              @if (count($complaints) < 1)
                                                <tbody>
                                                        <tr>
                                                                 <td colspan="11">
                                                                           <p class="pt-3 text-center">Tidak ada data</p>
                                                                 </td>  
                                                        </tr>
                                                </tbody>
                                              @else
                                              <tbody>
                                                @foreach ($complaints as $item)
                                                <tr>
                                                        <td>{{ $loop->iteration + $complaints->firstItem() - 1 }}</td>
                                                        <td>{{ $item->title }}</td>
                                                        <td>{!! wordwrap($item->content, 50, "<br>\n") !!}</td>
                                                        <td>{{ $item->status_label }}</td>
                                                        <td>
                                                                @if (isset($item->photo_proof))
                                                                        <img src="{{ $item->photo_proof }}" alt="Foto Bukti"
                                                                        style="max-width: 300px;">
                                                                @else
                                                                Tidak ada
                                                                @endif
                                                        </td>
                                                        <td>{{ $item->report_date_label }}</td>
                                                        <td>
                                                                <div class="d-flex align-items-center" style="gap: 10px;">
                                                                        <a href="/complaint/{{ $item->id }}" class="d-inline-block btn btn-sm btn-warning">
                                                                                <i class="fas fa-pen"></i>
                                                                        </a>
                                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                                        data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                                                <i class="fas fa-eraser"></i>
                                                                        </button>
                                                                </div>
                                                        </td>
                                                </tr>
                                                @include('pages.complaint.confirmation-delete')
                                                
                                                @endforeach
                                              </tbody>  
                                              @endif
                                        </table>
                                </div>
                                @if ($complaints->lastPage() > 1)
                                <div class="card-footer">
                                        {{ $complaints->links('pagination::bootstrap-5') }}
                                </div>
                                @endif
                        </div>
                </div>
         </div>
@endsection