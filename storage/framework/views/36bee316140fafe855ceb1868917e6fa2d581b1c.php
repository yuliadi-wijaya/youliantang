<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><?php echo e(__('translation.dashboards')); ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><?php echo e(__('translation.welcome-to-dashboard')); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary"><?php echo e(__('translation.welcome-back')); ?> !</h5>
                            <p><?php echo e(__('translation.dashboards')); ?></p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="<?php echo e(URL::asset('assets/images/profile-img.png')); ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="<?php if($user->profile_photo != null): ?><?php echo e(URL::asset('storage/images/users/' . $user->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('assets/images/users/noImage.png')); ?><?php endif; ?>" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate"> <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?> </h5>
                        <p class="text-muted mb-0 text-truncate"><?php echo e(__('Customer')); ?></p>
                    </div>
                    <div class="col-sm-8">
                        <div class="pt-4">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="font-size-12"><?php echo e(__('Last Login:')); ?></h5>
                                    <p class="text-muted mb-0"> <?php echo e($user->last_login); ?> </p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="<?php echo e(url('profile-edit')); ?>" class="btn btn-primary waves-effect waves-light btn-sm"><?php echo e(__('Edit Profile')); ?>

                                        <i class="mdi mdi-arrow-right ml-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><?php echo e(__('translation.monthly-expense')); ?></h4>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-muted"><?php echo e(__('This month')); ?></p>
                        <h3>$<?php echo e(number_format($data['monthly_earning'])); ?></h3>
                        <p class="text-muted"><span class="<?php if($data['monthly_diff'] > 0): ?> text-success <?php else: ?> text-danger <?php endif; ?> mr-2"> <?php echo e($data['monthly_diff']); ?>% <i class="mdi <?php if($data['monthly_diff'] > 0): ?> mdi-arrow-up <?php else: ?> mdi-arrow-down <?php endif; ?>"></i> </span>
                            <?php echo e(__('From previous month')); ?></p>
                    </div>
                    <div class="col-sm-6">
                        <div id="radialBar-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="row">
            
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <?php if(session()->has('page_limit')): ?>
                            <?php
                            $per_page = session()->get('page_limit');
                            ?>
                            <?php else: ?>
                            <?php
                            $per_page = Config::get('app.page_limit');
                            ?>
                            <?php endif; ?>
                            <div class="media-body">
                                <p class="text-muted font-weight-medium"><?php echo e(__('translation.items-per-page')); ?></p>
                                <button class="btn  <?php echo e($per_page == 10 ? 'btn-primary' : 'btn-info'); ?>  btn-sm mr-2 per-page-items  mb-md-1" data-page="10">10</button>
                                <button class="btn  <?php echo e($per_page == 25 ? 'btn-primary' : 'btn-info'); ?>  btn-sm mr-2 per-page-items  mb-md-1" data-page="25">25</button>
                                <button class="btn  <?php echo e($per_page == 50 ? 'btn-primary' : 'btn-info'); ?>  btn-sm mr-2 per-page-items  mb-md-1" data-page="50">50</button>
                                <button class="btn  <?php echo e($per_page == 100 ? 'btn-primary' : 'btn-info'); ?>  btn-sm mr-2 per-page-items  mb-md-1" data-page="100">100</button>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-book-open font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        
    </div>
</div>
<!-- end row -->
<?php /**PATH D:\Project\youliantang\resources\views/layouts/customer-dashboard.blade.php ENDPATH**/ ?>