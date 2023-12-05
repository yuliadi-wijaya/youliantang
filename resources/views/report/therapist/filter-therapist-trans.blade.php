@extends('layouts.master-layouts')
@section('title'){{ __('Report Therapists') }}@endsection
@section('css')
    <style type="text/css">
        .h-formfield-uppercase {
            text-transform: uppercase;
            &::placeholder {
                text-transform: none;
            }
        }

    </style>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
@endsection
@section('body')

<body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Report Filter Customer Transaction History @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Therapists @endslot
            @slot('li_4') Report Customer Transaction History @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Filter Details') }}</blockquote>
                        <form action="{{ route('rs-therapist-trans') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Report Type') }}</label>
                                    <select class="form-control select2" name="report_type" id="report_type">
                                        <option value="detail" @if (old('report_type') == 'detail') selected @endif>{{ __('Detail') }}</option>
                                        <option value="summary" @if (old('report_type') == 'summary') selected @endif>{{ __('Summary') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="treatment_date_show" style="display: block;">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Treatment Date ') }}<span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group datepickerdiv">
                                                        <input type="text"
                                                            class="form-control @error('date_from') is-invalid @enderror"
                                                            name="date_from" id="date_from" data-provide="datepicker"
                                                            data-date-autoclose="true" autocomplete="off"
                                                            {{ old('date_from', date('Y-m-d')) }} placeholder="{{ __('Enter Date From') }}"
                                                            value="{{ old('date_from') }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        @error('date_from')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group datepickerdiv">
                                                        <input type="text"
                                                            class="form-control @error('date_to') is-invalid @enderror"
                                                            name="date_to" id="date_to" data-provide="datepicker"
                                                            data-date-autoclose="true" autocomplete="off"
                                                            {{ old('date_to', date('Y-m-d')) }} placeholder="{{ __('Enter Date To') }}"
                                                            value="{{ old('date_to') }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        @error('date_to')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="therapist_show" style="display: none;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Select Therapist') }}</label>
                                    <select class="form-control select2" name="therapist_id" id="therapist_id">
                                        <option value="all" @if (old('therapist_id') == 'therapist ') selected @endif>{{ __('All Therapist') }}</option>
                                        @foreach($therapists as $row)
                                            <option value="{{ $row->id }}" {{ old('therapist_id') == $row->id ? 'selected' : '' }}>{{ $row->therapist_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="month_year_show" style="display: none;">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Treatment Date ') }}<span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group datepickerdiv">
                                                        <select class="custom-select" id="month" name="month" required oninvalid="setCustomValidity('Please select a month')" oninput="setCustomValidity('')">
                                                            <option value="" disabled selected>Select Month</option>
                                                        </select>
                                                        @error('month')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group datepickerdiv">
                                                        <select class="custom-select" id="year" name="year" required oninvalid="setCustomValidity('Please select a year')" oninput="setCustomValidity('')">
                                                            <option value="" disabled selected>Select Year</option>
                                                        </select>
                                                        @error('year')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="order_by_show" style="display: none;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Order By') }}</label>
                                    <select class="form-control select2" name="order_by">
                                        <option value="therapist" @if (old('order_by') == 'therapist ') selected @endif>{{ __('Therapist Name') }}</option>
                                        <option value="lowest_rating" @if (old('order_by') == 'lowest_rating') selected @endif>{{ __('Lowest Rating') }}</option>
                                        <option value="highest_rating" @if (old('order_by') == 'highest_rating') selected @endif>{{ __('Highest Rating') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
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
        <!-- Calender Js-->
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

        <script>
            $(document).ready(function(){
                $("#report_type").on("change", function() {
                    var selec_type = $(this).val();

                    if(selec_type == 'summary'){
                        $("#treatment_date_show").css("display", "none");
                        $("#therapist_show").css("display", "block");
                        $("#month_year_show").css("display", "block");
                        $("#order_by_show").css("display", "block");
                    }else{
                        $("#treatment_date_show").css("display", "block");
                        $("#therapist_show").css("display", "none");
                        $("#month_year_show").css("display", "none");
                        $("#order_by_show").css("display", "none");
                    }
                });
            });

            var monthSelect = document.getElementById("month");
            for (var i = 1; i <= 12; i++) {
                var option = document.createElement("option");
                option.value = i < 10 ? "0" + i : "" + i;
                option.text = new Date(2000, i - 1, 1).toLocaleString('default', { month: 'long' });
                monthSelect.appendChild(option);
            }

            var yearSelect = document.getElementById("year");
            var currentYear = new Date().getFullYear();
            for (var year = currentYear; year >= currentYear - 3; year--) {
                var option = document.createElement("option");
                option.value = "" + year;
                option.text = "" + year;
                yearSelect.appendChild(option);
            }
        </script>
    @endsection
