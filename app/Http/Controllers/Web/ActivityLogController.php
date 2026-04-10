<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Enforce basic admin check specifically for this controller, 
        // though the web routes already middleware this.
        if (auth()->user()->role !== 'ADMIN' && auth()->user()->role !== 'SUPER_ADMIN') {
            abort(403, 'Accès non autorisé.');
        }

        $logs = ActivityLog::with('user')
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('created_at', 'desc')
            ->paginate(50); // Show lots of items for an audit feed

        return view('activity_logs.index', compact('logs'));
    }
}
