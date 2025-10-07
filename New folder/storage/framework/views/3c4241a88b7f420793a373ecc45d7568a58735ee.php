<?php $__env->startSection('title', 'Edit Category'); ?>

<?php $__env->startSection('content'); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                
                <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Edit Category</h4>
                            <div class="page-title-right">
                                <a href="<?php echo e(route('category.index')); ?>"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="live-preview">
                                    <form method="POST" onsubmit="return validateFile()"
                                        action="<?php echo e(route('category.update')); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>

                                        <input type="hidden" name="categoryId" value="<?php echo e($data->id); ?>">
                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    Category Name <span style="color:red;">*</span>
                                                    <input type="text" class="form-control" placeholder="Enter Name"
                                                        name="categoryname" id="categoryname" autocomplete="off"
                                                        value="<?php echo e($data->categoryname); ?>" required>
                                                </div>
                                                <?php $__errorArgs = ['categoryname'];
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

                                            <div class="col-lg-3 col-md-6">
                                                <div>
                                                    Photo <span style="color:red;"></span>
                                                    <input type="file" class="form-control" name="photo" id="strPhoto"
                                                        value="<?php echo e($data->photo); ?>">
                                                    <input type="hidden" name="hiddenPhoto" class="form-control"
                                                        value="<?php echo e(old('photo') ? old('photo') : $data->photo); ?>"
                                                        id="hiddenPhoto">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-6">
                                                <div id="viewimg">
                                                    <?php if($data->photo): ?>
                                                        <img src="<?php echo e(asset('uploads/category') . '/' . $data->photo); ?>"
                                                            alt="" height="70" width="70">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('assets/images/noimage.png')); ?>"
                                                            style="width: 50px;height: 50px;">
                                                    <?php endif; ?>
                                                    <?php $__errorArgs = ['photo'];
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

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Title</label>
                                                <textarea class="form-control" name="meta_title" id="meta_title" rows="3"><?php echo e($data->meta_title); ?></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Keyword</label>
                                                <textarea class="form-control" name="meta_keyword" id="meta_keyword" rows="3"><?php echo e($data->meta_keyword); ?></textarea>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span>Meta Description</label>
                                                <textarea class="form-control" name="meta_description" id="meta_description" rows="3"><?php echo e($data->meta_description); ?></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Head</label>
                                                <textarea class="form-control" name="head" id="head" rows="3"><?php echo e($data->head); ?></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Body</label>
                                                <textarea class="form-control" name="body" id="body" rows="3"><?php echo e($data->body); ?></textarea>
                                            </div>


                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Update</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="<?php echo e(route('category.index')); ?>">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp', ''];
            var fileExtension = document.getElementById('strPhoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;
            var image = document.getElementById('strPhoto').value;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (image != "") {
                if (!isValidFile) {
                    alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
                }
                return isValidFile;
            }

            return true;
        }
    </script>

    
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#strPhoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#viewimg').html(html);
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\oro_veda\resources\views/admin/category/edit.blade.php ENDPATH**/ ?>