<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fa fa-home mr-2"></i>{{__('translation.dashboards')}}
                        </a>
                    </li>
                    @if ($role == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-pen-fancy mr-2"></i>{{ __('translation.master-data') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('receptionist') }}" class="dropdown-item">{{ __('translation.receptionist') }}</a>
                                <a href="{{ url('therapist') }}" class="dropdown-item">{{ __('translation.therapists') }}</a>
                                <a href="{{ url('product') }}" class="dropdown-item">{{ __('translation.products') }}</a>
                                <a href="{{ url('room') }}" class="dropdown-item">{{ __('translation.rooms') }}</a>
                                <a href="{{ url('membership') }}" class="dropdown-item">{{ __('translation.memberships') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-gifts mr-2"></i>{{ __('translation.promos') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('promo') }}" class="dropdown-item">{{ __('translation.list-of-promos') }}</a>
                                <a href="{{ route('promo.create') }}"
                                    class="dropdown-item">{{ __('translation.add-new-promo') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-person-booth mr-2"></i>{{ __('translation.customers') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('customer') }}" class="dropdown-item">{{ __('translation.list-of-customers') }}</a>
                                <a href="{{ route('customer.create') }}"
                                    class="dropdown-item">{{ __('translation.add-new-customer') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-address-card mr-2"></i>{{ __('translation.membership') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('customermember') }}" class="dropdown-item">{{ __('translation.list-of-membership') }}</a>
                                <a href="{{ route('customermember.create') }}"
                                    class="dropdown-item">{{ __('translation.add-new-membership') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-invoice-dollar mr-2"></i>{{ __('translation.invoice') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('invoice') }}" class="dropdown-item">{{ __('translation.list-of-invoice') }}</a>
                                <a href="{{ route('invoice.create') }}" class="dropdown-item">{{ __('translation.create-invoice') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="reportsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-chart-area mr-2"></i>{{ __('translation.reports') }}
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="reportsDropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="customerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('translation.customers') }} <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customerDropdown">
                                    <a href="{{ url('customer-new-and-repeat-order-report') }}" class="dropdown-item">{{ __('translation.new-and-repeat-order') }}</a>
                                    <a href="{{ url('customer-top-repeat-order-report') }}" class="dropdown-item">{{ __('translation.top-repeat-order') }}</a>
                                    {{-- <a href="{{ url('/rf-customer-reg') }}" class="dropdown-item">{{ __('translation.total-registration') }}</a>
                                    <a href="{{ url('/rf-customer-trans') }}" class="dropdown-item">{{ __('translation.transaction-history') }}</a> --}}
                                </div>

                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="therapistsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('translation.therapists') }} <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="therapistsDropdown">
                                    <a href="{{ url('therapist-commission-fee-report') }}" class="dropdown-item">{{ __('translation.commission-fee') }}</a>
                                    <a href="{{ url('therapist-review-report') }}" class="dropdown-item">{{ __('translation.review') }}</a>
                                    {{-- <a href="{{ url('/rf-therapist-trans') }}" class="dropdown-item">{{ __('translation.transaction-history') }}</a>
                                    <a href="{{ url('/rf-therapist-total') }}" class="dropdown-item">{{ __('translation.total-therapist') }}</a> --}}
                                </div>

                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="transactionsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('translation.products') }} <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="therapistsDropdown">
                                    <a href="{{ url('product-transaction-report') }}" class="dropdown-item">{{ __('translation.transactions') }}</a>
                                </div>

                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="transactionsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('translation.transactions') }} <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="therapistsDropdown">
                                    <a href="{{ url('transactions-revenue-report') }}" class="dropdown-item">{{ __('translation.revenue') }}</a>
                                    <a href="{{ url('transactions-commission-fee-report') }}" class="dropdown-item">{{ __('translation.commission-fee') }}</a>
                                    {{-- <a href="{{ url('/rf-trans') }}" class="dropdown-item">{{ __('translation.raw-data') }}</a> --}}
                                </div>

                                <a href="{{ url('analytics') }}" class="nav-link">{{ __('translation.analytics') }}</a>
                            </div>
                        </li>
                    @elseif ($role == 'receptionist')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('promo') }}">
                                <i class="fa fa-gifts mr-2"></i>{{__('translation.promos')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('customermember') }}">
                                <i class="fa fa-address-card mr-2"></i>{{__('translation.membership')}}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-person-booth mr-2"></i>{{ __('translation.customers') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('customer') }}" class="dropdown-item">{{ __('translation.list-of-customers') }}</a>
                                <a href="{{ route('customer.create') }}"
                                    class="dropdown-item">{{ __('translation.add-new-customer') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-invoice-dollar mr-2"></i>{{ __('translation.invoice') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('invoice') }}" class="dropdown-item">{{ __('translation.list-of-invoice') }}</a>
                                <a href="{{ route('invoice.create') }}" class="dropdown-item">{{ __('translation.create-invoice') }}</a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
