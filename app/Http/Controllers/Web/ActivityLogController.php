<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $isSuperAdmin = auth()->user()->role === 'SUPER_ADMIN';
        
        $query = ActivityLog::with(['user', 'company'])
            ->orderBy('created_at', 'desc');

        // Enforcement: If NOT super admin, strictly filter by company
        if (!$isSuperAdmin) {
            $query->where('company_id', auth()->user()->company_id);
        } else {
            // Super Admin can filter by company optionally
            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by model type (action category)
        if ($request->filled('model')) {
            $query->where('model_type', 'like', '%' . $request->model . '%');
        }

        // Filter by action type
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate(30)->appends($request->all());

        // Get filter data
        if ($isSuperAdmin) {
            $teamMembers = \App\Models\User::all(); // Global users
            $companies = \App\Models\Company::all();
        } else {
            $teamMembers = \App\Models\User::where('company_id', auth()->user()->company_id)
                ->where('role', '!=', 'SUPER_ADMIN')
                ->get();
            $companies = collect();
        }

        return view('activity_logs.index', compact('logs', 'teamMembers', 'companies', 'isSuperAdmin'));
    }
}
