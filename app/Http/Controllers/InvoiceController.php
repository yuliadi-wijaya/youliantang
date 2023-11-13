<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceDetail;
use App\Notification;
use App\Receptionist;
use App\Transaction;
use App\Customer;
use App\Therapist;
use App\Room;
use App\Product;
use App\Promo;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Facades\Config;
use PDF;

class InvoiceController extends Controller
{
    protected $invoice, $invoice_detail, $InvoiceDetail;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->invoice = new Invoice;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('invoice.list')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;
        $invoices = Invoice::select([
            'invoices.id', 'invoices.old_data',
            \DB::raw("CASE WHEN invoices.old_data = 'Y' THEN invoices.customer_name ELSE CONCAT(customer.first_name, ' ', customer.last_name) END AS customer_name"),
            'invoices.treatment_date',
            'invoices.therapist_name',
            'invoices.room',
            \DB::raw("CASE WHEN invoices.old_data = 'Y' THEN invoices.treatment_time_from ELSE (SELECT MIN(treatment_time_from) FROM invoice_details WHERE invoice_details.invoice_id = invoices.id) END AS treatment_time_from"),
            \DB::raw("CASE WHEN invoices.old_data = 'Y' THEN invoices.treatment_time_to ELSE (SELECT MAX(treatment_time_to) FROM invoice_details WHERE invoice_details.invoice_id = invoices.id) END AS treatment_time_to"),
            ])->leftJoin('users as customer', 'invoices.customer_id', '=', 'customer.id')
            ->where('invoices.is_deleted', 0)
            ->paginate($this->limit);

        foreach ($invoices as $invoice) {
            $id = $invoice->id;
            $invoice_detail = InvoiceDetail::select(\DB::raw('CONCAT(users.first_name, " ", users.last_name) as therapist_name'), 'invoice_details.room')
                ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
                ->where('invoice_details.invoice_id', $id)
                ->where('invoice_details.status', 1)
                ->where('invoice_details.is_deleted', 0)
                ->get();
        }

