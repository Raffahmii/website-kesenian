<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-docs');
    }

    public function rules(): array
    {
        return [
            'judul'            => ['required', 'string', 'max:100'],
            'deskripsi'        => ['nullable', 'string'],
            'kategori'         => ['nullable', 'string', 'max:50'],
            'tanggal_kegiatan' => ['nullable', 'date'],
            'id_jadwal'        => ['nullable', 'exists:jadwal_kegiatan,id_jadwal'],
            'cover_image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'      => 'Judul album wajib diisi.',
            'cover_image.image'   => 'Cover harus berupa gambar.',
            'cover_image.max'     => 'Cover maksimal 5MB.',
        ];
    }
}