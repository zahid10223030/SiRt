<!-- [file name]: dashboard.blade.php (di root: resources/views/dashboard.blade.php) -->
@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard {{ $role == 'admin' ? 'Admin' : 'Warga' }}</h1>
    
    @if($role == 'user')
    <div class="d-flex" style="gap: 10px;">
        <a href="/complaint/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Aduan
        </a>
        <a href="/letter/create" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Surat
        </a>
    </div>
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

<!-- ADMIN DASHBOARD -->
@if($role == 'admin')
<!-- Content Row -->
<div class="row">
    <!-- Total Penduduk Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Penduduk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_residents'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Aduan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Aduan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_complaints'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aduan Status Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Aduan Baru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['pending_complaints'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Aduan Diproses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['processing_complaints'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cog fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row -->
<div class="row">
    <!-- Akun Diajukan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Permintaan Akun</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_account_requests'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Surat Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Total Surat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['pending_letters'] + $stats['approved_letters'] + $stats['rejected_letters'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aduan Selesai Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Aduan Selesai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['completed_complaints'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengumuman Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pengumuman</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{ $stats['total_announcements'] }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{ $stats['total_announcements'] > 0 ? ($stats['pinned_announcements']/$stats['total_announcements'])*100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-xs mt-1">
                            <span class="text-warning">{{ $stats['pinned_announcements'] }} dipin</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Recent Complaints -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Aduan Terbaru</h6>
                <a href="/complaint" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_complaints as $index => $complaint)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $complaint->resident->nama ?? '-' }}</td>
                                <td>{{ Str::limit($complaint->title, 30) }}</td>
                                <td>
                                    <span class="badge badge-{{ $complaint->status_color }}">
                                        {{ $complaint->status_label }}
                                    </span>
                                </td>
                                <td>{{ $complaint->report_date_label }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada aduan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Announcements -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Pengumuman Terbaru</h6>
                <a href="/announcement" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse($recent_announcements as $announcement)
                    <a href="/announcement" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                @if($announcement->is_pinned)
                                <i class="fas fa-thumbtack text-warning mr-2"></i>
                                @endif
                                {{ $announcement->title }}
                            </h6>
                            <small>{{ $announcement->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($announcement->content, 80) }}</p>
                    </a>
                    @empty
                    <div class="text-center py-3">
                        <p class="text-muted">Belum ada pengumuman</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ADMIN DASHBOARD -->

@else
<!-- USER DASHBOARD -->
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col">
        <div class="card border-left-primary shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 font-weight-bold text-primary mb-1">Selamat Datang, {{ Auth::user()->name }}!</div>
                        <div class="text-muted">
                            <i class="fas fa-user mr-2"></i>{{ $resident->nama ?? 'Belum terhubung dengan data penduduk' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-home fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- My Complaints Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Aduan Saya</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['my_complaints'] }}
                        </div>
                        <div class="mt-2">
                            <small class="text-info">
                                <i class="fas fa-clock mr-1"></i>{{ $stats['my_pending_complaints'] }} Baru
                            </small>
                            <small class="text-warning ml-2">
                                <i class="fas fa-cog mr-1"></i>{{ $stats['my_processing_complaints'] }} Diproses
                            </small>
                            <small class="text-success ml-2">
                                <i class="fas fa-check mr-1"></i>{{ $stats['my_completed_complaints'] }} Selesai
                            </small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Letters Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Surat Saya</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['my_letters'] }}
                        </div>
                        <div class="mt-2">
                            <small class="text-info">
                                <i class="fas fa-clock mr-1"></i>{{ $stats['my_pending_letters'] }} Pending
                            </small>
                            <small class="text-success ml-2">
                                <i class="fas fa-check mr-1"></i>{{ $stats['my_approved_letters'] }} Disetujui
                            </small>
                            <small class="text-danger ml-2">
                                <i class="fas fa-times mr-1"></i>{{ $stats['my_rejected_letters'] }} Ditolak
                            </small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Aksi Cepat</div>
                        <div class="mb-2">
                            <a href="/complaint" class="btn btn-sm btn-primary btn-block">
                                <i class="fas fa-list mr-1"></i> Lihat Aduan
                            </a>
                        </div>
                        <div class="mb-2">
                            <a href="/letter" class="btn btn-sm btn-success btn-block">
                                <i class="fas fa-list mr-1"></i> Lihat Surat
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bolt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcement Stats Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pengumuman Terbaru</div>
                        @if($recent_announcements->count() > 0)
                        <div class="mb-1">
                            <strong>{{ $recent_announcements->first()->title }}</strong>
                        </div>
                        <p class="mb-0 text-muted small">
                            {{ Str::limit($recent_announcements->first()->content, 50) }}
                        </p>
                        @else
                        <p class="mb-0 text-muted">Belum ada pengumuman</p>
                        @endif
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Recent Complaints -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Aduan Terbaru Saya</h6>
                <a href="/complaint" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($my_recent_complaints as $index => $complaint)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Str::limit($complaint->title, 30) }}</td>
                                <td>
                                    <span class="badge badge-{{ $complaint->status_color }}">
                                        {{ $complaint->status_label }}
                                    </span>
                                </td>
                                <td>{{ $complaint->report_date_label }}</td>
                                <td>
                                    <a href="/complaint/{{ $complaint->id }}/edit" 
                                       class="btn btn-sm btn-warning" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <p class="py-3">Belum ada aduan</p>
                                    <a href="/complaint/create" class="btn btn-primary">
                                        <i class="fas fa-plus mr-1"></i> Buat Aduan Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Letters -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Surat Terbaru Saya</h6>
                <a href="/letter" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($my_recent_letters as $index => $letter)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $letter->type_label ?? $letter->type }}</td>
                                <td>
                                    @php
                                        $statusColor = match($letter->status) {
                                            'pending' => 'info',
                                            'approved' => 'success',
                                            'rejected' => 'danger',
                                            default => 'secondary'
                                        };
                                        
                                        $statusLabel = match($letter->status) {
                                            'pending' => 'Menunggu',
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Ditolak',
                                            default => $letter->status
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td>{{ $letter->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="/letter/{{ $letter->id }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <p class="py-3">Belum ada surat</p>
                                    <a href="/letter/create" class="btn btn-success">
                                        <i class="fas fa-plus mr-1"></i> Buat Surat Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Announcements -->
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengumuman Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse($recent_announcements as $announcement)
                    <div class="list-group-item list-group-item-action mb-2">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                @if($announcement->is_pinned)
                                <span class="badge badge-warning mr-2">
                                    <i class="fas fa-thumbtack"></i> Penting
                                </span>
                                @endif
                                {{ $announcement->title }}
                            </h6>
                            <small class="text-muted">{{ $announcement->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 mt-2">{{ $announcement->content }}</p>
                        @if($announcement->photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $announcement->photo) }}" 
                                 alt="Gambar Pengumuman" 
                                 class="img-fluid rounded" 
                                 style="max-height: 150px;">
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-bullhorn fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Belum ada pengumuman</p>
                    </div>
                    @endforelse
                </div>
                <div class="text-center mt-3">
                    <a href="/announcement" class="btn btn-outline-primary">
                        <i class="fas fa-list mr-1"></i> Lihat Semua Pengumuman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END USER DASHBOARD -->
@endif
@endsection