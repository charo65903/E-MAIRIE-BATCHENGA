<?php

namespace App\Http\Controllers;

use App\Models\Service;

class PublicController extends Controller
{
    public function accueil()
    {
        $services = Service::where('actif', true)->orderBy('nom')->take(6)->get();

        return view('public.accueil', compact('services'));
    }

    public function services()
    {
        $services = Service::where('actif', true)->orderBy('nom')->get();

        return view('public.services', compact('services'));
    }
}
