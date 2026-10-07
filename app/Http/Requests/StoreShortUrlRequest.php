<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShortUrlRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route is already protected by role:admin,member
        return true;
    }

    public function rules(): array
    {
        return [
            // Only http/https, so javascript: and similar can't be stored
            'original_url' => ['required', 'url:http,https', 'max:2048'],
        ];
    }
}