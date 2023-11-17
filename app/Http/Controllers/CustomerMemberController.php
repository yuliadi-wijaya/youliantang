<?php

namespace App\Http\Controllers;

use App\CustomerMember;
use App\Customer;
use App\Membership;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;

class CustomerMemberController extends Controller
{
    public function __construct() {
        $this->middleware('sentinel.auth');
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
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('customermember.list')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $customermembers = CustomerMember::where('customer_members.is_deleted', 0)
            ->join('users', 'users.id', '=', 'customer_members.customer_id')
            ->join('memberships', 'memberships.id', '=', 'customer_members.membership_id')
            ->select('customer_members.id', 'users.first_name', 'users.last_name', 'users.phone_number', 'memberships.name as membership_plan', 'customer_members.expired_date', 'customer_members.status')
            ->orderBy('customer_members.created_at', 'DESC')
            ->get();

        // Load Datatables
        if ($request->ajax()) {
            return Datatables::of($customermembers)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    $name = $row->first_name.' '.$row->last_name;
                    return $name;
                })
                ->addColumn('phone_number', function($row) {
                    return $row->phone_number;
                })
                ->addColumn('membership_plan', function($row) {
                    return $row->membership_plan;
                })
                ->addColumn('expired_date', function($row) {
                    return date('d-m-Y', strtotime($row->expired_date));
                })
                ->addColumn('status', function($row) {
                    return Config::get('constants.status.' . $row->status, 'Undefined');
                })
                ->addColumn('option', function($row) use ($role) {
                    if ($role == 'admin') {
                        $option = '
                            <a href="customermember/'.$row->id.'/edit">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update CustomerMember">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </button>
                            </a>
                            <a href="javascript:void(0)">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate CustomerMember" data-id="'.$row->id.'" id="delete-customermember">
                                    <i class="mdi mdi-trash-can"></i>
                                </button>
                            </a>';
                    }
                    return $option;
                })->rawColumns(['option'])->make(true);
        }
        // End

        return view('customermember.customermembers', compact('user', 'role', 'customermembers'));
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
        if (!$user->hasAccess('customermember.create')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Default data null
        $customermember = null;
        $customers = Customer::select('users.id', 'users.first_name', 'users.last_name')
            ->join('users', 'users.id', '=', 'customers.user_id')
            ->where('users.status', 1)
            ->where('users.is_deleted', 0)
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('customer_members')
                    ->whereRaw('customer_members.customer_id = users.id');
            })
            ->orderBy('users.first_name', 'asc')
            ->get();
        $memberships = Membership::where('is_deleted', 0)
            ->where('status', 1)
            ->get();

        return view('customermember.customermember-details', compact('user', 'role', 'customermember', 'customers', 'memberships'));
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
        if (!$user->hasAccess('customermember.create')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'customer_id' => 'required',
            'membership_id' => 'required',
            'expired_date' => 'required',
            'status' => 'required|numeric'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, new CustomerMember());
            $obj->created_by = $user->id;
            $obj->save();

            return redirect('customermember')->with('success', 'Customer member created successfully!');
        } catch (Exception $e) {
            return redirect('customermember')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerMember  $customermember
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerMember $customermember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerMember  $customermember
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerMember $customermember)
    {
        // Get user session data
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;

        $customer_id = $customermember->customer_id;

        // Get available data only
        $obj = CustomerMember::where('id', $customermember->id)->where('is_deleted', 0)->first();
        $customers = Customer::select('users.id', 'users.first_name', 'users.last_name')
            ->join('users', 'users.id', '=', 'customers.user_id')
            ->where('users.status', 1)
            ->where('users.is_deleted', 0)
            ->whereNotExists(function ($query) use ($customer_id) {
                $query->select(\DB::raw(1))
                    ->from('customer_members')
                    ->whereRaw('customer_members.customer_id = users.id')
                    ->where('customer_members.customer_id', '!=', $customer_id);
            })
            ->orderBy('users.first_name', 'asc')
            ->get();
        $memberships = Membership::where('is_deleted', 0)
            ->where('status', 1)
            ->get();

        // Check user access and available data
        if (!$user->hasAccess('customermember.update') || $obj == NULL) {
            return view('error.403');
        }

        return view('customermember.customermember-details', compact('user', 'role', 'customermember', 'customers', 'memberships'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerMember  $customermember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerMember $customermember)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('customermember.update')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'customer_id' => 'required',
            'membership_id' => 'required',
            'expired_date' => 'required',
            'status' => 'required|numeric'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, $customermember);
            $obj->updated_by = $user->id;
            $obj->save();

            return redirect('customermember')->with('success', 'CustomerMember updated successfully!');
        } catch (Exception $e) {
            return redirect('customermember')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerMember  $customermember
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerMember $customermember)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get available data only
        $obj = CustomerMember::where('id', $customermember->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('customermember.delete') || $obj == NULL) {
            return response()->json([
                'success' =>false,
                'message' =>'You have no permission to delete customermember.',
                'data'=> [],
            ],409);
        }

        try {
            if ($obj != NULL) {
                // Set available data to false
                $obj->is_deleted = 1;
                $obj->save();

                return response()->json([
                    'success' => true,
                    'message' => 'CustomerMember deleted successfully.',
                    'data' => $obj,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'CustomerMember not found.',
                    'data' => [],
                ], 409);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!!! ' . $e->getMessage(),
                'data' => [],
            ], 409);
        }
    }

    /**
     * Mapping request to object.
     *
     * @param  \Illuminate\Http\Request
     * @return \App\CustomerMember $customermember
     */
    private function toObject(Request $request, CustomerMember $customermember) {
        $customermember->customer_id = $request->input('customer_id');
        $customermember->membership_id = $request->input('membership_id');
        $customermember->expired_date = $request->input('expired_date');
        $customermember->status = $request->input('status');

        return $customermember;
    }
}
