<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExTherapistTransDetail implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
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
            'Invoice Code',
            'Customer Name',
            'Treatment Date',
            'Payment Mode',
            'Payment Status',
            'Note',
            'Voucher Code',
            'Total Price',
            'Discount',
            'PPN (%)',
            'PPN Amount',
            'Grand Total',
            'Therapist Name',
            'Room',
            'Time From',
            'Time To',
            'Product Name',
            'Amount',
            'Duration (Minutes)',
            'Commission Fee',
            'Rating',
            'Comment',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:V1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '808080'],
            ],
        ]);

        $sheet->getStyle('A1:V1')->getAlignment()->setWrapText(false);
        $sheet->getStyle('A2:V' . $this->report->count())->getAlignment()->setWrapText(false);

        $lastRow = $sheet->getHighestRow();

        $sheet->mergeCells("A{$lastRow}:G{$lastRow}");
        $sheet->setCellValue("A{$lastRow}", 'Total');
        $sheet->getStyle("A{$lastRow}:G{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A{$lastRow}:V{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
