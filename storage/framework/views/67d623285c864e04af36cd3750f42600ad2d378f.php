<?php $__env->startSection('title'); ?> <?php echo e(__('Report Customers')); ?> <?php $__env->stopSection(); ?>
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
            <?php $__env->slot('title'); ?> Report Customer Transaction History <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Reports <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Customers <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Report Customer Transaction History <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="<?php echo e(url('/rf-customer-trans')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Filter Customer Transaction History')); ?>

                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="<?php echo e(route('ex-customer-trans')); ?>" method="GET" style="display: none;">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="dateFrom" value="<?php echo e($dateFrom); ?>">
                    <input type="hidden" name="dateTo" value="<?php echo e($dateTo); ?>">
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
                                        <th class="no-wrap"><?php echo e(__('Customer Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Phone Number')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Email')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Invoice Code')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Treatment Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Payment Mode')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Payment Status')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Note')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Is Member')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Use Member')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Member Plan')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Voucher Code')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Total Price')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Discount')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Grand Total')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Product Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Amount')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Therapist Name')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Room')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Time From')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Time To')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sub_price = 0;
                                        $sub_discount = 0;
                                        $sub_grand_total = 0;
                                    ?>
                                    <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($index > 0 && $row->customer_id == $report[$index - 1]->customer_id): ?>
                                            <?php
                                                $customer_name = '';
                                                $customer_phone = '';
                                                $email = '';
                                            ?>
                                        <?php else: ?>
                                            <?php
                                                $customer_name = $row->customer_name;
                                                $customer_phone = $row->customer_phone;
                                                $email = $row->email;
                                            ?>
                                        <?php endif; ?>

                                        <?php
                                            $treatment_date = date('d-m-Y', strtotime($row->treatment_date));
                                            $total_price = 'Rp. '. number_format($row->total_price, 0, ',', '.');
                                            $discount = 'Rp. '. number_format($row->discount, 0, ',', '.');
                                            $grand_total = 'Rp. '. number_format($row->grand_total, 0, ',', '.');

                                            $sub_price += $row->total_price;
                                            $sub_discount += $row->discount;
                                            $sub_grand_total += $row->grand_total;
                                        ?>

                                        <tr>
                                            <td class="no-wrap"><?php echo e($customer_name); ?></td>
                                            <td class="no-wrap"><?php echo e($customer_phone); ?></td>
                                            <td class="no-wrap"><?php echo e($email); ?></td>
                                            <td class="no-wrap"><?php echo e($row->invoice_code); ?></td>
                                            <td class="no-wrap"><?php echo e($treatment_date); ?></td>
                                            <td class="no-wrap"><?php echo e($row->payment_mode); ?></td>
                                            <td class="no-wrap"><?php echo e($row->payment_status); ?></td>
                                            <td class="no-wrap"><?php echo e($row->note); ?></td>
                                            <td class="no-wrap"><?php echo e($row->is_member); ?></td>
                                            <td class="no-wrap"><?php echo e($row->use_member); ?></td>
                                            <td class="no-wrap"><?php echo e($row->member_plan); ?></td>
                                            <td class="no-wrap"><?php echo e($row->voucher_code); ?></td>
                                            <td class="no-wrap"><?php echo e($total_price); ?></td>
                                            <td class="no-wrap"><?php echo e($discount); ?></td>
                                            <td class="no-wrap"><?php echo e($grand_total); ?></td>
                                            <td class="no-wrap">&nbsp;</td>
                                            <td class="no-wrap">&nbsp;</td>
                                            <td class="no-wrap"><?php echo e($row->old_data == 'Y' ? $row->therapist_name : ''); ?></td>
                                            <td class="no-wrap"><?php echo e($row->old_data == 'Y' ? $row->room : ''); ?></td>
                                            <td class="no-wrap"><?php echo e($row->old_data == 'Y' ? $row->time_from : ''); ?></td>
                                            <td class="no-wrap"><?php echo e($row->old_data == 'Y' ? $row->time_to : ''); ?></td>

                                        </tr>

                                        <?php $__currentLoopData = $report_detail[$row->invoice_id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap">&nbsp;</td>
                                                <td class="no-wrap"><?php echo e($rd->product_name); ?></td>
                                                <td class="no-wrap">Rp. <?php echo e(number_format($rd->amount, 0, ',', '.')); ?></td>
                                                <td class="no-wrap"><?php echo e($row->old_data == 'N' ? $rd->therapist_name : ''); ?></td>
                                                <td class="no-wrap"><?php echo e($row->old_data == 'N' ? $rd->room : ''); ?></td>
                                                <td class="no-wrap"><?php echo e($row->old_data == 'N' ? $rd->treatment_time_from : ''); ?></td>
                                                <td class="no-wrap"><?php echo e($row->old_data == 'N' ? $rd->treatment_time_to : ''); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="11">&nbsp;</th>
                                        <th class="no-wrap"><?php echo e(__('Total')); ?></th>
                                        <th class="no-wrap">Rp. <?php echo e(number_format($sub_price, 0, ',', '.')); ?></th>
                                        <th class="no-wrap">Rp. <?php echo e(number_format($sub_discount, 0, ',', '.')); ?></th>
                                        <th class="no-wrap">Rp. <?php echo e(number_format($sub_grand_total, 0, ',', '.')); ?></th>
                                        <th class="no-wrap" colspan="6">&nbsp;</th>
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

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/report/customer/customer-trans.blade.php ENDPATH**/ ?>