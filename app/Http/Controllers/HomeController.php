<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Therapist;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Controllers\ReportController;
use App\Invoice;
use App\InvoiceDetail;
use App\InvoiceSettings;
use App\Receptionist;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function lang($locale){
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Sentinel::getUser();
        $user_id = $user->id;
        $role = $user->roles[0]->slug;
        $today = Carbon::today()->format('Y/m/d');
        $time = date('H:i:s');

        // Get invoice setting
        $invoice_type = InvoiceSettings::first()->invoice_type;

        if ($role == 'admin') {
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
            $daily_earning = $invoice->total;
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
                'revenue' => $revenue,
                'today_appointment' => $today_appointment->count(),
                'tomorrow_appointment' => $tomorrow_appointment->count(),
                'Upcoming_appointment' => $Upcoming_appointment->count(),
                'daily_earning' => $daily_earning,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'customers', 'therapists', 'receptionists', 'data'));
        } elseif ($role == 'therapist') {
            $therapist_info = Therapist::where('user_id', '=', $user->id)->first();
            $appointments = Appointment::with('customer')
                ->where(function ($re) use ($user_id) {
                    $re->orWhere('appointment_with', $user_id);
                    $re->orWhere('booked_by', $user_id);
                })
                ->whereDate('appointment_date', $today)
                ->orderby('id', 'desc')
                ->limit(5)
                ->get();
            $tot_appointment = Appointment::where(function ($re) use ($user_id) {
                $re->orWhere('appointment_with', $user_id);
                $re->orWhere('booked_by', $user_id);
            })->get();

            $therapist_count = InvoiceDetail::where('therapist_id', $user_id)->pluck('therapist_id');
            $Invoice_Detail = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where('created_by', $user_id)->orWhereIN('created_by', $therapist_count)->pluck('id');
            $revenue = InvoiceDetail::whereIn('invoice_id', $Invoice_Detail)->where('is_deleted',0)->sum('amount');
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])
            ->join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->where('invoice_details.therapist_id', $user_id)
                ->whereDate('invoices.created_at', Carbon::today())->pluck('invoices.id');
            $daily_earning = InvoiceDetail::whereIn('invoice_id', $invoice)->where('is_deleted',0)->sum('amount');

            $monthlyEarning = ReportController::getMonthlyEarning();
            $today_appointment = Appointment::where(function ($re) use ($user_id) {
                $re->orWhere('booked_by', $user_id);
                $re->orWhere('appointment_with', $user_id);
            })->where(function ($re) use ($today) {
                $re->orWhere('appointment_date', $today);
            })->get();
            $Upcoming_appointment = Appointment::where(function ($re) use ($user_id) {
                $re->orWhere('appointment_with', $user_id);
                $re->orWhere('booked_by', $user_id);
            })
                ->whereDate('appointment_date', '>', $today)
                ->orWhere(function ($re) use ($today, $time, $user_id) {
                    $re->whereDate('appointment_date', '=', $today);
                    $re->whereTime('available_time', '>=', $time);
                    $re->where(function ($r) use ($user_id) {
                        $r->orWhere('appointment_with', $user_id);
                        $r->orWhere('booked_by', $user_id);
                    });
                })
                ->get();
            $tomorrow_appointment = Appointment::with('customer', 'therapist')->where(function ($re) use ($user_id) {
                $re->orWhere('booked_by', $user_id);
                $re->orWhere('appointment_with', $user_id);
            })->where(function ($re) {
                $re->orWhere('appointment_date', Carbon::tomorrow()->format('Y/m/d'));
            })->get();
            $data = [
                'total_appointment' => $tot_appointment->count(),
                'today_appointment' => $today_appointment->count(),
                'Upcoming_appointment' => $Upcoming_appointment->count(),
                'tomorrow_appointment' => $tomorrow_appointment->count(),
                'revenue' => $revenue,
                'daily_earning' => $daily_earning,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'therapist_info', 'appointments', 'data'));
        } elseif ($role == 'receptionist') {
            $today = Carbon::today()->format('Y/m/d');
            $user_id = Sentinel::getUser();
            $userId = $user_id->id;
            $customer_role = Sentinel::findRoleBySlug('customer');
            $customers = DB::table('users')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->select('users.first_name', 'users.last_name', 'users.phone_number', 'users.email', 'customers.*')
            ->where('users.is_deleted', 0)
            ->orderBy('users.id', 'DESC')
            ->limit(5)
            ->get();
            $therapists = DB::table('users')
            ->join('therapists', 'users.id', '=', 'therapists.user_id')
            ->select('users.first_name', 'users.last_name', 'users.phone_number', 'users.email', 'therapists.*')
            ->where('users.is_deleted', 0)
            ->orderBy('users.id', 'DESC')
            ->limit(5)
            ->get();
            $appointments = Appointment::with('customer', 'therapist')->where(function ($re) use ($userId) {
                $re->orWhere('booked_by', $userId);
            })->where(function ($re) use ($today) {
                $re->orWhere('appointment_date', $today);
                $re->where('is_deleted', 0);
            })->get();
            $tot_appointment = Appointment::where(function ($re) use ($user_id) {
                $re->orWhere('booked_by', $user_id);
            })->get();
            $tot_customer = $customer_role->users()->with('roles')->where('is_deleted', 0)->get();
            $therapist_role = Sentinel::findRoleBySlug('therapist');
            $tot_therapist = $therapist_role->users()->with('roles')->where('is_deleted', 0)->get();
            $monthlyEarning = ReportController::getMonthlyEarning();
            $today_appointment = Appointment::with('customer', 'therapist')->where(function ($re) use ($userId) {
                $re->orWhere('booked_by', $userId);
            })->where(function ($re) use ($today) {
                $re->orWhere('appointment_date', $today);
            })->get();
            $appointments = Appointment::with('therapist', 'customer', 'timeSlot')
                ->where(function ($re) use ($userId) {
                    $re->orWhere('booked_by', $userId);
                })->where('appointment_date', Carbon::today())
                ->get();
            $tomorrow_appointment = Appointment::with('customer', 'therapist', 'timeSlot')->where(function ($re) use ($userId) {
                $re->orWhere('booked_by', $userId);
            })->where(function ($re) {
                $re->orWhere('appointment_date', Carbon::tomorrow()->format('Y/m/d'));
            })->get();
            $time = date('H:i:s');
            $Upcoming_appointment =  Appointment::with('customer', 'therapist', 'timeSlot')->where(function ($re) use ($userId) {
                $re->orWhere('booked_by', $userId);
            })
                ->whereDate('appointment_date', '>', $today)
                ->orWhere(function ($re) use ($today, $time) {
                    $re->whereDate('appointment_date', '=', $today);
                    $re->whereTime('available_time', '>=', $time);
                })
                ->get();

            $invoice = Invoice::whereDate('created_at', Carbon::today())
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->select(DB::raw('SUM(grand_total) as total'))
                ->first();
            $daily_earning = $invoice->total;

            $data = [
                'total_appointment' => $tot_appointment->count(),
                'total_customer' => $tot_customer->count(),
                'total_therapist' => $tot_therapist->count(),
                'today_appointment' => $today_appointment->count(),
                'Upcoming_appointment' => $Upcoming_appointment->count(),
                'tomorrow_appointment' => $tomorrow_appointment->count(),
                'daily_earning' => $daily_earning,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'customers', 'therapists', 'appointments', 'data', 'Upcoming_appointment'));
        } elseif ($role == 'customer') {
            $appointments = Appointment::with('therapist', 'timeSlot')->where('appointment_for', $user_id)->orderBy('id', 'DESC')->limit(5)->get();
            $tot_appointment = Appointment::where('appointment_for', $user_id)->get();
            $today_appointment = Appointment::where('appointment_for', $user_id)->whereDate('appointment_date', '=', $today)->get();
            $tomorrow_appointment = Appointment::where('appointment_for', $user_id)->whereDate('appointment_date', Carbon::tomorrow()->format('Y/m/d'))->get();
            $Upcoming_appointment = Appointment::with('therapist')
                ->where('appointment_for', $user_id)
                ->whereDate('appointment_date', '>', $today)
                ->orWhere(function ($re) use ($today, $time, $user_id) {
                    $re->whereDate('appointment_date', '=', $today);
                    $re->whereTime('available_time', '>=', $time);
                    $re->where(function ($r) use ($user_id) {
                        $r->where('appointment_for', $user_id);
                    });
                })->where('is_deleted', 0)
                ->get();
            $daily_earning = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where('customer_id', $user_id)->pluck('id');
            $revenue = InvoiceDetail::whereIn('invoice_id', $daily_earning)->sum('amount');
            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where('customer_id', $user_id)->where('created_at', $today)->pluck('id');
            $daily_earning = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');
            $monthlyEarning = ReportController::getMonthlyEarning();
            $data = [
                'total_appointment' => $tot_appointment->count(),
                'today_appointment' => $today_appointment->count(),
                'tomorrow_appointment' => $tomorrow_appointment->count(),
                'Upcoming_appointment' => $Upcoming_appointment->count(),
                'revenue' => $revenue,
                'daily_earning' => $daily_earning,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'appointments', 'data'));
        }
    }

    public function per_page_item(Request $request)
    {
        if ($request->ajax()) {
            $page_limit = $request->page;
            $request->session()->put('page_limit', $page_limit);
            return response()->json([
                'isSuccess' => true,
                'Message' => "Successfully set default " .$page_limit. " items per page!",
            ],200);
        }
        else{
            return response()->json([
                'isSuccess'=> true,
                'Message' =>'Something went wrong! please try again',
            ],409);
        }
    }
}
