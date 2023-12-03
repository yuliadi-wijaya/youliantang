<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExTherapistTotal implements FromCollection, WithHeadings
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
}
