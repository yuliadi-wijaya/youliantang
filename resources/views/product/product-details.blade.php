@extends('layouts.master-layouts')
@section('title')
    @if ($product)
        {{ __('Update Product Details') }}
    @else
        {{ __('Add New Product') }}
    @endif
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        @if ($product)
                            {{ __('Update Product Details') }}
                        @else
                            {{ __('Add New Product') }}
                        @endif
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('product') }}">{{ __('Products') }}</a></li>
                            <li class="breadcrumb-item active">
                                @if ($product)
                                    {{ __('Update Product Details') }}
                                @else
                                    {{ __('Add New Product') }}
                                @endif
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="{{ url('product') }}">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i>{{ __('Back to Product List') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Basic Information') }}</blockquote>
                        <form action="@if ($product ) {{ url('product/' . $product->id) }} @else {{ route('product.store') }} @endif" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($product )
                                <input type="hidden" name="_method" value="PATCH" />
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Product Name ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="Name" tabindex="1"
                                                value="@if ($product){{ old('name', $product->name) }}@elseif(old('name')){{ old('name') }}@endif"
                                                placeholder="{{ __('Enter Product Name') }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Duration (minute)') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('duration') is-invalid @enderror"
                                                name="duration" id="Duration" tabindex="1"
                                                value="@if ($product){{ old('duration', $product->duration) }}@elseif(old('duration')){{ old('duration') }}@endif"
                                                placeholder="{{ __('Enter Total Duration of Product In Minute') }}">
                                            @error('duration')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Status ') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                tabindex="11" name="status">
                                                <option selected disabled>{{ __('-- Select Status --') }}</option>
                                                <option value="1" @if (($product && $product->status == '1') || old('status') == '1') selected @endif>{{ __('Active') }}</option>
                                                <option value="0" @if (($product && $product->status == '0') || old('status') == '0') selected @endif>{{ __('In Active') }}</option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Price ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                                    tabindex="4" name="price" id="Price" value="@if ($product ){{ old('price', $product->price) }}@elseif(old('price')){{ old('price') }}@endif"
                                                    placeholder="{{ __('Enter Total Price') }}">
                                            @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Commission Fee ') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('commission_fee') is-invalid @enderror"
                                                tabindex="4" name="commission_fee" id="CommissionFee" value="@if ($product ){{ old('commission_fee', $product->commission_fee) }}@elseif(old('commission_fee')){{ old('commission_fee') }}@endif"
                                                placeholder="{{ __('Enter Commission Fee That Will Be Paid to The Therapist') }}">
                                            @error('commission_fee')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($product)
                                            {{ __('Update Product Details') }}
                                        @else
                                            {{ __('Add New Product') }}
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <script>
            // Script
        </script>
    @endsection
