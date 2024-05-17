<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'project_status_id' => 'required|integer|exists:project_statuses,id',
            'description' => 'required|string|max:3000',
            'date' => 'required|array',
            'date.*' => 'required|date',
            'files' => 'nullable|array',
        ];
    }
}
