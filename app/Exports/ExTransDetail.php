<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExTransDetail implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
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
            'Invoice Date',
            'Customer Name',
            'Customer Phone',
            'Treatment Date',
            'Payment Mode',
            'Payment Status',
            'Note',
            'Is Member',
            'Use Member',
            'Voucher Code',
            'Total Price',
            'Discount',
            'Grand Total',
            'Therapist Name',
            'Therapist Phone',
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
        $sheet->getStyle('A1:Y1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '808080'],
            ],
        ]);

        $sheet->getStyle('A1:Y1')->getAlignment()->setWrapText(false);
        $sheet->getStyle('A2:Y' . $this->report->count())->getAlignment()->setWrapText(false);

        $lastRow = $sheet->getHighestRow();

        $sheet->mergeCells("A{$lastRow}:K{$lastRow}");
        $sheet->setCellValue("A{$lastRow}", 'Total Revenue');
        $sheet->getStyle("A{$lastRow}:K{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A{$lastRow}:Y{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Add total revenue row below the existing total row
        $newRow = $lastRow - 1;
        $sheet->mergeCells("A{$newRow}:K{$newRow}");
        $sheet->setCellValue("A{$newRow}", 'Total');
        $sheet->getStyle("A{$newRow}:K{$newRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A{$newRow}:Y{$newRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'N' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'W' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
