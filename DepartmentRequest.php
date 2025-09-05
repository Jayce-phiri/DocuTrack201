<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Department;
use Illuminate\Validation\Rule;

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
        'department_code' => [
            'required',
            'string',
            'max:255',
            Rule::in(array_keys(Department::ALLOWED_DEPARTMENTS_CODES)), // only allowed codes
        ],
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::in(array_values(Department::ALLOWED_DEPARTMENTS_CODES)), // only allowed names
        ],
        'description' => ['nullable', 'string'],
    ];
}

    public function messages(): array
{
    return [
        'department_code.required' => 'Department code is required.',
        'department_code.string'   => 'Department code must be a string.',
        'department_code.max'      => 'Department code may not be greater than 255 characters.',
        'department_code.in'       => 'The selected department code is invalid.',

        'name.required' => 'Department name is required.',
        'name.string'   => 'Department name must be a string.',
        'description.max'      => 'Description may not be greater than 255 characters.',
        'name.in'       => 'The selected department name is invalid.',

        'description.string' => 'Description must be a string.',
    ];
}
}
