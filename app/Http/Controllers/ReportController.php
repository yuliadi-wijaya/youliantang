<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Invoice;
use App\InvoiceDetail;
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
        $customers =  User::whereHas('roles', function ($q) {
            $q->where('slug', 'customer');
        })->select(DB::raw('count(id) as `total_customer`'), DB::raw('MONTH(created_at) Month'))
            ->whereYear('created_at', Carbon::now()->year)->groupBy(DB::raw('MONTH(created_at)'))->get();

        $revenue = DB::select('SELECT MONTH(invoices.created_at) AS Month,SUM(invoice_details.amount) AS total_revenue
        FROM invoices, invoice_details WHERE invoices.id = invoice_details.invoice_id AND YEAR(invoices.created_at) = YEAR(CURDATE())
        GROUP BY MONTH(invoices.created_at)');
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
        if ($role == 'customer') {
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', date('m'))->where('customer_id', $userId)->pluck('id');
            $currentMonthEarning = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');
            $preInvoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', Carbon::now()->subMonth()->month)->where('customer_id', $userId)->pluck('id');
            $prevMonthEarning = InvoiceDetail::whereIn('invoice_id', $preInvoice)->sum('amount');
        } elseif ($role == 'therapist') {
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', date('m'))->where('created_by', $userId)->pluck('id');
            $currentMonthEarning = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');
            $preInvoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', Carbon::now()->subMonth()->month)->where('created_by', $userId)->pluck('id');
            $prevMonthEarning = InvoiceDetail::whereIn('invoice_id', $preInvoice)->sum('amount');
        } else {
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', date('m'))->pluck('id');
            $currentMonthEarning = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');

            $preInvoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->whereMonth('created_at', Carbon::now()->subMonth()->month)->pluck('id');
            $prevMonthEarning = InvoiceDetail::whereIn('invoice_id', $preInvoice)->sum('amount');
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
