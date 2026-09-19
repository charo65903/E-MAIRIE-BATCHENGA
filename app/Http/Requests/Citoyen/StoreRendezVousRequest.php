<?php

namespace App\Http\Requests\Citoyen;

use App\Models\RendezVous;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreRendezVousRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:services,id'],
            'motif' => ['nullable', 'string', 'max:255'],
            'date_rdv' => ['required', 'date', 'after_or_equal:today'],
            'creneau' => ['required', 'date_format:H:i'],
        ];
    }

    /**
     * Empêche le double-booking : un créneau déjà pris (statut != annule)
     * pour ce service à cette date ne peut pas être repris (§11).
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $conflit = RendezVous::where('service_id', $this->service_id)
                ->where('date_rdv', $this->date_rdv)
                ->where('creneau', $this->creneau)
                ->where('statut', '!=', 'annule')
                ->when($this->route('rendezVous'), fn ($q, $rdv) => $q->whereNot('id', $rdv->id))
                ->exists();

            if ($conflit) {
                $validator->errors()->add('creneau', 'Ce créneau vient d\'être pris. Merci d\'en choisir un autre.');
            }
        });
    }
}
