<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExCustomerReg implements FromCollection, WithHeadings
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
}
