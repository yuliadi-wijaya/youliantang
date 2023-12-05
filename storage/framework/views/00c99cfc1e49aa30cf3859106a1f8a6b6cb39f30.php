<?php $__env->startSection('title'); ?><?php echo e(__('Report Therapists')); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">
        .h-formfield-uppercase {
            text-transform: uppercase;
            &::placeholder {
                text-transform: none;
            }
        }

    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Report Filter Customer Transaction History <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Reports <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Therapists <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_4'); ?> Report Customer Transaction History <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Filter Details')); ?></blockquote>
                        <form action="<?php echo e(route('rs-therapist-trans')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="control-label"><?php echo e(__('Report Type')); ?></label>
                                    <select class="form-control select2" name="report_type" id="report_type">
                                        <option value="detail" <?php if(old('report_type') == 'detail'): ?> selected <?php endif; ?>><?php echo e(__('Detail')); ?></option>
                                        <option value="summary" <?php if(old('report_type') == 'summary'): ?> selected <?php endif; ?>><?php echo e(__('Summary')); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="treatment_date_show" style="display: block;">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Treatment Date ')); ?><span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group datepickerdiv">
                                                        <input type="text"
                                                            class="form-control <?php $__errorArgs = ['date_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="date_from" id="date_from" data-provide="datepicker"
                                                            data-date-autoclose="true" autocomplete="off"
                                                            <?php echo e(old('date_from', date('Y-m-d'))); ?> placeholder="<?php echo e(__('Enter Date From')); ?>"
                                                            value="<?php echo e(old('date_from')); ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        <?php $__errorArgs = ['date_from'];
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
                                                <div class="col-md-6">
                                                    <div class="input-group datepickerdiv">
                                                        <input type="text"
                                                            class="form-control <?php $__errorArgs = ['date_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="date_to" id="date_to" data-provide="datepicker"
                                                            data-date-autoclose="true" autocomplete="off"
                                                            <?php echo e(old('date_to', date('Y-m-d'))); ?> placeholder="<?php echo e(__('Enter Date To')); ?>"
                                                            value="<?php echo e(old('date_to')); ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        <?php $__errorArgs = ['date_to'];
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
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="therapist_show" style="display: none;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label"><?php echo e(__('Select Therapist')); ?></label>
                                    <select class="form-control select2" name="therapist_id" id="therapist_id">
                                        <option value="all" <?php if(old('therapist_id') == 'therapist '): ?> selected <?php endif; ?>><?php echo e(__('All Therapist')); ?></option>
                                        <?php $__currentLoopData = $therapists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($row->id); ?>" <?php echo e(old('therapist_id') == $row->id ? 'selected' : ''); ?>><?php echo e($row->therapist_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="month_year_show" style="display: none;">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Treatment Date ')); ?><span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group datepickerdiv">
                                                        <select class="custom-select" id="month" name="month" required oninvalid="setCustomValidity('Please select a month')" oninput="setCustomValidity('')">
                                                            <option value="" disabled selected>Select Month</option>
                                                        </select>
                                                        <?php $__errorArgs = ['month'];
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
                                                <div class="col-md-3">
                                                    <div class="input-group datepickerdiv">
                                                        <select class="custom-select" id="year" name="year" required oninvalid="setCustomValidity('Please select a year')" oninput="setCustomValidity('')">
                                                            <option value="" disabled selected>Select Year</option>
                                                        </select>
                                                        <?php $__errorArgs = ['year'];
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
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="order_by_show" style="display: none;">
                                <div class="col-md-4 form-group">
                                    <label class="control-label"><?php echo e(__('Order By')); ?></label>
                                    <select class="form-control select2" name="order_by">
                                        <option value="therapist" <?php if(old('order_by') == 'therapist '): ?> selected <?php endif; ?>><?php echo e(__('Therapist Name')); ?></option>
                                        <option value="lowest_rating" <?php if(old('order_by') == 'lowest_rating'): ?> selected <?php endif; ?>><?php echo e(__('Lowest Rating')); ?></option>
                                        <option value="highest_rating" <?php if(old('order_by') == 'highest_rating'): ?> selected <?php endif; ?>><?php echo e(__('Highest Rating')); ?></option>
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
        <script src="<?php echo e(URL::asset('assets/js/pages/form-advanced.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>

        <script>
            $(document).ready(function(){
                $("#report_type").on("change", function() {
                    var selec_type = $(this).val();

                    if(selec_type == 'summary'){
                        $("#treatment_date_show").css("display", "none");
                        $("#therapist_show").css("display", "block");
                        $("#month_year_show").css("display", "block");
                        $("#order_by_show").css("display", "block");
                    }else{
                        $("#treatment_date_show").css("display", "block");
                        $("#therapist_show").css("display", "none");
                        $("#month_year_show").css("display", "none");
                        $("#order_by_show").css("display", "none");
                    }
                });
            });

            var monthSelect = document.getElementById("month");
            for (var i = 1; i <= 12; i++) {
                var option = document.createElement("option");
                option.value = i < 10 ? "0" + i : "" + i;
                option.text = new Date(2000, i - 1, 1).toLocaleString('default', { month: 'long' });
                monthSelect.appendChild(option);
            }

            var yearSelect = document.getElementById("year");
            var currentYear = new Date().getFullYear();
            for (var year = currentYear; year >= currentYear - 3; year--) {
                var option = document.createElement("option");
                option.value = "" + year;
                option.text = "" + year;
                yearSelect.appendChild(option);
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/report/therapist/filter-therapist-trans.blade.php ENDPATH**/ ?>