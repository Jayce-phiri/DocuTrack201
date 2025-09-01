<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkFlowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

   
    public function rules(): array
    {
        return [
            'comments' => ['required', 'string'],
            'action' => ['required', 'string', 'in:pending,approve,rejected']
        ];
    }
}
