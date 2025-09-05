<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Document;

class DocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
{
    $allowedFormats = ['png','jpg','jpeg','pdf','xml','doc','docx','xls','xlsx'];

    return [
        'type'   => ['required', Rule::in(Document::ALLOWED_TYPES)],
        'file'   => ['required','file','mimes:'.implode(',', $allowedFormats),'max:2048'],
        // 'employee_nrc'  => auth()->user()->employee->nrc,

    ];
}

    public function messages(): array
{
    return [
        'type.required' => 'Please select a document type.',
        'type.in'       => 'The selected document type is invalid.',
        'file.required' => 'Please upload a document file.',
        'file.mimes'    => 'The document must be a file of type: png, jpg, jpeg, pdf, xml, doc, docx, xls, xlsx.',
        'file.max'      => 'The document may not be greater than 2MB.',
    ];
}
}
