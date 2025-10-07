<?php $__env->startSection('title', 'Category List'); ?>
<?php $__env->startSection('content'); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                
                <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" style="display: flex;justify-content: space-between;">
                                <h5 class="card-title mb-0">Category List</h5>
                                <a href="<?php echo e(route('category.create')); ?>" class="btn btn-sm btn-primary">
                                    <i data-feather="plus"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No.</th>
                                            <th scope="col">Category Name</th>
                                            <th scope="col">Photo</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php $__currentLoopData = $Category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="text-center">
                                                <td>
                                                    <?php echo e($i + $Category->perPage() * ($Category->currentPage() - 1)); ?>

                                                </td>
                                                <td class="text-center"><?php echo e($category->categoryname); ?></td>

                                                <td class="text-center">
                                                    <?php if($category->photo): ?>
                                                        <img src="<?php echo e(asset('uploads/category') . '/' . $category->photo); ?>"
                                                            style="width: 50px;height: 50px;">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('assets/images/noimage.png')); ?>"
                                                            style="width: 50px;height: 50px;">
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($category->iStatus == 0): ?>
                                                        <span class="badge badge-gradient-danger">Inactive</span>
                                                    <?php elseif($category->iStatus == 1): ?>
                                                        <span class="badge badge-gradient-primary">Active</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="gap-2">
                                                        <?php if($category->iStatus == 0): ?>
                                                            <a href="<?php echo e(route('category.status', ['category_id' => $category->id, 'status' => 1])); ?>"
                                                                onclick="return confirm('Are you sure you want to activate this category?');"
                                                                title="InActive" class="mx-1">
                                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                                            </a>
                                                        <?php elseif($category->iStatus == 1): ?>
                                                            <a href="<?php echo e(route('category.status', ['category_id' => $category->id, 'status' => 0])); ?>"
                                                                onclick="return confirm('Are you sure you want to deactivate this category?');"
                                                                title="Active" class="mx-1">
                                                                <i class="fa fa-unlock" aria-hidden="true"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <a class="mx-1" title="Edit"
                                                            href="<?php echo e(route('category.edit', $category->id)); ?>">
                                                            <i class="far fa-edit"></i>
                                                        </a>

                                                        <a class="" href="#" data-bs-toggle="modal"
                                                            title="Delete" data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $category->id ?>);">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Delete Modal Start -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mt-2 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                    </lord-icon>
                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                        <h4>Are you Sure ?</h4>
                                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                            ?</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                    <a class="btn btn-primary mx-2" href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                        Yes,
                                        Delete It!
                                    </a>
                                    <button type="button" class="btn w-sm btn-primary mx-2"
                                        data-bs-dismiss="modal">Close</button>
                                    <form id="user-delete-form" method="POST" action="<?php echo e(route('category.delete')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <input type="hidden" name="categoryId" id="deleteid" value="">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Delete modal End -->

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\oro_veda\resources\views/admin/category/index.blade.php ENDPATH**/ ?>