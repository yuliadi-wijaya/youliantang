<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExCustomerTrans implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
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
            'Customer Name',
            'Phone Number',
            'Email',
            'Invoice Code',
            'Treatment Date',
            'Payment Mode',
            'Payment Status',
            'Note',
            'Is Member',
            'Use Member',
            'Member Plan',
            'Voucher Code',
            'Total Price',
            'Discount',
            'PPN (%)',
            'PPN Amount',
            'Grand Total',
            'Product Name',
            'Amount',
            'Therapist Name',
            'Room',
            'Time From',
            'Time To',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:W1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '808080'],
            ],
        ]);

        $sheet->getStyle('A1:W1')->getAlignment()->setWrapText(false);
        $sheet->getStyle('A2:W' . $this->report->count())->getAlignment()->setWrapText(false);

        $lastRow = $sheet->getHighestRow();

        $sheet->mergeCells("A{$lastRow}:L{$lastRow}");
        $sheet->setCellValue("A{$lastRow}", 'Total');
        $sheet->getStyle("A{$lastRow}:L{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A{$lastRow}:V{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Total Price
            'N' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Discount
            'P' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Tax_amount
            'Q' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Grand Total
            'R' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Amount
        ];
    }
}
