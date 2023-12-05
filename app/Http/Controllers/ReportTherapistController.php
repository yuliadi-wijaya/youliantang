<?php

namespace App\Http\Controllers;
use App\InvoiceSettings;
use App\ReportTherapistTotal;
use App\ReportTherapistTransDetail;
use App\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Exports\ExTherapistTotal;
use App\Exports\ExTherapistTransDetailDetail;
use Maatwebsite\Excel\Facades\Excel;

class ReportTherapistController extends Controller
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

    public function fiterReportTotal()
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.filter')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        return view('report.therapist.filter-therapist-total', compact('user', 'role'));
    }

    public function showReportTherapistTotal(Request $request)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.view')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        $status = $request->status;

        $report = ReportTherapistTotal::when($status !== 'All', function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->get();

        return view('report.therapist.therapist-total', compact('user', 'role', 'report', 'status'));
    }

    public function exportReportTherapistTotal(Request $request)
    {
        $status = $request->status;

        $report = ReportTherapistTotal::when($status !== 'All', function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->get();

        $total_therapists = 0;

        $reportNew = new Collection();

        foreach ($report as $index => $row) {
            $total_therapists += 1;

            if ($row->status == 1) {
                $status = 'Active';
            }else{
                $status = 'Non Active';
            }

            $reportNew->push([
                'no' => $index + 1,
                'therapist_name' => $row->therapist_name,
                'status' => $status,
                'register_date' => date('d-m-Y', strtotime($row->register_date)),
                'phone_number' => $row->phone_number,
                'email' => $row->email,
                'ktp' => $row->ktp,
                'gender' => $row->gender,
                'place_of_birth' => $row->place_of_birth,
                'birth_date' => date('d-m-Y', strtotime($row->birth_date)),
                'address' => $row->address,
                'rekening_number' => $row->rekening_number,
                'emergency_name' => $row->emergency_name,
                'emergency_contact' => $row->emergency_contact
            ]);
        }

        $reportNew->push([
            'no' => '',
            'therapists_name' => 'Total Therapist',
            'status' =>  $total_therapists,
            'register_date' => '',
            'phone_number' => '',
            'email' => '',
            'ktp' => '',
            'gender' => '',
            'place_of_birth' => '',
            'birth_date' => '',
            'address' => '',
            'rekening_number' => '',
            'emergency_name' => '',
            'emergency_contact' => '',
        ]);

        $fileName = 'report_total_therapist.xlsx';

        return Excel::download(new ExTherapistTotal($reportNew), $fileName);
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

        $therapists = Therapist::select('users.id',
            \DB::raw("CONCAT(COALESCE(users.first_name,''), ' ', COALESCE(users.last_name,'')) AS therapist_name"))
            ->join('users', 'users.id', '=', 'therapists.user_id')
            ->where('users.is_deleted', 0)
            ->where('users.status', 1)
            ->orderBy('users.first_name', 'ASC')
            ->get();

        return view('report.therapist.filter-therapist-trans', compact('user', 'role', 'therapists'));
    }

    public function showReportTherapistTrans(Request $request)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.view')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        $invoice_type = InvoiceSettings::first()->invoice_type;
        $report_type = $request->report_type;

        if($report_type == 'detail'){
            // Validate input data
            $validatedData = $request->validate([
                'date_from' => 'required|date',
                'date_to' => 'required|date|after:date_from',
            ]);
            $dateFrom = date('Y-m-d', strtotime($validatedData['date_from']));
            $dateTo = date('Y-m-d', strtotime($validatedData['date_to']));

            $report = ReportTherapistTransDetail::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                return $query->whereBetween('treatment_date', [$dateFrom, $dateTo]);
            })
            ->when($invoice_type === 'NC', function ($query) {
                return $query->where('invoice_type', 'NC');
            })
            ->when($invoice_type === 'CK', function ($query) {
                return $query->where('invoice_type', 'CK');
            })
            ->get();

            return view('report.therapist.therapist-trans-detail', compact('user', 'role', 'report', 'dateFrom', 'dateTo', 'report_type'));
        }
    }

    public function exportReportTherapistTrans(Request $request)
    {
        $invoice_type = InvoiceSettings::first()->invoice_type;
        $report_type = $request->report_type;

        if($report_type == 'detail'){
            $dateFrom = date('Y-m-d', strtotime($request->dateFrom));
            $dateTo = date('Y-m-d', strtotime($request->dateTo));

            $report = ReportTherapistTransDetail::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
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
                if ($index > 0 && $row->therapists_id == $report[$index - 1]->therapists_id) {
                    $therapists_name = '';
                    $phone_number = '';
                    $email = '';
                }else{
                    $therapists_name = $row->therapists_name;
                    $phone_number = $row->phone_number;
                    $email = $row->email;
                }

                if ($index > 0 && $row->therapists_id == $report[$index - 1]->therapists_id && $row->invoice_code == $report[$index - 1]->invoice_code) {
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
                    'therapists_name' => $therapists_name,
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
                    'therapists_name' => $row->therapists_name,
                    'room' => $row->room,
                    'time_from' => $row->time_from,
                    'time_to' => $row->time_to,
                ]);
            }

            $reportNew->push([
                'therapists_name' => '',
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
                'therapists_name' => '',
                'room' => '',
                'time_from' => '',
                'time_to' => '',
            ]);

            $fileName = 'report_therapists_transaction_' . Carbon::parse($dateFrom)->format('Ymd') . '_' . Carbon::parse($dateTo)->format('Ymd') . '.xlsx';

            return Excel::download(new ExTherapistTransDetail($reportNew), $fileName);
        }
    }
}
