<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bordereau de Remise Bancaire - {{ $remittance->reference }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; padding: 40px; color: #333; line-height: 1.4; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 2px solid #000; pb-20px; }
        .logo { font-size: 24px; font-weight: bold; color: #1e293b; }
        .title-box { text-align: right; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; margin: 0; }
        .date { font-size: 12px; color: #666; margin-top: 5px; }
        
        .bank-info { margin-bottom: 30px; font-size: 14px; }
        .bank-info strong { text-transform: uppercase; font-size: 12px; color: #666; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 11px; }
        th { background: #f8fafc; border: 1px solid #000; padding: 10px 5px; text-transform: uppercase; font-weight: bold; text-align: center; }
        td { border: 1px solid #000; padding: 10px 5px; vertical-align: middle; text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .badge { display: inline-block; padding: 2px 5px; border-radius: 3px; font-size: 9px; font-weight: bold; }
        .badge-cheque { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .badge-effect { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }

        .footer { margin-top: 50px; border-top: 1px solid #eee; pt-20px; font-size: 10px; color: #999; text-align: center; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo" style="display: flex; align-items: center;">
            @php
                $depositoryBank = collect(\App\Http\Controllers\Web\TreasuryController::$banks)
                    ->firstWhere('name', $remittance->bankAccount->bank_name);
                $logoUrl = null;
                if ($remittance->bankAccount->logo_path) {
                    $logoUrl = asset('storage/' . $remittance->bankAccount->logo_path);
                } elseif ($depositoryBank && $depositoryBank['logo']) {
                    $logoUrl = asset('storage/' . $depositoryBank['logo']);
                }
            @endphp

            @if($logoUrl)
                <img src="{{ $logoUrl }}" height="80" border="0" style="margin-right: 20px;">
            @else
                <!-- Placeholder Bank Logo -->
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-right: 10px;">
                    <path d="M3 21H21V19H3V21ZM3 8V17H6V8H3ZM18 8V17H21V8H18ZM11 8V17H13V8H11ZM8 8V17H10V8H8ZM15 8V17H17V8H15ZM12 2L1 7V22H23V7L12 2ZM12 4.1L19.3 7.5H4.7L12 4.1Z" fill="black"/>
                </svg>
            @endif
            <span>{{ $remittance->bankAccount->bank_name ?? 'MA BANQUE' }}</span>
        </div>
        <div class="title-box">
            <h1 class="title">Bordereau de Remise de {{ $remittance->type === 'effect' ? 'Effets' : 'Chèques' }}</h1>
            <div class="date">Généré le : {{ now()->format('d/m/Y H:i') }}</div>
            <div class="date" style="font-weight: bold;">Réf : {{ $remittance->reference }}</div>
        </div>
    </div>

    <div class="bank-info">
        <div><strong>Compte de destination :</strong> {{ $remittance->bankAccount->rib }}</div>
        <div><strong>Date de dépôt :</strong> {{ \Carbon\Carbon::parse($remittance->remittance_date)->format('d/m/Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 20%;">N° Titre</th>
                <th style="width: 20%;">Date d'échéance</th>
                <th style="width: 40%;">Banque Emettrice</th>
                <th style="width: 20%;">Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($remittance->cheques as $cheque)
                <tr>
                    <td class="font-bold">{{ $cheque->cheque_number }}</td>
                    <td class="font-bold">
                        {{ \Carbon\Carbon::parse($cheque->due_date)->format('d/m/Y') }}
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                            @php
                                $drawerBank = collect(\App\Http\Controllers\Web\TreasuryController::$banks)->firstWhere('name', $cheque->bank_name);
                            @endphp
                            @if($drawerBank && $drawerBank['logo'])
                                <img src="{{ asset('storage/' . $drawerBank['logo']) }}" height="24" style="border-radius: 4px; vertical-align: middle;">
                            @endif
                            <span>{{ $cheque->bank_name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="font-bold">{{ number_format($cheque->amount, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot style="background: #f8fafc; color: #000; font-weight: bold; font-size: 14px;">
            <tr>
                <td colspan="2" class="text-right" style="border: 1px solid #000; vertical-align: middle;">
                    NOMBRE DE TITRES : <span style="font-size: 18px; margin-left: 10px;">{{ $remittance->cheques->count() }}</span>
                </td>
                <td class="text-right" style="border: 1px solid #000; border-right: none; vertical-align: middle;">TOTAL GÉNÉRAL :</td>
                <td class="text-right" style="border: 1px solid #000; border-left: none; vertical-align: middle;">{{ number_format($remittance->total_amount, 2, ',', ' ') }} DH</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-bottom: 40px; padding: 20px; background: #fdfaf6; border: 1px solid #e5e7eb; border-radius: 12px;">
        <div style="text-transform: uppercase; font-size: 10px; font-weight: black; color: #666; margin-bottom: 8px; letter-spacing: 0.05em;">Arrêté le présent bordereau à la somme de :</div>
        <div style="font-size: 16px; font-weight: bold; color: #111; font-style: italic;">
            *** {{ $remittance->amountInWords() }} ***
        </div>
    </div>

    <div style="margin-top: 60px; display: flex; justify-content: flex-end;">
        <div style="width: 300px; padding: 20px; border: 2px solid #333; border-radius: 15px; text-align: center;">
            <div style="text-transform: uppercase; font-size: 10px; font-weight: black; color: #666; margin-bottom: 50px;">Signature et Cachet du Client</div>
            <div style="height: 100px; border-bottom: 1px dashed #ccc;"></div>
        </div>
    </div>

    <div class="footer">
        Document généré par Treasury SaaS – {{ now()->format('d/m/Y H:i') }}
    </div>

    <div class="no-print" style="position: fixed; bottom: 30px; right: 30px;">
        <button onclick="window.print()" style="background: #000; color: #fff; padding: 15px 30px; border-radius: 50px; font-weight: bold; cursor: pointer; border: none; box-shadow: 0 10px 15px rgba(0,0,0,0.1);">
            IMPRIMER LE BORDEREAU
        </button>
    </div>
</body>
</html>
