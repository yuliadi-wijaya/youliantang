<?php $__env->startSection('title'); ?> <?php echo e(__('Appointment list')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Appointment List <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Appointment <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="PendingAppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('No.')); ?></th>
                                            <th><?php echo e(__('Therapist Name')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
                                            <th><?php echo e(__('Time')); ?></th>
                                            <th><?php echo e(__('Status')); ?></th>
                                            <th><?php echo e(__('Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(session()->has('page_limit')): ?>
                                            <?php
                                                $per_page = session()->get('page_limit');
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $per_page = Config::get('app.page_limit');
                                            ?>
                                        <?php endif; ?>
                                        <?php
                                            $currentpage = $appointment->currentPage();
                                        ?>
                                        <?php $__empty_1 = true; $__currentLoopData = $appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1 + $per_page * ($currentpage - 1)); ?></td>
                                                <td> <?php echo e($item->therapist->first_name . ' ' . $item->therapist->last_name); ?>

                                                </td>
                                                <td><?php echo e($item->appointment_date); ?></td>
                                                <td><?php echo e($item->timeSlot->from . ' to ' . $item->timeSlot->to); ?></td>
                                                <td>
                                                    <?php if($item->status == 0): ?>
                                                        <span class="badge badge-warning">Pending</span>
                                                    <?php elseif($item->status == 1 ): ?>
                                                        <span class="badge badge-success">Success</span>
                                                    <?php elseif($item->status == 2 ): ?>
                                                        <span class="badge badge-danger">Cancel</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($item->status == 0): ?>
                                                        <button type="button" class="btn btn-danger cancel"
                                                            data-id="<?php echo e($item->id); ?>">Cancel</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <p>No matching records found</p>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Showing <?php echo e($appointment->firstItem()); ?> to <?php echo e($appointment->lastItem()); ?> of
                                        <?php echo e($appointment->total()); ?> entries
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo e($appointment->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- Init js-->
        <script src="<?php echo e(URL::asset('assets/js/pages/notification.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/appointment.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/customer/customer-appointment.blade.php ENDPATH**/ ?>