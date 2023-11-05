<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceDetail;
use App\Notification;
use App\Receptionist;
use App\Transaction;
use App\Room;
use App\Product;
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

        // Get available data only
        $invoices = Invoice::where('is_deleted', 0)->paginate($this->limit);

        return view('invoice.invoices', compact('user', 'role', 'invoices'));
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
        $rooms = Room::where('is_deleted',0)->orderBy('id','ASC')->get();
        $products = Product::where('status', 1)->where('is_deleted', 0)->orderBy('id','ASC')->get();

        return view('invoice.invoice-details', compact('user', 'role', 'invoice', 'rooms', 'products'));
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
            'customer_name' => 'required',
            'therapist_name' => 'required',
            'room' => 'required',
            'treatment_date' => 'required|date',
            'treatment_time_from' => 'required',
            'treatment_time_to' => 'required',
            'payment_mode' => 'required',
            'payment_status' => 'required'
        ]);

        try {
            // Validate invoices
            if ($request->invoices[0]['title'] == null && $request->invoices[0]['amount'] == null) {
                return redirect()->back()->with('error', 'Add at least one Invoice title and amount to create invoice!!!');
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
        $invoice_detail = Invoice::with('invoice_detail')->where('id', $invoice->id)->first();

        // Check user access and available data
        if (!$user->hasAccess('invoice.show') || $invoice_detail == NULL) {
            return view('error.403');
        }

        return view('invoice.view-invoice', compact('user', 'role', 'invoice', 'invoice_detail'));
    }

    public function invoice_pdf($id)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $invoice = Invoice::where('id', $id)->first();
        $invoice_detail = Invoice::with('invoice_detail')->where('id', $id)->first();

        // Check user access and available data
        if (!$user->hasAccess('invoice.invoice_pdf') || $invoice_detail == NULL) {
            return view('error.403');
        }

        $pdf = PDF::loadView('invoice.invoice-pdf', compact('user', 'role', 'invoice', 'invoice_detail'));
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

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $invoice_detail = Invoice::with('invoice_detail')->where('id', $id)->first();
        $rooms = Room::where('is_deleted',0)->orderBy('id','ASC')->get();
        $products = Product::where('is_deleted',0)->orderBy('id','ASC')->get();

        // Check user access and available data
        if (!$user->hasAccess('invoice.update') || $invoice_detail == NULL) {
            return view('error.403');
        }

        return view('invoice.edit-invoice', compact('user', 'role', 'invoice_detail', 'rooms', 'products'));
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
        $request->validate([
            'customer_name' => 'required',
            'therapist_name' => 'required',
            'room' => 'required',
            'treatment_date' => 'required|date',
            'treatment_time_from' => 'required',
            'treatment_time_to' => 'required',
            'payment_mode' => 'required',
            'payment_status' => 'required'
        ]);

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
        $invoice->customer_name = $request->customer_name;
        $invoice->therapist_name = $request->therapist_name;
        $invoice->room = $request->room;
        $invoice->treatment_date = date('Y-m-d', strtotime($request->treatment_date));
        $invoice->treatment_time_from = $request->treatment_time_from;
        $invoice->treatment_time_to = $request->treatment_time_to;
        $invoice->payment_mode = $request->payment_mode;
        $invoice->payment_status = $request->payment_status;
        $invoice->note = $request->note;

        return $invoice;
    }

    private function toObjectDetails(Request $request, Invoice $invoice) {
        $invoiceDetails = [];

        foreach ($request->invoices as $item) {
            $obj = new InvoiceDetail();
            $obj->title = $item['title'];
            $obj->amount = $item['amount'];
            $invoiceDetails[] = $obj;
        }

        return $invoiceDetails;
    }
}
