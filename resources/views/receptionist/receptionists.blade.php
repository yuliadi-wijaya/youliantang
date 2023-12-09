@extends('layouts.master-layouts')
@section('css')
<!-- Datatables -->
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<style type="text/css">
    #receptionistList_length label {
        display: inline-flex;
        align-items: center;
        gap: 04px;
    }

</style>
@endsection
@section('title') {{ __('List of Receptionist') }} @endsection
@section('body')

<body data-topbar="dark" data-layout="horizontal">
    @endsection
    @section('content')
    <!-- start page title -->
    @component('components.breadcrumb')
    @slot('title') Receptionist List @endslot
    @slot('li_1') Dashboard @endslot
    @slot('li_2') Receptionist @endslot
    @endcomponent
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div></div>
            <div class="card">
                <div class="card-body">
                    @if ($role != 'customer' && $role != 'receptionist')
                    <a href=" {{ route('receptionist.create') }} ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i> {{ __('New Receptionist') }}
                        </button>
                    </a>
                    @endif
                    <table id="receptionistList" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('No.') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Gender') }}</th>
                                <th>{{ __('Phone Number') }}</th>
                                <th>{{ __('Email') }}</th>
                                @if ($role != 'customer')
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Option') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <!-- load data using yajra datatables -->
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
        //load datatable
        $(document).ready(function() {
            var role = '{{ $role }}';
            $('#receptionistList').DataTable({
                processing: true
                , serverSide: true
                , ajax: "{{ route('receptionist.index') }}"
                , columns: [{
                        data: 'DT_RowIndex'
                        , name: 'DT_RowIndex'
                        , orderable: false
                        , searchable: false
                    }
                    , {
                        data: 'name'
                        , name: 'name'
                        , sortable: false
                        , visible: true
                    }
                    , {
                        data: 'receptionist.gender'
                        , name: 'gender'
                        , sortable: false
                        , visible: true
                    }
                    , {
                        data: 'phone_number'
                        , name: 'phone_number'
                    }
                    , {
                        data: 'email'
                        , name: 'email'
                    }
                    , {
                        data: 'status'
                        , name: 'status'
                        , orderable: false
                        , searchable: false
                        , visible: (role != 'customer') ? true : false
                    }
                    , {
                        data: 'option'
                        , name: 'option'
                        , orderable: false
                        , searchable: false
                        , visible: (role != 'customer') ? true : false
                    }
                , ]
                , pagingType: 'full_numbers'
                , "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('justify-content-end');
                    $('.dataTables_filter').addClass('d-flex justify-content-end');
                }
            });
        });

        // delete Receptionist
        $(document).on('click', '#delete-receptionist', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure want to delete receptionist?')) {
                $.ajax({
                    type: "DELETE"
                    , url: 'receptionist/' + id
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
