<?php

namespace App\Http\Controllers\Web\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportHubController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with(['company', 'creator', 'messages' => fn($q) => $q->latest()])
            ->latest()
            ->paginate(20);

        return view('superadmin.support.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = SupportTicket::with(['company', 'creator', 'messages.sender'])
            ->findOrFail($id);

        // Mark incoming messages as read
        $ticket->messages()->where('sender_id', '!=', Auth::id())->where('is_read', false)->update(['is_read' => true]);

        return view('superadmin.support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $request->validate(['message' => 'required|string']);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'sender_id' => Auth::id(),
            'content' => $request->message
        ]);

        // Trigger global notification for the tenant creator
        \App\Models\Notification::create([
            'company_id' => $ticket->company_id,
            'user_id' => $ticket->user_id,
            'type' => 'support',
            'title' => 'Réponse du Support',
            'message' => 'L\'administration a répondu à votre ticket.',
            'link' => route('support.show', $ticket->id)
        ]);

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Réponse envoyée au locataire.');
    }

    public function close($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->update(['status' => 'closed']);
        return redirect()->back()->with('success', 'Ticket marqué comme résolu.');
    }

    public function apiMessages($id)
    {
        $ticket = SupportTicket::with(['messages.sender'])->findOrFail($id);

        // Mark incoming messages as read
        $ticket->messages()->where('sender_id', '!=', Auth::id())->where('is_read', false)->update(['is_read' => true]);

        return response()->json([
            'status' => $ticket->status,
            'messages' => $ticket->messages->map(function($m) {
                return [
                    'id' => $m->id,
                    'content' => $m->content,
                    'is_me' => $m->sender_id === Auth::id(),
                    'sender_name' => $m->sender->role === 'SUPER_ADMIN' ? 'Support Plateforme' : $m->sender->name,
                    'time' => $m->created_at->format('H:i'),
                    'role' => $m->sender->role
                ];
            })
        ]);
    }
}
