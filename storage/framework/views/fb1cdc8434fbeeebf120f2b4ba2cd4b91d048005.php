<?php $__env->startSection('title'); ?> <?php echo e(__('Invoice Details')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Invoice Details <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Invoice List <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Invoice Details <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="<?php echo e(url('transaction')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Invoice List')); ?>

                    </button>
                </a>
                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
                    <i class="fa fa-print"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="transaction-title">
                            <h4 class="float-right font-size-16"><?php echo e(__('Invoice #')); ?> <?php echo e($transaction_detail->id); ?></h4>
                            <div class="mb-4">
                                <img src="<?php echo e(URL::asset('assets/images/logo-dark.png')); ?>" alt="logo" height="20" />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">
                                <address>
                                    <strong><?php echo e(__('Customer Details')); ?></strong><br>
                                    <?php echo e($transaction_detail->customer_name); ?><br>
                                </address>
                            </div>
                            <div class="col-3">
                                <address>
                                    <strong><?php echo e(__('Therapist Details')); ?></strong><br>
                                    <?php echo e($transaction_detail->therapist_name); ?><br>
                                </address>
                            </div>
                            <div class="col-3">
                                <address>
                                    <strong><?php echo e(__('Payment Details')); ?></strong><br>
                                    <?php echo e(__('Payment Mode :')); ?> <?php echo e($transaction_detail->payment_method); ?><br>
                                </address>
                            </div>
                            <div class="col-3 pull-right">
                                <address>
                                    <strong><?php echo e(__('Invoice date: ')); ?></strong><?php echo e($transaction_detail->created_at); ?><br>
                                </address>
                            </div>
                        </div>

                        <div class="py-2 mt-3">
                            <h3 class="font-size-15 font-weight-bold"><?php echo e(__('Invoice summary')); ?></h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;"><?php echo e(__('No.')); ?></th>
                                        <th><?php echo e(__('Product')); ?></th>
                                        <th class="text-right"><?php echo e(__('Amount')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><?php echo e($transaction_detail->product); ?></td>
                                        <td class="text-right">Rp. <?php echo e(number_format($transaction_detail->total_cost, 2, '.', ',')); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right"><?php echo e(__('Sub Total')); ?></td>
                                        <td class="text-right">Rp. <?php echo e(number_format($transaction_detail->total_cost, 2, '.', ',')); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-right">
                                            <strong><?php echo e(__('Tax (10%)')); ?></strong>
                                        </td>
                                        <td class="border-0 text-right">Rp. <?php echo e(number_format(($transaction_detail->total_cost * 5) / 100, 2, '.', ',')); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-right">
                                            <strong><?php echo e(__('Total')); ?></strong>
                                        </td>
                                        <td class="border-0 text-right">
                                            <h4 class="m-0">Rp. <?php echo e(number_format($transaction_detail->total_cost + ($transaction_detail->total_cost * 5) / 100, 2, '.', ',')); ?></h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/transaction/transaction-view.blade.php ENDPATH**/ ?>