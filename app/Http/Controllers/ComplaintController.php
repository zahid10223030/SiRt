<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index(){

        $complaints = Complaint::where('resident_id', Auth::user()->resident->id)->paginate(5);

        return view('pages.complaint.index', compact(
            'complaints',
        ));
    }
}
