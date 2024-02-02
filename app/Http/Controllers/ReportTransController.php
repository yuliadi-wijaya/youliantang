<?php

namespace App\Http\Controllers;
use App\RoleAccess;
use App\ReportTrans;
use App\ReportTranSum;
use App\InvoiceDetail;
use App\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Exports\ExTransDetail;
use App\Exports\ExTransSummary;
use Maatwebsite\Excel\Facades\Excel;

class ReportTransController extends Controller
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

        return view('report.transaction.filter-trans', compact('user', 'role', 'therapists'));
    }

    public function showReportTrans(Request $request)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('report.view')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        $invoice_type = RoleAccess::where('user_id', $user->id)->first()->access_code;
        $report_type = $request->report_type;
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

        if($report_type == 'detail'){
            try {
                $report = ReportTrans::when($filter_display === 'daily', function ($query) use ($daily) {
                    return $query->whereDate('invoice_date', $daily);
                })
                ->when($filter_display === 'monthly', function ($query) use ($monthly) {
                    return $query->whereYear('invoice_date', substr($monthly, 0, 4))
                        ->whereMonth('invoice_date', substr($monthly, 5, 2));
                })
                ->when($filter_display === 'yearly', function ($query) use ($yearly) {
                    return $query->whereYear('invoice_date', $yearly);
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
                            \DB::raw("CONCAT(COALESCE(users.first_name,''), ' ', COALESCE(users.last_name,'')) as therapist_name"),
                            'users.phone_number as therapist_phone'
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

                $viewData = compact('user', 'role', 'report', 'report_detail', 'report_type', 'filter_display', 'daily', 'monthly', 'yearly');
                return view('report.transaction.trans-detail', $viewData);
            } catch (Exception $e) {
                return redirect()->back()->with($e->getMessage())->withInput($request->all());
            }
        }else{
            try {
                $therapist_id = $request->therapist_id;
                $order_by = $request->order_by;

                $report = ReportTranSum::select('therapist_name', 'phone_number')
                ->when($filter_display === 'daily', function ($query) use ($daily) {
                    return $query->addSelect('treatment_date')
                        ->whereDate('treatment_date', $daily);
                })
                ->when($filter_display === 'monthly', function ($query) use ($monthly) {
                    return $query->addSelect(\DB::raw('DATE_FORMAT(treatment_date, "%Y-%m") as treatment_month'))
                        ->whereYear('treatment_date', substr($monthly, 0, 4))
                        ->whereMonth('treatment_date', substr($monthly, 5, 2));
                })
                ->when($filter_display === 'yearly', function ($query) use ($yearly) {
                    return $query->addSelect(\DB::raw('DATE_FORMAT(treatment_date, "%Y") as treatment_year'))
                        ->whereYear('treatment_date', $yearly);
                })
                ->addSelect(\DB::raw('SUM(duration) as total_duration'))
                ->addSelect(\DB::raw('SUM(commission_fee) as total_commission_fee'))
                ->addSelect(\DB::raw('ROUND(AVG(rating), 2) as avg_rating'))
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
                ->when($filter_display === 'daily', function ($query) {
                    return $query->groupBy('therapist_name', 'phone_number', 'treatment_date', 'therapist_id');
                })
                ->when($filter_display === 'monthly', function ($query) {
                    return $query->groupBy('therapist_name', 'phone_number', 'treatment_month', 'therapist_id');
                })
                ->when($filter_display === 'yearly', function ($query) {
                    return $query->groupBy('therapist_name', 'phone_number', 'treatment_year', 'therapist_id');
                })
                ->get();

                $viewData = compact('user', 'role', 'report', 'report_type', 'filter_display', 'daily', 'monthly', 'yearly', 'therapist_id', 'order_by');
                return view('report.transaction.trans-summary', $viewData);
            } catch (Exception $e) {
                return redirect()->back()->with($e->getMessage())->withInput($request->all());
            }
        }
    }

    public function exportReportTrans(Request $request)
    {
        $user = Sentinel::getUser();

        $invoice_type = RoleAccess::where('user_id', $user->id)->first()->access_code;
        $report_type = $request->report_type;
        $filter_display = $request->filter_display;
        $daily = $request->daily;
        $monthly = $request->monthly;
        $yearly = $request->yearly;

        if($report_type == 'detail'){
            $report = ReportTrans::when($filter_display === 'daily', function ($query) use ($daily) {
                return $query->whereDate('invoice_date', $daily);
            })
            ->when($filter_display === 'monthly', function ($query) use ($monthly) {
                return $query->whereYear('invoice_date', substr($monthly, 0, 4))
                    ->whereMonth('invoice_date', substr($monthly, 5, 2));
            })
            ->when($filter_display === 'yearly', function ($query) use ($yearly) {
                return $query->whereYear('invoice_date', $yearly);
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
                        \DB::raw("CONCAT(COALESCE(users.first_name,''), ' ', COALESCE(users.last_name,'')) as therapist_name"),
                        'users.phone_number as therapist_phone'
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
            $t_tax_amount = 0;
            $t_grand_total = 0;
            $t_duration = 0;
            $t_fee = 0;

            $reportNew = new Collection();

            foreach ($report as $row) {
                $t_price += $row->total_price;
                $t_discount += $row->discount;
                $t_tax_amount += $row->tax_amount;
                $t_grand_total += $row->grand_total;

                $reportNew->push([
                    'A' => $row->invoice_code,
                    'B' => \Carbon\Carbon::parse($row->invoice_date)->toDateString(),
                    'C' => $row->customer_name,
                    'D' => $row->customer_phone,
                    'E' => $row->treatment_date,
                    'F' => $row->payment_mode,
                    'G' => $row->payment_status,
                    'H' => $row->note,
                    'I' => $row->is_member,
                    'J' => $row->use_member,
                    'K' => $row->voucher_code,
                    'L' => $row->total_price,
                    'M' => $row->discount,
                    'N' => $row->tax_rate,
                    'O' => $row->tax_amount,
                    'P' => $row->grand_total,
                    'Q' => $row->old_data == 'Y' ? $row->therapist_name : '',
                    'R' => $row->old_data == 'Y' ? $row->therapist_phone : '',
                    'S' => $row->old_data == 'Y' ? $row->room : '',
                    'T' => $row->old_data == 'Y' ? $row->time_from : '',
                    'U' => $row->old_data == 'Y' ? $row->time_to : '',
                    'V' => '',
                    'W' => '',
                    'X' => '',
                    'Y' => '',
                    'Z' => '',
                    'AA' => '',
                ]);

                foreach ($report_detail[$row->invoice_id] as $rd) {
                    $t_fee += $rd->commission_fee;
                    $t_duration += $rd->duration;

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
                        'Q' => $row->old_data == 'N' ? $rd->therapist_name : '',
                        'R' => $row->old_data == 'N' ? $rd->therapist_phone : '',
                        'S' => $row->old_data == 'N' ? $rd->room : '',
                        'T' => $row->old_data == 'N' ? $rd->treatment_time_from : '',
                        'U' => $row->old_data == 'N' ? $rd->treatment_time_to : '',
                        'V' => $rd->product_name,
                        'W' => $rd->amount,
                        'X' => $rd->duration,
                        'Y' => $rd->commission_fee,
                        'Z' => $rd->rating,
                        'AA' => $rd->comment,
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
                'L' => $t_price,
                'M' => $t_discount,
                'N' => '',
                'O' => $t_tax_amount,
                'P' => $t_grand_total,
                'Q' => '',
                'R' => '',
                'S' => '',
                'T' => '',
                'U' => '',
                'V' => '',
                'W' => '',
                'X' => $t_duration,
                'Y' => $t_fee,
                'Z' => '',
                'AA' => '',
            ]);

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
                'P' => $t_grand_total - $t_fee,
                'Q' => '',
                'R' => '',
                'S' => '',
                'T' => '',
                'U' => '',
                'V' => '',
                'W' => '',
                'X' => '',
                'Y' => '',
                'Z' => '',
                'AA' => '',
            ]);

            if ($filter_display === 'daily') {
                $fileName = 'transaction_'.$report_type.'_'.$filter_display.'_report_'.Carbon::parse($daily)->format('d_m_Y').'.xlsx';
            } elseif ($filter_display === 'monthly') {
                $fileName = 'transaction_'.$report_type.'_'.$filter_display.'_report_'.Carbon::parse($monthly)->format('m_Y').'.xlsx';
            } elseif ($filter_display === 'yearly') {
                $fileName = 'transaction_'.$report_type.'_'.$filter_display.'_report_'.$yearly.'.xlsx';
            }

            return Excel::download(new ExTransDetail($reportNew), $fileName);
        }else{
            $therapist_id = $request->therapist_id;
            $order_by = $request->order_by;

            $report = ReportTranSum::select('therapist_name', 'phone_number')
            ->when($filter_display === 'daily', function ($query) use ($daily) {
                return $query->addSelect('treatment_date')
                    ->whereDate('treatment_date', $daily);
            })
            ->when($filter_display === 'monthly', function ($query) use ($monthly) {
                return $query->addSelect(\DB::raw('DATE_FORMAT(treatment_date, "%Y-%m") as treatment_month'))
                    ->whereYear('treatment_date', substr($monthly, 0, 4))
                    ->whereMonth('treatment_date', substr($monthly, 5, 2));
            })
            ->when($filter_display === 'yearly', function ($query) use ($yearly) {
                return $query->addSelect(\DB::raw('DATE_FORMAT(treatment_date, "%Y") as treatment_year'))
                    ->whereYear('treatment_date', $yearly);
            })
            ->addSelect(\DB::raw('SUM(duration) as total_duration'))
            ->addSelect(\DB::raw('SUM(commission_fee) as total_commission_fee'))
            ->addSelect(\DB::raw('ROUND(AVG(rating), 2) as avg_rating'))
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
            ->when($filter_display === 'daily', function ($query) {
                return $query->groupBy('therapist_name', 'phone_number', 'treatment_date', 'therapist_id');
            })
            ->when($filter_display === 'monthly', function ($query) {
                return $query->groupBy('therapist_name', 'phone_number', 'treatment_month', 'therapist_id');
            })
            ->when($filter_display === 'yearly', function ($query) {
                return $query->groupBy('therapist_name', 'phone_number', 'treatment_year', 'therapist_id');
            })
            ->get();

            $gt_duration = 0;
            $gt_fee = 0;

            $reportNew = new Collection();

            foreach ($report as $row) {
                $gt_duration += $row->total_duration;
                $gt_fee += $row->total_commission_fee;

                $dateColumn = '';
                if ($filter_display === 'daily') {
                    $dateColumn = $row->treatment_date;
                } elseif ($filter_display === 'monthly') {
                    $dateColumn = $row->treatment_month;
                } elseif ($filter_display === 'yearly') {
                    $dateColumn = $row->treatment_year;
                }

                $reportNew->push([
                    'A' => $row->therapist_name,
                    'B' => $row->phone_number,
                    'C' => $dateColumn,
                    'D' => $row->total_duration.' Minutes',
                    'E' => $row->total_commission_fee,
                    'F' => $row->avg_rating,
                ]);
            }

            $reportNew->push([
                'A' => '',
                'B' => '',
                'C' => '',
                'D' => $gt_duration.' Minutes',
                'E' => $gt_fee,
                'F' => '',
            ]);

            if ($filter_display === 'daily') {
                $fileName = 'transaction_'.$report_type.'_'.$filter_display.'_report_'.Carbon::parse($daily)->format('d_m_Y').'.xlsx';
            } elseif ($filter_display === 'monthly') {
                $fileName = 'transaction_'.$report_type.'_'.$filter_display.'_report_'.Carbon::parse($monthly)->format('m_Y').'.xlsx';
            } elseif ($filter_display === 'yearly') {
                $fileName = 'transaction_'.$report_type.'_'.$filter_display.'_report_'.$yearly.'.xlsx';
            }

            return Excel::download(new ExTransSummary($reportNew), $fileName);
        }
    }
}
