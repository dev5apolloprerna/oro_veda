<?php if(Session::has('success') || Session::has('error')): ?>
    <style>
        .sparsh-modal .modal-content {
            border-radius: 16px;
            background: #fff0f5;
            border: 3px solid #e91e63;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: bounceIn 0.5s ease-out;
            overflow: hidden;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            80% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .sparsh-modal .modal-header {
            background: linear-gradient(45deg, #e91e63, #f06292);
            color: white;
            text-align: center;
            justify-content: center;
            padding: 25px;
            border-bottom: none;
        }

        .sparsh-modal .modal-body {
            text-align: center;
            padding: 30px;
        }

        .sparsh-modal .modal-body i {
            font-size: 48px;
            color: <?php echo e(Session::has('success') ? '#4caf50' : '#f44336'); ?>;
            margin-bottom: 10px;
        }

        .sparsh-modal .modal-body h5 {
            font-weight: bold;
            color: #e91e63;
            margin-bottom: 10px;
        }

        .sparsh-modal .btn-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            font-size: 1.3rem;
            color: white;
            opacity: 1;
        }

        .sparsh-modal-logo {
            width: 100px;
            margin: 0 auto 10px;
        }
    </style>

    <div class="modal fade sparsh-modal" id="frontAlertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header position-relative">
                    <img src="<?php echo e(asset('assets/front/img/logo.png')); ?>" alt="Sparsh Logo" class="sparsh-modal-logo">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <i class="fa <?php echo e(Session::has('success') ? 'fa-circle-check' : 'fa-circle-xmark'); ?>"></i>
                    <h5><?php echo e(Session::has('success') ? 'Success!' : 'Oops!'); ?></h5>
                    <p><?php echo e(session('success') ?? session('error')); ?></p>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = new bootstrap.Modal(document.getElementById('frontAlertModal'));
            modal.show();
            setTimeout(() => modal.hide(), 4000); // Auto-hide after 4s
        });
    </script>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\oro_veda\resources\views/common/frontmodalalert.blade.php ENDPATH**/ ?>