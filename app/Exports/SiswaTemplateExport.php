<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SiswaTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        return [
            'username',
            'email',
            'password',
            'nama_lengkap',
            'nisn',
            'nis',
            'jenis_kelamin',
        ];
    }

    public function array(): array
    {
        return [
            [
                'ahmad_pratama',
                'ahmad@siswa.sdn3krenceng.sch.id',
                'password123',
                'Ahmad Pratama Putra',
                '0123456789',
                '2024001',
                'L',
            ],
            [
                'siti_rahma',
                'siti@siswa.sdn3krenceng.sch.id',
                'password123',
                'Siti Rahmawati',
                '0123456790',
                '2024002',
                'P',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '198754'], // Bootstrap success green color
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
