<?php

namespace App\Http\Controllers;

use App\RoleAccess;
use App\ReportCustomerReg;
use App\ReportTrans;
use App\InvoiceDetail;
use App\User;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Exports\ExCustomerReg;
use App\Exports\ExCustomerTrans;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportCustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }

    public function fiterReportReg()
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.filter')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        return view('report.customer.filter-customer-reg', compact('user', 'role'));
    }

    public function showReportCustomerReg(Request $request)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.view')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Validate input data
        $validatedData = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after:date_from',
        ]);

        $dateFrom = date('Y-m-d', strtotime($validatedData['date_from']));
        $dateTo = date('Y-m-d', strtotime($validatedData['date_to']));
        $is_member = $request->is_member;

        $report = ReportCustomerReg::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('register_date', [$dateFrom, $dateTo]);
        })
        ->when($is_member !== 'All', function ($query) use ($is_member) {
            return $query->where('is_member', $is_member);
        })
        ->get();

        return view('report.customer.customer-reg', compact('user', 'role', 'report', 'dateFrom', 'dateTo','is_member'));
    }

    public function exportReportCustomerReg(Request $request)
    {
        $dateFrom = date('Y-m-d', strtotime($request->dateFrom));
        $dateTo = date('Y-m-d', strtotime($request->dateTo));
        $is_member = $request->is_member;

        $report = ReportCustomerReg::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('register_date', [$dateFrom, $dateTo]);
        })
        ->when($is_member !== 'All', function ($query) use ($is_member) {
            return $query->where('is_member', $is_member);
        })
        ->get();

        $total_customer = 0;
        $total_member = 0;

        $reportNew = new Collection();

        foreach ($report as $index => $row) {
            $total_customer += 1;

            if ($row->is_member == 1) {
                $is_member = 'Yes';
                $total_member += 1;
            }else{
                $is_member = 'No';
            }

            $reportNew->push([
                'A' => $index + 1,
                'B' => $row->customer_name,
                'C' => $row->phone_number,
                'D' => $row->email,
                'E' => date('d-m-Y', strtotime($row->register_date)),
                'F' => $row->place_of_birth,
                'G' => date('d-m-Y', strtotime($row->birth_date)),
                'H' => $row->gender,
                'I' => $row->address,
                'J' => $row->emergency_name,
                'K' => $row->emergency_contact,
                'L' => $row->customer_status,
                'M' => $row->is_member,
                'N' => $row->member_plan,
                'O' => $row->member_status,
                'P' => ($row->is_member == 1) ? date('d-m-Y', strtotime($row->start_member)) : '',
                'Q' => ($row->is_member == 1) ? date('d-m-Y', strtotime($row->expired_date)) : '',
            ]);
        }

        $reportNew->push([
            'A' => '',
            'B' => '',
            'C' => $total_customer,
            'D' => 'Total Member : ',
            'E' => $total_member,
            'F' => '',
            'G' => '',
            'H' => '',
            'I' => '',
            'J' => '',
            'K' => '',
            'L' => '',
            'M' => '',
            'N' => '',
            'O' => '',
            'P' => '',
            'Q' => '',
        ]);

        $fileName = 'report_customer_registration_' . Carbon::parse($dateFrom)->format('Ymd') . '_' . Carbon::parse($dateTo)->format('Ymd') . '.xlsx';

        return Excel::download(new ExCustomerReg($reportNew), $fileName);
    }

    public function fiterReportTrans()
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.filter')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        return view('report.customer.filter-customer-trans', compact('user', 'role'));
    }

    public function showReportCustomerTrans(Request $request)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.view')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Validate input data
        $validatedData = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after:date_from',
        ]);

        $dateFrom = date('Y-m-d', strtotime($validatedData['date_from']));
        $dateTo = date('Y-m-d', strtotime($validatedData['date_to']));

        $invoice_type = RoleAccess::where('user_id', $user->id)->first()->access_code;

        $report = ReportTrans::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('treatment_date', [$dateFrom, $dateTo]);
        })
        ->when($invoice_type === 'NC', function ($query) {
            return $query->where('invoice_type', 'NC');
        })
        ->when($invoice_type === 'CK', function ($query) {
            return $query->where('invoice_type', 'CK');
        })
        ->get();

        $report_detail = [];

        foreach ($report as $r) {
            if($r->old_data == 'N'){
                $detail = InvoiceDetail::select(
                    'products.name as product_name',
                    'invoice_details.amount',
                    'invoice_details.treatment_time_from',
                    'invoice_details.treatment_time_to',
                    'invoice_details.room',
                    \DB::raw("CONCAT(COALESCE(users.first_name,''), ' ', COALESCE(users.last_name,'')) as therapist_name")
                )
                ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
                ->join('products', 'products.id', '=', 'invoice_details.product_id')
                ->where('invoice_details.invoice_id', $r->invoice_id)
                ->where('invoice_details.is_deleted', 0)
                ->where('invoice_details.status', 1)
                ->get();
            }else{
                $detail = InvoiceDetail::select(
                    'products.name as product_name',
                    'invoice_details.amount'
                )
                ->join('products', \DB::raw('LOWER(products.name)'), '=', \DB::raw('LOWER(invoice_details.title)'))
                ->where('invoice_details.invoice_id', $r->invoice_id)
                ->where('invoice_details.is_deleted', 0)
                ->where('invoice_details.status', 1)
                ->get();
            }

            $report_detail[$r->invoice_id] = $detail;
        }

        return view('report.customer.customer-trans', compact('user', 'role', 'report', 'report_detail', 'dateFrom', 'dateTo'));
    }

    public function exportReportCustomerTrans(Request $request)
    {
        $user = Sentinel::getUser();

        $dateFrom = date('Y-m-d', strtotime($request->dateFrom));
        $dateTo = date('Y-m-d', strtotime($request->dateTo));

        $invoice_type = RoleAccess::where('user_id', $user->id)->first()->access_code;

        $report = ReportTrans::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('treatment_date', [$dateFrom, $dateTo]);
        })
        ->when($invoice_type === 'NC', function ($query) {
            return $query->where('invoice_type', 'NC');
        })
        ->when($invoice_type === 'CK', function ($query) {
            return $query->where('invoice_type', 'CK');
        })
        ->get();

        $report_detail = [];
        $sub_price = 0;
        $sub_discount = 0;
        $sub_grand_total = 0;

        $reportNew = new Collection();

        foreach ($report as $index => $row) {
            $customer_name = ($index > 0 && $row->customer_id == $report[$index - 1]->customer_id) ? '' : $row->customer_name;
            $customer_phone = ($index > 0 && $row->customer_id == $report[$index - 1]->customer_id) ? '' : $row->customer_phone;
            $email = ($index > 0 && $row->customer_id == $report[$index - 1]->customer_id) ? '' : $row->email;

            $detail = ($row->old_data == 'N')
                ? InvoiceDetail::select(
                    'products.name as product_name',
                    'invoice_details.amount',
                    'invoice_details.treatment_time_from',
                    'invoice_details.treatment_time_to',
                    'invoice_details.room',
                    \DB::raw("CONCAT(COALESCE(users.first_name,''), ' ', COALESCE(users.last_name,'')) as therapist_name")
                )
                ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
                ->join('products', 'products.id', '=', 'invoice_details.product_id')
                ->where('invoice_details.invoice_id', $row->invoice_id)
                ->where('invoice_details.is_deleted', 0)
                ->where('invoice_details.status', 1)
                ->get()
                : InvoiceDetail::select(
                    'products.name as product_name',
                    'invoice_details.amount'
                )
                ->join('products', \DB::raw('LOWER(products.name)'), '=', \DB::raw('LOWER(invoice_details.title)'))
                ->where('invoice_details.invoice_id', $row->invoice_id)
                ->where('invoice_details.is_deleted', 0)
                ->where('invoice_details.status', 1)
                ->get();

            $report_detail[$row->invoice_id] = $detail;

            $sub_price += $row->total_price;
            $sub_discount += $row->discount;
            $sub_grand_total += $row->grand_total;

            $reportNew->push([
                'A' => $customer_name,
                'B' => $customer_phone,
                'C' => $email,
                'D' => $row->invoice_code,
                'E' => date('d-m-Y', strtotime($row->treatment_date)),
                'F' => $row->payment_mode,
                'G' => $row->payment_status,
                'H' => $row->note,
                'I' => $row->is_member,
                'J' => $row->use_member,
                'K' => $row->member_plan,
                'L' => $row->voucher_code,
                'M' => $row->total_price,
                'N' => $row->discount,
                'O' => $row->grand_total,
                'P' => '',
                'Q' => '',
                'R' => ($row->old_data == 'Y') ? $row->therapist_name : '',
                'S' => ($row->old_data == 'Y') ? $row->room : '',
                'T' => ($row->old_data == 'Y') ? $row->time_from : '',
                'U' => ($row->old_data == 'Y') ? $row->time_to : '',
            ]);

            foreach ($report_detail[$row->invoice_id] as $rd) {
                $reportNew->push([
                    'A' => '',
                    'B' => '',
                    'C' => '',
                    'D' => '',
                    'E' => '',
                    'F' => '',
                    'G' => '',
                    'H' => '',
                    'I' => '',
                    'J' => '',
                    'K' => '',
                    'L' => '',
                    'M' => '',
                    'N' => '',
                    'O' => '',
                    'P' => $rd->product_name,
                    'Q' => $rd->amount,
                    'R' => ($row->old_data == 'Y') ? '' : $rd->therapist_name,
                    'S' => ($row->old_data == 'Y') ? '' : $rd->room,
                    'T' => ($row->old_data == 'Y') ? '' : $rd->treatment_time_from,
                    'U' => ($row->old_data == 'Y') ? '' : $rd->treatment_time_to,
                ]);
            }
        }

        $reportNew->push([
            'A' => '',
            'B' => '',
            'C' => '',
            'D' => '',
            'E' => '',
            'F' => '',
            'G' => '',
            'H' => '',
            'I' => '',
            'J' => '',
            'K' => '',
            'L' => '',
            'M' => $sub_price,
            'N' => $sub_discount,
            'O' => $sub_grand_total,
            'P' => '',
            'Q' => '',
            'R' => '',
            'S' => '',
            'T' => '',
            'U' => '',
        ]);

        $fileName = 'report_customer_transaction_' . Carbon::parse($dateFrom)->format('Ymd') . '_' . Carbon::parse($dateTo)->format('Ymd') . '.xlsx';

        return Excel::download(new ExCustomerTrans($reportNew), $fileName);
    }
}
