<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\IncomingCheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyAdminController extends Controller
{
    public function index()
    {
        $companies = Company::withCount('users')->get();
        return view('companies.index', compact('companies'));
    }

    public function activate($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['status' => 'active']);

        // Trigger notification for the tenant
        $admin = $company->users()->where('role', 'ADMIN')->first();
        if ($admin) {
            \App\Models\Notification::create([
                'company_id' => $company->id,
                'user_id' => $admin->id,
                'type' => 'security',
                'title' => 'Compte Activé',
                'message' => "Félicitations ! Votre compte entreprise '{$company->name}' a été activé.",
                'link' => route('dashboard')
            ]);
        }

        return redirect()->back()->with('success', "Entreprise '{$company->name}' activée.");
    }

    public function suspend($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['status' => 'suspended']);

        // Auto-create support ticket for clarification
        $ticket = \App\Models\SupportTicket::create([
            'company_id' => $company->id,
            'user_id' => Auth::id(), // SuperAdmin is the creator
            'subject' => 'Suspension de Compte - Notification Officielle',
            'status' => 'open'
        ]);

        \App\Models\SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'sender_id' => Auth::id(),
            'content' => "Votre compte entreprise '{$company->name}' a été suspendu par l'administration de la plateforme.\n\nVous pouvez utiliser cet espace pour demander des clarifications ou soumettre les éléments requis pour la réactivation."
        ]);

        // Trigger notification for the tenant
        $admin = $company->users()->where('role', 'ADMIN')->first();
        if ($admin) {
            \App\Models\Notification::create([
                'company_id' => $company->id,
                'user_id' => $admin->id,
                'type' => 'security',
                'title' => 'Compte Suspendu',
                'message' => "Attention : Votre compte '{$company->name}' a été suspendu. Consultez le Support Center.",
                'link' => route('support.index')
            ]);
        }

        return redirect()->back()->with('success', "Entreprise '{$company->name}' suspendue et ticket de support ouvert.");
    }

    public function manageUsers($id)
    {
        $company = Company::with('users')->findOrFail($id);
        return view('companies.users', compact('company'));
    }

    public function oversight($id)
    {
        $company = Company::withCount('users')->findOrFail($id);

        // Company Specific KPIs
        $totalEncaissements = IncomingCheque::withoutGlobalScopes()
            ->where('company_id', $id)
            ->whereIn('status', ['paid', 'endorsed'])
            ->sum('amount');

        $totalDecaissements = \App\Models\InvoicePayment::withoutGlobalScopes()
            ->where('company_id', $id)
            ->sum('amount') + 
            \App\Models\OutgoingCheque::withoutGlobalScopes()
                ->where('company_id', $id)
                ->where('status', 'paid')
                ->whereNull('invoice_id')
                ->sum('amount');

        $soldeNet = $totalEncaissements - $totalDecaissements;

        // Recent Activity
        $recentCheques = IncomingCheque::withoutGlobalScopes()
            ->where('company_id', $id)
            ->with('contact')
            ->latest()
            ->take(10)
            ->get();

        // Bank Accounts
        $bankAccounts = \App\Models\BankAccount::withoutGlobalScopes()
            ->where('company_id', $id)
            ->get();

        // Audit Logs
        $auditLogs = \App\Models\ActivityLog::withoutGlobalScopes()
            ->where('company_id', $id)
            ->with('user')
            ->latest()
            ->take(20)
            ->get();

        return view('superadmin.companies.oversight', compact(
            'company',
            'totalEncaissements',
            'totalDecaissements',
            'soldeNet',
            'recentCheques',
            'bankAccounts',
            'auditLogs'
        ));
    }
}
