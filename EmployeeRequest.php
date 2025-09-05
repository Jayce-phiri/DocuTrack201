<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Employee;
use App\Models\Department;
class EmployeeRequest extends FormRequest
{
   
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
            'department_code' => ['required','string',Rule::in(array_keys(Department::ALLOWED_DEPARTMENTS_CODES)),Rule::unique(Department::class, 'department_code')],
        ];
    }
}
