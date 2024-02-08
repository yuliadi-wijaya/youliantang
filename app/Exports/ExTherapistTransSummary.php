<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExTherapistTransSummary implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
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
            'Therapist Name',
            'Phone Number',
            'Treatment Date',
            'Duration (Minutes)',
            'Commission Fee',
            'Rating',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '808080'],
            ],
        ]);

        $sheet->getStyle('A1:F1')->getAlignment()->setWrapText(false);
        $sheet->getStyle('A2:F' . $this->report->count())->getAlignment()->setWrapText(false);

        $lastRow = $sheet->getHighestRow();

        $sheet->mergeCells("A{$lastRow}:C{$lastRow}");
        $sheet->setCellValue("A{$lastRow}", 'Total');
        $sheet->getStyle("A{$lastRow}:C{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A{$lastRow}:F{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
