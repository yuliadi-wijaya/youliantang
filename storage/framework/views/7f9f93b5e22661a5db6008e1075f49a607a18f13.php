
<?php $__env->startSection('title'); ?> <?php echo e(__('Create New Invoice')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Create Invoice <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Invoice <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Create Invoice <?php $__env->endSlot(); ?>
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
                        <blockquote><?php echo e(__('Invoice Header')); ?></blockquote>
                        <form class="outer-repeater" action="<?php echo e(route('invoice.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="old_data" value="N">
                            <input type="hidden" name="is_member" id="is_member">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Invoice Code ')); ?></label>
                                            <input type="text" class="form-control" placeholder="<?php echo e(__('Auto generated')); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 form-group">
                                            <label class="control-label"><?php echo e(__('Customer ')); ?><span class="text-danger">*</span></label>
                                            <select class="form-control select2 <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="customer_id" id="customer_id" onchange="getMember()">
                                                <option selected disabled><?php echo e(__('-- Select Customer --')); ?></option>
                                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($row->id); ?>"
                                                        data-member="<?php echo e($row->is_member); ?>"
                                                        data-member_plan="<?php echo e($row->member_plan); ?>"
                                                        data-discount_type="<?php echo e($row->discount_type); ?>"
                                                        data-discount_value="<?php echo e($row->discount_value); ?>"
                                                        <?php echo e(old('customer_id') == $row->id ? 'selected' : ''); ?>><?php echo e($row->phone_number.' - '.$row->first_name.' '.$row->last_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['customer_id'];
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
                                        <div class="col-md-2 form-group">
                                            <label class="control-label">&nbsp;</label>
                                            <a href="<?php echo e(url('invoice-customer-create')); ?>">
                                                <button type="button" class="form-control btn-primary" title="Add Customers">
                                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row">
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
                                                <option value="Cash Payement" <?php if(old('payment_mode') == 'Cash Payement'): ?> selected <?php endif; ?>><?php echo e(__('Cash Payment')); ?> </option>
                                                <option value="Debit/Credit Card" <?php if(old('payment_mode') == 'Debit/Credit Card'): ?> selected <?php endif; ?>><?php echo e(__('Debit/Credit Card')); ?></option>
                                                <option value="QRIS" <?php if(old('payment_mode') == 'QRIS'): ?> selected <?php endif; ?>><?php echo e(__('QRIS')); ?> </option>
                                                <option value="GoPay" <?php if(old('payment_mode') == 'GoPay'): ?> selected <?php endif; ?>><?php echo e(__('GoPay')); ?> </option>
                                                <option value="OVO" <?php if(old('payment_mode') == 'OVO'): ?> selected <?php endif; ?>><?php echo e(__('OVO')); ?> </option>
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
                                                <option value="Paid" <?php if(old('payment_status') == 'Paid'): ?> selected <?php endif; ?>><?php echo e(__('Paid')); ?></option>
                                                <option value="Unpaid" <?php if(old('payment_status') == 'Unpaid'): ?> selected <?php endif; ?>><?php echo e(__('Unpaid')); ?></option>
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
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Treatment Date ')); ?><span class="text-danger">*</span></label>
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
                                                    name="treatment_date" placeholder="<?php echo e(__('Enter Date')); ?>"
                                                    value="<?php echo e(now()->format('Y-m-d')); ?>" readonly>
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Note')); ?></label>
                                            <textarea id="Note" name="note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="4" placeholder="<?php echo e(__('Enter Note')); ?>"><?php echo e(old('note')); ?></textarea>
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
                            <blockquote><?php echo e(__('Invoice Detail')); ?></blockquote>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="repeater-product mb-4">
                                        <div data-repeater-list="invoices" class="form-group">
                                            <?php $__currentLoopData = old('invoices', [0 => []]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div data-repeater-item class="mb-12 row" style="border-bottom: 3px solid #f8f8fb; margin-top: 15px;">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-12 form-group">
                                                                <label class="control-label"><?php echo e(__('Product ')); ?><span class="text-danger">*</span></label>
                                                                <select class="form-control select2 <?php $__errorArgs = ['invoices.' . $index . '.product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                    name="invoices[<?php echo e($index); ?>][product_id]"
                                                                    id="product_id"
                                                                    onchange="getAmount(this)">
                                                                    <option selected disabled><?php echo e(__('-- Select Product --')); ?></option>
                                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($row->id); ?>" data-price="<?php echo e($row->price); ?>" data-duration="<?php echo e($row->duration); ?>" data-fee="<?php echo e($row->commission_fee); ?>" <?php echo e(old('invoices.' . $index . '.product_id') == $row->id ? 'selected' : ''); ?>>
                                                                            <?php echo e($row->name); ?> - Rp. <?php echo e(number_format($row->price)); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <?php $__errorArgs = ['invoices.' . $index . '.product_id'];
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
                                                                <select class="form-control select2 <?php $__errorArgs = ['invoices.' . $index . '.therapist_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="invoices[<?php echo e($index); ?>][therapist_id]">
                                                                    <option selected disabled><?php echo e(__('-- Select Therapist --')); ?></option>
                                                                    <?php $__currentLoopData = $therapists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($row->id); ?>" <?php echo e(old('invoices.' . $index . '.therapist_id') == $row->id ? 'selected' : ''); ?>><?php echo e($row->first_name.' '.$row->last_name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <?php $__errorArgs = ['invoices.' . $index . '.therapist_id'];
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
                                                            <div class="col-md-4 form-group">
                                                                <label class="control-label"><?php echo e(__('Price ')); ?><span class="text-info"><?php echo e(__('(Auto-Fill)')); ?></span></label>
                                                                <input type="text" name="invoices[<?php echo e($index); ?>][amount]" class="form-control" value="<?php echo e(old('invoices.' . $index . '.amount')); ?>" placeholder="<?php echo e(__('Enter Price')); ?>" readonly />
                                                                <input type="hidden" name="invoices[<?php echo e($index); ?>][fee]" class="form-control" value="<?php echo e(old('invoices.' . $index . '.fee')); ?>" readonly />
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                <label class="control-label"><?php echo e(__('Time From ')); ?><span class="text-danger">*</span></label>
                                                                <input type="time" name="invoices[<?php echo e($index); ?>][time_from]"
                                                                    class="form-control <?php $__errorArgs = ['invoices.' . $index . '.time_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                    value="<?php echo e(old('invoices.' . $index . '.time_from')); ?>"
                                                                    onchange="getTimeTo(this,'')" />
                                                                <?php $__errorArgs = ['invoices.' . $index . '.time_from'];
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
                                                            <div class="col-md-4 form-group">
                                                                <label class="control-label"><?php echo e(__('Time To ')); ?><span class="text-info"><?php echo e(__('(Auto-Fill)')); ?></span></label>
                                                                <input type="time" name="invoices[<?php echo e($index); ?>][time_to]" class="form-control" value="<?php echo e(old('invoices.' . $index . '.time_to')); ?>" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-10 form-group">
                                                                <label class="control-label"><?php echo e(__('Room ')); ?><span class="text-danger">*</span></label>
                                                                <select class="form-control select2 <?php $__errorArgs = ['invoices.' . $index . '.room'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="invoices[<?php echo e($index); ?>][room]">
                                                                    <option selected disabled><?php echo e(__('-- Select Room --')); ?></option>
                                                                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($row->name); ?>" <?php echo e(old('invoices.' . $index . '.room') == $row->name ? 'selected' : ''); ?>><?php echo e($row->name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <?php $__errorArgs = ['invoices.' . $index . '.room'];
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
                                                            <div class="col-md-2 form-group">
                                                                <br />
                                                                <input data-repeater-delete type="button" class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner" value="X" style="margin-top: 13px" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-primary" value="Add Item" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <blockquote><?php echo e(__('Invoice Summary')); ?></blockquote>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row" id="row_member" style="display: none">
                                        <div class="col-md-12 form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" value="1" name="use_member" id="use_member" onchange="useMember(this)">
                                                <label class="form-check-label" for="use_member">
                                                    Use Membership
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="row_member_plan" style="display: none">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Member Plan ')); ?></label>
                                            <input type="text"
                                                class="form-control" name="member_plan" id="member_plan"
                                                value="<?php if(old('member_plan')): ?><?php echo e(old('member_plan')); ?><?php endif; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row" id="row_voucher_code" style="display: block">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Voucher Code ')); ?></label>
                                            <select class="form-control select2"
                                                name="voucher_code"
                                                id="voucher_code"
                                                onchange="calDiscount()">
                                                <option value="" selected><?php echo e(__('-- Select Voucher Code --')); ?></option>
                                                <?php $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($row->voucher_code); ?>"
                                                        data-type = "<?php echo e($row->discount_type); ?>"
                                                        data-value = "<?php echo e($row->discount_value); ?>"
                                                        data-maxvalue = "<?php echo e($row->discount_max_value); ?>"
                                                        data-reuse = "<?php echo e($row->is_reuse_voucher); ?>"
                                                        <?php echo e(old('voucher_code') == $row->voucher_code ? 'selected' : ''); ?>>
                                                        <?php echo e($row->voucher_code); ?> - <?php echo e($row->name); ?> - <?php if($row->discount_type == 0): ?> <?php echo e('(Discount : Rp. '. number_format($row->discount_value) .')'); ?> <?php else: ?> <?php echo e('(Discount Max : Rp. '. number_format($row->discount_max_value) .')'); ?> <?php endif; ?>
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row" id="row_member" style="display: none">
                                        <div class="col-md-12 form-group">
                                            <div class="form-check">
                                                &nbsp;
                                                <label class="form-check-label">&nbsp;</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Total Price')); ?></label>
                                            <input type="text"
                                                class="form-control"
                                                name="total_price" id="total_price"
                                                value="<?php echo e(old('total_price', 0)); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Discount')); ?></label>
                                            <input type="text"
                                                class="form-control"
                                                name="discount" id="discount"
                                                value="<?php echo e(old('discount', 0)); ?>" readonly>
                                            <input type="hidden"
                                                name="reuse_voucher" id="reuse_voucher"
                                                value="<?php echo e(old('reuse_voucher', 0)); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Grand Total')); ?></label>
                                            <input type="text"
                                                class="form-control"
                                                name="grand_total" id="grand_total"
                                                value="<?php echo e(old('grand_total', 0)); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Create New Invoice')); ?>

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
            function getMember() {
                var select = document.querySelector('select[name="customer_id"]');
                var selectedOption = select.options[select.selectedIndex];
                var member = parseFloat(selectedOption.dataset.member);
                var member_plan = selectedOption.dataset.member_plan;
                var discount_type = selectedOption.dataset.discount_type;
                var discount_value = parseFloat(selectedOption.dataset.discount_value);

                document.getElementById('is_member').value = member;

                var rowMember = document.getElementById("row_member");
                var rowMemberPlan = document.getElementById("row_member_plan");
                var useMember = document.getElementById("use_member");
                var rowVoucer = document.getElementById("row_voucher_code");

                if(member == 1) {
                    rowMember.style.display = "block";
                    rowMemberPlan.style.display = "block";
                    rowVoucer.style.display = "none";

                    useMember.checked = true;
                    document.getElementById("member_plan").value = member_plan;

                    if(discount_type == 1) {
                        var total_price = document.getElementById('total_price').value.replace(/,/g, '');

                        discount = total_price * discount_value / 100;
                    }else{
                        discount = discount_value;
                    }

                    var formatDiscount = new Intl.NumberFormat('en-US', {
                        currency: 'USD'
                    }).format(discount);

                    document.getElementById('discount').value = formatDiscount;

                    grandTotal();
                }else{
                    rowMember.style.display = "none";
                    rowMemberPlan.style.display = "none";
                    rowVoucer.style.display = "block";

                    useMember.checked = false;

                    document.getElementById("member_plan").value = '';
                    document.getElementById('discount').value = 0;

                    if(useMember.checked == false) {
                        calDiscount();
                    }
                    grandTotal();
                }
            }

            function useMember(obj) {
                var rowMemberPlan = document.getElementById("row_member_plan");
                var rowVoucer = document.getElementById("row_voucher_code");

                if(obj.checked == true) {
                    rowMemberPlan.style.display = "block";
                    rowVoucer.style.display = "none";

                    getMember();
                }else{
                    rowMemberPlan.style.display = "none";
                    rowVoucer.style.display = "block";

                    calDiscount();
                }

                grandTotal();
            }

            function getAmount(obj) {
                var productName = obj.getAttribute('name');
                var selectedOption = obj.options[obj.selectedIndex];
                var price = parseFloat(selectedOption.dataset.price);
                var fee = parseFloat(selectedOption.dataset.fee);

                var amountName = productName.replace('product_id', 'amount');
                var amountInput = document.querySelector('[name="' + amountName + '"]');

                var feeName = productName.replace('product_id', 'fee');
                var feeInput = document.querySelector('[name="' + feeName + '"]');

                if (amountInput) {
                    if (!isNaN(price)) {
                        var formatAmount = new Intl.NumberFormat('en-US', {
                            currency: 'USD'
                        }).format(price);

                        amountInput.value = formatAmount;
                    } else {
                        amountInput.value = '';
                    }
                }

                if (feeInput) {
                    if (!isNaN(fee)) {
                        feeInput.value = fee;
                    } else {
                        feeInput.value = '';
                    }
                }

                var timeFrom = productName.replace('product_id', 'time_from');
                getTimeTo('change', timeFrom);

                calTotal();
            }

            function getTimeTo(obj, name) {
                if(obj == 'change') {
                    var objName = name;
                    var inputName = document.querySelector('input[name="' + objName + '"]');
                    var timeFromValue = inputName.value;
                } else {
                    var objName = obj.getAttribute('name');
                    var timeFromValue = obj.value;
                }

                //get data duration from product
                var productName = objName.replace('time_from', 'product_id');
                var select = document.querySelector('select[name="' + productName + '"]');
                var selectedOption = select.options[select.selectedIndex];
                var duration = parseFloat(selectedOption.getAttribute('data-duration'));

                //get form name time_to
                var timeTo = objName.replace('time_from', 'time_to');
                var timeToInput = document.querySelector('[name="' + timeTo + '"]');

                //Calculate time_to = time_from + duration
                if (!isNaN(duration) && timeFromValue && timeToInput) {
                    var timeFrom = new Date('1970-01-01T' + timeFromValue);
                    timeFrom.setMinutes(timeFrom.getMinutes() + duration);

                    // Format the calculated time as 'HH:mm'
                    var hours = timeFrom.getHours().toString().padStart(2, '0');
                    var minutes = timeFrom.getMinutes().toString().padStart(2, '0');
                    var calculatedTime = hours + ':' + minutes;

                    //Set the calculated time_to value
                    timeToInput.value = calculatedTime;
                }
            }

            function calTotal() {
                document.getElementById('total_price').value = '';
                var total = 0;

                var invoiceInputs = document.querySelectorAll('input[name^="invoices["][name$="][amount]"]');

                invoiceInputs.forEach(function (input) {
                    total += parseFloat(input.value.replace(/,/g, '')) || 0;
                });

                var formatTotalPrice = new Intl.NumberFormat('en-US', {
                    currency: 'USD'
                }).format(total);

                document.getElementById('total_price').value = formatTotalPrice;

                grandTotal();
                calDiscount();
            }

            function calDiscount() {
                var select = document.querySelector('select[name="voucher_code"]');
                var selectedOption = select.options[select.selectedIndex];

                var useMember = document.getElementById("use_member");

                if(useMember.checked == false) {
                    if(select.value != '') {
                        var type = parseFloat(selectedOption.dataset.type);
                        var value = parseFloat(selectedOption.dataset.value);
                        var maxvalue = parseFloat(selectedOption.dataset.maxvalue);
                        var reuse = parseFloat(selectedOption.dataset.reuse);

                        var total_price = document.getElementById('total_price').value.replace(/,/g, '');
                        var discount = 0;

                        if(type == 0) {
                            discount = value;
                        }else{
                            if(total_price != 0) {
                                discountPromo = total_price * value / 100;

                                // if total discount greater than maxvalue get discount form maxvalue
                                if (discountPromo <= maxvalue) {
                                    discount = discountPromo;
                                }else{
                                    discount = maxvalue;
                                }
                            }else{
                                discount = maxvalue;
                            }
                        }

                        var formatDiscount = new Intl.NumberFormat('en-US', {
                            currency: 'USD'
                        }).format(discount);

                        document.getElementById('discount').value = formatDiscount;
                        document.getElementById('reuse_voucher').value = reuse;

                        grandTotal();
                    }else{
                        document.getElementById('discount').value = 0;
                        grandTotal();
                    }
                }
            }

            function grandTotal() {
                var total_price = document.getElementById('total_price').value.replace(/,/g, '');
                var discount = document.getElementById('discount').value.replace(/,/g, '');

                var grandTotal = total_price - discount;

                var formatGrandTotal = new Intl.NumberFormat('en-US', {
                    currency: 'USD'
                }).format(grandTotal);

                document.getElementById('grand_total').value = formatGrandTotal;
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/invoice/invoice-details.blade.php ENDPATH**/ ?>