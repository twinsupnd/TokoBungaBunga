<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && in_array($user->role, ['admin', 'manager'], true);
    }

    public function rules(): array
    {
        return [
            'nama_acara' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'waktu_mulai' => ['required', 'date_format:H:i'],
            'waktu_selesai' => ['nullable', 'date_format:H:i', 'after_or_equal:waktu_mulai'],
            'tempat' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:Personal,Business'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $normalize = function ($value) {
            if (! $value) return $value;
            $v = preg_replace('/\s+/', '', $value);
            $v = str_replace('.', ':', $v);
            if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $v)) {
                $v = substr($v, 0, 5);
            }
            if (preg_match('/^\d{3,4}$/', $v)) {
                $v = substr($v, 0, -2) . ':' . substr($v, -2);
            }
            return $v;
        };

        $this->merge([
            'waktu_mulai' => $normalize($this->input('waktu_mulai')),
            'waktu_selesai' => $normalize($this->input('waktu_selesai')),
        ]);
    }
}
