<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('/') }}" class="logo logo-dark">
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/logo-dark1.png') }}" alt="" height="17">
                    </span>
                </a>
                <a href="{{ url('/') }}" class="logo logo-light pt-2">
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="100">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/images/logo-light1.png') }}" alt="" height="50">
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ __('Search ...') }}"
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- App Search-->
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ __('Search ...') }}"
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    @switch(Session::get('lang'))
                        @case('id')
                            <img src="{{ URL::asset('/assets/images/flags/id.svg') }}" class="rounded" alt="Header Language"
                                height="20">
                        @break

                        @case('ru')
                            <img src="{{ URL::asset('/assets/images/flags/russia.svg') }}" class="rounded" alt="Header Language"
                                height="20">
                        @break

                        @case('it')
                            <img src="{{ URL::asset('/assets/images/flags/italy.svg') }}" class="rounded" alt="Header Language"
                                height="20">
                        @break

                        @case('sp')
                            <img src="{{ URL::asset('/assets/images/flags/spain.svg') }}" class="rounded" alt="Header Language"
                                height="20">
                        @break

                        @case('ch')
                            <img src="{{ URL::asset('/assets/images/flags/china.svg') }}" class="rounded" alt="Header Language"
                                height="20">
                        @break

                        @case('fr')
                            <img src="{{ URL::asset('/assets/images/flags/french.svg') }}" class="rounded"
                                alt="Header Language" height="20">
                        @break

                        @case('gr')
                            <img src="{{ URL::asset('/assets/images/flags/germany.svg') }}" class="rounded"
                                alt="Header Language" height="20">
                        @break

                        @case('ae')
                            <img src="{{ URL::asset('/assets/images/flags/ae.svg') }}" class="rounded" alt="Header Language"
                                height="20">
                        @break

                        @default
                            <img src="{{ URL::asset('/assets/images/flags/us.svg') }}" class="rounded" alt="Header Language"
                                height="20">
                    @endswitch
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="{{ url('index/en') }}" class="dropdown-item notify-item language py-2" data-lang="en"
                        title="English">
                        <img src="{{ URL::asset('assets/images/flags/us.svg') }}" alt="user-image"
                            class="me-2 rounded" height="20">
                        <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/id') }}" class="dropdown-item notify-item language" data-lang="id"
                        title="Indonesia">
                        <img src="{{ URL::asset('assets/images/flags/id.svg') }}" alt="user-image"
                            class="me-2 rounded" height="20">
                        <span class="align-middle">Indonesia</span>
                    </a>

                    {{-- remark by febry
                    <!-- item-->
                    <a href="{{ url('index/sp') }}" class="dropdown-item notify-item language" data-lang="sp"
                        title="Spanish">
                        <img src="{{ URL::asset('assets/images/flags/spain.svg') }}" alt="user-image"
                            class="me-2 rounded" height="20">
                        <span class="align-middle">Española</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/gr') }}" class="dropdown-item notify-item language" data-lang="gr"
                        title="German">
                        <img src="{{ URL::asset('assets/images/flags/germany.svg') }}" alt="user-image"
                            class="me-2 rounded" height="20"> <span class="align-middle">Deutsche</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/it') }}" class="dropdown-item notify-item language" data-lang="it"
                        title="Italian">
                        <img src="{{ URL::asset('assets/images/flags/italy.svg') }}" alt="user-image"
                            class="me-2 rounded" height="20">
                        <span class="align-middle">Italiana</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/ru') }}" class="dropdown-item notify-item language" data-lang="ru"
                        title="Russian">
                        <img src="{{ URL::asset('assets/images/flags/russia.svg') }}" alt="user-image"
                            class="me-2 rounded" height="20">
                        <span class="align-middle">русский</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/ch') }}" class="dropdown-item notify-item language" data-lang="ch"
                        title="Chinese">
                        <img src="{{ URL::asset('assets/images/flags/china.svg') }}" alt="user-image"
                            class="me-2 rounded" height="20">
                        <span class="align-middle">中国人</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/fr') }}" class="dropdown-item notify-item language" data-lang="fr"
                        title="French">
                        <img src="{{ URL::asset('assets/images/flags/french.svg') }}" alt="user-image"
                            class="me-2 rounded" height="20">
                        <span class="align-middle">français</span>
                    </a>
                    <!-- item-->
                    <a href="{{ url('index/ae') }}" class="dropdown-item notify-item language" data-lang="ae"
                        title="Arabic">
                        <img src="{{ URL::asset('assets/images/flags/ae.svg') }}" alt="user-image"
                            class="me-2 rounded" height="18">
                        <span class="align-middle">Arabic</span>
                    </a>
                    --}}
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    <span class="badge badge-danger badge-pill">{{ $Cnotification_count->count() }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> {{ __('Notifications') }}</h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{ url('/notification-list') }}" class="small"> {{ __('View All') }}</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar class="notification-list-scroll overflow-auto" style="max-height: 230px;">
                        @forelse ($Cnotification_count as $item)
                            <a href="/notification/{{ $item->id }}"
                                class="text-reset notification-item bg-light ">
                                <div class="media">
                                    <img src="@if ($user->profile_photo != '') {{ URL::asset('storage/images/users/' . $user->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }} @endif"
                                        class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1">
                                            {{ $item->user->first_name . ' ' . $item->user->last_name }}</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">{{ $item->title }}</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                {{ $item->created_at->diffForHumans() }} </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center"
                            href="{{ url('/notification-list') }}">
                            <i class="mdi mdi-arrow-right-circle mr-1"></i> {{ __('View More..') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="@if ($user->profile_photo != '') {{ URL::asset('storage/images/users/' . $user->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }} @endif"
                        alt="Avatar">
                    <span class="d-none d-xl-inline-block ml-1">{{ $user->first_name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    @if ($role == 'therapist')
                        <a class="dropdown-item" href="{{ url('profile-view') }}"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i>
                            {{ __('translation.profile') }}</a>
                    @elseif($role == 'customer')
                        <a class="dropdown-item" href="{{ url('profile-view') }}"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i>
                            {{ __('translation.profile') }}</a>
                    @elseif($role == 'receptionist')
                        <a class="dropdown-item" href="{{ url('profile-view') }}"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i>
                            {{ __('translation.profile') }}</a>
                        {{-- <a class="dropdown-item" href="{{ url('invoice-setting') }}"><i
                                class="fa fa-file-invoice-dollar font-size-16 align-middle ml-1 mr-1"></i>
                            {{ __('translation.invoice-setting') }}</a> --}}
                    @elseif($role == 'admin')
                        <a class="dropdown-item" href="{{ url('profile-edit') }}"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i>
                            {{ __('translation.change-profile') }}</a>
                        <a class="dropdown-item" href="{{ url('payment-key') }}"><i
                                class="bx bx-key font-size-16 align-middle mr-1"></i>
                            {{ __('translation.add-api-key') }}</a>
                        <a class="dropdown-item" href="{{ url('app-setting') }}"><i
                                class="bx bx-cog font-size-16 align-middle mr-1"></i>
                            {{ __('translation.app-setting') }}</a>
                        {{-- <a class="dropdown-item" href="{{ url('invoice-setting') }}"><i
                                class="fa fa-file-invoice-dollar font-size-16 align-middle ml-1 mr-1"></i>
                            {{ __('translation.invoice-setting') }}</a> --}}
                    @endif
                    <a class="dropdown-item d-block" href="{{ url('change-password') }}"><i
                            class="bx bx-wrench font-size-16 align-middle mr-1"></i>
                        {{ __('translation.change-password') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
                        {{ __('translation.logout') }} </a>
                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            {{-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect ">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div> --}}
        </div>
    </div>
</header>
