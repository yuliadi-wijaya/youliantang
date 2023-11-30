<?php $__env->startSection('title'); ?> <?php echo e(__('Review')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Review <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Invoice <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Review <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(url('invoice')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Invoice List')); ?>

                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('review.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="old_data" value="<?php echo e($invoice->old_data); ?>" />
                            <input type="hidden" name="invoice_id" value="<?php echo e($invoice->id); ?>" />

                            <div class="row">
                                <div class="col-md-12">
                                    <blockquote><?php echo e(__('Review Header')); ?></blockquote>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label"><?php echo e(__('Customer Name ')); ?></label>
                                            <?php if($invoice->old_data == 'Y'): ?>
                                                <input type="text" class="form-control" name="customer_name" value="<?php echo e($invoice->customer_name); ?>" readonly>
                                            <?php elseif($invoice->old_data == 'N'): ?>
                                                <input type="hidden" class="form-control" name="customer_id" value="<?php echo e($invoice->customer_id); ?>" readonly>
                                                <input type="text" class="form-control" name="customer_name" value="<?php echo e($invoice->customer_name); ?>" readonly>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label"><?php echo e(__('Phone Number ')); ?></label>
                                            <?php if($invoice->old_data == 'Y'): ?>
                                                <input type="text" class="form-control" name="phone_number" value="" placeholder="Phone Number">
                                            <?php elseif($invoice->old_data == 'N'): ?>
                                                <input type="text" class="form-control" name="phone_number" value="<?php echo e($invoice->phone_number); ?>" readonly>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <blockquote><?php echo e(__('Review Details')); ?></blockquote>
                                    <?php
                                        $record = 0;
                                    ?>

                                    <?php $__currentLoopData = $invoice_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label class="control-label"><?php echo e(__('Therapist ')); ?></label>
                                                <input type="text" class="form-control" value="<?php echo e(old('therapist_name.' . $index, $row->therapist_name)); ?>" readonly>
                                                <input type="hidden" name="therapist_id[<?php echo e($index); ?>]" value="<?php echo e(old('therapist_id.' . $index, $row->therapist_id)); ?>">
                                                <input type="hidden" name="invoice_detail_id[<?php echo e($index); ?>]" value="<?php echo e(old('invoice_detail_id.' . $index, $row->id)); ?>">
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label class="control-label"><?php echo e(__('Rating ')); ?><span class="text-danger">*</span></label>
                                                <div class="star-rating" id="star-rating">
                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                        <span class="star-<?php echo e($index); ?>" data-rating="<?php echo e($i); ?>"><i class="fas fa-star" style="font-size: 20px;"></i></span>
                                                    <?php endfor; ?>
                                                </div>
                                                <input type="hidden" class="<?php $__errorArgs = ['rating.' . $index];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="rating[<?php echo e($index); ?>]" id="rating-<?php echo e($index); ?>" value="<?php echo e(old('rating.' . $index, $row->rating)); ?>">
                                                <?php $__errorArgs = ['rating.' . $index ];
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
                                            <div class="col-md-6 form-group">
                                                <label for="comment<?php echo e($index); ?>"><?php echo e(__('Comment (optional) ')); ?></label>
                                                <textarea class="form-control" name="comment[<?php echo e($index); ?>]" rows="4"><?php echo e(old('comment.' . $index, $row->comment)); ?></textarea>
                                            </div>
                                        </div>

                                        <?php
                                            $record++;
                                        ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <input type="hidden" id="record_review" value="<?php echo e($record); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Submit')); ?>

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
        <script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
        <!-- form mask -->
        <script src="<?php echo e(URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js')); ?>"></script>
        <!-- form init -->
        <script src="<?php echo e(URL::asset('assets/js/pages/form-repeater.int.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/form-advanced.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/notification.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/star-rating.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/invoice/invoice-review.blade.php ENDPATH**/ ?>