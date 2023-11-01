<?php $__env->startSection('css'); ?>
<style type="text/css">
    .h-formfield-uppercase {
        text-transform: uppercase;
        &::placeholder {
            text-transform: none;
        }
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Promo Vouchers Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <?php echo e(__('Promo Vouchers Detail')); ?>

                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('promo')); ?>"><?php echo e(__('Promos')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php echo e(__('Promo Vouchers Detail')); ?>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(url('promo')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Promo List')); ?>

                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Basic Information')); ?></blockquote>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label"><?php echo e(__('Promo Name: ')); ?> </label>
                                        <?php echo e($promo->name); ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label"><?php echo e(__('Status: ')); ?> </label>
                                        <?php if($promo->status == 1): ?> 
                                            <?php echo e("Active"); ?>

                                        <?php else: ?> 
                                            <?php echo e("In Active"); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label"><?php echo e(__('Reusable Voucher ? ')); ?> </label>
                                        <?php if($promo->is_reuse_voucher == 1): ?>
                                            <?php echo e("Yes"); ?>

                                        <?php else: ?>
                                            <?php echo e("No"); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label"><?php echo e(__('Note: ')); ?> </label>
                                        <?php echo e($promo->description); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label"><?php echo e(__('Discount: ')); ?> </label>
                                        <?php if($promo->discount_type == 0): ?>
                                            <?php echo e("Rp " . number_format($promo->discount_value)); ?>

                                        <?php else: ?> 
                                            <?php echo e($promo->discount_value . "% " . "(Max: Rp " . number_format($promo->discount_max_value) . ")"); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label"><?php echo e(__('Active Period: ')); ?> </label>
                                        <?php echo e(date('d/m/Y', strtotime($promo->active_period_start)) . " - " . date('d/m/Y', strtotime($promo->active_period_end))); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <blockquote><?php echo e(__('Voucher Information')); ?></blockquote>
                        <div class="row" style="margin-bottom: 8px">
                            <div class="col-md-12 form-group">
                                <label for="" class="d-block" style="margin-bottom: 15px"><?php echo e(__("Voucher List")); ?></label>
                                <div class="btn-group voucher_list d-block">
                                    <?php if($promo->promo_vouchers): ?>
                                        <?php $__currentLoopData = $promo->promo_vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="btn btn-outline-secondary m-1"><?php echo e($item->voucher_code); ?><input type="hidden" name="voucher_list[]" value="<?php echo e($item->voucher_code); ?>"></label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/yuliadiwijaya/Documents/Freelance/You Lian tAng/youliantang/resources/views/promo/promo-vouchers.blade.php ENDPATH**/ ?>