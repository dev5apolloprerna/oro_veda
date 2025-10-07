<ul class="nav nav-pills animation-nav nav-justified mb-3" role="tablist">
    <li class="nav-item ">
        <a class="nav-link <?php if(request()->routeIs('order.pending')): ?> <?php echo e('active'); ?> <?php endif; ?> ||  <?php if(request()->routeIs('order.pendingOrder')): ?> <?php echo e('active'); ?> <?php endif; ?>"
            href="<?php echo e(route('order.pending')); ?>" role="tab">
            Pending Order <span class="badge bg-danger rounded-circle"></span>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link <?php if(request()->routeIs('order.dispatched')): ?> <?php echo e('active'); ?> <?php endif; ?>"
            href="<?php echo e(route('order.dispatched')); ?>" role="tab">
            Dispatched Order <span class="badge bg-danger rounded-circle"></span>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link <?php if(request()->routeIs('order.cancel')): ?> <?php echo e('active'); ?> <?php endif; ?>"
            href="<?php echo e(route('order.cancel')); ?>" role="tab">
            Cancel Order<span class="badge bg-danger rounded-circle"></span>
        </a>
    </li>

</ul>
<?php /**PATH C:\wamp64\www\oro_veda\resources\views/admin/order/orderTab.blade.php ENDPATH**/ ?>