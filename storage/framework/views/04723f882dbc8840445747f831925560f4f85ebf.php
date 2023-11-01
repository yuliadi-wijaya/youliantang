<?php $__env->startSection('title'); ?> <?php echo e(__('Invoice Details')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- Adjust the CSS for the specific paper dimensions and max diameter -->
        <style>
            @page {
                margin: 0
            }
            body {
                margin: 0;
            }
            .sheet {
                margin: 0;
                overflow: hidden;
                position: relative;
                box-sizing: border-box;
                page-break-after: always;
            }

            /** Paper sizes **/
            body.struk .sheet {
                width: 75mm;
            }
            body.struk .sheet {
                padding: 2mm;
            }

            /** For screen preview **/
            @media screen {
                body {
                    background: #e0e0e0;
                }
                .sheet {
                    background: white;
                    margin: 5mm;
                }
            }

            /** Fix for Chrome issue **/
            @media print {
                body {
                    font-family: monospace;
                }
                body.struk {
                    width: 75mm;
                    text-align: left;
                }
                body.struk .sheet {
                    padding: 2mm;
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
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <section class="sheet">
                            <div class="invoice-title">
                                <h4 class="float-right font-size-16"><?php echo e(__('Invoice #')); ?> <?php echo e($invoice_detail->id); ?></h4>
                                <div class="mb-4">
                                    <h3>YOU LIAN tANG</h3>
                                    <h6>Family Refleksi & Massage</h6>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <address>
                                        <strong><?php echo e(__('Treatment date : ')); ?></strong><?php echo e($invoice->treatment_date . ' ' . $invoice->treatment_time_from . ' to ' . $invoice->treatment_time_to); ?><br>
                                        <strong><?php echo e(__('Customer : ')); ?></strong><?php echo e($invoice_detail->customer_name); ?><br>
                                        <strong><?php echo e(__('Therapist : ')); ?></strong><?php echo e($invoice_detail->therapist_name); ?><br>
                                    </address>
                                </div>
                                <div class="col-3">
                                    <address>

                                    </address>
                                </div>
                                <div class="col-3">
                                    <address>

                                    </address>
                                </div>
                                <div class="col-3 pull-right">
                                    <address>
                                        <strong><?php echo e(__('Invoice date : ')); ?></strong><?php echo e($invoice->created_at); ?><br>
                                        <strong><?php echo e(__('Payment Mode : ')); ?></strong><?php echo e($invoice_detail->payment_mode); ?><br>
                                        <strong><?php echo e(__('Payment Status : ')); ?></strong><?php echo e($invoice_detail->payment_status); ?><br>
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
                                            <th><?php echo e(__('Title')); ?></th>
                                            <th class="text-right"><?php echo e(__('Amount')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sub_total = 0;
                                        ?>
                                        <?php $__currentLoopData = $invoice_detail->invoice_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1); ?></td>
                                                <td><?php echo e($item->title); ?></td>
                                                <td class="text-right">Rp <?php echo e(number_format($item->amount)); ?></td>
                                            </tr>
                                            <?php
                                                $sub_total += $item->amount;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td colspan="2" class="text-right"><?php echo e(__('Sub Total')); ?></td>
                                            <td class="text-right">Rp <?php echo e(number_format($sub_total)); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border-0 text-right">
                                                <strong><?php echo e(__('Total')); ?></strong>
                                            </td>
                                            <td class="border-0 text-right">
                                                <h4 class="m-0">Rp <?php echo e(number_format($sub_total)); ?></h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/invoice/view-invoice.blade.php ENDPATH**/ ?>