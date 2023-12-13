<?php $__env->startSection('css'); ?>
<!-- Datatables -->
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" src="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<style type="text/css">

    #invoiceList_length label {
        display: inline-flex;
        align-items: center;
        gap: 04px;
    }

    #invoiceList_wrapper {
        margin-top: 0; /* Adjust the top margin as needed */
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?> <?php echo e(__('List of Invoices')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
    <!-- start page title -->
    <?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('title'); ?> Invoice List <?php $__env->endSlot(); ?>
    <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
    <?php $__env->slot('li_2'); ?> Invoices <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div></div>
            <div class="card">
                <div class="card-body">
                    <?php if($role != 'customer'): ?>
                    <a href=" <?php echo e(route('invoice.create')); ?> ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i>
                            <?php echo e(__('Create New Invoice')); ?>

                        </button>
                    </a>
                    <?php endif; ?>
                    <table id="invoiceList" class="table table-bordered dt-responsive nowrap display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th><?php echo e(__('No.')); ?></th>
                                <th><?php echo e(__('Invoice No')); ?></th>
                                <th><?php echo e(__('Customer Name')); ?></th>
                                <th><?php echo e(__('Therapist Name')); ?></th>
                                <th><?php echo e(__('Room')); ?></th>
                                <th><?php echo e(__('Treatment Date')); ?></th>
                                <th><?php echo e(__('Rating')); ?></th>
                                <th><?php echo e(__('Option')); ?></th>
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
            $('#invoiceList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?php echo e(route('invoice.index')); ?>",
                    dataSrc: function (json) {
                        json.data.forEach(function(row) {
                            row.therapist_name = row.therapist_name.replace(/,/g, '<br>');
                            row.room = row.room.replace(/,/g, '<br>');

                            if (row.rating !== '') {
                                var ratings = row.rating.split(',').map(function (rating) {

                                    console.log(ratings);
                                    var stars = '';
                                    for (var i = 1; i <= parseInt(rating, 10); i++) {
                                        stars += '<span class="star" data-rating="' + i + '"><i class="fas fa-star" style="font-size: 15px; color: orange"></i></span>';
                                        console.log(stars);
                                    }
                                    return stars;
                                });

                                row.rating = ratings.join('<br>');
                            }

                        });
                        return json.data;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'invoice_code', name: 'invoice_code' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'therapist_name', name: 'therapist_name', searchable: false },
                    { data: 'room', name: 'room', searchable: false },
                    { data: 'treatment_date', name: 'treatment_date', searchable: false },
                    { data: 'rating', name: 'rating', searchable: false },
                    { data: 'option', name: 'option', orderable: false, searchable: false, visible: (role == 'admin' || role === 'receptionist') ? true : false },
                ],
                pagingType: 'full_numbers',
                scrollX: true,
                autoWidth: false,
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass('justify-content-end');
                    $('.dataTables_filter').addClass('d-flex justify-content-end');
                }
            });
        });
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/invoice/invoices.blade.php ENDPATH**/ ?>