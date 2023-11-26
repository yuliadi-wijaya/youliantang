<?php $__env->startSection('title'); ?> <?php echo e(__('Report View')); ?> <?php $__env->stopSection(); ?>
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
            <?php $__env->slot('title'); ?> Report View <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Invoice <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Report View <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="<?php echo e(url('/report-filter')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Report Filter')); ?>

                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="<?php echo e(route('report-export')); ?>" method="GET" style="display: none;">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="dateFrom" value="<?php echo e($dateFrom); ?>">
                    <input type="hidden" name="dateTo" value="<?php echo e($dateTo); ?>">
                    <input type="hidden" name="payment_status" value="<?php echo e($pay_status); ?>">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4><strong><?php echo e(__('Report') . ' ' . date('d M Y', strtotime($dateFrom)) . ' - ' . date('d M Y', strtotime($dateTo))); ?></strong></h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                        </div>
                        <div class="table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-wrap"><?php echo e(__('Invoice No')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Invoice Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Customer Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Customer Phone')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Payment Mode')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Payment Status')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Note')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Total_price')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Discount')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Grand Total')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Product Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Amount')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Duration')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Treatment Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Treatment Time From')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Treatment Time To')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Room')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Therapist Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Therapist Phone')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Commission Fee')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sub_price = 0;
                                        $sub_discount = 0;
                                        $sub_grand_total = 0;
                                    ?>
                                    <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($index > 0 && $row->invoice_code == $report[$index - 1]->invoice_code): ?>
                                            <?php
                                                $invoice_code = '';
                                                $invoice_date = '';
                                                $customer_name = '';
                                                $customer_phone_number = '';
                                                $payment_mode = '';
                                                $payment_status = '';
                                                $note = '';
                                                $total_price = '';
                                                $discount = '';
                                                $grand_total = '';
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $invoice_code = $row->invoice_code;
                                                $invoice_date = $row->invoice_date;
                                                $customer_name = $row->customer_name;
                                                $customer_phone_number = $row->customer_phone_number;
                                                $payment_mode = $row->payment_mode;
                                                $payment_status = $row->payment_status;
                                                $note = $row->note;
                                                $total_price = $row->total_price;
                                                $discount = $row->discount;
                                                $grand_total = $row->grand_total;

                                                $sub_price = $sub_price + $total_price;
                                                $sub_discount = $sub_discount + $discount;
                                                $sub_grand_total = $sub_grand_total + $grand_total;
                                            ?>
                                        <?php endif; ?>

                                        <tr>
                                            <td class="no-wrap"><?php echo e($invoice_code); ?></td>
                                            <td class="no-wrap"><?php echo e(($total_price !== '') ? date('d-m-Y', strtotime($invoice_date)) : ''); ?></td>
                                            <td class="no-wrap"><?php echo e($customer_name); ?></td>
                                            <td class="no-wrap"><?php echo e($customer_phone_number); ?></td>
                                            <td class="no-wrap"><?php echo e($payment_mode); ?></td>
                                            <td class="no-wrap"><?php echo e($payment_status); ?></td>
                                            <td class="no-wrap"><?php echo e($note); ?></td>
                                            <td class="no-wrap"><?php echo e(($total_price !== '') ? 'Rp. '.number_format($total_price, 2) : ''); ?></td>
                                            <td class="no-wrap"><?php echo e(($discount !== '') ? 'Rp. '.number_format($discount, 2) : ''); ?></td>
                                            <td class="no-wrap"><?php echo e(($grand_total !== '') ? 'Rp. '.number_format($grand_total, 2) : ''); ?></td>
                                            <td class="no-wrap"><?php echo e($row->product_name); ?></td>
                                            <td class="no-wrap">Rp. <?php echo e(number_format($row->amount, 0, ',', '.')); ?></td>
                                            <td class="no-wrap"><?php echo e($row->duration); ?></td>
                                            <td class="no-wrap"><?php echo e(date('d-m-Y', strtotime($row->treatment_date))); ?></td>
                                            <td class="no-wrap"><?php echo e($row->treatment_time_from); ?></td>
                                            <td class="no-wrap"><?php echo e($row->treatment_time_to); ?></td>
                                            <td class="no-wrap"><?php echo e($row->room); ?></td>
                                            <td class="no-wrap"><?php echo e($row->therapist_name); ?></td>
                                            <td class="no-wrap"><?php echo e($row->therapist_phone_number); ?></td>
                                            <td class="no-wrap">Rp. <?php echo e(number_format($row->commission_fee, 0, ',', '.')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/report/report-view.blade.php ENDPATH**/ ?>