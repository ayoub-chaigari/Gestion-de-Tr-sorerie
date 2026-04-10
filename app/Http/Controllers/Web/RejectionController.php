<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Rejection;
use App\Models\IncomingCheque;
use Illuminate\Http\Request;

class RejectionController extends Controller
{
    public function index()
    {
        $rejections = Rejection::with('cheque.contact')->orderBy('created_at', 'desc')->paginate(15);
        return view('rejections.index', compact('rejections'));
    }

    public function createFromCheque(Request $request, $chequeId)
    {
        $cheque = IncomingCheque::findOrFail($chequeId);
        
        $rejection = Rejection::create([
            'company_id'       => auth()->user()->company_id,
            'cheque_id'        => $cheque->id,
            'type'             => 'incoming',  // enum: 'incoming' | 'outgoing'
            'reason'           => 'Non-payment / NSF',
            'resolved'         => false,
            'sent_to_litigation' => false,
        ]);

        $cheque->update(['status' => 'unpaid']);

        return redirect()->route('rejections.index')->with('success', 'Chèque transféré au module de gestion des impayés.');
    }

    public function toggleLitigation(Rejection $rejection)
    {
        $rejection->update([
            'sent_to_litigation' => !$rejection->sent_to_litigation
        ]);

        $msg = $rejection->sent_to_litigation ? 'Dossier envoyé au Contentieux (Tribunal).' : 'Dossier retiré du Contentieux.';
        return redirect()->back()->with('success', $msg);
    }

    public function resolve(Request $request, Rejection $rejection)
    {
        $rejection->update([
            'resolved' => true,
            'reason' => $request->resolution_note ?? $rejection->reason
        ]);

        return redirect()->back()->with('success', 'Dossier clôturé avec succès.');
    }
}
