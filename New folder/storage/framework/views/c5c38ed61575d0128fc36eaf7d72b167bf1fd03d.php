<?php $__env->startSection('title', 'Cart'); ?>
<?php $__env->startSection('content'); ?>
    
    <style>
        .badge-success {
            background-color: #28a745;
            color: #fff;
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }
        
        .btn-outline-danger {
            border: none;
            color: #dc3545;
        }
        
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

    </style>

    <?php echo $__env->make('common.frontmodalalert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Breadcrumb Start -->
    <section class="breadcrumb-section">
        <div class="container-fluid ">
            <div class="row py-5">
                <div class="col-5 mx-auto">
                    <h3 class="slogan">Quality Made Trust Delivered
                    </h3>
                    <nav class="breadcrumb  mb-30">
                        <a class="breadcrumb-item text-dark" href="<?php echo e(route('FrontIndex')); ?>">Home</a>
                        <span class="breadcrumb-item active">Cart</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->


    <?php if(\Cart::isEmpty()): ?>
        <div class="col-lg-12 text-center py-5">
            <img src="<?php echo e(asset('assets/front/img/no-product.gif')); ?>" alt="No Products"
                style="max-width: 300px; margin-top: 20px;"> <br>
            <a href="<?php echo e(route('FrontIndex')); ?>" class="btn btn-primary mt-3">Back to Home</a>
        </div>
    <?php else: ?>
        <!-- Cart Start -->
        <section class="section-padding">
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <div class="col-lg-8 table-responsive mb-5">
                        <table class="table table-light table-borderless table-hover text-center mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">

                                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="align-middle">
                                            <img src="<?php echo e(asset('uploads/product') . '/' . $item->attributes->image); ?>"
                                                alt="" style="width: 50px;">
                                            <?php echo e($item->name); ?>

                                        </td>
                                        <td class="align-middle">
                                            ₹<?php echo e($item->price . ' (' . $item->attribute_text . ')'); ?>

                                        </td>
                                        <td class="align-middle">
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-secondary btn-minus"
                                                        onclick="decreaseCount(this, <?php echo e($item->id); ?>)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm bg-secondary border-0 text-center"
                                                    value="<?php echo e($item->quantity); ?>" id="quantity_<?php echo e($item->id); ?>"
                                                    data-price="<?php echo e($item->price); ?>" readonly>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-secondary btn-plus"
                                                        onclick="increaseCount(this, <?php echo e($item->id); ?>)">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="align-middle">₹<span
                                                id="total_<?php echo e($item->id); ?>"><?php echo e($item->price * $item->quantity); ?></span>
                                        </td>

                                        <td class="align-middle">
                                            <form action="<?php echo e(route('cart.remove')); ?>" method="post"
                                                onsubmit="return confirm('Are you sure you want to remove this item?');">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"></i></button>

                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">

                        <form class="mb-30" action="<?php echo e(route('couponcodeapply')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="totalAmount" value="<?php echo e(\Cart::getTotal()); ?>">
                            <div class="input-group">
                                <input type="text" name="coupon" class="form-control" placeholder="Coupon Code" required
                                    autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Apply Coupon</button>
                                </div>
                            </div>
                        </form>

                        <h5 class="section-title position-relative text-uppercase my-3"><span class="bg-primary pr-3">Cart
                                Summary</span></h5>
                        <div class="bg-light p-30 mb-5">
                            <div class="border-bottom pb-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Subtotal</h6>
                                    <h6 style="margin-right: 15px;" id="subtotal">₹<?php echo e(\Cart::getSubTotal()); ?></h6>
                                </div>
                               <?php if(Session::has('discount')): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h6 class="mb-0">
                                                Coupon <span class="badge badge-pill badge-success">
                                                    <?php echo e(Session::get('applied_coupon_code')); ?>

                                                </span>
                                            </h6>
                                        </div>
                                
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 mr-2 text-danger">- ₹<?php echo e(Session::get('discount')); ?></h6>
                                            <form action="<?php echo e(route('couponcoderemove')); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-1" title="Remove Coupon">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endif; ?>


                            </div>
                            <div class="pt-2">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5>Total</h5>
                                    <?php
                                        $subtotal = \Cart::getSubTotal();
                                        $discount = Session::get('discount', 0);
                                        $total = $subtotal - $discount;
                                    ?>
                                    <h5 style="margin-right: 15px;" id="total">₹<?php echo e($total); ?></h5>
                                </div>
                                
                                <a class="btn btn-block btn-primary font-weight-bold my-3 <?php echo e(\Cart::isEmpty() ? 'disabled' : ''); ?>"
                                    href="<?php echo e(route('checkout')); ?>">
                                    Proceed To Checkout
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Cart End -->
    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script>
        function increaseCount(a, itemId) {
            var input = document.getElementById('quantity_' + itemId);
            var value = parseInt(input.value, 10);
            value = isNaN(value) ? 0 : value;
            value++;

            updateCart(itemId, value);
        }

        function decreaseCount(a, itemId) {
            var input = document.getElementById('quantity_' + itemId);
            var value = parseInt(input.value, 10);
            if (value > 1) {
                value--;

                updateCart(itemId, value);
            }
        }

        function updateCart(itemId, quantity) {
            let token = '<?php echo e(csrf_token()); ?>';

            fetch("<?php echo e(route('cart.update')); ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        id: itemId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let price = document.getElementById('quantity_' + itemId).getAttribute('data-price');
                        let total = price * quantity;
                        document.getElementById('quantity_' + itemId).value = quantity;
                        document.getElementById('total_' + itemId).innerText = total;

                        // Optionally update subtotal/total
                        if (data.cart_summary) {
                            document.getElementById('subtotal').innerText = `₹${data.cart_summary.subtotal}`;
                            document.getElementById('total').innerText = `₹${data.cart_summary.total}`;
                        }
                    }
                });
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/sparsvss/sparsh/resources/views/frontview/cart.blade.php ENDPATH**/ ?>