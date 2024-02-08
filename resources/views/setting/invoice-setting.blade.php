@extends('layouts.master-layouts')
@section('title')
    {{ __('Invoice Setting') }}
@endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title')
                Invoice Setting
            @endslot
            @slot('li_1')
                Dashboard
            @endslot
            @slot('li_2')
                Setting
            @endslot
            @slot('li_3')
                Invoice Setting
            @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Setting Header') }}</blockquote>
                        <form action="{{ route('update-invoice-setting') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="invoiceTitle">Invoice Type to Display <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('invoice_type') is-invalid @enderror" name="invoice_type">
                                            <option value="CK" @if (($data->invoice_type == 'CK') || old('status') == 'CK') selected @endif>{{ __('Checklist') }}</option>
                                            <option value="NC" @if (($data->invoice_type == 'NC') || old('status') == 'NC') selected @endif>{{ __('Non Checklist') }}</option>
                                            <option value="ALL" @if (($data->invoice_type == 'ALL') || old('status') == 'ALL') selected @endif>{{ __('ALL') }}</option>
                                        </select>
                                        @error('title')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
