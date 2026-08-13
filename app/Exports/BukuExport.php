<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BukuExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Buku::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul Buku',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'Stok',
            'Dibuat Pada',
            'Diperbarui Pada'
        ];
    }

    public function map($buku): array
    {
        return [
            $buku->id,
            $buku->judul,
            $buku->pengarang,
            $buku->penerbit,
            $buku->tahun_terbit,
            $buku->stok,
            $buku->created_at->format('Y-m-d H:i:s'),
            $buku->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
