


<?php $__env->startSection('title', 'Login | GownEase'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center mt-4">
    <div class="col-md-6 col-lg-5">
        <div class="content-card p-4 p-md-5">
            <h2 class="brand mb-2">Welcome back</h2>
            <p class="text-secondary">Log in to your GownEase account.</p>

            <form action="<?php echo e(route('login.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email"
                           value="<?php echo e(old('email')); ?>"
                           class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control" required>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox"
                           name="remember" value="1" id="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <button class="btn btn-primary w-100">
                    Login
                </button>
            </form>

            <p class="mt-3 mb-0 text-center">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>">Register here</a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\SIA_FINALS\Gownease\resources\views/auth/login.blade.php ENDPATH**/ ?>