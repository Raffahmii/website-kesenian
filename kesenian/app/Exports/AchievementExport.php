<?php

namespace App\Exports;

use App\Models\Prestasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AchievementExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        protected ?string $tingkat = null,
        protected ?int $tahun = null
    ) {}

    public function collection()
    {
        $query = Prestasi::with('peserta.user');
        if ($this->tingkat) $query->where('tingkat', $this->tingkat);
        if ($this->tahun)   $query->where('tahun', $this->tahun);
        return $query->orderByDesc('tahun')->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama Lomba', 'Kategori', 'Tingkat', 'Peringkat', 'Tahun', 'Penyelenggara', 'Peserta'];
    }

    public function map($p): array
    {
        static $no = 0;
        $no++;
        $peserta = $p->peserta->map(fn($ps) => $ps->user->nama_lengkap ?? '-')->implode(', ');
        return [
            $no,
            $p->nama_lomba,
            $p->kategori ?? '-',
            $p->tingkat->label(),
            $p->peringkat ?? '-',
            $p->tahun,
            $p->penyelenggara ?? '-',
            $peserta ?: '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true, 'size' => 12]]];
    }
}