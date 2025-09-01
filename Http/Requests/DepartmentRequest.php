<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Department;
class DepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'department_code' => ['required', 'string', 'max:255', 'unique:departments,department_code'],
            'name'           => ['required', 'string', 'max:255','Rule::in(Department::ALLOWED_DEPARTMENTS_NAMES)'],
            'description'    => ['nullable', 'string'],
        ];
    }
}
