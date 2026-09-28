<?php

namespace App\Http\Requests;

use App\Enums\TargetPengumuman;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-members') || $this->user()->can('access-admin');
    }

    public function rules(): array
    {
        return [
            'judul'        => ['required', 'string', 'max:150'],
            'isi'          => ['required', 'string'],
            'target_role'  => ['required', Rule::enum(TargetPengumuman::class)],
            'lampiran'     => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:10240'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'       => 'Judul pengumuman wajib diisi.',
            'isi.required'         => 'Isi pengumuman wajib diisi.',
            'target_role.required' => 'Target pengumuman wajib dipilih.',
            'lampiran.max'         => 'Lampiran maksimal 10MB.',
        ];
    }
}