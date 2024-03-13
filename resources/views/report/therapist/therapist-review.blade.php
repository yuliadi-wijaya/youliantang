@extends('layouts.master-layouts')
@section('title'){{ __('Report Transactions') }}@endsection
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
    <!-- Datatables -->
    <link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" src="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@endsection
@section('body')
{{-- @php
    echo '<pre>';
    print_r($request->daily_start_date);
    echo '</pre>';die();
@endphp --}}
<body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
        <!-- start page title -->
        @component('components.breadcrumb')
            @slot('title') Therapist Review Report @endslot
            @slot('li_1') Dashboard @endslot
            @slot('li_2') Reports @endslot
            @slot('li_3') Transactions @endslot
            @slot('li_4') Revenue @endslot
        @endcomponent
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datas" class="table dt-responsive table-bordered table-striped table-color-primary" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-white" style="background-color: #2a3042">
                                <tr>
                                    <th style="width: 75px">{{ __('#') }}</th>
                                    <th>{{ __('Therapist Name') }}</th>
                                    <th>{{ __('Treatment') }}</th>
                                    <th>{{ __('Review') }}</th>
                                    <th>{{ __('Rating Total') }}</th>
                                    <th>{{ __('Rating Average') }}</th>
                                </tr>
                            </thead>
                            @php 
                                $no = 1;
                                $sum_treatment = 0;
                                $sum_reviewer = 0;
                                $sum_rating_total = 0;
                                $sum_rating_average = 0;
                            @endphp
                            <tbody>
                                @if ($reports && count($reports) > 0)
                                    @foreach ($reports as $item)
                                        <tr>
                                            <td class="text-right">{{ $no }}</td>
                                            <td>{{ $item->therapist_name}}</td>
                                            <td class="text-right">{{ number_format($item->treatment_total) }}</td>
                                            <td class="text-right">{{ number_format($item->reviewer_total) }}</td>
                                            <td class="text-right">{{ number_format($item->rating_total) }}</td>
                                            <td class="text-right">{{ number_format($item->rating_average) }}</td>
                                        </tr>
                                        @php 
                                            $no++; 
                                            $sum_treatment += $item->treatment_total;
                                            $sum_reviewer += $item->reviewer_total;
                                            $sum_rating_total += $item->rating_total;
                                            $sum_rating_average += $item->rating_average;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            @if ($reports && count($reports) > 0)
                                <tfoot class="text-white" style="background-color: #2a3042">
                                    <tr>
                                        <th class="text-right" colspan="2">TOTAL</th>
                                        <th class="text-right">{{ number_format($sum_treatment) }}</th>
                                        <th class="text-right">{{ number_format($sum_reviewer) }}</th>
                                        <th class="text-right">{{ number_format($sum_rating_total) }}</th>
                                        <th class="text-right">{{ number_format($sum_rating_average) }}</th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
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
        <!-- Datatables -->
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>

        <script>
            $(document).ready(function(){
                $('#datas').DataTable({
                    buttons: [
                        'copy',
                        {extend : 'excel', footer: true},
                        'colvis' ],
                    pagingType: 'full_numbers',
                    "drawCallback": function() {
                        $('.dataTables_paginate > .pagination').addClass('justify-content-end');
                        $('.dataTables_filter').addClass('d-flex justify-content-end');
                    }
                });
            });
        </script>
    @endsection

