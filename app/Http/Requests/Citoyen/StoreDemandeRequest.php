<?php

namespace App\Http\Requests\Citoyen;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Contrôle des extensions et de la taille des pièces jointes (§22 sécurité).
     */
    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:services,id'],
            'description' => ['nullable', 'string', 'max:2000'],
            'pieces' => ['nullable', 'array'],
            'pieces.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'pieces.*.mimes' => 'Chaque pièce jointe doit être un PDF, JPG ou PNG.',
            'pieces.*.max' => 'Chaque pièce jointe ne doit pas dépasser 5 Mo.',
        ];
    }
}
