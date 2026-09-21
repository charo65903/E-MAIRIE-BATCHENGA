<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('nom')->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request)
    {
        Service::create([...$request->validated(), 'actif' => true]);

        return redirect()->route('admin.services.index')->with('success', 'Service créé.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(StoreServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return redirect()->route('admin.services.index')->with('success', 'Service mis à jour.');
    }

    /**
     * Pas de suppression physique (le service peut être référencé par des
     * demandes/rendez-vous existants) : on bascule juste actif/inactif,
     * ce qui le retire du catalogue visible côté citoyen.
     */
    public function basculerActif(Service $service)
    {
        $service->update(['actif' => ! $service->actif]);

        return back()->with('success', $service->actif ? 'Service activé.' : 'Service désactivé.');
    }
}
