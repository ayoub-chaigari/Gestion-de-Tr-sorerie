<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
// Use explicit path if nested
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('company_id', Auth::user()->company_id)
            ->with(['messages' => fn($q) => $q->latest()])
            ->latest()
            ->get();

        return view('support.index', compact('tickets'));
    }

    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $ticket = SupportTicket::create([
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'status' => 'open'
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'sender_id' => Auth::id(),
            'content' => $request->message
        ]);

        // Trigger global notification for SuperAdmins for the new ticket
        $superAdmins = \App\Models\User::where('role', 'SUPER_ADMIN')->get();
        foreach($superAdmins as $sa) {
            \App\Models\Notification::create([
                'user_id' => $sa->id,
                'company_id' => Auth::user()->company_id,
                'type' => 'support',
                'title' => 'Nouveau Ticket Support',
                'message' => 'Un locataire a ouvert un nouveau ticket : ' . $request->subject,
                'link' => route('superadmin.support.show', $ticket->id)
            ]);
        }

        return redirect()->route('support.show', $ticket->id)->with('success', 'Votre demande a été envoyée au support.');
    }

    public function show($id)
    {
        $ticket = SupportTicket::where('company_id', Auth::user()->company_id)
            ->with(['messages.sender'])
            ->findOrFail($id);

        // Mark incoming messages as read
        $ticket->messages()->where('sender_id', '!=', Auth::id())->where('is_read', false)->update(['is_read' => true]);

        return view('support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = SupportTicket::where('company_id', Auth::user()->company_id)->findOrFail($id);

        $request->validate(['message' => 'required|string']);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'sender_id' => Auth::id(),
            'content' => $request->message
        ]);

        $ticket->update(['status' => 'open']);

        // Trigger global notification for SuperAdmin if tenant replies
        if (Auth::user()->role !== 'SUPER_ADMIN') {
            $superAdmins = \App\Models\User::where('role', 'SUPER_ADMIN')->get();
            foreach($superAdmins as $sa) {
                \App\Models\Notification::create([
                    'user_id' => $sa->id,
                    'company_id' => Auth::user()->company_id,
                    'type' => 'support',
                    'title' => 'Nouvelle réponse support',
                    'message' => 'Un locataire a répondu à son ticket.',
                    'link' => route('superadmin.support.show', $ticket->id)
                ]);
            }
        }

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Message envoyé.');
    }
    public function getMessages($id)
    {
        $ticket = SupportTicket::where('company_id', Auth::user()->company_id)
            ->with(['messages.sender'])
            ->findOrFail($id);

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

    public function unreadCount()
    {
        $user = Auth::user();
        
        if ($user->role === 'SUPER_ADMIN') {
            // Unread messages in ALL open tickets for SuperAdmin
            $count = SupportMessage::where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
        } else {
            // Unread messages for the tenant
            $count = SupportMessage::where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->whereHas('ticket', function($q) use ($user) {
                    $q->where('company_id', $user->company_id);
                })
                ->count();
        }

        return response()->json(['count' => $count]);
    }

    public function getLatestNotifications()
    {
        $user = Auth::user();
        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => \App\Models\Notification::where('user_id', $user->id)->where('is_read', false)->count()
        ]);
    }

    public function markAsRead($id)
    {
        $notification = \App\Models\Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}
