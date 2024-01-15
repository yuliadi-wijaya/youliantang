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
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="@if ($therapist->profile_photo != ''){{ URL::asset('storage/images/users/' . $therapist->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" alt="{{ $therapist->first_name }}"
                                        class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate"> {{ $therapist->first_name }}
                                    {{ $therapist->last_name }} </h5>
                                <p class="text-muted mb-0 text-truncate"> {{ $therapist_info->title }} </p>
                            </div>
                            <div class="col-sm-8">
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
                                                class="btn btn-primary waves-effect waves-light btn-sm">{{ __('Edit Profile') }}
                                                <i class="mdi mdi-arrow-right ml-1"></i></a>
                                            {{-- <a href="{{ url('time-edit/' . $therapist->id) }}"
                                                class="btn btn-primary waves-effect waves-light btn-sm">{{ __('Edit Time Slot') }}
                                                <i class="mdi mdi-arrow-right ml-1"></i></a> --}}
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
                                        <th scope="row">{{ __('Contact No:') }}</th>
                                        <td> {{ $therapist->mobile }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Email:') }}</th>
                                        <td> {{ $therapist->email }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Degree:') }}</th>
                                        <td> {{ $therapist_info->degree }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Experience:') }}</th>
                                        <td> {{ $therapist_info->experience }} </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('Fees:') }}</th>
                                        <td>{{ $therapist_info->fees }}</td>
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
                                <span class="badge badge-primary font-size-15 my-2">{{ __('Sunday') }}</span>
                            @endif
                            @if ($availableDay->mon == 1)
                                <span class="badge badge-primary font-size-15 my-2">{{ __('Monday') }}</span>
                            @endif
                            @if ($availableDay->tue == 1)
                                <span class="badge badge-primary font-size-15 my-2">{{ __('Tuesday') }}</span>
                            @endif
                            @if ($availableDay->wen == 1)
                                <span class="badge badge-primary font-size-15 my-2">{{ __('Wednesday') }}</span>
                            @endif
                            @if ($availableDay->thu == 1)
                                <span class="badge badge-primary font-size-15 my-2">{{ __('Thursday') }}</span>
                            @endif
                            @if ($availableDay->fri == 1)
                                <span class="badge badge-primary font-size-15 my-2">{{ __('Friday') }}</span>
                            @endif
                            @if ($availableDay->sat == 1)
                                <span class="badge badge-primary font-size-15 my-2">{{ __('Saturday') }}</span>
                            @endif
                        @endif
                        <hr>
                        {{-- <p>Available Time</p>
                        @if ($availableTime)
                            @foreach ($availableTime as $item)
                                <span class="badge badge-info font-size-15 my-2">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $item->from)->format('h:i') . ' To ' . \Carbon\Carbon::createFromFormat('H:i:s', $item->to)->format('h:i') }}
                                </span>
                            @endforeach
                        @endif --}}
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">{{ __('Pending Bills') }}</p>
                                        <h4 class="mb-0">{{ number_format($data['pending_bill']) }}</h4>
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
                                        <p class="text-muted font-weight-medium">{{ __('Total Bill') }}</p>
                                        <h4 class="mb-0">Rp {{ number_format($data['revenue']) }}</h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-package font-size-24"></i>
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
                                <a class="nav-link" data-toggle="tab" href="#Invoices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Invoices') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Invoices" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>
                                            <th>{{ __('Customer Name') }}</th>
                                            <th>{{ __('Treatment Date') }}</th>
                                            <th>{{ __('Status') }}</th>
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
                                                <td>{{ $item->user->first_name }} {{ $item->user->last_name }}</td>
                                                <td>{{ date('d-m-Y') }}</td>
                                                <td>{{ $item->payment_status }}</td>
                                                <td>
                                                    <a href="{{ url('invoice/' . $item->id) }}">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            {{ __('View') }}
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of
                                        {{ $invoices->total() }} entries
                                    </div>
                                    <div class="d-flex justify-content-end">
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
