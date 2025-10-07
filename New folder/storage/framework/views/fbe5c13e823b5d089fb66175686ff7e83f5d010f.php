<!DOCTYPE html>
<html lang="en">

<?php echo $__env->make('common.front.fronthead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">

    <?php echo $__env->make('common.front.frontheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('common.front.frontfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <?php echo $__env->make('common.front.frontfooterjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('scripts'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>



</html>
<?php /**PATH /home4/sparsvss/sparsh/resources/views/layouts/front.blade.php ENDPATH**/ ?>