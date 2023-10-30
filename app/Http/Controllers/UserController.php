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
            'age' => 'required|numeric',
            'address' => 'required',
            'gender' => 'required',
            'profile_photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:500',
            'height' => 'required|numeric',
            'b_group' => 'required',
            'pulse' => 'required|numeric',
            'allergy' => 'required|regex:/^[a-zA-Z ]+$/',
            'weight' => 'required|numeric',
            'b_pressure' => 'required|numeric',
            'respiration' => 'required|numeric',
            'diet' => 'required'
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
            $customer_Details->user_id = $customer_id;
            $customer_Details->age = $request->age;
            $customer_Details->gender = $request->gender;
            $customer_Details->address = $request->address;
            $customer_Details->save();
            // medical info save
            $medical_info = new MedicalInfo();
            $medical_info->user_id = $customer_id;
            $medical_info->height = $request->height;
            $medical_info->b_group = $request->b_group;
            $medical_info->pulse = $request->pulse;
            $medical_info->allergy = $request->allergy;
            $medical_info->weight = $request->weight;
            $medical_info->b_pressure = $request->b_pressure;
            $medical_info->respiration = $request->respiration;
            $medical_info->diet = $request->diet;
            $medical_info->save();
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
                $role = $user->roles[0]->slug;
                $therapist_role = Sentinel::findRoleBySlug('therapist');
                $therapists = $therapist_role->users()->with(['roles', 'therapist'])->where('is_deleted', 0)->get();
                $receptionist_therapist = ReceptionListTherapist::where('reception_id', $receptionist->id)->where('is_deleted', 0)->pluck('therapist_id');
                $therapist_user = User::whereIn('id', $receptionist_therapist)->pluck('id')->toArray();
                return view('receptionist.receptionist-profile-edit', compact('user', 'role', 'receptionist', 'therapists', 'therapist_user'));
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
                    'last_name' => 'required|alpha',
                    'phone_number' => 'required',
                    'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                    'title' => 'required|regex:/^[a-zA-Z ]+$/',
                    'fees' => 'required|numeric',
                    'degree' => 'required',
                    'experience' => 'required|numeric',
                    'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                    'mon' => 'required_without_all:tue,wen,thu,fri,sat,sun',
                    'tue' => 'required_without_all:mon,wen,thu,fri,sat,sun',
                    'wen' => 'required_without_all:mon,tue,thu,fri,sat,sun',
                    'thu' => 'required_without_all:mon,wen,tue,fri,sat,sun',
                    'fri' => 'required_without_all:wen,tue,mon,thu,sat,sun',
                    'sat' => 'required_without_all:wen,tue,mon,thu,fri,sun',
                    'sun' => 'required_without_all:wen,tue,mon,thu,fri,sat',
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
                            'title' => $validatedData['title'],
                            'degree' => $validatedData['degree'],
                            'experience' => $validatedData['experience'],
                            'fees' => $validatedData['fees'],
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
                    'last_name' => 'required|alpha',
                    'phone_number' => 'required',
                    'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                    'therapist' => 'required',
                    'profile_photo'=>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
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
                    $receptionist->phone_number = $validatedData['phone_number'];
                    $receptionist->email = $validatedData['email'];
                    $receptionist->updated_by = $user->id;

                    $old_therapist = ReceptionListTherapist::where('reception_id', $receptionist->id)->pluck('therapist_id')->toArray();
                    $new_therapist = $request->therapist;
                    $numArray = array_map('intval', $new_therapist);
                    // remove therapist
                    $differenceArray1 = array_diff($old_therapist, $numArray);
                    // add therapist
                    $differenceArray2 = array_diff($numArray, $old_therapist);
                    $receptionistTherapist = ReceptionListTherapist::where('reception_id', $receptionist->id)->pluck('therapist_id');
                    if ($differenceArray1 && $differenceArray2) {
                        // add and remove both therapist
                        if ($differenceArray1) {
                            $receptionistTherapist = ReceptionListTherapist::whereIn('therapist_id', $differenceArray1)->delete();
                        }
                        if ($differenceArray2) {
                            foreach ($differenceArray2 as $item) {
                                $receptionistTherapist = new ReceptionListTherapist();
                                $receptionistTherapist->therapist_id = $item;
                                $receptionistTherapist->reception_id = $receptionist->id;
                                $receptionistTherapist->save();
                            }
                        }
                    } elseif ($differenceArray1) {
                        // only remove therapist
                        $receptionistTherapist = ReceptionListTherapist::whereIn('therapist_id', $differenceArray1)->delete();
                    } elseif ($differenceArray2) {
                        // only add therapist
                        foreach ($differenceArray2 as $item) {
                            $receptionistTherapist = new ReceptionListTherapist();
                            $receptionistTherapist->therapist_id = $item;
                            $receptionistTherapist->reception_id = $receptionist->id;
                            $receptionistTherapist->save();
                        }
                    }
                    $receptionist->save();
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
    public function profile_view()
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        if ($role == 'customer') {
            $customer = Sentinel::getUser();
            $customer_info = Customer::where('user_id', '=', $customer->id)->first();
            if ($customer) {
                $medical_Info = MedicalInfo::where('user_id', '=', $customer->id)->first();
                $customer_role = Sentinel::findRoleBySlug('customer');
                $customers = $customer_role->users()->with('roles')->get();
                $appointments = Appointment::with('therapist')->where('appointment_for', $customer->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'appointment');
                $prescriptions = Prescription::with('therapist')->where('customer_id', $customer->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'prescription');
                $invoices = Invoice::where('customer_id', $customer->id)->orderBy('id', 'desc')->paginate($this->limit, '*', 'invoice');
                $tot_appointment = Appointment::where('appointment_for', $customer->id)->get();
                $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                    $re->select(DB::raw('SUM(amount)'));
                }])->where('customer_id', $customer->id)->pluck('id');
                $revenue = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');
                $pending_bill = Invoice::where(['customer_id' => $customer->id, 'payment_status' => 'Unpaid'])->count();
                $data = [
                    'total_appointment' => $tot_appointment->count(),
                    'revenue' => $revenue,
                    'pending_bill' => $pending_bill
                ];
                return view('customer.customer-profile-view', compact('user', 'role', 'customer', 'customer_info', 'medical_Info', 'data', 'appointments', 'prescriptions', 'invoices'));
            } else {
                return redirect('/')->with('error', 'Customer not found');
            }
        } elseif ($role == 'therapist') {
            $therapist = Sentinel::getUser();
            $therapist_id = $therapist->id;
            $role = $user->roles[0]->slug;
            $therapist_info = Therapist::where('user_id', '=', $therapist->id)->first();
            if ($therapist_info) {
                $appointments = Appointment::where(function ($re) use ($therapist_id) {
                    $re->orWhere('appointment_with', $therapist_id);
                    $re->orWhere('booked_by', $therapist_id);
                })->orderBy('id', 'DESC')->paginate($this->limit, '*', 'appointments');
                $prescriptions = Prescription::with('customer')->where('created_by', $therapist->id)->orderby('id', 'desc')->paginate($this->limit, '*', 'prescriptions');
                $invoices = Invoice::with('user')->where('invoices.created_by', '=', $therapist->id)->orderby('id', 'desc')->get();
                $receptionists_therapist_id = ReceptionListTherapist::where('therapist_id', $therapist_id)->pluck('reception_id');
                $invoices = Invoice::with('user')->where('therapist_id', $therapist_id)->paginate($this->limit, '*', 'invoices');
                $tot_appointment = Appointment::where(function ($re) use ($therapist_id) {
                    $re->orWhere('appointment_with', $therapist_id);
                    $re->orWhere('booked_by', $therapist_id);
                })->get();
                $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                    $re->select(DB::raw('SUM(amount)'));
                }])->where('therapist_id', $therapist_id)->pluck('id');
                $revenue = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');

                $pending_bill = Invoice::where(['therapist_id' => $therapist_id, 'payment_status' => 'Unpaid'])->count();

                $data = [
                    'total_appointment' => $tot_appointment->count(),
                    'revenue' => $revenue,
                    'pending_bill' => $pending_bill
                ];
                $availableDay = TherapistAvailableDay::where('therapist_id', $therapist->id)->first();
                $availableTime = TherapistAvailableTime::where('therapist_id', $therapist->id)->where('is_deleted', 0)->get();
                return view('therapist.therapist-profile-view', compact('user', 'role', 'therapist', 'therapist_info', 'data', 'appointments', 'availableTime', 'prescriptions', 'invoices', 'availableDay'));
            } else {
                return redirect('/')->with('error', 'Therapists details not found');
            }
        } elseif ($role == 'receptionist') {
            $receptionist = Sentinel::getUser();
            $user_id = $receptionist->id;
            $role = $user->roles[0]->slug;
            $receptionists_therapist_id = ReceptionListTherapist::where('reception_id', $user_id)->pluck('therapist_id');
            $tot_appointment = Appointment::where(function ($re) use ($user_id, $receptionists_therapist_id) {
                $re->whereIN('appointment_with', $receptionists_therapist_id);
                $re->orWhereIN('booked_by', $receptionists_therapist_id);
                $re->orWhere('booked_by', $user_id);
            })->get();

            $invoice = Invoice::withCount(['invoice_detail as total' => function ($re) {
                $re->select(DB::raw('SUM(amount)'));
            }])->where(function ($re) use ($user_id, $receptionists_therapist_id) {
                $re->orWhereIN('created_by', $receptionists_therapist_id);
                $re->orWhere('created_by', $user_id);
            })->pluck('id');
            $revenue = InvoiceDetail::whereIn('invoice_id', $invoice)->sum('amount');

            $pending_bill = Invoice::where(['payment_status' => 'Unpaid'])
                ->where(function ($re) use ($user_id, $receptionists_therapist_id) {
                    $re->whereIN('therapist_id', $receptionists_therapist_id);
                    $re->orWhere('created_by', $user_id);
                })->count();
            $data = [
                'total_appointment' => $tot_appointment->count(),
                'revenue' => $revenue,
                'pending_bill' => $pending_bill
            ];
            $appointments = Appointment::where(function ($re) use ($user_id, $receptionists_therapist_id) {
                $re->whereIN('appointment_with', $receptionists_therapist_id);
                $re->orWhereIN('booked_by', $receptionists_therapist_id);
                $re->orWhere('booked_by', $user_id);
            })->orderBy('id', 'DESC')->paginate($this->limit, '*', 'appointments');
            $invoices = Invoice::with('user')
                ->where(function ($re) use ($user_id, $receptionists_therapist_id) {
                    $re->whereIN('therapist_id', $receptionists_therapist_id);
                    $re->orWhere('created_by', $user_id);
                })->paginate($this->limit, '*', 'invoice');
            $therapist_role = Sentinel::findRoleBySlug('therapist');
            $therapists = $therapist_role->users()->with(['roles', 'therapist'])->where('is_deleted', 0)->get();
            $receptionist_therapist = ReceptionListTherapist::where('reception_id', $receptionist->id)->where('is_deleted', 0)->pluck('therapist_id');
            $therapist_user = User::whereIn('id', $receptionist_therapist)->get();
            return view('receptionist.receptionist-profile-view', compact('user', 'role', 'receptionist', 'data', 'appointments', 'invoices', 'therapist_user'));
        } else {
            return redirect('/')->with('error', 'role not found');
        }
    }
}
