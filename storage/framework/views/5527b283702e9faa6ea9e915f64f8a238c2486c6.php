<?php $__env->startSection('title'); ?> <?php echo e(__('Report Therapist Transaction History Summary')); ?> <?php $__env->stopSection(); ?>
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
            <?php $__env->slot('title'); ?> Report Therapist Transaction History Summary <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Reports <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_3'); ?> Therapists <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_4'); ?> Report Therapist Transaction History Summary <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row d-print-none">
            <div class="col-12">
                <a href="<?php echo e(url('/rf-therapist-trans')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Filter Therapist Transaction')); ?>

                    </button>
                </a>

                <a href="" class="btn btn-success waves-effect waves-light mb-4"
                    onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </a>

                <form id="export-form" action="<?php echo e(route('ex-therapist-trans')); ?>" method="GET" style="display: none;">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="report_type" value="<?php echo e($report_type); ?>">
                    <input type="hidden" name="month" value="<?php echo e($month); ?>">
                    <input type="hidden" name="year" value="<?php echo e($year); ?>">
                    <input type="hidden" name="therapist_id" value="<?php echo e($therapist_id); ?>">
                    <input type="hidden" name="order_by" value="<?php echo e($order_by); ?>">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <div class="mb-4">
                                <h4>
                                    <?php
                                        $monthTexts = [
                                            "01" => "January",
                                            "02" => "February",
                                            "03" => "March",
                                            "04" => "April",
                                            "05" => "May",
                                            "06" => "June",
                                            "07" => "July",
                                            "08" => "August",
                                            "09" => "September",
                                            "10" => "October",
                                            "11" => "November",
                                            "12" => "December",
                                        ];
                                    ?>
                                    <strong>
                                        <?php echo e(__('Report Type = ') . ucfirst($report_type) . ' (' . $monthTexts[$month] . ' - ' . $year . ')'); ?>

                                    </strong>
                                </h4>
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
                                        <th class="no-wrap"><?php echo e(__('Treatment Date')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Duration')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Commission Fee')); ?></th>
                                        <th class="no-wrap"><?php echo e(__('Rating')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $gt_duration = 0;
                                        $gt_fee = 0;
                                    ?>

                                    <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $gt_duration += $row->total_duration;
                                            $gt_fee += $row->total_commission_fee;
                                        ?>

                                        <tr>
                                            <td class="no-wrap"><?php echo e($row->therapist_name); ?></td>
                                            <td class="no-wrap"><?php echo e($row->phone_number); ?></td>
                                            <td class="no-wrap"><?php echo e($row->treatment_month_year); ?></td>
                                            <td class="no-wrap"><?php echo e($row->total_duration); ?> Minutes</td>
                                            <td class="no-wrap">Rp. <?php echo e(number_format($row->total_commission_fee, 0, ',', '.')); ?></td>
                                            <td class="no-wrap"><?php echo e($row->avg_rating); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="no-wrap" colspan="2">&nbsp;</th>
                                        <th class="no-wrap"><?php echo e(__('Total')); ?></th>
                                        <th class="no-wrap"><?php echo e($gt_duration); ?> Minutes</th>
                                        <th class="no-wrap">Rp. <?php echo e(number_format($gt_fee, 0, ',', '.')); ?></td>
                                        <th class="no-wrap">&nbsp;</th>
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

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/report/therapist/therapist-trans-summary.blade.php ENDPATH**/ ?>