<?php $__env->startSection('title', 'Add Product'); ?>

<?php $__env->startSection('content'); ?>


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                
                <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add Product</h4>
                            <div class="page-title-right">
                                <a href="<?php echo e(route('product.index')); ?>"
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
                                    <form id="regForm" method="POST" onsubmit="return validateFile()"
                                        action="<?php echo e(route('product.store')); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Category
                                                    <select onchange="validatecategory();" class="form-control"
                                                        id="categoryId" name="categoryId" required>
                                                        <option value="">Select Category Name </option>
                                                        <?php $__currentLoopData = $Category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($category->id); ?>"
                                                                <?php echo e(old('categoryId') == $category->id ? 'selected' : ''); ?>>
                                                                <?php echo e($category->categoryname); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <?php $__errorArgs = ['categoryId'];
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

                                            

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Product Name
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Product Name" name="productname"
                                                        autocomplete="off" maxlength="255" value="<?php echo e(old('productname')); ?>"
                                                        required>
                                                    <?php $__errorArgs = ['productname'];
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

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Multiple Photo (Upto 5)
                                                    <input type="file" class="form-control" name="photo[]" multiple
                                                        id="strPhoto" required>
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

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Rate (MRP)
                                                    <input type="text" class="form-control" name="rate" id="strPhoto"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        maxlength="5" placeholder="Enter Rate" required autocomplete="off">
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

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Cut Price (MRP)
                                                    <input type="text" class="form-control" placeholder="Enter Cut Price"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        maxlength="5" name="cut_price" autocomplete="off"
                                                        value="<?php echo e(old('cut_price')); ?>" required autocomplete="off">
                                                    <?php $__errorArgs = ['cut_price'];
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

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isFeatures" id="isFeatures">
                                                    Featured Product
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span> Description
                                                <textarea class="form-control ckeditor" name="description" id="description" rows="6"></textarea>
                                                <?php $__errorArgs = ['description'];
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

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Title
                                                <textarea class="form-control" name="meta_title" id="meta_title" rows="6"></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Keyword
                                                <textarea class="form-control" name="meta_keyword" id="meta_keyword" rows="6"></textarea>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span>Meta Description
                                                <textarea class="form-control" name="meta_description" id="meta_description" rows="6"></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Head
                                                <textarea class="form-control" name="head" id="head" rows="6"></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Body
                                                <textarea class="form-control" name="body" id="body" rows="6"></textarea>
                                            </div>

                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Save</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="<?php echo e(route('product.index')); ?>">Cancel</a>
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


    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
            var fileExtension = document.getElementById('strPhoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }

            if (!isValidFile) {
                alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
            }

            return isValidFile;
        }
    </script>

    <script>
        function validatecategory() {
            var Category = $('#categoryId').val();
            var url = "<?php echo e(route('product.getsubcategory')); ?>";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    Category,
                    Category
                },
                success: function(data) {
                    console.log(data);
                    $("#subcategoryid").html(data);
                }
            });
        }

        $(document).ready(function() {
            $('#regForm').on('submit', function() {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/admin/product/add.blade.php ENDPATH**/ ?>