<?php

namespace App\Http\Controllers;

use App\Promo;
use App\PromoVoucher;
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
                        if ($row->discount_max_value > 0) {
                            return $row->discount_value . '% (Max: Rp ' . number_format($row->discount_max_value) . ')';
                        } else {
                            return $row->discount_value . '%';
                        }
                        
                    }
                })
                ->addColumn('active_period', function($row) {
                    return date('d M Y', strtotime($row->active_period_start)) . ' - ' . date('d M Y', strtotime($row->active_period_end));
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
                                <button type="button" class="btn btn-info btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Promo Voucher">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                            </a>
                            <a href="promo/'.$row->id.'/edit">
                                <button type="button" class="btn btn-warning btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Promo">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </button>
                            </a>
                            <a href="javascript:void(0)">
                                <button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Promo" data-id="'.$row->id.'" id="delete-promo">
                                    <i class="mdi mdi-trash-can"></i>
                                </button>
                            </a>';
                    } else if ($role == 'receptionist') {
                        $option = '
                            <a href="promo/'.$row->id.'">
                                <button type="button" class="btn btn-info btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Promo Voucher">
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
            'active_period_start' => 'required|date',
            'active_period_end' => 'required|date|after:active_period_start',
            'is_reuse_voucher' => 'required|numeric',
            'status' => 'required|numeric',
            'voucher_list.*' => 'required',
            'start_number' => 'required|numeric',
            'voucher_total' => 'required|numeric',
            'voucher_prefix' => 'required|string|max:25'
        ]);

        // Check if voucher_prefix already exists
        $existingPromo = Promo::where('voucher_prefix', $request->voucher_prefix)->first();

        if ($existingPromo) {
            // Check if start_number is greater than the existing promo's start_number
            $defaultStartNumber = $existingPromo->start_number + $existingPromo->voucher_total;

            if ($request->start_number < $defaultStartNumber) {
                $errorMessage = 'Start Number must be greater equals ' . $defaultStartNumber;

                return redirect()->back()
                    ->withErrors(['start_number' => $errorMessage])
                    ->withInput($request->all());
            }
        }

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, new Promo());
            $obj->created_by = $user->id;
            $obj->save();

            // Store detail promo voucher
            $obj->promo_vouchers()->saveMany($this->toObjectVoucherList($obj, $request));

            return redirect('promo/' . $request->id)->with('success', 'Promo created successfully!');
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
        // Get user session data
        $user = Sentinel::getUser();

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $obj = Promo::where('id', $promo->id)->where('is_deleted', 0)->with('promo_vouchers')->first();

        // Check user access and available data
        if (!$user->hasAccess('promo.show') || $obj == NULL) {
            return view('error.403');
        }

        return view('promo.promo-vouchers', compact('user', 'role', 'promo'));
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
        $obj = Promo::where('id', $promo->id)->where('is_deleted', 0)->with('promo_vouchers')->first();

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
            'active_period_start' => 'required|date',
            'active_period_end' => 'required|date|after:active_period_start',
            'is_reuse_voucher' => 'required|numeric',
            'status' => 'required|numeric',
            'voucher_list.*' => 'required'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, $promo);
            $obj->updated_by = $user->id;
            $obj->save();

            // If generated delete the old data
            if ($request->is_generated == 1) {
                PromoVoucher::where('promo_id', $promo->id)->update('is_deleted', 1);
            }

            // Store detail promo voucher
            $obj->promo_vouchers()->saveMany($this->toObjectVoucherList($promo, $request));

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
        // Get user session data
        $user = Sentinel::getUser();

        // Get available data only
        $obj = Promo::where('id', $promo->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('promo.delete') || $obj == NULL) {
            return response()->json([
                'success' =>false,
                'message' =>'You have no permission to delete promo.',
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
                    'message' => 'Promo deleted successfully.',
                    'data' => $obj,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Promo not found.',
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
     * @return \App\Promo $promo
     */
    private function toObject(Request $request, Promo $promo) {
        $promo->name = $request->input('name');
        $promo->description = $request->input('description');
        $promo->discount_type = $request->input('discount_type');
        $promo->discount_value = $request->input('discount_value');
        $promo->discount_max_value = $request->input('discount_max_value');
        $promo->active_period_start = date('Y-m-d', strtotime($request->input('active_period_start')));
        $promo->active_period_end = date('Y-m-d', strtotime($request->input('active_period_end')));
        $promo->is_reuse_voucher = $request->input('is_reuse_voucher');
        $promo->status = $request->input('status');
        $promo->start_number = $request->input('start_number');
        $promo->voucher_total = $request->input('voucher_total');
        $promo->voucher_prefix = $request->input('voucher_prefix');

        return $promo;
    }

    private function toObjectVoucherList(Promo $promo, Request $request) {
        $promoVouchers = [];

        // If voucher wasn't generated, keep exists the promo voucher
        if ($request->is_generated == 0) {
            return $promoVouchers;
        }

        foreach($request->input('voucher_list') as $item) {
            $obj = new PromoVoucher();
            $obj->voucher_code = $item;
            $promoVouchers[] = $obj;
        }

        return $promoVouchers;
    }
}
