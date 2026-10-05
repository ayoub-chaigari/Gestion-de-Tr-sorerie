<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // SECURITY: strictly filter by company_id to prevent cross-tenant leakage
        $users = User::where('company_id', auth()->user()->company_id)
                     ->where('role', '!=', 'SUPER_ADMIN')
                     ->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'permissions' => 'nullable|array'
        ]);

        $permissions = $request->permissions ?? [];
        foreach ($permissions as $module => $actions) {
            if (!empty($actions) && !in_array('view', $actions)) {
                $permissions[$module][] = 'view';
            }
        }

        User::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'ACCOUNTANT',
            'permissions' => $permissions
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté.');
    }

    public function edit(User $user)
    {
        // SECURITY: Ensure the user being edited belongs to the exact same company
        if ($user->company_id !== auth()->user()->company_id) {
            abort(403, 'Accès non autorisé.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // SECURITY: Ensure the user being updated belongs to the exact same company
        if ($user->company_id !== auth()->user()->company_id) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'permissions' => 'nullable|array'
        ]);

        $permissions = $request->permissions ?? [];
        foreach ($permissions as $module => $actions) {
            if (!empty($actions) && !in_array('view', $actions)) {
                $permissions[$module][] = 'view';
            }
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'permissions' => $permissions
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        // SECURITY: Prevent accessing users outside of company scope
        if ($user->company_id !== auth()->user()->company_id) {
            abort(403, 'Accès non autorisé.');
        }

        // LOGIC: Prevent deleting the primary admin or the currently logged-in user
        if ($user->role === 'ADMIN') {
            return redirect()->back()->withErrors('Impossible de supprimer un administrateur principal.');
        }
        
        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors('Vous ne pouvez pas supprimer votre propre compte actif.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé de l\'équipe.');
    }

    public function toggleStatus(User $user)
    {
        // SECURITY: Ensure the user belongs to the same company
        if ($user->company_id !== auth()->user()->company_id && auth()->user()->role !== 'SUPER_ADMIN') {
            abort(403, 'Accès non autorisé.');
        }

        // LOGIC: Prevent an admin from suspending themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors('Vous ne pouvez pas suspendre votre propre compte.');
        }

        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        
        $user->update([
            'status' => $newStatus,
            'suspended_at' => $newStatus === 'suspended' ? now() : null
        ]);

        return redirect()->back()->with('success', "Le statut de {$user->name} a été mis à jour.");
    }
}
