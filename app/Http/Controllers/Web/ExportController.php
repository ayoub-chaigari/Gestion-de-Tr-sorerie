<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingCheque;
use App\Models\OutgoingCheque;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportJson()
    {
        $data = [
            'company' => auth()->user()->company->name ?? 'Indépendant',
            'export_date' => now()->toDateTimeString(),
            'summary' => [
                'total_incoming' => IncomingCheque::whereIn('status', ['deposited', 'paid'])->sum('amount'),
                'total_outgoing' => OutgoingCheque::where('status', 'paid')->sum('amount'),
            ],
            'recent_cheques' => IncomingCheque::with('contact')->latest()->limit(50)->get(),
        ];

        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="treasury_report_' . now()->format('Ymd') . '.json"'
        ]);
    }

    public function exportCsv()
    {
        $cheques = IncomingCheque::with('contact')->get();
        $callback = function() use($cheques) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Numero', 'Client', 'Montant', 'Statut']);

            foreach ($cheques as $cheque) {
                fputcsv($file, [
                    $cheque->due_date,
                    $cheque->cheque_number,
                    $cheque->contact->name ?? 'N/A',
                    $cheque->amount,
                    $cheque->status
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'report_' . now()->format('Ymd') . '.csv');
    }

    public function printReport()
    {
        $incoming = IncomingCheque::whereIn('status', ['paid', 'deposited'])->sum('amount');
        $outgoing = OutgoingCheque::where('status', 'paid')->sum('amount');
        $solde = $incoming - $outgoing;
        $cheques = IncomingCheque::with('contact')->latest()->get();

        // Calculate 6-month evolution for the PDF
        $evolutionData = [];
        $cumulative = 0;
        
        // Initial cumulative balance before the 6-month window
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        $cumulative = IncomingCheque::whereIn('status', ['paid', 'deposited'])
                        ->where('due_date', '<', $sixMonthsAgo->toDateString())
                        ->sum('amount') 
                    - 
                    OutgoingCheque::where('status', 'paid')
                        ->where('due_date', '<', $sixMonthsAgo->toDateString())
                        ->sum('amount');

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $inc = IncomingCheque::whereYear('due_date', $month->year)
                                ->whereMonth('due_date', $month->month)
                                ->whereIn('status', ['paid', 'deposited'])
                                ->sum('amount');
            $out = OutgoingCheque::whereYear('due_date', $month->year)
                                ->whereMonth('due_date', $month->month)
                                ->where('status', 'paid')
                                ->sum('amount');
            
            $net = $inc - $out;
            $cumulative += $net;

            $evolutionData[] = [
                'month'    => $month->translatedFormat('F Y'),
                'incoming' => $inc,
                'outgoing' => $out,
                'net'      => $net,
                'balance'  => $cumulative
            ];
        }

        return view('exports.print_report', compact('incoming', 'outgoing', 'solde', 'cheques', 'evolutionData'));
    }
}
