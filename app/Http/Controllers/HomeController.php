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
use App\RoleAccess;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

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
        $this->middleware(function ($request, $next) {
            if (session()->has('page_limit')) {
                $this->limit = session()->get('page_limit');
            } else {
                $this->limit = Config::get('app.page_limit');
            }
            return $next($request);
        });
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
        $invoice_type = "";
        $rolesAccess = RoleAccess::where('user_id', $user_id)->first();
        if ($rolesAccess) {
            $invoice_type = $rolesAccess->access_code;
        }

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
            
            $revenue = Invoice::when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->sum('grand_total');
            $invoice = Invoice::whereDate('created_at', Carbon::today())
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->where('status', 1)
                ->where('is_deleted', 0)    
                ->select(DB::raw('SUM(grand_total) as revenue_total, COUNT(id) as invoice_total'))
                ->first();
            $monthly_invoice = Invoice::whereMonth('created_at', Carbon::now()->month)
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->select(DB::raw('SUM(grand_total) as revenue_total, COUNT(id) as invoice_total'))
                ->first();

            $daily_invoice = $invoice->invoice_total;
            $daily_earning = $invoice->revenue_total;
            $monthly_invoice = $monthly_invoice->invoice_total;

            $monthlyEarning = ReportController::getMonthlyEarning();

            $data = [
                'total_therapists' => $tot_therapist,
                'total_receptionists' => $tot_receptionist,
                'total_customers' => $tot_customer,
                'revenue' => $revenue,
                'daily_earning' => $daily_earning,
                'daily_invoice' => $daily_invoice,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_invoice' => $monthly_invoice,
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'customers', 'therapists', 'receptionists', 'data'));
        } elseif ($role == 'therapist') {
            $therapist_info = Therapist::where('user_id', '=', $user->id)->first();

            $therapist_count = InvoiceDetail::where('therapist_id', $user_id)
                ->where('is_deleted', 0)
                ->pluck('therapist_id');

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

            $invoices = Invoice::join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->join('users', 'users.id', '=', 'invoices.customer_id')
            ->join('products', 'products.id', '=', 'invoice_details.product_id')
            ->where('invoice_details.therapist_id', $user_id)
            ->where('invoices.status', '1')
            ->where('invoices.is_deleted', '0')
            ->where('invoice_details.status', '1')
            ->where('invoice_details.is_deleted', '0')
            ->orderby('invoice_details.id', 'desc')->paginate(
                $this->limit, 
                ['invoices.id',
                    'invoices.invoice_code',
                    'invoices.payment_status',
                    'invoices.treatment_date',
                    'users.first_name',
                    'users.last_name',
                    'users.phone_number',
                    'products.name as product_name',
                    'invoice_details.fee',
                    'invoice_details.treatment_time_from',
                    'invoice_details.treatment_time_to']
                , 'invoices');

            // payroll logic
            $current_date = Carbon::now();
            $payroll_date = Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, 25);
            
            $payroll_start_date = Carbon::now();
            $payroll_end_date = Carbon::now();

            if ($current_date >= Carbon::now()->firstOfMonth() && $current_date <= Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, 25)) {
                $payroll_start_date = Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, 25)->addMonths(-1)->addDays(1);
                $payroll_end_date = $current_date;
            }

            if ($current_date > Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, 25) && $current_date <= Carbon::now()->endOfMonth()) {
                $payroll_start_date = Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, 25)->addDay();
                $payroll_end_date = $current_date;
            }
            
            DB::connection()->enableQueryLog();
            $payroll_transaction_fee = InvoiceDetail::select(DB::raw('COUNT(DISTINCT invoice_id) AS invoice_total
            ,COUNT(DISTINCT id) AS treatment_total
            ,SUM(fee) AS commission_fee_total '))
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('therapist_id', $user_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$payroll_start_date->format('Y-m-d'), $payroll_end_date->format('Y-m-d')])
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->first();
            // end payroll logic

            $todays_transaction_fee = InvoiceDetail::select(DB::raw('COUNT(DISTINCT invoice_id) AS invoice_total
            ,COUNT(DISTINCT id) AS treatment_total
            ,SUM(fee) AS commission_fee_total '))
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('therapist_id', $user_id)
            ->whereDate('created_at', Carbon::now())
            ->groupBY(DB::raw('YEAR(created_at)'))
            ->first();

            $monthly_transaction_fee = InvoiceDetail::select(DB::raw('COUNT(DISTINCT invoice_id) AS invoice_total
            ,COUNT(DISTINCT id) AS treatment_total
            ,SUM(fee) AS commission_fee_total '))
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('therapist_id', $user_id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBY(DB::raw('YEAR(created_at)'))
            ->first();

            DB::connection()->enableQueryLog();
            $therapist_transaction_fee = InvoiceDetail::select(DB::raw('COUNT(DISTINCT invoice_id) AS invoice_total
            ,COUNT(DISTINCT id) AS treatment_total
            ,SUM(fee) AS commission_fee_total '))
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('therapist_id', $user_id)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBY(DB::raw('YEAR(created_at)'))
            ->first();

            $data = [
                'revenue' => $revenue,
                
                'daily_earning' => $daily_earning,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff'],

                'todays_fee' => ($todays_transaction_fee) ? $todays_transaction_fee->commission_fee_total : 0,
                'todays_total_treatments' => ($todays_transaction_fee) ? $todays_transaction_fee->treatment_total : 0,
                'todays_total_invoices' => ($todays_transaction_fee) ? $todays_transaction_fee->invoice_total : 0,

                'monthly_fee' => ($monthly_transaction_fee) ? $monthly_transaction_fee->commission_fee_total : 0,
                'monthly_total_treatments' => ($monthly_transaction_fee) ? $monthly_transaction_fee->treatment_total : 0,
                'monthly_total_invoices' => ($monthly_transaction_fee) ? $monthly_transaction_fee->invoice_total : 0,

                'fee' => ($therapist_transaction_fee) ? $therapist_transaction_fee->commission_fee_total : 0,
                'total_treatments' => ($therapist_transaction_fee) ? $therapist_transaction_fee->treatment_total : 0,
                'total_invoices' => ($therapist_transaction_fee) ? $therapist_transaction_fee->invoice_total : 0,

                'payroll_fee' => ($payroll_transaction_fee) ? $payroll_transaction_fee->commission_fee_total : 0,
                'payroll_treatments' => ($payroll_transaction_fee) ? $payroll_transaction_fee->treatment_total : 0,
                'payroll_invoices' => ($payroll_transaction_fee) ? $payroll_transaction_fee->invoice_total : 0
            ];
            return view('index', compact('user', 'role', 'therapist_info', 'data', 'invoices'));
        } elseif ($role == 'receptionist') {
            $today = Carbon::today()->format('Y/m/d');
            $user_id = Sentinel::getUser();
            $userId = $user_id->id;
            
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
            
            $customer_role = Sentinel::findRoleBySlug('customer');
            $tot_customer = $customer_role->users()->with('roles')->where('is_deleted', 0)->get();
            $therapist_role = Sentinel::findRoleBySlug('therapist');
            $tot_therapist = $therapist_role->users()->with('roles')->where('is_deleted', 0)->get();
            $monthlyEarning = ReportController::getMonthlyEarning();
            
            $invoice = Invoice::whereDate('created_at', Carbon::today())
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->where('status', 1)
                ->where('is_deleted', 0)  
                ->select(DB::raw('SUM(grand_total) as revenue_total, COUNT(id) as invoice_total'))
                ->first();

            $monthly_invoice = Invoice::whereMonth('created_at', Carbon::now()->month)
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->select(DB::raw('SUM(grand_total) as revenue_total, COUNT(id) as invoice_total'))
                ->first();

            $data = [
                'total_customer' => $tot_customer->count(),
                'total_therapist' => $tot_therapist->count(),
                'daily_earning' => $invoice->revenue_total,
                'daily_invoice' => $invoice->invoice_total,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_invoice' => $monthly_invoice->invoice_total,
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'customers', 'therapists', 'data'));
        } elseif ($role == 'customer') {
            $monthlyEarning = ReportController::getMonthlyEarning();

            $invoices = Invoice::join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->join('users', 'users.id', '=', 'invoices.customer_id')
            ->where('invoices.customer_id', $user_id)
            ->where('invoices.status', '1')
            ->where('invoices.is_deleted', '0')
            ->where('invoice_details.is_deleted', '0')
            ->orderby('invoices.id', 'desc')->distinct('invoices.id')->paginate(
                $this->limit, 
                ['invoices.id',
                    'invoices.invoice_code',
                    'invoices.payment_status',
                    'invoices.treatment_date',
                    'invoices.grand_total',
                    'users.first_name',
                    'users.last_name',
                    'users.phone_number']
                , 'invoice');

            $invoice_transaction = DB::select("
                SELECT year(treatment_date) as treatment_date, count(id) as invoice_total
                    ,sum(total_price) as price_total
                    ,sum(discount) as discount_total 
                    ,sum(tax_amount) as tax_amount_total
                    ,sum(grand_total) as revenue_total
                FROM invoices
                WHERE status = 1 
                    AND is_deleted = 0 
                    AND year(treatment_date) = year(curdate())
                    AND customer_id = ?
                GROUP BY year(treatment_date)
                    ", [$user_id]);

            $invoice_total = 0;
            $revenue_total = 0;
            if (count($invoice_transaction) > 0) {
                $invoice_total = $invoice_transaction[0]->invoice_total;
                $revenue_total = $invoice_transaction[0]->revenue_total;
            }
                    
            $data = [
                'invoice_total' => $invoice_total,
                'bill_total' => $revenue_total,
                'monthly_earning' => $monthlyEarning['monthlyEarning'],
                'monthly_diff' => $monthlyEarning['diff']
            ];
            return view('index', compact('user', 'role', 'data', 'invoices'));
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
