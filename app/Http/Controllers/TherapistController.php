<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Therapist;
use App\TherapistAvailableDay;
use App\TherapistAvailableSlot;
use App\TherapistAvailableTime;
use App\Invoice;
use App\Prescription;
use App\Receptionist;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class TherapistController extends Controller
{
    protected $therapist_details;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->therapist_details = new Therapist();
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
        if ($user->hasAccess('therapist.list')) {
            $role = $user->roles[0]->slug;
            $user = Sentinel::getUser();
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $therapist_role = Sentinel::findRoleBySlug('therapist');
            if ($role == 'receptionist') {
                $prescriptions_therapist = Receptionist::where('user_id', $user_id)->pluck('therapist_id');
                //$therapists = User::whereIN('id', $prescriptions_therapist)->where('is_deleted', 0)->get();
                $therapists = $therapist_role->users()->with(['roles', 'therapist'])->whereIN('id', $prescriptions_therapist)->where('is_deleted', 0)->get();
            } else {
                $therapists = $therapist_role->users()->with(['roles', 'therapist'])->where('is_deleted', 0)->orderByDesc('id')->get();
            }

            foreach ($therapists as $key => $value)
            {
                $pending_appointment = Appointment::where('appointment_with', $value->id)->where('status', '0')->count();
                $therapists[$key]['pending_appointment'] = $pending_appointment;

                $completed_appointment = Appointment::where('appointment_with', $value->id)->where('status', '1')->count();
                $therapists[$key]['completed_appointment'] = $completed_appointment;
            }

            // Load Datatables
            if ($request->ajax()) {
                return Datatables::of($therapists)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        $name = $row->first_name.' '.$row->last_name;
                        return $name;
                    })
                    ->addColumn('pending_appointment', function($row) use ($role){
                        if ($role != 'customer') {
                            if ($row->pending_appointment != 0) {
                               $pending_appointment = $row->pending_appointment;
                            } else {
                                $pending_appointment = $row->pending_appointment;
                            }

                        } else {
                           $pending_appointment = '';
                        }
                        return $pending_appointment;
                    })
                    ->addColumn('completed_appointment', function($row) use ($role){
                        if ($role != 'customer') {
                            if ($row->completed_appointment != 0) {
                               $completed_appointment = $row->completed_appointment;
                            } else {
                                $completed_appointment = $row->completed_appointment;
                            }

                        } else {
                           $completed_appointment = '';
                        }
                        return $completed_appointment;
                    })
                    ->addColumn('status', function($row) {
                        return Config::get('constants.status.' . $row->status, 'Undefined');
                    })
                    ->addColumn('option', function($row) use ($role){
                        if ($role != 'customer') {
                            if ($role == 'admin') {
                                $option = '
                                    <a href="therapist/'.$row->id.'">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                ';
                            } elseif ($role == 'receptionist') {
                                $option = '
                                    <a href="therapist-view/'.$row->id.'">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                ';
                            }

                            if ($role != 'receptionist') {
                                $option = '
                                    <a href="therapist/'.$row->id.'/edit">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Profile">
                                            <i class="mdi mdi-lead-pencil"></i>
                                        </button>
                                    </a>
                                    <a href=" javascript:void(0) ">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Profile" data-id="'.$row->id.'" id="delete-therapist">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </a>
                                ';
                            }
                        } else {
                           $option = '';
                        }
                        return $option;
                    })->rawColumns(['option'])->make(true);
            }
            // End
            return view('therapist.therapists', compact('user', 'role', 'therapists'));
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
        if ($user->hasAccess('therapist.create')) {
            $role = $user->roles[0]->slug;
            $therapist = null;
            $therapist_info = null;
            return view('therapist.therapist-details', compact('user', 'role', 'therapist', 'therapist_info'));
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
        if ($user->hasAccess('therapist.create')) {
            $slot_time = $request->slot_time;
            $validatedData = $request->validate(
                [
                    'first_name' => 'required|alpha',
                    'last_name' => 'alpha',
                    'ktp' => 'required|unique:therapists|regex:/^[0-9]*$/|max:16',
                    'gender' => 'required',
                    'email' => 'required|email|unique:users|regex:/(.+)@(.+)\.(.+)/i|max:50',
                    'phone_number' => 'required',
                    'rekening_number' => 'required|numeric',
                    'slot_time' => 'required',
                    'mon' => 'required_without_all:tue,wen,thu,fri,sat,sun',
                    'tue' => 'required_without_all:mon,wen,thu,fri,sat,sun',
                    'wen' => 'required_without_all:mon,tue,thu,fri,sat,sun',
                    'thu' => 'required_without_all:mon,wen,tue,fri,sat,sun',
                    'fri' => 'required_without_all:wen,tue,mon,thu,sat,sun',
                    'sat' => 'required_without_all:wen,tue,mon,thu,fri,sun',
                    'sun' => 'required_without_all:wen,tue,mon,thu,fri,sat',
                    'TimeSlot.*.from' => 'required',
                    'TimeSlot.*.to' => 'required',
                    'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                    'status' => 'required'
                ],
            );

            if ($request->profile_photo != null) {
                $request->validate([
                    'profile_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:500'
                ]);
                $file = $request->file('profile_photo');
                $extention = $file->getClientOriginalExtension();
                $validatedData['profile_photo'] = time() . '.' . $extention;
                $file->move(public_path('storage/images/users'), $validatedData['profile_photo']);
                $validatedData['profile_photo']= $validatedData['profile_photo'];
            }
            try {
                $user = Sentinel::getUser();
                if ($request->TimeSlot[0]['from'] == null && $request->TimeSlot[0]['to'] == null) {
                    return redirect()->back()->with('error', 'Add available time');
                } else {
                    $validatedData['password'] = Config::get('app.DEFAULT_PASSWORD');
                    $validatedData['created_by'] = $user->id;
                    $validatedData['updated_by'] = $user->id;
                    //Create a new user
                    $therapist = Sentinel::registerAndActivate($validatedData);
                    //Attach the user to the role
                    $role = Sentinel::findRoleBySlug('therapist');
                    $role->users()->attach($therapist);
                    $therapist_details = new Therapist();
                    $therapist_details->user_id = $therapist->id;
                    $therapist_details->ktp = $request->ktp;
                    $therapist_details->gender = $request->gender;
                    $therapist_details->place_of_birth = $request->place_of_birth;
                    $therapist_details->birth_date = $request->birth_date;
                    $therapist_details->address = $request->address;
                    $therapist_details->rekening_number = $request->rekening_number;
                    $therapist_details->emergency_contact = $request->emergency_contact;
                    $therapist_details->emergency_name = $request->emergency_name;
                    $therapist_details->slot_time = $request->slot_time;
                    $therapist_details->created_by = $user->id;
                    $therapist_details->updated_by = $user->id;
                    $therapist_details->status = $request->status;
                    $therapist_details->save();
                    // Therapist Available day record add
                    $availableDay = new TherapistAvailableDay();
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
                    foreach ($request->TimeSlot as $key => $item) {
                        $availableTime = new TherapistAvailableTime();
                        $availableTime->therapist_id = $therapist->id;
                        $availableTime->from = $item['from'];
                        $availableTime->to = $item['to'];
                        $availableTime->save();
                        $start_datetime = Carbon::parse($item['from'])->format('H:i:s');
                        $end_datetime = Carbon::parse($item['to'])->format('H:i:s');
                        $start_datetime_carbon = Carbon::parse($item['from']);
                        $end_datetime_carbon = Carbon::parse($item['to']);
                        $totalDuration = $end_datetime_carbon->diffInMinutes($start_datetime_carbon);
                        $totalSlots = $totalDuration / $slot_time;
                        for ($a = 0; $a <= $totalSlots; $a++) {
                            $slot_time_start_min = $a * $slot_time;
                            $slot_time_end_min = $slot_time_start_min + $slot_time;
                            $slot_time_start = Carbon::parse($start_datetime)->addMinute($slot_time_start_min)->format('H:i:s');
                            $slot_time_end = Carbon::parse($start_datetime)->addMinute($slot_time_end_min)->format('H:i:s');
                            if ($slot_time_end <= $end_datetime) {
                                // add time slot here
                                $time = $slot_time_start . '<=' . $slot_time_end . '<br>';
                                $availableSlot = new TherapistAvailableSlot();
                                $availableSlot->therapist_id = $therapist->id;
                                $availableSlot->therapist_available_time_id = $availableTime->id;
                                $availableSlot->from = $slot_time_start;
                                $availableSlot->to = $slot_time_end;
                                $availableSlot->save();
                            }
                        }
                    }
                    $app_name = AppSetting('title');
                    $verify_mail = trim($request->email);
                    Mail::send('emails.WelcomeEmail', ['user' => $therapist, 'email' => $verify_mail], function ($message) use ($verify_mail, $app_name) {
                        $message->to($verify_mail);
                        $message->subject($app_name . ' ' . 'Welcome email from You Lian tAng - Reflexology & Massage Therapy');
                    });
                    return redirect('therapist')->with('success', 'Therapist created successfully!');
                }
            } catch (Exception $e) {
                return redirect('therapist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $therapist
     * @return \Illuminate\Http\Response
     */
    public function show(User $therapist)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('therapist.view')) {
            $therapist_id = $therapist->id;
            $role = $user->roles[0]->slug;
            $therapist = $user::whereHas('roles',function($rq){
                $rq->where('slug','therapist');
            })->where('id', $therapist_id)->where('is_deleted', 0)->first();
            if ($therapist) {
                $therapist_info = Therapist::where('user_id', '=', $therapist->id)->orwhere('is_deleted', 0)->first();
                if ($therapist_info) {
                    $appointments = Appointment::where(function ($re) use ($therapist_id) {
                        $re->orWhere('appointment_with', $therapist_id);
                        $re->orWhere('booked_by', $therapist_id);
                    })->orderBy('id', 'DESC')->paginate($this->limit, '*', 'appointment');
                    $prescriptions = Prescription::with('customer')->where('created_by', $therapist->id)->orderby('id', 'desc')->paginate($this->limit, '*', 'prescriptions');
                    $invoices = Invoice::with('user')->where('invoices.created_by', '=', $therapist->id)->orderby('id', 'desc')->get();
                    $receptionists_id = Receptionist::where('therapist_id', $therapist_id)->pluck('user_id');
                    $invoices = Invoice::with('user')->where('therapist_id', $therapist_id)->paginate($this->limit, '*', 'invoice');

                    $tot_appointment = Appointment::where(function ($re) use ($therapist_id) {
                        $re->orWhere('appointment_with', $therapist_id);
                        $re->orWhere('booked_by', $therapist_id);
                    })->get();
                    $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$therapist->id]);
                    $pending_bill = DB::select("SELECT COUNT(*) AS total FROM invoices WHERE invoices.payment_status = 'Unpaid' AND created_by = ?", [$therapist->id]);
                    $data = [
                        'total_appointment' => $tot_appointment->count(),
                        'revenue' => $revenue[0]->total,
                        'pending_bill' => $pending_bill[0]->total
                    ];
                    $availableDay = TherapistAvailableDay::where('therapist_id', $therapist->id)->first();
                    $availableTime = TherapistAvailableTime::where('therapist_id', $therapist->id)->where('is_deleted', 0)->get();
                    return view('therapist.therapist-profile', compact('user', 'role', 'therapist', 'therapist_info', 'data', 'appointments', 'availableTime', 'prescriptions', 'invoices', 'availableDay'));
                } else {
                    return redirect('/')->with('error', 'Therapists details not found');
                }
            } else {
                return redirect('/')->with('error', 'Therapists details not found');
            }
        } else {
            return view('error.403');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $therapist
     * @return \Illuminate\Http\Response
     */
    public function edit(User $therapist)
    {
        $user = Sentinel::getUser();
        $therapist_id = $therapist->id;
        $therapist = $user::whereHas('roles',function($rq){
            $rq->where('slug','therapist');
        })->where('id', $therapist_id)->where('is_deleted', 0)->first();
        if($therapist){
            if ($user->hasAccess('therapist.update')) {
                $role = $user->roles[0]->slug;
                $therapist_info = Therapist::where('user_id', '=', $therapist->id)->first();
                if ($therapist_info) {
                    $availableDay = TherapistAvailableDay::where('therapist_id', $therapist->id)->first();
                    $availableTime = TherapistAvailableTime::where('therapist_id', $therapist->id)->get();
                    return view('therapist.therapist-edit', compact('user', 'role', 'therapist', 'therapist_info', 'availableDay', 'availableTime'));
                } else {
                    return redirect('/')->with('error', 'Therapist details not found');
                }
            } else {
                return view('error.403');
            }
        }else{
            return redirect('/')->with('error', 'Therapists details not found');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $therapist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $therapist)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('therapist.update')) {
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
                'status' => 'required'
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
                $therapist->email = $validatedData['email'];
                $therapist->phone_number = $validatedData['phone_number'];
                $therapist->status = $validatedData['status'];
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
                        'status' => $validatedData['status'],
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
                    return redirect('therapist')->with('success', 'Therapist Profile updated successfully!');
                }
            } catch (Exception $e) {
                return redirect('therapist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $therapist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('therapist.delete')) {
            try {
                $therapist = User::where('id',$request->id)->first();
                $therapist_info = Therapist::where('user_id',$request->id)->first();
                if ($therapist !=null) {
                    $therapist->is_deleted = 1;
                    $therapist->save();

                    $therapist_info->is_deleted = 1;
                    $therapist_info->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Therapist deleted successfully.',
                        'data' => $therapist,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Therapist not found.',
                        'data' => [],
                    ], 409);
                }
            } catch (Exception $e) {
                return response()->json([
                    'success' =>false,
                    'message' => 'Something went wrong!!!'.$e->getMessage(),
                    'data' =>[],
                ],409);
            }
        } else {
            return response()->json([
                'success' =>false,
                'message'=>'You have no permission to delete therapist',
                'data'=>[],
            ],409);
        }
    }

    public function time_edit($id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('therapist.time_edit')) {
            $role = $user->roles[0]->slug;
            $therapist = User::find($id);
            $therapist_info = Therapist::where('user_id', '=', $id)->first();
            if ($therapist_info) {
                $availableDay = TherapistAvailableDay::where('therapist_id', $id)->first();
                $availableTime = TherapistAvailableTime::where('therapist_id', $id)->get();
                return view('therapist.therapist_time_edit', compact('user', 'role', 'therapist', 'therapist_info', 'availableDay', 'availableTime'));
            } else {
                return redirect('/')->with('error', 'Therapist details not found');
            }
        } else {
            return view('error.403');
        }
    }
    public function time_update(Request $request, $id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('therapist.time_edit')) {
            $validatedData = $request->validate([
                'slot_time' => 'required',
                'TimeSlot.*.from' => 'required',
                'TimeSlot.*.to' => 'required',
            ]);
            $role = $user->roles[0]->slug;
            $slot_time = $request->slot_time;
            $therapist = Therapist::where('user_id', $id)->first();
            $therapist->slot_time = $slot_time;
            $therapist->save();
            $availableTime = TherapistAvailableTime::where('therapist_id', $id)->update(['is_deleted' => 1]);
            $availableSlot = TherapistAvailableSlot::where('therapist_id', $id)->update(['is_deleted' => 1]);
            $validatedData = $request->validate([
                'slot_time' => 'required',
            ]);
            foreach ($request->TimeSlot as $key => $item) {
                $availableTime = new TherapistAvailableTime();
                $availableTime->therapist_id = $id;
                $availableTime->from = $item['from'];
                $availableTime->to = $item['to'];
                $availableTime->save();
                $start_datetime = Carbon::parse($item['from'])->format('H:i:s');
                $end_datetime = Carbon::parse($item['to'])->format('H:i:s');
                $start_datetime_carbon = Carbon::parse($item['from']);
                $end_datetime_carbon = Carbon::parse($item['to']);
                $totalDuration = $end_datetime_carbon->diffInMinutes($start_datetime_carbon);
                $totalSlots = $totalDuration / $slot_time;
                for ($a = 0; $a <= $totalSlots; $a++) {
                    $slot_time_start_min = $a * $slot_time;
                    $slot_time_end_min = $slot_time_start_min + $slot_time;
                    $slot_time_start = Carbon::parse($start_datetime)->addMinute($slot_time_start_min)->format('H:i:s');
                    $slot_time_end = Carbon::parse($start_datetime)->addMinute($slot_time_end_min)->format('H:i:s');
                    if ($slot_time_end <= $end_datetime) {
                        // add time slot here
                        $time = $slot_time_start . '<=' . $slot_time_end . '<br>';
                        $availableSlot = new TherapistAvailableSlot();
                        $availableSlot->therapist_id = $id;
                        $availableSlot->therapist_available_time_id = $availableTime->id;
                        $availableSlot->from = $slot_time_start;
                        $availableSlot->to = $slot_time_end;
                        $availableSlot->save();
                    }
                }
            }
            if ($role == 'therapist') {
                return redirect('/')->with('success', 'Profile updated successfully!');
            } else {
                return redirect('therapist')->with('success', 'Therapist Profile updated successfully!');
            }
        } else {
            return view('error.403');
        }
    }
    public function time_update_ajax($id)
    {
        $availableTime = TherapistAvailableTime::where('therapist_id', $id)->where('is_deleted', 0)->get();
        if ($availableTime) {
            return response()->json([
                'isSuccess' => true,
                'Message' => "Therapist Available Time Get Successfully",
                'data' => $availableTime
            ]);
        }
        return response()->json([
            'isSuccess' => false,
            'Message' => "Therapist availableTime not found",
        ]);
    }
    public function therapist_view($id){
        {
            $user = Sentinel::getUser();
            if ($user->hasAccess('therapist.view')) {
                $therapist_id = $id;
                $role = $user->roles[0]->slug;
                $receptionist = Receptionist::where('user_id',$user->id)->pluck('therapist_id');
                $therapist = $user::where('id', $therapist_id)->whereIn('id',$receptionist)->where('is_deleted', 0)->first();
                if ($therapist) {
                    $therapist_info = Therapist::where('user_id', '=', $therapist->id)->orwhere('is_deleted', 0)->first();
                    if ($therapist_info) {
                        $appointments = Appointment::where(function ($re) use ($therapist_id) {
                            $re->orWhere('appointment_with', $therapist_id);
                            $re->orWhere('booked_by', $therapist_id);
                        })->orderBy('id', 'DESC')->paginate($this->limit, '*', 'appointment');
                        $prescriptions = Prescription::with('customer')->where('created_by', $therapist->id)->orderby('id', 'desc')->paginate($this->limit, '*', 'prescriptions');
                        $invoices = Invoice::with('user')->where('invoices.created_by', '=', $therapist->id)->orderby('id', 'desc')->get();
                        $receptionists_id = Receptionist::where('therapist_id', $therapist_id)->pluck('user_id');
                        $invoices = Invoice::with('user')->where('therapist_id', $therapist_id)->paginate($this->limit, '*', 'invoice');

                        $tot_appointment = Appointment::where(function ($re) use ($therapist_id) {
                            $re->orWhere('appointment_with', $therapist_id);
                            $re->orWhere('booked_by', $therapist_id);
                        })->get();
                        $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$therapist->id]);
                        $pending_bill = DB::select("SELECT COUNT(*) AS total FROM invoices WHERE invoices.payment_status = 'Unpaid' AND created_by = ?", [$therapist->id]);
                        $data = [
                            'total_appointment' => $tot_appointment->count(),
                            'revenue' => $revenue[0]->total,
                            'pending_bill' => $pending_bill[0]->total
                        ];
                        $availableDay = TherapistAvailableDay::where('therapist_id', $therapist->id)->first();
                        $availableTime = TherapistAvailableTime::where('therapist_id', $therapist->id)->where('is_deleted', 0)->get();
                        return view('therapist.therapist-profile', compact('user', 'role', 'therapist', 'therapist_info', 'data', 'appointments', 'availableTime', 'prescriptions', 'invoices', 'availableDay'));
                    } else {
                        return redirect('/')->with('error', 'Therapists details not found');
                    }
                } else {
                    return redirect('/')->with('error', 'Therapists details not found');
                }
            } else {
                return view('error.403');
            }
        }
    }
}
