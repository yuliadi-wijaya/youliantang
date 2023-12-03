<?php

namespace App\Http\Controllers;

use App\ReportCustomerReg;
use App\ReportCustomerTrans;
use App\InvoiceSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Exports\ExCustomerReg;
use App\Exports\ExCustomerTrans;
use Maatwebsite\Excel\Facades\Excel;

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
                'no' => $index + 1,
                'customer_name' => $row->customer_name,
                'phone_number' => $row->phone_number,
                'email' => $row->email,
                'register_date' => $row->register_date,
                'place_of_birth' => $row->place_of_birth,
                'birth_date' => $row->birth_date,
                'gender' => $row->gender,
                'address' => $row->address,
                'emergency_name' => $row->emergency_name,
                'emergency_contact' => $row->emergency_contact,
                'customer_status' => $row->customer_status,
                'is_member' => $row->is_member,
                'member_plan' => $row->member_plan,
                'member_status' => $row->member_status,
                'start_member' => $row->start_member,
                'expired_date' => $row->expired_date,
            ]);
        }

        $reportNew->push([
            'no' => '',
            'customer_name' => 'Total Customer',
            'phone_number' => $total_customer,
            'email' => '',
            'register_date' => '',
            'place_of_birth' => '',
            'birth_date' => '',
            'gender' => '',
            'address' => '',
            'emergency_name' => '',
            'emergency_contact' => '',
            'customer_status' => '',
            'is_member' => '',
            'member_plan' => '',
            'member_status' => '',
            'start_member' => '',
            'expired_date' => '',
        ]);

        $reportNew->push([
            'no' => '',
            'customer_name' => 'Total Member',
            'phone_number' => $total_member,
            'email' => '',
            'register_date' => '',
            'place_of_birth' => '',
            'birth_date' => '',
            'gender' => '',
            'address' => '',
            'emergency_name' => '',
            'emergency_contact' => '',
            'customer_status' => '',
            'is_member' => '',
            'member_plan' => '',
            'member_status' => '',
            'start_member' => '',
            'expired_date' => '',
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

        $invoice_type = InvoiceSettings::first()->invoice_type;

        $report = ReportCustomerTrans::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('treatment_date', [$dateFrom, $dateTo]);
        })
        ->when($invoice_type === 'NC', function ($query) {
            return $query->where('invoice_type', 'NC');
        })
        ->when($invoice_type === 'CK', function ($query) {
            return $query->where('invoice_type', 'CK');
        })
        ->get();

        return view('report.customer.customer-trans', compact('user', 'role', 'report', 'dateFrom', 'dateTo'));
    }

    public function exportReportCustomerTrans(Request $request)
    {
        $dateFrom = date('Y-m-d', strtotime($request->dateFrom));
        $dateTo = date('Y-m-d', strtotime($request->dateTo));

        $invoice_type = InvoiceSettings::first()->invoice_type;

        $report = ReportCustomerTrans::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('treatment_date', [$dateFrom, $dateTo]);
        })
        ->when($invoice_type === 'NC', function ($query) {
            return $query->where('invoice_type', 'NC');
        })
        ->when($invoice_type === 'CK', function ($query) {
            return $query->where('invoice_type', 'CK');
        })
        ->get();

        $sub_price = 0;
        $sub_discount = 0;
        $sub_grand_total = 0;

        $reportNew = new Collection();

        foreach ($report as $index => $row) {
            if ($index > 0 && $row->customer_id == $report[$index - 1]->customer_id) {
                $customer_name = '';
                $phone_number = '';
                $email = '';
            }else{
                $customer_name = $row->customer_name;
                $phone_number = $row->phone_number;
                $email = $row->email;
            }

            if ($index > 0 && $row->customer_id == $report[$index - 1]->customer_id && $row->invoice_code == $report[$index - 1]->invoice_code) {
                $invoice_code = '';
                $treatment_date = '';
                $payment_mode = '';
                $payment_status = '';
                $note = '';
                $is_member = '';
                $use_member = '';
                $member_plan = '';
                $voucher_code = '';
                $total_price = '';
                $discount = '';
                $grand_total = '';
            }else{
                $invoice_code = $row->invoice_code;
                $treatment_date = $row->treatment_date;
                $payment_mode = $row->payment_mode;
                $payment_status = $row->payment_status;
                $note = $row->note;
                $is_member = $row->is_member;
                $use_member = $row->use_member;
                $member_plan = $row->member_plan;
                $voucher_code = $row->voucher_code;
                $total_price = $row->total_price;
                $discount = $row->discount;
                $grand_total = $row->grand_total;

                $sub_price = $sub_price + $row->total_price;
                $sub_discount = $sub_discount + $row->discount;
                $sub_grand_total = $sub_grand_total + $row->grand_total;
            }

            $reportNew->push([
                'customer_name' => $customer_name,
                'phone_number' => $phone_number,
                'email' => $email,
                'invoice_code' => $invoice_code,
                'treatment_date' => $treatment_date,
                'payment_mode' => $payment_mode,
                'payment_status' => $payment_status,
                'note' => $note,
                'is_member' => $is_member,
                'use_member' => $use_member,
                'member_plan' => $member_plan,
                'voucher_code' => $voucher_code,
                'total_price' => $total_price,
                'discount' => $discount,
                'grand_total' => $grand_total,
                'amount' => $row->amount,
                'product_name' => $row->product_name,
                'therapist_name' => $row->therapist_name,
                'room' => $row->room,
                'time_from' => $row->time_from,
                'time_to' => $row->time_to,
            ]);
        }

        $reportNew->push([
            'customer_name' => '',
            'phone_number' => '',
            'email' => '',
            'invoice_code' => '',
            'treatment_date' => '',
            'payment_mode' => '',
            'payment_status' => '',
            'note' => '',
            'is_member' => '',
            'use_member' => '',
            'member_plan' => '',
            'voucher_code' => 'Total',
            'total_price' => $sub_price,
            'discount' => $sub_discount,
            'grand_total' => $sub_grand_total,
            'amount' => '',
            'product_name' => '',
            'therapist_name' => '',
            'room' => '',
            'time_from' => '',
            'time_to' => '',
        ]);

        $fileName = 'report_customer_transaction_' . Carbon::parse($dateFrom)->format('Ymd') . '_' . Carbon::parse($dateTo)->format('Ymd') . '.xlsx';

        return Excel::download(new ExCustomerTrans($reportNew), $fileName);
    }
}
