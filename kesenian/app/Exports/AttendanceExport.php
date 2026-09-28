<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        protected ?string $dari = null,
        protected ?string $sampai = null,
        protected ?string $cabang = null
    ) {}

    public function collection()
    {
        $query = Absensi::with(['user', 'jadwal']);

        if ($this->dari)   $query->whereDate('created_at', '>=', $this->dari);
        if ($this->sampai) $query->whereDate('created_at', '<=', $this->sampai);
        if ($this->cabang) $query->whereHas('user', fn($q) => $q->where('cabang', $this->cabang));

        return $query->orderByDesc('created_at')->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama Anggota', 'NIS', 'Cabang', 'Kegiatan', 'Tanggal Kegiatan', 'Status', 'Keterangan', 'Waktu Absen'];
    }

    public function map($a): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $a->user->nama_lengkap ?? '-',
            $a->user->nis ?? '-',
            $a->user->cabang?->shortLabel() ?? '-',
            $a->jadwal->judul ?? '-',
            $a->jadwal?->tanggal?->format('d/m/Y') ?? '-',
            $a->status->label(),
            $a->keterangan ?? '-',
            $a->waktu_absen?->format('d/m/Y H:i') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }
}