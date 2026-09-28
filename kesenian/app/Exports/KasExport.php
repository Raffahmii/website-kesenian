<?php

namespace App\Exports;

use App\Models\KasPembayaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        protected ?string $periode = null,
        protected ?string $status = null,
        protected ?string $kategori = null,
        protected ?string $cabang = null
    ) {}

    public function collection()
    {
        $query = KasPembayaran::with(['user', 'kategori', 'pencatat']);

        if ($this->periode)  $query->where('periode_bulan', $this->periode);
        if ($this->status)   $query->where('status', $this->status);
        if ($this->kategori) $query->where('id_kategori', $this->kategori);
        if ($this->cabang)   $query->whereHas('user', fn($q) => $q->where('cabang', $this->cabang));

        return $query->orderByDesc('periode_bulan')->orderByDesc('created_at')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Periode',
            'Nama Anggota',
            'NIS',
            'Kelas',
            'Cabang',
            'Kategori',
            'Nominal',
            'Status',
            'Tanggal Bayar',
            'Dicatat Oleh',
        ];
    }

    public function map($kas): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $kas->periode_bulan,
            $kas->user->nama_lengkap ?? '-',
            $kas->user->nis ?? '-',
            ($kas->user->kelas ?? '') . ' ' . ($kas->user->jurusan ?? ''),
            $kas->user->cabang?->shortLabel() ?? '-',
            $kas->kategori->nama ?? '-',
            $kas->nominal,
            $kas->status->label(),
            $kas->tanggal_bayar?->format('d/m/Y') ?? '-',
            $kas->pencatat->nama_lengkap ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}