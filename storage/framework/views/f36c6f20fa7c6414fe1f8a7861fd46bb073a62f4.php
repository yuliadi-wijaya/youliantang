<?php $__env->startSection('title'); ?> <?php echo e(__('List of Receptionists')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
    <!-- start page title -->
    <?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('title'); ?> Receptionist List <?php $__env->endSlot(); ?>
    <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
    <?php $__env->slot('li_2'); ?> Receptionists <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if($role == 'admin'): ?>
                    <a href=" <?php echo e(route('receptionist.create')); ?> ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i> <?php echo e(__('New Receptionist')); ?>

                        </button>
                    </a>
                    <?php endif; ?>
                    <table id="receptionList" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th><?php echo e(__('No.')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Phone Number')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Option')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php
                            $i = 1;
                            ?>
                            <?php $__currentLoopData = $receptionists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receptionist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($i++); ?></td>
                                <td>
                                    <a href="<?php echo e(url('receptionist/' . $receptionist->id)); ?> "><?php echo e($receptionist->first_name); ?>

                                        <?php echo e($receptionist->last_name); ?></a>
                                </td>
                                <td><?php echo e($receptionist->phone_number); ?></td>
                                <td><?php echo e($receptionist->email); ?></td>
                                <td>
                                    <?php if($role == 'admin'): ?>
                                    <a href="<?php echo e(url('receptionist/' . $receptionist->id)); ?>">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                    <a href="<?php echo e(url('receptionist/' . $receptionist->id . '/edit')); ?>">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Update Profile">
                                            <i class="mdi mdi-lead-pencil"></i>
                                        </button>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="Deactivate Profile" data-id="<?php echo e($receptionist->id); ?>" id="delete-receptionist">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </a>
                                    <?php elseif($role == 'therapist'): ?>
                                    <a href="<?php echo e(url('receptionist-view/' . $receptionist->id)); ?>">
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0" title="View Profile">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
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
            $('#receptionList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('receptionist.index')); ?>",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name', sortable : false, visible:true },
                    { data: 'phone_number', name: 'phone_number' },
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
                        _token: '<?php echo e(csrf_token()); ?>'
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
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/yuliadiwijaya/Documents/Freelance/You Lian tAng/youliantang/resources/views/receptionist/receptionists.blade.php ENDPATH**/ ?>