<?php $__env->startSection('title'); ?> <?php echo e(__('Dashboard')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <?php if($role == 'admin'): ?>
            <?php echo $__env->make('layouts.admin-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($role == 'therapist'): ?>
            <?php echo $__env->make('layouts.therapist-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($role == 'receptionist'): ?>
            <?php echo $__env->make('layouts.receptionist-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($role == 'customer'): ?>
            <?php echo $__env->make('layouts.customer-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- Plugin Js-->
        <script src="<?php echo e(URL::asset('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/dashboard.init.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/yuliadiwijaya/Documents/Freelance/You Lian tAng/youliantang/resources/views/index.blade.php ENDPATH**/ ?>