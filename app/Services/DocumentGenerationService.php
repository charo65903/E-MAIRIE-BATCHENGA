<?php

namespace App\Services;

use App\Models\Demande;
use App\Models\DocumentGenere;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DocumentGenerationService
{
    /**
     * Génère le PDF du document administratif + son QR code de vérification.
     * QR généré en SVG (et non PNG) pour ne pas dépendre de l'extension PHP gd,
     * absente sur certains environnements Windows.
     */
    public function genererPourDemande(Demande $demande): DocumentGenere
    {
        $reference = 'DOC-'.now()->format('Y').'-'.str_pad((string) $demande->id, 4, '0', STR_PAD_LEFT);

        $urlVerification = route('verification.document', ['reference' => $reference]);

        $qrCodePath = 'qrcodes/'.$reference.'.svg';
        Storage::disk('public')->put(
            $qrCodePath,
            QrCode::format('svg')->size(300)->generate($urlVerification)
        );

        $pdf = Pdf::loadView('documents.attestation', [
            'demande' => $demande,
            'reference' => $reference,
        ]);

        $cheminPdf = 'documents/'.$reference.'.pdf';
        Storage::disk('public')->put($cheminPdf, $pdf->output());

        return DocumentGenere::updateOrCreate(
            ['demande_id' => $demande->id],
            [
                'reference' => $reference,
                'chemin_fichier' => $cheminPdf,
                'qr_code_path' => $qrCodePath,
                'date_generation' => now(),
            ]
        );
    }
}
