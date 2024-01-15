<?php $__env->startSection('title'); ?> <?php echo e(__("Login")); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<body>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="account-pages mb-5">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-md-8 col-lg-6 col-xl-5 mt-5">
                    <div class="col-12" style="margin-bottom: -50px">
                        <div class="row justify-content-center">
                            <img src="<?php echo e(URL::asset('assets/images/companies/ylt-black.png')); ?>" width="400" alt=""
                            class="img-fluid">
                        </div>
                    </div>
                    
                    <div class="card overflow-hidden">
                        
                        <div class="card-body">
                            
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="<?php echo e(url('login')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php if($msg = Session::get('error')): ?>
                                        <div class="alert alert-danger">
                                            <span> <?php echo e($msg); ?> </span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($msg = Session::get('success')): ?>
                                        <div class="alert alert-success">
                                            <span> <?php echo e($msg); ?> </span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="username"><?php echo e(__("Username")); ?></label>
                                        <input name="email" type="email" id="email"
                                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            <?php if(old('email')): ?> value="<?php echo e(old('email')); ?>" <?php else: ?> value="" <?php endif; ?> id="username" placeholder="Enter username"
                                            autocomplete="email" autofocus>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="userpassword"><?php echo e(__("Password")); ?></label>
                                        <input type="password" name="password" id="pass"
                                            class="form-control  <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="userpassword" <?php if(old('password')): ?> value="<?php echo e(old('password')); ?>" <?php else: ?> value="" <?php endif; ?> placeholder="Enter password">
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="remember"
                                            id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline"><?php echo e(__("Remember me")); ?></label>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light"
                                            type="submit"><?php echo e(__("Log In")); ?></button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <a href="<?php echo e(url('forgot-password')); ?>" class="text-muted"><i
                                                class="mdi mdi-lock mr-1"></i> <?php echo e(__("Forgot your password?")); ?></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p><?php echo e(__("Don't have an account ?")); ?> <a href="<?php echo e(url('register')); ?>"
                                class="font-weight-medium text-primary"> <?php echo e(__("Sign Up here")); ?></a> </p>
                        <p>© <?php echo e(date('Y')); ?> <?php echo e(AppSetting('title')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/yuliadiwijaya/Documents/Freelance/You Lian tAng/youliantang/resources/views/auth/login.blade.php ENDPATH**/ ?>