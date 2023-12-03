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
@endsection
@section('title')
    {{ __('Report Therapists') }}
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
                                    <select class="form-control" name="report_type" id="report_type">
                                        <option value="detail" @if (old('report_type') == 'detail') selected @endif>{{ __('Detail') }}</option>
                                        <option value="summary" @if (old('report_type') == 'summary') selected @endif>{{ __('Summary') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="treatment_date" style="display: block;">
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
                            <div class="row" id="order_by" style="display: none;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label">{{ __('Order By') }}</label>
                                    <select class="form-control" name="order_by">
                                        <option value="therapist " @if (old('order_by') == 'therapist ') selected @endif>{{ __('Therapist Name') }}</option>
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
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script>
            $(document).ready(function(){
                $("#report_type").on("change", function() {
                    var selec_type = $(this).val();

                    if(selec_type == 'summary'){
                        $("#treatment_date").css("display", "none");
                        $("#order_by").css("display", "block");
                    }else{
                        $("#treatment_date").css("display", "block");
                        $("#order_by").css("display", "none");
                    }
                });
            });

        </script>
    @endsection
