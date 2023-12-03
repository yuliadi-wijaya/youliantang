<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExTherapistTransDetail implements FromCollection, WithHeadings
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
            'Grand Total',
            'Amount',
            'Product Name',
            'Therapist Name',
            'Room',
            'Time From',
            'Time To',
        ];
    }
}
