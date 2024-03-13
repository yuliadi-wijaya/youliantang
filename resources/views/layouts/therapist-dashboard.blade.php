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
                            <p>{{ __("translation.dashboards") }}</p>
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
                            <img src="@if ($user->profile_photo != ''){{ URL::asset('storage/images/users/' . $user->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ $user->first_name }} {{ $user->last_name }}</h5>
                        <p class="text-muted mb-0 text-truncate">{{ $therapist_info->title }}</p>
                    </div>
                    <div class="col-sm-6">
                        <div class="pt-4">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="font-size-12">{{ __('Last Login:') }}</h5>
                                    <p class="text-muted mb-0"> {{ $user->last_login }} </p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="{{ url('profile-edit') }}"
                                        class="btn btn-success waves-effect waves-light btn-sm">{{ __('Edit Profile') }}
                                        <i class="mdi mdi-arrow-right ml-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="text-muted font-weight-bold">{{ __('Current Payout') }}</p>
                        <h4 class="mb-0 text-danger" style="font-weight: bold">Rp {{ number_format($data['payroll_fee']) }} <span style="font-size:9pt; font-weight:normal;"> of {{ number_format((float)$data['payroll_treatments']) }} treatments</span></h4>
                        <span class="mt-2 badge badge-success font-size-9" style="padding:5px;"><i class="fa fa-calendar-alt font-size-12"></i>&nbsp;&nbsp;{{ date('d M Y', strtotime($data['payroll_start_date'])) }} <i class="mdi mdi-arrow-right font-size-11"></i> {{ date('d M Y', strtotime($data['payroll_end_date'])) }}</span>
                    </div>
                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-danger">
                        <span class="avatar-title" style="background-color: #f46a6a">
                            <i class="fa fa-money-check-alt font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{ __('translation.monthly-earning') }}</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-muted">{{ __('This month') }}</p>
                        <h3>Rp {{ number_format($data['monthly_earning']) }}  <span style="font-size:9pt; font-weight:normal;"> of {{ number_format((float)$data['monthly_total_treatments']) }} treatments</span></h3>
                        <p class="text-muted"><span class="@if ($data['monthly_diff'] > 0) text-success @else text-danger @endif mr-2"> {{ $data['monthly_diff'] }}% <i class="mdi @if ($data['monthly_diff'] > 0) mdi-arrow-up @else mdi-arrow-down @endif"></i> </span>
                            {{ __('From previous month') }}</p>
                    </div>
                    <div class="col-sm-6">
                        <div id="radialBar-chart" class="apex-charts"></div>
                    </div>
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
                                <p class="text-muted font-weight-medium">{{ __("Today's Treatment") }}</p>
                                <h4 class="mb-0">{{ number_format((float)$data['todays_total_treatments']) }} <span style="font-size:9pt; font-weight:normal;"> of {{ number_format((float)$data['todays_total_invoices']) }} invoices</span></h4>
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
                                <p class="text-muted font-weight-medium">{{ __("Today's Eearning") }}</p>
                                <h4 class="mb-0">Rp {{ number_format($data['todays_fee']) }}</h4>
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
            <div class="col-md-6">
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
            <div class="col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">{{ __('Total Earning') }}</p>
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
