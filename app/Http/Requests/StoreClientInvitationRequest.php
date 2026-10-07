<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
       
        // Route is already protected by role:superadmin
        return true;
    }

    public function rules(): array
    {
        return [
            // Either pick an existing company OR type a new company name
            'company_id'   => ['nullable', 'exists:companies,id', 'required_without:company_name'],
            'company_name' => ['nullable', 'string', 'max:255', 'required_without:company_id'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'A user with this email already exists.',
        ];
    }
}