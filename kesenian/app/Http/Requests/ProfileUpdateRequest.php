<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email'        => [
                'required', 'string', 'lowercase', 'email', 'max:100',
                Rule::unique('users', 'email')->ignore($this->user()->id_user, 'id_user'),
            ],
            'nis'          => ['nullable', 'string', 'max:20'],
            'kelas'        => ['nullable', 'string', 'max:20'],
            'jurusan'      => ['nullable', 'string', 'max:50'],
            'angkatan'     => ['nullable', 'string', 'max:10'],
            'phone'        => ['nullable', 'string', 'max:15'],
            'bio'          => ['nullable', 'string', 'max:255'],
            'photo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cover_photo'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}