<?php

namespace App\Http\Controllers;

use App\Models\DocumentGenere;

class DocumentVerificationController extends Controller
{
    /**
     * Page publique accessible en scannant le QR code d'un document.
     * N'affiche que des informations non sensibles (pas de données
     * personnelles complètes) à des fins de vérification d'authenticité.
     */
    public function show(string $reference)
    {
        $document = DocumentGenere::where('reference', $reference)->with('demande.service')->first();

        return view('verification.show', compact('document', 'reference'));
    }
}
