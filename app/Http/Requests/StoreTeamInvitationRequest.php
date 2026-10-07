<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route is already protected by role:admin
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'  => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_MEMBER])],
            // No company_id rule on purpose: it is never read from the form
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'A user with this email already exists.',
        ];
    }
}