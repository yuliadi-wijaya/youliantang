
<?php $__env->startSection('title'); ?>
    <?php if($product): ?>
        <?php echo e(__('Update Product Details')); ?>

    <?php else: ?>
        <?php echo e(__('Add New Product')); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <?php if($product): ?>
                            <?php echo e(__('Update Product Details')); ?>

                        <?php else: ?>
                            <?php echo e(__('Add New Product')); ?>

                        <?php endif; ?>
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('product')); ?>"><?php echo e(__('Products')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php if($product): ?>
                                    <?php echo e(__('Update Product Details')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Add New Product')); ?>

                                <?php endif; ?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(url('product')); ?>">
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                        <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Product List')); ?>

                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Basic Information')); ?></blockquote>
                        <form action="<?php if($product ): ?> <?php echo e(url('product/' . $product->id)); ?> <?php else: ?> <?php echo e(route('product.store')); ?> <?php endif; ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if($product ): ?>
                                <input type="hidden" name="_method" value="PATCH" />
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Product Name ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="name" id="Name" tabindex="1"
                                                value="<?php if($product): ?><?php echo e(old('name', $product->name)); ?><?php elseif(old('name')): ?><?php echo e(old('name')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Product Name')); ?>">
                                            <?php $__errorArgs = ['name'];
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Duration (minute)')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control <?php $__errorArgs = ['duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="duration" id="Duration" tabindex="1"
                                                value="<?php if($product): ?><?php echo e(old('duration', $product->duration)); ?><?php elseif(old('duration')): ?><?php echo e(old('duration')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Total Duration of Product In Minute')); ?>">
                                            <?php $__errorArgs = ['duration'];
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Status ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="11" name="status">
                                                <option selected disabled><?php echo e(__('-- Select Status --')); ?></option>
                                                <option value="1" <?php if(($product && $product->status == '1') || old('status') == '1'): ?> selected <?php endif; ?>><?php echo e(__('Active')); ?></option>
                                                <option value="0" <?php if(($product && $product->status == '0') || old('status') == '0'): ?> selected <?php endif; ?>><?php echo e(__('In Active')); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['status'];
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
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Price ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    tabindex="4" name="price" id="Price" value="<?php if($product ): ?><?php echo e(old('price', $product->price)); ?><?php elseif(old('price')): ?><?php echo e(old('price')); ?><?php endif; ?>"
                                                    placeholder="<?php echo e(__('Enter Total Price')); ?>">
                                            <?php $__errorArgs = ['price'];
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Commission Fee ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control <?php $__errorArgs = ['commission_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="4" name="commission_fee" id="CommissionFee" value="<?php if($product ): ?><?php echo e(old('commission_fee', $product->commission_fee)); ?><?php elseif(old('commission_fee')): ?><?php echo e(old('commission_fee')); ?><?php endif; ?>"
                                                placeholder="<?php echo e(__('Enter Commission Fee That Will Be Paid to The Therapist')); ?>">
                                            <?php $__errorArgs = ['commission_fee'];
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
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php if($product): ?>
                                            <?php echo e(__('Update Product Details')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Add New Product')); ?>

                                        <?php endif; ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script>
            // Script
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project\youliantang\resources\views/product/product-details.blade.php ENDPATH**/ ?>