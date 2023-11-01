<?php

namespace App\Http\Controllers;

use App\TransactionNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
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
        if (!$user->hasAccess('transaction.list')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $transactions = TransactionNew::where('is_deleted', 0)->orderByDesc('id')->get();

        // Load Datatables
        if ($request->ajax()) {
            return Datatables::of($transactions)
                ->addIndexColumn()
                ->addColumn('customer_name', function($row) {
                    return $row->customer_name;
                })
                ->addColumn('room', function($row) {
                    return $row->room;
                })
                ->addColumn('therapist_name', function($row) {
                    return $row->therapist_name;
                })
                ->addColumn('total_cost', function($row) {
                    return $row->total_cost;
                })
                ->addColumn('payment_method', function($row) {
                    return $row->payment_method;
                })
                ->addColumn('option', function($row) use ($role) {
                    if ($role == 'admin') {
                        $option = '
                            <a href="transaction/'.$row->id.'">
                                <button type="button"
                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                    title="View Invoice">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                            </a>
                            <a href="transaction/'.$row->id.'/edit">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Transaction">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </button>
                            </a>
                            <a href="javascript:void(0)">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Delete Transaction" data-id="'.$row->id.'" id="delete-transaction">
                                    <i class="mdi mdi-trash-can"></i>
                                </button>
                            </a>';
                    }
                    return $option;
                })->rawColumns(['option'])->make(true);
        }
        // End

        return view('transaction.transactions', compact('user', 'role', 'transactions'));
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
        if (!$user->hasAccess('transaction.create')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Default data null
        $transaction = null;

        return view('transaction.transaction-details', compact('user', 'role', 'transaction'));
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
        if (!$user->hasAccess('transaction.create')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'customer_name' => 'required',
            'room' => 'required',
            'therapist_name' => 'required',
            'product' => 'required',
            'total_cost' => 'required',
            'payment_method' => 'required'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, new TransactionNew());
            $obj->created_by = $user->id;
            $obj->save();

            return redirect('transaction')->with('success', 'Transaction created successfully!');
        } catch (Exception $e) {
            return redirect('transaction')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransactionNew  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionNew $transaction)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('transaction.show')) {
            $user = Sentinel::getUser();
            $role = $user->roles[0]->slug;
            $transaction_detail = TransactionNew::where('id', $transaction->id)->first();
            // return $transaction_detail;
            return view('transaction.transaction-view', compact('user', 'role', 'transaction_detail'));
        } else {
            return view('error.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransactionNew  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionNew $transaction)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $obj = TransactionNew::where('id', $transaction->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('transaction.update') || $obj == NULL) {
            return view('error.403');
        }

        return view('transaction.transaction-details', compact('user', 'role', 'transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransactionNew  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionNew $transaction)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('transaction.update')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'customer_name' => 'required',
            'room' => 'required',
            'therapist_name' => 'required',
            'product' => 'required',
            'total_cost' => 'required',
            'payment_method' => 'required'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, $transaction);
            $obj->updated_by = $user->id;
            $obj->save();

            return redirect('transaction')->with('success', 'Transaction updated successfully!');
        } catch (Exception $e) {
            return redirect('transaction')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransactionNew  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionNew $transaction)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get available data only
        $obj = TransactionNew::where('id', $transaction->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('transaction.delete') || $obj == NULL) {
            return response()->json([
                'success' =>false,
                'message' =>'You have no permission to delete transaction.',
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
                    'message' => 'Transaction deleted successfully.',
                    'data' => $obj,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found.',
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
     * @return \App\TransactionNew $transaction
     */
    private function toObject(Request $request, TransactionNew $transaction) {
        $transaction->customer_name = $request->input('customer_name');
        $transaction->room = $request->input('room');
        $transaction->therapist_name = $request->input('therapist_name');
        $transaction->product = $request->input('product');
        $transaction->total_cost = $request->input('total_cost');
        $transaction->payment_method = $request->input('payment_method');

        return $transaction;
    }
}
