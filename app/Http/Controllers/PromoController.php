<?php

namespace App\Http\Controllers;

use App\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;

class PromoController extends Controller
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
        if (!$user->hasAccess('promo.list')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $promos = Promo::where('is_deleted', 0)->orderByDesc('id')->get();

        // Load Datatables
        if ($request->ajax()) {
            return Datatables::of($promos)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return $row->name;
                })
                ->addColumn('discount', function($row) {
                    if ($row->discount_type == 0) {
                        return 'Rp ' . number_format($row->discount_value);
                    } else if ($row->discount_type == 1) {
                        return $row->discount_value . '%';
                    }
                })
                ->addColumn('discount_max', function($row) {
                    return 'Rp ' . number_format($row->discount_max_value);
                })
                ->addColumn('active_period', function($row) {
                    return $row->active_period_start . ' - ' . $row->active_period_end;
                })
                ->addColumn('is_reuse_voucher', function($row) {
                    if ($row->is_reuse_voucher == 0) {
                        return 'No';
                    } else {
                        return 'Yes';
                    }
                })
                ->addColumn('status', function($row) {
                    return Config::get('constants.status.' . $row->status, 'Undefined');
                })
                ->addColumn('option', function($row) use ($role) {
                    if ($role == 'admin') {
                        $option = '
                            <a href="promo/'.$row->id.'">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Promo Voucher">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                            </a>
                            <a href="product/'.$row->id.'/edit">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Product">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </button>
                            </a>
                            <a href="javascript:void(0)">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Product" data-id="'.$row->id.'" id="delete-product">
                                    <i class="mdi mdi-trash-can"></i>
                                </button>
                            </a>';
                    } else if ($role == 'receptionist') {
                        $option = '
                            <a href="promo/'.$row->id.'">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Promo Voucher">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                            </a>';
                    }
                    return $option;
                })->rawColumns(['option'])->make(true);
        }
        // End

        return view('promo.promos', compact('user', 'role', 'promos'));
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
        if (!$user->hasAccess('promo.create')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Default data null
        $promo = null;
        
        return view('promo.promo-details', compact('user', 'role', 'promo'));
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
        if (!$user->hasAccess('promo.create')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'name' => 'required',
            'discount_type' => 'required|numeric',
            'discount_value' => 'required|numeric',
            'discount_max_value' => 'numeric',
            'active_period_start' => 'required|date|after:yesterday',
            'active_period_end' => 'required|date|after:active_period_start',
            'is_reuse_voucher' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, new Promo());
            $obj->created_by = $user->id;
            $obj->save();

            return redirect('promo')->with('success', 'Promo created successfully!');
        } catch (Exception $e) {
            return redirect('promo')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function show(Promo $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function edit(Promo $promo)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $obj = Promo::where('id', $promo->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('promo.update') || $obj == NULL) {
            return view('error.403');
        }

        return view('promo.promo-details', compact('user', 'role', 'promo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promo $promo)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('promo.update')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'name' => 'required',
            'discount_type' => 'required|numeric',
            'discount_value' => 'required|numeric',
            'discount_max_value' => 'numeric',
            'active_period_start' => 'required|date|after:yesterday',
            'active_period_end' => 'required|date|after:active_period_start',
            'is_reuse_voucher' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, $promo);
            $obj->updated_by = $user->id;
            $obj->save();

            return redirect('promo')->with('success', 'Promo updated successfully!');
        } catch (Exception $e) {
            return redirect('promo')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promo $promo)
    {
        //
    }

    /**
     * Mapping request to object.
     *
     * @param  \Illuminate\Http\Request
     * @return \App\Promo $promo
     */
    private function toObject(Request $request, Promo $promo) {
        $promo->name = $request->input('name');
        $promo->description = $request->input('description');
        $promo->discount_type = $request->input('discount_type');
        $promo->discount_value = $request->input('discount_value');
        $promo->discount_max_value = $request->input('discount_max_value');
        $promo->active_period_start = $request->input('active_period_start');
        $promo->active_period_end = $request->input('active_period_end');
        $promo->is_reuse_voucher = $request->input('is_reuse_voucher');
        $promo->status = $request->input('status');

        return $promo;
    }
}
