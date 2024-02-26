@extends('layouts.master-layouts')
@section('title') {{ __('Receptionist Profile') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        {{ __('Receptionist Profile') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('receptionist') }}">{{ __('Receptionists') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Receptionist Profile') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-soft-primary" style="background-color: #2a3042 !important">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">{{ __('Receptionist Information') }}</h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="@if ($receptionist->profile_photo != ''){{ URL::asset('storage/images/users/' . $receptionist->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" alt="{{ $receptionist->fisrt_name }}"
                                        class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate"> {{ $receptionist->first_name }}
                                    {{ $receptionist->last_name }} </h5>
                                <p class="text-muted mb-0 text-truncate"> {{ $receptionist->title }} </p>
                            </div>
                            <div class="col-sm-6">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-size-12">{{ __('Last Login:') }}</h5>
                                            <p class="text-muted mb-0"> {{ $receptionist->last_login }} </p>
                                        </div>
                                    </div>
                                    @if ($role == 'admin')
                                        <div class="mt-4">
                                            <a href="{{ url('receptionist/' . $receptionist->id . '/edit') }}"
                                                class="btn btn-success waves-effect waves-light btn-sm">
                                                {{ __('Edit Profile') }} <i class="mdi mdi-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('Personal Information') }}</h4>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ __('Full Name:') }}</th>
                                        <td>{{ $receptionist->first_name }} {{ $receptionist->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('ID Card:') }}</th>
                                        <td>{{ $receptionist_info->ktp }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Email:') }}</th>
                                        <td> {{ $receptionist->email }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Phone Number:') }}</th>
                                        <td> {{ $receptionist->phone_number }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Gender:') }}</th>
                                        <td> {{ $receptionist_info->gender }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Pending Invoice') }}</p>
                                        <h4 class="mb-0">{{ number_format($data['pending_invoice_total']) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-hourglass font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Pending Bill') }}</p>
                                        <h4 class="mb-0">Rp {{ number_format($data['pending_revenue']) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-hourglass font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Total Invoice') }}</p>
                                        <h4 class="mb-0">{{ number_format((float)$data['invoice_total']) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="fa fa-file-invoice font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Total Bill') }}</p>
                                        <h4 class="mb-0">Rp {{ number_format($data['revenue']) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="fa fa-money-bill font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if($config['pagination'] == 0) active @endif" data-toggle="tab" href="#UnpaidInvoices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Pending Transaction') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($config['pagination'] == 1) active @endif" data-toggle="tab" href="#Invoices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Paid Transaction') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane @if($config['pagination'] == 0) active @endif" id="UnpaidInvoices" role="tabpanel">
                                <table id="invoiceList" class="table table-hover dt-responsive nowrap ">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>
                                            <th>{{ __('Invoice Number') }}</th>
                                            <th>{{ __('Customer') }}</th>
                                            <th>{{ __('Treatment Date') }}</th>
                                            <th>{{ __('Grand Total') }}</th>
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (session()->has('page_limit'))
                                            @php
                                                $per_page = session()->get('page_limit');
                                            @endphp
                                        @else
                                            @php
                                                $per_page = Config::get('app.page_limit');
                                            @endphp
                                        @endif
                                        @php
                                            $currentpage = $pending_invoices->currentPage();
                                        @endphp
                                        @foreach ($pending_invoices as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                                <td>{{ $item->invoice_code }}</td>
                                                <td>{{ ucwords($item->first_name) . ' ' . ucwords($item->last_name) . ' - ' . $item->phone_number }}</td>
                                                <td>{{ date('d M Y', strtotime($item->treatment_date)) }}</td>
                                                <td>Rp {{ number_format($item->grand_total) }}</td>
                                                <td>
                                                    <a href="{{ url('invoice/' . $item->id) }}" target="_blank">
                                                        <button type="button"
                                                            class="btn btn-info btn-sm btn-rounded waves-effect waves-light">
                                                            {{ __('View') }}
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row mt-3">
                                    <div class="col-md-6 d-flex justify-content-start">
                                        Showing {{ $pending_invoices->firstItem() }} to {{ $pending_invoices->lastItem() }} of
                                        {{ $pending_invoices->total() }} entries
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{ $pending_invoices->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane @if($config['pagination'] == 1) active @endif" id="Invoices" role="tabpanel">
                                <table id="invoiceList" class="table table-hover dt-responsive nowrap ">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>
                                            <th>{{ __('Invoice Number') }}</th>
                                            <th>{{ __('Customer') }}</th>
                                            <th>{{ __('Treatment Date') }}</th>
                                            <th>{{ __('Grand Total') }}</th>
                                            <th>{{ __('Option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (session()->has('page_limit'))
                                            @php
                                                $per_page = session()->get('page_limit');
                                            @endphp
                                        @else
                                            @php
                                                $per_page = Config::get('app.page_limit');
                                            @endphp
                                        @endif
                                        @php
                                            $currentpage = $invoices->currentPage();
                                        @endphp
                                        @foreach ($invoices as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 + $per_page * ($currentpage - 1) }}</td>
                                                <td>{{ $item->invoice_code }}</td>
                                                <td>{{ ucwords($item->first_name) . ' ' . ucwords($item->last_name) . ' - ' . $item->phone_number }}</td>
                                                <td>{{ date('d M Y', strtotime($item->treatment_date)) }}</td>
                                                <td>Rp {{ number_format($item->grand_total) }}</td>
                                                <td>
                                                    <a href="{{ url('invoice/' . $item->id) }}" target="_blank">
                                                        <button type="button"
                                                            class="btn btn-info btn-sm btn-rounded waves-effect waves-light">
                                                            {{ __('View') }}
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row mt-3">
                                    <div class="col-md-6 d-flex justify-content-start">
                                        Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of
                                        {{ $invoices->total() }} entries
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        {{ $invoices->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('script')
        <!-- Chart plugins -->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
    @endsection
