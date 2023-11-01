
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Update Therapist Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>">
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
                        <?php echo e(__('Update Therapist Details')); ?>

                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('therapist')); ?>"><?php echo e(__('Therapists')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php echo e(__('Update Therapist Details')); ?>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <?php if($therapist && $therapist_info): ?>
                    <?php if($role == 'therapist'): ?>
                        <a href="<?php echo e(url('/')); ?>">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Dashboard')); ?>

                            </button>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(url('therapist/' . $therapist->id)); ?>">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Profile')); ?>

                            </button>
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(url('therapist')); ?>">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Therapist List')); ?>

                        </button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Basic Information')); ?></blockquote>

                        <form action="<?php echo e(url('therapist/' . $therapist->id)); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if($therapist && $therapist_info): ?>
                                <input type="hidden" name="_method" value="PATCH" />
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('First Name ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="first_name" id="firstname" tabindex="1"
                                                value="<?php echo e(old('first_name', $therapist->first_name)); ?>"
                                                placeholder="<?php echo e(__('Enter First Name')); ?>">
                                            <?php $__errorArgs = ['first_name'];
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
                                            <label class="control-label"><?php echo e(__('ID Card ')); ?><span
                                                class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control <?php $__errorArgs = ['ktp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="ktp" id="lastname" tabindex="2"
                                                value="<?php echo e(old('ktp', $therapist_info->ktp)); ?>"
                                                placeholder="<?php echo e(__('Enter ID Card')); ?>">
                                            <?php $__errorArgs = ['ktp'];
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
                                            <label class="control-label"><?php echo e(__('Email ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="email" id="email" tabindex="3"
                                                value="<?php echo e(old('email', $therapist->email)); ?>"
                                                placeholder="<?php echo e(__('Enter Email')); ?>">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Place Of Birth ')); ?></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['place_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="place_of_birth" id="place_of_birth" tabindex="4"
                                                value="<?php echo e(old('place_of_birth', $therapist_info->place_of_birth)); ?>"
                                                placeholder="<?php echo e(__('Enter Place Of Birth')); ?>">
                                            <?php $__errorArgs = ['place_of_birth'];
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
                                            <label class="control-label"><?php echo e(__('Address ')); ?></label>
                                            <textarea rows="3"
                                                class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="address" tabindex="5" id="address"
                                                placeholder="<?php echo e(__('Enter Address')); ?>"><?php echo e(old('address', $therapist_info->address)); ?></textarea>
                                            <?php $__errorArgs = ['address'];
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
                                            <label class="control-label"><?php echo e(__('Emergency Contact ')); ?></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['emergency_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="emergency_contact" id="emergency_contact" tabindex="6"
                                                value="<?php echo e(old('emergency_contact', $therapist_info->emergency_contact)); ?>"
                                                placeholder="<?php echo e(__('Enter Emergency Contact')); ?>">
                                            <?php $__errorArgs = ['emergency_contact'];
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
                                            <label class="control-label"><?php echo e(__('Emergency Name ')); ?></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['emergency_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="emergency_name" id="emergency_name" tabindex="7"
                                                value="<?php echo e(old('emergency_name', $therapist_info->emergency_name)); ?>"
                                                placeholder="<?php echo e(__('Enter Emergency Name')); ?>">
                                            <?php $__errorArgs = ['emergency_name'];
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
                                        <?php if($availableDay): ?>
                                            <div class="col-md-12 form-group">
                                                <label class="control-label d-block"><?php echo e(__("Therapist available days")); ?> <span
                                                        class="text-danger">*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                        value="1" name="sun" <?php echo e($availableDay->sun == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox1">Sun</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                        value="1" name="mon" <?php echo e($availableDay->mon == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox2">Mon</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                        value="1" name="tue" <?php echo e($availableDay->tue == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox3">Tue</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                                        value="1" name="wen" <?php echo e($availableDay->wen == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox4">Wen</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5"
                                                        value="1" name="thu" <?php echo e($availableDay->thu == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox5">Thu</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6"
                                                        value="1" name="fri" <?php echo e($availableDay->fri == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox6">Fri</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7"
                                                        value="1" name="sat" <?php echo e($availableDay->sat == 1 ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="inlineCheckbox7">Sat</label>
                                                </div>
                                                <?php $__errorArgs = ['mon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="error d-block " role="alert">
                                                        <strong>Select any one days</strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="control-label"><?php echo e(__('Last Name ')); ?></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="last_name" id="lastname" tabindex="8"
                                                value="<?php echo e(old('last_name', $therapist->last_name)); ?>"
                                                placeholder="<?php echo e(__('Enter Last Name')); ?>">
                                            <?php $__errorArgs = ['last_name'];
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
                                        <div class="col-md-6 form-group">
                                            <label class="control-label"><?php echo e(__('Gender ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control select2 <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="gender" id="gender">
                                                <option value="" disabled selected>-</option>
                                                <option value="<?php echo e('Male'); ?>" <?php echo e(old('gender', $therapist_info->gender) == 'Male' ? 'selected' : ''); ?>><?php echo e('Male'); ?></option>
                                                <option value="<?php echo e('Female'); ?>" <?php echo e(old('gender', $therapist_info->gender) == 'Female' ? 'selected' : ''); ?>><?php echo e('Female'); ?></option>
                                            </select>
                                            <?php $__errorArgs = ['gender'];
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
                                            <label class="control-label"><?php echo e(__('Phone Number ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" class="form-control <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="phone_number" id="phone_number" tabindex="9"
                                                value="<?php echo e(old('phone_number', $therapist->phone_number)); ?>"
                                                placeholder="<?php echo e(__('Enter Phone Number')); ?>">
                                            <?php $__errorArgs = ['phone_number'];
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
                                        <div class="col-md-6 form-group">
                                            <label class="control-label"><?php echo e(__('Birth Date ')); ?></label>
                                            <input type="date" class="form-control <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="birth_date" id="birth_date" tabindex="10"
                                                value="<?php echo e(old('birth_date', $therapist_info->birth_date)); ?>"
                                                placeholder="<?php echo e(__('Enter Birth Date')); ?>">
                                            <?php $__errorArgs = ['birth_date'];
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
                                            <label class="control-label"><?php echo e(__('Rekening Number ')); ?><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['rekening_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="rekening_number" id="rekening_number" tabindex="11"
                                                value="<?php echo e(old('rekening_number', $therapist_info->rekening_number)); ?>"
                                                placeholder="<?php echo e(__('Enter Rekening Number')); ?>">
                                            <?php $__errorArgs = ['rekening_number'];
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
                                            <label class="control-label"><?php echo e(__('Profile Photo ')); ?></label>
                                            <img class="<?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                src=" <?php if($therapist && $therapist_info &&
                                                $therapist->profile_photo != null): ?>
                                            <?php echo e(URL::asset('storage/images/users/' . $therapist->profile_photo)); ?>

                                        <?php else: ?> <?php echo e(URL::asset('assets/images/users/noImage.png')); ?> <?php endif; ?>"
                                            id="profile_display" onclick="triggerClick()"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Click to Upload Profile Photo" />
                                            <input type="file"
                                                class="form-control <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                tabindex="12" name="profile_photo" id="profile_photo" style="display:none;"
                                                onchange="displayProfile(this)">
                                            <?php $__errorArgs = ['profile_photo'];
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
                                        <div class="col-md-6 form-group">
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
                                                tabindex="13" name="status">
                                                <option selected disabled><?php echo e(__('-- Select Status --')); ?></option>
                                                <option value="1" <?php if(($therapist_info->status == '1') || old('status') == '1'): ?> selected <?php endif; ?>><?php echo e(__('Active')); ?></option>
                                                <option value="0" <?php if(($therapist_info->status == '0') || old('status') == '0'): ?> selected <?php endif; ?>><?php echo e(__('In Active')); ?></option>
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php if($therapist && $therapist_info): ?>
                                            <?php echo e(__('Update Details')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Add New Therapist')); ?>

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
        <script src="<?php echo e(URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js')); ?>"></script>
        <!-- form init -->
        <script src="<?php echo e(URL::asset('assets/js/pages/form-repeater.int.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/form-advanced.init.js')); ?>"></script>
        <script>
            // Profile Photo
            function triggerClick() {
                document.querySelector('#profile_photo').click();
            }

            function displayProfile(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#profile_display').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }
            // Time validation
            var timecount = $('.timecount').length;
            let cf = 0;
            let error = 0;

            function valinput0() {
                var startTime = $('input[name="TimeSlot[0][from]"]').val();
                var endTime = $('input[name="TimeSlot[0][to]"]').val();
                var st = startTime.split(":");
                var et = endTime.split(":");
                var sst = new Date();
                sst.setHours(st[0]);
                sst.setMinutes(st[1]);
                var eet = new Date();
                eet.setHours(et[0]);
                eet.setMinutes(et[1]);
                if (sst > eet) {
                    error = 1;
                    $('.para').html('to value is bigger then from');
                    $('.para').addClass('d-block');
                } else {
                    error = 0;
                    $('.para').removeClass('d-block');
                }
            }

            function change() {
                cf++;
                setTimeout(function() {
                    $(document).on('change', `input[name="TimeSlot[${cf}][to]"]`, function() {
                        validate1();
                    });
                }, 100);
            }

            function validate1() {
                timecount = $('.timecount').length;
                for (let i = 0; i < timecount; i++) {
                    var startTime = $('input[name="TimeSlot[' + i + '][from]"]').val();
                    var endTime = $('input[name="TimeSlot[' + i + '][to]"]').val();
                    currenttime = $(`input[name="TimeSlot[${cf}][from]"]`).val();
                    currentto = $(`input[name="TimeSlot[${cf}][to]"]`).val();
                    var st = startTime.split(":");
                    var et = endTime.split(":");
                    var ct = currenttime.split(":");
                    var cft = currentto.split(":");
                    var sst = new Date();
                    sst.setHours(st[0]);
                    sst.setMinutes(st[1]);
                    var eet = new Date();
                    eet.setHours(et[0]);
                    eet.setMinutes(et[1]);
                    var cct = new Date();
                    cct.setHours(ct[0]);
                    cct.setMinutes(ct[1]);
                    var cff = new Date();
                    cff.setHours(cft[0]);
                    cff.setMinutes(cft[1]);
                    if (cct < cff) {
                        if (sst < cct && eet > cct) {
                            error = 1;
                            $('.para').html('Value not accepted');
                            $('.para').addClass('d-block');
                            break
                        } else {
                            error = 0;
                            $('.para').removeClass('d-block');
                        }
                    } else {
                        $('.para').html('to value is bigger then from');
                        $('.para').addClass('d-block');
                        break
                    }
                }
            }
            // Checkbox value check
            $('#inlineCheckbox1').on('change', function() {
                var inlineCheckbox1 = $('#inlineCheckbox1').is(':checked') ? '1' : '0';
                $('#inlineCheckbox1').val(inlineCheckbox1);
            }).change();
            $('#inlineCheckbox2').on('change', function() {
                var inlineCheckbox2 = $('#inlineCheckbox2').is(':checked') ? '1' : '0';
                $('#inlineCheckbox2').val(inlineCheckbox2);
            }).change();
            $('#inlineCheckbox3').on('change', function() {
                var inlineCheckbox3 = $('#inlineCheckbox3').is(':checked') ? '1' : '0';
                $('#inlineCheckbox3').val(inlineCheckbox3);
            }).change();
            $('#inlineCheckbox4').on('change', function() {
                var inlineCheckbox4 = $('#inlineCheckbox4').is(':checked') ? '1' : '0';
                $('#inlineCheckbox4').val(inlineCheckbox4);
            }).change();
            $('#inlineCheckbox5').on('change', function() {
                var inlineCheckbox5 = $('#inlineCheckbox5').is(':checked') ? '1' : '0';
                $('#inlineCheckbox5').val(inlineCheckbox5);
            }).change();
            $('#inlineCheckbox6').on('change', function() {
                var inlineCheckbox6 = $('#inlineCheckbox6').is(':checked') ? '1' : '0';
                $('#inlineCheckbox6').val(inlineCheckbox6);
            }).change();
            $('#inlineCheckbox7').on('change', function() {
                var inlineCheckbox7 = $('#inlineCheckbox7').is(':checked') ? '1' : '0';
                $('#inlineCheckbox7').val(inlineCheckbox7);
            }).change();
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Data\Project\youliantang\resources\views/therapist/therapist-edit.blade.php ENDPATH**/ ?>