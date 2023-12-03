<?php $__env->startSection('title'); ?> <?php echo e(__('Report Customer Registration')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <style>
        .no-wrap {
            white-space: nowrap;
        }
    </style>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Report Customer Registration <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Reports <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Customers <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_4'); ?> Report Customer Registration <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="<?php echo e(url('/rf-customer-reg')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Filter Customer Registration')); ?>

                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="<?php echo e(route('ex-customer-reg')); ?>" method="GET" style="display: none;">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="dateFrom" value="<?php echo e($dateFrom); ?>">
                    <input type="hidden" name="dateTo" value="<?php echo e($dateTo); ?>">
                    <input type="hidden" name="is_member" value="<?php echo e($is_member); ?>">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4><strong><?php echo e(__('Report') . ' ' . date('d M Y', strtotime($dateFrom)) . ' - ' . date('d M Y', strtotime($dateTo))); ?></strong></h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                        </div>
                        <div class="table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-wrap"><?php echo e(__('No')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Customer Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Phone Number')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Email')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Register Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Place Of Birth')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Birth Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Gender')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Address')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Emergency Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Emergency Contact')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Customer Status')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Is Member')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Member Plan')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Member Status')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Start Member')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Expired Date')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total_customer = 0;
                                        $total_member = 0;
                                    ?>

                                    <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $total_customer += 1;
                                            if ($row->is_member == 1) $total_member += 1;
                                        ?>

                                        <tr>
                                            <td class="no-wrap"><?php echo e($loop->index + 1); ?></td>
                                            <td class="no-wrap"><?php echo e($row->customer_name); ?></td>
                                            <td class="no-wrap"><?php echo e($row->phone_number); ?></td>
                                            <td class="no-wrap"><?php echo e($row->email); ?></td>
                                            <td class="no-wrap"><?php echo e(date('d-m-Y', strtotime($row->register_date))); ?></td>
                                            <td class="no-wrap"><?php echo e($row->place_of_birth); ?></td>
                                            <td class="no-wrap"><?php echo e(date('d-m-Y', strtotime($row->birth_date))); ?></td>
                                            <td class="no-wrap"><?php echo e($row->gender); ?></td>
                                            <td class="no-wrap"><?php echo e($row->address); ?></td>
                                            <td class="no-wrap"><?php echo e($row->emergency_name); ?></td>
                                            <td class="no-wrap"><?php echo e($row->emergency_contact); ?></td>
                                            <td class="no-wrap"><?php echo e($row->customer_status); ?></td>
                                            <td class="no-wrap"><?php if($row->is_member == 1): ?> Yes <?php else: ?> No <?php endif; ?></td>
                                            <td class="no-wrap"><?php echo e($row->member_plan); ?></td>
                                            <td class="no-wrap"><?php echo e($row->member_status); ?></td>
                                            <td class="no-wrap"><?php echo e($row->start_member); ?></td>
                                            <td class="no-wrap"><?php echo e(date('d-m-Y', strtotime($row->expired_date))); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="2"><?php echo e(__('Total Customer')); ?></th>
                                        <th class="no-wrap"><?php echo e($total_customer); ?></th>
                                        <th class="no-wrap" colspan="14">&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <th class="no-wrap" colspan="2"><?php echo e(__('Total Member')); ?></th>
                                        <th class="no-wrap"><?php echo e($total_member); ?></th>
                                        <th class="no-wrap" colspan="14">&nbsp;</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/report/customer/customer-reg.blade.php ENDPATH**/ ?>