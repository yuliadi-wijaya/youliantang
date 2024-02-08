<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportInvoiceExport implements FromCollection, WithHeadings
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
        // Define column headings
        return [
            'Invoice No',
            'Invoice Date',
            'Customer Name',
            'Customer Phone',
            'Payment Mode',
            'Payment Status',
            'Note',
            'Total_price',
            'Discount',
            'Grand Total',
            'Product Name',
            'Amount',
            'Duration',
            'Treatment Date',
            'Treatment Time From',
            'Treatment Time To',
            'Room',
            'Therapist Name',
            'Therapist Phone',
            'Commission Fee',
        ];
    }
}
