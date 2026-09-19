<?php

namespace App\Http\Controllers\Citoyen;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('actif', true)->orderBy('nom')->get();

        return view('citoyen.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        abort_if(! $service->actif, 404);

        return view('citoyen.services.show', compact('service'));
    }
}
