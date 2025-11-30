<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
        // Normalize times so validation accepts H:i (e.g. "10 . 00 . 00", "10:00:00" => "10:00")
        $normalize = function ($value) {
            if (! $value) return $value;
            // remove spaces
            $v = preg_replace('/\s+/', '', $value);
            // convert dots to colons
            $v = str_replace('.', ':', $v);
            // if contains seconds, trim to H:i
            if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $v)) {
                $v = substr($v, 0, 5);
            }
            // if format like HHMM (e.g., 1000) try to insert colon
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
