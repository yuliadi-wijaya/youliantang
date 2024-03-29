<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Invoice;
use App\InvoiceDetail;
use App\Customer;
use App\User;
use App\Prescription;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;


class CustomerController extends Controller
{
    protected $customer_info;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->customer_info = new Customer();
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
    public function index(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;

        if ($user->hasAccess('customer.list')) {
            $user_id = $user->id;
            $customer_role = Sentinel::findRoleBySlug('customer');
            $customers = $customer_role->users()->with(['roles', 'customer'])->where('is_deleted', 0)->orderByDesc('id')->get();

            // Load Datatables
            if ($request->ajax()) {
                return Datatables::of($customers)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        $name = ucwords($row->first_name).' '.ucwords($row->last_name);
                        return $name;
                    })
                    ->addColumn('status', function($row) {
                        return Config::get('constants.status.' . $row->status, 'Undefined');
                    })
                    ->addColumn('option', function($row){
                        $option = '
                            <a href="customer/'.$row->id.'">
                                <button type="button" class="btn btn-info btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                            </a>
                            <a href="customer/'.$row->id.'/edit">
                                <button type="button" class="btn btn-warning btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Profile">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </button>
                            </a>
                            <a href=" javascript:void(0)">
                                <button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Profile" data-id="'.$row->id.'" id="delete-customer">
                                    <i class="mdi mdi-trash-can"></i>
                                </button>
                            </a>';
                        return $option;
                    })->rawColumns(['option'])->make(true);
            }
            // End
            return view('customer.customers', compact('user', 'role', 'customers'));
        } else {
            return view('error.403');
        }
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
        if (!$user->hasAccess('customer.create')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Default data null
        $customer = null;
        $customer_info = null;

        // Default email
        $runningNumber = User::join('role_users as b', 'b.user_id', '=', 'users.id')
            ->where('b.role_id', 4)
            ->count() + 1;

        $cust_mail = 'cust' . $runningNumber . '@youliantang.com';

        return view('customer.customer-details', compact('user', 'role', 'customer', 'customer_info', 'cust_mail'));
    }

    public function create_from_invoice()
    {
        $user = Sentinel::getUser();
        if (!$user->hasAccess('customer.create')) {
            return view('error.403');
        }

        $role = $user->roles[0]->slug;

        $customer = null;
        $customer_info = null;

        // Default email
        $runningNumber = User::join('role_users as b', 'b.user_id', '=', 'users.id')
            ->where('b.role_id', 4)
            ->count() + 1;

        $cust_mail = 'cust' . $runningNumber . '@youliantang.com';

        return view('invoice.customer-add', compact('user', 'role', 'customer', 'customer_info', 'cust_mail'));
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
        if (!$user->hasAccess('customer.create')) {
            return view('error.403');
        }

        // Validate input data
        $validatedData = $request->validate([
            'first_name' => 'required|alpha',
            // 'phone_number' => 'required',
            'email' => 'nullable|email',
            'gender' => 'required',
            'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500',
            'status' => 'required'
        ]);

        try {
            // Upload profile foto
            if ($request->profile_photo != null) {
                $request->validate([
                    'profile_photo' => 'image'
                ]);
                $file = $request->file('profile_photo');
                $extention = $file->getClientOriginalExtension();
                $imageName = time() . '.' . $extention;
                $file->move(public_path('storage/images/users'), $imageName);
                $validatedData['profile_photo'] = $imageName;
            }

            // Set Default Password for Customer
            $validatedData['last_name'] = $request->last_name;
            $validatedData['phone_number'] = $request->phone_number;
            $validatedData['email'] = empty($validatedData['email']) ? $request->hidden_mail : $validatedData['email'];
            $validatedData['password'] = Config::get('app.DEFAULT_PASSWORD');
            $validatedData['created_by'] = $user->id;
            $validatedData['updated_by'] = $user->id;

            //Create a new user
            $customer = Sentinel::registerAndActivate($validatedData);

            //Attach the user to the role
            $role = Sentinel::findRoleBySlug('customer');
            $role->users()->attach($customer);

            $customer_info = new Customer();
            $customer_info->user_id = $customer->id;
            $customer_info->gender = $request->gender;
            $customer_info->place_of_birth = $request->place_of_birth;
            $customer_info->birth_date = $request->birth_date;
            $customer_info->address = $request->address;
            $customer_info->emergency_contact = $request->emergency_contact;
            $customer_info->emergency_name = $request->emergency_name;
            $customer_info->created_by = $user->id;
            $customer_info->updated_by = $user->id;
            $customer_info->status = $request->status;
            $customer_info->save();

            $app_name =  AppSetting('title');
            /*
            if($request->email !== ''){
                $verify_mail = trim($request->email);
                Mail::send('emails.WelcomeEmail', ['user' => $customer, 'email' => $verify_mail], function ($message) use ($verify_mail, $app_name) {
                    $message->to($verify_mail);
                    $message->subject($app_name . ' ' . 'Welcome email from You Lian tAng - Reflexology & Massage Therapy');
                });
            }*/
            if($request->post_from == 'customer') {
                return redirect('customer')->with('success', 'Customer created successfully!');
            }else{
                return redirect('invoice/create')->with('success', 'Customer created successfully!');
            }

        } catch (Exception $e) {
            if($request->post_from == 'customer') {
                return redirect('customer')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }else{
                return redirect('invoice/create')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('customer.view')) {
            $role = $user->roles[0]->slug;
            $customer = $user::whereHas('roles',function($rq){
                $rq->where('slug','customer');
            })->where('id', $customer->id)->where('is_deleted', 0)->first();
            if ($customer) {
                $customer_info = Customer::where('user_id', '=', $customer->id)->first();
                if ($customer_info) {
                    $customer_role = Sentinel::findRoleBySlug('customer');
                    $customers = $customer_role->users()->with('roles')->get();

                    $invoices = Invoice::join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
                    ->join('users', 'users.id', '=', 'invoices.customer_id')
                    ->where('invoices.customer_id', $customer->id)
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
                            ", [$customer->id]);

                    $invoice_total = 0;
                    $revenue_total = 0;
                    if (count($invoice_transaction) > 0) {
                        $invoice_total = $invoice_transaction[0]->invoice_total;
                        $revenue_total = $invoice_transaction[0]->revenue_total;
                    }
                            
                    $data = [
                        'invoice_total' => $invoice_total,
                        'bill_total' => $revenue_total
                    ];
                    return view('customer.customer-profile', compact('user', 'role', 'customer', 'customer_info', 'data', 'invoices'));
                } else {
                    return redirect('/')->with('error', 'Customer information  not found, update customer information');
                }
            } else {
                return redirect('/')->with('error', 'Customer not found');
            }
        } else {
            return view('error.403');

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        $user = Sentinel::getUser();
        $customer = $user::whereHas('roles',function($rq){
            $rq->where('slug','customer');
        })->where('id', $customer->id)->where('is_deleted', 0)->first();
        if($customer){
            if ($user->hasAccess('customer.update')) {
                $role = $user->roles[0]->slug;
                $customer_info = Customer::where('user_id', '=', $customer->id)->first();
                return view('customer.customer-details', compact('user', 'role', 'customer', 'customer_info'));
            } else {
                return view('error.403');
            }
        }
        else{
            return redirect('/')->with('error', 'Customer not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $customer)
    {
        // return $request;
        $user = Sentinel::getUser();
        if ($user->hasAccess('customer.update')) {
            $validatedData = $request->validate([
                'first_name' => 'required|alpha',
                // 'phone_number' => 'required',
                'email' => 'nullable|email',
                'gender' => 'required',
                'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                'status' => 'required'
            ]);
            try {
                $user = Sentinel::getUser();
                $role = $user->roles[0]->slug;
                if ($request->hasFile('profile_photo')) {
                    $des = 'storage/images/users/.' . $customer->profile_photo;
                    if (File::exists($des)) {
                        File::delete($des);
                    }
                    $file = $request->file('profile_photo');
                    $extention = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extention;
                    $file->move(public_path('storage/images/users'), $imageName);
                    $customer->profile_photo = $imageName;
                }
                $customer->first_name = $validatedData['first_name'];
                $customer->last_name = $request->last_name;
                $customer->phone_number = $request->phone_number;
                $customer->email = empty($validatedData['email']) ? $request->hidden_mail : $validatedData['email'];
                $customer->status = $validatedData['status'];
                $customer->updated_by = $user->id;
                $customer->save();
                $customer_info= Customer::where('user_id', '=', $customer->id)->first();
                    if($customer_info == null){
                        $customer_info = new Customer();
                        $customer_info->user_id = $customer->id;
                        $customer_info->gender = $request->gender;
                        $customer_info->place_of_birth = $request->place_of_birth;
                        $customer_info->birth_date = $request->birth_date;
                        $customer_info->address = $request->address;
                        $customer_info->emergency_contact = $request->emergency_contact;
                        $customer_info->emergency_name = $request->emergency_name;
                        $customer_info->created_by = $user->id;
                        $customer_info->updated_by = $user->id;
                        $customer_info->status = $request->status;
                        $customer_info->save();
                    }
                    else{
                        $customer_info->user_id = $customer->id;
                        $customer_info->gender = $request->gender;
                        $customer_info->place_of_birth = $request->place_of_birth;
                        $customer_info->birth_date = $request->birth_date;
                        $customer_info->address = $request->address;
                        $customer_info->emergency_contact = $request->emergency_contact;
                        $customer_info->emergency_name = $request->emergency_name;
                        $customer_info->created_by = $user->id;
                        $customer_info->updated_by = $user->id;
                        $customer_info->status = $request->status;
                        $customer_info->save();
                    }
                if ($role == 'customer') {
                    return redirect('/')->with('success', 'Profile updated successfully!');
                } else {
                    return redirect('customer')->with('success', 'Customer Profile updated successfully!');
                }
            } catch (Exception $e) {
                return redirect('customer')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Sentinel::getUser();
        $customer = $user::whereHas('roles',function($rq){
            $rq->where('slug','customer');
        })->where('id', $request->id)->where('is_deleted', 0)->first();
        if($customer){
            if ($user->hasAccess('customer.delete')) {
                try {
                    $User = User::where('id',$request->id)->first();
                    if ($User != Null) {
                        $User->is_deleted = 1;
                        $User->save();
                        return response()->json([
                            'success' => true,
                            'message' => 'Customer deleted successfully.',
                            'data' => $User,
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Customer not found.',
                            'data' => [],
                        ], 409);
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'success' =>false,
                        'message' => 'Something went wrong!!!' . $e->getMessage(),
                        'data' => [],
                    ],409);
                }
            }
            else {
                return response()->json([
                    'success' =>false,
                    'message' =>'You have no permission to delete customer',
                    'data'=> [],
                ],409);
            }
        }else{
            return redirect('/')->with('error', 'Customer not found');
        }
    }
}
