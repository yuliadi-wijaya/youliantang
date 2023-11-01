<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(url('/')); ?>">
                            <i class="bx bx-home-circle mr-2"></i><?php echo e(__('translation.dashboards')); ?>

                        </a>
                    </li>
                    <?php if($role == 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('translation.master-data')); ?> <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('therapist')); ?>" class="dropdown-item"><?php echo e(__('translation.therapists')); ?></a>
                                <a href="<?php echo e(url('receptionist')); ?>" class="dropdown-item"><?php echo e(__('translation.receptionist')); ?></a>
                                <a href="<?php echo e(url('room')); ?>" class="dropdown-item"><?php echo e(__('translation.rooms')); ?></a>
                                <a href="<?php echo e(url('membership')); ?>" class="dropdown-item"><?php echo e(__('translation.memberships')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('translation.products')); ?> <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('product')); ?>" class="dropdown-item"><?php echo e(__('translation.list-of-products')); ?></a>
                                <a href="<?php echo e(route('product.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.add-new-product')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('translation.promos')); ?> <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('promo')); ?>" class="dropdown-item"><?php echo e(__('translation.list-of-promos')); ?></a>
                                <a href="<?php echo e(route('promo.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.add-new-promo')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('translation.customers')); ?> <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('customer')); ?>" class="dropdown-item"><?php echo e(__('translation.list-of-customers')); ?></a>
                                <a href="<?php echo e(route('customer.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('translation.add-new-customer')); ?></a>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('transaction')); ?>">
                                <i class='bx bx-list-check mr-2'></i><?php echo e(__('translation.transaction')); ?>

                            </a>
                        </li>
                    
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
<?php /**PATH /Users/yuliadiwijaya/Documents/Freelance/You Lian tAng/youliantang/resources/views/layouts/hor-menu.blade.php ENDPATH**/ ?>