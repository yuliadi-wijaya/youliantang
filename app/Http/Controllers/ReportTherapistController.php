<?php

namespace App\Http\Controllers;
use App\InvoiceSettings;
use App\ReportTherapistTotal;
use App\ReportTrans;
use App\ReportTranSum;
use App\InvoiceDetail;
use App\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Exports\ExTherapistTotal;
use App\Exports\ExTherapistTransDetail;
use App\Exports\ExTherapistTransSummary;
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
                'A' => $index + 1,
                'B' => $row->therapist_name,
                'C' => $status,
                'D' => date('d-m-Y', strtotime($row->register_date)),
                'E' => $row->phone_number,
                'F' => $row->email,
                'G' => $row->ktp,
                'H' => $row->gender,
                'I' => $row->place_of_birth,
                'J' => date('d-m-Y', strtotime($row->birth_date)),
                'K' => $row->address,
                'L' => $row->rekening_number,
                'M' => $row->emergency_name,
                'N' => $row->emergency_contact
            ]);
        }

        $reportNew->push([
            'A' => '',
            'B' => '',
            'C' =>  $total_therapists,
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

            try {
                $dateFrom = date('Y-m-d', strtotime($validatedData['date_from']));
                $dateTo = date('Y-m-d', strtotime($validatedData['date_to']));

                $report = ReportTrans::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                    return $query->whereBetween('treatment_date', [$dateFrom, $dateTo]);
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
                            'products.duration',
                            \DB::raw("COALESCE(invoice_details.fee, products.commission_fee) as commission_fee"),
                            'invoice_details.amount',
                            'invoice_details.treatment_time_from',
                            'invoice_details.treatment_time_to',
                            'invoice_details.room',
                            'reviews.rating',
                            'reviews.comment',
                            \DB::raw("CONCAT(COALESCE(users.first_name,''), ' ', COALESCE(users.last_name,'')) as therapist_name")
                        )
                        ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
                        ->join('products', 'products.id', '=', 'invoice_details.product_id')
                        ->leftJoin('reviews', function ($join) {
                            $join->on('reviews.invoice_id', '=', 'invoice_details.invoice_id')
                                ->on('reviews.invoice_detail_id', '=', 'invoice_details.id')
                                ->on('reviews.therapist_id', '=', 'invoice_details.therapist_id');
                        })
                        ->where('invoice_details.invoice_id', $r->invoice_id)
                        ->where('invoice_details.is_deleted', 0)
                        ->where('invoice_details.status', 1)
                        ->get();
                    }else{
                        $detail = InvoiceDetail::select(
                            'products.name as product_name',
                            'products.duration',
                            \DB::raw("COALESCE(invoice_details.fee, products.commission_fee) as commission_fee"),
                            'invoice_details.amount',
                            \DB::raw('NULL AS rating'),
                            \DB::raw('NULL AS comment')
                        )
                        ->join('products', \DB::raw('LOWER(products.name)'), '=', \DB::raw('LOWER(invoice_details.title)'))
                        ->where('invoice_details.invoice_id', $r->invoice_id)
                        ->where('invoice_details.is_deleted', 0)
                        ->where('invoice_details.status', 1)
                        ->get();
                    }

                    $report_detail[$r->invoice_id] = $detail;
                }

                return view('report.therapist.therapist-trans-detail', compact('user', 'role', 'report' ,'report_detail', 'dateFrom', 'dateTo', 'report_type'));
            } catch (Exception $e) {
                return redirect()->back()->with($e->getMessage())->withInput($request->all());
            }
        }else{
            $validatedData = $request->validate([
                'month' => 'required',
                'year' => 'required',
            ]);

            try {
                $month = $validatedData['month'];
                $year = $validatedData['year'];
                $month_year = $month.'-'.$year;
                $therapist_id = $request->therapist_id;
                $order_by = $request->order_by;

                $report = ReportTranSum::select(
                    'therapist_name',
                    'phone_number',
                    'treatment_month_year',
                    \DB::raw('SUM(duration) as total_duration'),
                    \DB::raw('SUM(commission_fee) as total_commission_fee'),
                    \DB::raw('ROUND(AVG(rating), 2) as avg_rating')
                )
                ->when($month_year, function ($query) use ($month_year) {
                    return $query->where('treatment_month_year', $month_year);
                })
                ->when($invoice_type === 'NC', function ($query) {
                    return $query->where('invoice_type', 'NC');
                })
                ->when($invoice_type === 'CK', function ($query) {
                    return $query->where('invoice_type', 'CK');
                })
                ->when($therapist_id !== 'all', function ($query) use ($therapist_id) {
                    return $query->where('therapist_id', $therapist_id);
                })
                ->when($order_by === 'therapist', function ($query) {
                    return $query->orderBy('therapist_id', 'ASC');
                })
                ->when($order_by === 'lowest_rating', function ($query) {
                    return $query->orderByRaw('AVG(rating) ASC');
                })
                ->when($order_by === 'highest_rating', function ($query) {
                    return $query->orderByRaw('AVG(rating) DESC');
                })
                ->groupBy('therapist_name', 'phone_number', 'treatment_month_year', 'therapist_id')
                ->get();

                return view('report.therapist.therapist-trans-summary', compact('user', 'role', 'report' ,'month', 'year', 'therapist_id', 'order_by', 'report_type'));
            } catch (Exception $e) {
                return redirect()->back()->with($e->getMessage())->withInput($request->all());
            }
        }
    }

    public function exportReportTherapistTrans(Request $request)
    {
        $invoice_type = InvoiceSettings::first()->invoice_type;
        $report_type = $request->report_type;

        if($report_type == 'detail'){
            $dateFrom = date('Y-m-d', strtotime($request->dateFrom));
            $dateTo = date('Y-m-d', strtotime($request->dateTo));

            $report = ReportTrans::when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                return $query->whereBetween('treatment_date', [$dateFrom, $dateTo]);
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
                        'products.duration',
                        \DB::raw("COALESCE(invoice_details.fee, products.commission_fee) as commission_fee"),
                        'invoice_details.amount',
                        'invoice_details.treatment_time_from',
                        'invoice_details.treatment_time_to',
                        'invoice_details.room',
                        'reviews.rating',
                        'reviews.comment',
                        \DB::raw("CONCAT(COALESCE(users.first_name,''), ' ', COALESCE(users.last_name,'')) as therapist_name")
                    )
                    ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
                    ->join('products', 'products.id', '=', 'invoice_details.product_id')
                    ->leftJoin('reviews', function ($join) {
                        $join->on('reviews.invoice_id', '=', 'invoice_details.invoice_id')
                            ->on('reviews.invoice_detail_id', '=', 'invoice_details.id')
                            ->on('reviews.therapist_id', '=', 'invoice_details.therapist_id');
                    })
                    ->where('invoice_details.invoice_id', $r->invoice_id)
                    ->where('invoice_details.is_deleted', 0)
                    ->where('invoice_details.status', 1)
                    ->get();
                }else{
                    $detail = InvoiceDetail::select(
                        'products.name as product_name',
                        'products.duration',
                        \DB::raw("COALESCE(invoice_details.fee, products.commission_fee) as commission_fee"),
                        'invoice_details.amount',
                        \DB::raw('NULL AS rating'),
                        \DB::raw('NULL AS comment')
                    )
                    ->join('products', \DB::raw('LOWER(products.name)'), '=', \DB::raw('LOWER(invoice_details.title)'))
                    ->where('invoice_details.invoice_id', $r->invoice_id)
                    ->where('invoice_details.is_deleted', 0)
                    ->where('invoice_details.status', 1)
                    ->get();
                }

                $report_detail[$r->invoice_id] = $detail;
            }

            $t_price = 0;
            $t_discount = 0;
            $t_grand_total = 0;
            $t_fee = 0;

            $reportNew = new Collection();

            foreach ($report as $row) {
                $t_price += $row->total_price;
                $t_discount += $row->discount;
                $t_grand_total += $row->grand_total;

                $reportNew->push([
                    'A' => $row->invoice_code,
                    'B' => $row->customer_name,
                    'C' => $row->treatment_date,
                    'D' => $row->payment_mode,
                    'E' => $row->payment_status,
                    'F' => $row->note,
                    'G' => $row->voucher_code,
                    'H' => $row->total_price,
                    'I' => $row->discount,
                    'J' => $row->grand_total,
                    'K' => $row->old_data == 'Y' ? $row->therapist_name : '',
                    'L' => $row->old_data == 'Y' ? $row->room : '',
                    'M' => $row->old_data == 'Y' ? $row->time_from : '',
                    'N' => $row->old_data == 'Y' ? $row->time_to : '',
                    'O' => '',
                    'P' => '',
                    'Q' => '',
                    'R' => '',
                    'S' => '',
                    'T' => '',
                ]);

                foreach ($report_detail[$row->invoice_id] as $rd) {
                    $t_fee += $rd->commission_fee;

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
                        'K' => $row->old_data == 'N' ? $rd->therapist_name : '',
                        'L' => $row->old_data == 'N' ? $rd->room : '',
                        'M' => $row->old_data == 'N' ? $rd->treatment_time_from : '',
                        'N' => $row->old_data == 'N' ? $rd->treatment_time_to : '',
                        'O' => $rd->product_name,
                        'P' => $rd->amount,
                        'Q' => $rd->duration,
                        'R' => $rd->commission_fee,
                        'S' => $rd->rating,
                        'T' => $rd->comment,
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
                'H' => $t_price,
                'I' => $t_discount,
                'J' => $t_grand_total,
                'K' => '',
                'L' => '',
                'M' => '',
                'N' => '',
                'O' => '',
                'P' => '',
                'Q' => '',
                'R' => $t_fee,
                'S' => '',
                'T' => '',
                'U' => '',
            ]);

            $fileName = 'report_therapists_transaction_detail_' . Carbon::parse($dateFrom)->format('Ymd') . '_' . Carbon::parse($dateTo)->format('Ymd') . '.xlsx';
            return Excel::download(new ExTherapistTransDetail($reportNew), $fileName);
        }else{
            $month = $request->month;
            $year = $request->year;
            $month_year = $month.'-'.$year;
            $therapist_id = $request->therapist_id;
            $order_by = $request->order_by;

            $report = ReportTranSum::select(
                'therapist_name',
                'phone_number',
                'treatment_month_year',
                \DB::raw('SUM(duration) as total_duration'),
                \DB::raw('SUM(commission_fee) as total_commission_fee'),
                \DB::raw('ROUND(AVG(rating), 2) as avg_rating')
            )
            ->when($month_year, function ($query) use ($month_year) {
                return $query->where('treatment_month_year', $month_year);
            })
            ->when($invoice_type === 'NC', function ($query) {
                return $query->where('invoice_type', 'NC');
            })
            ->when($invoice_type === 'CK', function ($query) {
                return $query->where('invoice_type', 'CK');
            })
            ->when($therapist_id !== 'all', function ($query) use ($therapist_id) {
                return $query->where('therapist_id', $therapist_id);
            })
            ->when($order_by === 'therapist', function ($query) {
                return $query->orderBy('therapist_id', 'ASC');
            })
            ->when($order_by === 'lowest_rating', function ($query) {
                return $query->orderByRaw('AVG(rating) ASC');
            })
            ->when($order_by === 'highest_rating', function ($query) {
                return $query->orderByRaw('AVG(rating) DESC');
            })
            ->groupBy('therapist_name', 'phone_number', 'treatment_month_year', 'therapist_id')
            ->get();

            $gt_duration = 0;
            $gt_fee = 0;

            $reportNew = new Collection();

            foreach ($report as $row) {
                $gt_duration += $row->total_duration;
                $gt_fee += $row->total_commission_fee;

                $reportNew->push([
                    'A' => $row->therapist_name,
                    'B' => $row->phone_number,
                    'C' => $row->treatment_month_year,
                    'D' => $row->total_duration,
                    'E' => $row->total_commission_fee,
                    'F' => $row->avg_rating,
                ]);
            }

            $reportNew->push([
                'A' => '',
                'B' => '',
                'C' => '',
                'D' => $gt_duration,
                'E' => $gt_fee,
                'F' => '',
            ]);

            $fileName = 'report_therapists_transaction_summary_' . $month . '_' . $year . '.xlsx';
            return Excel::download(new ExTherapistTransSummary($reportNew), $fileName);
        }
    }
}