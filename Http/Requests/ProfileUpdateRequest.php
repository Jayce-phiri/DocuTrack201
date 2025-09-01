<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
   
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','string','lowercase','email','max:255',Rule::unique(User::class)->ignore($this->user()->id)],
            'nrc' => ['required', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:100'],
            'department_code' => ['required', 'string', 'max:20'],
        
            
        ];
    }
}
