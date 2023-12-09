@extends('layouts.master-layouts')
@section('title') {{ __('List of Customers') }} @endsection
@section('css')
<!-- Datatables -->
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<style type="text/css">
    #customerList_length label {
        display: inline-flex;
        align-items: center;
        gap: 04px;
    }
</style>
@endsection
@section('body')

<body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
    <!-- start page title -->
    @component('components.breadcrumb')
    @slot('title') Customer List @endslot
    @slot('li_1') Dashboard @endslot
    @slot('li_2') Customers @endslot
    @endcomponent
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href=" {{ route('customer.create') }} ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i> {{ __('New Customer') }}
                        </button>
                    </a>
                    <table id="customerList" class="table table-bordered dt-responsive nowrap display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('No.') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Gender') }}</th>
                                <th>{{ __('Phone Number') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Option') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- @php
                            $i = 1;
                            @endphp
                            @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td><a href="{{ url('customer/' . $customer->id) }}">{{ $customer->first_name }}
                                        {{ $customer->last_name }}</a></td>
                                <td>{{ $customer->phone_number }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->status }}</td>
                                <td>
                                    <a href="{{ url('customer/' . $customer->id) }}">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                    <a href="{{ url('customer/' . $customer->id . '/edit') }}">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Profile">
                                            <i class="mdi mdi-lead-pencil"></i>
                                        </button>
                                    </a>
                                    <a href=" javascript:void(0)">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Profile" data-id="{{ $customer->id }}" id="delete-customer">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @endsection
    @section('script')
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <!-- Init js-->
    <script src="{{ URL::asset('assets/js/pages/notification.init.js') }}"></script>
    <script>
        // Load Datatable
        $(document).ready(function() {
            $('#customerList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name', sortable : false, visible:true },
                    { data: 'customer.gender', name: 'gender', sortable : false, visible:true },
                    { data: 'phone_number', name: 'phone_number' },
                    { data: 'email', name: 'email' },
                    { data: 'status', name: 'status' },
                    { data: 'option', name: 'option', orderable: false, searchable: false },
                ],
                pagingType: 'full_numbers',
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('justify-content-end');
                    $('.dataTables_filter').addClass('d-flex justify-content-end');
                }
            });
        });

        //delete customer
        $(document).on('click', '#delete-customer', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure want to delete this customer?')) {
                $.ajax({
                    type: "DELETE"
                    , url: 'customer/' + id
                    , data: {
                        _token: '{{ csrf_token() }}'
                        , id: id
                    , }
                    , beforeSend: function() {
                        $('#pageloader').show()
                    }
                    , success: function(response) {
                        toastr.success(response.message, 'Success Alert', {
                            timeOut: 2000
                        });
                        location.reload();
                    }
                    , error: function(response) {
                        toastr.error(response.responseJSON.message, {
                            timeOut: 20000
                        });
                    }
                    , complete: function() {
                        $('#pageloader').hide();
                    }
                });
            }
        });

    </script>
    @endsection
