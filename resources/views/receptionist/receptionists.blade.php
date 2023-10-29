@extends('layouts.master-layouts')
@section('title') {{ __('List of Receptionists') }} @endsection
@section('css')
<!-- Datatables -->
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<style type="text/css">
    #receptionList_length label {
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
    @slot('title') Receptionist List @endslot
    @slot('li_1') Dashboard @endslot
    @slot('li_2') Receptionists @endslot
    @endcomponent
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($role == 'admin')
                    <a href=" {{ route('receptionist.create') }} ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i> {{ __('New Receptionist') }}
                        </button>
                    </a>
                    @endif
                    <table id="receptionList" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('Sr. No') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Contact No') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Option') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- @php
                            $i = 1;
                            @endphp
                            @foreach ($receptionists as $receptionist)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <a href="{{ url('receptionist/' . $receptionist->id) }} ">{{ $receptionist->first_name }}
                                        {{ $receptionist->last_name }}</a>
                                </td>
                                <td>{{ $receptionist->mobile }}</td>
                                <td>{{ $receptionist->email }}</td>
                                <td>
                                    @if ($role == 'admin')
                                    <a href="{{ url('receptionist/' . $receptionist->id) }}">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                    <a href="{{ url('receptionist/' . $receptionist->id . '/edit') }}">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Profile">
                                            <i class="mdi mdi-lead-pencil"></i>
                                        </button>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Profile" data-id="{{ $receptionist->id }}" id="delete-receptionist">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </a>
                                    @elseif($role == 'doctor')
                                    <a href="{{ url('receptionist-view/' . $receptionist->id) }}">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                    @endif
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
    //load datatable 
        $(document).ready(function() {
            $('#receptionList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('receptionist.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name', sortable : false, visible:true },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'email', name: 'email' },
                    { data: 'option', name: 'option', orderable: false, searchable: false },
                ],
                pagingType: 'full_numbers',
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('justify-content-end');
                    $('.dataTables_filter').addClass('d-flex justify-content-end');
                }
            });
        });
        
        // Delete Prescription
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
                            timeOut: 1000
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
