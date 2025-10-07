<?php $__env->startSection('title', 'Edit Product'); ?>

<?php $__env->startSection('content'); ?>

    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                
                <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Edit Product</h4>
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
                                        action="<?php echo e(route('product.update', $product->id)); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="row gy-4">

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Category
                                                    <select class="form-control" onchange="validatecategory();"
                                                        name="categoryId" id="categoryId" required>
                                                        <option value="">Select Category Name
                                                        </option>
                                                        <?php $__currentLoopData = $Category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($category->id); ?>"
                                                                <?php echo e($product->categoryId == $category->id ? 'selected' : ''); ?>>
                                                                <?php echo e($category->categoryname); ?></option>
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
                                                    <span style="color:red;">*</span>Product Name
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Product Name" name="productname"
                                                        autocomplete="off" maxlength="255"
                                                        value="<?php echo e($product->productname); ?>" required>
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

                                            <?php
                                            $ProductImages = \App\Models\Productphotos::select('productphotosid', 'strphoto')
                                                ->where(['productphotos.iStatus' => 1, 'productphotos.isDelete' => 0, 'productid' => $product->id])
                                                ->get();
                                            $arr = [];
                                            foreach ($ProductImages as $value) {
                                                $arr[] = $value->strphoto;
                                            }
                                            ?>


                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Multiple Photo (Upto 5)
                                                    <input type="file" name="photo[]" multiple class="form-control"
                                                        id="Editphoto">
                                                    

                                                    <div class="d-flex justify-content-between mt-3 mb-3">
                                                        <?php $__currentLoopData = $ProductImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ProductImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if (in_array($ProductImage->strphoto, $arr)){ ?>
                                                            <div id="PHOTOID_<?= $ProductImage->productphotosid ?>">
                                                                <img src="<?php echo e(asset('uploads/product/thumbnail/') . '/' . $ProductImage->strphoto); ?>"
                                                                    width="50px" height="50px">

                                                                <button type="button"
                                                                    onclick="imagedelete(<?= $ProductImage->productphotosid ?>);"
                                                                    class="btn btn-link p-0">
                                                                    <span class="text-500 fas fa-trash-alt"></span>
                                                                </button>

                                                            </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <?php }?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span> Rate (MRP)
                                                    <input type="text" class="form-control" placeholder="Enter Rate"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        maxlength="5" name="rate" autocomplete="off"
                                                        value="<?php echo e($product->rate); ?>" required>
                                                    <?php $__errorArgs = ['rate'];
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
                                                        value="<?php echo e($product->cut_price); ?>" required>
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
                                                <div>
                                                    <span style="color:red;">*</span> USD Rate (MRP)
                                                    <input type="text" class="form-control" placeholder="Enter USD Rate"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        maxlength="5" name="usd_rate" autocomplete="off"
                                                        value="<?php echo e($product->usd_rate); ?>" required>
                                                    <?php $__errorArgs = ['usd_rate'];
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
                                                    <span style="color:red;">*</span>USD Cut Price (MRP)
                                                    <input type="text" class="form-control" placeholder="Enter USD Cut Price"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                        maxlength="5" name="usd_cut_price" autocomplete="off"
                                                        value="<?php echo e($product->usd_cut_price); ?>" required>
                                                    <?php $__errorArgs = ['usd_cut_price'];
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
                                                    <input type="checkbox" name="isFeatures" id="isFeatures"
                                                        <?php echo e($product->isFeatures == 1 ? 'checked' : null); ?>>
                                                    Featured Product
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span>Description
                                                <textarea class="form-control ckeditor" name="description" id="description" rows="6"><?php echo e($product->description); ?></textarea>

                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Title
                                                <textarea class="form-control" name="meta_title" id="meta_title" rows="6">
                                                    <?php echo e($product->meta_title); ?>

                                                </textarea>

                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Keyword
                                                <textarea class="form-control" name="meta_keyword" id="meta_keyword" rows="6"><?php echo e($product->meta_keyword); ?></textarea>

                                            </div>

                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span>Meta Description
                                                <textarea class="form-control" name="meta_description" id="meta_description" rows="6"><?php echo e($product->meta_description); ?></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Head
                                                <textarea class="form-control" name="head" id="head" rows="6"><?php echo e($product->head); ?></textarea>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Body
                                                <textarea class="form-control" name="body" id="body" rows="6"><?php echo e($product->body); ?></textarea>
                                            </div>

                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Update</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="<?php echo e(route('product.edit', $product->id)); ?>">Cancel</a>
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
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
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

        $(document).ready(function() {
            $('#regForm').on('submit', function() {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
    </script>

    <script>
        function imagedelete(id) {
            var url = "<?php echo e(route('product.imagedelete', ':id')); ?>";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id: id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        console.log(data);
                        var obj = JSON.parse(data);
                        $("#PHOTOID_" + id).html("");
                    }
                });
            }
        }
    </script>

    <script>
        function validatecategory() {
            var Category = $('#categoryId').val();
            var url = "<?php echo e(route('product.getEditsubcategory')); ?>";
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
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\oro_veda\resources\views/admin/product/edit.blade.php ENDPATH**/ ?>