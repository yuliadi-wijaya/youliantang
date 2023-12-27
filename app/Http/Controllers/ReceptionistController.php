<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Receptionist;
use Exception;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
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

        if ($user->hasAccess('receptionist.list')) {
            $user_id = $user->id;
            $receptionist_role = Sentinel::findRoleBySlug('receptionist');
            $receptionists = $receptionist_role->users()->with(['roles', 'receptionist'])->where('is_deleted', 0)->orderByDesc('id')->get();

            // Load Datatables
            if ($request->ajax()) {
                return Datatables::of($receptionists)
                    ->addIndexColumn()
                    ->addColumn('name', function($row){
                        $name = $row->first_name.' '.$row->last_name;
                        return $name;
                    })
                    ->addColumn('status', function($row) {
                        return Config::get('constants.status.' . $row->status, 'Undefined');
                    })
                    ->addColumn('option', function($row) use ($role){
                        if ($role != 'customer') {
                            if ($role == 'admin') {
                                $option = '
                                    <a href="receptionist/'.$row->id.'">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                ';
                            } elseif ($role == 'receptionist') {
                                $option = '
                                    <a href="receptionist-view/'.$row->id.'">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                ';
                            }

                            if ($role != 'receptionist') {
                                $option = '
                                    <a href="receptionist/'.$row->id.'/edit">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Profile">
                                            <i class="mdi mdi-lead-pencil"></i>
                                        </button>
                                    </a>
                                    <a href=" javascript:void(0) ">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Profile" data-id="'.$row->id.'" id="delete-receptionist">
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
            return view('receptionist.receptionists', compact('user', 'role', 'receptionists'));
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
        $role = $user->roles[0]->slug;

        if ($user->hasAccess('receptionist.create')) {
            $receptionist = null;
            $receptionist_info = null;
            return view('receptionist.receptionist-details', compact('user', 'role', 'receptionist', 'receptionist_info'));
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
            $validatedData = $request->validate(
                [
                    'first_name' => 'required|alpha',
                    'last_name' => 'alpha',
                    'ktp' => 'required|unique:receptionists|regex:/^[0-9]*$/|max:16',
                    'gender' => 'required',
                    'email' => 'required|email|unique:users|regex:/(.+)@(.+)\.(.+)/i|max:50',
                    'phone_number' => 'required',
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
                $validatedData['password'] = Config::get('app.DEFAULT_PASSWORD');
                $validatedData['created_by'] = $user->id;
                $validatedData['updated_by'] = $user->id;

                //Create a new user
                $receptionist = Sentinel::registerAndActivate($validatedData);

                //Attach the user to the role
                $role = Sentinel::findRoleBySlug('receptionist');
                $role->users()->attach($receptionist);

                $receptionist_details = new Receptionist();
                $receptionist_details->user_id = $receptionist->id;
                $receptionist_details->ktp = $request->ktp;
                $receptionist_details->gender = $request->gender;
                $receptionist_details->place_of_birth = $request->place_of_birth;
                $receptionist_details->birth_date = $request->birth_date;
                $receptionist_details->address = $request->address;
                $receptionist_details->rekening_number = $request->rekening_number;
                $receptionist_details->emergency_contact = $request->emergency_contact;
                $receptionist_details->emergency_name = $request->emergency_name;
                $receptionist_details->created_by = $user->id;
                $receptionist_details->updated_by = $user->id;
                $receptionist_details->status = $request->status;
                $receptionist_details->save();

                $app_name = AppSetting('title');
                $verify_mail = trim($request->email);
                Mail::send('emails.WelcomeEmail', ['user' => $receptionist, 'email' => $verify_mail], function ($message) use ($verify_mail, $app_name) {
                    $message->to($verify_mail);
                    $message->subject($app_name . ' ' . 'Welcome email from You Lian tAng - Reflexology & Massage Therapy');
                });
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

                $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$receptionist->id]);
                $pending_bill = Invoice::where(['payment_status' => 'Unpaid'])
                    ->where(function ($re) use ($user_id) {
                        $re->orWhere('created_by', $user_id);
                    })->count();
                $data = [
                    'revenue' => $revenue[0]->total,
                    'pending_bill' => $pending_bill
                ];

                $invoices = Invoice::with('user')
                    ->where(function ($re) use ($user_id) {
                        $re->orWhere('created_by', $user_id);
                    })->paginate($this->limit, '*', 'invoice');
                $therapist_role = Sentinel::findRoleBySlug('therapist');
                $therapists = $therapist_role->users()->with(['roles', 'therapist'])->where('is_deleted', 0)->get();
                $therapist_user = User::join('role_users', 'role_users.user_id', '=', 'users.id')
                    ->where('role_users.role_id', 2)->get();
                return view('receptionist.receptionist-profile', compact('user', 'role', 'receptionist', 'data', 'invoices', 'therapist_user'));
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
        $receptionist_id = $receptionist->id;
        $receptionist = $user::whereHas('roles',function($rq){
            $rq->where('slug','receptionist');
        })->where('id', $receptionist_id)->where('is_deleted', 0)->first();
        if($receptionist){
            if ($user->hasAccess('receptionist.update')) {
                $role = $user->roles[0]->slug;
                $receptionist_info = Receptionist::where('user_id', '=', $receptionist->id)->first();
                if ($receptionist_info) {
                    return view('receptionist.receptionist-details', compact('user', 'role', 'receptionist', 'receptionist_info'));
                } else {
                    return redirect('receptionist')->with('error', 'Receptionist details not found');
                }
            } else {
                return view('error.403');
            }
        }else{
            return redirect('receptionist')->with('error', 'Receptionists details not found');
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
                'last_name' => 'alpha',
                'ktp' => 'required|regex:/^[0-9]*$/|max:16',
                'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:50',
                'gender' => 'required',
                'phone_number' => 'required',
                'rekening_number' => 'required|numeric',
                'profile_photo' =>'image|mimes:jpg,png,jpeg,gif,svg|max:500',
                'status' => 'required'
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
                $receptionist->status = $validatedData['status'];
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
                        'status' => $validatedData['status'],
                    ]);

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
                $receptionist_info = Receptionist::where('user_id',$request->id)->first();
                if ($receptionist !=null) {
                    $receptionist->is_deleted = 1;
                    $receptionist->save();

                    $receptionist_info->is_deleted = 1;
                    $receptionist_info->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Receptionist deleted successfully.',
                        'data' => $receptionist,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Receptionist not found.',
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
                'message'=>'You have no permission to delete receptionist',
                'data'=>[],
            ],409);
        }
    }

    public function receptionist_view($id){
        $user = Sentinel::getUser();
            $user_id = $id;
            $receptionist = $user::join('role_users', 'role_users.user_id', '=', 'users.id')
                ->where('id', $id)->where('is_deleted', 0)
                ->where('role_users.role_id', 2)->first();
            if ($receptionist) {
                $role = $user->roles[0]->slug;
                $revenue = DB::select('SELECT SUM(amount) AS total FROM invoice_details, invoices WHERE invoices.id = invoice_details.invoice_id AND created_by = ?', [$receptionist->id]);
                $pending_bill = Invoice::where(['payment_status' => 'Unpaid'])
                    ->where(function ($re) use ($user_id) {
                        $re->orWhere('created_by', $user_id);
                    })->count();
                $data = [
                    'revenue' => $revenue[0]->total,
                    'pending_bill' => $pending_bill
                ];

                $invoices = Invoice::with('user')
                    ->where(function ($re) use ($user_id) {
                        $re->orWhere('created_by', $user_id);
                    })->paginate($this->limit, '*', 'invoice');
                $therapist_role = Sentinel::findRoleBySlug('therapist');
                $therapists = $therapist_role->users()->with(['roles', 'therapist'])->where('is_deleted', 0)->get();
                $therapist_user = User::join('role_users', 'role_users.user_id', '=', 'users.id')
                    ->where('role_users.role_id', 2)->get();

                return view('receptionist.receptionist-profile', compact('user', 'role', 'receptionist', 'data', 'invoices', 'therapist_user'));
            } else {
                return redirect('/')->with('error', 'receptionist not found');
            }
    }
}
