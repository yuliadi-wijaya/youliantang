<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">{{ __('translation.dashboards') }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">{{ __('translation.welcome-to-dashboard') }}</li>
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
                            <h5 class="text-primary">{{ __('translation.welcome-back') }} !</h5>
                            <p>{{ __('translation.dashboards') }}</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="@if ($user->profile_photo != ''){{ URL::asset('storage/images/users/' . $user->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate"> {{ $user->first_name }} {{ $user->last_name }} </h5>
                        <p class="text-muted mb-0 text-truncate">{{ __('Super Admin') }}</p>
                    </div>
                    <div class="col-sm-8">
                        <div class="pt-4">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ url('/therapist') }}" class="mb-0 font-weight-medium font-size-15">
                                        <h5 class="mb-0">{{ number_format($data['total_therapists']) }}</h5>
                                    </a>
                                    <p class="text-muted mb-0">{{ __('translation.therapists') }}</p>
                                </div>
                                <div class="col-6">
                                    <a href="{{ url('/customer') }}" class="mb-0 font-weight-medium font-size-15">
                                        <h5 class="mb-0">{{ number_format($data['total_customers']) }}</h5>
                                    </a>
                                    <p class="text-muted mb-0">{{ __('translation.customers') }}</p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-6">
                                    <a href="{{ url('/receptionist') }}"
                                        class="mb-0 font-weight-medium font-size-15">
                                        <h5 class="mb-0">{{ number_format($data['total_receptionists']) }}
                                        </h5>
                                    </a>
                                    <p class="text-muted mb-0">{{ __('translation.receptionist') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 pl-0 pr-0">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ __('translation.monthly-earning') }}</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="text-muted">{{ __('This month') }}</p>
                            <h3>Rp {{ number_format($data['monthly_earning']) }}</h3>
                            <p class="text-muted">
                                <span class="@if ($data['monthly_diff'] > 0) text-success @else text-danger @endif mr-2">
                                    {{ $data['monthly_diff'] }}% <i class="mdi @if ($data['monthly_diff'] > 0) mdi-arrow-up @else mdi-arrow-down @endif"></i>
                                </span>{{ __('From previous month') }}
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <div id="radialBar-chart" class="apex-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 pl-0 pr-0">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="media">
                        @if (session()->has('page_limit'))
                            @php
                                $per_page = session()->get('page_limit');
                            @endphp
                        @else
                            @php
                                $per_page = Config::get('app.page_limit');
                            @endphp
                        @endif
                        <div class="media-body">
                            <p class="text-muted font-weight-medium">{{ __('translation.items-per-page') }}</p>
                            <button
                                class="btn  {{ $per_page == 10 ? 'btn-primary' : 'btn-info' }}  btn-sm mr-2 per-page-items  mb-md-1"
                                data-page="10">10</button>
                            <button
                                class="btn  {{ $per_page == 25 ? 'btn-primary' : 'btn-info' }}  btn-sm mr-2 per-page-items  mb-md-1"
                                data-page="25">25</button>
                            <button
                                class="btn  {{ $per_page == 50 ? 'btn-primary' : 'btn-info' }}  btn-sm mr-2 per-page-items  mb-md-1"
                                data-page="50">50</button>
                            <button
                                class="btn  {{ $per_page == 100 ? 'btn-primary' : 'btn-info' }}  btn-sm mr-2 per-page-items  mb-md-1"
                                data-page="100">100</button>
                        </div>
                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-book-open font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">{{ __("Monthly Invoice") }}</p>
                                <h4 class="mb-0">{{ number_format($data['monthly_invoice']) }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="fa fa-file-invoice-dollar font-size-24"></i>
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
                                <p class="text-muted font-weight-medium">{{ __("translation.today's-invoice") }}</p>
                                <h4 class="mb-0">{{ number_format($data['daily_invoice']) }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
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
                                <p class="text-muted font-weight-medium">{{ __("translation.today's-earning") }}</p>
                                <h4 class="mb-0">Rp {{ number_format($data['daily_earning']) }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-dollar  font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('translation.latest-users') }}</h4>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#Receptionist" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-user-tie"></i></span>
                                    <span class="d-none d-sm-block">{{ __('translation.receptionist') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Therapists" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-user-md"></i></span>
                                    <span class="d-none d-sm-block">{{ __('translation.therapists') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Customers" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-user-injured"></i></span>
                                    <span class="d-none d-sm-block">{{ __('translation.customers') }}</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Receptionist" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0 table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Gender') }}</th>
                                                <th>{{ __('Phone Number') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('View Details') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($receptionists as $row)
                                                <tr>
                                                    <td>{{ ucwords($row->first_name) }} {{ ucwords($row->last_name) }}</td>
                                                    <td>{{ $row->gender }}</td>
                                                    <td>{{ $row->phone_number }}</td>
                                                    <td>{{ $row->email }}</td>
                                                    <td>{{ $row->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <a href="{{ url('receptionist/' . $row->user_id) }}" target="_blank">
                                                            <button type="button"
                                                                class="btn btn-info btn-sm btn-rounded waves-effect waves-light"
                                                                data-toggle="modal" data-target=".exampleModal">
                                                                {{ __('View Details') }}
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                            <div class="tab-pane" id="Therapists" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0 table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Gender') }}</th>
                                                <th>{{ __('Phone Number') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('View Details') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($therapists as $row)
                                                <tr>
                                                    <td>{{ ucwords($row->first_name) }} {{ ucwords($row->last_name) }}</td>
                                                    <td>{{ $row->gender }}</td>
                                                    <td>{{ $row->phone_number }}</td>
                                                    <td>{{ $row->email }}</td>
                                                    <td>{{ $row->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <a href="{{ url('therapist/' . $row->user_id) }}" target="_blank">
                                                            <button type="button"
                                                                class="btn btn-info btn-sm btn-rounded waves-effect waves-light">
                                                                {{ __('View Details') }}
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                            <div class="tab-pane" id="Customers" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0 table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Gender') }}</th>
                                                <th>{{ __('Phone Number') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('View Details') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $customer)
                                                <tr>
                                                    <td>{{ ucwords($customer->first_name) }} {{ ucwords($customer->last_name) }}</td>
                                                    <td> {{ $customer->gender }} </td>
                                                    <td> {{ $customer->phone_number }} </td>
                                                    <td> {{ $customer->email }} </td>
                                                    <td> {{ $customer->status == 1 ? 'Active' : 'Inactive' }} </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <a href="{{ url('customer/' . $customer->user_id) }}" target="_blank">
                                                            <button type="button"
                                                                class="btn btn-info btn-sm btn-rounded waves-effect waves-light"
                                                                data-toggle="modal" data-target=".exampleModal">
                                                                {{ __('View Details') }}
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
