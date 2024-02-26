@extends('layouts.master-layouts')
@section('title') {{ __('Therapist Profile') }} @endsection
@section('body')

    <body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        {{ __('Therapist Profile') }}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('therapist') }}">{{ __('Therapists') }}</a></li>
                            <li class="breadcrumb-item active">
                                {{ __('Therapist Profile') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-soft-primary" style="background-color: #2a3042 !important">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">{{ __('Therapist Information') }}</h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="@if ($therapist->profile_photo != ''){{ URL::asset('storage/images/users/' . $therapist->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" alt="{{ $therapist->first_name }}"
                                        class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate"> {{ $therapist->first_name }}
                                    {{ $therapist->last_name }} </h5>
                                <p class="text-muted mb-0 text-truncate"> {{ $therapist_info->title }} </p>
                            </div>
                            <div class="col-sm-6">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-size-12">{{ __('Last Login :') }} </h5>
                                            <p class="text-muted mb-0"> {{ $therapist->last_login }} </p>
                                        </div>
                                    </div>
                                    @if ($role == 'therapist' || $role == 'admin')
                                        <div class="mt-4">
                                            <a href="{{ url('therapist/' . $therapist->id . '/edit') }}"
                                                class="btn btn-success waves-effect waves-light btn-sm">{{ __('Edit Profile') }}
                                                <i class="mdi mdi-arrow-right ml-1"></i></a>
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
                                        <td>{{ $therapist->first_name }} {{ $therapist->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('ID Card:') }}</th>
                                        <td> {{ $therapist_info->ktp }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Email:') }}</th>
                                        <td> {{ $therapist->email }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Phone Number:') }}</th>
                                        <td> {{ $therapist->phone_number }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Gender:') }}</th>
                                        <td> {{ $therapist_info->gender }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end card -->
                <!-- end card -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __(' Therapist Available Day And Time') }}</h4>
                        <hr>
                        <p>Available Day</p>
                        @if ($availableDay)
                            @if ($availableDay->sun == 1)
                                <span class="badge badge-secondary font-size-15 my-2">{{ __('Sunday') }}</span>
                            @endif
                            @if ($availableDay->mon == 1)
                                <span class="badge badge-secondary font-size-15 my-2">{{ __('Monday') }}</span>
                            @endif
                            @if ($availableDay->tue == 1)
                                <span class="badge badge-secondary font-size-15 my-2">{{ __('Tuesday') }}</span>
                            @endif
                            @if ($availableDay->wen == 1)
                                <span class="badge badge-secondary font-size-15 my-2">{{ __('Wednesday') }}</span>
                            @endif
                            @if ($availableDay->thu == 1)
                                <span class="badge badge-secondary font-size-15 my-2">{{ __('Thursday') }}</span>
                            @endif
                            @if ($availableDay->fri == 1)
                                <span class="badge badge-secondary font-size-15 my-2">{{ __('Friday') }}</span>
                            @endif
                            @if ($availableDay->sat == 1)
                                <span class="badge badge-secondary font-size-15 my-2">{{ __('Saturday') }}</span>
                            @endif
                        @endif
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Total Fee') }}</p>
                                        <h4 class="mb-0">Rp {{ number_format($data['fee']) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-dollar font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Total Treatment') }}</p>
                                        <h4 class="mb-0">{{ number_format((float)$data['total_treatments']) }} <span style="font-size:9pt; font-weight:normal;"> of {{ number_format((float)$data['total_invoices']) }} invoices</span></h4>
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
                    <div class="col-md-4">
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
                                <a class="nav-link active" data-toggle="tab" href="#Invoices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Transaction') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Invoices" role="tabpanel">
                                <table class="table dt-responsive nowrap table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>
                                            <th>{{ __('Invoice Number') }}</th>
                                            <th>{{ __('Treatment') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
                                            <th>{{ __('Fee') }}</th>
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
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ date('d M Y', strtotime($item->treatment_date)) }}</td>
                                                <td>{{ substr($item->treatment_time_from, 0, 5) . ' - ' . substr($item->treatment_time_to, 0, 5) }}</td>
                                                <td>Rp {{ number_format($item->fee) }}</td>
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
        <!-- chart plugins -->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <!-- Init js-->
        <script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
    @endsection
