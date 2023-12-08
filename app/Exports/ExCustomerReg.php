<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExCustomerReg implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
            'Customer Name',
            'Phone Number',
            'Email',
            'Register Date',
            'Place Of Birth',
            'Birth Date',
            'Gender',
            'Address',
            'Emergency Name',
            'Emergency Contact',
            'Customer Status',
            'Is Member',
            'Member Plan',
            'Member Status',
            'Start Member',
            'Expired Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Q1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '808080'],
            ],
        ]);

        $sheet->getStyle('A1:Q1')->getAlignment()->setWrapText(false);
        $sheet->getStyle('A2:Q' . $this->report->count())->getAlignment()->setWrapText(false);

        $lastRow = $sheet->getHighestRow();

        $sheet->mergeCells("A{$lastRow}:B{$lastRow}");
        $sheet->setCellValue("A{$lastRow}", 'Total Customer : ');
        $sheet->getStyle("A{$lastRow}:B{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A{$lastRow}:Q{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->getStyle("D{$lastRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("C{$lastRow}")->getAlignment()->setHorizontal('left');
        $sheet->getStyle("E{$lastRow}")->getAlignment()->setHorizontal('left');
    }
}
