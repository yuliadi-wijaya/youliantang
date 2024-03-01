<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Therapist;
use App\TherapistAvailableDay;
use App\TherapistAvailableTime;
use App\Invoice;
use App\InvoiceDetail;
use Illuminate\Http\Request;
use App\Customer;
use App\MedicalInfo;
use App\Prescription;
use App\Receptionist;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{

    protected $customer, $medical_info, $MedicalInfo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->customer = new Customer();
        $this->medical_info = new MedicalInfo();
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
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Sentinel::check()) {
            return redirect('/');
        } else {
            return view('profile-details');
        }
    }

    public function userProfileDetails()
    {
        return view('profile-details');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'gender' => 'required'
        ]);
        try {
            $user = Sentinel::getUser();
            $customer = Sentinel::getUser();
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
            $customer->save();
            // customer details save
            $customer_id = $customer->id;
            $customer_Details = new Customer();
            $customer_Details->user_id = $customer->id;
            $customer_Details->gender = $request->gender;
            $customer_Details->place_of_birth = $request->place_of_birth;
            $customer_Details->birth_date = $request->birth_date;
            $customer_Details->address = $request->address;
            $customer_Details->emergency_contact = $request->emergency_contact;
            $customer_Details->emergency_name = $request->emergency_name;
            $customer_Details->status = $request->status;
            $customer_Details->save();

            return redirect('/')->with('success', 'Register Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('profile.update')) {
            $userId = $user->id;
            $role = $user->roles[0]->slug;
            if ($role == 'admin') {
                return view('admin.admin-edit', compact('user', 'role'));
            } elseif ($role == 'therapist') {
                $therapist = Sentinel::getUser();
                $therapist_info = Therapist::where('user_id', '=', $therapist->id)->first();
                if ($therapist_info) {
                    $availableDay = TherapistAvailableDay::where('therapist_id', $therapist->id)->first();
                    $availableTime = TherapistAvailableTime::where('therapist_id', $therapist->id)->get();
                    return view('therapist.therapist-profile-edit', compact('user', 'role', 'therapist', 'therapist_info', 'availableDay', 'availableTime'));
                } else {
                    return redirect('/')->with('error', 'Therapist details not found');
                }
            } elseif ($role == 'receptionist') {
                $receptionist = Sentinel::getUser();
                $receptionist_info = Receptionist::where('user_id', '=', $receptionist->id)->first();
                $role = $user->roles[0]->slug;
                $therapist_role = Sentinel::findRoleBySlug('therapist');
                $therapists = $therapist_role->users()->with(['roles', 'therapist'])->where('is_deleted', 0)->get();
                return view('receptionist.receptionist-profile-edit', compact('user', 'role', 'receptionist', 'receptionist_info', 'therapists'));
            } elseif ($role == 'customer') {
                $customer = Sentinel::getUser();
                $customer_info = Customer::where('user_id', '=', $customer->id)->first();
                $medical_info = MedicalInfo::where('user_id', '=', $customer->id)->first();
                // return $customer;
                return view('customer.customer-edit', compact('user', 'role', 'customer', 'customer_info', 'medical_info'));
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('profile.update')) {
            $role = $user->roles[0]->slug;
            if ($role == 'admin') {
                $validatedData = $request->validate([
                    'first_name' => 'required|alpha',
                    'last_name' => 'required|alpha',
                    'phone_number' => 'required',
                    'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                    'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                ]);
                try {
                    $userId = $user->id;
                    if ($request->hasFile('profile_photo')) {
                        $des = 'storage/images/users/.' . $user->profile_photo;
                        if (File::exists($des)) {
                            File::delete($des);
                        }
                        $file = $request->file('profile_photo');
                        $extension = $file->getClientOriginalExtension();
                        $imageName = time() . '.' . $extension;
                        $file->move(public_path('storage/images/users'), $imageName);
                        $user->profile_photo = $imageName;
                    }
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->email = $request->email;
                    $user->last_name = $request->last_name;
                    $user->phone_number = $request->phone_number;
                    $user->updated_by = $userId;
                    $user->save();
                    return redirect('/')->with('success', 'Profile updated successfully!');
                } catch (Exception $e) {
                    return redirect('/')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
            } elseif ($role == 'therapist') {
                $therapist = Sentinel::getUser();
                $user = Sentinel::getUser();
                $validatedData = $request->validate([
                    'first_name' => 'required|alpha',
                    'last_name' => 'alpha',
                    'ktp' => 'required|regex:/^[0-9]*$/|max:16',
                    'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                    'gender' => 'required',
                    'phone_number' => 'required',
                    'rekening_number' => 'required|numeric',
                    'mon' => 'required_without_all:tue,wen,thu,fri,sat,sun',
                    'tue' => 'required_without_all:mon,wen,thu,fri,sat,sun',
                    'wen' => 'required_without_all:mon,tue,thu,fri,sat,sun',
                    'thu' => 'required_without_all:mon,wen,tue,fri,sat,sun',
                    'fri' => 'required_without_all:wen,tue,mon,thu,sat,sun',
                    'sat' => 'required_without_all:wen,tue,mon,thu,fri,sun',
                    'sun' => 'required_without_all:wen,tue,mon,thu,fri,sat',
                    'profile_photo' =>'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                ]);
                try {
                    $user = Sentinel::getUser();
                    $role = $user->roles[0]->slug;
                    if ($request->hasFile('profile_photo')) {
                        $des = 'storage/images/users/.' . $therapist->profile_photo;
                        if (File::exists($des)) {
                            File::delete($des);
                        }
                        $file = $request->file('profile_photo');
                        $extention = $file->getClientOriginalExtension();
                        $imageName = time() . '.' . $extention;
                        $file->move(public_path('storage/images/users'), $imageName);
                        $therapist->profile_photo = $imageName;
                    }
                    $therapist->first_name = $validatedData['first_name'];
                    $therapist->last_name = $validatedData['last_name'];
                    $therapist->phone_number = $validatedData['phone_number'];
                    $therapist->email = $validatedData['email'];
                    $therapist->updated_by = $user->id;
                    $therapist->save();
                    Therapist::where('user_id', $therapist->id)
                        ->update([
                            'ktp' => $validatedData['ktp'],
                            'gender' => $validatedData['gender'],
                            'place_of_birth' =>$request->place_of_birth,
                            'birth_date' => $request->birth_date,
                            'address' => $request->address,
                            'rekening_number' => $request->rekening_number,
                            'emergency_contact' => $request->emergency_contact,
                            'emergency_name' => $request->emergency_name,
                        ]);
                    $availableDay = TherapistAvailableDay::where('therapist_id', $therapist->id)->first();
                    $availableDay->therapist_id = $therapist->id;
                    if ($availableDay->mon = $request->mon !== Null) {
                        $availableDay->mon = $request->mon;
                    }
                    if ($availableDay->tue = $request->tue !== Null) {
                        $availableDay->tue = $request->tue;
                    }
                    if ($availableDay->wen = $request->wen !== Null) {
                        $availableDay->wen = $request->wen;
                    }
                    if ($availableDay->thu = $request->thu !== Null) {
                        $availableDay->thu = $request->thu;
                    }
                    if ($availableDay->fri = $request->fri !== Null) {
                        $availableDay->fri = $request->fri;
                    }
                    if ($availableDay->sat = $request->sat !== Null) {
                        $availableDay->sat = $request->sat;
                    }
                    if ($availableDay->sun = $request->sun !== Null) {
                        $availableDay->sun = $request->sun;
                    }
                    $availableDay->save();
                    if ($role == 'therapist') {
                        return redirect('/')->with('success', 'Profile updated successfully!');
                    } else {
                        return redirect('therapist')->with('success', 'Profile updated successfully!');
                    }
                } catch (Exception $e) {
                    return redirect('therapist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
            } elseif ($role == 'receptionist') {
                $receptionist = Sentinel::getUser();
                $validatedData = $request->validate([
                    'first_name' => 'required|alpha',
                    'last_name' => 'alpha',
                    'ktp' => 'required|regex:/^[0-9]*$/|max:16',
                    'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                    'gender' => 'required',
                    'phone_number' => 'required',
                    'rekening_number' => 'required|numeric',
                    'profile_photo' =>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
                ]);
                try {
                    $user = Sentinel::getUser();
                    $role = $user->roles[0]->slug;
                    if ($request->hasFile('profile_photo')) {
                        $des = 'storage/images/users/.' . $receptionist->profile_photo;
                        if (File::exists($des)) {
                            File::delete($des);
                        }
                        $file = $request->file('profile_photo');
                        $extention = $file->getClientOriginalExtension();
                        $imageName = time() . '.' . $extention;
                        $file->move(public_path('storage/images/users'), $imageName);
                        $receptionist->profile_photo = $imageName;
                    }
                    $receptionist->first_name = $validatedData['first_name'];
                    $receptionist->last_name = $validatedData['last_name'];
                    $receptionist->email = $validatedData['email'];
                    $receptionist->phone_number = $validatedData['phone_number'];
                    $receptionist->updated_by = $user->id;
                    $receptionist->save();
                    Receptionist::where('user_id', $receptionist->id)
                        ->update([
                            'ktp' => $validatedData['ktp'],
                            'gender' => $validatedData['gender'],
                            'place_of_birth' =>$request->place_of_birth,
                            'birth_date' => $request->birth_date,
                            'address' => $request->address,
                            'rekening_number' => $request->rekening_number,
                            'emergency_contact' => $request->emergency_contact,
                            'emergency_name' => $request->emergency_name,
                        ]);
                    if ($role == 'receptionist') {
                        return redirect('/')->with('success', 'Profile updated successfully!');
                    } else {
                        return redirect('receptionist')->with('success', 'Profile updated successfully!');
                    }
                } catch (Exception $e) {
                    return redirect('receptionist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
            } elseif ($role == 'customer') {
                $customer = Sentinel::getUser();
                $validatedData = $request->validate([
                    'first_name' => 'required|alpha',
                    'last_name' => 'required|alpha',
                    'phone_number' => 'required',
                    'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                    'age' => 'required|numeric',
                    'address' => 'required',
                    'gender' => 'required',
                    'height' => 'required|numeric',
                    'b_group' => 'required',
                    'pulse' => 'required|numeric',
                    'allergy' => 'required|regex:/^[a-zA-Z ]+$/',
                    'weight' => 'required|numeric',
                    'b_pressure' => 'required|numeric',
                    'respiration' => 'required|numeric',
                    'diet' => 'required',
                    'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
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
                    $customer->first_name = $request->first_name;
                    $customer->last_name = $request->last_name;
                    $customer->phone_number = $request->phone_number;
                    $customer->email = $request->email;
                    $customer->updated_by = $user->id;
                    $customer->save();
                    $customer_info= Customer::where('user_id', '=', $user->id)->first();
                    if($customer_info == null){
                        $customer_info = new Customer();
                        $customer_info->age = $request->age;
                        $customer_info->gender = $request->gender;
                        $customer_info->address = $request->address;
                        $customer_info->user_id = $user->id;
                        $customer_info->save();
                    }
                    else{
                        $customer_info->age = $request->age;
                        $customer_info->gender = $request->gender;
                        $customer_info->address = $request->address;
                        $customer_info->user_id = $user->id;
                        $customer_info->save();
                    }
                    $medical_info = MedicalInfo::where('user_id', '=', $customer->id)->first();
                    if($medical_info == null){
                        $medical_info = new MedicalInfo();
                        $medical_info->height = $request->height;
                        $medical_info->b_group = $request->b_group;
                        $medical_info->pulse = $request->pulse;
                        $medical_info->allergy = $request->allergy;
                        $medical_info->weight = $request->weight;
                        $medical_info->b_pressure = $request->b_pressure;
                        $medical_info->respiration = $request->respiration;
                        $medical_info->diet = $request->diet;
                        $medical_info->user_id = $user->id;
                        $medical_info->save();
                    }
                    else{
                        $medical_info->height = $request->height;
                        $medical_info->b_group = $request->b_group;
                        $medical_info->pulse = $request->pulse;
                        $medical_info->allergy = $request->allergy;
                        $medical_info->weight = $request->weight;
                        $medical_info->b_pressure = $request->b_pressure;
                        $medical_info->respiration = $request->respiration;
                        $medical_info->diet = $request->diet;
                        $medical_info->user_id = $user->id;
                        $medical_info->save();
                    }
                    if ($role == 'customer') {
                        return redirect('/')->with('success', 'Profile updated successfully!');
                    } else {
                        return redirect('customer')->with('success', 'Profile updated successfully!');
                    }
                } catch (Exception $e) {
                    return redirect('customer')->with('error', 'Something went wrong!!! ' . $e->getMessage());
                }
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
    public function profile_view(Request $request)
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($role == 'customer') {
            $customer = Sentinel::getUser();
            $customer_info = Customer::where('user_id', '=', $customer->id)->first();
            if ($customer) {
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
                return view('customer.customer-profile-view', compact('user', 'role', 'customer', 'customer_info', 'data', 'invoices'));
            } else {
                return redirect('/')->with('error', 'Customer not found');
            }
        } elseif ($role == 'therapist') {
            $therapist = Sentinel::getUser();
            $role = $user->roles[0]->slug;
            $therapist_info = Therapist::where('user_id', '=', $therapist->id)->first();
            if ($therapist_info) {
                $invoices = Invoice::join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
                        ->join('users', 'users.id', '=', 'invoices.customer_id')
                        ->join('products', 'products.id', '=', 'invoice_details.product_id')
                        ->where('invoice_details.therapist_id', $therapist->id)
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
                    
                    $payroll_transaction_fee = InvoiceDetail::select(DB::raw('COUNT(DISTINCT invoice_id) AS invoice_total
                    ,COUNT(DISTINCT id) AS treatment_total
                    ,SUM(fee) AS commission_fee_total '))
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('therapist_id', $therapist->id)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$payroll_start_date->format('Y-m-d'), $payroll_end_date->format('Y-m-d')])
                    ->groupBy(DB::raw('YEAR(created_at)'))
                    ->first();
                    // end payroll logic

                    $todays_transaction_fee = InvoiceDetail::select(DB::raw('COUNT(DISTINCT invoice_id) AS invoice_total
                    ,COUNT(DISTINCT id) AS treatment_total
                    ,SUM(fee) AS commission_fee_total '))
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('therapist_id', $therapist->id)
                    ->whereDate('created_at', Carbon::now())
                    ->groupBY(DB::raw('YEAR(created_at)'))
                    ->first();

                    $monthly_transaction_fee = InvoiceDetail::select(DB::raw('COUNT(DISTINCT invoice_id) AS invoice_total
                    ,COUNT(DISTINCT id) AS treatment_total
                    ,SUM(fee) AS commission_fee_total '))
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('therapist_id', $therapist->id)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->groupBY(DB::raw('YEAR(created_at)'))
                    ->first();

                    $therapist_transaction_fee = InvoiceDetail::select(DB::raw('COUNT(DISTINCT invoice_id) AS invoice_total
                    ,COUNT(DISTINCT id) AS treatment_total
                    ,SUM(fee) AS commission_fee_total '))
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('therapist_id', $therapist->id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->groupBY(DB::raw('YEAR(created_at)'))
                    ->first();

                    $data = [
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

                    $availableDay = TherapistAvailableDay::where('therapist_id', $therapist->id)->first();
                return view('therapist.therapist-profile-view', compact('user', 'role', 'therapist', 'therapist_info', 'data', 'invoices', 'availableDay'));
            } else {
                return redirect('/')->with('error', 'Therapists details not found');
            }
        } elseif ($role == 'receptionist') {
            $receptionist = Sentinel::getUser();
            $receptionist_info = Receptionist::where('user_id', $receptionist->id)->first();
            
            $invoices = Invoice::join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
                ->join('users', 'users.id', '=', 'invoices.customer_id')
                ->where('invoices.created_by', $receptionist->id)
                ->where('invoices.status', '1')
                ->where('invoices.is_deleted', '0')
                ->where('invoice_details.is_deleted', '0')
                ->where('invoices.payment_status', 'Paid')
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
                    , 'invoices');

            $pending_invoices = Invoice::join('invoice_details', 'invoice_details.invoice_id', '=', 'invoices.id')
                ->join('users', 'users.id', '=', 'invoices.customer_id')
                ->where('invoices.created_by', $receptionist->id)
                ->where('invoices.status', '1')
                ->where('invoices.is_deleted', '0')
                ->where('invoice_details.is_deleted', '0')
                ->where('invoices.payment_status', 'Unpaid')
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
                    , 'pending_invoices');

            $invoice_transaction_paid = Invoice::select(DB::raw('count(id) as invoice_total
                        ,sum(total_price) as price_total
                        ,sum(discount) as discount_total 
                        ,sum(tax_amount) as tax_amount_total
                        ,sum(grand_total) as revenue_total'))
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('payment_status', 'Paid')
                    ->whereYear('treatment_date', Carbon::now()->year)
                    ->where('created_by', $receptionist->id)
                    ->groupBy(DB::raw('year(treatment_date)'))
                    ->first();

            $invoice_transaction_unpaid = Invoice::select(DB::raw('count(id) as invoice_total
                        ,sum(total_price) as price_total
                        ,sum(discount) as discount_total 
                        ,sum(tax_amount) as tax_amount_total
                        ,sum(grand_total) as revenue_total'))
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->where('payment_status', 'Unpaid')
                    ->whereYear('treatment_date', Carbon::now()->year)
                    ->where('created_by', $receptionist->id)
                    ->groupBy(DB::raw('year(treatment_date)'))
                    ->first();
                
            $data = [
                'invoice_total' => ($invoice_transaction_paid) ? $invoice_transaction_paid->invoice_total : 0,
                'revenue' => ($invoice_transaction_paid) ? $invoice_transaction_paid->revenue_total : 0,
                'pending_invoice_total' => ($invoice_transaction_unpaid) ? $invoice_transaction_unpaid->invoice_total : 0,
                'pending_revenue' => ($invoice_transaction_unpaid) ? $invoice_transaction_unpaid->revenue_total : 0
            ];

            $pagination = 0;
            if($request->has('invoices')) {
                $pagination = 1;
            }
            
            $config = [
                'pagination' => $pagination
            ];

            return view('receptionist.receptionist-profile-view', compact('user', 'role', 'receptionist', 'receptionist_info', 'data', 'config', 'invoices', 'pending_invoices'));
        } else {
            return redirect('/')->with('error', 'role not found');
        }
    }
}
