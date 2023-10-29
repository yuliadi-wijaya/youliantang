<?php

namespace App\Http\Controllers;

use App\Membership;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;

class MembershipController extends Controller
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
        if (!$user->hasAccess('membership.list')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $memberships = Membership::where('is_deleted', 0)->orderByDesc('id')->get();

        // Load Datatables
        if ($request->ajax()) {
            return Datatables::of($memberships)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return $row->name;
                })
                ->addColumn('discount', function($row) {
                    if ($row->discount_type == 0) {
                        return "Rp " . number_format($row->discount_value);
                    } else if ($row->discount_type == 1) {
                        return $row->discount_value . "%";
                    }
                })
                ->addColumn('total_active_period', function($row) {
                    $convert = $row->total_active_period;
                    $years = ($convert / 365) ; // days / 365 days
                    $years = floor($years); // Remove all decimals

                    $month = ($convert % 365) / 30.5; // I choose 30.5 for Month (30,31) ;)
                    $month = floor($month); // Remove all decimals

                    $days = ($convert % 365) % 30.5; // the rest of days
                    return $years . ' Year, ' . $month . ' Month, ' . $days . ' Days';
                })
                ->addColumn('status', function($row) {
                    return Config::get('constants.status.' . $row->status, 'Undefined');
                })
                ->addColumn('option', function($row) use ($role) {
                    if ($role == 'admin') {
                        $option = '
                            <a href="membership/'.$row->id.'/edit">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Membership">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </button>
                            </a>
                            <a href="javascript:void(0)">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Membership" data-id="'.$row->id.'" id="delete-membership">
                                    <i class="mdi mdi-trash-can"></i>
                                </button>
                            </a>';
                    }
                    return $option;
                })->rawColumns(['option'])->make(true);
        }
        // End

        return view('membership.memberships', compact('user', 'role', 'memberships'));
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
        if (!$user->hasAccess('membership.create')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Default data null
        $membership = null;
        
        return view('membership.membership-details', compact('user', 'role', 'membership'));
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
        if (!$user->hasAccess('membership.create')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'name' => 'required',
            'discount_type' => 'required|numeric',
            'discount_value' => 'required|numeric',
            'total_active_period' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, new Membership());
            $obj->created_by = $user->id;
            $obj->save();

            return redirect('membership')->with('success', 'Membership created successfully!');
        } catch (Exception $e) {
            return redirect('membership')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function edit(Membership $membership)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $obj = Membership::where('id', $membership->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('membership.update') || $obj == NULL) {
            return view('error.403');
        }

        return view('membership.membership-details', compact('user', 'role', 'membership'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Membership $membership)
    {   
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('membership.update')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'name' => 'required',
            'discount_type' => 'required|numeric',
            'discount_value' => 'required|numeric',
            'total_active_period' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, $membership);
            $obj->updated_by = $user->id;
            $obj->save();

            return redirect('membership')->with('success', 'Membership updated successfully!');
        } catch (Exception $e) {
            return redirect('membership')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membership $membership)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get available data only
        $obj = Membership::where('id', $membership->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('membership.delete') || $obj == NULL) {
            return response()->json([
                'success' =>false,
                'message' =>'You have no permission to delete membership.',
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
                    'message' => 'Membership deleted successfully.',
                    'data' => $obj,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Membership not found.',
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
     * @return \App\Membership $membership
     */
    private function toObject(Request $request, Membership $membership) {
        $membership->name = $request->input('name');
        $membership->discount_type = $request->input('discount_type');
        $membership->discount_value = $request->input('discount_value');
        $membership->total_active_period = $request->input('total_active_period');
        $membership->status = $request->input('status');

        return $membership;
    }
}
