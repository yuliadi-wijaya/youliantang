<?php $__env->startSection('title'); ?>
    <?php if($membership): ?>
        <?php echo e(__('Update Membership Details')); ?>

    <?php else: ?>
        <?php echo e(__('Add New Membership')); ?>

    <?php endif; ?>
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
                        <?php if($membership): ?>
                            <?php echo e(__('Update Membership Details')); ?>

                        <?php else: ?>
                            <?php echo e(__('Add New Membership')); ?>

                        <?php endif; ?>
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('membership')); ?>"><?php echo e(__('Memberships')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php if($membership): ?>
                                    <?php echo e(__('Update Membership Details')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Add New Membership')); ?>

                                <?php endif; ?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(url('membership')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Membership List')); ?>

                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Basic Information')); ?></blockquote>
                        <form action="<?php if($membership ): ?> <?php echo e(url('membership/' . $membership->id)); ?> <?php else: ?> <?php echo e(route('membership.store')); ?> <?php endif; ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if($membership ): ?>
                                <input type="hidden" name="_method" value="PATCH" />
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Membership Name ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="name" id="Name" tabindex="1"
                                                value="<?php if($membership): ?><?php echo e(old('name', $membership->name)); ?><?php elseif(old('name')): ?><?php echo e(old('name')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Membership Name')); ?>">
                                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Total Active Period (days)')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['total_active_period'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="total_active_period" id="TotalActivePeriod" tabindex="1"
                                                value="<?php if($membership): ?><?php echo e(old('total_active_period', $membership->total_active_period)); ?><?php elseif(old('total_active_period')): ?><?php echo e(old('total_active_period')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Total Active Period of Membership In Days')); ?>">
                                            <?php $__errorArgs = ['total_active_period'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Status ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="11" name="status">
                                                <option selected disabled><?php echo e(__('-- Select Status --')); ?></option>
                                                <option value="1" <?php if(($membership && $membership->status == '1') || old('status') == '1'): ?> selected <?php endif; ?>><?php echo e(__('Active')); ?></option>
                                                <option value="0" <?php if(($membership && $membership->status == '0') || old('status') == '0'): ?> selected <?php endif; ?>><?php echo e(__('In Active')); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Discount Type ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['discount_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="11" name="discount_type">
                                                <option selected disabled><?php echo e(__('-- Select Discount Type --')); ?></option>
                                                <option value="0" <?php if(($membership && $membership->discount_type == '0') || old('discount_type') == '0'): ?> selected <?php endif; ?>><?php echo e(__('Fix Rate (Rp)')); ?></option>
                                                <option value="1" <?php if(($membership && $membership->discount_type == '1') || old('discount_type') == '1'): ?> selected <?php endif; ?>><?php echo e(__('Percentage (%)')); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['discount_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Total Discount ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="4" name="discount_value" id="DiscountValue" value="<?php if($membership ): ?><?php echo e(old('discount_value', $membership->discount_value)); ?><?php elseif(old('discount_value')): ?><?php echo e(old('discount_value')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Total Discount Based On Discount Type')); ?>">
                                            <?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php if($membership): ?>
                                            <?php echo e(__('Update Membership Details')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Add New Membership')); ?>

                                        <?php endif; ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script>
            // Script
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/yuliadiwijaya/Documents/Freelance/You Lian tAng/youliantang/resources/views/membership/membership-details.blade.php ENDPATH**/ ?>