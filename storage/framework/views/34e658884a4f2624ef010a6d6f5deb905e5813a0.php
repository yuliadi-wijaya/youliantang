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
    <?php echo e(__('Report Therapists')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Report Filter Total Therapist <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Reports <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Therapists <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_4'); ?> Report Filter Total Therapist <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Filter Details')); ?></blockquote>
                        <form action="<?php echo e(route('rs-therapist-total')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label"><?php echo e(__('Status ')); ?></label>
                                    <select class="form-control" name="status">
                                        <option value="All" <?php if(old('status') == 'All'): ?> selected <?php endif; ?>><?php echo e(__('All')); ?></option>
                                        <option value="1" <?php if(old('status') == '1'): ?> selected <?php endif; ?>><?php echo e(__('Active')); ?></option>
                                        <option value="0" <?php if(old('status') == '0'): ?> selected <?php endif; ?>><?php echo e(__('Non Active')); ?></option>
                                    </select>
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
        <!-- Calender Js-->
        <script src="<?php echo e(URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/moment/moment.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/report/therapist/filter-therapist-total.blade.php ENDPATH**/ ?>