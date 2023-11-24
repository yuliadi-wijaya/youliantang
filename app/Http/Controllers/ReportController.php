<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Invoice;
use App\InvoiceDetail;
use App\InvoiceSettings;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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
}
