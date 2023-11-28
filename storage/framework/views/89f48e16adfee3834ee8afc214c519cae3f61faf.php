<?php $__env->startSection('title'); ?>
    <?php echo e(__('Invoice Setting')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?>
                Invoice Setting
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?>
                Dashboard
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?>
                Setting
            <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?>
                Invoice Setting
            <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Setting Header')); ?></blockquote>
                        <form action="<?php echo e(route('update-invoice-setting')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="invoiceTitle">Invoice Type to Display <span class="text-danger">*</span></label>
                                        <select class="form-control select2 <?php $__errorArgs = ['invoice_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="invoice_type">
                                            <option value="CK" <?php if(($data->invoice_type == 'CK') || old('status') == 'CK'): ?> selected <?php endif; ?>><?php echo e(__('Checklist')); ?></option>
                                            <option value="NC" <?php if(($data->invoice_type == 'NC') || old('status') == 'NC'): ?> selected <?php endif; ?>><?php echo e(__('Non Checklist')); ?></option>
                                            <option value="ALL" <?php if(($data->invoice_type == 'ALL') || old('status') == 'ALL'): ?> selected <?php endif; ?>><?php echo e(__('ALL')); ?></option>
                                        </select>
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
                            </div>
                            <div class="row">
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

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/setting/invoice-setting.blade.php ENDPATH**/ ?>