
<?php $__env->startSection('title'); ?>
    <?php echo e(__('App Setting')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?>
                App Setting
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?>
                Dashboard
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?>
                Setting
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?>
                App Setting
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Setting Details')); ?></blockquote>
                        <form action="<?php echo e(route('update-setting')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appTitle">App Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="appTitle" value="<?php echo e(@$data->title); ?>" name="title">
                                        <small id="appTitleHelp" class="form-text text-muted">Please Enter minimum 5 or maximum 40 caracters.</small>
                                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo Small</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_sm">
                                        <small class="form-text text-muted">Please Enter only .png files, a good looking logo dimensions are 64x75.</small>
                                        <?php $__errorArgs = ['logo_sm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Logo Large</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_lg">
                                        <small class="form-text text-muted">Please Enter only .png files, a good looking logo dimensions are 440x75.</small>
                                        <?php $__errorArgs = ['logo_lg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Dark Logo Small</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_dark_sm">
                                        <small class="form-text text-muted">Please Enter only .png files, a good looking logo dimensions are 64x75.</small>
                                        <?php $__errorArgs = ['logo_dark_sm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appLogo">Dark Logo Large</label>
                                        <input type="file" class="form-control" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" value="" name="logo_dark_lg">
                                        <small class="form-text text-muted">Please Enter only .png files, a good looking logo dimensions are 440x75.</small>
                                        <?php $__errorArgs = ['logo_dark_lg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="appFavicon">Favicon</label>
                                        <input type="file" class="form-control" id="appFavicon" data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" name="favicon">
                                        <small class="form-text text-muted">Please Enter only jpg, png, svg, ico files, a good looking icon dimensions are 128x128.</small>
                                        <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <blockquote><?php echo e(__('Footer Details')); ?></blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="footerLeft">Footer Left <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="footerLeft" name="footer_left" value="<?php echo e(@$data->footer_left); ?>">
                                        <small class="form-text text-muted">Please Enter minimum 5 or maximum 40 caracters.</small>
                                        <?php $__errorArgs = ['footer_left'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="footerRight">Footer Right <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="footerRight" name="footer_right" value="<?php echo e(@$data->footer_right); ?>">
                                        <small class="form-text text-muted">Please Enter minimum 5 or maximum 80 caracters.</small>
                                        <?php $__errorArgs = ['footer_right'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/yuliadiwijaya/Documents/Freelance/You Lian tAng/youliantang/resources/views/setting/setting.blade.php ENDPATH**/ ?>