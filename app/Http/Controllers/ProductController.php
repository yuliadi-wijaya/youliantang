<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
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
        if (!$user->hasAccess('product.list')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $products = Product::where('is_deleted', 0)->orderByDesc('id')->get();

        // Load Datatables
        if ($request->ajax()) {
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return $row->name;
                })
                ->addColumn('duration', function($row) {
                    return number_format($row->duration) . ' minute';
                })
                ->addColumn('price', function($row) {
                    return 'Rp ' . number_format($row->price);
                })
                ->addColumn('commission_fee', function($row) use ($role) {
                    if ($role == 'admin') {
                        return 'Rp ' . number_format($row->commission_fee);
                    } else {
                        return '';
                    }
                })
                ->addColumn('status', function($row) {
                    return Config::get('constants.status.' . $row->status, 'Undefined');
                })
                ->addColumn('option', function($row) use ($role) {
                    if ($role == 'admin') {
                        $option = '
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
                    }
                    return $option;
                })->rawColumns(['option'])->make(true);
        }
        // End

        return view('product.products', compact('user', 'role', 'products'));
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
        if (!$user->hasAccess('product.create')) {
            return view('error.403');
        }

        // Get user role
        $role = $user->roles[0]->slug;

        // Default product data null
        $product = null;
        
        return view('product.product-details', compact('user', 'role', 'product'));
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
        if (!$user->hasAccess('product.create')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'name' => 'required',
            'duration' => 'required|numeric',
            'price' => 'required|numeric',
            'commission_fee' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, new Product());
            $obj->created_by = $user->id;
            $obj->save();

            return redirect('product')->with('success', 'Product created successfully!');
        } catch (Exception $e) {
            return redirect('product')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get user role
        $role = $user->roles[0]->slug;

        // Get available data only
        $obj = Product::where('id', $product->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('product.update') || $obj == NULL) {
            return view('error.403');
        }

        return view('product.product-details', compact('user', 'role', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Check user access
        if (!$user->hasAccess('product.update')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'name' => 'required',
            'duration' => 'required|numeric',
            'price' => 'required|numeric',
            'commission_fee' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        try {
            // Mapping request to object and store data
            $obj = $this->toObject($request, $product);
            $obj->updated_by = $user->id;
            $obj->save();

            return redirect('product')->with('success', 'Product updated successfully!');
        } catch (Exception $e) {
            return redirect('product')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Get user session data
        $user = Sentinel::getUser();

        // Get available data only
        $obj = Product::where('id', $product->id)->where('is_deleted', 0)->first();

        // Check user access and available data
        if (!$user->hasAccess('product.delete') || $obj == NULL) {
            return response()->json([
                'success' =>false,
                'message' =>'You have no permission to delete product.',
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
                    'message' => 'Product deleted successfully.',
                    'data' => $obj,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.',
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
     * @return \App\Product $product
     */
    private function toObject(Request $request, Product $product) {
        $product->name = $request->input('name');
        $product->duration = $request->input('duration');
        $product->price = $request->input('price');
        $product->commission_fee = $request->input('commission_fee');
        $product->status = $request->input('status');

        return $product;
    }
}
