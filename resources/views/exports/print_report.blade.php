<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Trésorerie - {{ now()->format('d/m/Y') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body class="bg-white p-12 text-slate-900 font-sans">
    <div class="flex justify-between items-center mb-12 border-b-4 border-slate-900 pb-8">
        <div>
            <h1 class="text-4xl font-black italic uppercase tracking-tighter">Treasury Statement</h1>
            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-1">Generated on {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-black">{{ auth()->user()->company->name ?? 'Indépendant' }}</h2>
            <p class="text-xs font-bold text-slate-400">RC: {{ auth()->user()->company->rc ?? 'N/A' }} • ICE: {{ auth()->user()->company->ice ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-8 mb-12">
        <div class="border-2 border-slate-900 p-6 rounded-3xl">
            <div class="text-[10px] font-black uppercase mb-1">Total Encaissements</div>
            <div class="text-2xl font-black">{{ number_format($incoming, 2) }} MAD</div>
        </div>
        <div class="border-2 border-slate-900 p-6 rounded-3xl">
            <div class="text-[10px] font-black uppercase mb-1">Total Décaissements</div>
            <div class="text-2xl font-black">{{ number_format($outgoing, 2) }} MAD</div>
        </div>
        <div class="bg-slate-900 text-white p-6 rounded-3xl shadow-xl">
            <div class="text-[10px] font-black uppercase mb-1 text-slate-400">Position Nette</div>
            <div class="text-2xl font-black">{{ number_format($solde, 2) }} MAD</div>
        </div>
    </div>
    <div class="bg-slate-900 text-white p-8 rounded-[2rem] mb-12">
        <h3 class="text-xs font-black uppercase tracking-[0.3em] mb-6 text-slate-400">Analyse de Flux (6 derniers mois)</h3>
        <table class="w-full text-left">
            <thead>
                <tr class="text-[9px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-800">
                    <th class="py-4">Période</th>
                    <th class="py-4">Recettes</th>
                    <th class="py-4">Dépenses</th>
                    <th class="py-4">Net Mensuel</th>
                    <th class="py-4 text-right">Position Finale</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @foreach($evolutionData as $m)
                <tr class="text-xs font-bold">
                    <td class="py-4 text-slate-300 uppercase italic">{{ $m['month'] }}</td>
                    <td class="py-4 text-emerald-400 font-black">+ {{ number_format($m['incoming'], 2) }}</td>
                    <td class="py-4 text-rose-400 font-black">- {{ number_format($m['outgoing'], 2) }}</td>
                    <td class="py-4 {{ $m['net'] >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                        {{ number_format($m['net'], 2) }}
                    </td>
                    <td class="py-4 text-right font-black text-base italic text-blue-400">
                        {{ number_format($m['balance'], 2) }} <span class="text-[9px]">DH</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h3 class="text-sm font-black uppercase tracking-[0.2em] mb-6 border-b-2 border-slate-100 pb-2">Détails des Titres (Cheques Recettes)</h3>
    <table class="min-w-full text-sm">
        <thead>
            <tr class="border-b-2 border-slate-900">
                <th class="py-3 text-left font-black uppercase text-[10px]">Date</th>
                <th class="py-3 text-left font-black uppercase text-[10px]">Référence</th>
                <th class="py-3 text-left font-black uppercase text-[10px]">Tiers</th>
                <th class="py-3 text-right font-black uppercase text-[10px]">Montant</th>
                <th class="py-3 text-right font-black uppercase text-[10px]">Statut</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 italic">
            @foreach($cheques as $cheque)
            <tr>
                <td class="py-4">{{ \Carbon\Carbon::parse($cheque->due_date)->format('d/m/Y') }}</td>
                <td class="py-4 font-mono font-bold">{{ $cheque->cheque_number }}</td>
                <td class="py-4 font-black text-slate-600">{{ $cheque->contact->name ?? 'N/A' }}</td>
                <td class="py-4 text-right font-black">{{ number_format($cheque->amount, 2) }}</td>
                <td class="py-4 text-right uppercase text-[9px] font-black">{{ $cheque->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-12 pt-12 border-t border-slate-100 flex justify-between items-end">
        <div class="text-[10px] text-slate-400 font-bold uppercase">
            Document généré par Treasury SaaS Monolith
        </div>
        <div class="text-center italic w-48 border-t border-slate-900 pt-4">
            <p class="text-xs font-black">Signature & Cachet</p>
        </div>
    </div>

    <div class="fixed bottom-8 right-8 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-8 py-4 rounded-full shadow-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all">
            Imprimer le Rapport (CTRL + P)
        </button>
    </div>
</body>
</html>
