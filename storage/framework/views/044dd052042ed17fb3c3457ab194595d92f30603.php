<?php $__env->startSection('title'); ?>
    <?php if($transaction): ?>
        <?php echo e(__('Update Transaction Details')); ?>

    <?php else: ?>
        <?php echo e(__('Add New Transaction')); ?>

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
                        <?php if($transaction): ?>
                            <?php echo e(__('Update Transaction Details')); ?>

                        <?php else: ?>
                            <?php echo e(__('Add New Transaction')); ?>

                        <?php endif; ?>
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('transaction')); ?>"><?php echo e(__('Transactions')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php if($transaction): ?>
                                    <?php echo e(__('Update Transaction Details')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Add New Transaction')); ?>

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
                <a href="<?php echo e(url('transaction')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Transaction List')); ?>

                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Basic Information')); ?></blockquote>
                        <form action="<?php if($transaction ): ?> <?php echo e(url('transaction/' . $transaction->id)); ?> <?php else: ?> <?php echo e(route('transaction.store')); ?> <?php endif; ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if($transaction ): ?>
                                <input type="hidden" name="_method" value="PATCH" />
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Customer Name ')); ?><span
                                                    class="text-danger">*</span></label>
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
                                                value="<?php if($transaction): ?><?php echo e(old('customer_name', $transaction->customer_name)); ?><?php elseif(old('customer_name')): ?><?php echo e(old('customer_name')); ?><?php endif; ?>"
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
                                            <label class="control-label"><?php echo e(__('Room ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['room'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="room" id="room" tabindex="1"
                                                value="<?php if($transaction): ?><?php echo e(old('room', $transaction->room)); ?><?php elseif(old('room')): ?><?php echo e(old('room')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Room')); ?>">
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
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Therapist Name ')); ?><span
                                                    class="text-danger">*</span></label>
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
                                                value="<?php if($transaction): ?><?php echo e(old('therapist_name', $transaction->therapist_name)); ?><?php elseif(old('therapist_name')): ?><?php echo e(old('therapist_name')); ?><?php endif; ?>"
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
                                            <label class="control-label"><?php echo e(__('Product ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['product'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="product" id="product" tabindex="1"
                                                value="<?php if($transaction): ?><?php echo e(old('product', $transaction->product)); ?><?php elseif(old('product')): ?><?php echo e(old('product')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Product')); ?>">
                                            <?php $__errorArgs = ['product'];
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
                                            <label class="control-label"><?php echo e(__('Total Cost ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control <?php $__errorArgs = ['total_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="total_cost" id="total_cost" tabindex="1"
                                                value="<?php if($transaction): ?><?php echo e(old('total_cost', $transaction->total_cost)); ?><?php elseif(old('total_cost')): ?><?php echo e(old('total_cost')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Total Cost')); ?>">
                                            <?php $__errorArgs = ['total_cost'];
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
                                            <label class="control-label"><?php echo e(__('Payment Method ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="11" name="payment_method">
                                                <option selected disabled><?php echo e(__('-- Select Payment Method --')); ?></option>
                                                <option value="Cash" <?php if(($transaction && $transaction->payment_method == 'Cash') || old('payment_method') == 'Cash'): ?> selected <?php endif; ?>><?php echo e(__('Cash')); ?></option>
                                                <option value="Debit" <?php if(($transaction && $transaction->payment_method == 'Debit') || old('payment_method') == 'Debit'): ?> selected <?php endif; ?>><?php echo e(__('Debit')); ?></option>
                                                <option value="GoPay" <?php if(($transaction && $transaction->payment_method == 'GoPay') || old('payment_method') == 'GoPay'): ?> selected <?php endif; ?>><?php echo e(__('GoPay')); ?></option>
                                                <option value="QRIS" <?php if(($transaction && $transaction->payment_method == 'QRIS') || old('payment_method') == 'QRIS'): ?> selected <?php endif; ?>><?php echo e(__('QRIS')); ?></option>
                                                <option value="Credit Card" <?php if(($transaction && $transaction->payment_method == 'Credit Card') || old('payment_method') == 'Credit Card'): ?> selected <?php endif; ?>><?php echo e(__('Credit Card')); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['payment_method'];
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
                                        <?php if($transaction): ?>
                                            <?php echo e(__('Update Transaction Details')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Add New Transaction')); ?>

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

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/transaction/transaction-details.blade.php ENDPATH**/ ?>