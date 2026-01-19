<?php
// [file name]: DashboardController.php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Resident;
use App\Models\User;
use App\Models\Letter;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role_id == 1) {
            // Admin Dashboard Stats
            $stats = [
                'total_residents' => Resident::count(),
                'total_complaints' => Complaint::count(),
                'total_account_requests' => User::where('status', 'submitted')->count(),
                'pending_complaints' => Complaint::where('status', 'new')->count(),
                'processing_complaints' => Complaint::where('status', 'processing')->count(),
                'completed_complaints' => Complaint::where('status', 'completed')->count(),
                'total_announcements' => Announcement::count(),
                'pinned_announcements' => Announcement::where('is_pinned', true)->count(),
                'pending_letters' => Letter::where('status', 'pending')->count(),
                'approved_letters' => Letter::where('status', 'approved')->count(),
                'rejected_letters' => Letter::where('status', 'rejected')->count(),
            ];
            
            // Recent Activity
            $recent_complaints = Complaint::with('resident')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            $recent_announcements = Announcement::orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            return view('dashboard', [
                'role' => 'admin',
                'stats' => $stats,
                'recent_complaints' => $recent_complaints,
                'recent_announcements' => $recent_announcements
            ]);
            
        } else {
            // User Dashboard Stats
            $resident = $user->resident;
            
            if (!$resident) {
                return redirect('/profile')->with('error', 'Akun Anda belum terhubung dengan data penduduk. Silahkan lengkapi profil terlebih dahulu.');
            }
            
            $stats = [
                'my_complaints' => Complaint::where('resident_id', $resident->id)->count(),
                'my_pending_complaints' => Complaint::where('resident_id', $resident->id)
                    ->where('status', 'new')
                    ->count(),
                'my_processing_complaints' => Complaint::where('resident_id', $resident->id)
                    ->where('status', 'processing')
                    ->count(),
                'my_completed_complaints' => Complaint::where('resident_id', $resident->id)
                    ->where('status', 'completed')
                    ->count(),
                'my_letters' => Letter::where('resident_id', $resident->id)->count(),
                'my_pending_letters' => Letter::where('resident_id', $resident->id)
                    ->where('status', 'pending')
                    ->count(),
                'my_approved_letters' => Letter::where('resident_id', $resident->id)
                    ->where('status', 'approved')
                    ->count(),
                'my_rejected_letters' => Letter::where('resident_id', $resident->id)
                    ->where('status', 'rejected')
                    ->count(),
            ];
            
            // Recent Activity
            $my_recent_complaints = Complaint::where('resident_id', $resident->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            $my_recent_letters = Letter::where('resident_id', $resident->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            $recent_announcements = Announcement::orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            return view('dashboard', [
                'role' => 'user',
                'stats' => $stats,
                'my_recent_complaints' => $my_recent_complaints,
                'my_recent_letters' => $my_recent_letters,
                'recent_announcements' => $recent_announcements,
                'resident' => $resident
            ]);
        }
    }
}