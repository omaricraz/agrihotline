<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'complainant_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'location' => ['required', 'string', 'max:255'],
            'region' => ['required', Rule::in(config('complaints.regions'))],
            'department' => ['required', Rule::in(config('complaints.departments'))],
            'description' => ['required', 'string'],
            'priority' => ['required', Rule::in(array_keys(config('complaints.priorities')))],
        ];
    }
}
