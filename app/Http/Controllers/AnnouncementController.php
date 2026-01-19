<?php
// [file name]: AnnouncementController.php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Get pinned announcements first, then others
        $announcements = Announcement::orderBy('is_pinned', 'desc')
            ->orderBy('pinned_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.announcement.index', compact('announcements'));
    }

    public function create()
    {
        // Only admin can create
        if (auth()->user()->role_id != 1) {
            return redirect('/announcement')->with('error', 'Anda tidak memiliki akses');
        }

        return view('pages.announcement.create');
    }

    public function store(Request $request)
    {
        // Only admin can store
        if (auth()->user()->role_id != 1) {
            return redirect('/announcement')->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content' => ['required', 'min:3'],
            'photo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        $announcement = new Announcement();
        $announcement->title = $request->input('title');
        $announcement->content = $request->input('content');

        if ($request->hasFile('photo')) {
            $filePath = $request->file('photo')->store('public/announcements');
            $announcement->photo = str_replace('public/', '', $filePath);
        }

        $announcement->save();

        return redirect('/announcement')->with('success', 'Berhasil membuat pengumuman');
    }

    public function edit($id)
    {
        // Only admin can edit
        if (auth()->user()->role_id != 1) {
            return redirect('/announcement')->with('error', 'Anda tidak memiliki akses');
        }

        $announcement = Announcement::findOrFail($id);
        return view('pages.announcement.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        // Only admin can update
        if (auth()->user()->role_id != 1) {
            return redirect('/announcement')->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content' => ['required', 'min:3'],
            'photo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        $announcement = Announcement::findOrFail($id);
        $announcement->title = $request->input('title');
        $announcement->content = $request->input('content');

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($announcement->photo && Storage::exists('public/' . $announcement->photo)) {
                Storage::delete('public/' . $announcement->photo);
            }

            $filePath = $request->file('photo')->store('public/announcements');
            $announcement->photo = str_replace('public/', '', $filePath);
        }
        if ($request->has('delete_photo')) {
            if ($announcement->photo && Storage::exists('public/' . $announcement->photo)) {
                Storage::delete('public/' . $announcement->photo);
                $announcement->photo = null;
            }
        }

        $announcement->save();

        return redirect('/announcement')->with('success', 'Berhasil mengubah pengumuman');
    }

    public function destroy($id)
    {
        // Only admin can delete
        if (auth()->user()->role_id != 1) {
            return redirect('/announcement')->with('error', 'Anda tidak memiliki akses');
        }

        $announcement = Announcement::findOrFail($id);

        // Delete photo if exists
        if ($announcement->photo && Storage::exists('public/' . $announcement->photo)) {
            Storage::delete('public/' . $announcement->photo);
        }

        $announcement->delete();

        return redirect('/announcement')->with('success', 'Berhasil menghapus pengumuman');
    }

    public function togglePin($id)
    {
        // Only admin can pin/unpin
        if (auth()->user()->role_id != 1) {
            return redirect('/announcement')->with('error', 'Anda tidak memiliki akses');
        }

        $announcement = Announcement::findOrFail($id);
        
        $announcement->is_pinned = !$announcement->is_pinned;
        $announcement->pinned_at = $announcement->is_pinned ? now() : null;
        $announcement->save();

        $action = $announcement->is_pinned ? 'mem-pin' : 'un-pin';
        return redirect('/announcement')->with('success', "Berhasil {$action} pengumuman");
    }
}