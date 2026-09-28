<?php

namespace App\Http\Requests;

use App\Enums\TingkatPrestasi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAchievementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-docs') || $this->user()->can('access-admin');
    }

    public function rules(): array
    {
        return [
            'nama_lomba'    => ['required', 'string', 'max:100'],
            'kategori'      => ['nullable', 'string', 'max:50'],
            'tingkat'       => ['required', Rule::enum(TingkatPrestasi::class)],
            'peringkat'     => ['nullable', 'string', 'max:20'],
            'tahun'         => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'tanggal'       => ['nullable', 'date'],
            'penyelenggara' => ['nullable', 'string', 'max:100'],
            'lokasi'        => ['nullable', 'string', 'max:100'],
            'deskripsi'     => ['nullable', 'string'],
            'foto'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'peserta'       => ['nullable', 'array'],
            'peserta.*'     => ['exists:users,id_user'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lomba.required' => 'Nama lomba wajib diisi.',
            'tingkat.required'    => 'Tingkat wajib dipilih.',
            'tahun.required'      => 'Tahun wajib diisi.',
        ];
    }
}