<?php $__env->startSection('title'); ?> <?php echo e(__('Invoice Details')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

<body data-topbar="dark" data-layout="horizontal">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    .print-invoice {
        display: none;
    }

    @media print {
        .view-invoice {
            display: none;
        }

        @page {
            size: 58mm 120mm;
            margin: 0;
        }
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
        }
        .print-invoice {
            display: block;
            margin: 0;
            padding: 0;
            page-break-after: auto;
        }

        .print-invoice td {
            font-size: 9pt;
            padding: 2px;
            white-space: pre-line;
            word-wrap: break-word;
            vertical-align: top;
        }
    }
</style>
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
        <a href="<?php echo e(url('invoice')); ?>">
            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Invoice List')); ?>

            </button>
        </a>
        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
            <i class="fa fa-print"></i>
        </a>
        <a href="<?php echo e(url('invoice-pdf/' . $invoices->id)); ?>" class="btn btn-success waves-effect waves-light mb-4">
            <i class="fa fa-file-pdf"></i>
        </a>
    </div>
</div>
<div class="view-invoice">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-right font-size-16"><?php echo e(__('Invoice #')); ?> <?php echo e($invoices->id); ?></h4>
                        <div class="mb-4">
                            <h3>YOU LIAN tANG</h3>
                            <h6>Family Refleksi & Massage</h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-9">
                            <address>
                                <strong><?php echo e(__('Treatment date : ')); ?></strong><?php echo e($invoices->treatment_date); ?><br />
                                <strong><?php echo e(__('Customer : ')); ?></strong><?php echo e($invoices->customer_name); ?><br />
                                
                            </address>
                        </div>
                        <div class="col-3 pull-right" style="text-align: right">
                            <address>
                                <strong><?php echo e(__('Invoice date : ')); ?></strong><?php echo e($invoices->created_at); ?><br />
                                
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
                                    <th><?php echo e(__('Product Name')); ?></th>
                                    <th class="text-right"><?php echo e(__('Amount')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $invoice_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index + 1); ?></td>
                                        <td><?php echo e($row->product_name); ?></td>
                                        <td class="text-right">Rp <?php echo e(number_format($row->amount)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="2" class="text-right"><?php echo e(__('Sub Total')); ?></td>
                                    <td class="text-right">Rp <?php echo e(number_format($invoices->total_price)); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right"><?php echo e(__('Discount')); ?></td>
                                    <td class="text-right">Rp <?php echo e(number_format($invoices->discount)); ?></td>
                                </tr>
                                <?php if($invoices->use_member !== 1 && $invoices->voucher_code !== ''): ?>
                                    <tr>
                                        <td colspan="2" class="text-right"><?php echo e(__('Voucer Code')); ?></td>
                                        <td class="text-right"><?php echo e($invoices->voucher_code); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="2" class="border-0 text-right">
                                        <strong><?php echo e(__('Grand Total')); ?></strong>
                                    </td>
                                    <td class="border-0 text-right">
                                        <h4 class="m-0">Rp <?php echo e(number_format($invoices->grand_total)); ?></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="print-invoice">
    <table cellpadding="0" cellspacing="0" style="margin-left: 20px;">
        <tr>
            <td style="text-align:center"><span style="font-weight: bold; font-size:13pt">YOU LIAN tANG<span>
                <span style="font-weight: bold; font-size:10pt;">FAMILY REFLEXOLOGY AND MASSAGE</span></td>
        </tr>
        <tr>
            <td style="text-align:center"><span>RUKO INKOPAL BLOK C6-C7</span>
                <span>KELAPA GADING BARAT JAKARTA UTARA</span>
            </td>
        </tr>
    </table>

    <?php echo e(str_repeat("-", 37)); ?> <br>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <td>Treatment Date</td>
            <td>:</td>
            <td><?php echo e($invoices->treatment_date); ?></td>
        </tr>
        <tr>
            <td>Customer</td>
            <td>:</td>
            <td><?php echo e($invoices->customer_name); ?></td>
        </tr>
        <tr>
            <td>Is Member</td>
            <td>:</td>
            <td><?php if($invoices->is_member == 1): ?> <?php echo e(__('Yes (').$invoices->member_plan.')'); ?> <?php else: ?> <?php echo e(__('No')); ?> <?php endif; ?></td>
        </tr>
        <?php $__currentLoopData = $invoice_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>Therapist</td>
                <td>:</td>
                <td><?php echo e($row->therapist_name); ?></td>
            </tr>
            <tr>
                <td>Treatment Time</td>
                <td>:</td>
                <td><?php echo e($row->treatment_time_from); ?> - <?php echo e($row->treatment_time_to); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td>Payment Mode</td>
            <td>:</td>
            <td><?php echo e($invoices->payment_mode); ?></td>
        </tr>
        <tr>
            <td>Payment Status</td>
            <td>:</td>
            <td><?php echo e($invoices->payment_status); ?></td>
        </tr>
    </table>

    <?php echo e(str_repeat("-", 37)); ?> <br>

    <h6><strong>Invoice summary</strong></h6>

    <table cellpadding="0" cellspacing="0">
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td>No</td>
            <td width="200px">Product Name</td>
            <td>Amount</td>
        </tr>

        <?php $__currentLoopData = $invoice_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->index + 1); ?></td>
                <td><?php echo e($row->product_name); ?></td>
                <td align="right">Rp <?php echo e(number_format($row->amount)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td></td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" align="right"><?php echo e(__('Sub Total')); ?></td>
            <td class="text-right">Rp <?php echo e(number_format($invoices->total_price)); ?></td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" align="right"><?php echo e(__('Discount')); ?></td>
            <td class="text-right">Rp <?php echo e(number_format($invoices->discount)); ?></td>
        </tr>
        <tr style="border-top:1px dashed black; border-bottom:1px dashed black">
            <td colspan="2" align="right"><strong><?php echo e(__('Total')); ?></strong></td>
            <td align="right"><strong>Rp <?php echo e(number_format($invoices->grand_total)); ?></strong></td>
        </tr>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/yuliadiwijaya/Documents/Freelance/You Lian tAng/youliantang/resources/views/invoice/view-invoice-new.blade.php ENDPATH**/ ?>