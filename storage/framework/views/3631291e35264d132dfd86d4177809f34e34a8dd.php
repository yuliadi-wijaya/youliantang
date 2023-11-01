
<?php $__env->startSection('title'); ?> <?php echo e(__('Book Appointment')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- Calender -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/fullcalendar/fullcalendar.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Book Appointment <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Appointment <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(url('/appointment-create')); ?>"
                    class="btn btn-primary text-white waves-effect waves-light mb-4">
                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i> <?php echo e(__('New Appointment')); ?>

                </a>
            </div> <!-- end col -->
        </div> <!-- end row -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div> <!-- end col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><?php echo e(__('Appointment List')); ?> | <label
                                id="selected_date"><?php echo date('d M, Y'); ?></label>
                        </h4>
                        <div id="appointment_list">
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th><?php echo e(__('No.')); ?></th>
                                        <?php if($role == 'customer'): ?>
                                            <th><?php echo e(__('Therapist Name')); ?></th>
                                            <th><?php echo e(__('Therapist Number')); ?></th>
                                        <?php elseif($role == 'therapist'): ?>
                                            <th><?php echo e(__('Customer Name')); ?></th>
                                            <th><?php echo e(__('Customer Number')); ?></th>
                                        <?php else: ?>
                                            <th><?php echo e(__('Customer Name')); ?></th>
                                            <th><?php echo e(__('Therapist Name')); ?></th>
                                            <th><?php echo e(__('Customer Number')); ?></th>

                                        <?php endif; ?>
                                        <th><?php echo e(__('Time')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                    ?>
                                    <?php if($role == 'receptionist'): ?>
                                        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($i); ?> </td>
                                                <td><?php echo e($appointment->customer->first_name . ' ' . $appointment->customer->last_name); ?>

                                                </td>
                                                <td><?php echo e($appointment->therapist->first_name . ' ' . $appointment->therapist->last_name); ?>

                                                </td>
                                                <td><?php echo e($appointment->customer->mobile); ?></td>
                                                <td>
                                                    <?php echo e($appointment->timeSlot->from . ' to ' . $appointment->timeSlot->to); ?>

                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif($role == 'therapist'): ?>
                                        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($i); ?> </td>
                                                <td><?php echo e($appointment->customer->first_name . ' ' . $appointment->customer->last_name); ?>

                                                </td>
                                                <td><?php echo e($appointment->customer->mobile); ?></td>
                                                <td>
                                                    <?php echo e($appointment->timeSlot->from . ' to ' . $appointment->timeSlot->to); ?>

                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif($role == 'customer'): ?>
                                        <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e($i); ?> </td>
                                                <td><?php echo e($appointment->therapist->first_name . ' ' . $appointment->therapist->last_name); ?>

                                                </td>
                                                <td><?php echo e($appointment->therapist->mobile); ?></td>
                                                <td>
                                                    <?php echo e($appointment->timeSlot->from . ' to ' . $appointment->timeSlot->to); ?>

                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="new_list" style="display : none"></div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- Calender Js-->
        <script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/moment/moment.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/fullcalendar/fullcalendar.min.js')); ?>"></script>
        <!-- Get App url in Javascript file -->
        <script type="text/javascript">
            var aplist_url = "<?php echo e(url('appointmentList')); ?>";
        </script>
        <!-- Init js-->
        <script src="<?php echo e(URL::asset('assets/js/pages/calendar-init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/form-advanced.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/appointment.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/appointment/appointment.blade.php ENDPATH**/ ?>