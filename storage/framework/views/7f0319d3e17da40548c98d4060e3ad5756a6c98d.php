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
    <?php if($promo): ?>
        <?php echo e(__('Update Promo Details')); ?>

    <?php else: ?>
        <?php echo e(__('Add New Promo')); ?>

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
                        <?php if($promo): ?>
                            <?php echo e(__('Update Promo Details')); ?>

                        <?php else: ?>
                            <?php echo e(__('Add New Promo')); ?>

                        <?php endif; ?>
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('promo')); ?>"><?php echo e(__('Promos')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php if($promo): ?>
                                    <?php echo e(__('Update Promo Details')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Add New Promo')); ?>

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
                        <form action="<?php if($promo ): ?> <?php echo e(url('promo/' . $promo->id)); ?> <?php else: ?> <?php echo e(route('promo.store')); ?> <?php endif; ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if($promo ): ?>
                                <input type="hidden" name="_method" value="PATCH" />
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Promo Name ')); ?><span
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
                                                value="<?php if($promo): ?><?php echo e(old('name', $promo->name)); ?><?php elseif(old('name')): ?><?php echo e(old('name')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Promo Name')); ?>">
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
                                                <option value="1" <?php if(($promo && $promo->status == '1') || old('status') == '1'): ?> selected <?php endif; ?>><?php echo e(__('Active')); ?></option>
                                                <option value="0" <?php if(($promo && $promo->status == '0') || old('status') == '0'): ?> selected <?php endif; ?>><?php echo e(__('In Active')); ?></option>
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
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Reusable Voucher ? ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['is_reuse_voucher'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="11" name="is_reuse_voucher" id="is_reuse_voucher">
                                                <option value="0" <?php if(($promo && $promo->is_reuse_voucher == '0') || old('is_reuse_voucher') == '0'): ?> selected <?php endif; ?>><?php echo e(__('No')); ?></option>
                                                <option value="1" <?php if(($promo && $promo->is_reuse_voucher == '1') || old('is_reuse_voucher') == '1'): ?> selected <?php endif; ?>><?php echo e(__('Yes')); ?></option>

                                            </select>
                                            <?php $__errorArgs = ['is_reuse_voucher'];
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
                                            <label class="control-label"><?php echo e(__('Note')); ?></label>
                                                    <textarea id="Description" name="description" tabindex="7"
                                                    class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="4"
                                                    placeholder="<?php echo e(__('Enter Note')); ?>"><?php if($promo): ?><?php echo e($promo->description); ?><?php elseif(old('description')): ?><?php echo e(old('description')); ?><?php endif; ?></textarea>
                                            <?php $__errorArgs = ['duration'];
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
                                                tabindex="11" name="discount_type" id="DiscountType">
                                                <option selected disabled><?php echo e(__('-- Select Discount Type --')); ?></option>
                                                <option value="0" <?php if(($promo && $promo->discount_type == '0') || old('discount_type') == '0'): ?> selected <?php endif; ?>><?php echo e(__('Fix Rate (Rp)')); ?></option>
                                                <option value="1" <?php if(($promo && $promo->discount_type == '1') || old('discount_type') == '1'): ?> selected <?php endif; ?>><?php echo e(__('Percentage (%)')); ?></option>
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="control-label"><?php echo e(__('Total Discount ')); ?><span
                                                        class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label discount-max-value"><?php echo e(__('Max Discount ')); ?><span
                                                        class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control <?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        tabindex="4" name="discount_value" id="DiscountValue" value="<?php if($promo ): ?><?php echo e(old('discount_value', $promo->discount_value)); ?><?php elseif(old('discount_value')): ?><?php echo e(old('discount_value')); ?><?php endif; ?>"
                                                        placeholder="<?php echo e(__('Enter Total Discount Based On Type')); ?>">
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
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control discount-max-value <?php $__errorArgs = ['discount_max_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        tabindex="4" name="discount_max_value" id="DiscountMaxValue" value="<?php if($promo ): ?><?php echo e(old('discount_max_value', $promo->discount_max_value)); ?><?php elseif(old('discount_max_value')): ?><?php echo e(old('discount_max_value')); ?><?php endif; ?>"
                                                        placeholder="<?php echo e(__('Enter Max Discount (Fix Rate)')); ?>">
                                                    <?php $__errorArgs = ['discount_max_value'];
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
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Active Period ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group datepickerdiv">
                                                        <input type="text"
                                                            class="form-control active_period <?php $__errorArgs = ['active_period_start'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="active_period_start" id="ActivePeriodStart" data-provide="datepicker"
                                                            data-date-autoclose="true" autocomplete="off"
                                                            <?php echo e(old('active_period_start', date('d/m/Y'))); ?> placeholder="<?php echo e(__('Enter Start Date')); ?>"
                                                            value="<?php if($promo ): ?><?php echo e(old('active_period_start', date('d/m/Y', strtotime($promo->active_period_start)))); ?><?php elseif(old('active_period_start')): ?><?php echo e(old('active_period_start')); ?><?php endif; ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        <?php $__errorArgs = ['active_period_start'];
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
                                                            class="form-control active_period <?php $__errorArgs = ['active_period_end'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="active_period_end" id="ActivePeriodEnd" data-provide="datepicker"
                                                            data-date-autoclose="true" autocomplete="off"
                                                            <?php echo e(old('active_period_end', date('d/m/Y'))); ?> placeholder="<?php echo e(__('Enter End Date')); ?>"
                                                            value="<?php if($promo ): ?><?php echo e(old('active_period_end', date('d/m/Y', strtotime($promo->active_period_end)))); ?><?php elseif(old('active_period_end')): ?><?php echo e(old('active_period_end')); ?><?php endif; ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                        </div>
                                                        <?php $__errorArgs = ['active_period_end'];
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
                            <br />
                            <blockquote><?php echo e(__('Voucher Information')); ?></blockquote>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label"><?php echo e(__('Filter ')); ?><span
                                        class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <input type="number"
                                                class="form-control"
                                                name="voucher_total" id="VoucherTotal" tabindex="1"
                                                value="<?php echo e(old('voucher_total')); ?>"
                                                placeholder="<?php echo e(__('Enter Total Voucher Will Be Generated')); ?>">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <input type="text"
                                                class="form-control text-uppercase h-formfield-uppercase"
                                                name="voucher_prefix" id="VoucherPrefix" tabindex="1"
                                                value="<?php echo e(old('voucher_prefix')); ?>"
                                                placeholder="<?php echo e(__('Enter Prefix Voucher')); ?>">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <input type="hidden" id="IsGenerated" name="is_generated" value="0">
                                            <button type="button" id="GenerateVoucher" class="btn btn-primary"><?php echo e(__('Generate Voucher')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 8px">
                                <div class="col-md-12 form-group">
                                    <label for="" class="d-block" style="margin-bottom: 15px"><?php echo e(__("Voucher List")); ?><span
                                            class="text-danger">*</span> <span style="font-size: 8pt; font-style: italic;"><?php echo e(__("(will be generated automatically after click the generate voucher button)")); ?></span></label>
                                    <div class="btn-group voucher_list d-block">
                                        <?php if($promo != null && $promo->promo_vouchers): ?>
                                            <?php $__currentLoopData = $promo->promo_vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="btn btn-outline-secondary m-1"><?php echo e($item->voucher_code); ?><input type="hidden" name="voucher_list[]" value="<?php echo e($item->voucher_code); ?>"></label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <?php $__errorArgs = ['voucher_list'];
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
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php if($promo): ?>
                                            <?php echo e(__('Update Promo Details')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Add New Promo')); ?>

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
        <!-- Calender Js-->
        <script src="<?php echo e(URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/moment/moment.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.js')); ?>"></script>
        <script>
            $(document).ready(function() {
                if ($("#DiscountType").val() == 0) {
                    $("#DiscountMaxValue").val('');
                    $(".discount-max-value").fadeOut();
                } else {
                    $(".discount-max-value").fadeIn();
                }
            });

            $(document).on('change', '#DiscountType', function() {
                if ($(this).val() != undefined) {
                    if ($(this).val() == 0) {
                        $("#DiscountMaxValue").val('');
                        $(".discount-max-value").fadeOut();
                    } else {
                        $(".discount-max-value").fadeIn();
                    }
                }
            });
            // Script
            $('.active_period').datepicker({
                startDate: new Date(),
                format: 'dd/mm/yyyy'
            });

            $(document).on('click', '#GenerateVoucher', function() {
                var voucherTotal = $('#VoucherTotal').val();
                var voucherPrefix = $('#VoucherPrefix').val();

                if (!voucherTotal || !voucherPrefix) {
                    alert('Input filters are required.');
                    return
                }

                today = new Date();

                $('.voucher_list').html('');
                for(var i = 1; i <= voucherTotal; i++) {
                    voucherGeneratedText = voucherPrefix.replaceAll(/\s/g,'').toUpperCase() + today.getFullYear() + today.getMonth() + today.getDate() + i.toString().padStart(3, '0')
                    //$('.voucher_list').append('<div class="d-inline p-2 bg-success text-white font-weight-bold">' + voucherGeneratedText + '</div>');
                    $('.voucher_list').append('<label class="btn btn-outline-secondary m-1">' + voucherGeneratedText + '<input type="hidden" name="voucher_list[]" value="' + voucherGeneratedText + '"></label>');
                }

                $('#IsGenerated').val(1);
            });

            $(document).on('change', '#is_reuse_voucher', function() {
                if ($(this).val() == 1) {
                    $('#VoucherTotal').val('1');
                    $('#VoucherTotal').prop('readonly', true);
                } else {
                    $('#VoucherTotal').val('');
                    $('#VoucherTotal').prop('readonly', false);
                }
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/promo/promo-details.blade.php ENDPATH**/ ?>