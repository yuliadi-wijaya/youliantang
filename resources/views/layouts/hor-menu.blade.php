<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="bx bx-home-circle mr-2"></i>{{__('translation.dashboards')}}
                        </a>
                    </li>
                    @if ($role == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.master-data') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('therapist') }}" class="dropdown-item">{{ __('translation.therapists') }}</a>
                                <a href="{{ url('receptionist') }}" class="dropdown-item">{{ __('translation.receptionist') }}</a>
                                <a href="{{ url('room') }}" class="dropdown-item">{{ __('translation.rooms') }}</a>
                                <a href="{{ url('membership') }}" class="dropdown-item">{{ __('translation.memberships') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.products') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('product') }}" class="dropdown-item">{{ __('translation.list-of-products') }}</a>
                                <a href="{{ route('product.create') }}"
                                    class="dropdown-item">{{ __('translation.add-new-product') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.promos') }} <div class="arrow-down">
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
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.customers') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('customer') }}" class="dropdown-item">{{ __('translation.list-of-customers') }}</a>
                                <a href="{{ route('customer.create') }}"
                                    class="dropdown-item">{{ __('translation.add-new-customer') }}</a>
                            </div>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('pending-appointment') }}">
                                <i class='bx bx-list-plus mr-2'></i>{{ __('translation.appointment-list') }}
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('transaction') }}">
                                <i class='bx bx-list-check mr-2'></i>{{ __('translation.transaction') }}
                            </a>
                        </li>
                    {{-- @elseif ($role == 'therapist')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointment.create') }}">
                                <i class="bx bx-calendar-plus mr-2"></i>{{ __('translation.appointments') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.customers') }} <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('customer') }}"
                                    class="dropdown-item">{{ __('translation.list-of-customers') }}</a>
                                <a href="{{ route('customer.create') }}"
                                    class="dropdown-item">{{ __('translation.add-new-customer') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ url('receptionist') }}">
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.receptionist') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-notepad mr-2"></i>{{ __('translation.prescription') }}<div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('prescription') }}"
                                    class="dropdown-item">{{ __('translation.list-of-prescription') }}</a>
                                <a href="{{ route('prescription.create') }}"
                                    class="dropdown-item">{{ __('translation.create-prescription') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-receipt mr-2"></i>{{ __('translation.invoice') }} <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('invoice') }}"
                                    class="dropdown-item">{{ __('translation.list-of-invoice') }}</a>
                                <a href="{{ route('invoice.create') }}"
                                    class="dropdown-item">{{ __('translation.create-invoice') }}</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('pending-appointment') }}">
                                <i class='bx bx-list-plus mr-2'></i>{{ __('translation.appointment-list') }}
                            </a>
                        </li>
                    @elseif ($role == 'receptionist')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointment.create') }}">
                                <i class="bx bx-calendar-plus mr-2"></i>{{ __('translation.appointments') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('therapist') }}">
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.therapists') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.customers') }} <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('customer') }}"
                                    class="dropdown-item">{{ __('translation.list-of-customers') }}</a>
                                <a href="{{ route('customer.create') }}"
                                    class="dropdown-item">{{ __('translation.add-new-customer') }}</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('prescription') }}">
                                <i class="bx bx-notepad mr-2"></i>{{ __('translation.prescription') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-receipt mr-2"></i>{{ __('translation.invoice') }}<div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="{{ url('invoice') }}"
                                    class="dropdown-item">{{ __('translation.list-of-invoice') }}</a>
                                <a href="{{ route('invoice.create') }}"
                                    class="dropdown-item">{{ __('translation.create-invoice') }}</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('pending-appointment') }}">
                                <i class='bx bx-list-plus mr-2'></i>{{ __('translation.appointment-list') }}
                            </a>
                        </li>
                    @elseif ($role == 'customer')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointment.create') }}">
                                <i class="bx bx-calendar-plus mr-2"></i>{{ __('translation.appointments') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('therapist') }}">
                                <i class="bx bx-user-circle mr-2"></i>{{ __('translation.therapists') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('prescription-list') }}">
                                <i class="bx bx-notepad mr-2"></i>{{ __('translation.prescription') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('invoice-list') }}">
                                <i class="bx bx-receipt mr-2"></i>{{ __('translation.invoice') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('customer-appointment') }}">
                                <i class='bx bx-list-plus mr-2'></i>{{ __('translation.appointment-list') }}
                            </a>
                        </li> --}}
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
