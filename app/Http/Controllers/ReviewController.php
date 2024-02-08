<?php

namespace App\Http\Controllers;

use App\User;
use App\Review;
use App\Invoice;
use App\InvoiceDetail;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Config;

class ReviewController extends Controller
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
        if (!$user->hasAccess('invoice.review')) {
            return view('error.403');
        }

        // Validate input data
        $request->validate([
            'rating.*' => 'required|integer|min:1|max:5'
        ]);

        try {
            //if exist delete data
            Review::where('invoice_id', $request->invoice_id)->delete();

            // Mapping request to object and store data
            foreach ($request->therapist_id as $index => $therapistId) {
                $obj = new Review();
                $obj = $this->toObject($request, $obj, $index);
                $obj->created_by = $user->id;
                $obj->save();
            }

            return redirect('invoice')->with('success', 'Review successfully!');
        } catch (Exception $e) {
            return redirect('invoice')->with('error', 'Something went wrong!!! ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get user session data
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        $invoice = Invoice::select([
            'invoices.id',
            'invoices.old_data',
            'invoices.customer_id',
            'invoices.therapist_name',
            'customer.phone_number',
            \DB::raw("CASE WHEN invoices.old_data = 'Y' THEN invoices.customer_name ELSE CONCAT(COALESCE(customer.first_name,''), ' ', COALESCE(customer.last_name,'')) END AS customer_name")
        ])
        ->leftJoin('users as customer', 'invoices.customer_id', '=', 'customer.id')
        ->where('invoices.id', $id)
        ->first();
        $invoice_details = InvoiceDetail::select(
            'invoice_details.id',
            'invoice_details.invoice_id',
            'invoice_details.therapist_id',
            \DB::raw("CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) as therapist_name"),
            'reviews.id as review_id',
            \DB::raw("COALESCE(reviews.rating, 0) as rating"),
            \DB::raw("COALESCE(reviews.comment, '') as comment"),
            'products.name as product_name'
        )
        ->join('users', 'users.id', '=', 'invoice_details.therapist_id')
        ->join('products', 'products.id', '=', 'invoice_details.product_id')
        ->leftJoin('reviews', function ($join) {
            $join->on('reviews.invoice_id', '=', 'invoice_details.invoice_id')
                ->on('reviews.invoice_detail_id', '=', 'invoice_details.id');
        })
        ->where('invoice_details.is_deleted', 0)
        ->where('invoice_details.status', 1)
        ->where('invoice_details.invoice_id', $id)
        ->orderBy('invoice_details.id', 'asc')
        ->get();
        $reviews = Review::where('invoice_id', $id)->first();

        // Check user access and available data
        if (!$user->hasAccess('invoice.review')) {
            return view('error.403');
        }

        return view('invoice.invoice-review', compact('user', 'role', 'invoice', 'invoice_details', 'reviews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {

    }

    /**
     * Mapping request to object.
     *
     * @param  \Illuminate\Http\Request
     * @return \App\Review $review
     */
    private function toObject(Request $request, Review $review, $index) {
        if ($request->old_data == 'Y') {
            $review->customer_name = $request->customer_name;
        } else {
            $review->customer_id = $request->customer_id;
        }

        $review->phone_number = $request->phone_number;
        $review->invoice_id = $request->invoice_id;
        $review->invoice_detail_id = $request->invoice_detail_id[$index];
        $review->therapist_id = $request->therapist_id[$index];
        $review->rating = $request->rating[$index];
        $review->comment = $request->comment[$index];

        return $review;
    }
}
