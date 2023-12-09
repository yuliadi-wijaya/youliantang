<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExTherapistTotal implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function collection()
    {
        return $this->report;
    }

    public function headings(): array
    {
        return [
            'No',
            'Therapist Name',
            'Status',
            'Register Date',
            'Phone Number',
            'Email',
            'Ktp',
            'Gender',
            'Place Of Birth',
            'Birth Date',
            'Address',
            'Rekening Number',
            'Emergency Name',
            'Emergency Contact',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '808080'],
            ],
        ]);

        $sheet->getStyle('A1:N1')->getAlignment()->setWrapText(false);
        $sheet->getStyle('A2:N' . $this->report->count())->getAlignment()->setWrapText(false);

        $lastRow = $sheet->getHighestRow();

        $sheet->mergeCells("A{$lastRow}:B{$lastRow}");
        $sheet->setCellValue("A{$lastRow}", 'Total Therapist : ');
        $sheet->getStyle("A{$lastRow}:B{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A{$lastRow}:N{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->getStyle("C{$lastRow}")->getAlignment()->setHorizontal('left');
    }
}
