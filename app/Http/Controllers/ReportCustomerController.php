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

        $filter_display = $request->filter_display;
        $daily = NULL;
        $monthly = NULL;
        $yearly = NULL;

        // Validate input data
        if ($filter_display === 'daily') {
            $validatedData = $request->validate([
                'daily_date' => 'required|date',
            ]);

            $daily = date('Y-m-d', strtotime($validatedData['daily_date']));
        } elseif ($filter_display === 'monthly') {
            $validatedData = $request->validate([
                'month' => 'required',
                'year' => 'required',
            ]);

            $monthly = $validatedData['year'] . '-' . $validatedData['month'];
        } elseif ($filter_display === 'yearly') {
            $validatedData = $request->validate([
                'yearly_date' => 'required',
            ]);

            $yearly = $validatedData['yearly_date'];
        }

        $invoice_type = RoleAccess::where('user_id', $user->id)->first()->access_code;

        $report = ReportTrans::when($filter_display === 'daily', function ($query) use ($daily) {
            return $query->whereDate('treatment_date', $daily);
        })
        ->when($filter_display === 'monthly', function ($query) use ($monthly) {
            return $query->whereYear('treatment_date', substr($monthly, 0, 4))
                ->whereMonth('treatment_date', substr($monthly, 5, 2));
        })
        ->when($filter_display === 'yearly', function ($query) use ($yearly) {
            return $query->whereYear('treatment_date', $yearly);
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

        $viewData = compact('user', 'role', 'report', 'report_detail', 'filter_display', 'daily', 'monthly', 'yearly');
        return view('report.customer.customer-trans', $viewData);
    }

    public function exportReportCustomerTrans(Request $request)
    {
        $user = Sentinel::getUser();

        $filter_display = $request->filter_display;
        $daily = $request->daily;
        $monthly = $request->monthly;
        $yearly = $request->yearly;

        $invoice_type = RoleAccess::where('user_id', $user->id)->first()->access_code;

        $report = ReportTrans::when($filter_display === 'daily', function ($query) use ($daily) {
            return $query->whereDate('treatment_date', $daily);
        })
        ->when($filter_display === 'monthly', function ($query) use ($monthly) {
            return $query->whereYear('treatment_date', substr($monthly, 0, 4))
                ->whereMonth('treatment_date', substr($monthly, 5, 2));
        })
        ->when($filter_display === 'yearly', function ($query) use ($yearly) {
            return $query->whereYear('treatment_date', $yearly);
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
        $sub_tax_amount = 0;
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
            $sub_tax_amount += $row->tax_amount;
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
                'O' => $row->tax_rate,
                'P' => $row->tax_amount,
                'Q' => $row->grand_total,
                'R' => '',
                'S' => '',
                'T' => ($row->old_data == 'Y') ? $row->therapist_name : '',
                'U' => ($row->old_data == 'Y') ? $row->room : '',
                'V' => ($row->old_data == 'Y') ? $row->time_from : '',
                'W' => ($row->old_data == 'Y') ? $row->time_to : '',
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
                    'P' => '',
                    'Q' => '',
                    'R' => $rd->product_name,
                    'S' => $rd->amount,
                    'T' => ($row->old_data == 'Y') ? '' : $rd->therapist_name,
                    'U' => ($row->old_data == 'Y') ? '' : $rd->room,
                    'V' => ($row->old_data == 'Y') ? '' : $rd->treatment_time_from,
                    'W' => ($row->old_data == 'Y') ? '' : $rd->treatment_time_to,
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
            'O' => '',
            'P' => $sub_tax_amount,
            'Q' => $sub_grand_total,
            'R' => '',
            'S' => '',
            'T' => '',
            'U' => '',
            'V' => '',
            'W' => '',
        ]);

        if ($filter_display === 'daily') {
            $fileName = 'customer_transaction_'.$filter_display.'_report_'.Carbon::parse($daily)->format('d_m_Y').'.xlsx';
        } elseif ($filter_display === 'monthly') {
            $fileName = 'customer_transaction_'.$filter_display.'_report_'.Carbon::parse($monthly)->format('m_Y').'.xlsx';
        } elseif ($filter_display === 'yearly') {
            $fileName = 'customer_transaction_'.$filter_display.'_report_'.$yearly.'.xlsx';
        }

        return Excel::download(new ExCustomerTrans($reportNew), $fileName);
    }
}
