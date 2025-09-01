<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'nrc' => ['required', 'string','regex:/^\d{6}\/\d{2}\/\d{1}$/',Rule::unique('employees', 'nrc')->ignore($this->employee)],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees,email'],
            'position' => ['required', 'string', 'max:255'],
            'department_code' => ['required', 'string', 'max:255', 'exists:departments,department_code'],
        ];
    }
}
