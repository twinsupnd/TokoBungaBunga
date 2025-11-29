<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only admins or managers may manage events
        $user = $this->user();
        return $user && in_array($user->role, ['admin', 'manager'], true);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'all_day' => ['sometimes', 'boolean'],
            'color' => ['nullable', 'string', 'max:32'],
            'category' => ['nullable', 'string', 'max:100'],
        ];
    }
}
