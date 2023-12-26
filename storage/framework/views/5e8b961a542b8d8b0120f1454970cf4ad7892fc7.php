<?php $__env->startSection('css'); ?>
<!-- Datatables -->
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<style type="text/css">
    #therapistList_length label {
        display: inline-flex;
        align-items: center;
        gap: 04px;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?> <?php echo e(__('List of Therapists')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
    <!-- start page title -->
    <?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('title'); ?> Therapist List <?php $__env->endSlot(); ?>
    <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
    <?php $__env->slot('li_2'); ?> Therapists <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div></div>
            <div class="card">
                <div class="card-body">
                    <?php if($role != 'customer' && $role != 'receptionist'): ?>
                    <a href=" <?php echo e(route('therapist.create')); ?> ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i> <?php echo e(__('New Therapist')); ?>

                        </button>
                    </a>
                    <?php endif; ?>
                    <table id="therapistList" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th><?php echo e(__('No.')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Gender')); ?></th>
                                <th><?php echo e(__('Phone Number')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <?php if($role != 'customer'): ?>
                                
                                <th><?php echo e(__('Complete Transaction')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <?php endif; ?>
                                <?php if($role != 'customer'): ?>
                                <th><?php echo e(__('Option')); ?></th>
                                <?php endif; ?>
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
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
    <!-- Plugins js -->
    <script src="<?php echo e(URL::asset('assets/libs/jszip/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/pdfmake/pdfmake.min.js')); ?>"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <!-- Init js-->
    <script src="<?php echo e(URL::asset('assets/js/pages/notification.init.js')); ?>"></script>
    <script>
        //load datatable
        $(document).ready(function() {
            var role = '<?php echo e($role); ?>';
            $('#therapistList').DataTable({
                processing: true
                , serverSide: true
                , ajax: "<?php echo e(route('therapist.index')); ?>"
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
                        data: 'therapist.gender'
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
                    /*, {
                        data: 'pending_appointment'
                        , name: 'pending_appointment'
                        , orderable: false
                        , searchable: false
                        , visible: (role != 'customer') ? true : false
                    }
                    , {
                        data: 'completed_appointment'
                        , name: 'completed_appointment'
                        , orderable: false
                        , searchable: false
                        , visible: (role != 'customer') ? true : false
                    }*/
                    , {
                        data: 'completed_trans'
                        , name: 'completed_trans'
                        , orderable: false
                        , searchable: false
                        , visible: (role != 'customer') ? true : false
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

        // delete Therapist
        $(document).on('click', '#delete-therapist', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure want to delete therapist?')) {
                $.ajax({
                    type: "DELETE"
                    , url: 'therapist/' + id
                    , data: {
                        _token: '<?php echo e(csrf_token()); ?>'
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
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/therapist/therapists.blade.php ENDPATH**/ ?>