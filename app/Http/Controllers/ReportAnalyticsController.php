<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\RoleAccess;
use App\Invoice;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReportAnalyticsController extends Controller
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
    public function revenue()
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.filter')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        $invoice_type = RoleAccess::where('user_id', $user->id)->first()->access_code;
        $today = Carbon::today()->format('Y/m/d');
        $time = date('H:i:s');

        $customer_role = Sentinel::findRoleBySlug('customer');
        $customers = DB::table('users')
        ->join('customers', 'users.id', '=', 'customers.user_id')
        ->select('users.first_name', 'users.last_name', 'users.phone_number', 'users.email', 'customers.*')
        ->where('users.is_deleted', 0)
        ->orderBy('users.id', 'DESC')
        ->limit(5)
        ->get();
        $therapist_role = Sentinel::findRoleBySlug('therapist');
        $therapists = DB::table('users')
        ->join('therapists', 'users.id', '=', 'therapists.user_id')
        ->select('users.first_name', 'users.last_name', 'users.phone_number', 'users.email', 'therapists.*')
        ->where('users.is_deleted', 0)
        ->orderBy('users.id', 'DESC')
        ->limit(5)
        ->get();
        $receptionist_role = Sentinel::findRoleBySlug('receptionist');
        $receptionists = DB::table('users')
        ->join('receptionists', 'users.id', '=', 'receptionists.user_id')
        ->select('users.first_name', 'users.last_name', 'users.phone_number', 'users.email', 'receptionists.*')
        ->where('users.is_deleted', 0)
        ->orderBy('users.id', 'DESC')
        ->limit(5)
        ->get();

        $tot_customer = 0;
        if ($customer_role) {
            $tot_customer = $customer_role->users()->with('roles')->where('is_deleted', 0)->get()->count();
        }
        
        $tot_therapist = 0;
        if ($therapist_role) {
            $tot_therapist = $therapist_role->users()->with('roles')->where('is_deleted', 0)->get()->count();
        }

        $tot_receptionist = 0;
        if ($receptionist_role) {
            $tot_receptionist = $receptionist_role->users()->with('roles')->where('is_deleted', 0)->get()->count();
        }
        
        $appointments = Appointment::all();
        $revenue = Invoice::when($invoice_type === 'CK', function ($query) {
                return $query->where('invoice_type', 'CK');
            })
            ->when($invoice_type === 'NC', function ($query) {
                return $query->where('invoice_type', 'NC');
            })
            ->sum('grand_total');
        $invoice = Invoice::whereDate('created_at', Carbon::today())
            ->when($invoice_type === 'NC', function ($query) {
                return $query->where('invoice_type', 'NC');
            })
            ->when($invoice_type === 'CK', function ($query) {
                return $query->where('invoice_type', 'CK');
            })
            ->select(DB::raw('SUM(grand_total) as total'))
            ->first();
        
        $tot_invoices = Invoice::when($invoice_type === 'CK', function ($query) {
                return $query->where('invoice_type', 'CK');
            })
            ->when($invoice_type === 'NC', function ($query) {
                return $query->where('invoice_type', 'NC');
            })
            ->count('id');
        // return $invoice;
        $daily_earning = $invoice->total;
        // return $daily_earning;
        $monthlyEarning = ReportController::getMonthlyEarning();
        $today_appointment = Appointment::with('timeSlot')->where('appointment_date', $today)->get();
        $tomorrow_appointment = Appointment::where('appointment_date', '=', Carbon::tomorrow())->get();

        $Upcoming_appointment = Appointment::where('appointment_date', '>', $today)->orWhere(function ($re) use ($today, $time) {
            $re->whereDate('appointment_date', $today);
            $re->whereTime('available_time', '>=', $time);
        })
            ->get();
        $data = [
            'total_therapists' => $tot_therapist,
            'total_receptionists' => $tot_receptionist,
            'total_customers' => $tot_customer,
            'total_appointment' => $appointments->count(),
            'total_invoices' => $tot_invoices,
            'revenue' => $revenue,
            'today_appointment' => $today_appointment->count(),
            'tomorrow_appointment' => $tomorrow_appointment->count(),
            'Upcoming_appointment' => $Upcoming_appointment->count(),
            'daily_earning' => $daily_earning,
            'monthly_earning' => $monthlyEarning['monthlyEarning'],
            'monthly_diff' => $monthlyEarning['diff']
        ];
        
        return view('report.analytics.revenue', compact('user', 'role', 'customers', 'therapists', 'receptionists', 'data'));
    }
}
