<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MembersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        protected ?string $role = null,
        protected ?string $status = null,
        protected ?string $cabang = null
    ) {}

    public function collection()
    {
        $query = User::with('kepengurusan.jabatan');

        if ($this->role)   $query->where('role', $this->role);
        if ($this->status) $query->where('status_anggota', $this->status);
        if ($this->cabang) $query->where('cabang', $this->cabang);

        return $query->orderBy('nama_lengkap')->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama Lengkap', 'NIS', 'Email', 'Kelas', 'Jurusan', 'Angkatan', 'Cabang', 'Role', 'Status', 'No. HP'];
    }

    public function map($user): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $user->nama_lengkap,
            $user->nis ?? '-',
            $user->email,
            $user->kelas ?? '-',
            $user->jurusan ?? '-',
            $user->angkatan ?? '-',
            $user->cabang?->shortLabel() ?? '-',
            $user->role->label(),
            $user->status_anggota->label(),
            $user->phone ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }
}