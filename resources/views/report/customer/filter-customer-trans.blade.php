@extends('layouts.master-layouts')
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
@section('title')
    {{ __('Report Customers') }}
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
            @slot('li_3') Customers @endslot
            @slot('li_4') Report Customer Transaction History @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote>{{ __('Filter Details') }}</blockquote>
                        <form action="{{ route('rs-customer-trans') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Filter Display') }}</label>
                                    <select class="form-control select2" name="filter_display" id="filter_display">
                                        <option value="daily" @if (old('filter_display') == 'daily') selected @endif>{{ __('Daily') }}</option>
                                        <option value="monthly" @if (old('filter_display') == 'monthly') selected @endif>{{ __('Monthly') }}</option>
                                        <option value="yearly" @if (old('filter_display') == 'yearly') selected @endif>{{ __('Yearly') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="daily_show">
                                <div class="col-md-2 form-group">
                                    <label class="control-label">{{ __('Treatment Date ') }}<span class="text-danger">*</span></label>
                                    <div class="input-group datepickerdiv">
                                        <input type="date" class="form-control @error('daily_date') is-invalid @enderror"
                                            name="daily_date" id="daily_date" value="{{ old('daily_date') }}"
                                            placeholder="{{ __('Select Date') }}">
                                        @error('daily_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="monthly_show" style="display: none;">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label">{{ __('Treatment Date ') }}<span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group datepickerdiv">
                                                        <select class="form-control select2 @error('month') is-invalid @enderror" id="month" name="month">
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
                                                        <select class="form-control select2 @error('year') is-invalid @enderror" id="year" name="year">
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
                            <div class="row" id="yearly_show" style="display: none;">
                                <div class="col-md-3 form-group">
                                    <label class="control-label">{{ __('Treatment Date ') }}<span class="text-danger">*</span></label>
                                    <div class="input-group datepickerdiv">
                                        <select class="form-control select2 @error('yearly_date') is-invalid @enderror" id="yearly_date" name="yearly_date">
                                            <option value="" disabled selected>Select Year</option>
                                        </select>
                                        @error('yearly_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>

        <script>
            $(document).ready(function(){
                function toggleFilterDate() {
                    var selec_type = $("#filter_display").val();

                    if (selec_type == 'daily') {
                        $("#daily_show").css("display", "block");
                        $("#monthly_show").css("display", "none");
                        $("#yearly_show").css("display", "none");
                    } else if (selec_type == 'monthly') {
                        $("#daily_show").css("display", "none");
                        $("#monthly_show").css("display", "block");
                        $("#yearly_show").css("display", "none");
                    } else if (selec_type == 'yearly') {
                        $("#daily_show").css("display", "none");
                        $("#monthly_show").css("display", "none");
                        $("#yearly_show").css("display", "block");
                    }
                }

                toggleFilterDate();

                $("#filter_display").on("change", function() {
                    toggleFilterDate();
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
            for (var year = currentYear; year >= currentYear - 24; year--) {
                var option = document.createElement("option");
                option.value = "" + year;
                option.text = "" + year;
                yearSelect.appendChild(option);
            }

            var yearSelect = document.getElementById("yearly_date");
            var currentYear = new Date().getFullYear();
            for (var year = currentYear; year >= currentYear - 24; year--) {
                var option = document.createElement("option");
                option.value = "" + year;
                option.text = "" + year;
                yearSelect.appendChild(option);
            }
        </script>
    @endsection
