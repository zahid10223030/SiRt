<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LetterController extends Controller
{
    public function index()
    {
        $residentId = Auth::user()->resident->id ?? null;
        
        $letters = Letter::when(Auth::user()->role_id == 2, function ($query) use ($residentId) {
            $query->where('resident_id', $residentId);
        })
        ->with('resident')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('pages.letter.index', compact('letters'));
    }

    public function create()
    {
        $resident = Auth::user()->resident;
        if (!$resident) {
            return redirect('/letter')->with('error', 'Akun Anda belum terhubung ke data penduduk');
        }

        return view('pages.letter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', Rule::in(['surat_keterangan', 'surat_izin', 'surat_rekomendasi', 'surat_pengantar'])],
            'purpose' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $resident = Auth::user()->resident;
        if (!$resident) {
            return redirect('/letter')->with('error', 'Akun Anda belum terhubung ke data penduduk');
        }

        Letter::create([
            'resident_id' => $resident->id,
            'type' => $request->input('type'),
            'purpose' => $request->input('purpose'),
            'content' => $request->input('content'),
            'status' => 'pending',
        ]);

        return redirect('/letter')->with('success', 'Surat berhasil diajukan. Silakan tunggu konfirmasi dari admin.');
    }

    public function edit($id)
    {
        $resident = Auth::user()->resident;
        if (!$resident) {
            return redirect('/letter')->with('error', 'Akun Anda belum terhubung ke data penduduk');
        }

        $letter = Letter::where('resident_id', $resident->id)
            ->where('status', 'pending') // Hanya bisa edit yang masih pending
            ->findOrFail($id);

        return view('pages.letter.edit', compact('letter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => ['required', Rule::in(['surat_keterangan', 'surat_izin', 'surat_rekomendasi', 'surat_pengantar'])],
            'purpose' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $resident = Auth::user()->resident;
        if (!$resident) {
            return redirect('/letter')->with('error', 'Akun Anda belum terhubung ke data penduduk');
        }

        $letter = Letter::where('resident_id', $resident->id)
            ->where('status', 'pending')
            ->findOrFail($id);

        $letter->update([
            'type' => $request->input('type'),
            'purpose' => $request->input('purpose'),
            'content' => $request->input('content'),
        ]);

        return redirect('/letter')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $resident = Auth::user()->resident;
        if (!$resident) {
            return redirect('/letter')->with('error', 'Akun Anda belum terhubung ke data penduduk');
        }

        $letter = Letter::where('resident_id', $resident->id)
            ->where('status', 'pending') // Hanya bisa hapus yang masih pending
            ->findOrFail($id);

        $letter->delete();

        return redirect('/letter')->with('success', 'Surat berhasil dibatalkan.');
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB max
        ]);

        $letter = Letter::findOrFail($id);
        
        $data = [
            'status' => 'approved',
            'admin_notes' => $request->input('admin_notes'),
            'processed_at' => now(),
        ];

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('public/letters');
            $data['file_path'] = $filePath;
        }

        $letter->update($data);

        return redirect('/letter')->with('success', 'Surat berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $letter = Letter::findOrFail($id);
        $letter->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes'),
            'processed_at' => now(),
        ]);

        return redirect('/letter')->with('success', 'Surat berhasil ditolak.');
    }

    public function download($id)
    {
        $letter = Letter::findOrFail($id);
        
        if (!$letter->file_path) {
            return back()->with('error', 'File surat belum tersedia.');
        }

        return Storage::download($letter->file_path);
    }
}