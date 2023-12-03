<?php $__env->startSection('title'); ?> <?php echo e(__('Report Therapist Transaction History Detail')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <style>
        .no-wrap {
            white-space: nowrap;
        }
    </style>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Report Therapist Transaction History Detail <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Reports <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Therapists <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_4'); ?> Report Therapist Transaction History Detail <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="<?php echo e(url('/rf-therapist-trans')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Filter Therapist Transaction History Detail')); ?>

                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="<?php echo e(route('ex-therapist-trans')); ?>" method="GET" style="display: none;">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="dateFrom" value="<?php echo e($dateFrom); ?>">
                    <input type="hidden" name="dateTo" value="<?php echo e($dateTo); ?>">
                    <input type="hidden" name="report_type" value="<?php echo e($report_type); ?>">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4><strong><?php echo e(__('Report Status = ') . ($report_type == 'detail' ? 'Detail' : 'Summary')); ?></strong></h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                        </div>
                        <div class="table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-wrap"><?php echo e(__('Therapist Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Phone Number')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Email')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Invoice Code')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Treatment Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Payment Mode')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Payment Status')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Note')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Voucher Code')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Total Price')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Discount')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Grand Total')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Amount')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Product Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Duration')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Commission Fee')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Customer Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Room')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Time From')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Time To')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Invoice Type')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Rating')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Comment')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sub_price = 0;
                                        $sub_discount = 0;
                                        $sub_grand_total = 0;
                                        $sub_fee = 0;
                                    ?>

                                    <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($index > 0 && $row->therapist_id == $report[$index - 1]->therapist_id): ?>
                                            <?php
                                                $therapist_name = '';
                                                $phone_number = '';
                                                $email = '';
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $therapist_name = $row->therapist_name;
                                                $phone_number = $row->phone_number;
                                                $email = $row->email;
                                            ?>
                                        <?php endif; ?>

                                        <?php if($index > 0 && $row->therapist_id == $report[$index - 1]->therapist_id && $row->invoice_code == $report[$index - 1]->invoice_code): ?>
                                            <?php
                                                $invoice_code = '';
                                                $treatment_date = '';
                                                $payment_mode = '';
                                                $payment_status = '';
                                                $note = '';
                                                $voucher_code = '';
                                                $total_price = '';
                                                $discount = '';
                                                $grand_total = '';
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $invoice_code = $row->invoice_code;
                                                $treatment_date = $row->treatment_date;
                                                $payment_mode = $row->payment_mode;
                                                $payment_status = $row->payment_status;
                                                $note = $row->note;
                                                $voucher_code = $row->voucher_code;
                                                $total_price = 'Rp. '. number_format($row->total_price, 0, ',', '.');
                                                $discount = 'Rp. '. number_format($row->discount, 0, ',', '.');
                                                $grand_total = 'Rp. '. number_format($row->grand_total, 0, ',', '.');

                                                $sub_price = $sub_price + $row->total_price;
                                                $sub_discount = $sub_discount + $row->discount;
                                                $sub_grand_total = $sub_grand_total + $row->grand_total;
                                            ?>
                                        <?php endif; ?>

                                        <?php
                                            $sub_fee = $sub_fee + $row->commission_fee;
                                        ?>

                                        <tr>
                                            <td class="no-wrap"><?php echo e($therapist_name); ?></td>
                                            <td class="no-wrap"><?php echo e($phone_number); ?></td>
                                            <td class="no-wrap"><?php echo e($email); ?></td>
                                            <td class="no-wrap"><?php echo e($invoice_code); ?></td>
                                            <td class="no-wrap"><?php echo e($treatment_date); ?></td>
                                            <td class="no-wrap"><?php echo e($payment_mode); ?></td>
                                            <td class="no-wrap"><?php echo e($payment_status); ?></td>
                                            <td class="no-wrap"><?php echo e($note); ?></td>
                                            <td class="no-wrap"><?php echo e($voucher_code); ?></td>
                                            <td class="no-wrap"><?php echo e($total_price); ?></td>
                                            <td class="no-wrap"><?php echo e($discount); ?></td>
                                            <td class="no-wrap"><?php echo e($grand_total); ?></td>
                                            <td class="no-wrap">Rp. <?php echo e(number_format($row->amount, 0, ',', '.')); ?></td>
                                            <td class="no-wrap"><?php echo e($row->product_name); ?></td>
                                            <td class="no-wrap"><?php echo e($row->duration); ?> Minutes</td>
                                            <td class="no-wrap">Rp. <?php echo e(number_format($row->commission_fee, 0, ',', '.')); ?></td>
                                            <td class="no-wrap"><?php echo e($row->customer_name); ?></td>
                                            <td class="no-wrap"><?php echo e($row->room); ?></td>
                                            <td class="no-wrap"><?php echo e($row->time_from); ?></td>
                                            <td class="no-wrap"><?php echo e($row->time_to); ?></td>
                                            <td class="no-wrap"><?php echo e($row->invoice_type); ?></td>
                                            <td class="no-wrap"><?php echo e($row->rating); ?></td>
                                            <td class="no-wrap"><?php echo e($row->comment); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="8">&nbsp;</th>
                                        <th class="no-wrap"><?php echo e(__('Total')); ?></th>
                                        <th class="no-wrap">Rp. <?php echo e(number_format($sub_price, 0, ',', '.')); ?></th>
                                        <th class="no-wrap">Rp. <?php echo e(number_format($sub_discount, 0, ',', '.')); ?></th>
                                        <th class="no-wrap">Rp. <?php echo e(number_format($sub_grand_total, 0, ',', '.')); ?></th>
                                        <th class="no-wrap" colspan="3">&nbsp;</th>
                                        <th class="no-wrap">Rp. <?php echo e(number_format($sub_fee, 0, ',', '.')); ?></th>
                                        <th class="no-wrap" colspan="7">&nbsp;</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/report/therapist/therapist-trans-detail.blade.php ENDPATH**/ ?>