        return view('invoice.invoices', compact('user', 'role', 'invoices', 'invoice_detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('invoice.create')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Default data null
        $invoice = null;
        $customers = Customer::select('users.id', 'users.first_name', 'users.last_name',
                \DB::raw('CASE WHEN COALESCE(customer_members.id, 0) = 0 THEN 0 ELSE 1 END AS is_member'),
                'customer_members.expired_date',
                'memberships.name as member_plan',
                'memberships.discount_type',
                'memberships.discount_value')
            ->join('users', 'users.id', '=', 'customers.user_id')
            ->leftJoin('customer_members', function($join) {
                $join->on('customer_members.customer_id', '=', 'users.id')
                    ->where('customer_members.status', '=', 1);
            })
            ->leftJoin('memberships', function($join) {
                $join->on('memberships.id', '=', 'customer_members.membership_id')
                    ->whereRaw('TIMESTAMPADD(DAY, memberships.total_active_period, memberships.created_at) >= NOW()')
                    ->where('memberships.status', '=', 1)
                    ->where('memberships.is_deleted', '=', 0);
            })
            ->where('users.is_deleted', '=', 0)
            ->where('users.status', '=', 1)
            ->orderBy('users.first_name', 'asc')
            ->get();
        $therapists = Therapist::select('users.id', 'users.first_name', 'users.last_name')
            ->join('users', 'users.id', '=', 'therapists.user_id')
            ->where('users.is_deleted', 0)
            ->where('users.status', 1)
            ->orderBy('users.first_name', 'ASC')
            ->get();
        $rooms = Room::where('is_deleted',0)->where('status',1)->orderBy('id','ASC')->get();
        $products = Product::where('status', 1)->where('is_deleted', 0)->orderBy('id','ASC')->get();
        $promos = Promo::select(
                \DB::raw('(SELECT voucher_code
                          FROM promo_vouchers AS a
                          WHERE a.is_used = 0 AND a.promo_id = promos.id
                          ORDER BY a.voucher_code
                          LIMIT 1) AS voucher_code'),
                'promos.name',
                'promos.discount_type',
                'promos.discount_value',
                'promos.discount_max_value'
            )
            ->where('promos.status', 1)
            ->where('promos.is_deleted', 0)
            ->where('promos.active_period_start', '<=', now())
            ->where('promos.active_period_end', '>=', now())
            ->get();

        return view('invoice.invoice-details', compact('user', 'role', 'invoice', 'customers', 'therapists', 'rooms', 'products', 'promos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('invoice.create')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'customer_id' => 'required',
            'treatment_date' => 'required|date',
            'payment_mode' => 'required',
            'payment_status' => 'required',

            'invoices' => 'required|array',
            'invoices.*.product_id' => 'required',
            'invoices.*.time_from' => 'required',
            'invoices.*.therapist_id' => 'required',
            'invoices.*.room' => 'required'
        ]);

        try {
            // Validate invoices
            if ($request->invoices[0]['product_id'] == null && $request->invoices[0]['amount'] == null) {
                return redirect()->back()->with('error', 'Add at least one Invoice product and amount to create invoice!!!');
            }

            // Mapping request to object and store data
            $obj = $this->toObject($request, new Invoice());
            $obj->created_by = $user->id;
            $obj->save();

            // Store invoice detail
            $obj->invoice_detail()->saveMany($this->toObjectDetails($request, $obj));

            return redirect('invoice')->with('success', 'Invoice created successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        if($invoice->old_data == 'Y') {
            $invoice_detail = Invoice::with('invoice_detail')->where('id', $invoice->id)->first();
        }else{
            $invoices = Invoice::select(
                    'invoices.id',
                    \DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS customer_name"),
                    'invoices.treatment_date',
                    'invoices.created_at',
                    'invoices.payment_mode',
                    'invoices.payment_status',
                    'invoices.is_member',
                    'invoices.use_member',
                    'invoices.member_plan',
                    'invoices.voucher_code',
                    'invoices.total_price',
                    'invoices.discount',
                    'invoices.grand_total'
                )
                ->join('users', 'invoices.customer_id', '=', 'users.id')
                ->where('invoices.is_deleted', 0)
                ->where('invoices.id', $invoice->id)
                ->first();

            $invoice_detail = InvoiceDetail::select(
                    'products.name as product_name',
                    'amount',
                    'treatment_time_from',
                    'treatment_time_to',
                    'room',
                    \DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS therapist_name")
                )
                ->join('products', 'products.id', '=', 'invoice_details.product_id')
                ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
                ->where('invoice_details.invoice_id', $invoice->id)
                ->get();
        }

        // Check user access and available data
        if (!$user->hasAccess('invoice.show') || $invoice_detail == NULL) {
            return view('error.403');
        }

        if($invoice->old_data == 'Y') {
            return view('invoice.view-invoice-old', compact('user', 'role', 'invoice', 'invoice_detail'));
        }else{
            return view('invoice.view-invoice-new', compact('user', 'role', 'invoices', 'invoice_detail'));
        }
    }

    public function invoice_pdf($id)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $invoice = Invoice::where('id', $id)->first();

        // Check user access and available data
        if (!$user->hasAccess('invoice.invoice_pdf')) {
            return view('error.403');
        }

        if($invoice->old_data == 'Y') {
            $invoice_detail = Invoice::with('invoice_detail')->where('id', $id)->first();

            $pdf = PDF::loadView('invoice.invoice-pdf-old', compact('user', 'role', 'invoice', 'invoice_detail'));
        }else{
            $invoices = Invoice::select(
                'invoices.id',
                \DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS customer_name"),
                'invoices.treatment_date',
                'invoices.created_at',
                'invoices.payment_mode',
                'invoices.payment_status',
                'invoices.is_member',
                'invoices.use_member',
                'invoices.member_plan',
                'invoices.voucher_code',
                'invoices.total_price',
                'invoices.discount',
                'invoices.grand_total'
            )
            ->join('users', 'invoices.customer_id', '=', 'users.id')
            ->where('invoices.is_deleted', 0)
            ->where('invoices.id', $id)
            ->first();

            $invoice_detail = InvoiceDetail::select(
                'products.name as product_name',
                'amount',
                'treatment_time_from',
                'treatment_time_to',
                'room',
                \DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS therapist_name")
            )
            ->join('products', 'products.id', '=', 'invoice_details.product_id')
            ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
            ->where('invoice_details.invoice_id', $id)
            ->get();

            $pdf = PDF::loadView('invoice.invoice-pdf-new', compact('user', 'role', 'invoices', 'invoice_detail'));
        }

        return $pdf->download('invoice_' . date('Y-m-d') . '_' . $id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get user session data
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $invoice = Invoice::where('id', $id)->first();

        $rooms = Room::where('is_deleted',0)->where('status',1)->orderBy('id','ASC')->get();

        if($invoice->old_data == 'Y') {
            $invoice_detail = Invoice::with('invoice_detail')->where('id', $id)->first();
        }else{
            $invoice_detail = InvoiceDetail::where('invoice_id', $id)->where('is_deleted', 0)->where('status', 1)->get();
            $customers = Customer::select('users.id', 'users.first_name', 'users.last_name',
                    \DB::raw('CASE WHEN COALESCE(customer_members.id, 0) = 0 THEN 0 ELSE 1 END AS is_member'),
                    'customer_members.expired_date',
                    'memberships.name as member_plan',
                    'memberships.discount_type',
                    'memberships.discount_value'
                )
                ->join('users', 'users.id', '=', 'customers.user_id')
                ->leftJoin('customer_members', function($join) {
                    $join->on('customer_members.customer_id', '=', 'users.id')
                        ->where('customer_members.status', '=', 1);
                })
                ->leftJoin('memberships', function($join) {
                    $join->on('memberships.id', '=', 'customer_members.membership_id')
                        ->whereRaw('TIMESTAMPADD(DAY, memberships.total_active_period, memberships.created_at) >= NOW()')
                        ->where('memberships.status', '=', 1)
                        ->where('memberships.is_deleted', '=', 0);
                })
                ->where('users.is_deleted', '=', 0)
                ->where('users.status', '=', 1)
                ->orderBy('users.first_name', 'asc')
                ->get();
            $therapists = Therapist::select('users.id', 'users.first_name', 'users.last_name')
                ->join('users', 'users.id', '=', 'therapists.user_id')
                ->where('users.is_deleted', 0)
                ->where('users.status', 1)
                ->orderBy('users.first_name', 'ASC')
                ->get();
            $products = Product::where('status', 1)->where('is_deleted', 0)->orderBy('id','ASC')->get();
            $promos = Promo::select(
                    \DB::raw('(SELECT voucher_code
                            FROM promo_vouchers AS a
                            WHERE a.is_used = 0 AND a.promo_id = promos.id
                            ORDER BY a.voucher_code
                            LIMIT 1) AS voucher_code'),
                    'promos.name',
                    'promos.discount_type',
                    'promos.discount_value',
                    'promos.discount_max_value'
                )
                ->where('promos.status', 1)
                ->where('promos.is_deleted', 0)
                ->where('promos.active_period_start', '<=', now())
                ->where('promos.active_period_end', '>=', now())
                ->get();
        }

        // Check user access and available data
        if (!$user->hasAccess('invoice.update') || $invoice_detail == NULL) {
            return view('error.403');
        }

        if($invoice->old_data == 'Y') {
            return view('invoice.edit-invoice-old', compact('user', 'role', 'invoice_detail', 'rooms'));
        }else{
            return view('invoice.edit-invoice-new', compact('user', 'role', 'invoice', 'invoice_detail', 'customers', 'therapists', 'rooms', 'products', 'promos'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('invoice.update')) {
            return view('error.403');
        }

        // Validate input data
        if($request->old_data == 'Y') {
            $request->validate([
                'customer_name' => 'required|string',
                'therapist_name' => 'required|string',
                'room' => 'required',
                'treatment_date' => 'required|date',
                'treatment_time_from' => 'required',
                'treatment_time_to' => 'required',
                'payment_mode' => 'required',
                'payment_status' => 'required'
            ]);
        }else{
            $request->validate([
                'customer_id' => 'required',
                'treatment_date' => 'required|date',
                'payment_mode' => 'required',
                'payment_status' => 'required',

                'invoices' => 'required|array',
                'invoices.*.product_id' => 'required',
                'invoices.*.time_from' => 'required',
                'invoices.*.therapist_id' => 'required',
                'invoices.*.room' => 'required'
            ]);
        }
        try {
        // Mapping request to object and store data
        $obj = $this->toObject($request, $invoice);
        $obj->updated_by = $user->id;
        $obj->save();

        // old invoice_list details delete
        InvoiceDetail::where('invoice_id', $invoice->id)->update(['is_deleted' => 1]);

        // Store invoice detail
        $obj->invoice_detail()->saveMany($this->toObjectDetails($request, $obj));

        return redirect('invoice')->with('success', 'Invoice updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
    }
    public function customer_by_appointment(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.create')) {
            if ($request->ajax()) {
                $customer_id =  $request->customer_id;
                $user = Sentinel::getUser();
                $user_id = $user->id;
                $role = $user->roles[0]->slug;
                $therapist_role = Sentinel::findRoleBySlug('therapist');
                if ($role == 'therapist') {
                    $appointment = Appointment::where('id', $user_id)->orWhere('appointment_for', $customer_id)->where('appointment_with', $user_id)->where('is_deleted', 1)
                        ->orderBy('id', 'DESC')->pluck("appointment_date", "id")->all();
                } elseif ($role == 'receptionist') {
                    $receptionists_therapist_id = ReceptionListTherapist::where('reception_id', $user_id)->pluck('therapist_id');
                    $appointment  = Appointment::where('appointment_for', $customer_id)->whereIN('appointment_with', $receptionists_therapist_id)->where('is_deleted', 1)
                        ->orderBy('id', 'DESC')->pluck("appointment_date", "id")->all();
                }
                $data = view('appointment.ajax-select-appointment', compact('appointment'))->render();
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Appointment select by Customer id!",
                    'options' => $data
                ]);
            }
        } else {
            return view('error.403');
        }
    }
    public function appointment_by_therapist(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.create')) {
            if ($request->ajax()) {
                $appointment_id =  $request->appointment_id;
                $user = Sentinel::getUser();
                $role = $user->roles[0]->slug;
                $therapist_role = Sentinel::findRoleBySlug('therapist');
                $appointment = Appointment::where('id', $appointment_id)->pluck('appointment_with');
                $therapists = $therapist_role->users()->where('id', $appointment)->select('first_name', 'last_name', 'id')->get();
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Appointment select by Customer id!",
                    'data' => $therapists
                ]);
            }
        } else {
            return view('error.403');
        }
    }
    public function invoice_list()
    {
        $user = Sentinel::getUser();
        $user_id = Sentinel::getUser()->id;
        $role = $user->roles[0]->slug;
        $invoices = Invoice::with('appointment', 'appointment.timeSlot')->where('customer_id', $user_id)->orderBy('id', 'DESC')->paginate($this->limit);
        return view('customer.customer-invoices', compact('user', 'role', 'invoices'));
    }
    public function invoice_view($id)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $invoice_detail = Invoice::with('invoice_detail', 'customer', 'therapist', 'appointment', 'appointment.timeSlot', 'transaction')->where('customer_id', $user->id)->where('id', $id)->first();
        // return $invoice_detail;
        if ($invoice_detail) {
            return view('customer.customer-invoice-view', compact('user', 'role', 'invoice_detail'));
        } else {
            return redirect()->back()->with('error', 'Invoice details not found');
        }
    }

    public function transaction()
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $transaction = Transaction::paginate($this->limit);
        return view('admin.transaction', compact('transaction', 'user', 'role'));
    }

    /**
     * Mapping request to object.
     *
     * @param  \Illuminate\Http\Request
     * @return \App\Invoice $invoice
     */
    private function toObject(Request $request, Invoice $invoice) {
        $invoice->treatment_date = date('Y-m-d', strtotime($request->treatment_date));
        $invoice->payment_mode = $request->payment_mode;
        $invoice->payment_status = $request->payment_status;
        $invoice->note = $request->note;

        if($request->old_data == 'N') {
            $invoice->customer_id = $request->customer_id;
            $invoice->is_member = $request->is_member;
            if (isset($request->use_member) && $request->use_member == 1) {
                $invoice->use_member = 1;
                $invoice->member_plan = $request->member_plan;
                $invoice->voucher_code = NULL;
            }else{
                $invoice->use_member = 0;
                $invoice->member_plan = NULL;
                $invoice->voucher_code = $request->voucher_code;
            }
            $invoice->total_price = str_replace(',', '', $request->total_price);
            $invoice->discount = str_replace(',', '', $request->discount);
            $invoice->grand_total = str_replace(',', '', $request->grand_total);

        }else{
            $invoice->customer_name = $request->customer_name;
            $invoice->therapist_name = $request->therapist_name;
            $invoice->room = $request->room;
            $invoice->treatment_time_from = $request->treatment_time_from;
            $invoice->treatment_time_to = $request->treatment_time_to;
        }

        return $invoice;
    }

    private function toObjectDetails(Request $request, Invoice $invoice) {
        $invoiceDetails = [];

        foreach ($request->invoices as $item) {
            $obj = new InvoiceDetail();
            if($request->old_data == 'N') {
                $obj->product_id = $item['product_id'];
                $obj->amount = str_replace(',', '', $item['amount']);
                $obj->treatment_time_from = $item['time_from'];
                $obj->treatment_time_to = $item['time_to'];
                $obj->therapist_id = $item['therapist_id'];
                $obj->room = $item['room'];
            }else{
                $obj->title = $item['title'];
                $obj->amount = str_replace(',', '', $item['amount']);
            }

            $invoiceDetails[] = $obj;
        }

        return $invoiceDetails;
    }
}
