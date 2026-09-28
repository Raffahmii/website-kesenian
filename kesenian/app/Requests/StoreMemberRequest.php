<?php

namespace App\Http\Requests;

use App\Enums\RoleUser;
use App\Enums\StatusAnggota;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-members');
    }

    public function rules(): array
    {
        $userId = $this->route('member')?->id_user;

        return [
            'nama_lengkap'   => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($userId, 'id_user')],
            'password'       => [$this->isMethod('POST') ? 'required' : 'nullable', 'string', 'min:8'],
            'nis'            => ['nullable', 'string', 'max:20', Rule::unique('users', 'nis')->ignore($userId, 'id_user')],
            'role'           => ['required', Rule::enum(RoleUser::class)],
            'kelas'          => ['nullable', 'string', 'max:20'],
            'jurusan'        => ['nullable', 'string', 'max:50'],
            'angkatan'       => ['nullable', 'string', 'max:10'],
            'status_anggota' => ['required', Rule::enum(StatusAnggota::class)],
            'phone'          => ['nullable', 'string', 'max:15'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'nis.unique'            => 'NIS sudah terdaftar.',
            'role.required'         => 'Role wajib dipilih.',
        ];
    }
}