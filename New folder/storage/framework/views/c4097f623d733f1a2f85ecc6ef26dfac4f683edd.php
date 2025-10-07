<?php $__env->startSection('title', 'Cancel List'); ?>

<?php $__env->startSection('content'); ?>


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                
                <?php echo $__env->make('common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="row">
                    <div class="col-xxl-12">
                        <h5 class="mb-3"></h5>
                        <div class="card">
                            <div class="card-body">
                                <!-- Nav tabs -->

                                <?php echo $__env->make('admin.order.orderTab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" id="form" action="<?php echo e(route('order.cancel')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="row  align-items-center">
                                                    <div class="col-md-3  mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <input placeholder="Enter From Date" type="text"
                                                                class="form-control" id="startdatepicker" name="fromdate"
                                                                autocomplete="off"
                                                                value="<?= isset($FromDate) ? $FromDate : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3  mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <input placeholder="Enter To Date" type="text"
                                                                class="form-control" name="todate" autocomplete="off"
                                                                id="enddatepicker"
                                                                value="<?= isset($ToDate) ? $ToDate : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3  mb-2">
                                                        <div class="input-group d-flex justify-content-right">
                                                            <button type="submit" class="btn btn-primary mx-2">
                                                                Search
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content text-muted">
                                    <div class="tab-pane active" id="PendingOrder" role="tabpanel">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">

                                                            <table id="scroll-horizontal" class="table nowrap align-middle"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="all">Sr.No</th>
                                                                        <th class="all">Order Date</th>
                                                                        <th class="all">Customer Name</th>

                                                                        <th class="all">Email</th>
                                                                        <th class="all">Mobile</th>
                                                                        <th class="all">City</th>
                                                                        <th class="all">State</th>
                                                                        <th class="all">Pincode</th>
                                                                        <th class="all">Total</th>
                                                                        <th class="all">Payment Status</th>
                                                                        <th class="all">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    ?>
                                                                    <?php $__currentLoopData = $Cancel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cancel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr class="text-center">
                                                                            <td>
                                                                                <?php echo e($i + $Cancel->perPage() * ($Cancel->currentPage() - 1)); ?>

                                                                            </td>
                                                                            <td><?php echo e(date('d-m-Y', strtotime($cancel->created_at))); ?>

                                                                            </td>
                                                                            <td>
                                                                                <?php echo e($cancel->shipping_cutomerName); ?>

                                                                            </td>

                                                                            <td><?php echo e($cancel->shipping_email); ?></td>
                                                                            <td><?php echo e($cancel->shipping_mobile); ?></td>
                                                                            <td><?php echo e($cancel->shipping_city); ?></td>
                                                                            <td><?php echo e($cancel->stateName); ?></td>
                                                                            <td><?php echo e($cancel->shipping_pincode); ?></td>
                                                                            <td><?php echo e($cancel->netAmount); ?></td>
                                                                            <td>
                                                                                <?php if($cancel->isPayment == 0): ?>
                                                                                    Pending
                                                                                <?php elseif($cancel->isPayment == 1): ?>
                                                                                    Success
                                                                                <?php else: ?>
                                                                                    Failed
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td>
                                                                                <a href="<?php echo e(route('order.statustopending', $cancel->order_id)); ?>"
                                                                                    onclick="return confirm('Are you Sure You wanted to Pending?');"
                                                                                    class="mx-2" title="Pending">
                                                                                    <i class="fa-solid fa-clock fa-lg"></i>
                                                                                </a>
                                                                                <a class="mx-2"
                                                                                    href="<?php echo e(route('order.orderdetail', $cancel->order_id)); ?>"
                                                                                    title="Details">
                                                                                    <i
                                                                                        class="fa-solid fa-circle-info fa-lg"></i>
                                                                                </a>

                                                                                <a class="mx-2" target="_blank"
                                                                                    href="<?php echo e(route('order.DetailPDF', $cancel->order_id)); ?>"
                                                                                    title="Pdf Details">
                                                                                    <i
                                                                                        class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php $i++; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                                </tbody>

                                                            </table>
                                                            <div class="d-flex justify-content-center mt-3">
                                                                <?php echo e($Cancel->appends(request()->except('page'))->links()); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#startdatepicker").datepicker({
                dateFormat: 'd-m-yy',
                //minDate: 0
            });
        });

        $(function() {
            $("#enddatepicker").datepicker({
                dateFormat: 'd-m-yy',
                //minDate: 0
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/admin/order/cancel.blade.php ENDPATH**/ ?>