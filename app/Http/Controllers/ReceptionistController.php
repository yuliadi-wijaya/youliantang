<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Invoice;
use App\Receptionist;
use Exception;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;
use Yajra\DataTables\DataTables;

class ReceptionistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session()->has('page_limit')) {
                $this->limit = session()->get('page_limit');
            } else {
                $this->limit = Config::get('app.page_limit');
            }
            return $next($request);
        });
        $this->middleware('sentinel.auth');
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
        $receptionist_role = Sentinel::findRoleBySlug('receptionist');
        $receptionists = $receptionist_role->users()->with('roles')->where('is_deleted', 0)->orderByDesc('id')->get();
        if($role == 'therapist'){
            $receptionist_therapist = Receptionist::where('therapist_id',$user->id)->pluck('user_id');
            $receptionists = User::with('roles')->whereIn('id',$receptionist_therapist)->get();
        }

        // Load Datatables
        if ($request->ajax()) {
            return Datatables::of($receptionists)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $name = $row->first_name.' '.$row->last_name;
                    return $name;
                })
                ->addColumn('option', function($row) use ($role){
                    if ($role == 'admin') {
                        $option = '
                            <a href="receptionist/'.$row->id.'">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                            </a>
                            <a href="receptionist/'.$row->id.'/edit">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Profile">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </button>
                            </a>
                            <a href="javascript:void(0)">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Profile" data-id="'.$row->id.'" id="delete-receptionist">
                                    <i class="mdi mdi-trash-can"></i>
                                </button>
                            </a>';
                    } elseif ($role == 'therapist') {
                        $option = '
                            <a href="receptionist-view/'.$row->id.'">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                            </a>';
                    }
                    return $option;
                })->rawColumns(['option'])->make(true);
        }
        // End
        return view('receptionist.receptionists', compact('user', 'role', 'receptionists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('receptionist.create')) {
            $role = $user->roles[0]->slug;
            $receptionist = null;
            $therapist_role = Sentinel::findRoleBySlug('therapist');
            $therapists = $therapist_role->users()->with(['roles', 'therapist'])->where('is_deleted', 0)->get();
            return view('receptionist.receptionist-details', compact('user', 'role', 'receptionist', 'therapists'));
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
        if ($user->hasAccess('receptionist.create')) {
            $therapist_id =  $request->therapist;
            $validatedData = $request->validate([
                'first_name' => 'required|alpha',
                'last_name' => 'required|alpha',
                'phone_number' => 'required',
                'email' => 'required|email|unique:users|regex:/(.+)@(.+)\.(.+)/i|max:50',
                'therapist' => 'required',
                'profile_photo' =>'image|mimes:jpg,png,jpeg,gif,svg|max:500'
            ]);
            if ($request->profile_photo != null) {
                $request->validate([
                    'profile_photo' => 'image'
                ]);
                $file = $request->file('profile_photo');
                $extention = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $extention;
                $file->move(public_path('storage/images/users'), $fileName);
                $validatedData['profile_photo'] = $fileName;
            }
            try {
                $user = Sentinel::getUser();
                // Set Default Password for Therapist
                $validatedData['password'] = Config::get('app.DEFAULT_PASSWORD');
                $validatedData['created_by'] = $user->id;
                $validatedData['updated_by'] = $user->id;
                //Create a new user
                $receptionist = Sentinel::registerAndActivate($validatedData);
                //Attach the user to the role
                $role = Sentinel::findRoleBySlug('receptionist');
                $role->users()
                    ->attach($receptionist);
                foreach ($therapist_id as $item) {
                    $receptionistTherapist  = new Receptionist();
                    $receptionistTherapist->therapist_id = $item;
                    $receptionistTherapist->user_id = $receptionist->id;
                    $receptionistTherapist->save();
                }
                return redirect('receptionist')->with('success', 'Receptionist created successfully!');
            } catch (Exception $e) {
                return redirect('receptionist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function show(User $receptionist)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('receptionist.view')) {
            $user_id = $receptionist->id;
            $receptionist = $user::whereHas('roles',function($rq){
                $rq->where('slug','receptionist');
            })->where('id', $receptionist->id)->where('is_deleted', 0)->first();
            if ($receptionist) {
                $role = $user->roles[0]->slug;
                $receptionists_therapist_id = Receptionist::where('user_id', $user_id)->pluck('therapist_id');
                $tot_appointment = Appointment::where(function ($re) use ($user_id, $receptionists_therapist_id) {
                    $re->whereIN('appointment_with', $receptionists_therapist_id);
                    $re->orWhereIN('booked_by', $receptionists_therapist_id);
                    $re->orWhere('booked_by', $user_id);
                })->get();

                $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$receptionist->id]);
                $pending_bill = Invoice::where(['payment_status' => 'Unpaid'])
                    ->where(function ($re) use ($user_id, $receptionists_therapist_id) {
                        $re->whereIN('therapist_id', $receptionists_therapist_id);
                        $re->orWhere('created_by', $user_id);
                    })->count();
                $data = [
                    'total_appointment' => $tot_appointment->count(),
                    'revenue' => $revenue[0]->total,
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
                $receptionist_therapist = Receptionist::where('user_id', $receptionist->id)->where('is_deleted', 0)->pluck('therapist_id');
                $therapist_user = User::whereIn('id', $receptionist_therapist)->get();
                return view('receptionist.receptionist-profile', compact('user', 'role', 'receptionist', 'data', 'appointments', 'invoices', 'therapist_user'));
            } else {
                return redirect('/')->with('error', 'Receptionist not found');
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function edit(User $receptionist)
    {
        $user = Sentinel::getUser();
        $receptionist = $user::whereHas('roles',function($rq){
            $rq->where('slug','receptionist');
        })->where('id', $receptionist->id)->where('is_deleted', 0)->first();
        if($receptionist){

            if ($user->hasAccess('receptionist.update')) {
                $role = $user->roles[0]->slug;
                $therapist_role = Sentinel::findRoleBySlug('therapist');
                // return $therapist_role;
                $therapists = $therapist_role->users()->with(['roles', 'therapist'])->where('is_deleted', 0)->get();
                $receptionist_therapist = Receptionist::where('user_id', $receptionist->id)->where('is_deleted', 0)->pluck('therapist_id');
                $therapist_user = User::whereIn('id', $receptionist_therapist)->pluck('id')->toArray();
                return view('receptionist.receptionist-edit', compact('user', 'role', 'receptionist', 'therapists', 'therapist_user'));
            } else {
                return view('error.403');
            }
        }
        else{
            return redirect('/')->with('error', 'Receptionist not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $receptionist)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('receptionist.update')) {
            $validatedData = $request->validate([
                'first_name' => 'required|alpha',
                'last_name' => 'required|alpha',
                'phone_number' => 'required',
                'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                'therapist' => 'required',
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
                    $extension = $file->getClientOriginalExtension();
                    $imageName = time() . '.' . $extension;
                    $file->move(public_path('storage/images/users'), $imageName);
                    $receptionist->profile_photo = $imageName;
                }
                $receptionist->first_name = $validatedData['first_name'];
                $receptionist->last_name = $validatedData['last_name'];
                $receptionist->phone_number = $validatedData['phone_number'];
                $receptionist->email = $validatedData['email'];
                $receptionist->updated_by = $user->id;
                $old_therapist = Receptionist::where('user_id', $receptionist->id)->pluck('therapist_id')->toArray();
                $new_therapist = $request->therapist;
                $numArray = array_map('intval', $new_therapist);
                // remove old Therapist
                $differenceArray1 = array_diff($old_therapist, $numArray);
                // add New Therapist
                $differenceArray2 = array_diff($numArray, $old_therapist);
                $receptionistTherapist = Receptionist::where('user_id', $receptionist->id)->pluck('therapist_id');
                if ($differenceArray1 && $differenceArray2) {
                    // Add and remove both Therapist
                    if ($differenceArray1) {
                        $receptionistTherapist = Receptionist::whereIn('therapist_id', $differenceArray1)->delete();
                    }
                    if ($differenceArray2) {
                        foreach ($differenceArray2 as $item) {
                            $receptionistTherapist = new Receptionist();
                            $receptionistTherapist->therapist_id = $item;
                            $receptionistTherapist->user_id = $receptionist->id;
                            $receptionistTherapist->save();
                        }
                    }
                } elseif ($differenceArray1) {
                    // only remove Therapist
                    $receptionistTherapist = Receptionist::whereIn('therapist_id', $differenceArray1)->delete();
                } elseif ($differenceArray2) {
                    // only add therapist
                    foreach ($differenceArray2 as $item) {
                        $receptionistTherapist = new Receptionist();
                        $receptionistTherapist->therapist_id = $item;
                        $receptionistTherapist->user_id = $receptionist->id;
                        $receptionistTherapist->save();
                    }
                }
                $receptionist->save();
                if ($role == 'receptionist') {
                    return redirect('/')->with('success', 'Profile updated successfully!');
                } else {
                    return redirect('receptionist')->with('success', 'Receptionist Profile updated successfully!');
                }
            } catch (Exception $e) {
                return redirect('receptionist')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $receptionist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('receptionist.delete')) {
        try {
            $receptionist = User::where('id',$request->id)->first();
                if ($receptionist != Null) {
                    $receptionist->status = 1;
                    $receptionist->save();
                    return response()->json([
                        'isSuccess' => true,
                        'message' => 'Receptionist deleted successfully.',
                        'data' => $receptionist,
                    ], 200);
                } else {
                    return response()->json([
                        'isSuccess' => false,
                        'message' => 'Receptionist not found.',
                        'data' => [],
                    ], 409);
                }
            } catch (Exception $e) {
                return response()->json([
                    'isSuccess' =>false,
                    'message' =>'Something went wrong!!!' .$e->getMessage(),
                    'data' => [],
                ],409);
            }
        } else {
            return response()->json([
                'isSuccess' =>false,
                'message' =>'You have no permission to delete Receptionist',
                'data'=> [],
            ],409);
        }
    }
    public function receptionist_view($id){
        $user = Sentinel::getUser();
            $user_id = $id;
            $receptionist_therapist = Receptionist::where('therapist_id',$user->id)->pluck('user_id');
            $receptionist = $user::where('id', $id)->where('is_deleted', 0)->WhereIn('id',$receptionist_therapist)->first();
            if ($receptionist) {
                $role = $user->roles[0]->slug;
                $receptionists_therapist_id = Receptionist::where('user_id', $user_id)->pluck('therapist_id');
                $tot_appointment = Appointment::where(function ($re) use ($user_id, $receptionists_therapist_id) {
                    $re->whereIN('appointment_with', $receptionists_therapist_id);
                    $re->orWhereIN('booked_by', $receptionists_therapist_id);
                    $re->orWhere('booked_by', $user_id);
                })->get();
                $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$receptionist->id]);
                $pending_bill = Invoice::where(['payment_status' => 'Unpaid'])
                    ->where(function ($re) use ($user_id, $receptionists_therapist_id) {
                        $re->whereIN('therapist_id', $receptionists_therapist_id);
                        $re->orWhere('created_by', $user_id);
                    })->count();
                $data = [
                    'total_appointment' => $tot_appointment->count(),
                    'revenue' => $revenue[0]->total,
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
                $receptionist_therapist = Receptionist::where('user_id', $receptionist->id)->where('is_deleted', 0)->pluck('therapist_id');
                $therapist_user = User::whereIn('id', $receptionist_therapist)->get();
                return view('receptionist.receptionist-profile', compact('user', 'role', 'receptionist', 'data', 'appointments', 'invoices', 'therapist_user'));
            } else {
                return redirect('/')->with('error', 'receptionist not found');
            }
    }
}
