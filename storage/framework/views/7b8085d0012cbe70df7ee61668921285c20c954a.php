

<?php $__env->startSection('title'); ?> <?php echo e(__("Welcome Email For Default Credentials")); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<body>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary"><?php echo e(AppSetting('title')); ?> - Hospital Management System</h5>
                                        <p>Here is your new account credentials with <?php echo e(AppSetting('title')); ?>.</p>
                                    </div>
                                </div>
                                <!-- <div class="col-5 align-self-end">
                                    <img src="<?php echo e(URL::asset('assets/images/profile-img.png')); ?>" alt="" class="img-fluid">
                                </div> -->
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="<?php echo e(url('/')); ?>">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?php echo e(URL::asset('assets/images/logo-dark.png')); ?>" alt=""
                                                class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <h4><?php echo e(__("Hello,")); ?> <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h4>
                                <p><?php echo e(__("Your account default credentials are as below.")); ?></p>
                                <p><b><?php echo e(__("Username:")); ?></b> <?php echo e($user->email); ?></p>
                                <p><b><?php echo e(__("Password:")); ?></b> <?php echo e(config('app.DEFAULT_PASSWORD')); ?></p>
                                <p><?php echo e(__("You can change your default password from profile menu after login.")); ?></p>
                                <p><?php echo e(__("Thank you,")); ?></p>
                                <p><?php echo e(AppSetting('title')); ?>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>© <?php echo e(date('Y')); ?> <?php echo e(AppSetting('title')); ?>. Crafted with
                            <i class="mdi mdi-heart text-danger"></i> <?php echo e(__("by Themesbrand")); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/emails/WelcomeEmail.blade.php ENDPATH**/ ?>