<?php $__env->startSection('title', 'Contact'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('common.contactalert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb  mb-30">
                        <a class="breadcrumb-item text-dark" href="<?php echo e(route('FrontIndex')); ?>">Home</a>

                        <span class="breadcrumb-item active">Contact us</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <!-- Contact Start -->
    <section class="section-padding contact">
        <div class="container-fluid">
            <h5 class="section-title position-relative text-uppercase mx-xl-5 "><span class="bg-primary pr-3">
                    Contact Us</span>
            </h5>
            <div class="row px-xl-5">
                <div class="col-lg-7 ">
                    <div class="contact-form bg-light p-30">
                        <div id="success"></div>

                        <form method="POST" action="<?php echo e(route('contact_us_store')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Your Name" required="required" value="<?php echo e(old('name')); ?>"
                                    data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                            </div>

                            <div class="form-group">
                                <input type="text" name="mobileNumber" class="form-control" id="mobileNumber"
                                    placeholder="Your Mobile" required="required" value="<?php echo e(old('mobileNumber')); ?>"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    maxlength="10" minlength="10"
                                    data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Your Email" required="required" value="<?php echo e(old('email')); ?>"
                                    data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>

                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" id="subject"
                                    placeholder="Subject" required="required" value="<?php echo e(old('subject')); ?>"
                                    data-validation-required-message="Please enter a subject" />
                                <p class="help-block text-danger"></p>
                            </div>

                            <div class="form-group">
                                <textarea name="message" class="form-control" rows="8" id="message" placeholder="Message" required="required"
                                    data-validation-required-message="Please enter your message"><?php echo e(old('message')); ?></textarea>
                                <p class="help-block text-danger"></p>
                            </div>

                            <div class="form-group<?php echo e($errors->has('captcha') ? ' has-error' : ''); ?>">

                                <div class="form-group mt-4 mb-4">
                                    <div class="captcha">
                                        <span><?php echo captcha_img(); ?></span>
                                        <button type="button" class="btn btn-danger" class="reload" id="reload">
                                            &#x21bb;
                                        </button>
                                    </div>
                                </div>
                                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                    name="captcha" required>
                                <?php if($errors->has('captcha')): ?>
                                    <span class="help-block">
                                        <strong class=""><?php echo e($errors->first('captcha')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div>
                                <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">
                                    Send Message
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-5 mb-5">

                    <div class="bg-light p-30 ">
                        <p class="mb-2 p-0 card d-flex"><i class="fa fa-map-marker-alt text-primary mr-3"></i>
                       <span style="position:absolute; left:80px"> 4TH FLOOR, A - 419 ABHISHEK-2 COMMERCIAL COMPLEX, HARIPURA GAM, ASARWA Ahmedabad 380013</span>
                        </p>
                        <p class="mb-2 card"><i class="fa fa-envelope text-primary mr-3"></i>Contact@sparshcosmo-group.com</p>
                        <p class="mb-2 card"><i class="fa fa-phone-alt text-primary mr-3"></i>81560 88203</p>
                    </div>
                    <div class="bg-light p-30 mb-30">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact End -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script type="text/javascript">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'refresh_captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/frontview/contact.blade.php ENDPATH**/ ?>