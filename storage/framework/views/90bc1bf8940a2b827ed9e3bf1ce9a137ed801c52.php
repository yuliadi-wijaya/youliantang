<?php $__env->startSection('title'); ?> <?php echo e(__('Update Invoice')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Update Invoice <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Invoice <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Update Invoice <?php $__env->endSlot(); ?>
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
                        <blockquote><?php echo e(__('Invoice Details')); ?></blockquote>
                        <form class="outer-repeater" action="<?php echo e(url('invoice/' . $invoice_detail->id)); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="_method" value="PATCH" />
                            <input type="hidden" name="old_data" value="<?php echo e($invoice_detail->old_data); ?>" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Customer ')); ?><span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="customer_name" id="customer_name" tabindex="1"
                                                value="<?php echo e($invoice_detail->customer_name); ?>"
                                                placeholder="<?php echo e(__('Enter Customer Name')); ?>">
                                            <?php $__errorArgs = ['customer_name'];
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
                                            <label class="control-label"><?php echo e(__('Therapist ')); ?><span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['therapist_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="therapist_name" id="therapist_name" tabindex="1"
                                                value="<?php echo e($invoice_detail->therapist_name); ?>"
                                                placeholder="<?php echo e(__('Enter Therapist Name')); ?>">
                                            <?php $__errorArgs = ['therapist_name'];
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
                                            <label class="control-label"><?php echo e(__('Room ')); ?><span class="text-danger">*</span></label>
                                            <select class="form-control select2 <?php $__errorArgs = ['room'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="room">
                                                <option selected disabled><?php echo e(__('-- Select Room --')); ?></option>
                                                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->name); ?>" <?php if($invoice_detail->room == $item->name): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['room'];
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
                                        <div class="col-md-6">
                                            <label class="control-label"><?php echo e(__('Treatment Date ')); ?><span
                                                class="text-danger">*</span></label>
                                            <div class="input-group datepickerdiv">
                                                <input type="text"
                                                    class="form-control <?php $__errorArgs = ['treatment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="treatment_date" id="TreatmentDate" data-provide="datepicker"
                                                    data-date-autoclose="true" autocomplete="off" placeholder="<?php echo e(__('Enter Date')); ?>"
                                                    value="<?php echo e(date('d/m/Y', strtotime($invoice_detail->treatment_date))); ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                                <?php $__errorArgs = ['treatment_date'];
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
                                        <div class="col-md-3 form-group">
                                            <label class="control-label"><?php echo e(__('From ')); ?><span
                                                class="text-danger">*</span></label>
                                            <input type="time"
                                                class="form-control <?php $__errorArgs = ['treatment_time_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="treatment_time_from" id="TreatmentTimeFrom" tabindex="1"
                                                value="<?php echo e($invoice_detail->treatment_time_from); ?>">
                                            <?php $__errorArgs = ['treatment_time_from'];
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
                                        <div class="col-md-3 form-group">
                                            <label class="control-label"><?php echo e(__('To ')); ?><span
                                                class="text-danger">*</span></label>
                                            <input type="time"
                                                class="form-control <?php $__errorArgs = ['treatment_time_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="treatment_time_to" id="treatment_time_to" tabindex="1"
                                                value="<?php echo e($invoice_detail->treatment_time_to); ?>">
                                            <?php $__errorArgs = ['treatment_end'];
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
                                            <label class="control-label"><?php echo e(__('Payment Mode ')); ?><span
                                                class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['payment_mode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="payment_mode">
                                                <option selected disabled><?php echo e(__('-- Select Payment Mode --')); ?></option>
                                                <option value="Cash Payement" <?php if($invoice_detail->payment_mode == 'Cash Payement'): ?> selected <?php endif; ?>><?php echo e(__('Cash Payment')); ?> </option>
                                                <option value="Debit/Credit Card" <?php if($invoice_detail->payment_mode == 'Debit/Credit Card'): ?> selected <?php endif; ?>><?php echo e(__('Debit/Credit Card')); ?></option>
                                                <option value="QRIS" <?php if($invoice_detail->payment_mode == 'QRIS'): ?> selected <?php endif; ?>><?php echo e(__('QRIS')); ?> </option>
                                                <option value="GoPay" <?php if($invoice_detail->payment_mode == 'GoPay'): ?> selected <?php endif; ?>><?php echo e(__('GoPay')); ?> </option>
                                                <option value="OVO" <?php if($invoice_detail->payment_mode == 'OVO'): ?> selected <?php endif; ?>><?php echo e(__('OVO')); ?> </option>
                                            </select>
                                            <?php $__errorArgs = ['payment_mode'];
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
                                            <label class="control-label"><?php echo e(__('Payment Status')); ?><span
                                                class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="payment_status">
                                                <option selected disabled><?php echo e(__('-- Select Payment Status --')); ?></option>
                                                <option value="Paid" <?php if($invoice_detail->payment_status == 'Paid'): ?> selected <?php endif; ?>><?php echo e(__('Paid')); ?></option>
                                                <option value="Unpaid" <?php if($invoice_detail->payment_status == 'Unpaid'): ?> selected <?php endif; ?>><?php echo e(__('Unpaid')); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['payment_status'];
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
                                                    <textarea id="Note" name="note" tabindex="7"
                                                    class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="1"
                                                    placeholder="<?php echo e(__('Enter Note')); ?>"><?php echo e($invoice_detail->note); ?></textarea>
                                            <?php $__errorArgs = ['note'];
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
                            <br>
                            <blockquote><?php echo e(__('Invoice Summary')); ?></blockquote>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class='repeater-product mb-4'>
                                        <div data-repeater-list="invoices" class="form-group">
                                            <label><?php echo e(__('Invoice Items ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <?php $__currentLoopData = $invoice_detail->invoice_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div data-repeater-item class="mb-3 row">
                                                    <div class="col-md-5 col-6">
                                                        <input type="text" name="title" class="form-control"
                                                            placeholder="<?php echo e(__('Enter Product')); ?>" value="<?php echo e($item->title); ?>" />
                                                    </div>
                                                    <div class="col-md-5 col-6">
                                                        <input type="number" name="amount" class="form-control"
                                                            placeholder="<?php echo e(__('Enter Amount')); ?>" value="<?php echo e($item->amount); ?>" />
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <input data-repeater-delete type="button"
                                                            class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                                            value="X" />
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-primary"
                                            value="Add Item" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Update Invoice')); ?>

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
        <script>
            $('#TreatmentDate').datepicker({
                startDate: new Date(),
                format: 'dd/mm/yyyy'
            });

            $(document).ready(function() {
                $(this).find('select').each(function() {
                    if (typeof $(this).attr('id') === "undefined") {
                        // ...
                    } else {
                        $('.select2').removeAttr("id").removeAttr("data-select2-id");
                        $('.select2').select2();
                        $('.select2-container').css('width','100%');
                        $('.select2').next().next().remove();
                    }
                });
            });

            function getAmount(obj) {
                var productName = obj.getAttribute('name');
                var productVal = obj.value;

                var amountName = productName.replace('product_id', 'amount');
                var amountInput = document.querySelector('[name="' + amountName + '"]');

                if (amountInput) {
                    var parts = productVal.split('|');
                    var amount = parseFloat(parts[0]);

                    if (!isNaN(amount)) {
                        amountInput.value = amount;

                        var formattedAmount = new Intl.NumberFormat('en-US', {
                            currency: 'USD'
                        }).format(amount);

                        amountInput.value = formattedAmount;
                    } else {
                        amountInput.value = '';
                    }
                }
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/invoice/edit-invoice-old.blade.php ENDPATH**/ ?>