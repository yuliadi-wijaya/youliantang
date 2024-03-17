<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\RoleAccess;
use App\Invoice;
use App\InvoiceDetail;
use App\User;
use App\TransactionRevenueDailyView;
use App\TransactionRevenueMonthlyView;
use App\TransactionRevenueYearlyView;
use App\TransactionCommissionFeeDailyView;
use App\TransactionCommissionFeeMonthlyView;
use App\TransactionCommissionFeeYearlyView;
use App\TherapistCommissionFeeDailyView;
use App\TherapistCommissionFeeMonthlyView;
use App\TherapistCommissionFeeYearlyView;
use App\TherapistReviewView;
use App\CustomerRegistrationTotalDailyView;
use App\CustomerRegistrationTotalMonthlyView;
use App\CustomerRegistrationTotalYearlyView;
use App\CustomerRepeatOrderDailyView;
use App\CustomerRepeatOrderMonthlyView;
use App\CustomerRepeatOrderYearlyView;
use App\ProductTransactionView;
use App\Promo;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Query\JoinClause;

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

    public function analytics()
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
        
        return view('report.analytics', compact('user', 'role', 'customers', 'therapists', 'receptionists', 'data'));
    }

    /**
     * Get Monthly Users and Revenue.
     *
     * @return Array
     */
    public function getMonthlyUsersRevenue()
    {
        $user = Sentinel::getUser();
        $userId = $user->id;

        // Get Role Access
        $invoice_type = RoleAccess::where('user_id', $userId)->first()->access_code;

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

    public function getMonthlyInvoicesRevenue() {
        $user = Sentinel::getUser();
        $userId = $user->id;

        // Get Role Access
        $invoice_type = RoleAccess::where('user_id', $userId)->first()->access_code;

        $q_invoice_count = "SELECT MONTH(created_at) AS Month, count(id) AS total_invoice
        FROM invoices
        WHERE YEAR(created_at) = YEAR(CURDATE())";
        if ($invoice_type === 'NC') {
            $q_invoice_count .= " AND invoice_type = 'NC'";
        } elseif ($invoice_type === 'CK') {
            $q_invoice_count .= " AND invoice_type = 'CK'";
        }
        $q_invoice_count .= " GROUP BY MONTH(created_at)";
        $invoice_count = DB::select($q_invoice_count);


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
            'total_invoice' => $invoice_count,
            'total_revenue' => $revenue
        ];
        return $data;
    }

    public function getYearlyInvoicesRevenue() {
        $user = Sentinel::getUser();
        $userId = $user->id;

        // Get Role Access
        $invoice_type = RoleAccess::where('user_id', $userId)->first()->access_code;

        $q_invoice_count = "SELECT YEAR(created_at) AS year, count(id) AS total_invoice
        FROM invoices";
        if ($invoice_type === 'NC') {
            $q_invoice_count .= " AND invoice_type = 'NC'";
        } elseif ($invoice_type === 'CK') {
            $q_invoice_count .= " AND invoice_type = 'CK'";
        }
        $q_invoice_count .= " GROUP BY YEAR(created_at) ORDER BY year(created_at)";
        $invoice_count = DB::select($q_invoice_count);


        $query = "SELECT YEAR(created_at) AS year, SUM(grand_total) AS total_revenue
        FROM invoices";
        if ($invoice_type === 'NC') {
            $query .= " AND invoice_type = 'NC'";
        } elseif ($invoice_type === 'CK') {
            $query .= " AND invoice_type = 'CK'";
        }
        $query .= " GROUP BY YEAR(created_at) ORDER BY year(created_at)";
        $revenue = DB::select($query);

        $data = [
            'total_invoice' => $invoice_count,
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

        // Get Role Access
        if($role == 'receptionist'){
            $invoice_type = RoleAccess::where('user_id', $userId)->first()->access_code;
        }else{
            $invoice_type = 'ALL';
        }

        if ($role == 'customer') {
            $invoice = Invoice::whereMonth('created_at', Carbon::now()->month)
                ->where('customer_id', $userId)
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->where('status', 1)
                ->where('is_deleted', 0)
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
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->selectRaw('SUM(grand_total) as total')
                ->first();
            $prevMonthEarning = $preInvoice ->total;
        } elseif ($role == 'therapist') {
            $invoice = InvoiceDetail::whereMonth('created_at', Carbon::now()->month)
                ->where('therapist_id', $userId)
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->select(DB::raw('SUM(fee) as total'))
                ->first();
            $currentMonthEarning = $invoice->total;

            $preInvoice = InvoiceDetail::whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->where('therapist_id', $userId)
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->select(DB::raw('SUM(fee) as total'))
                ->first();
            $prevMonthEarning = $preInvoice ->total;
        } else {
            $invoice = Invoice::whereMonth('created_at', Carbon::now()->month)
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->where('status', 1)
                ->where('is_deleted', 0)
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
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->select(DB::raw('SUM(grand_total) as total'))
                ->first();
            $prevMonthEarning = $preInvoice ->total;
        }
        $diff = $currentMonthEarning - $prevMonthEarning;
        if ($prevMonthEarning == 0) {
            $total_diff = 100;
        } else {
            $total_diff = ($diff / $prevMonthEarning) * 100;
        }
        $data = [
            'monthlyEarning' => $currentMonthEarning,
            'diff' => number_format($total_diff, 2)
        ];
        return $data;
    }
    public function PaymentMethodTransactionReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $reports = null;
        // Get user role
        $role = $user->roles[0]->slug;

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        if ($request->report_type) {
            $reports = Invoice::select('payment_mode',
                DB::raw('COUNT(id) AS invoice_total'),
                DB::raw("SUM(CASE 
                    WHEN invoice_type = 'NC' THEN grand_total
                    ELSE 0
                END) AS revenue_nc"),
                DB::raw("SUM(CASE 
                    WHEN invoice_type = 'CK' THEN grand_total
                    ELSE 0
                END) AS revenue_ck"),
                DB::raw('SUM(grand_total) as revenue_total'))
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->when($request->report_type == 'daily', function ($query) use ($request) {
                return $query->whereBetween('treatment_date', [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))]);
            })
            ->when($request->report_type == 'monthly', function ($query) use ($request) {
                if ($request->month != "All Months") {
                    return $query->whereMonth('treatment_date', $request->month);
                }
                if ($request->year != "All Years") {
                    return $query->whereYear('treatment_date', $request->year);
                }
                return $query;
            })
            ->when($request->report_type == 'yearly', function ($query) use ($request) {
                if ($request->yearly_year != "All Years") {
                    return $query->whereYear('treatment_date', $request->yearly_year);
                }
                return $query;
            })
            ->groupBy('payment_mode')
            ->orderBy(DB::raw('COUNT(id)'), 'DESC')
            ->get();
        }

        return view('report.payment.payment-method-transaction', compact('user', 'role', 'reportType', 'months', 'years', 'reports', 'request'));
    }

    public function PromoUsageReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $reports = null;
        // Get user role
        $role = $user->roles[0]->slug;

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        if ($request->report_type) {
            // DB::connection()->enableQueryLog();
            $reports = Promo::select('promos.id',
                'promos.name',
                'promos.active_period_start',
                'promos.active_period_end',
                'promos.is_reuse_voucher',
                DB::raw('COUNT(DISTINCT promo_vouchers.id) AS voucher_total'),
                DB::raw('COUNT(DISTINCT COALESCE(invoices.id, 0)) AS invoice_total'))
            ->join('promo_vouchers', 'promo_vouchers.promo_id', '=', 'promos.id')
            ->join('invoices', function (JoinClause $join) {
                $join->on('invoices.promo_id', '=', 'promos.id')
                    ->where('invoices.is_deleted', '=', '0');
            })
            ->where('promos.is_deleted', 0)
            ->when($request->report_type == 'daily', function ($query) use ($request) {
                return $query->whereBetween('invoices.treatment_date', [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))]);
            })
            ->when($request->report_type == 'monthly', function ($query) use ($request) {
                if ($request->month != "All Months") {
                    return $query->whereMonth('invoices.treatment_date', $request->month);
                }
                if ($request->year != "All Years") {
                    return $query->whereYear('invoices.treatment_date', $request->year);
                }
                return $query;
            })
            ->when($request->report_type == 'yearly', function ($query) use ($request) {
                if ($request->yearly_year != "All Years") {
                    return $query->whereYear('invoices.treatment_date', $request->yearly_year);
                }
                return $query;
            })
            ->groupBy('promos.id')
            ->groupBy('promos.name')
            ->groupBy('promos.active_period_start')
            ->groupBy('promos.active_period_end')
            ->groupBy('promos.is_reuse_voucher')
            ->orderBy(DB::raw('COUNT(DISTINCT COALESCE(invoices.id, 0))'), 'DESC')
            ->orderBy(DB::raw('COUNT(DISTINCT promo_vouchers.id)'), 'DESC')
            ->limit($request->limit)
            ->get();

            // echo '<pre>';
            // print_r(DB::getQueryLog());
            // echo '</pre>';
            // die();
        }

        return view('report.promo.promo-usage', compact('user', 'role', 'reportType', 'months', 'years', 'reports', 'request'));
    }

    public function ProductTransactionReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $reports = null;
        // Get user role
        $role = $user->roles[0]->slug;

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        if ($request->report_type) {
            $reports = InvoiceDetail::select('products.name AS treatment_name',
                DB::raw('SUM(products.duration) AS duration_total'),
                DB::raw('COUNT(DISTINCT invoice_details.therapist_id) AS therapist_total'),
                DB::raw('COUNT(DISTINCT invoice_details.invoice_id) AS invoice_total'),
                DB::raw('COUNT(DISTINCT invoice_details.id) AS treatment_total'),
                DB::raw('SUM(invoice_details.amount) AS treatment_price_total'),
                DB::raw('SUM(invoice_details.fee) AS therapist_fee_total'))
            ->join('invoices', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->leftJoin('products', 'products.id', '=', 'invoice_details.product_id')
            ->where('invoices.status', 1)
            ->where('invoices.is_deleted', 0)
            ->when($request->report_type == 'daily', function ($query) use ($request) {
                return $query->whereBetween('invoices.treatment_date', [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))]);
            })
            ->when($request->report_type == 'monthly', function ($query) use ($request) {
                if ($request->month != "All Months") {
                    return $query->whereMonth('invoices.treatment_date', $request->month);
                }
                if ($request->year != "All Years") {
                    return $query->whereYear('invoices.treatment_date', $request->year);
                }
                return $query;
            })
            ->when($request->report_type == 'yearly', function ($query) use ($request) {
                if ($request->yearly_year != "All Years") {
                    return $query->whereYear('invoices.treatment_date', $request->yearly_year);
                }
                return $query;
            })
            ->groupBy('products.name')
            ->orderBy(DB::raw('COUNT(DISTINCT invoice_details.therapist_id)'), 'DESC')
            ->get();

            // echo '<pre>';
            // print_r(DB::getQueryLog());
            // echo '</pre>';
            // die();
        }

        return view('report.product.product-transaction', compact('user', 'role', 'reportType', 'months', 'years', 'reports', 'request'));
    }

    public function CustomerTopRepeatOrderReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $reports = null;
        // Get user role
        $role = $user->roles[0]->slug;

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        if ($request->report_type) {
            $reports = Invoice::select(
                DB::raw("CONCAT(users.first_name, ' ', COALESCE(users.last_name, ''), ' - ', users.phone_number) AS customer_name"),
                DB::raw('COUNT(COALESCE(invoices.id, 0)) AS repeat_order_total'),
                DB::raw('SUM(invoices.total_price) AS based_paid_total'),
                DB::raw('SUM(invoices.discount) AS discount_total'),
                DB::raw('SUM(invoices.additional_price) AS additional_price_total'),
                DB::raw('SUM(invoices.tax_amount) AS tax_amount_total'),
                DB::raw('SUM(invoices.grand_total) AS gross_paid_total'))
            ->join('users', 'users.id', '=', 'invoices.customer_id')
            ->where('invoices.treatment_date', '>', DB::raw('DATE(users.created_at)'))
            ->when($request->report_type == 'daily', function ($query) use ($request) {
                return $query->whereBetween('invoices.treatment_date', [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))]);
            })
            ->when($request->report_type == 'monthly', function ($query) use ($request) {
                if ($request->month != "All Months") {
                    return $query->whereMonth('invoices.treatment_date', $request->month);
                }
                if ($request->year != "All Years") {
                    return $query->whereYear('invoices.treatment_date', $request->year);
                }
                return $query;
            })
            ->when($request->report_type == 'yearly', function ($query) use($request) {
                if ($request->yearly_year != "All Years") {
                    return $query->whereYear('invoices.treatment_date', $request->yearly_year);
                }
                return $query;
            })
            ->groupBy(DB::raw("CONCAT(users.first_name, ' ', COALESCE(users.last_name, ''), ' - ', users.phone_number)"))
            ->orderBy(DB::raw('COUNT(COALESCE(invoices.id, 0))'), 'DESC')
            ->limit($request->limit)
            ->get();
        }

        return view('report.customer.customer-top-repeat-order', compact('user', 'role', 'reportType', 'months', 'years', 'reports', 'request'));
    }

    public function CustomerNewAndRepeatOrderReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $new_orders = null;
        $repeat_orders = null;
        
        switch ($request->report_type) {
            case 'daily':
                // Validate input data
                $validatedData = $request->validate([
                    'daily_start_date' => 'required',
                    'daily_end_date' => 'required'
                ]);

                $new_orders = CustomerRegistrationTotalDailyView::whereBetween('regist_date', [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))])
                    ->get();
                
                $repeat_orders = CustomerRepeatOrderDailyView::whereBetween('treatment_date', [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))])
                ->get();
                break;
            case 'monthly';
                $month = $request->month != "All Months"? $request->month : NULL;
                $year = $request->year != "All Years"? $request->year : NULL;


                $new_orders = CustomerRegistrationTotalMonthlyView::get()
                    ->when($month != NULL, function ($query) use($month) {
                        return $query->where('month_num', $month);
                    })
                    ->when($year != NULL, function ($query) use($year) {
                        return $query->where('year_num', $year);
                    });

                $repeat_orders = CustomerRepeatOrderMonthlyView::get()
                    ->when($month != NULL, function ($query) use($month) {
                        return $query->where('month_num', $month);
                    })
                    ->when($year != NULL, function ($query) use($year) {
                        return $query->where('year_num', $year);
                    });
                break;
            case 'yearly':
                $yearly_year = $request->yearly_year != "All Years"? $request->yearly_year : NULL;

                $new_orders = CustomerRegistrationTotalYearlyView::get()
                    ->when($yearly_year != NULL, function ($query) use($yearly_year) {
                        return $query->where('regist_date', $yearly_year);
                    });
                $repeat_orders = CustomerRepeatOrderYearlyView::get()
                    ->when($yearly_year != NULL, function ($query) use($yearly_year) {
                        return $query->where('treatment_date', $yearly_year);
                    });
                break;
        }

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        // Get user role
        $role = $user->roles[0]->slug;

        return view('report.customer.customer-new-and-repeat-order', compact('user', 'role', 'reportType', 'months', 'years', 'new_orders', 'repeat_orders', 'request'));
    }

    public function TherapistReviewReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $reports = null;
        // Get user role
        $role = $user->roles[0]->slug;

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        if ($request->report_type) {
            $reports = InvoiceDetail::select(
                DB::raw("CONCAT(users.first_name, ' ', COALESCE(users.last_name, '')) AS therapist_name"),
                DB::raw('COUNT(invoice_details.id) AS treatment_total'),
                DB::raw('COUNT(reviews.id) AS reviewer_total'),
                DB::raw('SUM(COALESCE(reviews.rating, 0)) AS rating_total'),
                DB::raw('COALESCE(ROUND(SUM(COALESCE(reviews.rating, 0))/COUNT(reviews.id), 2), 0) AS rating_average'))
            ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
            ->leftJoin('reviews', 'reviews.invoice_detail_id', '=', 'invoice_details.id')
            ->where('invoice_details.status', 1)
            ->where('invoice_details.is_deleted', 0)
            ->when($request->report_type == 'daily', function ($query) use ($request) {
                return $query->whereBetween(DB::raw('DATE(invoice_details.created_at)'), [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))]);
            })
            ->when($request->report_type == 'monthly', function ($query) use ($request) {
                if ($request->month != "All Months") {
                    return $query->whereMonth('invoice_details.created_at', $request->month);
                }
                if ($request->year != "All Years") {
                    return $query->whereYear('invoice_details.created_at', $request->year);
                }
                return $query;
            })
            ->when($request->report_type == 'yearly', function ($query) use ($request) {
                if ($request->yearly_year != "All Years") {
                    return $query->whereYear('invoice_details.created_at', $request->yearly_year);
                }
                return $query;
            })
            ->groupBy(DB::raw("CONCAT(users.first_name, ' ', COALESCE(users.last_name,''))"))
            ->orderBy('rating_average', 'DESC')
            ->orderBy('rating_total', 'DESC')
            ->orderBy('reviewer_total', 'DESC')
            ->orderBy('treatment_total', 'DESC')
            ->orderBy('therapist_name', 'ASC')
            ->get();
        }

        return view('report.therapist.therapist-review', compact('user', 'role', 'reportType', 'months', 'years', 'reports', 'request'));
    }

    public function TherapistCommissionFeeReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $reports = null;

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        // Get user role
        $role = $user->roles[0]->slug;

        if ($request->report_type) {
            $reports = InvoiceDetail::select(
                DB::raw("CONCAT(users.first_name, ' ', COALESCE(users.last_name,'')) AS therapist_name"),
                DB::raw('COUNT(DISTINCT invoice_details.invoice_id) AS invoice_total'),
                DB::raw('COUNT(DISTINCT invoice_details.id) AS treatment_total'),
                DB::raw('SUM(invoice_details.fee) AS commission_fee_total'))
            ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
            ->where('invoice_details.status', 1)
            ->where('invoice_details.is_deleted', 0)
            ->when($request->report_type == 'daily', function ($query) use ($request) {
                return $query->whereBetween(DB::raw('DATE(invoice_details.created_at)'), [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))]);
            })
            ->when($request->report_type == 'monthly', function ($query) use ($request) {
                if ($request->month != "All Months") {
                    return $query->whereMonth('invoice_details.created_at', $request->month);
                }
                if ($request->year != "All Years") {
                    return $query->whereYear('invoice_details.created_at', $request->year);
                }
                return $query;
            })
            ->when($request->report_type == 'yearly', function ($query) use ($request) {
                if ($request->yearly_year != "All Years") {
                    return $query->whereYear('invoice_details.created_at', $request->yearly_year);
                }
                return $query;
            })
            ->groupBy(DB::raw("CONCAT(users.first_name, ' ', COALESCE(users.last_name,''))"))
            ->orderBy(DB::raw('COUNT(DISTINCT invoice_details.id)'), 'DESC')
            ->get();
        }

        return view('report.therapist.therapist-commission-fee', compact('user', 'role', 'reportType', 'months', 'years', 'reports', 'request'));
    }

    public function TransactionCommissionFeeReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $reports = null;
        
        switch ($request->report_type) {
            case 'daily':
                // Validate input data
                $validatedData = $request->validate([
                    'daily_start_date' => 'required',
                    'daily_end_date' => 'required'
                ]);

                $reports = TransactionCommissionFeeDailyView::whereBetween('treatment_date', [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))])
                    ->get();
                break;
            case 'monthly';
                $month = $request->month != "All Months"? $request->month : NULL;
                $year = $request->year != "All Years"? $request->year : NULL;


                $reports = TransactionCommissionFeeMonthlyView::get()
                    ->when($month != NULL, function ($query) use($month) {
                        return $query->where('month_num', $month);
                    })
                    ->when($year != NULL, function ($query) use($year) {
                        return $query->where('year_num', $year);
                    });
                break;
            case 'yearly':
                $reports = TransactionCommissionFeeYearlyView::get();
                break;
        }

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        // Get user role
        $role = $user->roles[0]->slug;

        return view('report.transaction.transaction-commission-fee', compact('user', 'role', 'reportType', 'months', 'years', 'reports', 'request'));
    }

    public function TransactionRevenueReport(Request $request) {
        // Get user session data
        $user = Sentinel::getUser();
        $reports = null;
        
        switch ($request->report_type) {
            case 'daily':
                // Validate input data
                $validatedData = $request->validate([
                    'daily_start_date' => 'required',
                    'daily_end_date' => 'required'
                ]);

                $reports = TransactionRevenueDailyView::whereBetween('treatment_date', [date('Y-m-d', strtotime($request->daily_start_date)), date('Y-m-d', strtotime($request->daily_end_date))])
                    ->get();
                break;
            case 'monthly';
                $month = $request->month != "All Months"? $request->month : NULL;
                $year = $request->year != "All Years"? $request->year : NULL;


                $reports = TransactionRevenueMonthlyView::get()
                    ->when($month != NULL, function ($query) use($month) {
                        return $query->where('month_num', $month);
                    })
                    ->when($year != NULL, function ($query) use($year) {
                        return $query->where('year_num', $year);
                    });
                break;
            case 'yearly':
                $reports = TransactionRevenueYearlyView::get();
                break;
        }

        // Report Type Filter
        $reportType = $this->getReportType();

        // Month Filter
        $months = $this->getMonths();

        // Year Filter
        $years = $this->getYears();

        // Get user role
        $role = $user->roles[0]->slug;

        return view('report.transaction.transaction-revenue', compact('user', 'role', 'reportType', 'months', 'years', 'reports', 'request'));
    }

    private function getReportType() {
        return [
            'daily' => 'Daily',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly'
        ];
    }

    private function getMonths() {
        return [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
    }

    private function getYears() {
        $years = [];
        $curYear = date('Y');
        for ($i = 0; $i < 5; $i++) {
            $years[$curYear - $i] = $curYear - $i;
        }

        return $years;
    }
}
