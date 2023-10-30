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
        if ($user->hasAccess('customer.list')) {
            $role = $user->roles[0]->slug;
            $customer_role = Sentinel::findRoleBySlug('customer');
            //$customers = $customer_role->users()->with('roles')->where('is_deleted', 0)->orderByDesc('id')->get();
            $customers = DB::table('users')
            ->join('customers', 'users.id', '=', 'customers.user_id')
            ->select('users.first_name', 'users.last_name', 'users.phone_number', 'users.email', 'customers.*')
            ->where('users.is_deleted', 0)
            ->orderBy('users.id', 'DESC')
            ->limit(5)
            ->get();

            // Load Datatables
            if ($request->ajax()) {
                return Datatables::of($customers)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        $name = $row->first_name.' '.$row->last_name;
                        return $name;
                    })
                    ->addColumn('status', function($row) {
                        return Config::get('constants.status.' . $row->status, 'Undefined');
                    })
                    ->addColumn('option', function($row){
                        $option = '
                            <a href="customer/'.$row->id.'">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                            </a>
                            <a href="customer/'.$row->id.'/edit">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Profile">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </button>
                            </a>
                            <a href=" javascript:void(0)">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Profile" data-id="'.$row->id.'" id="delete-customer">
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
        $user = Sentinel::getUser();
        if ($user->hasAccess('customer.create')) {
            $role = $user->roles[0]->slug;
            $customer = null;
            $customer_info = null;
            return view('customer.customer-details', compact('user', 'role', 'customer', 'customer_info'));
        } else {
            return view('error.403');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('customer.create')) {
            $validatedData = $request->validate([
                'first_name' => 'required|alpha',
                'last_name' => 'alpha',
                'phone_number' => 'required',
                'email' => 'required|email|unique:users|regex:/(.+)@(.+)\.(.+)/i|max:50',
                'address' => 'required|max:100',
                'gender' => 'required',
                'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                'status' => 'required'
            ]);
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
            try {
                $user = Sentinel::getUser();
                // Set Default Password for Customer
                $validatedData['password'] = Config::get('app.DEFAULT_PASSWORD');
                $validatedData['created_by'] = $user->id;
                $validatedData['updated_by'] = $user->id;
                //Create a new user
                $customer = Sentinel::registerAndActivate($validatedData);
                //Attach the user to the role
                $role = Sentinel::findRoleBySlug('customer');
                $role->users()->attach($customer);
                $validatedData['user_id'] = $customer->id;

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
                $verify_mail = trim($request->email);
                Mail::send('emails.WelcomeEmail', ['user' => $customer, 'email' => $verify_mail], function ($message) use ($verify_mail, $app_name) {
                    $message->to($verify_mail);
                    $message->subject($app_name . ' ' . 'Welcome email from You Lian tAng - Reflexology & Massage Therapy');
                });
                return redirect('/customer')->with('success', 'Customer created successfully!');
            } catch (Exception $e) {
                return redirect('customer')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                //dd($e->getMessage());
            }
        } else {
            return view('error.403');

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
                    $appointments = Appointment::with('therapist')->where('appointment_for', $customer->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'appointment');
                    $prescriptions = Prescription::with('therapist')->where('customer_id', $customer->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'prescriptions');
                    $invoices = Invoice::where('customer_id', $customer->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'invoice');
                    $tot_appointment = Appointment::where('appointment_for', $customer->id)->get();
                    $invoice = Invoice::where('customer_id', $customer->id)->pluck('id');
                    $revenue = InvoiceDetail::whereIn('invoice_id',$invoice)->sum('amount');
                    $pending_bill = Invoice::where(['customer_id' => $customer->id, 'payment_status' => 'Unpaid'])->count();
                    $data = [
                        'total_appointment' => $tot_appointment->count(),
                        'revenue' => $revenue,
                        'pending_bill' => $pending_bill
                    ];
                    return view('customer.customer-profile', compact('user', 'role', 'customer', 'customer_info', 'data', 'appointments', 'prescriptions', 'invoices'));
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
                'last_name' => 'alpha',
                'phone_number' => 'required',
                'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                'address' => 'required|max:100',
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
                $customer->last_name = $validatedData['last_name'];
                $customer->phone_number = $validatedData['phone_number'];
                $customer->email = $validatedData['email'];
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
