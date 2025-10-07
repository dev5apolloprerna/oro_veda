<?php $__env->startSection('title', 'Edit Profile'); ?>

<?php $__env->startSection('content'); ?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid mt-4">

                
                <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="position-relative mx-n4 mt-n4">
                    <div class="profile-wid-bg profile-setting-img">
                        <img src="<?php echo e(asset('assets/images/profile-bg.jpg')); ?>" class="profile-wid-img" alt="">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <img src="<?php echo e(asset('assets/images/users/undraw_profile.webp')); ?>"
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                            alt="user-profile-image">
                                    </div>
                                    <h5 class="mb-1"><?php echo e(auth()->user()->full_name); ?></h5>
                                    <?php
                                    $session = auth()->user()->id;
                                    $role = App\Models\User::select('users.id', 'roles.name')
                                        ->where('users.id', $session)
                                        ->join('roles', 'users.role_id', '=', 'roles.id')
                                        ->first();
                                    ?>
                                    <p class="text-muted mb-0">
                                        <?php echo e($role->name); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                            role="tab">
                                            <i class="fas fa-home"></i> Personal Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                            <i class="far fa-user"></i> Change Password
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>First Name
                                                        <input type="text"
                                                            class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="first_name" id="firstnameInput"
                                                            placeholder="Enter Your FirstName" maxlength="100"
                                                            value="<?php echo e(old('first_name') ? old('first_name') : auth()->user()->first_name); ?>"
                                                            autocomplete="off" required>

                                                        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Last Name
                                                        <input type="text"
                                                            class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="lastnameInput" name="last_name"
                                                            placeholder="Enter Your LastName" maxlength="100"
                                                            value="<?php echo e(old('last_name') ? old('last_name') : auth()->user()->last_name); ?>"
                                                            autocomplete="off" required>

                                                        <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Email
                                                        <input type="email" name="email"
                                                            class="form-control  <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            maxlength="100" id="emailInput" placeholder="Enter Your Email"
                                                            value="<?php echo e(old('email') ? old('email') : auth()->user()->email); ?>"
                                                            autocomplete="off" required>

                                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Phone
                                                        <input type="text"
                                                            class="form-control <?php $__errorArgs = ['mobile_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="phonenumberInput" placeholder="Enter your phone number"
                                                            name="mobile_number"
                                                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                                            minlength="10" maxlength="10"
                                                            value="<?php echo e(old('mobile_number') ? old('mobile_number') : auth()->user()->mobile_number); ?>"
                                                            autocomplete="off" required>

                                                        <?php $__errorArgs = ['mobile_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>



                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Updates</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <form action="<?php echo e(route('profile.change-password')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="row g-2" style="align-items: end;">
                                                <div class="col-lg-3">
                                                    <div>
                                                        <span style="color:red;">*</span>Old
                                                        Password
                                                        <input type="password" name="current_password"
                                                            class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="oldpasswordInput" placeholder="Enter current password"
                                                            required>
                                                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div>
                                                        <span style="color:red;">*</span>New
                                                        Password
                                                        <input type="password"
                                                            class="form-control <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            required name="new_password"id="newpasswordInput"
                                                            placeholder="Enter new password" minlength="4"
                                                            maxlength="20">
                                                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div>
                                                        <span style="color:red;">*</span>Confirm
                                                        Password
                                                        <input type="password"
                                                            class="form-control <?php $__errorArgs = ['new_confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="new_confirm_password" required id="confirmpasswordInput"
                                                            minlength="4" maxlength="20" placeholder="Confirm password">
                                                        <?php $__errorArgs = ['new_confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>

                                                <!--end col-->
                                                <div class="col-lg-3">
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-success">Change
                                                            Password</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

            </div>
            <!-- container-fluid -->
        </div><!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © PY Engineering.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/Editprofile.blade.php ENDPATH**/ ?>