<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #1f2937; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 16px; margin: 0; }
        .header p { font-size: 11px; color: #6b7280; margin: 2px 0; }
        .titre { text-align: center; font-size: 15px; font-weight: bold; margin: 25px 0; text-decoration: underline; }
        table { width: 100%; margin-top: 20px; }
        td { padding: 6px 0; }
        .label { color: #6b7280; width: 180px; }
        .footer { margin-top: 60px; text-align: center; }
        .footer img { width: 90px; }
        .ref { font-size: 10px; color: #9ca3af; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RÉPUBLIQUE DU CAMEROUN</h1>
        <p>Paix — Travail — Patrie</p>
        <p>MAIRIE DE BATCHENGA</p>
    </div>

    <div class="titre">{{ $demande->service->nom }}</div>

    <table>
        <tr>
            <td class="label">Bénéficiaire</td>
            <td>{{ $demande->citoyen->prenom }} {{ $demande->citoyen->nom }}</td>
        </tr>
        <tr>
            <td class="label">Objet de la demande</td>
            <td>{{ $demande->description ?: $demande->service->nom }}</td>
        </tr>
        <tr>
            <td class="label">Date de délivrance</td>
            <td>{{ now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Référence du document</td>
            <td>{{ $reference }}</td>
        </tr>
    </table>

    <div class="footer">
        <img src="{{ storage_path('app/public/qrcodes/'.$reference.'.svg') }}" alt="QR Code">
        <p class="ref">Scannez ce code pour vérifier l'authenticité du document.</p>
    </div>
</body>
</html>
