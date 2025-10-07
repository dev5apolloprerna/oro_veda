<?php $__env->startSection('title', 'Inquiry List'); ?>

<?php $__env->startSection('content'); ?>

    
    <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                
                <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Inquiry List</h5>
                            </div>
                            <div class="card-body">
                                <?php //echo date('ymd');
                                ?>
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th width="5%">Name</th>
                                            <th width="2%">Mobile</th>
                                            <th width="2%">Email</th>
                                            <th width="1%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="text-center">
                                                <td><?php echo e($i + $inquiries->perPage() * ($inquiries->currentPage() - 1)); ?>

                                                <td><?php echo e($inquiry->name); ?></td>
                                                <td><?php echo e($inquiry->mobileNumber); ?></td>
                                                <td><?php echo e($inquiry->email); ?></td>
                                                <td>
                                                    <div class="gap-2">
                                                        <a class="mx-1" title="View" href="#"
                                                            onclick="viewData(<?= $inquiry->inquiry_id ?>)"
                                                            data-bs-toggle="modal" data-bs-target="#ViewModal">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a class="" href="#" data-bs-toggle="modal"
                                                            title="Delete" data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $inquiry->inquiry_id ?>);">
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
                                    <?php echo e($inquiries->links()); ?>

                                </div>
                            </div>
                        </div>
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
                        <button type="button" class="btn w-sm btn-primary mx-2" data-bs-dismiss="modal">Close</button>
                        <form id="user-delete-form" method="POST" action="<?php echo e(route('Inquiry.delete')); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <input type="hidden" name="inquiry_id" id="deleteid" value="">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Delete modal End -->

    <!--View Modal Start-->
    <div class="modal fade flip" id="ViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title"> Inquiry Detail </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <div class="model-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table width="100%">
                            <tbody>
                                <tr>
                                    <td class="text-center" style="width: 20%;text-align: justify;padding: 5px;">Name</td>
                                    <td class="text-center" id="showname"></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 20%;text-align: justify;padding: 5px;">Subject</td>
                                    <td class="text-center" id="showsubject"></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 20%;text-align: justify;padding: 5px;">Mobile</td>
                                    <td class="text-center" id="showmobileNumber"></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 20%;text-align: justify;padding: 5px;">Email</td>
                                    <td class="text-center" id="showemail"></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 20%;padding: 5px;">Message</td>
                                    <td class="text-center" id="showMessage"></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
    <!--View Modal End -->


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }

        function viewData(id) {
            var url = "<?php echo e(route('Inquiry.viewdetail', ':id')); ?>";
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
                        $("#modal-title").html(obj.name);
                        $("#showname").html(obj.name);
                        $("#showsubject").html(obj.subject);
                        $("#showmobileNumber").html(obj.mobileNumber);
                        $("#showemail").html(obj.email);
                        $("#showMessage").html(obj.message);
                    }
                });
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/admin/inquiries/index.blade.php ENDPATH**/ ?>