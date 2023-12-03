<?php $__env->startSection('title'); ?> <?php echo e(__('Report Total Therapists')); ?> <?php $__env->stopSection(); ?>
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
            <?php $__env->slot('title'); ?> Report Total Therapists <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Reports <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Therapists <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_4'); ?> Report Total Therapists <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="<?php echo e(url('/rf-therapist-total')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Filter Total Therapists')); ?>

                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="<?php echo e(route('ex-therapist-total')); ?>" method="GET" style="display: none;">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="status" value="<?php echo e($status); ?>">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4><strong><?php echo e(__('Report Status = ') . ($status == 1 ? 'Active' : 'Non Active')); ?></strong></h4>
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
                                        <th class="no-wrap"><?php echo e(__('Therapist Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Status')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Register Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Phone Number')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Email')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Ktp')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Gender')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Place Of Birth')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Birth Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Address')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Rekening Number')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Emergency Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Emergency Contact')); ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total_therapist = 0;
                                    ?>

                                    <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $total_therapist += 1;
                                        ?>

                                        <tr>
                                            <td class="no-wrap"><?php echo e($loop->index + 1); ?></td>
                                            <td class="no-wrap"><?php echo e($row->therapist_name); ?></td>
                                            <td class="no-wrap"><?php if($row->status == 1): ?> Active <?php else: ?> Non Active <?php endif; ?></td>
                                            <td class="no-wrap"><?php echo e(date('d-m-Y', strtotime($row->register_date))); ?></td>
                                            <td class="no-wrap"><?php echo e($row->phone_number); ?></td>
                                            <td class="no-wrap"><?php echo e($row->email); ?></td>
                                            <td class="no-wrap"><?php echo e($row->ktp); ?></td>
                                            <td class="no-wrap"><?php echo e($row->gender); ?></td>
                                            <td class="no-wrap"><?php echo e($row->place_of_birth); ?></td>
                                            <td class="no-wrap"><?php echo e(date('d-m-Y', strtotime($row->birth_date))); ?></td>
                                            <td class="no-wrap"><?php echo e($row->address); ?></td>
                                            <td class="no-wrap"><?php echo e($row->rekening_number); ?></td>
                                            <td class="no-wrap"><?php echo e($row->emergency_name); ?></td>
                                            <td class="no-wrap"><?php echo e($row->emergency_contact); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="2"><?php echo e(__('Total Therapist')); ?></th>
                                        <th class="no-wrap"><?php echo e($total_therapist); ?></th>
                                        <th class="no-wrap" colspan="11">&nbsp;</th>
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

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/report/therapist/therapist-total.blade.php ENDPATH**/ ?>