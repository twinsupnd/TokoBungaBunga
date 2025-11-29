<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        // Only a manager may update admin accounts
        return $user && $user->role === 'manager';
    }

    public function rules(): array
    {
        // When updating, the email must be unique except for the current user
        $adminId = $this->route('admin')?->id ?? $this->route('user')?->id ?? null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $adminId],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            // status: active => email_verified_at set, inactive => email_verified_at null
            'status' => ['nullable', 'in:active,inactive'],
        ];
    }
}
