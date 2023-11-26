<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceDetail;
use App\InvoiceSettings;
use App\ReportInvoice;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Exports\ReportInvoiceExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
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

    /**
     * Get Monthly Users and Revenue.
     *
     * @return Array
     */
    public function getMonthlyUsersRevenue()
    {
        // Get invoice setting
        $invoice_type = InvoiceSettings::first()->invoice_type;

        $customers =  User::whereHas('roles', function ($q) {
            $q->where('slug', 'customer');
        })->select(DB::raw('count(id) as `total_customer`'), DB::raw('MONTH(created_at) Month'))
            ->whereYear('created_at', Carbon::now()->year)->groupBy(DB::raw('MONTH(created_at)'))->get();

        $query = "SELECT MONTH(created_at) AS Month, SUM(grand_total) AS total_revenue
        FROM invoices
        WHERE YEAR(created_at) = YEAR(CURDATE())";

        if ($invoice_type === 'NC') {
            $query .= " AND invoice_type = 'NC'";
        } elseif ($invoice_type === 'CK') {
            $query .= " AND invoice_type = 'CK'";
        }

        $query .= " GROUP BY MONTH(created_at)";

        $revenue = DB::select($query);

        $data = [
            'total_customer' => $customers,
            'total_revenue' => $revenue
        ];
        return $data;
    }

    /**
     * Get Monthly Appointments for each therapist.
     *
     * @return Array
     */
    public function getMonthlyAppointments()
    {
        $user = Sentinel::getUser();
        $appointments = Appointment::select(DB::raw('MONTH(appointment_date) Month'), DB::raw('count(id) as `total_appointment`'))
            ->whereYear('created_at', Carbon::now()->year)->groupBy(DB::raw('MONTH(appointment_date)'))->where('appointment_with', $user->id)->get();
        return $appointments;
    }

    /**
     * Get Monthly monthly earning.
     *
     * @return Array
     */
    public static function getMonthlyEarning()
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $userId = $user->id;

        // Get invoice setting
        $invoice_type = InvoiceSettings::first()->invoice_type;

        if ($role == 'customer') {
            $invoice = Invoice::whereMonth('created_at', date('m'))
                ->where('customer_id', $userId)
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->selectRaw('SUM(grand_total) as total')
                ->first();
            $currentMonthEarning = $invoice->total;

            $preInvoice = Invoice::whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->where('customer_id', $userId)
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->selectRaw('SUM(grand_total) as total')
                ->first();
            $prevMonthEarning = $preInvoice ->total;
        } elseif ($role == 'therapist') {
            $invoice = Invoice::whereMonth('created_at', date('m'))
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->where('created_by', $userId)
                ->select(DB::raw('SUM(grand_total) as total'))
                ->first();
            $currentMonthEarning = $invoice->total;

            $preInvoice = Invoice::whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->where('created_by', $userId)
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->select(DB::raw('SUM(grand_total) as total'))
                ->first();
            $prevMonthEarning = $preInvoice ->total;
        } else {
            $invoice = Invoice::whereMonth('created_at', date('m'))
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->select(DB::raw('SUM(grand_total) as total'))
                ->first();
            $currentMonthEarning = $invoice->total;

            $preInvoice = Invoice::whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->select(DB::raw('SUM(grand_total) as total'))
                ->first();
            $prevMonthEarning = $preInvoice ->total;
        }
        $diff = $currentMonthEarning - $prevMonthEarning;
        if ($prevMonthEarning == 0) {
            $total_diff = 100;
        } else {
            $total_diff = $diff / $prevMonthEarning * 100;
        }
        $data = [
            'monthlyEarning' => $currentMonthEarning,
            'diff' => number_format($total_diff, 2)
        ];
        return $data;
    }

    public function fiterReport()
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.filter')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        return view('report.report-filter', compact('user', 'role'));
    }

    public function showReport(Request $request)
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
        $pay_status = $request->payment_status;

        $invoice_type = InvoiceSettings::first()->invoice_type;

        $report = ReportInvoice::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('invoice_date', [$dateFrom, $dateTo]);
        })
        ->when($pay_status !== 'All', function ($query) use ($pay_status) {
            return $query->where('payment_status', $pay_status);
        })
        ->when($invoice_type === 'NC', function ($query) {
            return $query->where('invoice_type', 'NC');
        })
        ->when($invoice_type === 'CK', function ($query) {
            return $query->where('invoice_type', 'CK');
        })
        ->get();

        return view('report.report-view', compact('user', 'role', 'report', 'dateFrom', 'dateTo','pay_status'));
    }

    public function exportReport(Request $request)
    {
        $dateFrom = date('Y-m-d', strtotime($request->dateFrom));
        $dateTo = date('Y-m-d', strtotime($request->dateTo));
        $pay_status = $request->payment_status;

        $invoice_type = InvoiceSettings::first()->invoice_type;

        $report = ReportInvoice::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('invoice_date', [$dateFrom, $dateTo]);
        })
        ->when($pay_status !== 'All', function ($query) use ($pay_status) {
            return $query->where('payment_status', $pay_status);
        })
        ->when($invoice_type === 'NC', function ($query) {
            return $query->where('invoice_type', 'NC');
        })
        ->when($invoice_type === 'CK', function ($query) {
            return $query->where('invoice_type', 'CK');
        })
        ->get();

        $reportNew = new Collection();

        foreach ($report as $index => $row) {
            if ($index > 0 && $row->invoice_code == $report[$index - 1]->invoice_code) {
                $invoice_code = '';
                $invoice_date = '';
                $customer_name = '';
                $customer_phone_number = '';
                $payment_mode = '';
                $payment_status = '';
                $note = '';
                $total_price = '';
                $discount = '';
                $grand_total = '';
            } else {
                $invoice_code = $row->invoice_code;
                $invoice_date = $row->invoice_date;
                $customer_name = $row->customer_name;
                $customer_phone_number = $row->customer_phone_number;
                $payment_mode = $row->payment_mode;
                $payment_status = $row->payment_status;
                $note = $row->note;
                $total_price = $row->total_price;
                $discount = $row->discount;
                $grand_total = $row->grand_total;
            }

            $reportNew->push([
                'invoice_code' => $invoice_code,
                'invoice_date' => $invoice_date,
                'customer_name' => $customer_name,
                'customer_phone_number' => $customer_phone_number,
                'payment_mode' => $payment_mode,
                'payment_status' => $payment_status,
                'note' => $note,
                'total_price' => $total_price,
                'discount' => $discount,
                'grand_total' => $grand_total,
                'product_name' => $row->product_name,
                'amount' => $row->amount,
                'duration' => $row->duration,
                'treatment_date' => $row->treatment_date,
                'treatment_time_from' => $row->treatment_time_from,
                'treatment_time_to' => $row->treatment_time_to,
                'room' => $row->room,
                'therapist_name' => $row->therapist_name,
                'therapist_phone_number' => $row->therapist_phone_number,
                'commission_fee' => $row->commission_fee
            ]);
        }

        $fileName = 'report_invoice_' . Carbon::parse($dateFrom)->format('Ymd') . '_' . Carbon::parse($dateTo)->format('Ymd') . '.xlsx';

        return Excel::download(new ReportInvoiceExport($reportNew), $fileName);
    }
}
