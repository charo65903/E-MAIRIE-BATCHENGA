<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'documents_requis' => ['nullable', 'string', 'max:1000'],
            'tarif' => ['nullable', 'numeric', 'min:0'],
            'delai' => ['nullable', 'string', 'max:100'],
        ];
    }
}
