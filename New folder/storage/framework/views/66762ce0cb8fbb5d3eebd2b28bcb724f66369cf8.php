<?php $__env->startSection('title', 'Video List'); ?>
<?php $__env->startSection('content'); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                
                <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-body">
                                <div class="row">


                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between card-header">
                                            <h5 class="card-title mb-0">Video List</h5>
                                        </div>

                                        <table id="scroll-horizontal" class="table nowrap align-middle mt-3"
                                            style="width:100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No</th>
                                                    <th>Url</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="text-center">
                                                        <td><?php echo e($i + $datas->perPage() * ($datas->currentPage() - 1)); ?>

                                                        </td>
                                                        <td>
                                                            <a target="_blank" href="<?php echo e($data->url); ?>">
                                                                <?php echo e($data->url); ?>

                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="gap-2">
                                                                <a class="mx-1" title="Edit" href="#"
                                                                    onclick="getEditData(<?= $data->id ?>)"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#showModal">
                                                                    <i class="far fa-edit"></i>
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center mt-3">
                                            <?php echo e($datas->links()); ?>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>


                    </div>
                </div>


<!--Edit Modal Start-->
        <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form method="POST" action="<?php echo e(route('video.update')); ?>"
                        autocomplete="off" >
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" id="video_id" value="">

                        <div class="modal-body">

                            <div class="mb-3">
                                <span style="color:red;">*</span>Url
                                <input type="text" class="form-control" name="url" id="Editurl"
                                    placeholder="Enter URL" autocomplete="off" required>
                                <?php $__errorArgs = ['url'];
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
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-success" id="add-btn">Update</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Edit Modal End -->

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

   <script>
            function getEditData(id) {
                var url = "<?php echo e(route('video.edit', ':id')); ?>";
                url = url.replace(":id", id);
                if (id) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id,
                            id
                        },
                        success: function(data) {
                            
                            var obj = JSON.parse(data);
                            $("#Editurl").val(obj.url);
                            $('#video_id').val(id);
                        }
                    });
                }
            }
        </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/admin/video/index.blade.php ENDPATH**/ ?>