<?php

namespace App\Http\Controllers\Web\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\IncomingCheque;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlatformDashboardController extends Controller
{
    public function index()
    {
        // 1. Global Financial KPIs (Bypass tenant isolation)
        $globalEncaissements = IncomingCheque::withoutGlobalScopes()
            ->whereIn('status', ['paid', 'endorsed'])
            ->sum('amount');

        $globalDecaissements = \App\Models\InvoicePayment::withoutGlobalScopes()->sum('amount') + 
                               \App\Models\OutgoingCheque::withoutGlobalScopes()
                                   ->where('status', 'paid')
                                   ->whereNull('invoice_id')
                                   ->sum('amount');
        
        $globalSoldeNet = $globalEncaissements - $globalDecaissements;

        // 2. Platform Growth Chart Data (Last 6 Months Global)
        $chartData = $this->getPlatformGrowthMetrics();

        // 3. Tenant Impact (Top Companies by Volume)
        $topCompanies = Company::withCount('users')
            ->get()
            ->map(function($company) {
                $company->volume = IncomingCheque::withoutGlobalScopes()
                    ->where('company_id', $company->id)
                    ->sum('amount');
                return $company;
            })
            ->sortByDesc('volume')
            ->take(5);

        // 4. Consolidated Recent Activity (Last 5 Cheques Platform-wide)
        $lastFiveCheques = IncomingCheque::withoutGlobalScopes()
            ->with('company', 'contact')
            ->latest()
            ->take(5)
            ->get();

        // 5. Infrastructure Basics
        $totalCompanies = Company::count();
        $totalUsers = User::count();
        $recentCompanies = Company::latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'globalEncaissements',
            'globalDecaissements',
            'globalSoldeNet',
            'totalCompanies', 
            'totalUsers', 
            'chartData',
            'topCompanies',
            'lastFiveCheques',
            'recentCompanies'
        ));
    }

    private function getPlatformGrowthMetrics()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->translatedFormat('M y');
            
            $volumeIncoming = IncomingCheque::withoutGlobalScopes()
                ->whereYear('due_date', $month->year)
                ->whereMonth('due_date', $month->month)
                ->whereIn('status', ['paid', 'deposited', 'endorsed'])
                ->sum('amount');

            $volumeOutgoing = \App\Models\InvoicePayment::withoutGlobalScopes()
                ->whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount');

            $data[] = [
                'month'    => $monthName,
                'incoming' => $volumeIncoming,
                'outgoing' => $volumeOutgoing,
                'balance'  => $volumeIncoming - $volumeOutgoing
            ];
        }
        return $data;
    }
}
